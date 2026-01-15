<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Http\Handlers\HandlerInterface;
use WebholeInk\Core\PostResolver;

final class FeedJsonHandler implements HandlerInterface
{
    private PostResolver $posts;
    private array $site;

    public function __construct()
    {
        $this->site = require WEBHOLEINK_ROOT . '/app/config/site.php';

        $this->posts = new PostResolver(
            WEBHOLEINK_ROOT . '/content/posts'
        );
    }

    public function handle(Request $request): Response
    {
        $items = [];

        foreach ($this->posts->index() as $post) {
            $url = rtrim($this->site['url'], '/') . $post['url'];

            $items[] = [
                'id'    => $url,
                'url'   => $url,
                'title' => $post['title'],
                'summary' => $post['description'],
                'date_published' => $post['date'],
            ];
        }

        $feed = [
            'version' => 'https://jsonfeed.org/version/1.1',
            'title'   => $this->site['name'],
            'home_page_url' => $this->site['url'],
            'feed_url' => rtrim($this->site['url'], '/') . '/feed.json',
            'items'   => $items,
        ];

        return new Response(
            json_encode($feed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            200,
            ['Content-Type' => 'application/json; charset=utf-8']
        );
    }
}
