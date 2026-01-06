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
        $title = htmlspecialchars(
            (string)($meta['title'] ?? 'WebholeInk'),
            ENT_QUOTES,
            'UTF-8'
        );

        $description = '';
        if (!empty($meta['description'])) {
            $description = '<meta name="description" content="'
                . htmlspecialchars((string)$meta['description'], ENT_QUOTES, 'UTF-8')
                . '">' . PHP_EOL;
        }

        $canonical = '';
        if (!empty($meta['canonical'])) {
            $canonical = '<link rel="canonical" href="'
                . htmlspecialchars((string)$meta['canonical'], ENT_QUOTES, 'UTF-8')
                . '">' . PHP_EOL;
        }

        return '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>' . $title . '</title>
    ' . $description . '
    ' . $canonical . '
    <link rel="stylesheet" href="/themes/default/assets/css/style.css">
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
            $label = (string) ($item['label'] ?? '');
            $path  = (string) ($item['path'] ?? '/');

            $html .= '<li><a href="'
                . htmlspecialchars($path, ENT_QUOTES, 'UTF-8')
                . '">'
                . htmlspecialchars($label, ENT_QUOTES, 'UTF-8')
                . '</a></li>';
        }

        $html .= '</ul></nav>';

        return $html;
    }

    /**
     * Base URL detection (proxy-safe)
     */
    private function baseUrl(): string
    {
        $scheme = 'http';

        if (
            (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
            || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        ) {
            $scheme = 'https';
        }

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        return $scheme . '://' . $host;
    }
}
