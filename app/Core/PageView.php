<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class PageView
{
    public function __construct(
        private string $themeRoot
    ) {}

    public function render(string $template, array $data = []): string
    {
        $templateFile = $this->themeRoot . '/' . $template . '.php';

        if (!is_file($templateFile)) {
            throw new \RuntimeException("View template not found: {$templateFile}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $templateFile;
        return ob_get_clean();
    }

    public function layout(string $content): string
    {
        $layout = new Layout($this->themeRoot);
        return $layout->render($content);
    }
}
