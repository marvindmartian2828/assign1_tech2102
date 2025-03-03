<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Login</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="auth-error">
                <?php 
                    if ($_GET['error'] == 'wrong_password') echo "❌ Incorrect password!";
                    if ($_GET['error'] == 'email_not_found') echo "❌ Email not registered!";
                ?>
            </p>
        <?php endif; ?>

        <form action="../controller/AuthController.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="auth-btn">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
