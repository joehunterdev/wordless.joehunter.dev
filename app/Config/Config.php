<?php

declare(strict_types=1);

namespace Wordless\Config;

class Config
{
    private static ?Config $instance = null;
    private array $config = [];

    private function __construct()
    {
        $this->loadDefaults();
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Merge a user config array over the defaults.
     * Only call this once, during bootstrap.
     */
    public static function load(array $overrides): Config
    {
        $instance = self::getInstance();
        $instance->config = array_replace_recursive($instance->config, $overrides);
        return $instance;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->config;
    }

    // -------------------------------------------------------------------------

    private function loadDefaults(): void
    {
        $base = dirname(__DIR__, 2); // project root from app/Config/

        $this->config = [
            'name'         => 'Wordless',
            'base_path'    => $base,
            'content_dir'  => $base . '/content',
            'cache_dir'    => $base . '/storage/cache',
            'log_dir'      => $base . '/storage/logs',
            'template_dir' => $base . '/templates',
            'debug'        => false,
            'cache_ttl'    => 3600,
            'locales'        => ['en'],
            'default_locale' => 'en',
        ];
    }
}
