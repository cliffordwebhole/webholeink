<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PostResolver;

final class FeedHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $site = require WEBHOLEINK_ROOT . '/app/config/site.php';

        $siteName = $site['name'] ?? 'WebholeInk';
        $siteUrl  = rtrim($site['url'] ?? '', '/');
        $siteDesc = $site['description'] ?? '';

        $postsDir = WEBHOLEINK_ROOT . '/content/posts';
        $resolver = new PostResolver($postsDir);
        $posts    = $resolver->index();

        $items = '';

        foreach ($posts as $post) {
            $url   = $siteUrl . $post['url'];
            $title = htmlspecialchars($post['title'], ENT_XML1);
            $desc  = htmlspecialchars($post['description'], ENT_XML1);
            $date  = !empty($post['date'])
                ? gmdate(DATE_RSS, strtotime($post['date']))
                : gmdate(DATE_RSS);

            $items .= <<<XML
<item>
  <title>{$title}</title>
  <link>{$url}</link>
  <guid>{$url}</guid>
  <description>{$desc}</description>
  <pubDate>{$date}</pubDate>
</item>

XML;
        }

        $rss = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>
  <title>{$siteName}</title>
  <link>{$siteUrl}</link>
  <description>{$siteDesc}</description>
  <language>en-us</language>
  {$items}
</channel>
</rss>
XML;

        return new Response(
            $rss,
            200,
            ['Content-Type' => 'application/rss+xml; charset=UTF-8']
        );
    }
}
