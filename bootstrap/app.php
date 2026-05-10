<?php

declare(strict_types=1);

require __DIR__ . '/autoload.php';

use Wordless\Cache\Cache;
use Wordless\Config\Config;
use Wordless\Content\ContentRepositoryInterface;
use Wordless\Content\FileContentRepository;
use Wordless\Content\PeerMap;
use Wordless\Core\Application;
use Wordless\Core\Container;
use Wordless\Events\EventDispatcher;
use Wordless\Http\Middleware\CacheMiddleware;
use Wordless\Http\Middleware\ErrorMiddleware;
use Wordless\Plugins\PluginManager;
use Wordless\Http\Controllers\SitemapController;
use Wordless\Routing\Router;
use Wordless\Templating\Renderer;

// Load defaults then merge user overrides
$overrides = file_exists(__DIR__ . '/../config.php')
    ? require __DIR__ . '/../config.php'
    : [];

$config = Config::load($overrides)->all();

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
    new FileContentRepository(
        $config['content_dir'],
        $config['meta']           ?? [],
        $config['locales']        ?? ['en'],
        $config['default_locale'] ?? 'en'
    )
);

$container->singleton(PeerMap::class, fn() =>
    PeerMap::load($config['base_path'] . '/storage/peers.php')
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

// Named routes
/** @var Router $router */
$router = $container->get(Router::class);
$router->add('/sitemap.xml', SitemapController::class);

$app = new Application($container);
Application::setInstance($app);

return $app;
