<?php
declare(strict_types=1);

/**
 * Posts index template
 *
 * Expected variables:
 * - $posts (array)
 */
?>

<h1>Posts</h1>

<?php if (empty($posts)): ?>
    <p>No posts yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
<a href="/posts/<?= htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8') ?>">
    <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
</a>

<?php if (!empty($post['date'])): ?>
    <small>
        <?= htmlspecialchars(
            date('M j, Y', strtotime($post['date']))
        ) ?>
    </small>
<?php endif; ?>
                <?php if (!empty($post['excerpt'])): ?>
                    <p><?= htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
