<?php

declare(strict_types=1);

namespace Wordless\Content;

use Wordless\Content\Parser\PhpFileParser;

class FileContentRepository implements ContentRepositoryInterface
{
    private readonly string $contentDir;
    private readonly PhpFileParser $phpParser;
<<<<<<< HEAD

    public function __construct(string $contentDir)
    {
        $this->contentDir = rtrim($contentDir, '/\\');
        $this->phpParser  = new PhpFileParser();
=======
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
>>>>>>> develop
    }

    public function find(string $path, ?object $renderer = null, string $currentPath = ''): ?Content
    {
        $path = '/' . trim($path, '/');
        $slug = trim($path, '/') ?: 'home';

<<<<<<< HEAD
        $candidates = [
            $this->contentDir . '/pages' . $path . '.php',
            $this->contentDir . '/pages' . $path . '/index.php',
            $this->contentDir . '/posts' . $path . '.php',
        ];

        if ($path === '/') {
            array_unshift($candidates, $this->contentDir . '/pages/index.php');
        }
=======
        if ($path === '/') {
            $candidates = [$root . '/index.php'];
        } else {
            $candidates = [
                $root . $path . '.php',
                $root . $path . '/index.php',
            ];
>>>>>>> develop

            // For paths with no non-default locale prefix, also try the default locale dir.
            // This makes content/en/about.php accessible at /about.
            if (!$this->hasLocalePrefix($path)) {
                $candidates[] = $root . '/' . $this->defaultLocale . $path . '.php';
                $candidates[] = $root . '/' . $this->defaultLocale . $path . '/index.php';
            }
        }

        foreach ($candidates as $file) {
            if (file_exists($file)) {
<<<<<<< HEAD
                return $this->phpParser->parseFile($file, $slug);
=======
                $inherited = array_merge($this->defaultMeta, $this->inheritedMeta($file));
                return $this->phpParser->parseFile($file, $slug, $inherited, $renderer, $currentPath);
>>>>>>> develop
            }
        }

        return null;
    }

    public function all(string $type = 'pages'): array
    {
<<<<<<< HEAD
        $dir   = $this->contentDir . '/' . $type;
=======
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
>>>>>>> develop
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

    /**
     * Extract only the $meta array from a PHP content file using static regex analysis.
     * Safer than require+ob_start: body code (including $renderer calls) never executes.
     */
    private function parseMeta(string $filePath): array
    {
        $source = file_get_contents($filePath);
        if ($source === false) {
            return [];
        }
        // Terminate at ]; so nested arrays inside $meta don't truncate the match.
        if (!preg_match('/\$meta\s*=\s*(\[[\s\S]*?\]);/s', $source, $matches)) {
            return [];
        }
        try {
            $meta = [];
            // phpcs:ignore
            eval('$meta = ' . $matches[1] . ';');
            return is_array($meta) ? $meta : [];
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Returns true if $path starts with a non-default locale prefix (e.g. /es or /es/).
     */
    private function hasLocalePrefix(string $path): bool
    {
        foreach ($this->locales as $locale) {
            if ($locale === $this->defaultLocale) {
                continue;
            }
            if (str_starts_with($path, '/' . $locale . '/') || $path === '/' . $locale) {
                return true;
            }
        }
        return false;
    }
}
