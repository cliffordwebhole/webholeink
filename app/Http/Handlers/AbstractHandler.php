<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Http\Contracts\HandlerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    protected function html(string $content, int $status = 200): Response
    {
        return new Response(
            $content,
            $status,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }
}
