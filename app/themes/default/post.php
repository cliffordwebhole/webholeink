<article>
    <h1><?= htmlspecialchars($meta['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h1>

    <?php if (!empty($meta['date'])): ?>
        <small><?= htmlspecialchars($meta['date'], ENT_QUOTES, 'UTF-8') ?></small>
    <?php endif; ?>

    <div class="post-content">
        <?= $content ?>
    </div>
</article>
