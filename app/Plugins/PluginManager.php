<?php

declare(strict_types=1);

namespace Wordless\Plugins;

use Wordless\Core\Container;

class PluginManager
{
    /** @var PluginInterface[] */
    private array $plugins = [];

    public function __construct(private readonly Container $container) {}

    public function register(PluginInterface $plugin): void
    {
        $this->plugins[] = $plugin;
    }

    public function boot(): void
    {
        foreach ($this->plugins as $plugin) {
            $plugin->register($this->container);
        }
    }
}
