<?php
declare(strict_types=1);

/**
 * Expected variables:
 * @var array<int,array<string,mixed>> $docs
 */

?>
<h1>Documentation</h1>

<ul class="docs-list">
<?php foreach ($docs as $doc): ?>
    <?php
        $title = $doc['title']
            ?? ($doc['meta']['title'] ?? ucfirst((string)$doc['slug']));
    ?>
    <li>
        <a href="<?= htmlspecialchars((string)$doc['url'], ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
