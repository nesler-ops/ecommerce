<?php
session_start();

include_once '../config/Database.php';
include_once '../classes/Admin.php';
include_once '../classes/User.php';
include_once '../classes/Product.php';
include_once '../classes/CartItem.php';
require_once '../init.php';

class AdminController {
    private $db;
    private $admin;
    private $user;
    private $product;
    private $cartItem;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->admin = new Admin($this->db);
        $this->user = new User($this->db);
        $this->product = new Product($this->db);
        $this->cartItem = new CartItem($this->db);
    }

    public function loginAdmin($email, $password) {
        $this->admin->email = htmlspecialchars(strip_tags($email));
        
        if ($this->admin->login()) {
            if (password_verify($password, $this->admin->password) || $password === $this->admin->password) {
                if ($password === $this->admin->password) {
                    $this->updatePassword($this->admin->id, $password);
                }
                
                $_SESSION['admin_id'] = $this->admin->id;
                $_SESSION['admin_email'] = $this->admin->email;
                return true;
            }
        }
        return false;
    }

    private function updatePassword($id, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admin SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function logoutAdmin() {
        session_unset();
        session_destroy();
        return true;
    }

    public function manageUsers() {
        $users = $this->user->read();
        include_once '../views/Admin/manage_users.php';
    }

    public function manageProducts() {
        $products = $this->product->read();
        include_once '../views/Admin/manage_products.php';
    }

    public function manageCartItems() {
        $cartItems = $this->cartItem->read();
        include_once '../views/Admin/manage_cart_items.php';
    }

    public function createProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->product->name = htmlspecialchars(strip_tags($_POST['name']));
            $this->product->price = htmlspecialchars(strip_tags($_POST['price']));
            $this->product->description = htmlspecialchars(strip_tags($_POST['description']));
            $this->product->image = $this->uploadImage($_FILES['image']);
            
            if ($this->product->create()) {
                header('Location: AdminController.php?action=manageProducts');
                exit();
            } else {
                $_SESSION['error'] = "Error al crear el producto.";
                include_once '../views/product_form.php';
            }
        } else {
            include_once '../views/product_form.php';
        }
    }
    
    public function editProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->product->id = $_POST['id'];
            $this->product->name = htmlspecialchars(strip_tags($_POST['name']));
            $this->product->price = htmlspecialchars(strip_tags($_POST['price']));
            $this->product->description = htmlspecialchars(strip_tags($_POST['description']));
            
            $existingProduct = $this->product->readOne($this->product->id);
            $this->product->image = $existingProduct['image'];
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadResult = $this->uploadImage($_FILES['image']);
                if ($uploadResult['success']) {
                    $this->product->image = $uploadResult['filename'];  // Guardamos solo el nombre del archivo
                } else {
                    $_SESSION['error'] = "Error al subir la nueva imagen: " . $uploadResult['message'];
                    $product = $existingProduct;
                    include_once '../views/Admin/product_form.php';
                    return;
                }
            }
    
            if ($this->product->update()) {
                $_SESSION['success'] = "Producto actualizado con éxito.";
                header('Location: AdminController.php?action=manageProducts');
                exit();
            } else {
                $_SESSION['error'] = "Error al actualizar el producto.";
                $product = $existingProduct;
                include_once '../views/product_form.php';
            }
        } else if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $product = $this->product->readOne($id);
            include_once '../views/Admin/product_form.php';
        } else {
            header('Location: AdminController.php?action=manageProducts');
            exit();
        }
    }     

    public function deleteProduct() {
        $id = $_GET['id'];
        if ($this->product->delete($id)) {
            header('Location: AdminController.php?action=manageProducts');
            exit();
        } else {
            $_SESSION['error'] = "Error al eliminar el producto.";
            header('Location: AdminController.php?action=manageProducts');
            exit();
        }
    }

    private function uploadImage($file) {
        $target_dir = "../assets/images/";
        $filename = basename($file["name"]);
        $target_file = $target_dir . $filename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
        $check = getimagesize($file["tmp_name"]);
        if($check === false) {
            $uploadOk = 0;
        }
    
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
    
        if ($file["size"] > 500000) {
            $uploadOk = 0;
        }
    
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
            return ['success' => false, 'message' => "Lo siento, tu archivo no fue subido."];
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return ['success' => true, 'filename' => $filename];  // Retornamos solo el nombre del archivo
            } else {
                return ['success' => false, 'message' => "Lo siento, hubo un error subiendo tu archivo."];
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['action'])) {
    $adminController = new AdminController();

    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        switch ($action) {
            case 'login':
                $email = $_POST['email'];
                $password = $_POST['password'];
                
                if ($adminController->loginAdmin($email, $password)) {
                    header('Location: ../views/menuAdmin.php');
                    exit();
                } else {
                    header('Location: ../views/admin_login.php?error=Login%20fallido');
                    exit();
                }
                break;
            case 'logout':
                $adminController->logoutAdmin();
                header('Location: ../index.php');
                exit();
                break;
            case 'manageUsers':
                $adminController->manageUsers();
                break;
            case 'manageProducts':
                $adminController->manageProducts();
                break;
            case 'manageCartItems':
                $adminController->manageCartItems();
                break;
            case 'createProduct':
                $adminController->createProduct();
                break;
            case 'editProduct':
                $adminController->editProduct();
                break;
            case 'deleteProduct':
                $adminController->deleteProduct();
                break;
        }
    }
}
?>