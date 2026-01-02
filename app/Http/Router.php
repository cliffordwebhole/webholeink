<?php

declare(strict_types=1);

namespace WebholeInk\Http;

use WebholeInk\Http\Handlers\HandlerInterface;

final class Router
{
    private array $routes = [];
    private ?HandlerInterface $fallback = null;

    public function get(string $path, HandlerInterface $handler): void
    {
        $this->routes[$this->normalize($path)] = $handler;
    }

    public function fallback(HandlerInterface $handler): void
    {
        $this->fallback = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $path = $this->normalize($request->path());

        if (isset($this->routes[$path])) {
            return $this->routes[$path]->handle($request);
        }

        if ($this->fallback !== null) {
            return $this->fallback->handle($request);
        }

        return new Response(
            '<h1>404 Not Found</h1>',
            404,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }

    private function normalize(string $path): string
    {
        $path = '/' . trim($path, '/');
        return $path === '//' ? '/' : $path;
    }
}
