<div class="d-flex align-items-center justify-content-between">
    <h1><?= $title ?></h1>

    <a href="/user" class="btn btn-outline-secondary">Retour</a>
</div>

<div class="row justify-content-center">
    <div>
        <div>
            <div class="d-flex align-items-center gap-3 mb-3">
                <img src="<?= htmlspecialchars($user->getPicture() ?: '/images/default-avatar.jpg') ?>"
                     alt="Photo de profil"
                     width="100"
                     height="100"
                     class="rounded-circle border"
                     style="object-fit: cover;"
                />

                <div>
                    <h2 class="h4 mb-1"><?= htmlspecialchars($user->getUsername()) ?></h2>
                    <div class="text-muted"><?= htmlspecialchars($user->getEmail()) ?></div>
                    <div class="small text-muted">ID: <?= (int)$user->getId() ?></div>
                </div>
            </div>

            <hr>

            <dl class="row mb-0">
                <dt class="col-4">Nom d’utilisateur</dt>
                <dd class="col-8 mb-2"><?= htmlspecialchars($user->getUsername()) ?></dd>

                <dt class="col-4">Email</dt>
                <dd class="col-8 mb-2">
                    <a href="mailto:<?= htmlspecialchars($user->getEmail()) ?>">
                        <?= htmlspecialchars($user->getEmail()) ?>
                    </a>
                </dd>
            </dl>
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <a href="/user/<?= (int)$user->getId() ?>/edit" class="btn btn-primary">Modifier</a>
        </div>
    </div>
</div>