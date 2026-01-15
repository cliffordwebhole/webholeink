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
        // Site config
        // -------------------------------------------------
        $site = require WEBHOLEINK_ROOT . '/app/config/site.php';

        // -------------------------------------------------
        // Theme config (author-controlled)
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
            (string)($meta['title'] ?? $site['name']),
            ENT_QUOTES,
            'UTF-8'
        );

        $description = !empty($meta['description'])
            ? htmlspecialchars((string)$meta['description'], ENT_QUOTES, 'UTF-8')
            : htmlspecialchars((string)$site['description'], ENT_QUOTES, 'UTF-8');

        $canonical = !empty($meta['canonical'])
            ? htmlspecialchars((string)$meta['canonical'], ENT_QUOTES, 'UTF-8')
            : '';

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
        $head[] = "<meta name=\"description\" content=\"{$description}\">";

        if ($canonical !== '') {
            $head[] = "<link rel=\"canonical\" href=\"{$canonical}\">";
        }

        if ($isDraft) {
            $head[] = '<meta name="robots" content="noindex, nofollow">';
        }

        $head[] = '<meta property="og:site_name" content="' . htmlspecialchars($site['name'], ENT_QUOTES, 'UTF-8') . '">';
        $head[] = "<meta property=\"og:type\" content=\"{$pageType}\">";
        $head[] = "<meta property=\"og:title\" content=\"{$title}\">";
        $head[] = "<meta property=\"og:description\" content=\"{$description}\">";
        $head[] = "<meta property=\"og:image\" content=\"{$ogImage}\">";

        $head[] = '<meta name="twitter:card" content="summary_large_image">';
        $head[] = "<meta name=\"twitter:title\" content=\"{$title}\">";
        $head[] = "<meta name=\"twitter:description\" content=\"{$description}\">";
        $head[] = "<meta name=\"twitter:image\" content=\"{$ogImage}\">";

        // -------------------------------------------------
        // Render
        // -------------------------------------------------
        return '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    ' . implode("\n    ", $head) . '
    <link rel="stylesheet" href="/themes/default/assets/css/style.css">
    <link rel="stylesheet" href="/themes/default/assets/css/theme-' . htmlspecialchars($theme, ENT_QUOTES, 'UTF-8') . '.v1.css">
    <link rel="alternate" type="application/rss+xml"
          title="' . htmlspecialchars($site['name'], ENT_QUOTES, 'UTF-8') . ' RSS"
          href="' . htmlspecialchars($site['url'], ENT_QUOTES, 'UTF-8') . '/feed.xml">
</head>
<body>
' . $this->renderNavigation() . '
<main>
' . $content . '
</main>

<footer class="site-footer">
    <p>
        &copy; ' . date('Y') . ' '
        . htmlspecialchars($site['name'], ENT_QUOTES, 'UTF-8') .
        ' · Powered by
        <a href="https://webholeink.com" rel="noopener" target="_blank">
            WebholeInk
        </a>
    </p>
</footer>

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
