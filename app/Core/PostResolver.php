<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class PostResolver
{
    public function __construct(
        private string $postsDir
    ) {}

    /**
     * Return all published posts for index
     *
     * Drafts (published !== true) are ignored
     */
    public function index(): array
    {
        $posts = [];

        foreach (glob($this->postsDir . '/*.md') ?: [] as $file) {
            $raw = file_get_contents($file);
            if ($raw === false) {
                continue;
            }

            $md = new Markdown();
            $parsed = $md->parseWithFrontMatter($raw);
            $meta = $parsed['meta'];

            // 🔒 Explicit publish requirement (Option A)
            if (($meta['published'] ?? false) !== true) {
                continue;
            }

            $slug = $meta['slug']
                ?? basename($file, '.md');

            $posts[] = [
                'slug'  => $slug,
                'title' => $meta['title'] ?? $slug,
                'date'  => $meta['date'] ?? null,
            ];
        }

        // Newest first (null-safe)
        usort(
            $posts,
            fn ($a, $b) => strcmp(
                (string) ($b['date'] ?? ''),
                (string) ($a['date'] ?? '')
            )
        );

        return $posts;
    }

    /**
     * Resolve a single published post by slug
     *
     * Drafts return null (404)
     */
    public function resolve(string $slug): ?array
    {
        $path = $this->postsDir . '/' . $slug . '.md';

        if (!is_file($path)) {
            return null;
        }

        $raw = file_get_contents($path);
        if ($raw === false) {
            return null;
        }

        $md = new Markdown();
        $parsed = $md->parseWithFrontMatter($raw);
        $meta = $parsed['meta'];

        // 🔒 Explicit publish requirement (Option A)
        if (($meta['published'] ?? false) !== true) {
            return null;
        }

        return [
            'meta'    => $meta,
            'content' => $parsed['html'],
        ];
    }
}
