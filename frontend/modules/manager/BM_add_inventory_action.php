<?php
session_start();
include("../../../backend/config/db_connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Get input data matching the HTML form's name attributes
    $product_id = $_POST['product_id'] ?? '';
    $category_name = $_POST['category_name'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    
    // Retrieve Session Branch ID (Defaults to 'B001' if not set)
    $branch_id = $_SESSION['branch_id'] ?? 'B001';

    // 2. Validate input: Product ID must not be empty and quantity must be greater than 0
    if (empty($product_id) || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data. Please check your form.']);
        exit;
    }

    // 3. Check if an inventory record already exists for this product in the current branch
    $check_inv = "SELECT inventory_id, quantity FROM inventory WHERE branch_id = '$branch_id' AND product_id = '$product_id' LIMIT 1";
    $i_result = mysqli_query($conn, $check_inv);

    if (mysqli_num_rows($i_result) > 0) {
        // --- If it exists, update the existing quantity ---
        $i_row = mysqli_fetch_assoc($i_result);
        $inv_id = $i_row['inventory_id'];
        $new_qty = $i_row['quantity'] + $quantity;
        
        $status = ($new_qty <= 0) ? 'Out of Stock' : (($new_qty < 10) ? 'Low Stock' : 'In Stock');
        
        $update_inv = "UPDATE inventory SET quantity = $new_qty, status = '$status' WHERE inventory_id = '$inv_id'";
        if (mysqli_query($conn, $update_inv)) {
            echo json_encode(['success' => true, 'message' => 'Stock updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update inventory.']);
        }
    } else {
        // --- If it does not exist, create a new inventory record ---
        
        // Generate a new sequential inventory ID (e.g., INV-108) instead of using random numbers
        $id_query = "SELECT inventory_id FROM inventory ORDER BY inventory_id DESC LIMIT 1";
        $id_result = mysqli_query($conn, $id_query);
        
        $inv_id = 'INV-101'; // Default starting ID
        if (mysqli_num_rows($id_result) > 0) {
            $last_id = mysqli_fetch_assoc($id_result)['inventory_id'];
            $num = intval(substr($last_id, 4)) + 1;
            $inv_id = 'INV-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        }

        $status = ($quantity <= 0) ? 'Out of Stock' : (($quantity < 10) ? 'Low Stock' : 'In Stock');
        
        $insert_inv = "INSERT INTO inventory (inventory_id, branch_id, product_id, quantity, status) VALUES ('$inv_id', '$branch_id', '$product_id', $quantity, '$status')";
        
        if (mysqli_query($conn, $insert_inv)) {
            echo json_encode(['success' => true, 'message' => 'New stock record created successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create inventory record: ' . mysqli_error($conn)]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>