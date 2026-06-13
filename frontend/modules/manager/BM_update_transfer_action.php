<?php
session_start();
include("../../../backend/config/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transfer_id = $_POST['transfer_id'] ?? '';
    $source_branch_id = $_POST['source_branch_id'] ?? '';
    $dest_branch_id = $_POST['dest_branch_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    $status = $_POST['status'] ?? 'Pending';

    if (empty($transfer_id) || empty($source_branch_id) || empty($dest_branch_id) || empty($product_id) || $quantity <= 0) {
        header("Location: BM_Inter_Branch_Transfer.php?err=" . urlencode("All fields are required and quantity must be positive."));
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
        header("Location: BM_Inter_Branch_Transfer.php?msg=" . urlencode("Transfer updated successfully."));
        exit;
    } else {
        header("Location: BM_Inter_Branch_Transfer.php?err=" . urlencode("Failed to update transfer: " . mysqli_error($conn)));
        exit;
    }
} else {
    header("Location: BM_Inter_Branch_Transfer.php?err=" . urlencode("Method not allowed."));
    exit;
}
?>
