<?php
/**
 * Posts index template
 *
 * Expects:
 * - $posts: array of post arrays from PostResolver
 */

?>
<h1>Posts</h1>

<?php if (empty($posts)): ?>
    <p>No posts yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <?php
                $title = $post['meta']['title'] ?? ucfirst($post['slug']);
                $date  = $post['meta']['date']  ?? '';
            ?>
            <li>
                <a href="/posts/<?= htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
                </a>
                <?php if ($date): ?>
                    <small><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></small>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
