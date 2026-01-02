<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class ThemeLoader
{
    private string $basePath;
    private string $activeTheme;

    public function __construct(
        string $basePath,
        string $activeTheme = 'default'
    ) {
        $this->basePath = rtrim($basePath, '/');
        $this->activeTheme = $activeTheme;
    }

    /**
     * Absolute path to active theme directory
     */
    public function path(): string
    {
        return $this->basePath . '/' . $this->activeTheme;
    }

    /**
     * Resolve a template file inside the active theme
     */
    public function template(string $name): string
    {
        $file = $this->path() . '/' . $name . '.php';

        if (!is_file($file)) {
            throw new \RuntimeException(
                "Theme template not found: {$file}"
            );
        }

        return $file;
    }
}
