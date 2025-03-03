<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once __DIR__ . "/../models/User.php";
include_once __DIR__ . "/../config/Database.php";

class AuthController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->userModel = new User($db);
    }

    public function register($username, $email, $password) {
        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->password = $password;

        $result = $this->userModel->register();

        if ($result == "success") {
            header("Location: ../views/login.php?success=registered");
            exit;
        } elseif ($result == "email_exists") {
            header("Location: ../views/register.php?error=email_taken");
            exit;
        } else {
            header("Location: ../views/register.php?error=failed");
            exit;
        }
    }

    public function login($email, $password) {
        $this->userModel->email = $email;
        $this->userModel->password = $password;

        $result = $this->userModel->login();

        if ($result == "success") {
            $_SESSION['user'] = $this->userModel->username;
            $_SESSION['user_id'] = $this->userModel->id;
            header("Location: ../views/dashboard.php");
            exit;
        } elseif ($result == "invalid_password") {
            header("Location: ../views/login.php?error=wrong_password");
            exit;
        } elseif ($result == "invalid_email") {
            header("Location: ../views/login.php?error=email_not_found");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../views/login.php");
        exit;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authController = new AuthController();

    if (isset($_POST["register"])) {
        $authController->register($_POST["username"], $_POST["email"], $_POST["password"]);
    }

    if (isset($_POST["login"])) {
        $authController->login($_POST["email"], $_POST["password"]);
    }
}

if (isset($_GET["logout"])) {
    $authController = new AuthController();
    $authController->logout();
}
?>
