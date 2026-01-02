<?php

declare(strict_types=1);

namespace WebholeInk\Core;

final class Navigation
{
    /**
     * @var array<int, array{label:string,path:string}>
     */
    private array $items;

    public function __construct()
    {
        $file = WEBHOLEINK_CONTENT . '/navigation.php';

        if (!is_file($file)) {
            $this->items = [];
            return;
        }

        $data = require $file;

        $this->items = is_array($data) ? $data : [];
    }

    /**
     * Return navigation items.
     */
    public function items(): array
    {
        return $this->items;
    }
}
