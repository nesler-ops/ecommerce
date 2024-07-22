<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Hard Rock'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #007bff !important;
        }
        .nav-link {
            color: #333 !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #007bff !important;
        }
        .navbar-nav .nav-link.active {
            color: #007bff !important;
            border-bottom: 2px solid #007bff;
        }
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
        .admin-icon {
            color: #6c757d;
            transition: color 0.3s ease;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        .admin-icon:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a href="admin_login.php" class="admin-icon" title="Admin Login">
            <i class="fas fa-cog"></i>
        </a>
        <a class="navbar-brand" href="../index.php">
            <i class="fas fa-store me-2"></i>Hard Rock!
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/product.php' ? 'active' : ''); ?>" href="product.php">
                        <i class="fas fa-box me-1"></i>Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/cart.php' ? 'active' : ''); ?>" href="cart.php">
                        <i class="fas fa-shopping-cart me-1"></i>Chariot
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary ms-2" href="../controllers/AuthController.php?action=logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Se déconnecter
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/login.php' ? 'active' : ''); ?>" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Commencer la session
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/register.php' ? 'active' : ''); ?> btn btn-outline-primary ms-2" href="register.php">
                            <i class="fas fa-user-plus me-1"></i>S'inscrire
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>