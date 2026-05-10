<?php

declare(strict_types=1);

namespace Wordless\Templating;

class Renderer
{
    private readonly string $templateDir;

    public function __construct(string $templateDir)
    {
        $this->templateDir = rtrim($templateDir, '/\\');
    }

    public function render(string $template, array $data = []): string
    {
        $templateFile = $this->templateDir . '/' . $template . '.php';

        if (!file_exists($templateFile)) {
            throw new \RuntimeException("Template not found: {$template}");
        }

        $data['renderer'] = $this;

        extract($data, EXTR_SKIP);

        $layout    = null;
        $pageTitle = '';

        ob_start();
        require $templateFile;
        $slot = ob_get_clean();

        if ($layout !== null) {
            return $this->render('layouts/' . $layout, [
                'slot'      => $slot,
                'pageTitle' => $pageTitle,
                'renderer'  => $this,
            ] + $data);
        }

        return $slot;
    }

    public function partial(string $name, array $data = []): string
    {
        return $this->render('partials/' . $name, $data);
    }

    public function renderWithLayout(string $layout, string $template, array $data = []): string
    {
        $inner = $this->render($template, $data);
        return $this->render('layouts/' . $layout, array_merge($data, ['content' => $inner]));
    }

    public function renderMenu(string $currentPath = ''): string
    {
        $menuItems = $this->getMenuItems($currentPath);

        $nav = '<nav class="site-nav"><ul class="navbar">';

        foreach ($menuItems as $item) {
            $activeAttr = ($currentPath === $item['path']) ? ' class="active"' : '';

            if (!empty($item['children'])) {
                $nav .= '<li class="dropdown">';
                $nav .= '<a href="' . e($item['path']) . '" class="dropbtn">' . e($item['title']) . ' &#9660;</a>';
                $nav .= '<div class="dropdown-content">';
                foreach ($item['children'] as $child) {
                    $nav .= '<a href="' . e($child['path']) . '">' . e($child['title']) . '</a>';
                }
                $nav .= '</div></li>';
            } else {
                $nav .= '<li><a href="' . e($item['path']) . '"' . $activeAttr . '>' . e($item['title']) . '</a></li>';
            }
        }

        $nav .= '</ul></nav>';

        return $nav;
    }

    private function getMenuItems(string $currentPath): array
    {
        $contentDir    = dirname($this->templateDir) . '/content';
        $config        = \Wordless\Config\Config::getInstance();
        $locales       = $config->get('locales', ['en']);
        $defaultLocale = $config->get('default_locale', 'en');

        // Detect the active locale from the request path
        $activeLocale = $defaultLocale;
        foreach ($locales as $locale) {
            if ($locale !== $defaultLocale && (
                str_starts_with($currentPath, '/' . $locale . '/') ||
                $currentPath === '/' . $locale
            )) {
                $activeLocale = $locale;
                break;
            }
        }

        $localeDir = $contentDir . DIRECTORY_SEPARATOR . $activeLocale;
        if (!is_dir($localeDir)) {
            return [];
        }

        $menuItems = [];
        $iterator  = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($localeDir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $meta     = $this->extractMeta($file->getPathname());
            $menuMeta = $meta['menu'] ?? null;

            if (!is_array($menuMeta)) {
                continue;
            }

            $relative = str_replace(
                '\\',
                '/',
                ltrim(str_replace($localeDir, '', $file->getPathname()), DIRECTORY_SEPARATOR)
            );

            if ($relative === 'index.php') {
                $slug = '';
            } else {
                $slug = trim(str_replace(['/index.php', '.php'], ['', ''], '/' . $relative), '/');
            }

            if ($slug === '') {
                $path = '/' . $activeLocale;
            } elseif ($activeLocale === $defaultLocale) {
                $path = '/' . $slug;
            } else {
                $path = '/' . $activeLocale . '/' . $slug;
            }

            $menuItems[] = [
                'title'    => $menuMeta['title'] ?? $meta['title'] ?? 'Untitled',
                'path'     => $path,
                'order'    => $menuMeta['order'] ?? 100,
                'parent'   => $menuMeta['parent'] ?? null,
                'children' => [],
            ];
        }

        usort($menuItems, fn($a, $b) => $a['order'] <=> $b['order']);

        return $this->buildMenuHierarchy($menuItems);
    }

    private function extractMeta(string $filePath): array
    {
        $source = file_get_contents($filePath);
        if ($source === false) {
            return [];
        }

        // Match the first $meta = [...]; — terminate at ]; so nested arrays don't confuse the match.
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

    private function buildMenuHierarchy(array $items): array
    {
        // Sort shallowest paths first so parents are indexed before children
        usort($items, fn($a, $b) => substr_count($a['path'], '/') <=> substr_count($b['path'], '/'));

        $config      = \Wordless\Config\Config::getInstance();
        $localeRoots = array_map(fn($l) => '/' . $l, $config->get('locales', ['en']));

        $byPath   = [];
        $children = [];

        foreach ($items as $item) {
            $byPath[$item['path']] = $item;
        }

        foreach ($byPath as $path => $item) {
            // Walk up path segments to find the nearest ancestor menu item.
            // Skip locale root paths (e.g. /es) — they provide locale context,
            // not section structure, so pages like /es/acerca stay top-level.
            $parts = explode('/', trim($path, '/'));
            array_pop($parts);

            while (!empty($parts)) {
                $ancestor = '/' . implode('/', $parts);
                if (isset($byPath[$ancestor]) && !in_array($ancestor, $localeRoots, true)) {
                    $byPath[$ancestor]['children'][] = $item;
                    $children[$path] = true;
                    break;
                }
                array_pop($parts);
            }
        }

        $hierarchy = [];
        foreach ($byPath as $path => $item) {
            if (!isset($children[$path])) {
                $hierarchy[] = $item;
            }
        }

        return $hierarchy;
    }
}
