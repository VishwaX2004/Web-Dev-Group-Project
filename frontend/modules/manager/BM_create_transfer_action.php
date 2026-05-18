<?php
session_start();
include("../../../backend/config/db_connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $source_branch_id = $_POST['source_branch_id'] ?? '';
    $dest_branch_id = $_POST['dest_branch_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);

    if (empty($source_branch_id) || empty($dest_branch_id) || empty($product_id) || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $transfer_id = 'TRF-' . rand(1000, 9999);
    $status = 'Pending';
    
    $query = "INSERT INTO inter_branch_transfer (transfer_id, source_branch_id, dest_branch_id, product_id, quantity, status) 
              VALUES ('$transfer_id', '$source_branch_id', '$dest_branch_id', '$product_id', $quantity, '$status')";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Transfer request created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create transfer: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>
