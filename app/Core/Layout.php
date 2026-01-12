<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class Layout
{
    public function __construct(
        private Navigation $navigation
    ) {}

    /**
     * @param array<string,mixed> $meta
     */
    public function render(string $content, array $meta = []): string
    {
        // -------------------------------------------------
        // Theme resolution (author-controlled)
        // -------------------------------------------------
        $themeConfig = require WEBHOLEINK_ROOT . '/app/config/theme.php';

        $available = $themeConfig['available'] ?? ['classic'];
        $default   = $themeConfig['default'] ?? 'classic';
        $active    = $themeConfig['active'] ?? $default;

        $theme = in_array($active, $available, true)
            ? $active
            : $default;

        // -------------------------------------------------
        // Metadata
        // -------------------------------------------------
        $title = htmlspecialchars(
            (string)($meta['title'] ?? 'WebholeInk'),
            ENT_QUOTES,
            'UTF-8'
        );

        $description = !empty($meta['description'])
            ? htmlspecialchars((string)$meta['description'], ENT_QUOTES, 'UTF-8')
            : '';

        $url = htmlspecialchars(
            (string)($meta['canonical'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $isDraft  = !empty($meta['draft']);
        $pageType = (string)($meta['type'] ?? 'website');

        $ogImage = htmlspecialchars(
            (string)($meta['og_image'] ?? '/og-default.png'),
            ENT_QUOTES,
            'UTF-8'
        );

        // -------------------------------------------------
        // Head construction
        // -------------------------------------------------
        $head = [];

        $head[] = "<title>{$title}</title>";

        if ($description !== '') {
            $head[] = "<meta name=\"description\" content=\"{$description}\">";
        }

        if ($url !== '') {
            $head[] = "<link rel=\"canonical\" href=\"{$url}\">";
        }

        if ($isDraft) {
            $head[] = '<meta name="robots" content="noindex, nofollow">';
        }

        // Open Graph
        $head[] = '<meta property="og:site_name" content="WebholeInk">';
        $head[] = "<meta property=\"og:type\" content=\"{$pageType}\">";
        $head[] = "<meta property=\"og:title\" content=\"{$title}\">";

        if ($description !== '') {
            $head[] = "<meta property=\"og:description\" content=\"{$description}\">";
        }

        if ($url !== '') {
            $head[] = "<meta property=\"og:url\" content=\"{$url}\">";
        }

        $head[] = "<meta property=\"og:image\" content=\"{$ogImage}\">";

        // Twitter / X
        $head[] = '<meta name="twitter:card" content="summary_large_image">';
        $head[] = "<meta name=\"twitter:title\" content=\"{$title}\">";

        if ($description !== '') {
            $head[] = "<meta name=\"twitter:description\" content=\"{$description}\">";
        }

        $head[] = "<meta name=\"twitter:image\" content=\"{$ogImage}\">";

        // -------------------------------------------------
        // Render
        // -------------------------------------------------
        return '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    ' . implode("\n    ", $head) . '

    <!-- Base structural CSS (engine rules) -->
    <link rel="stylesheet" href="/themes/default/assets/css/style.css">

    <!-- Theme variables (ONE file only) -->
    <link rel="stylesheet" href="/themes/default/assets/css/theme-'
        . htmlspecialchars($theme, ENT_QUOTES, 'UTF-8')
        . '.v1.css">

    <link rel="alternate" type="application/rss+xml"
          title="WebholeInk RSS"
          href="https://webholeink.org/feed.xml">
</head>
<body>
' . $this->renderNavigation() . '
<main>
' . $content . '
</main>
</body>
</html>';
    }

    private function renderNavigation(): string
    {
        $html = '<nav><ul>';

        foreach ($this->navigation->items() as $item) {
            $label = (string)($item['label'] ?? '');
            $path  = (string)($item['path'] ?? '/');

            $html .= '<li><a href="'
                . htmlspecialchars($path, ENT_QUOTES, 'UTF-8')
                . '">'
                . htmlspecialchars($label, ENT_QUOTES, 'UTF-8')
                . '</a></li>';
        }

        $html .= '</ul></nav>';

        return $html;
    }
}
