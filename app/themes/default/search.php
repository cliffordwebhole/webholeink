<?php
declare(strict_types=1);

$q = (string)($q ?? '');
$results = $results ?? [];
$error = (string)($error ?? '');
?>

<h1>Search</h1>

<form method="get" action="/search" style="margin: 1rem 0;">
    <input
        type="text"
        name="q"
        value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>"
        placeholder="Search posts and pages…"
        style="padding:.6rem; width:min(520px, 90%);"
    >
    <button type="submit" style="padding:.6rem 1rem;">Search</button>
</form>

<?php if ($error !== ''): ?>
    <p style="color:#f55;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<?php if ($q !== ''): ?>
    <p>Results for <strong><?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?></strong> (<?= is_array($results) ? count($results) : 0 ?>)</p>
<?php endif; ?>

<?php if ($q !== '' && empty($results)): ?>
    <p>No matches found.</p>
<?php endif; ?>

<?php if (!empty($results)): ?>
    <ul>
        <?php foreach ($results as $r): ?>
            <li style="margin-bottom: 1rem;">
                <a href="<?= htmlspecialchars((string)$r['url'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars((string)$r['title'], ENT_QUOTES, 'UTF-8') ?>
                </a>
                <?php if (!empty($r['date'])): ?>
                    <small style="display:block;opacity:.8;">
                        <?= htmlspecialchars((string)$r['date'], ENT_QUOTES, 'UTF-8') ?>
                    </small>
                <?php endif; ?>
                <?php if (!empty($r['description'])): ?>
                    <div style="margin-top:.25rem;opacity:.9;">
                        <?= htmlspecialchars((string)$r['description'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
