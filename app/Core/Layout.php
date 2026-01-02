<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class Layout
{
    private string $themePath;

    public function __construct(
        private Navigation $navigation,
        string $theme = 'default'
    ) {
        $this->themePath = WEBHOLEINK_ROOT . '/app/themes/' . $theme;
    }

    public function render(string $content): string
    {
        $navigation = $this->navigation->items();

        ob_start();
        require $this->themePath . '/layout.php';
        return ob_get_clean();
    }
}
