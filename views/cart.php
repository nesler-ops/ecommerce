<?php
include_once '../controllers/CartController.php';
require_once '../init.php';

$cartController = new CartController();
$cartItems = $cartController->getCartItems();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chariot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../assets/images/back6.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2>Chariot</h2>
    <?php if (empty($cartItems)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <form action="../controllers/CartController.php" method="GET">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control" style="width: 60px;">
                            <button type="submit" class="btn btn-sm btn-primary">Mise à jour</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td>
                        <a href="../controllers/CartController.php?action=remove&id=<?php echo $item['product_id']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>$<?php echo number_format($cartController->getTotal(), 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>
        <!-- <a href="checkout.php" class="btn btn-primary">Procéder au paiement</a> -->
        <a href="../success.php" class="btn btn-primary">Procéder au paiement</a>
        <a href="../controllers/CartController.php?action=clear" class="btn btn-warning">Vider le panier</a>
    <?php endif; ?>
    <a href="product.php" class="btn btn-secondary">Continuer à acheter</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>