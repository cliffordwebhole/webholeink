<?php

declare(strict_types=1);

namespace WebholeInk\Http;

interface HandlerInterface
{
    public function handle(Request $request): Response;
}
