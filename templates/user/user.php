<?php
$size = (int)($_GET['size'] ?? 5);
$page = (int)($_GET['page'] ?? 1);
$q = $_GET['q'] ?? '';
$totalPages = (int)ceil($count / $size);

function pageUrl(int $targetPage): string
{
    $params = $_GET;            // garde tout (q, size, etc.)
    $params['page'] = $targetPage;
    return '?' . http_build_query($params);
}

?>

<h1><?= $title ?></h1>

<!-- search -->
<div class="d-flex flex-row align-items-center justify-content-between gap-3 mb-3">
    <form action="" method="get" id="searchForm" class="d-flex align-items-center gap-2 mb-0">
        <input type="search" name="q" class="form-control" placeholder="Search user" value="<?= $q ?>" style="width: 300px">
        <button type="submit" class="btn btn-primary">Search</button>

        <select name="size" class="form-select w-auto">
            <option value="5" <?= $size === 5 ? 'selected' : '' ?>>5</option>
            <option value="10" <?= $size === 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?= $size === 20 ? 'selected' : '' ?>>20</option>
        </select>

        <input type="hidden" name="page" value="1">
    </form>

    <nav aria-label="pagination">
        <ul class="pagination mb-0">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page <= 1 ? '#' : pageUrl($page - 1) ?>">Previous</a>
            </li>

            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);

            if ($start > 1) {
                echo '<li class="page-item"><a class="page-link" href="' . pageUrl(1) . '">1</a></li>';
                if ($start > 2) {
                    echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                }
            }

            for ($i = $start; $i <= $end; $i++) {
                $active = $i === $page ? 'active' : '';
                echo '<li class="page-item ' . $active . '">';
                echo '<a class="page-link" href="' . pageUrl($i) . '"' . ($active ? ' aria-current="page"' : '') . '>' . $i . '</a>';
                echo '</li>';
            }

            if ($end < $totalPages) {
                if ($end < $totalPages - 1) {
                    echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                }
                echo '<li class="page-item"><a class="page-link" href="' . pageUrl($totalPages) . '">' . $totalPages . '</a></li>';
            }
            ?>

            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page >= $totalPages ? '#' : pageUrl($page + 1) ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<!-- list in table -->
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Date de création</th>
        <th scope="col">Date de modification</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>

    <?php if (count($users) > 0): ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <th scope="row"><?= $user->getId() ?></th>
                <td><?= $user->getUsername() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getCreatedAt()->format('d/m/Y H:i') ?></td>
                <td><?= $user->getUpdatedAt()->format('d/m/Y H:i') ?></td>
                <td>
                    <a href="/user/<?= $user->getId() ?>" class="btn btn-secondary">Voir</a>
                    <a href="/user/<?= $user->getId() ?>/edit" class="btn btn-secondary">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <th colspan="4">Aucun enregistrement</th>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
