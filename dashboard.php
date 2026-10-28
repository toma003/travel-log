<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Travel Log</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="auth-container" style="max-width: 600px;">
    <!-- <h2>Welcome to Travel Log, <?php echo htmlspecialchars($_SESSION['username']); ?>! 🎉</h2> -->
    <h2> Welcome to Travel Log, <?= htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['username'] ?? 'Explorer') ?>! 🎉 </h2>
    <p style="text-align: center; margin-bottom: 20px;">You are now securely logged in.</p>
    <a href="logout.php" class="btn" style="display: block; text-align: center; text-decoration: none; background-color: #dc3545;">Logout</a>
</div>

</body>
</html>