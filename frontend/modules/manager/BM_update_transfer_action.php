<?php
session_start();
include("../../../backend/config/db_connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transfer_id = $_POST['transfer_id'] ?? '';
    $source_branch_id = $_POST['source_branch_id'] ?? '';
    $dest_branch_id = $_POST['dest_branch_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    $status = $_POST['status'] ?? 'Pending';

    if (empty($transfer_id) || empty($source_branch_id) || empty($dest_branch_id) || empty($product_id) || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'All fields are required and quantity must be positive.']);
        exit;
    }

    $query = "UPDATE inter_branch_transfer 
              SET source_branch_id = '$source_branch_id', 
                  dest_branch_id = '$dest_branch_id', 
                  product_id = '$product_id', 
                  quantity = $quantity,
                  status = '$status'
              WHERE transfer_id = '$transfer_id'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Transfer updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update transfer: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>
