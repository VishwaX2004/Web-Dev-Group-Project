<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../config/db_connection.php';

if (!isset($conn) || !$conn) {
    die("Database connection failed!");
}

function getAllBranches($conn) {
    $result = mysqli_query($conn, "SELECT * FROM branch ORDER BY branch_id");
    if (!$result) return [];
    $branches = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $branches[] = $row;
    }
    return $branches;
}

function addBranch($conn, $name, $location, $contact, $status) {
    $result = mysqli_query($conn, "SELECT branch_id FROM branch ORDER BY branch_id DESC LIMIT 1");
    $lastBranch = mysqli_fetch_assoc($result);
    if ($lastBranch) {
        $lastNum = intval(substr($lastBranch['branch_id'], 3));
        $newNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        $branchId = "BR-" . $newNum;
    } else {
        $branchId = "BR-001";
    }
    
    $stmt = mysqli_prepare($conn, "INSERT INTO branch (branch_id, branch_name, location, branch_contact, branch_status) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "sssss", $branchId, $name, $location, $contact, $status);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success ? $branchId : false;
}

function updateBranch($conn, $id, $name, $location, $contact, $status) {
    $stmt = mysqli_prepare($conn, "UPDATE branch SET branch_name = ?, location = ?, branch_contact = ?, branch_status = ? WHERE branch_id = ?");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "sssss", $name, $location, $contact, $status, $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

function deleteBranch($conn, $id) {
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
    $query = "DELETE FROM branch WHERE branch_id = '" . mysqli_real_escape_string($conn, $id) . "'";
    $result = mysqli_query($conn, $query);
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
    return $result ? true : false;
}

$message = '';
$messageType = '';
$editBranch = null;

if (isset($_POST['add_submit'])) {
    $name = trim($_POST['branch_name']);
    $location = trim($_POST['location']);
    $contact = trim($_POST['branch_contact']);
    $status = $_POST['branch_status'];
    
    if (empty($name) || empty($location) || empty($contact)) {
        $message = "All fields are required!";
        $messageType = "error";
    } else {
        $result = addBranch($conn, $name, $location, $contact, $status);
        if ($result) {
            $message = "Branch added successfully!";
            $messageType = "success";
        } else {
            $message = "Failed to add branch!";
            $messageType = "error";
        }
    }
}

if (isset($_POST['edit_submit'])) {
    $id = $_POST['branch_id'];
    $name = trim($_POST['branch_name']);
    $location = trim($_POST['location']);
    $contact = trim($_POST['branch_contact']);
    $status = $_POST['branch_status'];
    
    if (empty($id) || empty($name) || empty($location) || empty($contact)) {
        $message = "All fields are required!";
        $messageType = "error";
    } else {
        $result = updateBranch($conn, $id, $name, $location, $contact, $status);
        if ($result) {
            $message = "Branch updated successfully!";
            $messageType = "success";
        } else {
            $message = "Failed to update branch!";
            $messageType = "error";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = deleteBranch($conn, $id);
    if ($result) {
        $message = "Branch deleted successfully!";
        $messageType = "success";
    } else {
        $message = "Failed to delete branch!";
        $messageType = "error";
    }
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM branch WHERE branch_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $editBranch = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}

$branches = getAllBranches($conn);
?>