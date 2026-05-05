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

    /**
     * Render a template file with the given data.
     * Templates live in /templates/{name}.php
     */
    public function render(string $template, array $data = []): string
    {
        $file = $this->templateDir . '/' . $template . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException("Template not found: {$template}");
        }

        // Always inject $renderer so partials are callable from any template
        $data += ['renderer' => $this];

        // Extract data into local scope, then buffer output
        extract($data, EXTR_SKIP);

        // $layout / $pageTitle may be set by the template itself
        $layout    = null;
        $pageTitle = '';

        ob_start();
        require $file;
        $slot = ob_get_clean();

        if ($layout !== null) {
            return $this->render('layouts/' . $layout, [
                'slot'      => $slot,
                'pageTitle' => $pageTitle,
            ]);
        }

        return $slot;
    }

    /**
     * Render a partial from /templates/partials/{name}.php
     */
    public function partial(string $name, array $data = []): string
    {
        return $this->render('partials/' . $name, $data);
    }

    /**
     * Render a template wrapped in a layout.
     * The layout receives $content (the inner rendered HTML).
     */
    public function renderWithLayout(string $layout, string $template, array $data = []): string
    {
        $inner = $this->render($template, $data);
        return $this->render('layouts/' . $layout, array_merge($data, ['content' => $inner]));
    }

    /**
     * Render the main navigation menu.
     * Simple, direct approach - reads content metadata but keeps rendering straightforward.
     */
    public function renderMenu(string $currentPath = ''): string
    {
        // We need access to the content repository to read menu metadata
        // For now, let's build this more dynamically
        $menuItems = $this->getMenuItems();
        
        $nav = '<nav class="site-nav">';
        $nav .= '<ul class="navbar">';
        
        foreach ($menuItems as $item) {
            $activeClass = ($currentPath === $item['path']) ? ' class="active"' : '';
            
            if (!empty($item['children'])) {
                // Dropdown menu
                $nav .= '<li class="dropdown">';
                $nav .= '<a href="' . htmlspecialchars($item['path']) . '" class="dropbtn">' . htmlspecialchars($item['title']) . ' ▼</a>';
                $nav .= '<div class="dropdown-content">';
                foreach ($item['children'] as $child) {
                    $nav .= '<a href="' . htmlspecialchars($child['path']) . '">' . htmlspecialchars($child['title']) . '</a>';
                }
                $nav .= '</div>';
                $nav .= '</li>';
            } else {
                // Regular menu item
                $nav .= '<li><a href="' . htmlspecialchars($item['path']) . '"' . $activeClass . '>' . htmlspecialchars($item['title']) . '</a></li>';
            }
        }
        
        $nav .= '</ul>';
        $nav .= '</nav>';
        
        return $nav;
    }
    
    /**
     * Get menu items from content metadata.
     * Simplified version that reads from filesystem but keeps logic minimal.
     */
    private function getMenuItems(): array
    {
        $contentDir = dirname($this->templateDir) . '/content';
        $menuItems = [];
        
        // Scan for content files with menu metadata
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($contentDir, \FilesystemIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            
            // Extract metadata
            $meta = $this->extractMeta($file->getPathname());
            $menuMeta = $meta['menu'] ?? null;
            
            if (is_array($menuMeta)) {
                $relativePath = str_replace($contentDir, '', $file->getPathname());
                $path = '/' . trim(str_replace(['\\', '/index.php', '.php'], ['/', '', ''], $relativePath), '/');
                if ($path === '/') $path = '/';
                
                $menuItems[] = [
                    'title' => $menuMeta['title'] ?? $meta['title'] ?? 'Untitled',
                    'path' => $path,
                    'order' => $menuMeta['order'] ?? 100,
                    'parent' => $menuMeta['parent'] ?? null,
                ];
            }
        }
        
        // Sort by order and build hierarchy
        usort($menuItems, fn($a, $b) => $a['order'] <=> $b['order']);
        
        return $this->buildMenuHierarchy($menuItems);
    }
    
    /**
     * Extract metadata from a PHP content file.
     */
    private function extractMeta(string $filePath): array
    {
        $meta = [];
        ob_start();
        require $filePath;
        ob_end_clean();
        return $meta;
    }
    
    /**
     * Build menu hierarchy from flat array.
     */
    private function buildMenuHierarchy(array $items): array
    {
        $hierarchy = [];
        $itemsByPath = [];
        
        // Index by path
        foreach ($items as $item) {
            $itemsByPath[$item['path']] = $item + ['children' => []];
        }
        
        // Build hierarchy
        foreach ($itemsByPath as $path => $item) {
            if ($item['parent']) {
                if (isset($itemsByPath[$item['parent']])) {
                    $itemsByPath[$item['parent']]['children'][] = $item;
                } else {
                    $hierarchy[] = $item; // Orphaned child becomes top-level
                }
            } else {
                $hierarchy[] = $item;
            }
        }
        
        return $hierarchy;
    }

    /**
     * Check if feature content exists.
     */
    private function hasFeatureContent(): bool
    {
        return is_dir(dirname($this->templateDir) . '/content/en/features');
    }
}
