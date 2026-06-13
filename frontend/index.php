<?php
// Start session
session_start();
?>

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
                <img src="assets/images/home_image.png"
                    alt="Home"
                    style="width: 30px; height: 30px;">
            </div>

            <div class="header-content">
                <h1>Welcome Back</h1>
                <p>Manage your retail empire effortlessly.</p>
            </div>

            <!-- ERROR MESSAGE -->
            <?php
            if (isset($_SESSION['error'])) {
                echo '
                <div class="error-alert">
                    '.$_SESSION['error'].'
                </div>
                ';

                unset($_SESSION['error']);
            }
            ?>

            <!-- LOGIN FORM -->
            <form id="loginForm"
                action="../backend/api/login_auth.php"
                method="POST">

                <div class="input-group">

                    <label>Username</label>

                    <input
                        type="text"
                        name="username"
                        placeholder="Enter your username"
                        required>

                </div>

                <div class="input-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required>

                </div>

                <button
                    type="submit"
                    name="login_btn"
                    class="btn-signin">

                    Sign In

                </button>

            </form>

            <p class="signup-text">
                New to the system?
                <a href="#">Create an account</a>
            </p>

        </main>

        <!-- RIGHT SIDE -->
        <section class="info-side">

            <div class="floating-icon">

                <img
                    src="assets/images/shopping_cart.png"
                    alt="Icon"
                    style="width: 32px; filter: brightness(0) invert(1);">

            </div>

            <h2>Smart Retail Management</h2>

            <p>
                Optimize inventory, track live sales,
                and empower your staff with our all-in-one platform.
            </p>

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