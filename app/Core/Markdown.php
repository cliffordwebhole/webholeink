<?php

declare(strict_types=1);

namespace WebholeInk\Core;

use Parsedown;

final class Markdown
{
    private Parsedown $parser;

    public function __construct()
    {
        $this->parser = new Parsedown();
        $this->parser->setSafeMode(true);
    }

    /**
     * Parse markdown with optional YAML front matter.
     *
     * @return array{
     *   meta: array<string, mixed>,
     *   html: string
     * }
     */
    public function parseWithFrontMatter(string $raw): array
    {
        $meta = [];
        $body = $raw;

        if (str_starts_with($raw, "---")) {
            $parts = preg_split('/^-{3}\s*$/m', $raw, 3);

            if (count($parts) === 3) {
                $meta = $this->parseMeta(trim($parts[1]));
                $body = $parts[2];
            }
        }

        return [
            'meta' => $meta,
            'html' => $this->parser->text($body),
        ];
    }

    private function parseMeta(string $yaml): array
    {
        $meta = [];

        foreach (preg_split('/\r?\n/', $yaml) as $line) {
            if (!str_contains($line, ':')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode(':', $line, 2));
            $meta[$key] = $this->castValue($value);
        }

        return $meta;
    }

    private function castValue(string $value): mixed
    {
        if ($value === 'true') return true;
        if ($value === 'false') return false;
        if (is_numeric($value)) return (int) $value;

        return $value;
    }
}
