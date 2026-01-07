<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class PostResolver
{
    public function __construct(
        private string $postsDir
    ) {}

    /**
     * Return all non-draft posts for index / feeds
     */
    public function index(): array
    {
        $posts = [];

        foreach (glob($this->postsDir . '/*.md') ?: [] as $file) {
            $raw = file_get_contents($file);

            $md     = new Markdown();
            $parsed = $md->parseWithFrontMatter($raw);
            $meta   = $parsed['meta'] ?? [];

            // ⛔ Exclude ONLY explicit drafts
            if (($meta['draft'] ?? false) === true) {
                continue;
            }

            // ✅ Canonical slug: front-matter slug OR filename
            $filenameSlug = basename($file, '.md');
            $slug = (string) ($meta['slug'] ?? $filenameSlug);

            $posts[] = [
                'slug'        => $slug,
                'title'       => (string) ($meta['title'] ?? $slug),
                'description' => (string) ($meta['description'] ?? ''),
                'date'        => (string) ($meta['date'] ?? ''),
                'url'         => '/posts/' . $slug,
            ];
        }

        usort(
            $posts,
            fn ($a, $b) => strcmp((string) $b['date'], (string) $a['date'])
        );

        return $posts;
    }

    /**
     * Resolve a single post by slug (front-matter OR filename)
     */
    public function resolve(string $slug): ?array
    {
        foreach (glob($this->postsDir . '/*.md') ?: [] as $file) {
            $raw = file_get_contents($file);

            $md     = new Markdown();
            $parsed = $md->parseWithFrontMatter($raw);
            $meta   = $parsed['meta'] ?? [];

            // ⛔ Exclude ONLY explicit drafts
            if (($meta['draft'] ?? false) === true) {
                continue;
            }

            $filenameSlug = basename($file, '.md');
            $postSlug = (string) ($meta['slug'] ?? $filenameSlug);

            if ($postSlug !== $slug) {
                continue;
            }

            return [
                'meta'    => $meta,
                'content' => $parsed['html'],
            ];
        }

        return null;
    }
}
