<?php
ob_start();
session_start();
require_once 'config/db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        // Check if user already exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        
        if ($check->rowCount() > 0) {
            $_SESSION['auth_error'] = "An account with this email already exists.";
            header("Location: register.php");
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            
            if ($stmt->execute([$name, $email, $hashed_password])) {
                $_SESSION['auth_success'] = "Account created successfully! Please sign in.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['auth_error'] = "Registration failed. Please try again.";
                header("Location: register.php");
                exit();
            }
        }
    } else {
        $_SESSION['auth_error'] = "Please fill in all required fields.";
        header("Location: register.php");
        exit();
    }
}

// Extract session errors/success messages if set
$error = $_SESSION['auth_error'] ?? '';
unset($_SESSION['auth_error']);

$success = $_SESSION['auth_success'] ?? '';
unset($_SESSION['auth_success']);

// Reusable Header Configuration
$page_title = "Create Account";
$extra_css = "style.css";
$hide_navbar = true;
include 'includes/header.php';
?>

<div class="split-container">

    <!-- LEFT SIDE: Scenic Hero Section -->
    <div class="left-hero">
        <h1 class="hero-title">Every Journey<br>Tells a Story</h1>
        
        <div class="hero-caption-wrapper">
            <p class="hero-caption">Document your trips, log interactive map pins, and store travel memories securely in one place.</p>
            
            <div class="hero-features">
                <span class="feature-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                    </svg>
                    Explore places
                </span>
                
                <span class="feature-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.72-8.72 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    Save favorites
                </span>
                
                <span class="feature-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                    </svg>
                    Remember every journey
                </span>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: Registration Form -->
    <div class="right-form-panel">
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Create an Account</h2>
                <p>Fill in your details below to get started</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert-box alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert-box alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <div class="input-wrapper">
                        <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Create a password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 1rem;">Create Account</button>
            </form>

            <div class="auth-switch">
                Already have an account? <a href="login.php">Sign In</a>
            </div>

            <div class="divider">
                <span>Or continue with</span>
            </div>

            <div class="social-buttons">
                <a href="#" class="btn-social">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                    Google
                </a>
            </div>
        </div>
    </div>

</div>

<script>
function togglePasswordVisibility(fieldId = 'password') {
    const passwordInput = document.getElementById(fieldId);
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>