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

        $candidates = [
            $this->contentDir . '/pages' . $path . '.php',
            $this->contentDir . '/pages' . $path . '/index.php',
            $this->contentDir . '/posts' . $path . '.php',
        ];

        if ($path === '/') {
            array_unshift($candidates, $this->contentDir . '/pages/index.php');
        }

        foreach ($candidates as $file) {
            if (file_exists($file)) {
                return $this->phpParser->parseFile($file, $slug);
            }
        }

        return null;
    }

    public function all(string $type = 'pages'): array
    {
        $dir   = $this->contentDir . '/' . $type;
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

            $relative = str_replace($dir, '', $file->getPathname());
            $slug     = trim(str_replace(['\\', '/index.php', '.php'], ['/', '', ''], $relative), '/');
            $path     = '/' . $slug;

            $content = $this->find($path);
            if ($content !== null) {
                $items[] = $content;
            }
        }

        return $items;
    }
}
