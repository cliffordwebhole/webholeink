<?php

declare(strict_types=1);

define('WEBHOLEINK_ENTRY', true);

require __DIR__ . '/../app/autoload.php';
require __DIR__ . '/../app/bootstrap.php';

use WebholeInk\Core\PostResolver;
use WebholeInk\Core\View;
use WebholeInk\Http\Request;
use WebholeInk\Http\Router;

use WebholeInk\Http\Handlers\DocsHandler;
use WebholeInk\Http\Handlers\FeedHandler;
use WebholeInk\Http\Handlers\FeedJsonHandler;
use WebholeInk\Http\Handlers\HomeHandler;
use WebholeInk\Http\Handlers\PageHandler;
use WebholeInk\Http\Handlers\PostsHandler;
use WebholeInk\Http\Handlers\SearchHandler;
use WebholeInk\Http\Handlers\SitemapHandler;

$request = Request::fromGlobals();
$router  = new Router();

/**
 * Docs (must come before fallback)
 */
$router->get('/docs',  new DocsHandler());
$router->get('/docs/', new DocsHandler());
// $router->get('/docs/{slug}', new DocHandler()); // enable when router supports slug routing

/**
 * Core routes
 */
$router->get('/', new HomeHandler());
$router->get('/posts', new PostsHandler());

$router->get('/sitemap.xml', new SitemapHandler());
$router->get('/feed.xml', new FeedHandler());

$router->get('/feed.json', new FeedJsonHandler(
    new PostResolver(WEBHOLEINK_ROOT . '/content/posts')
));

$router->get('/search', new SearchHandler(
    new View('default')
));

/**
 * Fallback pages (keep last)
 */
$router->fallback(new PageHandler());

$response = $router->dispatch($request);
$response->send();
