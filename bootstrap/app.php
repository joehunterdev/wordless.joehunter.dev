<?php

declare(strict_types=1);

require __DIR__ . '/autoload.php';

use Wordless\Cache\Cache;
use Wordless\Content\ContentRepositoryInterface;
use Wordless\Content\FileContentRepository;
use Wordless\Core\Application;
use Wordless\Core\Container;
use Wordless\Events\EventDispatcher;
use Wordless\Http\Middleware\CacheMiddleware;
use Wordless\Http\Middleware\ErrorMiddleware;
use Wordless\Plugins\PluginManager;
use Wordless\Routing\Router;
use Wordless\Templating\Renderer;

$config = require __DIR__ . '/../config/app.php';

$container = new Container();

// Config
$container->bind('config', fn() => $config);

// Core services
$container->singleton(Cache::class, fn() =>
    new Cache($config['cache_dir'], $config['cache_ttl'])
);

$container->singleton(Renderer::class, fn() =>
    new Renderer($config['template_dir'])
);

$container->singleton(ContentRepositoryInterface::class, fn() =>
    new FileContentRepository($config['content_dir'])
);

$container->singleton(EventDispatcher::class, fn() =>
    new EventDispatcher()
);

$container->singleton(Router::class, fn(Container $c) =>
    new Router($c)
);

$container->singleton(PluginManager::class, fn(Container $c) =>
    new PluginManager($c)
);

// Middleware stack (outermost first)
$container->bind('middleware.stack', fn() => [
    ErrorMiddleware::class,
    CacheMiddleware::class,
]);

// Boot plugins
/** @var PluginManager $plugins */
$plugins = $container->get(PluginManager::class);
$plugins->boot();

$app = new Application($container);
Application::setInstance($app);

return $app;
