<?php

declare(strict_types=1);

namespace WebholeInk\Core;

use RuntimeException;

final class View
{
    private string $themePath;

    public function __construct(string $theme = 'default')
    {
        $this->themePath = WEBHOLEINK_ROOT . '/app/themes/' . $theme;
    }

    public function render(string $template, array $data = []): string
    {
        $file = $this->themePath . '/' . $template . '.php';

        if (!is_file($file)) {
            throw new RuntimeException('View template not found: ' . $file);
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $file;
        return ob_get_clean();
    }
}
