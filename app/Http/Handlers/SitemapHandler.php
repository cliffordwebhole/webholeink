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
        $site = require WEBHOLEINK_ROOT . '/app/config/site.php';

        $baseUrl = rtrim((string) ($site['url'] ?? ''), '/');

        $urls = [];

        // -------------------------------------------------
        // Homepage
        // -------------------------------------------------
        $urls[] = $baseUrl . '/';

        // -------------------------------------------------
        // Pages (navigation-aware, non-draft)
        // -------------------------------------------------
        $pageResolver = new PageResolver(WEBHOLEINK_ROOT . '/content');

        foreach ($pageResolver->navigationItems() as $page) {
            $path = (string) ($page['path'] ?? '');

            if ($path === '/' || $path === '') {
                continue;
            }

            $urls[] = $baseUrl . $path;
        }

        // -------------------------------------------------
        // Posts
        // -------------------------------------------------
        $postResolver = new PostResolver(WEBHOLEINK_ROOT . '/content/posts');

        foreach ($postResolver->index() as $post) {
            $urls[] = $baseUrl . (string) $post['url'];
        }

        // -------------------------------------------------
        // Build XML
        // -------------------------------------------------
        $entries = '';

        foreach ($urls as $url) {
            $loc = htmlspecialchars($url, ENT_XML1, 'UTF-8');

            $entries .= <<<XML
<url>
  <loc>{$loc}</loc>
</url>

XML;
        }

        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{$entries}
</urlset>
XML;

        return new Response(
            $xml,
            200,
            ['Content-Type' => 'application/xml; charset=UTF-8']
        );
    }
}
