<?php

declare(strict_types=1);

namespace Wordless\Cache;

class Cache
{
    private readonly string $cacheDir;
    private readonly int    $ttl;

    public function __construct(string $cacheDir, int $ttl = 3600)
    {
        $this->cacheDir = rtrim($cacheDir, '/\\');
        $this->ttl      = $ttl;
    }

    public function get(string $key): ?string
    {
        $file = $this->path($key);

        if (!file_exists($file)) {
            return null;
        }

        $data = unserialize(file_get_contents($file));

        if ($data['expires'] < time()) {
            unlink($file);
            return null;
        }

        return $data['value'];
    }

    public function set(string $key, string $value, ?int $ttl = null): void
    {
        $file = $this->path($key);

        file_put_contents($file, serialize([
            'expires' => time() + ($ttl ?? $this->ttl),
            'value'   => $value,
        ]), LOCK_EX);
    }

    public function remember(string $key, callable $callback, ?int $ttl = null): string
    {
        $cached = $this->get($key);

        if ($cached !== null) {
            return $cached;
        }

        $value = $callback();
        $this->set($key, $value, $ttl);

        return $value;
    }

    public function forget(string $key): void
    {
        $file = $this->path($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function flush(): void
    {
        foreach (glob($this->cacheDir . '/*.cache') ?: [] as $file) {
            unlink($file);
        }
    }

    private function path(string $key): string
    {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}
