<?php
/**
 * Theme Navigation Template
 *
 * Receives:
 * - $navigation (array of [label, path])
 */

if (empty($navigation) || !is_array($navigation)) {
    return;
}
?>

<nav>
    <ul>
        <?php foreach ($navigation as $item): ?>
            <li>
                <a href="<?= htmlspecialchars($item['path'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
