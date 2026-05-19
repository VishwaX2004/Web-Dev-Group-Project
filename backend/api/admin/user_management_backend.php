<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../config/db_connection.php';

if (!isset($conn) || !$conn) {
    die("Database connection failed!");
}

function getAllUsers($conn) {
    $result = mysqli_query($conn, "SELECT * FROM users ORDER BY user_id");
    if (!$result) return [];
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

function getUserById($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id = ?");
    if (!$stmt) return null;
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function emailExists($conn, $email, $excludeId = null) {
    if ($excludeId) {
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $excludeId);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

function generateUserId($conn) {
    $result = mysqli_query($conn, "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
    $lastUser = mysqli_fetch_assoc($result);
    if ($lastUser) {
        $lastNum = intval(substr($lastUser['user_id'], 4));
        $newNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        return "USR-" . $newNum;
    } else {
        return "USR-001";
    }
}

function addUser($conn, $full_name, $email, $role, $branch_id) {
    if (emailExists($conn, $email)) {
        return ['success' => false, 'message' => 'Email already exists!'];
    }
    
    $userId = generateUserId($conn);
    
    $stmt = mysqli_prepare($conn, "INSERT INTO users (user_id, full_name, email, role, branch_id) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        return ['success' => false, 'message' => 'Database error!'];
    }
    mysqli_stmt_bind_param($stmt, "sssss", $userId, $full_name, $email, $role, $branch_id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    if ($success) {
        return ['success' => true, 'message' => 'User added successfully! ID: ' . $userId];
    } else {
        return ['success' => false, 'message' => 'Failed to add user!'];
    }
}

function updateUser($conn, $id, $full_name, $email, $role, $branch_id) {
    if (emailExists($conn, $email, $id)) {
        return ['success' => false, 'message' => 'Email already exists!'];
    }
    
    $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, email = ?, role = ?, branch_id = ? WHERE user_id = ?");
    if (!$stmt) {
        return ['success' => false, 'message' => 'Database error!'];
    }
    mysqli_stmt_bind_param($stmt, "sssss", $full_name, $email, $role, $branch_id, $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    if ($success) {
        return ['success' => true, 'message' => 'User updated successfully!'];
    } else {
        return ['success' => false, 'message' => 'Failed to update user!'];
    }
}

function deleteUser($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE user_id = ?");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "s", $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

$message = '';
$messageType = '';
$editUser = null;

if (isset($_POST['add_submit'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $branch_id = trim($_POST['branch_id']);
    
    if (empty($full_name) || empty($email)) {
        $message = "Name and email are required!";
        $messageType = "error";
    } else {
        $result = addUser($conn, $full_name, $email, $role, $branch_id);
        $message = $result['message'];
        $messageType = $result['success'] ? 'success' : 'error';
    }
}

if (isset($_POST['edit_submit'])) {
    $id = $_POST['user_id'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $branch_id = trim($_POST['branch_id']);
    
    if (empty($id) || empty($full_name) || empty($email)) {
        $message = "All fields are required!";
        $messageType = "error";
    } else {
        $result = updateUser($conn, $id, $full_name, $email, $role, $branch_id);
        $message = $result['message'];
        $messageType = $result['success'] ? 'success' : 'error';
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = deleteUser($conn, $id);
    if ($result) {
        $message = "User deleted successfully!";
        $messageType = "success";
    } else {
        $message = "Failed to delete user!";
        $messageType = "error";
    }
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editUser = getUserById($conn, $id);
}

$users = getAllUsers($conn);
?>