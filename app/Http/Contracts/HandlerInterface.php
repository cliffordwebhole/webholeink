<?php

declare(strict_types=1);

namespace WebholeInk\Http\Contracts;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;

interface HandlerInterface
{
    public function handle(Request $request): Response;
}
