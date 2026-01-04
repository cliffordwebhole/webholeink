<?php
/**
 * Default Home Template
 *
 * Variables provided:
 * - $page   : array (optional metadata)
 * - $html   : string (rendered Markdown HTML)
 *
 * This file MUST NOT:
 * - call layout
 * - render navigation
 * - echo headers
 * - assume globals
 */

declare(strict_types=1);

?>

<h1><?= htmlspecialchars($meta['title'] ?? 'Home', ENT_QUOTES, 'UTF-8') ?></h1>

<?= $content ?>
