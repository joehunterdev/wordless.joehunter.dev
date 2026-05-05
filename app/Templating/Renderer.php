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
}
