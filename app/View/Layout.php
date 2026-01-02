<?php

declare(strict_types=1);

namespace WebholeInk\View;

final class Layout
{
    public static function render(string $content, string $title = 'WebholeInk'): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
{$content}
</body>
</html>
HTML;
    }
}
