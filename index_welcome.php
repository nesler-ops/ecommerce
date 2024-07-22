<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: views/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/images/back2.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            padding-top: 5rem;
        }
        .welcome-card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 0.3rem;
            padding: 2rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Hard-Rock!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="views/product.php">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="views/cart.php">Panier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="controllers/AuthController.php?action=logout">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="welcome-card text-center">
                <h1 class="mb-4">Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p class="lead mb-4">Merci de vous être connecté à notre boutique en ligne.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="views/product.php" class="btn btn-primary btn-lg">Voir les produits</a>
                    <a href="views/cart.php" class="btn btn-warning btn-lg">Voir Panier d'achat</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>