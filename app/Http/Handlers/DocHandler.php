<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Core\DocResolver;
use WebholeInk\Core\View;
use WebholeInk\Http\Request;
use WebholeInk\Http\Response;

final class DocHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        // Site config (single source of truth)
        $site = require WEBHOLEINK_ROOT . '/app/config/site.php';
        $baseUrl = rtrim((string)($site['url'] ?? ''), '/');

        // Expected incoming paths: /docs/<slug> (router sends all /docs/* here)
        $path = trim($request->path(), '/');

        // If someone hits /docs or /docs/ with no slug, send them to docs index
        if ($path === 'docs') {
            return new Response('', 302, ['Location' => '/docs']);
        }

        // Extract slug after "docs/"
        if (!str_starts_with($path, 'docs/')) {
            return new Response(
                '<h1>404 - Document not found</h1>',
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $slug = trim(substr($path, strlen('docs/')), '/');

        if ($slug === '') {
            return new Response(
                '<h1>404 - Document not found</h1>',
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $resolver = new DocResolver(WEBHOLEINK_ROOT . '/content/docs');
        $doc = $resolver->resolve($slug);

        if ($doc === null) {
            return new Response(
                '<h1>404 - Document not found</h1>',
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $meta = $doc['meta'] ?? [];

        return new Response(
            (new View('default'))->render('doc', [
                'title'       => (string)($meta['title'] ?? ucfirst($slug)),
                'description' => (string)($meta['description'] ?? 'WebholeInk documentation'),
                'canonical'   => $baseUrl . '/docs/' . $slug,
                'content'     => (string)($doc['content'] ?? ''),
            ]),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8'],
            $doc['mtime'] ?? null
        );
    }
}
