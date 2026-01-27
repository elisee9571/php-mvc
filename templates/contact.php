<div class="w-100 d-flex flex-column align-items-center justify-content-center">
    <h1><?= $title ?></h1>

    <form action="" method="post" class="w-75">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="example@gmail.com">
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Sujet</label>
            <select id="subject" name="subject" class="form-select">
                <option value="" selected disabled>Choisir un sujet</option>
                <option value="help">Aide</option>
                <option value="bug">Bug</option>
                <option value="refund">Remboursement</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea id="message" name="message" class="form-control" rows="3"
                      placeholder="Saisir votre message"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <h2>Message de contact</h2>
        <p>Email : <?= $email ?></p>
        <p>Sujet : <?= $subject ?></p>
        <p>Message : <?= $message ?></p>
    <?php endif; ?>
</div>
