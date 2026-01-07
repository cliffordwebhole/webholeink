<?php

declare(strict_types=1);

namespace WebholeInk\Http;

final class Response
{
    private string $body;
    private int $status;
    private array $headers;
    private ?int $lastModified;

    public function __construct(
        string $body,
        int $status = 200,
        array $headers = [],
        ?int $lastModified = null
    ) {
        $this->body = $body;
        $this->status = $status;
        $this->headers = $headers;
        $this->lastModified = $lastModified;
    }

    public function send(): void
    {
        // ----------------------------
        // Last-Modified + ETag
        // ----------------------------
        if ($this->lastModified !== null) {
            $etag = '"' . sha1((string) $this->lastModified) . '"';
            $lastModifiedHttp = gmdate('D, d M Y H:i:s', $this->lastModified) . ' GMT';

            header('ETag: ' . $etag);
            header('Last-Modified: ' . $lastModifiedHttp);
            header('Cache-Control: public, max-age=0, must-revalidate');

            // Conditional request handling
            if (
                ($_SERVER['HTTP_IF_NONE_MATCH'] ?? '') === $etag ||
                ($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '') === $lastModifiedHttp
            ) {
                http_response_code(304);
                return;
            }
        }

        // ----------------------------
        // Status + Headers
        // ----------------------------
        http_response_code($this->status);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $this->body;
    }
}
