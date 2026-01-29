<div class="d-flex align-items-center justify-content-between">
    <h1><?= $title ?></h1>

    <a href="/user" class="btn btn-outline-secondary">Retour</a>
</div>

<form action="" method="post" enctype="multipart/form-data">

    <img src="<?= htmlspecialchars($user->getPicture() ?? '/images/default-avatar.jpg') ?>"
         alt="Photo de profil"
         width="100"
         height="100"
         class="rounded-circle border"
         style="object-fit: cover;"/>

    <div class="mb-3">
        <label for="picture" class="form-label">Picture</label>
        <input id="picture" name="picture" type="file" accept="image/*" class="form-control">
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username" type="text" class="form-control" placeholder="Exemple78"
               value="<?= htmlspecialchars($user->getUsername()) ?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" class="form-control" placeholder="exemple@gmail.com"
               value="<?= htmlspecialchars($user->getEmail()) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>