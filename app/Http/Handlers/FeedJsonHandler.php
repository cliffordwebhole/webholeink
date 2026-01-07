<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PostResolver;

final class FeedJsonHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $resolver = new PostResolver(
            __DIR__ . '/../../../content/posts'
        );

        $posts = $resolver->index();

        $items = [];

        foreach ($posts as $post) {
            if (!empty($post['draft'])) {
                continue;
            }
$baseUrl = 'https://webholeink.org';

$items[] = [
    'id'   => $baseUrl . '/posts/' . $post['slug'],
    'url'  => $baseUrl . '/posts/' . $post['slug'],
    'title' => $post['title'],
    'summary' => $post['description'] ?? '',
    'content_html' => '',
    'date_published' => (new \DateTimeImmutable($post['date']))
        ->format(DATE_ATOM),
];

        }

        $feed = [
            'version' => 'https://jsonfeed.org/version/1.1',
            'title' => 'WebholeInk',
            'home_page_url' => 'https://webholeink.org',
            'feed_url' => 'https://webholeink.org/feed.json',
            'items' => $items,
        ];

        return new Response(
            json_encode($feed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            200,
            ['Content-Type' => 'application/feed+json; charset=UTF-8']
        );
    }
}
