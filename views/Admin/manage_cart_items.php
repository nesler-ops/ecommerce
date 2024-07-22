<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ítems del Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Ítems del Carrito</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario ID</th>
                    <th>Producto ID</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['user_id']; ?></td>
                    <td><?php echo $item['product_id']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>
                        <a href="../controllers/AdminController.php?action=editCartItem&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="../controllers/AdminController.php?action=deleteCartItem&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este ítem del carrito?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../controllers/AdminController.php?action=createCartItem" class="btn btn-success">Crear Nuevo Ítem de Carrito</a>
        <a href="menuAdmin.php" class="btn btn-secondary">Volver al Menú</a>
    </div>
</body>
</html>