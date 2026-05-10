<?php

declare(strict_types=1);

namespace Wordless\Content;

use Wordless\Content\Parser\PhpFileParser;

class FileContentRepository implements ContentRepositoryInterface
{
    private readonly string $contentDir;
    private readonly PhpFileParser $phpParser;
    private readonly array $defaultMeta;
    private readonly array $locales;
    private readonly string $defaultLocale;

    public function __construct(
        string $contentDir,
        array  $defaultMeta    = [],
        array  $locales        = ['en'],
        string $defaultLocale  = 'en'
    ) {
        $this->contentDir    = rtrim($contentDir, '/\\');
        $this->phpParser     = new PhpFileParser();
        $this->defaultMeta   = $defaultMeta;
        $this->locales       = $locales;
        $this->defaultLocale = $defaultLocale;
    }

    public function find(string $path, ?object $renderer = null, string $currentPath = ''): ?Content
    {
        $path = $this->sanitizePath($path);
        $root = $this->contentDir;

        if ($path === '/') {
            $candidates = [$root . '/index.php'];
        } else {
            $candidates = [
                $root . $path . '.php',
                $root . $path . '/index.php',
            ];

            if (!$this->hasLocalePrefix($path)) {
                $candidates[] = $root . '/' . $this->defaultLocale . $path . '.php';
                $candidates[] = $root . '/' . $this->defaultLocale . $path . '/index.php';
            }
        }

        foreach ($candidates as $file) {
            if (file_exists($file)) {
                $inherited = array_merge($this->defaultMeta, $this->inheritedMeta($file));
                return $this->phpParser->parseFile($file, $path, $inherited, $renderer, $currentPath);
            }
        }

        return null;
    }

    private function inheritedMeta(string $filePath): array
    {
        $contentRoot = realpath($this->contentDir);
        $dir         = dirname(realpath($filePath));
        $ancestors   = [];

        while ($dir && $dir !== $contentRoot) {
            $index = $dir . DIRECTORY_SEPARATOR . 'index.php';
            if (file_exists($index) && $index !== realpath($filePath)) {
                $ancestors[] = $index;
            }
            $parent = dirname($dir);
            if ($parent === $dir) {
                break;
            }
            $dir = $parent;
        }

        if (empty($ancestors)) {
            return [];
        }

        $ancestors = array_reverse($ancestors);

        $merged = [];
        foreach ($ancestors as $indexFile) {
            $data = $this->parseMeta($indexFile);
            if (isset($data['keywords']) && isset($merged['keywords'])) {
                $data['keywords'] = array_values(array_unique(array_merge($merged['keywords'], (array) $data['keywords'])));
            }
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

            // Skip redirect shims — files that call header() with a Location
            $source = file_get_contents($file->getPathname());
            if ($source !== false && str_contains($source, 'header(') && str_contains($source, 'Location')) {
                continue;
            }

            $relative = relative_path($file->getPathname(), $this->contentDir);
            $slug     = trim(str_replace(['/index.php', '.php'], ['', ''], $relative), '/');

            $content = $this->find('/' . $slug);
            if ($content !== null) {
                $items[] = $content;
            }
        }

        return $items;
    }

    private function parseMeta(string $filePath): array
    {
        return PhpFileParser::parseMeta($filePath);
    }

    private function hasLocalePrefix(string $path): bool
    {
        $nonDefault = array_values(array_filter($this->locales, fn($l) => $l !== $this->defaultLocale));
        return locale_from_path($path, $nonDefault) !== null;
    }

    private function sanitizePath(string $path): string
    {
        $path = str_replace(["\0", '..'], '', $path);
        return '/' . trim(preg_replace('#/+#', '/', $path), '/');
    }
}
