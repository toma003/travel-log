<?php
$page_title = "Map & Memories";
$extra_css = "landing.css";
include 'includes/header.php';
?>

<!-- 1. Hero Section -->
<section class="hero-section">
    <!-- Right Hero Image with True Edge-to-Edge Torn Paper Mask -->
    <div class="hero-right">
        <!-- Realistic torn paper backing with warm deckle shade -->
        <div class="torn-paper-backing"></div>
        
        <!-- Photo container with natural deckle ripped paper edge -->
        <div class="hero-img-mask">
            <img src="images/img12.jpg" alt="Travel Journal Cover" class="hero-bg-img">
        </div>
    </div>

    <!-- Left Content Container -->
    <div class="hero-container">
        <div class="hero-left">
            <h1 class="hero-heading">
                Every Journey<br>
                <span class="heading-accent">
                    Tells a Story.
                    <span class="artistic-double-underline">
                        <svg viewBox="0 0 280 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 4 11 C 70 3, 195 2, 276 9" stroke="#5E8B6E" stroke-width="3.5" stroke-linecap="round"/>
                            <path d="M 24 19 C 85 13, 155 12, 205 16" stroke="#7E9F88" stroke-width="2.2" stroke-linecap="round"/>
                        </svg>
                    </span>
                </span>
            </h1>

            <p class="hero-text">
                Document your trips, capture meaningful places, and preserve your travel memories — all in one personal space.
            </p>

            <div class="hero-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn-primary-pill">Start Logging — It's Free &rarr;</a>
                <?php else: ?>
                    <a href="register.php" class="btn-primary-pill">Start Logging — It's Free &rarr;</a>
                    <a href="#features" class="btn-text-link">Explore Features &rsaquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- 2. Feature Ribbon Bar -->
<div class="ribbon-bar">
    <div class="ribbon-container">

        <!-- Item 1: Compass Icon -->
        <div class="ribbon-item">
            <svg class="ribbon-svg-icon" viewBox="0 0 24 24" fill="none" stroke="#2D7D56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="#2D7D56"></polygon>
            </svg>
            <span>One place for every adventure.</span>
        </div>

        <div class="ribbon-divider"></div>

        <!-- Item 2: Shield Lock Icon -->
        <div class="ribbon-item">
            <svg class="ribbon-svg-icon" viewBox="0 0 24 24" fill="#2D7D56">
                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-5.45 9-12V5l-9-4zm0 6c1.4 0 2.5 1.1 2.5 2.5 0 .9-.5 1.7-1.2 2.1v2.4c0 .4-.3.7-.7.7h-1.2c-.4 0-.7-.3-.7-.7v-2.4c-.7-.4-1.2-1.2-1.2-2.1C9.5 8.1 10.6 7 12 7z" />
            </svg>
            <span>Your memories, your privacy.</span>
        </div>

        <div class="ribbon-divider"></div>

        <!-- Item 3: Star Icon -->
        <div class="ribbon-item">
            <svg class="ribbon-svg-icon" viewBox="0 0 24 24" fill="#2D7D56">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            <span>Every destination has a story.</span>
        </div>

    </div>
</div>

<!-- 3. How It Works Section -->
<section class="how-it-works" id="how-it-works">
    <div class="section-header">
        <div class="section-title-wrapper">
            <span class="title-line"></span>
            <h2 class="section-title">How It Works</h2>
            <span class="title-line"></span>
        </div>
        <p class="section-subtitle">Start your travel journal in just three simple steps.</p>
    </div>

    <div class="steps-container">
        <!-- Step 1 -->
        <div class="step-card">
            <div class="step-icon-wrapper">
                <svg viewBox="0 0 24 24" fill="none" stroke="#2D7D56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <div class="step-content">
                <h3>1. Create Your Trip</h3>
                <p>Give your trip a name, add dates, and start documenting your experience.</p>
            </div>
        </div>

        <div class="step-arrow">&rarr;</div>

        <!-- Step 2 -->
        <div class="step-card">
            <div class="step-icon-wrapper">
                <svg viewBox="0 0 24 24" fill="none" stroke="#2D7D56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="step-content">
                <h3>2. Add Your Destinations</h3>
                <p>Pin visited places and wishlist locations on your interactive map.</p>
            </div>
        </div>

        <div class="step-arrow">&rarr;</div>

        <!-- Step 3 -->
        <div class="step-card">
            <div class="step-icon-wrapper">
                <svg viewBox="0 0 24 24" fill="none" stroke="#2D7D56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </div>
            <div class="step-content">
                <h3>3. Preserve Your Memories</h3>
                <p>Add photos and stories, then revisit or share your journey.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Features Section (2x2 Grid) -->
