<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    // Clear token in MySQL
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL, token_expires = NULL WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

// Expire cookie
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, "/");
}

session_unset();
session_destroy();

header("Location: index.php");
exit();
?>