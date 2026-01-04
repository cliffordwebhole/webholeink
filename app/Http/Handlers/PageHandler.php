<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PageResolver;
use WebholeInk\Core\PostResolver;
use WebholeInk\Core\Markdown;
use WebholeInk\Core\View;

final class PageHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $path = trim($request->path(), '/');
        $view = new View('default');

        /**
         * -------------------------------------------------
         * 1. Single blog posts: /posts/{slug}
         * -------------------------------------------------
         */
        if (str_starts_with($path, 'posts/')) {
            $slug = substr($path, strlen('posts/'));

            $postResolver = new PostResolver(
                __DIR__ . '/../../../content/posts'
            );

            $post = $postResolver->resolve($slug);

            if ($post === null) {
                return new Response('<h1>404 – Post not found</h1>', 404);
            }

            return new Response(
                $view->render('post', [
                    'content'     => $post['content'],
                    'title'       => $post['meta']['title'] ?? 'WebholeInk',
                    'description' => $post['meta']['description'] ?? '',
                    'date'        => $post['meta']['date'] ?? '',
                ])
            );
        }

        /**
         * -------------------------------------------------
         * 2. Pages: content/pages/*.md
         * -------------------------------------------------
         */
        $pageResolver = new PageResolver(
            __DIR__ . '/../../../content'
        );

        $page = $pageResolver->resolve($path);

        if ($page === null) {
            return new Response('<h1>404 – Page not found</h1>', 404);
        }

        // 🔑 THIS WAS MISSING
        $markdown = new Markdown();
        $parsed   = $markdown->parseWithFrontMatter($page['body']);

        return new Response(
            $view->render('page', [
                'content'     => $parsed['html'],   // ← parsed HTML
                'title'       => $page['meta']['title'] ?? 'WebholeInk',
                'description' => $page['meta']['description'] ?? '',
                'slug'        => $page['slug'],
            ])
        );
    }
}
