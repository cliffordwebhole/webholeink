<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class PostIndex
{
    public function __construct(
        private string $postsDir
    ) {}

    /**
     * @return array<int,array{
     *   title:string,
     *   slug:string,
     *   date:string
     * }>
     */
    public function all(): array
    {
        $posts = [];

        $pattern = $this->postsDir . '/*.md';

foreach (glob($pattern) ?: [] as $file) {
            $post = $this->parsePost($file);
            if ($post === null) {
                continue;
            }
            $posts[] = $post;
        }

        usort($posts, fn ($a, $b) => strcmp($b['date'], $a['date']));

        return $posts;
    }

    private function parsePost(string $file): ?array
    {
        $raw = file_get_contents($file);
        if (!$raw || !str_starts_with($raw, '---')) {
            return null;
        }

        if (!preg_match('/\A---\R(.*?)\R---/s', $raw, $m)) {
            return null;
        }

        $meta = [];
        foreach (preg_split('/\R/', $m[1]) as $line) {
            if (!str_contains($line, ':')) continue;
            [$k, $v] = array_map('trim', explode(':', $line, 2));
            $meta[$k] = trim($v, "\"'");
        }

        if (
            empty($meta['title']) ||
            empty($meta['slug']) ||
            empty($meta['date'])
        ) {
            return null;
        }

        return [
            'title' => $meta['title'],
            'slug'  => $meta['slug'],
            'date'  => $meta['date'],
        ];
    }
}
