<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_SESSION['user'])) {
    header("Location: views/dashboard.php");
} else {
    header("Location: views/login.php");
}
exit;
?>
