<?php
session_start();
include_once '../controllers/ProductController.php';
require_once '../init.php';

$productController = new ProductController();
$products = $productController->getProducts();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            background-image: url('../assets/images/back5.jpg'); /* Ajusta esta ruta a la ubicación de tu imagen */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: calc(100vh - 56px); /* Ajusta este valor según la altura de tu header */
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .content-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            cursor: pointer; 
        }
    </style>
</head>
<body>
<?php include 'header.php';?>
<div class="main-content">
    <div class="container content-container">
        <h2 class="my-4">Nos produits</h2>
        <div class="row">
        <?php foreach($products as $product):?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../assets/images/<?php echo htmlspecialchars($product['image']);?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']);?>" data-bs-toggle="modal" data-bs-target="#imageModal-<?php echo $product['id'];?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']);?></h5>
                        <p class="card-text">$<?php echo number_format($product['price'], 2);?></p>
                        <form action="../controllers/CartController.php" method="GET">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="id" value="<?php echo $product['id'];?>">
                            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" style="width: 60px;">
                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="imageModal-<?php echo $product['id'];?>" tabindex="-1" aria-labelledby="imageModalLabel-<?php echo $product['id'];?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="../assets/images/<?php echo htmlspecialchars($product['image']);?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']);?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>