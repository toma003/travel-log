<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' — Travel Log' : 'Travel Log — Map & Memories'; ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Links -->
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/navbar.css?v=<?php echo time(); ?>">
    <?php if (isset($extra_css)): ?>
        <link rel="stylesheet" href="css/<?php echo htmlspecialchars($extra_css); ?>?v=<?php echo time(); ?>">
    <?php endif; ?>
</head>

<body>

    <?php if (!isset($hide_navbar) || !$hide_navbar): ?>
        <nav class="navbar">
            <div class="navbar-container">
                <!-- Brand -->
                <a href="index.php" class="nav-brand">
                    <img src="images/logo.png" alt="Travel Log Logo" class="brand-logo-img">
                    <span class="brand-title-text">Travel<span class="logo-accent">Log</span></span>
                </a>

                <!-- Hamburger Button (Mobile & Tablet) -->
                <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Responsive Collapsible Menu -->
                <div class="nav-menu" id="navMenu">
                    <!-- Nav Links -->
                    <div class="nav-center-links">
                        <a href="#features">Features</a>
                        <a href="#how-it-works">How It Works</a>
                        <a href="#about">About</a>
                    </div>

                    <!-- Action Links -->
                    <div class="nav-right-actions">
                        <a href="login.php" class="btn-signin">Log In</a>
                        <a href="register.php" class="btn-signup-pill">Sign Up</a>
                    </div>
                </div>
            </div>
        </nav>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const navToggle = document.getElementById('navToggle');
                const navMenu = document.getElementById('navMenu');

                if (navToggle && navMenu) {
                    navToggle.addEventListener('click', function () {
                        navToggle.classList.toggle('open');
                        navMenu.classList.toggle('open');
                    });
                }
            });
        </script>
    <?php endif; ?>