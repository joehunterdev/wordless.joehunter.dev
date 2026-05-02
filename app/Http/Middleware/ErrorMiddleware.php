<?php

declare(strict_types=1);

namespace Wordless\Http\Middleware;

use Wordless\Core\Container;
use Wordless\Http\HandlerInterface;
use Wordless\Http\Request;
use Wordless\Http\Response;
use Wordless\Templating\Renderer;

class ErrorMiddleware implements HandlerInterface
{
    public function __construct(
        private readonly HandlerInterface $next,
        private readonly Container        $container
    ) {}

    public function handle(Request $request): Response
    {
        try {
            return $this->next->handle($request);
        } catch (\Throwable $e) {
            /** @var array $config */
            $config = $this->container->get('config');

            if ($config['debug'] ?? false) {
                $body = '<h1>Error</h1><pre>' . htmlspecialchars($e->getMessage() . "\n\n" . $e->getTraceAsString()) . '</pre>';
            } else {
                /** @var Renderer $renderer */
                $renderer = $this->container->get(Renderer::class);
                $body     = $renderer->render('500', []);
            }

            return Response::error($body);
        }
    }
}
