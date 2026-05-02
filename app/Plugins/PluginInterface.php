<?php

declare(strict_types=1);

namespace Wordless\Plugins;

use Wordless\Core\Container;

interface PluginInterface
{
    public function register(Container $container): void;
}
