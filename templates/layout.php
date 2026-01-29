<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function navActive(string $path): string
{
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Home: actif uniquement sur la page racine
    if ($path === '/') {
        return $currentPath === '/' ? 'active' : '';
    }

    // Autres liens: actif si l'URL commence par le path
    return str_starts_with($currentPath, $path) ? 'active' : '';
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $title ?? 'Mon Site' ?></title>

    <link rel="stylesheet" href="/assets/css/reset.css">
    <link rel="stylesheet" href="/assets/css/main.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Navbar</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                 aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= navActive('/') ?>" aria-current="page" href="/">Home</a>
                        </li>

                        <?php if (isset($_SESSION['username'])): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= navActive('/user') ?>" href="/user">User</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link <?= navActive('/contact') ?>" href="/contact">Contact</a>
                        </li>
                    </ul>

                    <div class="d-grid gap-2 d-md-block">
                        <?php if (isset($_SESSION['username'])): ?>
                            <li class="btn-group w-100">
                                <button type="button" class="btn btn-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <?= $_SESSION['username'] ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="/user/<?= $_SESSION['userId'] ?>">Profil</a></li>
                                    <li><a class="dropdown-item" href="#">Setting</a></li>
                                    <li><a class="dropdown-item" href="#">Order</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <a class="btn btn-primary" href="/login">Login</a>
                            <a class="btn btn-secondary" href="/register">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="container py-5">
    <?= $contentFile ?>
</main>

<footer class="container-fluid row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
    <div class="col mb-3">
        <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none"
           aria-label="Bootstrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-bank2"
                 viewBox="0 0 16 16">
                <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z"/>
            </svg>
        </a>
        <p class="text-body-secondary">© <?= date('Y') ?></p>
    </div>
    <div class="col mb-3"></div>

    <div class="col mb-3"><h5>Section</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
        </ul>
    </div>
    <div class="col mb-3"><h5>Section</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
        </ul>
    </div>
    <div class="col mb-3"><h5>Section</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
        </ul>
    </div>
</footer>

<script src="/assets/js/filter-search.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>
