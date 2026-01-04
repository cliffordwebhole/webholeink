<?php
// File: app/Core/PageResolver.php

declare(strict_types=1);

namespace WebholeInk\Core;

final class PageResolver
{
    private string $pagesDir;

    public function __construct(string $contentDir)
    {
        $this->pagesDir = rtrim($contentDir, '/') . '/pages';
    }

    /**
     * Resolve a page by slug (e.g. "about" -> content/pages/about.md)
     *
     * @return array{
     *   slug: string,
     *   meta: array<string,mixed>,
     *   body: string
     * }|null
     */
    public function resolve(string $slug): ?array
    {
        $slug = trim($slug, '/');
        if ($slug === '') {
            $slug = 'home';
        }

        $path = $this->pagesDir . '/' . $slug . '.md';
        if (!is_file($path)) {
            return null;
        }

        return $this->parseFile($path, $slug);
    }

    /**
     * Build navigation from pages directory.
     *
     * Only includes pages where front matter includes: nav: true
     *
     * @return array<int,array{label:string,path:string,order:int}>
     */
    public function navigationItems(): array
    {
        $items = [];

        foreach (glob($this->pagesDir . '/*.md') ?: [] as $file) {
            $slug = basename($file, '.md');
            $page = $this->parseFile($file, $slug);

            $nav = $page['meta']['nav'] ?? false;
            if ($nav !== true) {
                continue;
            }

            $label = (string)($page['meta']['title'] ?? ucfirst($slug));
            $order = (int)($page['meta']['nav_order'] ?? 999);

            $items[] = [
                'label' => $label,
                'path'  => ($slug === 'home') ? '/' : '/' . $slug,
                'order' => $order,
            ];
        }

        usort($items, static function (array $a, array $b): int {
            return $a['order'] <=> $b['order'];
        });

        return $items;
    }

    /**
     * Parse markdown file + YAML-ish front matter.
     *
     * Front matter format:
     * ---
     * title: About
     * description: About WebholeInk
     * nav: true
     * nav_order: 20
     * ---
     *
     * @return array{slug:string, meta:array<string,mixed>, body:string}
     */
    private function parseFile(string $path, string $slug): array
    {
        $raw = (string)file_get_contents($path);
        $meta = [];
        $body = $raw;

        // Front matter detection at top of file
        if (preg_match('/\A---\R(.*?)\R---\R/s', $raw, $m)) {
            $metaText = $m[1];
            $body = (string)substr($raw, strlen($m[0]));
            $meta = $this->parseFrontMatter($metaText);
        }

        return [
            'slug' => $slug,
            'meta' => $meta,
            'body' => ltrim($body),
        ];
    }

    /**
     * Very small front matter parser:
     * - key: value
     * - true/false
     * - integers
     */
    private function parseFrontMatter(string $text): array
    {
        $meta = [];

        foreach (preg_split('/\R/', $text) as $line) {
            $line = trim((string)$line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            // key: value
            if (!str_contains($line, ':')) {
                continue;
            }

            [$k, $v] = array_map('trim', explode(':', $line, 2));
            if ($k === '') {
                continue;
            }

            // Normalize value
            if ($v === 'true') {
                $meta[$k] = true;
            } elseif ($v === 'false') {
                $meta[$k] = false;
            } elseif (preg_match('/^-?\d+$/', $v)) {
                $meta[$k] = (int)$v;
            } else {
                // Strip optional surrounding quotes
                $meta[$k] = trim($v, "\"'");
            }
        }

        return $meta;
    }
}
