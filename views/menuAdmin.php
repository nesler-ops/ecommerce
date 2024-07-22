<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Panneau d'administration</h1>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Utilisateurs</h5>
                        <p class="card-text">Gérer les utilisateurs du système.</p>
                        <a href="../controllers/AdminController.php?action=manageUsers" class="btn btn-primary">Gérer les utilisateurs</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produits</h5>
                        <p class="card-text">Gérer les produits de la boutique.</p>
                        <a href="../controllers/AdminController.php?action=manageProducts" class="btn btn-primary">Gérer les produits</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Panier</h5>
                        <p class="card-text">Voir et gérer les paniers d'achats.</p>
                        <a href="../controllers/AdminController.php?action=manageCartItems" class="btn btn-primary">Gérer les paniers</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="../controllers/AdminController.php?action=logout" class="btn btn-danger">Se déconnecter</a>
        </div>
    </div>
</body>
</html>
