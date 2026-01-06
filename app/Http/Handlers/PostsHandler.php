<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PostResolver;
use WebholeInk\Core\View;

final class PostsHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $view = new View('default');

        $resolver = new PostResolver(
            __DIR__ . '/../../../content/posts'
        );

        $posts = $resolver->index();

        return new Response(
            $view->render('posts', [
                'title'       => 'Posts',
                'description' => 'Published articles from WebholeInk',
                'posts'       => $posts,
            ]),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }
}
