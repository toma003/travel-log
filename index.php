<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

// Auto-login via "Remember Me" Cookie if session doesn't exist yet
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $raw_token = $_COOKIE['remember_token'];
    $hashed_token = hash('sha256', $raw_token);

    if (isset($conn) && $conn instanceof mysqli) {
        $stmt = $conn->prepare("SELECT id, full_name FROM users WHERE remember_token = ? AND token_expires > NOW()");
        if ($stmt) {
            $stmt->bind_param("s", $hashed_token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($user = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'] ?? 'Explorer';
            }
            $stmt->close();
        }
    }
}

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = $_SESSION['auth_error'] ?? '';
$success = $_SESSION['auth_success'] ?? '';
unset($_SESSION['auth_error'], $_SESSION['auth_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css?v=1.8">
    <!-- <link rel="stylesheet" href="css/style.css?v=1.1"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Near Nature Spots - Travel Log</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Google Identity Services Library -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    Explore places
                </span>
                
                <span class="feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
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

    <!-- RIGHT SIDE: Actual Login Form -->
    <div class="right-form-panel">
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Sign in to continue your journey</p>
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
                        <input type="checkbox" name="remember" value="1"> Remember me
                    </label>
                </div>

                <button type="submit" class="btn-primary">Sign In</button>
            </form>

            <div class="auth-switch">
                Don't have an account? <a href="#" id="openSignUpBtn">Sign Up</a>
            </div>

            <div class="divider">
                <span>Or continue with</span>
            </div>

            <div class="social-buttons">
                <button type="button" class="btn-social" onclick="triggerGoogleSignIn()">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                    Google
                </button>
            </div>
        </div>
    </div>

</div>

<!-- SIGN UP POPUP MODAL -->
<div class="modal-overlay" id="signUpModal">
    <div class="modal-card">
        <button class="modal-close" id="closeSignUpBtn">&times;</button>
        <div class="form-header">
            <h2>Create Account</h2>
            <p>Sign up to start logging your journeys</p>
        </div>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="reg_full_name">Full Name</label>
                <div class="input-wrapper">
                    <input type="text" id="reg_full_name" name="full_name" placeholder="Enter your full name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="reg_email">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="reg_email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="reg_password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="reg_password" name="password" placeholder="Create a password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('reg_password')">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember" value="1"> Remember me
                </label>
            </div>

            <button type="submit" class="btn-primary">Sign Up</button>
        </form>

        <div class="auth-switch">
            Already have an account? <a href="#" id="openSignInBtn">Sign In</a>
        </div>

        <div class="divider">
            <span>Or access quickly with</span>
        </div>

        <div class="social-buttons">
            <button type="button" class="btn-social" onclick="triggerGoogleSignIn()">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                Google
            </button>
        </div>
    </div>
</div>

<script>
// Google Sign-In Setup
const GOOGLE_CLIENT_ID = "751897549855-6p8gfuvr1848mrn2g3v7lpj8dombdj49.apps.googleusercontent.com";

function triggerGoogleSignIn() {
    google.accounts.id.initialize({
        client_id: GOOGLE_CLIENT_ID,
        callback: handleGoogleResponse
    });
    google.accounts.id.prompt();
}

function handleGoogleResponse(response) {
    fetch('google-callback.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ credential: response.credential })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'dashboard.php';
        } else {
            alert(data.message || 'Google sign-in failed.');
        }
    })
    .catch(err => console.error('Error:', err));
}

// Password Visibility Toggle & Modal Handlers
function togglePasswordVisibility(fieldId = 'password') {
    const passwordInput = document.getElementById(fieldId);
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}

const modal = document.getElementById('signUpModal');
const openBtn = document.getElementById('openSignUpBtn');
const closeBtn = document.getElementById('closeSignUpBtn');
const openSignInBtn = document.getElementById('openSignInBtn');

openBtn.addEventListener('click', (e) => {
    e.preventDefault();
    modal.classList.add('active');
});

closeBtn.addEventListener('click', () => {
    modal.classList.remove('active');
});

openSignInBtn.addEventListener('click', (e) => {
    e.preventDefault();
    modal.classList.remove('active');
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.remove('active');
    }
});
</script>

</body>
</html>