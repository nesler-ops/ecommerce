<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$product = isset($product) ? $product : null;
$action = $product ? 'updateProduct' : 'createProduct';
$title = $product ? 'Modifier le produit' : 'Créer un nouveau produit';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo $title; ?></h1>
        <form action="../controllers/AdminController.php?action=editProduct" method="POST" enctype="multipart/form-data">
    <?php if ($product): ?>
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <?php endif; ?>
            
            <div class="mb-3">
                <label for="name" class="form-label">Nom du produit</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product ? htmlspecialchars($product['name']) : ''; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $product ? $product['price'] : ''; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $product ? htmlspecialchars($product['description']) : ''; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Image du produit</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" <?php echo $product ? '' : 'required'; ?>>
                <?php if ($product && $product['image']): ?>
                    <div class="mt-2">
                        <p>Image actuelle:</p>
                        <img src="<?php echo '../assets/images/' . basename($product['image']); ?>" alt="<?php echo $product['name']; ?>" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary"><?php echo $product ? 'Mettre à jour' : 'Créer'; ?> Produit</button>
    <a href="../controllers/AdminController.php?action=manageProducts" class="btn btn-secondary">Annuler</a>
</form>
    </div>
</body>
</html>
