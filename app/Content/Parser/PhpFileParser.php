<?php

declare(strict_types=1);

namespace Wordless\Content\Parser;

use Wordless\Content\Content;

/**
 * Loads a .php content file, captures its output as the body,
 * and reads an optional $meta array defined at the top of the file.
 *
 * Content file format:
 *
 *   <?php $meta = ['title' => 'My Page', 'date' => '2026-01-01']; ?>
 *
 *   <h1>My Page</h1>
 *   <p>Content here with full PHP: <?= strtoupper('hello') ?></p>
 */
class PhpFileParser implements ParserInterface
{
    public function parseFile(string $filePath, string $slug, array $inheritedMeta = [], ?object $renderer = null, string $currentPath = ''): Content
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Content file not found: {$filePath}");
        }

        $meta = [];
        $body = $this->capture($filePath, $meta, $renderer, $currentPath);

        $meta  = array_merge($inheritedMeta, $meta);
        $title = $meta['title'] ?? $this->titleFromSlug($slug);

        return new Content(
            title: $title,
            body:  $body,
            slug:  $slug,
            meta:  $meta
        );
    }

    private function capture(string $filePath, array &$meta, ?object $renderer, string $currentPath): string
    {
        $loader = static function (string $_file, ?object $renderer, string $currentPath): array {
            $meta = [];
            ob_start();
            require $_file;
            $body = ob_get_clean();
            return [$body, $meta];
        };

        [$body, $meta] = $loader($filePath, $renderer, $currentPath);

        return $body;
    }

    private function titleFromSlug(string $slug): string
    {
        return ucwords(str_replace(['-', '_'], ' ', basename($slug) ?: 'Home'));
    }

    /**
     * Extract only the $meta array from a PHP content file using static regex analysis.
     * Safer than require+ob_start: body code never executes.
     */
    public static function parseMeta(string $filePath): array
    {
        $source = file_get_contents($filePath);
        if ($source === false) {
            return [];
        }
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
}
