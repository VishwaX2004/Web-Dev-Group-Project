<?php
session_start();
include("../../../backend/config/db_connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    $branch_id = $_SESSION['branch_id'] ?? 'B001';

    if (empty($product_name) || empty($category_id) || $quantity < 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit;
    }

    // 1. Check if product exists, or create it
    $check_product = "SELECT Product_id FROM product WHERE product_name = '$product_name' LIMIT 1";
    $p_result = mysqli_query($conn, $check_product);
    
    if (mysqli_num_rows($p_result) > 0) {
        $p_row = mysqli_fetch_assoc($p_result);
        $product_id = $p_row['Product_id'];
    } else {
        // Create new product ID
        $product_id = 'PROD-' . rand(1000, 9999);
        $insert_product = "INSERT INTO product (Product_id, product_name, category_name, price) VALUES ('$product_id', '$product_name', '$category_id', 0.00)";
        if (!mysqli_query($conn, $insert_product)) {
            echo json_encode(['success' => false, 'message' => 'Failed to create product.']);
            exit;
        }
    }

    // 2. Check if inventory record exists for this branch, or create it
    $check_inv = "SELECT inventory_id, quantity FROM inventory WHERE branch_id = '$branch_id' AND product_id = '$product_id' LIMIT 1";
    $i_result = mysqli_query($conn, $check_inv);

    if (mysqli_num_rows($i_result) > 0) {
        $i_row = mysqli_fetch_assoc($i_result);
        $inv_id = $i_row['inventory_id'];
        $new_qty = $i_row['quantity'] + $quantity;
        $status = ($new_qty <= 0) ? 'Out of Stock' : (($new_qty < 10) ? 'Low Stock' : 'In Stock');
        
        $update_inv = "UPDATE inventory SET quantity = $new_qty, status = '$status' WHERE inventory_id = '$inv_id'";
        if (mysqli_query($conn, $update_inv)) {
            echo json_encode(['success' => true, 'message' => 'Stock updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update inventory.']);
        }
    } else {
        $inv_id = 'INV-' . rand(1000, 9999);
        $status = ($quantity <= 0) ? 'Out of Stock' : (($quantity < 10) ? 'Low Stock' : 'In Stock');
        $insert_inv = "INSERT INTO inventory (inventory_id, branch_id, product_id, quantity, status) VALUES ('$inv_id', '$branch_id', '$product_id', $quantity, '$status')";
        if (mysqli_query($conn, $insert_inv)) {
            echo json_encode(['success' => true, 'message' => 'New stock record created.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create inventory record.']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>
