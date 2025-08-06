<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resto</title>

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="<?= BASE_URL . 'vendor/bootstrap/css/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= BASE_URL . 'vendor/bootstrap-icons/bootstrap-icons.css' ?>">

    <style>
        body {
            background-color: whitesmoke;
        }

        .header,
        .footer {
            background-color: #212529;
            color: white;
        }

        .header a,
        .footer a {
            color: white;
        }

        .header .bi,
        .footer .bi {
            color: black;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .dropdown-item-text {
            font-size: 0.85rem;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-outline-secondary {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-outline-secondary:hover {
            background-color: #dc3545;
            color: white;
        }

        .form-control-sm {
            height: calc(1.5em + .5rem + 2px);
        }
    </style>
</head>

<body>
    <header class="header sticky-top py-2 shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="/" class="logo text-white text-decoration-none d-flex align-items-center">
                <h1 class="sitename m-0">Resto</h1><span>.</span>
            </a>

            <nav class="d-flex align-items-center">
                <ul class="nav me-3">
                    <li class="nav-item"><a class="nav-link" href="/"><i class="bi bi-house-door fs-4"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="/historique"><i class="bi bi-tags fs-4"></i></a></li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/panier">
                            <i class="bi bi-cart-fill fs-4"></i>
                            <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/notifications">
                            <i class="bi bi-bell fs-4"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                        </a>
                    </li>
                </ul>

                <?php if (isset($_SESSION['user'])): ?>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-white" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2"><?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                            <i class="bi bi-person-circle fs-4"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                            <li>
                                <span class="dropdown-item-text">
                                    Connecté en tant que<br>
                                    <strong><?= htmlspecialchars($_SESSION['user']['nom']) ?></strong>
                                    <strong><?= htmlspecialchars($_SESSION['user']['prenom']) ?></strong>
                                </span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                <li><a class="dropdown-item" href="/admin"><i class="bi bi-gear me-2"></i>Admin</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <form action="/login" method="POST" class="d-flex align-items-center gap-2">
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" required>
                        <input type="password" name="password" class="form-control form-control-sm" placeholder="Mot de passe" required>
                        <button type="submit" class="btn btn-danger btn-sm">Connexion</button>
                    </form>
                    <a href="/register" class="btn btn-outline-secondary btn-sm ms-2">
                        <i class="bi bi-person-plus"></i> S'inscrire
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <footer class="footer py-4 mt-5">
        <div class="container text-center text-white">
            <div class="row gy-3">
                <div class="col-md-3">
                    <i class="bi bi-geo-alt"></i>
                    <p class="mb-0">A108 Adam Street, New York, NY 535022</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-telephone"></i>
                    <p class="mb-0">+1 5589 55488 55<br>info@example.com</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-clock"></i>
                    <p class="mb-0">Lun-Sam: 11h - 23h<br>Dimanche: fermé</p>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="text-white"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <small>&copy; <?= date('Y') ?> <strong>Resto</strong> - Tous droits réservés.</small>
        </div>
    </footer>

    <!-- JS Bootstrap -->
    <script src="<?= BASE_URL . 'vendor/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>

    <script>
        fetch('/panier/count')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count || 0;
            });
    </script>
</body>

</html>