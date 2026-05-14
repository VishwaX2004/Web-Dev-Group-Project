<?php
// start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Management System | Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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

            <?php
            if (isset($_SESSION['error'])) {
                echo '
                <div style="
                    background:#ffdede;
                    color:#d10000;
                    padding:10px;
                    border-radius:6px;
                    margin-bottom:15px;
                    font-size:14px;
                ">
                    ' . htmlspecialchars($_SESSION['error']) . '
                </div>
                ';
                unset($_SESSION['error']);
            }
            ?>

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

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password-field"
                            placeholder="••••••••"
                            required>
                        <span id="togglePassword">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </span>

                    </div>

                </div>

                <button
                    type="submit"
                    name="login_btn"
                    class="btn-signin">
                    Sign In
                </button>

            </form>

        </main>

        <section class="info-side">

            <div class="floating-icon">
                <img
                    src="assets/images/shopping_cart.png"
                    alt="Icon"
                    style="width: 32px; filter: brightness(0) invert(1);">
            </div>

            <h2>Smart POS Retail Management System</h2>

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