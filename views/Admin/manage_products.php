<?php
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
    <title>Gestion des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestion des produits</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo substr($product['description'], 0, 50) . '...'; ?></td>
                    <td><img src="<?php echo '../assets/images/' . basename($product['image']); ?>" alt="<?php echo $product['name']; ?>" width="50"></td>
                    <td>
                        <a href="../controllers/AdminController.php?action=editProduct&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Modifier</a>
                        <a href="../controllers/AdminController.php?action=deleteProduct&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../controllers/AdminController.php?action=createProduct" class="btn btn-success">Créer un nouveau produit</a>
        <a href="../views/menuAdmin.php" class="btn btn-secondary">Retour au menu</a>
    </div>
</body>
</html>
