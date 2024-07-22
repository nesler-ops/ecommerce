<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/images/back.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            padding-top: 5rem;
        }
        .jumbotron {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 0.3rem;
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .admin-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #ffffff;
            font-size: 1.5rem;
            transition: color 0.3s ease;
            z-index: 1100;
        }
        .admin-icon:hover {
            color: #007bff;
        }
    </style>
</head>
<body>

<a href="views/admin_login.php" class="admin-icon" title="Admin Login">
    <i class="fas fa-cog"></i>
</a>

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
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="views/login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/register.php">S'inscrire</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="views/cart.php">Panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controllers/AuthController.php?action=logout">Déconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Bienvenue sur notre boutique en ligne</h1>
        <p class="lead">Découvrez notre sélection exceptionnelle de produits.</p>
        <hr class="my-4">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p>Connectez-vous pour commencer votre expérience de shopping !</p>
            <a class="btn btn-primary btn-lg" href="views/login.php" role="button">Connexion</a>
            <a class="btn btn-secondary btn-lg" href="views/register.php" role="button">S'inscrire</a>
        <?php else: ?>
            <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> ! Prêt à explorer nos produits ?</p>
            <a class="btn btn-primary btn-lg" href="views/product.php" role="button">Voir les produits</a>
        <?php endif; ?>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>