<?php

declare(strict_types=1);

namespace Wordless\Content;

use Wordless\Content\Parser\PhpFileParser;

class FileContentRepository implements ContentRepositoryInterface
{
    private readonly string $contentDir;
    private readonly PhpFileParser $phpParser;

    public function __construct(string $contentDir)
    {
        $this->contentDir = rtrim($contentDir, '/\\');
        $this->phpParser  = new PhpFileParser();
    }

    public function find(string $path): ?Content
    {
        $path = '/' . trim($path, '/');
        $slug = trim($path, '/') ?: 'home';
        $root = $this->contentDir;

        $candidates = $path === '/'
            ? [$root . '/index.php']
            : [
                $root . $path . '.php',
                $root . $path . '/index.php',
            ];

        foreach ($candidates as $file) {
            if (file_exists($file)) {
                $inherited = $this->inheritedMeta($file);
                return $this->phpParser->parseFile($file, $slug, $inherited);
            }
        }

        return null;
    }

    /**
     * Walk up the directory tree from $filePath collecting $meta declared in
     * each ancestor folder's index.php, stopping at the content root.
     * Returns a single array merged outermost-first so closer ancestors win.
     */
    private function inheritedMeta(string $filePath): array
    {
        $contentRoot = realpath($this->contentDir);
        $dir         = dirname(realpath($filePath));
        $ancestors   = [];

        // Climb toward the root, collect index.php paths (skip own directory)
        while ($dir && $dir !== $contentRoot) {
            $index = $dir . DIRECTORY_SEPARATOR . 'index.php';
            if (file_exists($index) && $index !== realpath($filePath)) {
                $ancestors[] = $index;
            }
            $parent = dirname($dir);
            if ($parent === $dir) {
                break; // filesystem root guard
            }
            $dir = $parent;
        }

        if (empty($ancestors)) {
            return [];
        }

        // Reverse so outermost ancestor is merged first (innermost wins)
        $ancestors = array_reverse($ancestors);

        $merged = [];
        foreach ($ancestors as $indexFile) {
            // Extract only $meta — discard body output entirely
            $data = (static function (string $f): array {
                $meta = [];
                ob_start();
                require $f;
                ob_end_clean();
                return is_array($meta) ? $meta : [];
            })($indexFile);
            $merged = array_merge($merged, $data);
        }

        return $merged;
    }

    public function all(string $path = ''): array
    {
        $dir   = $path !== '' ? $this->contentDir . '/' . trim($path, '/') : $this->contentDir;
        $items = [];

        if (!is_dir($dir)) {
            return $items;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $relative = str_replace($this->contentDir, '', $file->getPathname());
            $slug     = trim(str_replace(['\\', '/index.php', '.php'], ['/', '', ''], $relative), '/');

            $content = $this->find('/' . $slug);
            if ($content !== null) {
                $items[] = $content;
            }
        }

        return $items;
    }
}
