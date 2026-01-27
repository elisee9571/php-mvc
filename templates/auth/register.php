<div class="w-100 d-flex flex-column align-items-center justify-content-center">
    <h1><?= $title ?></h1>

    <form action="" method="post" class="w-50">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input id="username" name="username" type="text" class="form-control" placeholder="Exemple78">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="exemple@gmail.com">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" name="password" type="password" class="form-control" placeholder="************">
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
