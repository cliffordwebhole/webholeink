<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\Markdown;
use WebholeInk\Core\PageResolver;
use WebholeInk\Core\PostResolver;
use WebholeInk\Core\DocResolver;
use WebholeInk\Core\View;

final class PageHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $path = trim($request->path(), '/');
        $view = new View('default');

/*
 * -------------------------------------------------
 * Docs index: /docs
 * -------------------------------------------------
 */
if ($path === 'docs') {
    $resolver = new \WebholeInk\Core\DocResolver(WEBHOLEINK_ROOT . '/content/docs');
    $docs = $resolver->index();

    return new Response(
        $view->render('docs', [
            'title'       => 'Documentation',
            'description' => 'WebholeInk documentation',
            'canonical'   => 'https://webholeink.org/docs',
            'docs'        => $docs,
        ]),
        200,
        ['Content-Type' => 'text/html; charset=UTF-8']
    );
}

        /*
         * -------------------------------------------------
         * Docs: /docs/{slug}
         * -------------------------------------------------
         */
        if (str_starts_with($path, 'docs/')) {
            $slug = trim(substr($path, 5), '/');

            $resolver = new DocResolver(WEBHOLEINK_ROOT . '/content/docs');
            $doc = $resolver->resolve($slug);

            if ($doc === null) {
                return new Response(
                    $view->render('page', [
                        'title'       => '404',
                        'description' => '',
                        'canonical'   => 'https://webholeink.org/docs/' . $slug,
                        'content'     => '<h1>404 – Document not found</h1>',
                    ]),
                    404
                );
            }

            return new Response(
                $view->render('page', [
                    'title'       => (string) ($doc['meta']['title'] ?? ucfirst($slug)),
                    'description' => (string) ($doc['meta']['description'] ?? ''),
                    'canonical'   => 'https://webholeink.org/docs/' . $slug,
                    'content'     => (string) $doc['content'],
                ]),
                200,
                ['Content-Type' => 'text/html; charset=UTF-8'],
                $doc['mtime']
            );
        }

        /*
         * -------------------------------------------------
         * Posts: /posts/{slug}
         * -------------------------------------------------
         */
        if (str_starts_with($path, 'posts/')) {
            $slug = trim(substr($path, 6), '/');

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
                    404
                );
            }

            return new Response(
                $view->render('post', [
                    'title'       => (string) ($post['meta']['title'] ?? 'WebholeInk'),
                    'description' => (string) ($post['meta']['description'] ?? ''),
                    'canonical'   => 'https://webholeink.org/posts/' . $slug,
                    'date'        => (string) ($post['meta']['date'] ?? ''),
                    'content'     => (string) $post['content'],
                ]),
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        /*
         * -------------------------------------------------
         * Pages
         * -------------------------------------------------
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
                404
            );
        }

        $md = new Markdown();
        $parsed = $md->parseWithFrontMatter((string) ($page['body'] ?? ''));

        $slug = (string) ($page['slug'] ?? 'home');
        $canonical = $slug === 'home' ? '/' : '/' . $slug;

        return new Response(
            $view->render('page', [
                'title'       => (string) ($page['meta']['title'] ?? ucfirst($slug)),
                'description' => (string) ($page['meta']['description'] ?? ''),
                'canonical'   => 'https://webholeink.org' . $canonical,
                'content'     => (string) ($parsed['html'] ?? ''),
            ]),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }
}
