<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\DocResolver;
use WebholeInk\Core\View;

final class DocHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        // Expected path: /docs/{slug}
        $path = trim($request->path(), '/');

        // Guard: prevent /docs from being treated as a document
        if ($path === 'docs') {
            return new Response(
                '<h1>404 – Document not found</h1>',
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        // Extract slug
        $slug = substr($path, strlen('docs/'));
        $slug = trim($slug, '/');

        if ($slug === '') {
            return new Response(
                '<h1>404 – Document not found</h1>',
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $resolver = new DocResolver(WEBHOLEINK_ROOT . '/content/docs');
        $doc = $resolver->resolve($slug);

        if ($doc === null) {
            return new Response(
                '<h1>404 – Document not found</h1>',
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $meta = $doc['meta'] ?? [];

        return new Response(
            (new View('default'))->render('doc', [
                'title'       => (string) ($meta['title'] ?? ucfirst($slug)),
                'description' => (string) ($meta['description'] ?? 'WebholeInk documentation'),
                'canonical'   => 'https://webholeink.org/docs/' . $slug,
                'content'     => (string) $doc['content'],
            ]),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8'],
            $doc['mtime'] ?? null
        );
    }
}
