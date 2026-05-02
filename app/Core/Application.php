<?php

declare(strict_types=1);

namespace Wordless\Core;

use Wordless\Http\Request;
use Wordless\Http\Response;
use Wordless\Routing\Router;

class Application
{
    private static ?Application $instance = null;

    public function __construct(
        private readonly Container $container
    ) {}

    public static function getInstance(): ?Application
    {
        return self::$instance;
    }

    public static function setInstance(Application $app): void
    {
        self::$instance = $app;
    }

    public function handle(Request $request): Response
    {
        /** @var Router $router */
        $router     = $this->container->get(Router::class);
        $middleware = $this->container->get('middleware.stack');

        $handler = $router->resolve($request);

        // Walk middleware stack (last in, first out wrapping)
        $stack = array_reverse($middleware);
        $core  = $handler;

        foreach ($stack as $middlewareClass) {
            $mw   = new $middlewareClass($core, $this->container);
            $core = $mw;
        }

        return $core->handle($request);
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}
