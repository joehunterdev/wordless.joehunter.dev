<?php

/**
 * Wordless — local configuration
 *
 * Only override what you need. All defaults are defined in app/Config/Config.php.
 *
 * Available keys and their defaults:
 *   'name'         => 'Wordless'
 *   'content_dir'  => {base}/content
 *   'cache_dir'    => {base}/storage/cache
 *   'log_dir'      => {base}/storage/logs
 *   'template_dir' => {base}/templates
 *   'debug'        => false
 *   'cache_ttl'    => 3600
 */
return [
    'debug'         => true,
    'cache_enabled' => false,  // Disable caching during development

    'meta' => [
        'lang'        => 'en',
        'locale'      => 'en-US',
        'dir'         => 'ltr',
        'description' => 'A minimal, dependency-free flat-file CMS built with modern PHP.',
        'keywords'    => ['wordless', 'cms', 'php', 'flat-file'],
        'site_url'    => 'https://wordless.joehunter.dev',
    ],

    'menu' => [
        'home_slugs' => ['home', 'index'],  // Which slugs count as "homepage"
    ],
];
