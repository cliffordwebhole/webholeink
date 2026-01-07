<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PostResolver;
use WebholeInk\Core\FeedBuilder;

final class FeedHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $resolver = new PostResolver(
            __DIR__ . '/../../../content/posts'
        );

        // Get all posts and filter published only
        $posts = array_filter(
            $resolver->index(),
            fn ($p) => ($p['published'] ?? true) === true
        );

        $builder = new FeedBuilder();

        $rss = $builder->buildRss($posts, [
            'title'       => 'WebholeInk',
            'description' => 'A minimal, file-first publishing engine.',
            'url'         => 'https://webholeink.org',
        ]);

        return new Response(
            $rss,
            200,
            ['Content-Type' => 'application/rss+xml; charset=UTF-8']
        );
    }
}
