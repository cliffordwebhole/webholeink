<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\Markdown;
use WebholeInk\Core\PageResolver;
use WebholeInk\Core\PostResolver;
use WebholeInk\Core\View;

final class PageHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $path = trim($request->path(), '/');
        $view = new View('default');

        /**
         * 1) Single posts: /posts/{slug}
         */
        if (str_starts_with($path, 'posts/')) {
            $slug = trim(substr($path, strlen('posts/')), '/');

            $postResolver = new PostResolver(WEBHOLEINK_ROOT . '/content/posts');
            $post = $postResolver->resolve($slug);

            if ($post === null) {
                return new Response(
                    $view->render('page', [
                        'title'       => '404',
                        'description' => '',
                        'canonical'   => 'https://webholeink.org/posts/' . $slug,
                        'content'     => '<h1>404 – Post not found</h1>',
                    ]),
                    404,
                    ['Content-Type' => 'text/html; charset=UTF-8']
                );
            }

            $meta = $post['meta'] ?? [];

            return new Response(
                $view->render('post', [
                    'title'       => (string)($meta['title'] ?? 'WebholeInk'),
                    'description' => (string)($meta['description'] ?? ''),
                    'canonical'   => 'https://webholeink.org/posts/' . $slug,
                    'date'        => (string)($meta['date'] ?? ''),
                    'content'     => (string)($post['content'] ?? ''),
                ]),
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        /**
         * 2) Pages: content/pages/{slug}.md (home maps to /)
         */
        $pageResolver = new PageResolver(WEBHOLEINK_ROOT . '/content');
        $page = $pageResolver->resolve($path);

        if ($page === null) {
            return new Response(
                $view->render('page', [
                    'title'       => '404',
                    'description' => '',
                    'canonical'   => 'https://webholeink.org' . $request->path(),
                    'content'     => '<h1>404 – Page not found</h1>',
                ]),
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $md = new Markdown();
        $parsed = $md->parseWithFrontMatter((string)($page['body'] ?? ''));

        // PageResolver already parsed front matter; prefer it.
        $meta = (array)($page['meta'] ?? []);
        $slug = (string)($page['slug'] ?? 'home');

        $canonicalPath = ($slug === 'home') ? '/' : '/' . $slug;

        return new Response(
            $view->render('page', [
                'title'       => (string)($meta['title'] ?? ucfirst($slug)),
                'description' => (string)($meta['description'] ?? ''),
                'canonical'   => 'https://webholeink.org' . $canonicalPath,
                'content'     => (string)($parsed['html'] ?? ''),
            ]),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }
}
