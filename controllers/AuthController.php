<?php
session_start();

include_once '../config/Database.php';
include_once '../classes/User.php';
require_once '../init.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function registerUser($username, $password, $email) {
        $this->user->username = htmlspecialchars(strip_tags($username));
        $this->user->email = htmlspecialchars(strip_tags($email));
        $this->user->password = password_hash($password, PASSWORD_DEFAULT);
        return $this->user->register();
    }

    public function loginUser($email, $password) {
        $this->user->email = htmlspecialchars(strip_tags($email));
        $userData = $this->user->getUserByEmail();
        if ($userData) {
            if (password_verify($password, $userData['password'])) {
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['username'] = $userData['username'];
                return true;
            }
        }
        return false;
    }

    public function logoutUser() {
        session_unset();
        session_destroy();
        return true;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['action'])) {
    $authController = new AuthController();

    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        switch ($action) {
            case 'login':
                $email = $_POST['email'];
                $password = $_POST['password'];
                if ($authController->loginUser($email, $password)) {
                    header('Location: ../index_welcome.php');
                    exit();
                } else {
                    header('Location: ../views/login.php?error=Login%20fallido');
                    exit();
                }
                break;
            case 'register':
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                if ($authController->registerUser($username, $password, $email)) {
                    header('Location: ../views/login.php?success=Registro%20exitoso');
                    exit();
                } else {
                    header('Location: ../views/register.php?error=Registro%20fallido');
                    exit();
                }
                break;
            case 'logout':
                $authController->logoutUser();
                header('Location: ../index.php');
                exit();
                break;
        }
    }
}
?>