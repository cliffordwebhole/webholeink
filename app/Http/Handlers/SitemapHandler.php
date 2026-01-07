<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PageResolver;
use WebholeInk\Core\PostResolver;

final class SitemapHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $base = 'https://webholeink.org';

        $urls = [];
        $seen = [];

        $add = function (string $path, string $lastmod) use (&$urls, &$seen, $base): void {
            if (isset($seen[$path])) {
                return;
            }

            $seen[$path] = true;

            $urls[] = [
                'loc'     => $base . $path,
                'lastmod' => $lastmod,
            ];
        };

        // Homepage
        $add('/', date('Y-m-d'));

        // Pages
        $pages = new PageResolver(__DIR__ . '/../../../content');
        foreach ($pages->navigationItems() as $page) {
            $add(
                $page['path'],
                date('Y-m-d')
            );
        }

        // Posts
        $posts = new PostResolver(__DIR__ . '/../../../content/posts');
        foreach ($posts->index() as $post) {
            $add(
                $post['url'],
                $post['date'] ?: date('Y-m-d')
            );
        }

        // Build XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url['loc']}</loc>\n";
            $xml .= "    <lastmod>{$url['lastmod']}</lastmod>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return new Response(
            $xml,
            200,
            ['Content-Type' => 'application/xml; charset=UTF-8']
        );
    }
}
