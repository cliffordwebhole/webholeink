<?php

declare(strict_types=1);

namespace WebholeInk\Core;

use RuntimeException;

final class View
{
    private string $themePath;
    private Layout $layout;

    public function __construct(string $theme = 'default')
    {
        $this->themePath = WEBHOLEINK_ROOT . '/app/themes/' . $theme;

        // Navigation requires PageResolver
        $pageResolver = new PageResolver(
            WEBHOLEINK_ROOT . '/content'
        );

        $navigation = new Navigation($pageResolver);
        $this->layout = new Layout($navigation);
    }

    public function render(string $template, array $data = []): string
    {
        $templateFile = $this->templatePath($template);

        extract($data, EXTR_SKIP);

        ob_start();
        require $templateFile;
        $content = ob_get_clean();

        return $this->layout->render(
            $content,
            $data // ← metadata now flows correctly
        );
    }

    private function templatePath(string $template): string
    {
        $file = $this->themePath . '/' . $template . '.php';

        if (!is_file($file)) {
            throw new RuntimeException(
                'View template not found: ' . $file
            );
        }

        return $file;
    }
}
