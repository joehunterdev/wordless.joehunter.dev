<?php

declare(strict_types=1);

require __DIR__ . '/../app/helpers.php';

spl_autoload_register(function (string $class): void {
    // Map namespace prefixes to base directories
    $prefixes = [
        'Wordless\\' => __DIR__ . '/../app/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
