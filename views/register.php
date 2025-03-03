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
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Register</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="auth-error">
                <?php 
                    if ($_GET['error'] == 'email_taken') echo "❌ Email already registered!";
                    if ($_GET['error'] == 'failed') echo "❌ Registration failed!";
                ?>
            </p>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
            <p class="auth-success">✅ Registration successful! You can now log in.</p>
        <?php endif; ?>

        <form action="../controller/AuthController.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register" class="auth-btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
