<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class Search
{
    public function __construct(
        private string $contentRoot
    ) {}

    /**
     * @return array<int, array{type:string,title:string,path:string,excerpt:string}>
     */
    public function run(string $query): array
    {
        $q = mb_strtolower(trim($query));
        if ($q === '') return [];

        $targets = [
            'posts' => $this->contentRoot . '/posts',
            'pages' => $this->contentRoot . '/pages',
            'docs'  => $this->contentRoot . '/docs',
        ];

        $md = new Markdown();

        $hits = [];

        foreach ($targets as $type => $dir) {
            if (!is_dir($dir)) continue;

            foreach (glob($dir . '/*.md') ?: [] as $file) {
                $raw = @file_get_contents($file);
                if ($raw === false) continue;

                $parsed = $md->parseWithFrontMatter($raw);
                $meta = $parsed['meta'] ?? [];
                $html = $parsed['html'] ?? '';

                $title = (string)($meta['title'] ?? basename($file, '.md'));

                // Search within title + visible text
                $text = strip_tags($html);
                $hay = mb_strtolower($title . "\n" . $text);

                if (mb_strpos($hay, $q) === false) {
                    continue;
                }

                $slug = basename($file, '.md');
                $path = match ($type) {
                    'posts' => '/posts/' . $slug,
                    'pages' => '/' . $slug,
                    'docs'  => '/docs/' . $slug,
                    default => '/' . $slug,
                };

                $excerpt = $this->makeExcerpt($text, $q);

                $hits[] = [
                    'type' => $type,
                    'title' => $title,
                    'path' => $path,
                    'excerpt' => $excerpt,
                ];
            }
        }

        // Simple sort: title matches first, then excerpt matches
        usort($hits, function ($a, $b) use ($q) {
            $aTitle = mb_stripos($a['title'], $q) !== false ? 1 : 0;
            $bTitle = mb_stripos($b['title'], $q) !== false ? 1 : 0;
            return $bTitle <=> $aTitle;
        });

        // Cap results so it stays fast
        return array_slice($hits, 0, 50);
    }

    private function makeExcerpt(string $text, string $q): string
    {
        $text = preg_replace('/\s+/', ' ', trim($text)) ?? '';
        if ($text === '') return '';

        $pos = mb_stripos($text, $q);
        if ($pos === false) {
            return mb_substr($text, 0, 180) . (mb_strlen($text) > 180 ? '…' : '');
        }

        $start = max(0, $pos - 60);
        $chunk = mb_substr($text, $start, 220);
        return ($start > 0 ? '…' : '') . $chunk . (mb_strlen($text) > ($start + 220) ? '…' : '');
    }
}
