<?php

declare(strict_types=1);

namespace Wordless\Content;

use Wordless\Content\Parser\ParserInterface;
use Wordless\Content\Parser\MarkdownParser;

class FileContentRepository implements ContentRepositoryInterface
{
    private readonly string $contentDir;

    /** @var array<string, ParserInterface> */
    private array $parsers = [];

    public function __construct(string $contentDir)
    {
        $this->contentDir = rtrim($contentDir, '/\\');
        $this->parsers    = [
            'md'   => new MarkdownParser(),
        ];
    }

    public function find(string $path): ?Content
    {
        $path = '/' . trim($path, '/');

        // Try /pages first, then /posts
        $candidates = [
            $this->contentDir . '/pages' . $path . '.md',
            $this->contentDir . '/posts' . $path . '.md',
            $this->contentDir . '/pages' . $path . '/index.md',
        ];

        // Root maps to /pages/index.md
        if ($path === '/') {
            array_unshift($candidates, $this->contentDir . '/pages/index.md');
        }

        foreach ($candidates as $file) {
            if (file_exists($file)) {
                $ext    = pathinfo($file, PATHINFO_EXTENSION);
                $parser = $this->parsers[$ext] ?? null;

                if ($parser === null) {
                    continue;
                }

                $slug = trim($path, '/') ?: 'home';
                return $parser->parse(file_get_contents($file), $slug);
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
            if ($file->getExtension() !== 'md') {
                continue;
            }

            $relative = str_replace($dir, '', $file->getPathname());
            $slug     = trim(str_replace(['\\', '/index.md', '.md'], ['/', '', ''], $relative), '/');
            $path     = '/' . $slug;

            $content = $this->find($path);
            if ($content !== null) {
                $items[] = $content;
            }
        }

        return $items;
    }
}
