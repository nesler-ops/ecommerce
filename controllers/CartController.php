<?php
session_start();

include_once '../config/Database.php';
include_once '../classes/CartItem.php';
include_once '../controllers/ProductController.php';
require_once '../init.php';

class CartController {
    private $cartItem;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cartItem = new CartItem($this->db);
    }

    public function addProductToCart($productId, $quantity) {
        if (!isset($_SESSION['user_id'])) {
            return false; // User not logged in
        }

        $this->cartItem->user_id = $_SESSION['user_id'];
        $this->cartItem->product_id = $productId;
        $this->cartItem->quantity = $quantity;

        return $this->cartItem->addToCart();
    }

    public function removeProductFromCart($productId) {
        if (!isset($_SESSION['user_id'])) {
            return false; // User not logged in
        }

        $this->cartItem->user_id = $_SESSION['user_id'];
        $this->cartItem->product_id = $productId;

        return $this->cartItem->removeFromCart();
    }

    public function updateProductQuantity($productId, $quantity) {
        if (!isset($_SESSION['user_id'])) {
            return false; // User not logged in
        }

        $this->cartItem->user_id = $_SESSION['user_id'];
        $this->cartItem->product_id = $productId;
        $this->cartItem->quantity = $quantity;

        return $this->cartItem->updateQuantity();
    }

    public function getCartItems() {
        if (!isset($_SESSION['user_id'])) {
            return []; // User not logged in
        }

        $stmt = $this->cartItem->getCartItems($_SESSION['user_id']);
        $cartItems = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cartItems[] = $row;
        }

        return $cartItems;
    }

    public function clearCart() {
        if (!isset($_SESSION['user_id'])) {
            return false; // User not logged in
        }

        return $this->cartItem->clearCart($_SESSION['user_id']);
    }

    public function getTotal() {
        $total = 0;
        $cartItems = $this->getCartItems();

        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }
}

if (isset($_GET['action'])) {
    $cartController = new CartController();
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            if (isset($_GET['id']) && isset($_GET['quantity'])) {
                $cartController->addProductToCart($_GET['id'], $_GET['quantity']);
            }
            break;
        case 'remove':
            if (isset($_GET['id'])) {
                $cartController->removeProductFromCart($_GET['id']);
            }
            break;
        case 'update':
            if (isset($_GET['id']) && isset($_GET['quantity'])) {
                $cartController->updateProductQuantity($_GET['id'], $_GET['quantity']);
            }
            break;
        case 'clear':
            $cartController->clearCart();
            break;
    }
    header('Location: ../views/cart.php');
}
?>