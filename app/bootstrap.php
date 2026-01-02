<?php

declare(strict_types=1);

// Prevent direct access
if (php_sapi_name() !== 'cli' && !defined('WEBHOLEINK_ENTRY')) {
    http_response_code(403);
    exit('Forbidden');
}

// Base paths
define('WEBHOLEINK_ROOT', dirname(__DIR__));
define('WEBHOLEINK_APP', WEBHOLEINK_ROOT . '/app');
define('WEBHOLEINK_CONFIG', WEBHOLEINK_ROOT . '/config');
define('WEBHOLEINK_CONTENT', WEBHOLEINK_ROOT . '/content');
define('WEBHOLEINK_PUBLIC', WEBHOLEINK_ROOT . '/public');

// Autoloader (single source of truth)
require WEBHOLEINK_APP . '/autoload.php';
