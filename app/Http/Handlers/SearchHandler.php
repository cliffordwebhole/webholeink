<?php

declare(strict_types=1);

namespace WebholeInk\Http\Handlers;

use WebholeInk\Core\View;
use WebholeInk\Http\Request;
use WebholeInk\Http\Response;

final class SearchHandler implements HandlerInterface
{
    public function __construct(
        private View $view
    ) {}

    public function handle(Request $request): Response
    {
        // Your Request object doesn't have query(), so read query params directly.
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
        $results = [];

        $indexFile = WEBHOLEINK_ROOT . '/public/storage/search-index.json';

        if (!is_file($indexFile)) {
            $html = $this->view->render('search', [
                'title'   => 'Search',
                'q'       => $q,
                'results' => [],
                'error'   => 'Search index missing. Run: php bin/build-search-index.php',
            ]);

            return new Response($html, 200, ['Content-Type' => 'text/html; charset=UTF-8']);
        }

        $raw = file_get_contents($indexFile);
        $items = $raw ? json_decode($raw, true) : [];
        if (!is_array($items)) {
            $items = [];
        }

        if ($q !== '') {
            $needle = mb_strtolower($q);
            $terms = preg_split('/\s+/', $needle) ?: [];
            $terms = array_values(array_filter($terms, static fn($t) => $t !== ''));

            foreach ($items as $item) {
                if (!is_array($item)) continue;

                $hayTitle = mb_strtolower((string)($item['title'] ?? ''));
                $hayText  = mb_strtolower((string)($item['text'] ?? ''));

                $score = 0;

                foreach ($terms as $t) {
                    // Title is weighted heavier than body text
                    $score += substr_count($hayTitle, $t) * 10;
                    $score += substr_count($hayText,  $t);
                }

                if ($score > 0) {
                    $item['_score'] = $score;
                    $results[] = $item;
                }
            }

            // Sort: score desc -> docs/pages/posts -> date desc
            usort($results, static function (array $a, array $b): int {
                $sa = (int)($a['_score'] ?? 0);
                $sb = (int)($b['_score'] ?? 0);

                if ($sb !== $sa) {
                    return $sb <=> $sa;
                }

                $prio = ['docs' => 0, 'pages' => 1, 'posts' => 2];
                $ta = (string)($a['type'] ?? '');
                $tb = (string)($b['type'] ?? '');
                $pa = $prio[$ta] ?? 9;
                $pb = $prio[$tb] ?? 9;

                if ($pa !== $pb) {
                    return $pa <=> $pb; // lower number first
                }

                $da = strtotime((string)($a['date'] ?? '')) ?: 0;
                $db = strtotime((string)($b['date'] ?? '')) ?: 0;

                return $db <=> $da;
            });
        }

        $html = $this->view->render('search', [
            'title'   => 'Search',
            'q'       => $q,
            'results' => $results,
            'error'   => '',
        ]);

        return new Response($html, 200, ['Content-Type' => 'text/html; charset=UTF-8']);
    }
}
