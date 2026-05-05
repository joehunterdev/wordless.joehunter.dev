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
    public function parseFile(string $filePath, string $slug, array $inheritedMeta = []): Content
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Content file not found: {$filePath}");
        }

        // Isolate scope — only $meta leaks out intentionally
        $meta = [];
        $body = $this->capture($filePath, $meta);

        // Page meta wins over inherited meta
        $meta  = array_merge($inheritedMeta, $meta);
        $title = $meta['title'] ?? $this->titleFromSlug($slug);

        return new Content(
            title: $title,
            body:  $body,
            slug:  $slug,
            meta:  $meta
        );
    }

    private function capture(string $filePath, array &$meta): string
    {
        // Wrap in a static closure to contain scope.
        // The file may define $meta — we extract it via extract + compact trick.
        $loader = static function (string $_file): array {
            $meta = [];
            ob_start();
            require $_file;
            $body = ob_get_clean();
            return [$body, $meta];
        };

        [$body, $meta] = $loader($filePath);

        return $body;
    }

    private function titleFromSlug(string $slug): string
    {
        return ucwords(str_replace(['-', '_'], ' ', basename($slug) ?: 'Home'));
    }
}
