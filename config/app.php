<?php

declare(strict_types=1);

return [
    'name'        => 'Wordless CMS',
    'base_path'   => dirname(__DIR__),
    'content_dir' => dirname(__DIR__) . '/content',
    'cache_dir'   => dirname(__DIR__) . '/storage/cache',
    'log_dir'     => dirname(__DIR__) . '/storage/logs',
    'template_dir'=> dirname(__DIR__) . '/templates',
    'debug'       => true,
    'cache_ttl'   => 3600, // seconds
];
