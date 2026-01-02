<?php

declare(strict_types=1);

namespace WebholeInk\Http;

use WebholeInk\Core\Layout;
use WebholeInk\Core\Navigation;

final class Response
{
    public function __construct(
        private string $body,
        private int $status = 200,
        private array $headers = []
    ) {}

    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        $layout = new Layout(
            new Navigation()
        );

        echo $layout->render($this->body);
    }
}
