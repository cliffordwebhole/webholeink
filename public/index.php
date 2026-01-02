<?php

declare(strict_types=1);

define('WEBHOLEINK_ENTRY', true);

require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/../app/autoload.php';

use WebholeInk\Http\Request;
use WebholeInk\Http\Router;
use WebholeInk\Http\Handlers\HomeHandler;
use WebholeInk\Http\Handlers\PageHandler;

$request = Request::fromGlobals();

$router = new Router();
$router->get('/', new HomeHandler());
$router->fallback(new PageHandler());

$response = $router->dispatch($request);
$response->send();
