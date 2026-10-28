<?php
ob_start();
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Check if remember checkbox is checked
    $remember = isset($_POST['remember']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'] ?? $email;

                // Handle Remember Me token generation & cookie
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $hashed_token = hash('sha256', $token);
                    $expiry = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 Days

                    $update_stmt = $conn->prepare("UPDATE users SET remember_token = ?, token_expires = ? WHERE id = ?");
                    if ($update_stmt) {
                        $update_stmt->bind_param("ssi", $hashed_token, $expiry, $user['id']);
                        $update_stmt->execute();
                        $update_stmt->close();
                    }

                    // Save cookie in browser
                    setcookie('remember_token', $token, time() + (86400 * 30), "/", "", false, true);
                }

                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['auth_error'] = "Invalid password. Please try again.";
            }
        } else {
            $_SESSION['auth_error'] = "No account found with this email.";
        }
        $stmt->close();
    } else {
        $_SESSION['auth_error'] = "Please fill in all required fields.";
    }

    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Travel Log</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

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

    <!-- RIGHT SIDE: Clean Form -->
    <div class="right-form-panel">
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Enter your email and password to access your account</p>
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

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <span>Forgot password? <a href="#">Reset it</a></span>
                </div>

                <button type="submit" class="btn-primary">Sign In</button>
            </form>

            <div class="auth-switch">
                Don't have an account? <a href="index.php">Sign Up</a>
            </div>

            <div class="divider">
                <span>Or continue with</span>
            </div>

            <div class="social-buttons">
                <a href="#" class="btn-social">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                    Google
                </a>
                <a href="#" class="btn-social">
                    <svg width="16" height="16" fill="#1877F2" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
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