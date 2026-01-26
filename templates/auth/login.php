<h1><?= $title ?></h1>

<form action="" method="post">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" class="form-control" placeholder="exemple@gmail.com">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="************">
    </div>

    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
