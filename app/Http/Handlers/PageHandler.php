<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Http\Request;
use WebholeInk\Http\Response;
use WebholeInk\Core\Markdown;
use WebholeInk\Core\PageResolver;
use WebholeInk\Core\PostResolver;
use WebholeInk\Core\View;

final class PageHandler implements HandlerInterface
{
    public function handle(Request $request): Response
    {
        $path = trim($request->path(), '/');
        $view = new View('default');

        /**
         * 1) Single posts: /posts/{slug}
         */
        if (str_starts_with($path, 'posts/')) {
            $slug = trim(substr($path, strlen('posts/')), '/');

            // Use the resolver for content, but do NOT assume filename = slug.md
            $postsDir = WEBHOLEINK_ROOT . '/content/posts';
            $postResolver = new PostResolver($postsDir);
            $post = $postResolver->resolve($slug);

            if ($post === null) {
                return new Response(
                    $view->render('page', [
                        'title'       => '404',
                        'description' => '',
                        'canonical'   => 'https://webholeink.org/posts/' . $slug,
                        'content'     => '<h1>404 – Post not found</h1>',
                    ]),
                    404,
                    ['Content-Type' => 'text/html; charset=UTF-8']
                );
            }

            $meta = (array)($post['meta'] ?? []);

            // Find the real file path for this slug so filemtime() works
            $contentFile = $this->findPostFileBySlug($postsDir, $slug);

            // If we can't find it for some reason, fall back to theme/layout times only (no warnings)
            $mtimeCandidates = [
                filemtime(WEBHOLEINK_ROOT . '/app/Core/Layout.php'),
                filemtime(WEBHOLEINK_ROOT . '/app/themes/default/post.php'),
            ];

            if ($contentFile !== null && is_file($contentFile)) {
                $mtimeCandidates[] = filemtime($contentFile);
            }

            $lastModified = max($mtimeCandidates);

            return new Response(
                $view->render('post', [
                    'title'       => (string)($meta['title'] ?? 'WebholeInk'),
                    'description' => (string)($meta['description'] ?? ''),
                    'canonical'   => 'https://webholeink.org/posts/' . $slug,
                    'date'        => (string)($meta['date'] ?? ''),
                    'content'     => (string)($post['content'] ?? ''),
                ]),
                200,
                ['Content-Type' => 'text/html; charset=UTF-8'],
                $lastModified
            );
        }
/**
 * 2) Pages: content/pages/{slug}.md (home maps to /)
 */
$pageResolver = new PageResolver(WEBHOLEINK_ROOT . '/content');
$page = $pageResolver->resolve($path);

if ($page === null) {
    return new Response(
        $view->render('page', [
            'title'       => '404',
            'description' => '',
            'canonical'   => 'https://webholeink.org' . $request->path(),
            'content'     => '<h1>404 – Page not found</h1>',
        ]),
        404,
        ['Content-Type' => 'text/html; charset=UTF-8']
    );
}

$meta = (array) ($page['meta'] ?? []);
$slug = (string) ($page['slug'] ?? 'home');

$canonicalPath = ($slug === 'home') ? '/' : '/' . $slug;

// Per-file Last-Modified (page content + layout + template)
$contentFile = WEBHOLEINK_ROOT . '/content/pages/' . $slug . '.md';
$lastModified = max(
    is_file($contentFile) ? filemtime($contentFile) : 0,
    filemtime(WEBHOLEINK_ROOT . '/app/Core/Layout.php'),
    filemtime(WEBHOLEINK_ROOT . '/app/themes/default/page.php')
);
$md = new Markdown();
$parsed = $md->parseWithFrontMatter((string) ($page['body'] ?? ''));

return new Response(
    $view->render('page', [
        'title'       => (string) ($meta['title'] ?? ucfirst($slug)),
        'description' => (string) ($meta['description'] ?? ''),
        'canonical'   => 'https://webholeink.org' . $canonicalPath,
        'content'     => (string) ($parsed['html'] ?? ''),
    ]),
    200,
    ['Content-Type' => 'text/html; charset=UTF-8'],
    $lastModified
);

    }

    /**
     * Find the actual post file path by matching front-matter slug.
     * This respects your design: filename is NOT authoritative.
     */
    private function findPostFileBySlug(string $postsDir, string $slug): ?string
    {
        foreach (glob(rtrim($postsDir, '/') . '/*.md') ?: [] as $file) {
            $raw = file_get_contents($file);
            if ($raw === false) {
                continue;
            }

            $md = new Markdown();
            $parsed = $md->parseWithFrontMatter($raw);
            $meta = (array)($parsed['meta'] ?? []);

            // exclude explicit drafts
            if (($meta['draft'] ?? false) === true) {
                continue;
            }

            if (($meta['slug'] ?? null) === $slug) {
                return $file;
            }
        }

        return null;
    }
}
