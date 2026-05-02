<?php

declare(strict_types=1);

namespace Wordless\Content\Parser;

use Wordless\Content\Content;

/**
 * Parses Markdown files with optional YAML-style front matter.
 *
 * Front matter format:
 * ---
 * title: My Page
 * date: 2026-01-01
 * ---
 */
class MarkdownParser implements ParserInterface
{
    public function parse(string $raw, string $slug): Content
    {
        [$meta, $body] = $this->extractFrontMatter($raw);

        $title = $meta['title'] ?? $this->titleFromSlug($slug);
        $html  = $this->parseMarkdown($body);

        return new Content(
            title: $title,
            body:  $html,
            slug:  $slug,
            meta:  $meta
        );
    }

    // -------------------------------------------------------------------------

    private function extractFrontMatter(string $raw): array
    {
        $meta = [];
        $body = $raw;

        if (str_starts_with(ltrim($raw), '---')) {
            $pattern = '/^---\s*\n(.*?)\n---\s*\n(.*)/s';
            if (preg_match($pattern, ltrim($raw), $matches)) {
                $meta = $this->parseYamlLite($matches[1]);
                $body = $matches[2];
            }
        }

        return [$meta, $body];
    }

    /**
     * Minimal YAML parser supporting key: value pairs only.
     */
    private function parseYamlLite(string $yaml): array
    {
        $result = [];

        foreach (explode("\n", $yaml) as $line) {
            if (str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $result[trim($key)] = trim($value);
            }
        }

        return $result;
    }

    /**
     * Converts Markdown to HTML (hand-rolled, no dependencies).
     */
    private function parseMarkdown(string $md): string
    {
        $lines  = explode("\n", $md);
        $html   = '';
        $inPara = false;
        $inUl   = false;
        $inOl   = false;
        $inCode = false;
        $codeBuf = '';

        foreach ($lines as $line) {
            // Fenced code blocks
            if (str_starts_with(trim($line), '```')) {
                if ($inCode) {
                    $html   .= '<pre><code>' . htmlspecialchars($codeBuf) . '</code></pre>' . "\n";
                    $codeBuf = '';
                    $inCode  = false;
                } else {
                    if ($inPara) { $html .= '</p>'; $inPara = false; }
                    if ($inUl)   { $html .= '</ul>'; $inUl = false; }
                    if ($inOl)   { $html .= '</ol>'; $inOl = false; }
                    $inCode = true;
                }
                continue;
            }

            if ($inCode) {
                $codeBuf .= $line . "\n";
                continue;
            }

            // Headings
            if (preg_match('/^(#{1,6})\s+(.+)$/', $line, $m)) {
                if ($inPara) { $html .= '</p>'; $inPara = false; }
                if ($inUl)   { $html .= '</ul>'; $inUl = false; }
                if ($inOl)   { $html .= '</ol>'; $inOl = false; }
                $level = strlen($m[1]);
                $html .= "<h{$level}>" . $this->parseInline($m[2]) . "</h{$level}>\n";
                continue;
            }

            // Horizontal rule
            if (preg_match('/^[-*_]{3,}$/', trim($line))) {
                if ($inPara) { $html .= '</p>'; $inPara = false; }
                $html .= "<hr>\n";
                continue;
            }

            // Unordered list
            if (preg_match('/^[\*\-\+]\s+(.+)$/', $line, $m)) {
                if ($inPara) { $html .= '</p>'; $inPara = false; }
                if ($inOl)   { $html .= '</ol>'; $inOl = false; }
                if (!$inUl)  { $html .= '<ul>'; $inUl = true; }
                $html .= '<li>' . $this->parseInline($m[1]) . "</li>\n";
                continue;
            }

            // Ordered list
            if (preg_match('/^\d+\.\s+(.+)$/', $line, $m)) {
                if ($inPara) { $html .= '</p>'; $inPara = false; }
                if ($inUl)   { $html .= '</ul>'; $inUl = false; }
                if (!$inOl)  { $html .= '<ol>'; $inOl = true; }
                $html .= '<li>' . $this->parseInline($m[1]) . "</li>\n";
                continue;
            }

            // Blockquote
            if (str_starts_with($line, '> ')) {
                if ($inPara) { $html .= '</p>'; $inPara = false; }
                if ($inUl)   { $html .= '</ul>'; $inUl = false; }
                if ($inOl)   { $html .= '</ol>'; $inOl = false; }
                $html .= '<blockquote><p>' . $this->parseInline(substr($line, 2)) . "</p></blockquote>\n";
                continue;
            }

            // Empty line
            if (trim($line) === '') {
                if ($inPara) { $html .= '</p>'; $inPara = false; }
                if ($inUl)   { $html .= '</ul>'; $inUl = false; }
                if ($inOl)   { $html .= '</ol>'; $inOl = false; }
                continue;
            }

            // Paragraph
            if ($inUl) { $html .= '</ul>'; $inUl = false; }
            if ($inOl) { $html .= '</ol>'; $inOl = false; }
            if (!$inPara) {
                $html  .= '<p>';
                $inPara = true;
            } else {
                $html .= ' ';
            }
            $html .= $this->parseInline($line);
        }

        if ($inPara) $html .= '</p>';
        if ($inUl)   $html .= '</ul>';
        if ($inOl)   $html .= '</ol>';
        if ($inCode) $html .= '<pre><code>' . htmlspecialchars($codeBuf) . '</code></pre>';

        return $html;
    }

    /**
     * Inline elements: bold, italic, code, links, images.
     */
    private function parseInline(string $text): string
    {
        // Images before links
        $text = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<img src="$2" alt="$1">', $text);
        // Links
        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $text);
        // Bold + italic
        $text = preg_replace('/\*\*\*(.+?)\*\*\*/', '<strong><em>$1</em></strong>', $text);
        // Bold
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__(.+?)__/', '<strong>$1</strong>', $text);
        // Italic
        $text = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.+?)_/', '<em>$1</em>', $text);
        // Inline code
        $text = preg_replace('/`(.+?)`/', '<code>$1</code>', $text);
        // Strikethrough
        $text = preg_replace('/~~(.+?)~~/', '<del>$1</del>', $text);

        return $text;
    }

    private function titleFromSlug(string $slug): string
    {
        return ucwords(str_replace(['-', '_'], ' ', basename($slug) ?: 'Home'));
    }
}
