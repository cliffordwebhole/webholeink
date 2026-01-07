<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class FeedBuilder
{
    /**
     * @param array<int,array<string,mixed>> $posts
     */
    public function buildRss(array $posts, array $site): string
    {
        $items = '';

        foreach ($posts as $post) {
            $title = htmlspecialchars((string)$post['title'], ENT_QUOTES, 'UTF-8');
            $link  = $site['url'] . '/posts/' . $post['slug'];
            $desc  = htmlspecialchars((string)($post['description'] ?? ''), ENT_QUOTES, 'UTF-8');
            $date  = date(DATE_RSS, strtotime((string)$post['date']));

            $items .= <<<XML
<item>
    <title>{$title}</title>
    <link>{$link}</link>
    <guid>{$link}</guid>
    <pubDate>{$date}</pubDate>
    <description><![CDATA[{$desc}]]></description>
</item>

XML;
        }

        $channelTitle = htmlspecialchars($site['title'], ENT_QUOTES, 'UTF-8');
        $channelDesc  = htmlspecialchars($site['description'], ENT_QUOTES, 'UTF-8');
        $channelLink  = $site['url'];

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>
    <title>{$channelTitle}</title>
    <link>{$channelLink}</link>
    <description>{$channelDesc}</description>
    {$items}
</channel>
</rss>
XML;
    }
}
