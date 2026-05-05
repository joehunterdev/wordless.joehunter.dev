<?php

declare(strict_types=1);

if (!function_exists('e')) {
    /**
     * HTML-escape a value for safe output in templates.
     * Handles null/int/float gracefully.
     *
     * Usage: <?= e($value) ?>
     */
    function e(mixed $value, string $encoding = 'UTF-8'): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, $encoding);
    }
}