<section class="features-section" id="features">
    <div class="section-header">
        <h2 class="section-title">Your Adventures, All in One Place</h2>
        <p class="section-subtitle">Powerful features to make your travel memories even better.</p>
    </div>

    <div class="features-2x2-grid">

        <!-- Feature 1: Interactive Travel Map -->
        <div class="feature-row">
            <div class="feature-img-box">
                <img src="images/img2.jpg" alt="Interactive Travel Map" onerror="this.src='css/bg.jpg';">
            </div>
            <div class="feature-info">
                <h3>
                    <svg class="feature-title-icon" viewBox="0 0 24 24" fill="#26593F">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Interactive Travel Map
                </h3>
                <p>See your visited destinations and future wishlist locations on an interactive map.</p>
            </div>
        </div>

        <!-- Feature 2: Memories & Travel Journals -->
        <div class="feature-row">
            <div class="feature-img-box">
                <img src="images/img3.jpg" alt="Memories & Travel Journals" onerror="this.src='css/bg.jpg';">
            </div>
            <div class="feature-info">
                <h3>
                    <svg class="feature-title-icon" viewBox="0 0 24 24" fill="#26593F">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                    </svg>
                    Memories & Travel Journals
                </h3>
                <p>Keep your photos, dates, and stories together in one place.</p>
            </div>
        </div>

        <!-- Feature 3: Organized Travel Experiences -->
        <div class="feature-row">
            <div class="feature-img-box">
                <img src="images/img4.jpg" alt="Organized Travel Experiences" onerror="this.src='css/bg.jpg';">
            </div>
            <div class="feature-info">
                <h3>
                    <svg class="feature-title-icon" viewBox="0 0 24 24" fill="#26593F">
                        <path d="M17 6h-2V3c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v3H7c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6-2h2v2h-2V4zm6 15H7V8h10v11z"/>
                    </svg>
                    Organized Travel Experiences
                </h3>
                <p>Group multiple destinations and stops under one master trip container.</p>
            </div>
        </div>

        <!-- Feature 4: Your Memories, Your Choice -->
        <div class="feature-row">
            <div class="feature-img-box">
                <img src="images/img5.jpg" alt="Your Memories, Your Choice" onerror="this.src='css/bg.jpg';">
            </div>
            <div class="feature-info">
                <h3>
                    <svg class="feature-title-icon" viewBox="0 0 24 24" fill="#26593F">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    Your Memories, Your Choice
                </h3>
                <p>Keep your travel journals private or share selected experiences publicly.</p>
            </div>
        </div>

    </div>
</section>

<!-- 5 & 6. Combined CTA & Footer Wrapper -->
<div class="cta-footer-wrapper" id="about">
    <!-- CTA Content -->
    <section class="cta-section">
        <div class="cta-container">
            <h2>Your Next Adventure Deserves a Story.</h2>
            <p>Create your free account and start your travel journal today!</p>
            <a href="register.php" class="btn-cta-white">Create Your Free Account &rarr;</a>
        </div>
    </section>

    <!-- Footer Bar -->
    <footer class="footer-dark">
        <div class="footer-inner">
            <div class="footer-brand">
                <a href="index.php" class="footer-logo-link">
                    <img src="images/logo.png" alt="Travel Log Logo" class="footer-custom-logo">
                    <span class="footer-logo-text">Travel Log</span>
                </a>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-nav">
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-auth-nav">
                <a href="login.php">Log In</a>
                <a href="register.php">Sign Up</a>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-mountain-space"></div>
        </div>

        <div class="footer-copyright">
            <p>&copy; <?php echo date('Y'); ?> Travel Log. All rights reserved.</p>
        </div>
    </footer>
</div>

</body>
</html>