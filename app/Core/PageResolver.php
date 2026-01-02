<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class PageResolver
{
    private string $pagesPath;

    public function __construct(string $pagesPath)
    {
        $this->pagesPath = rtrim($pagesPath, '/');
    }

    public function resolve(string $slug): ?string
    {
        $file = $this->pagesPath . '/' . $slug . '.md';

        if (!is_file($file)) {
            return null;
        }

        return file_get_contents($file);
    }
}
