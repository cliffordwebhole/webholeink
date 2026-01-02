<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\PageView;

final class PageHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $slug = trim($request->path(), '/');

        $file = WEBHOLEINK_CONTENT . '/pages/' . $slug . '.md';

        if (!is_file($file)) {
            return new Response('<h1>404 Not Found</h1>', 404);
        }

        $markdown = file_get_contents($file);
        $html = (new \Parsedown())->text($markdown);

        $view = new PageView(WEBHOLEINK_ROOT . '/app/themes/default');

        return new Response(
            $view->render('page', ['content' => $html]),
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }
}
