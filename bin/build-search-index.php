<?php
declare(strict_types=1);

/**
 * WebholeInk Search Index Builder (Option B)
 * Output: /public/storage/search-index.json
 * Scans: /content/posts, /content/pages, /content/docs
 */

$root = realpath(__DIR__ . '/..');
if (!$root) { fwrite(STDERR, "Root not found\n"); exit(1); }

$contentDirs = [
  'posts' => $root . '/content/posts',
  'pages' => $root . '/content/pages',
  'docs'  => $root . '/content/docs',
];

$outFile = $root . '/public/storage/search-index.json';

function parseFrontMatter(string $raw): array {
  $meta = [];
  $body = $raw;

  if (str_starts_with($raw, "---")) {
    $parts = preg_split('/^-{3}\s*$/m', $raw, 3);
    if (is_array($parts) && count($parts) === 3) {
      $yaml = trim($parts[1]);
      $body = (string)$parts[2];

      foreach (preg_split('/\r?\n/', $yaml) as $line) {
        if (!str_contains($line, ':')) continue;
        [$k, $v] = array_map('trim', explode(':', $line, 2));
        $v = trim($v);
        $v = preg_replace('/^"(.*)"$/', '$1', $v);
        $v = preg_replace("/^'(.*)'$/", '$1', $v);
        $meta[$k] = $v;
      }
    }
  }
  return [$meta, $body];
}

function cleanToText(string $body): string {
  // remove WP block comments (if any)
  $body = preg_replace('/<!--\s*\/?wp:.*?-->/', ' ', $body) ?? $body;
  // strip HTML -> text
  $body = html_entity_decode(strip_tags($body), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $body = preg_replace('/\s+/', ' ', $body) ?? $body;
  return trim($body);
}

function excerpt(string $text, int $len = 220): string {
  if (mb_strlen($text) <= $len) return $text;
  return mb_substr($text, 0, $len) . '…';
}

/**
 * Build a slug for a file.
 * - posts/pages: basename without .md
 * - docs: relative path within content/docs (keeps nested structure)
 */
function buildSlug(string $type, SplFileInfo $file, string $dir): string {
  $path = $file->getRealPath();
  if (!$path) return $file->getBasename('.md');

  if ($type !== 'docs') {
    return $file->getBasename('.md');
  }

  // docs: keep nested path (relative to docs dir)
  $dirReal = realpath($dir);
  if (!$dirReal) return $file->getBasename('.md');

  $dirReal = rtrim($dirReal, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
  $rel = str_starts_with($path, $dirReal) ? substr($path, strlen($dirReal)) : $file->getBasename();
  $rel = preg_replace('/\.md$/i', '', $rel) ?? $rel;
  $rel = str_replace('\\', '/', $rel);

  return trim($rel, '/');
}

$index = [];
$total = 0;

foreach ($contentDirs as $type => $dir) {
  if (!is_dir($dir)) continue;

  $it = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
  );

  foreach ($it as $file) {
    /** @var SplFileInfo $file */
    if (!$file->isFile()) continue;
    if (strtolower($file->getExtension()) !== 'md') continue;

    $path = $file->getRealPath();
    if (!$path) continue;

    $raw = file_get_contents($path);
    if ($raw === false) continue;

    [$meta, $body] = parseFrontMatter($raw);

    $slug  = buildSlug($type, $file, $dir);
    $title = (string)($meta['title'] ?? $slug);
    $date  = (string)($meta['date'] ?? '');
    $desc  = (string)($meta['description'] ?? '');

    $text = cleanToText($body);
    if ($desc === '') $desc = excerpt($text, 180);

    // URL mapping per type
    if ($type === 'posts') {
      $url = "/posts/{$slug}";
    } elseif ($type === 'docs') {
      $url = "/docs/{$slug}";
    } else { // pages
      $url = "/{$slug}";
      if ($slug === 'home') $url = "/";
    }

    $index[] = [
      'type' => $type,               // posts | pages | docs
      'title' => $title,
      'slug' => $slug,
      'url' => $url,
      'date' => $date,
      'description' => $desc,
      'text' => $text,
    ];

    $total++;
  }
}

usort($index, function($a, $b) {
  $ad = strtotime((string)($a['date'] ?? '')) ?: 0;
  $bd = strtotime((string)($b['date'] ?? '')) ?: 0;
  return $bd <=> $ad;
});

@mkdir(dirname($outFile), 0755, true);

$json = json_encode($index, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
if ($json === false) { fwrite(STDERR, "JSON encode failed\n"); exit(1); }

if (file_put_contents($outFile, $json) === false) {
  fwrite(STDERR, "Write failed: {$outFile}\n");
  exit(1);
}

echo "Wrote {$total} items to {$outFile}\n";
