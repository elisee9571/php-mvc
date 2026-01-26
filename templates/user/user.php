<h1><?= $title ?></h1>

<form action="" method="get">
    <input type="search" name="q" placeholder="Rechercher un utilisateur" value="<?= $_GET['q'] ?? '' ?>">
    <input type="submit" name="search" value="rechercher">
</form>

<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
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
