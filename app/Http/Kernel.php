<?php

declare(strict_types=1);

namespace WebholeInk\Http;

final class Kernel
{
    public function handle(Request $request): Response
    {
        // For now, return a simple response
return new Response(
    '<h1>WebholeInk v1</h1><p>Core online.</p>',
    200,
    ['Content-Type' => 'text/html']
);
    }
}
