<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\View;

final class DocsHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $docsDir = WEBHOLEINK_ROOT . '/content/docs';
        $docs    = [];

        foreach (glob($docsDir . '/*.md') ?: [] as $file) {
            $slug = basename($file, '.md');

            $docs[] = [
                'slug' => $slug,
                'url'  => '/docs/' . $slug,
                'name' => ucfirst(str_replace('-', ' ', $slug)),
            ];
        }

        usort($docs, fn ($a, $b) => strcmp($a['name'], $b['name']));

        $view = new View('default');

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
}
