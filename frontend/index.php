<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Management System | Login</title>
    <link rel="stylesheet" href="assets/css/login_page.css">
</head>
<body>

    <div class="main-wrapper">
        <main class="form-side">
            <div class="brand-icon">
                <img src="assets/images/home_image.png" alt="Home" style="width: 30px; height: 30px;">
            </div>
            
            <div class="header-content">
                <h1>Welcome Back</h1>
                <p>Manage your retail empire effortlessly.</p>
            </div>

            <form id="loginForm">
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" id="email" placeholder="vishwa@example.com" required>
                </div>

                <div class="input-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="margin-bottom: 0;">Password</label>
                        <a href="#" class="forgot-pass">Forgot Password?</a>
                    </div>
                    <input type="password" id="password" placeholder="••••••••" required>
                    <div class="toggle-password" id="togglePassword">
                        <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </div>
                </div>

                <button type="submit" class="btn-signin" id="submitBtn">Sign In</button>
            </form>

            <p class="signup-text">New to the system? <a href="Signup.html">Create an account</a></p>
        </main>

        <section class="info-side">
            <div class="floating-icon">
                <img src="assets/images/shopping_cart.png" alt="Icon" style="width: 32px; filter: brightness(0) invert(1);">
            </div>
            <h2>Smart Retail Management</h2>
            <p>Optimize inventory, track live sales, and empower your staff with our all-in-one platform.</p>

            <div class="stats-grid">
                <div class="stat-box">
                    <h4>400+</h4>
                    <span>Active Stores</span>
                </div>
                <div class="stat-box">
                    <h4>24/7</h4>
                    <span>Live Support</span>
                </div>
                <div class="stat-box">
                    <h4>99.9%</h4>
                    <span>Uptime Rate</span>
                </div>
                <div class="stat-box">
                    <h4>5K+</h4>
                    <span>Total Products</span>
                </div>
            </div>
        </section>
    </div>
    <script src="assets/js/login_page.js"></script>
</body>
</html>