<?php
session_start();
include("../config/db_connection.php");

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Please fill all fields!";
        header("Location: ../../frontend/index.php");
        exit();
    }

    // Query adjusted to match your screenshot (user_id instead of id)
    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        // Plain text check (As per your DB screenshot showing '1234')
        if ($password == $user_data['password']) {
            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $user_data['user_id']; // Fixed column name
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['role'] = $user_data['role'];
            $_SESSION['branch_id'] = $user_data['branch_id'];

            // Redirect based on role
            if ($user_data['role'] == "admin") {
                header("Location: ../../frontend/modules/admin/dashboard.php");
            } elseif ($user_data['role'] == "cashier") {
                header("Location: ../../frontend/modules/cashier/cashier_dashboard.php");
            } elseif ($user_data['role'] == "manager") {
                header("Location: ../../frontend/modules/manager/dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password!";
            header("Location: ../../frontend/index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found!";
        header("Location: ../../frontend/index.php");
        exit();
    }
}
?>