<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PageResolver;
use WebholeInk\Core\Markdown;
use WebholeInk\Core\View;

final class HomeHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $view = new View('default');

        $resolver = new PageResolver(
            __DIR__ . '/../../../content'
        );

        // Home is just the "home" page
        $page = $resolver->resolve('home');

        if ($page === null) {
            return new Response('<h1>Home page not found</h1>', 404);
        }

        $markdown = new Markdown();
        $parsed   = $markdown->parseWithFrontMatter($page['body']);

        return new Response(
            $view->render('page', [
                'content'     => $parsed['html'],
                'title'       => $page['meta']['title'] ?? 'WebholeInk',
                'description' => $page['meta']['description'] ?? '',
                'slug'        => 'home',
            ])
        );
    }
}
