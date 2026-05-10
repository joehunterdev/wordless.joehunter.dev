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

if (!function_exists('cfg')) {
    /**
     * Retrieve a config value by dot-notation key.
     * Reads from the Config singleton loaded during bootstrap.
     *
     * Usage: <?= cfg('meta.site_url') ?>
     *        <?= cfg('name') ?>
     */
    function cfg(string $key, mixed $default = null): mixed
    {
        $config = \Wordless\Config\Config::getInstance()->all();

        if (str_contains($key, '.')) {
            $parts = explode('.', $key);
            $value = $config;
            foreach ($parts as $part) {
                if (!is_array($value) || !array_key_exists($part, $value)) {
                    return $default;
                }
                $value = $value[$part];
            }
            return $value;
        }

        return $config[$key] ?? $default;
    }
}

if (!function_exists('img')) {
    /**
     * Return the public URL for an image asset.
     * Looks in /public/assets/img/ and appends the first matching extension.
     *
     * Usage: <?= img('logo') ?>          → /assets/img/logo.png
     *        <?= img('logo-trim.png') ?>  → /assets/img/logo-trim.png
     */
    function img(string $name, string $default = ''): string
    {
        // If extension already provided, use as-is
        if (pathinfo($name, PATHINFO_EXTENSION) !== '') {
            return '/assets/img/' . $name;
        }

        $base = dirname(__DIR__) . '/public/assets/img/';
        foreach (['png', 'svg', 'webp', 'jpg', 'jpeg', 'gif'] as $ext) {
            if (file_exists($base . $name . '.' . $ext)) {
                return '/assets/img/' . $name . '.' . $ext;
            }
        }

        return $default;
    }
}

if (!function_exists('normalize_path')) {
    function normalize_path(string $path): string
    {
        return '/' . trim(preg_replace('#/+#', '/', $path), '/');
    }
}

if (!function_exists('locale_from_path')) {
    /**
     * Return the locale segment from a URL path, or null if the first segment
     * isn't in the given $locales list.
     */
    function locale_from_path(string $path, array $locales): ?string
    {
        $segment = explode('/', ltrim($path, '/'))[0] ?? '';
        return in_array($segment, $locales, true) ? $segment : null;
    }
}

if (!function_exists('relative_path')) {
    /**
     * Convert an absolute filesystem path to a root-relative URL path.
     * Strips $base and converts DIRECTORY_SEPARATOR to forward slashes.
     */
    function relative_path(string $absolutePath, string $base): string
    {
        return '/' . ltrim(str_replace([$base, DIRECTORY_SEPARATOR], ['', '/'], $absolutePath), '/');
    }
}

if (!function_exists('route')) {
    /**
     * Return the URL path for a content slug.
     * Searches all locale subdirectories and the root content directory.
     *
     * Usage: <?= route('application-kernel') ?>
     *        <?= route('en/features/file-based-routing') ?>
     */
    function route(string $slug, string $locale = ''): string
    {
        $config        = \Wordless\Config\Config::getInstance();
        $contentDir    = $config->get('content_dir', dirname(__DIR__) . '/content');
        $locales       = $config->get('locales', ['en']);
        $defaultLocale = $config->get('default_locale', 'en');

        // Build raw path then normalise: strip trailing /index since index files
        // are the section root (content/es/index.php lives at /es, not /es/index).
        $build = static function (string $locale, string $slug, string $defaultLocale): string {
            if ($locale === $defaultLocale) {
                $path = '/' . ltrim($slug, '/');
            } else {
                $path = '/' . trim($locale . '/' . $slug, '/');
            }
            return preg_replace('#/index$#', '', $path) ?: '/';
        };

        // Explicit locale given — build directly
        if ($locale !== '') {
            return $build($locale, $slug, $defaultLocale);
        }

        // Search locale subdirectories for a matching file
        foreach ($locales as $loc) {
            if (file_exists($contentDir . '/' . $loc . '/' . $slug . '.php')) {
                return $build($loc, $slug, $defaultLocale);
            }
        }

        // Fall back to root content directory
        if (file_exists($contentDir . '/' . $slug . '.php')) {
            return '/' . ltrim($slug, '/');
        }

        // Slug not found — best-guess using explicit locale or default
        return $build($locale ?: $defaultLocale, $slug, $defaultLocale);
    }
}
