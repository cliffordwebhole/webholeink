<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PostResolver;
use WebholeInk\Core\View;

final class PostHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        // Strip "/posts/" from path
        $slug = trim(substr($request->path(), strlen('/posts/')), '/');

        $resolver = new PostResolver(
            __DIR__ . '/../../../content/posts'
        );

        $post = $resolver->resolve($slug);

        if ($post === null) {
            return new Response('<h1>404 – Post not found</h1>', 404);
        }

        $view = new View('default');

        return new Response(
            $view->render('post', [
                'post' => $post,
            ]),
            200
        );
    }
}
