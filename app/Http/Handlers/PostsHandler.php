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
        $resolver = new PostResolver(
            __DIR__ . '/../../../content/posts'
        );

        // ✅ THIS IS THE CRITICAL LINE
        $posts = $resolver->index();

        $view = new View('default');

        return new Response(
            $view->render('posts', [
                'title' => 'Posts',
                'posts' => $posts,
            ]),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }
}
