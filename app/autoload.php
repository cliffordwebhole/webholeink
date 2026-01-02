<?php

declare(strict_types=1);

/**
 * WebholeInk Autoloader
 */

// Core autoload (your classes)
spl_autoload_register(function (string $class): void {
    $prefix = 'WebholeInk\\';
    $baseDir = __DIR__ . '/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

/**
 * Third-party libraries
 */
require_once __DIR__ . '/vendor/Parsedown/Parsedown.php';
