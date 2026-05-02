<?php

declare(strict_types=1);

namespace Wordless\Core;

use Closure;

class Container implements ContainerInterface
{
    /** @var array<string, Closure|object> */
    private array $bindings = [];

    /** @var array<string, object> */
    private array $instances = [];

    public function bind(string $id, Closure $factory): void
    {
        $this->bindings[$id] = $factory;
    }

    public function singleton(string $id, Closure $factory): void
    {
        $this->bind($id, function () use ($id, $factory) {
            if (!isset($this->instances[$id])) {
                $this->instances[$id] = $factory($this);
            }
            return $this->instances[$id];
        });
    }

    public function instance(string $id, mixed $value): void
    {
        $this->instances[$id] = $value;
        $this->bind($id, fn() => $value);
    }

    public function get(string $id): mixed
    {
        if (isset($this->bindings[$id])) {
            return ($this->bindings[$id])($this);
        }

        throw new \RuntimeException("No binding found for: {$id}");
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }
}
