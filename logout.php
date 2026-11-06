<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    // Clear remember token in MySQL using PDO
    $stmt = $pdo->prepare("UPDATE users SET remember_token = NULL, token_expires = NULL WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}

// Expire the remember_token cookie in the browser
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, "/");
}

// Unset all session variables and destroy the session
session_unset();
session_destroy();

// Redirect to login/signup page
header("Location: index.php");
exit();
?>