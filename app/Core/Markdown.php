<?php

declare(strict_types=1);

namespace WebholeInk\Core;

require_once __DIR__ . '/../vendor/Parsedown/Parsedown.php';

final class Markdown
{
    private \Parsedown $parser;

    public function __construct()
    {
        $this->parser = new \Parsedown();

        // safer defaults
        $this->parser->setSafeMode(true);
        $this->parser->setMarkupEscaped(true);
    }

    public function toHtml(string $markdown): string
    {
        return $this->parser->text($markdown);
    }
}
