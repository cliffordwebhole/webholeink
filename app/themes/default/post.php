<?php
/** @var string $title */
/** @var string|null $date */
/** @var string $content */
?>

<article>
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

    <?php if (!empty($date)): ?>
        <small><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></small>
    <?php endif; ?>

    <div class="post-content">
        <?= $content ?>
    </div>
</article>
