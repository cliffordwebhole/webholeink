<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\View;

final class HomeHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $view = new View('default');

        return new Response(
            $view->render('home'),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }
}
