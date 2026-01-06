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

            // Draft protection
            if (($meta['draft'] ?? false) === true) {
                continue;
            }

            $slug = $meta['slug'] ?? basename($file, '.md');

            $posts[] = [
                'slug'    => $slug,
                'title'   => $meta['title'] ?? $slug,
                'date'    => $meta['date'] ?? '',
                'excerpt' => $meta['excerpt'] ?? '',
                'updated' => $meta['updated'] ?? null,
            ];
        }

        usort(
            $posts,
            fn ($a, $b) => strcmp((string) $b['date'], (string) $a['date'])
        );

        return $posts;
    }

    /**
     * Resolve a single published post
     */
public function resolve(string $slug): ?array
{
    foreach (glob($this->postsDir . '/*.md') ?: [] as $file) {
        $raw = file_get_contents($file);

        $md = new Markdown();
        $parsed = $md->parseWithFrontMatter($raw);

        $metaSlug = $parsed['meta']['slug'] ?? null;
        $fileSlug = basename($file, '.md');

        // Match front-matter slug OR legacy filename slug
        if ($metaSlug === $slug || ($metaSlug === null && $fileSlug === $slug)) {
            return [
                'meta'    => $parsed['meta'],
                'content' => $parsed['html'],
            ];
        }
    }

    return null;
}
}
