<?php

declare(strict_types=1);

namespace WebholeInk\Http;

final class Request
{
    private string $method;
    private string $uri;
    private array $query;
    private array $post;
    private array $server;

    private function __construct(
        string $method,
        string $uri,
        array $query,
        array $post,
        array $server
    ) {
        $this->method = strtoupper($method);
        $this->uri    = $uri;
        $this->query  = $query;
        $this->post   = $post;
        $this->server = $server;
    }

    public static function fromGlobals(): self
    {
        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'] ?? '/',
            $_GET,
            $_POST,
            $_SERVER
        );
    }

    public function method(): string
    {
        return $this->method;
    }

    /**
     * Normalized request path (no query string)
     */
    public function path(): string
    {
        $path = parse_url($this->uri, PHP_URL_PATH) ?? '/';

        // Normalize
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        return $path;
    }

    /**
     * Get a query parameter (?q=something)
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    /**
     * Optional helpers (handy later)
     */
    public function allQuery(): array
    {
        return $this->query;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function server(string $key, mixed $default = null): mixed
    {
        return $this->server[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }
}
