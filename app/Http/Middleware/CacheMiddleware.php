<?php

declare(strict_types=1);

namespace Wordless\Http\Middleware;

use Wordless\Core\Container;
use Wordless\Cache\Cache;
use Wordless\Http\HandlerInterface;
use Wordless\Http\Request;
use Wordless\Http\Response;

class CacheMiddleware implements HandlerInterface
{
    public function __construct(
        private readonly HandlerInterface $next,
        private readonly Container        $container
    ) {}

    public function handle(Request $request): Response
    {
        // Check if caching is enabled in config
        $config = $this->container->get('config');
        if (isset($config['cache_enabled']) && $config['cache_enabled'] === false) {
            return $this->next->handle($request);
        }

        // Only cache GET requests
        if ($request->getMethod() !== 'GET') {
            return $this->next->handle($request);
        }

        /** @var Cache $cache */
        $cache = $this->container->get(Cache::class);
        $key   = 'page_' . md5($request->getPath());

        $cached = $cache->get($key);
        if ($cached !== null) {
            return Response::html($cached);
        }

        $response = $this->next->handle($request);

        if ($response->getStatusCode() === 200) {
            $cache->set($key, $response->getBody());
        }

        return $response;
    }
}
