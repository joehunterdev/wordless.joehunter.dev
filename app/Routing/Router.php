<?php

declare(strict_types=1);

namespace Wordless\Routing;

use Wordless\Core\Container;
use Wordless\Http\HandlerInterface;
use Wordless\Http\Request;
use Wordless\Http\Response;
use Wordless\Http\Controllers\ContentController;

class Router
{
    /** @var array<string, class-string<HandlerInterface>> */
    private array $routes = [];

    public function __construct(private readonly Container $container) {}

    public function add(string $path, string $controllerClass): void
    {
        $this->routes['/' . trim($path, '/')] = $controllerClass;
    }

    public function resolve(Request $request): HandlerInterface
    {
        $path = $request->getPath();

        // Explicit static routes first
        if (isset($this->routes[$path])) {
            $class = $this->routes[$path];
            return new $class($this->container);
        }

        // File-based routing: path maps directly to directory structure
        return new ContentController($this->container, $path);
    }

}
