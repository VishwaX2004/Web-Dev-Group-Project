<?php
session_start();
include("../../../backend/config/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $source_branch_id = $_POST['source_branch_id'] ?? '';
    $dest_branch_id = $_POST['dest_branch_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);

    if (empty($source_branch_id) || empty($dest_branch_id) || empty($product_id) || $quantity <= 0) {
        header("Location: BM_Inter_Branch_Transfer.php?err=" . urlencode("All fields are required."));
        exit;
    }

    // Check available stock in source branch
    $stock_query = "SELECT quantity FROM inventory WHERE branch_id = '$source_branch_id' AND product_id = '$product_id' LIMIT 1";
    $stock_result = mysqli_query($conn, $stock_query);
    
    $available_stock = 0;
    if ($stock_result && mysqli_num_rows($stock_result) > 0) {
        $stock_row = mysqli_fetch_assoc($stock_result);
        $available_stock = intval($stock_row['quantity']);
    }

    if ($quantity > $available_stock) {
        header("Location: BM_Inter_Branch_Transfer.php?err=" . urlencode("Insufficient stock in source branch. Available stock: $available_stock."));
        exit;
    }

    $transfer_id = 'TRF-' . time();
    $status = 'Pending';
    
    $query = "INSERT INTO inter_branch_transfer (transfer_id, source_branch_id, dest_branch_id, product_id, quantity, status) 
              VALUES ('$transfer_id', '$source_branch_id', '$dest_branch_id', '$product_id', $quantity, '$status')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: BM_Inter_Branch_Transfer.php?msg=" . urlencode("Transfer request created successfully."));
        exit;
    } else {
        header("Location: BM_Inter_Branch_Transfer.php?err=" . urlencode("Failed to create transfer: " . mysqli_error($conn)));
        exit;
    }
} else {
    header("Location: BM_Inter_Branch_Transfer.php?err=" . urlencode("Method not allowed."));
    exit;
}
?>
