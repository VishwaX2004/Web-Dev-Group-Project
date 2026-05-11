<?php
// ============================================
// LOGIN AUTHENTICATION
// ============================================

// Start session
session_start();

// Include database connection
include("../config/db_connection.php");

// Check if form submitted
if (isset($_POST['login_btn'])) {

    // Get form data safely
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Check empty fields
    if (empty($username) || empty($password)) {

        $_SESSION['error'] = "Please fill all fields!";
        header("Location: ../../frontend/index.php");
        exit();
    }

    // Find user
    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";

    $result = mysqli_query($conn, $query);

    // Query check
    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    // User exists
    if (mysqli_num_rows($result) > 0) {

        $user_data = mysqli_fetch_assoc($result);

        // Password check
        if ($password == $user_data['password']) {

            // Store session data
            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['role'] = $user_data['role'];
            $_SESSION['branch_id'] = $user_data['branch_id'];

            // Redirect according to role
            if ($user_data['role'] == "admin") {

                header("Location: ../../frontend/modules/admin/dashboard.php");
                exit();

            } elseif ($user_data['role'] == "cashier") {

                header("Location: ../../frontend/modules/cashier/cashier_dashboard.php");
                exit();

            } elseif ($user_data['role'] == "manager") {

                header("Location: ../../frontend/modules/manager/dashboard.php");
                exit();

            } else {

                $_SESSION['error'] = "Invalid role!";
                header("Location: ../../frontend/index.php");
                exit();
            }

        } else {

            // Wrong password
            $_SESSION['error'] = "Incorrect password!";
            header("Location: ../../frontend/index.php");
            exit();
        }

    } else {

        // User not found
        $_SESSION['error'] = "User not found!";
        header("Location: ../../frontend/index.php");
        exit();
    }

} else {

    // Direct access protection
    header("Location: ../../frontend/index.php");
    exit();
}
?>