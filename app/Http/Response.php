<?php

declare(strict_types=1);

namespace WebholeInk\Http;

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

        // 🚫 NO layout, NO navigation, NO rendering here
        echo $this->body;
    }
}
