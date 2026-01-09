<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class DocResolver
{
    public function __construct(
        private string $docsDir
    ) {}

    /**
     * Return all docs for /docs index
     */
    public function index(): array
    {
        $docs = [];

        foreach (glob($this->docsDir . '/*.md') ?: [] as $file) {
            $raw = file_get_contents($file);
            if ($raw === false) {
                continue;
            }

            $md = new Markdown();
            $parsed = $md->parseWithFrontMatter($raw);

            $meta = $parsed['meta'] ?? [];
            $slug = basename($file, '.md');

            if (($meta['draft'] ?? false) === true) {
                continue;
            }

            $docs[] = [
                'slug'        => $slug,
                'title'       => (string) ($meta['title'] ?? ucfirst($slug)),
                'description' => (string) ($meta['description'] ?? ''),
                'url'         => '/docs/' . $slug,
                'mtime'       => filemtime($file) ?: time(),
            ];
        }

        usort(
            $docs,
            fn ($a, $b) => strcmp($a['slug'], $b['slug'])
        );

        return $docs;
    }

    /**
     * Resolve a single doc by slug
     */
    public function resolve(string $slug): ?array
    {
        $file = $this->docsDir . '/' . $slug . '.md';

        if (!is_file($file) || !is_readable($file)) {
            return null;
        }

        $raw = file_get_contents($file);
        if ($raw === false) {
            return null;
        }

        $md = new Markdown();
        $parsed = $md->parseWithFrontMatter($raw);

        return [
            'meta'    => $parsed['meta'] ?? [],
            'content' => $parsed['html'] ?? '',
            'mtime'   => filemtime($file) ?: time(),
            'slug'    => $slug,
        ];
    }
}
