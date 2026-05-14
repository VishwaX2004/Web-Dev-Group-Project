<?php

session_start();

include("../../config/db_connection.php");

header("Content-Type: application/json");

// 1. SECURITY CHECK: Verify if the user is authenticated
if (!isset($_SESSION['auth'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized Access"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. GET JSON DATA: Retrieve data sent from the Frontend
$data = json_decode(file_get_contents("php://input"), true);
$cart = $data['cart'] ?? [];
$branch_id = mysqli_real_escape_string($conn, $data['branch_id']);

if (empty($cart)) {
    echo json_encode(["status" => "error", "message" => "Cart is empty"]);
    exit();
}

// 3. START TRANSACTION: Ensure database integrity during updates
mysqli_begin_transaction($conn);

try {
    // Generate a short timestamp (e.g., Hour and Minute like 1220)
    $short_time = date("Hi");

    // Main Order ID for the success response (e.g., ORDER-1220)
    $main_order_display_id = "ORDER-" . $short_time;

    foreach ($cart as $index => $item) {
        $product_id = mysqli_real_escape_string($conn, $item['product_id']);
        $qty = (int) $item['qty'];
        $item_total = (float) $item['total'];

        // Generate short sale_id (e.g., SALE-1220-0, SALE-1220-1)
        $current_sale_id = "SALE-" . $short_time . "-" . $index;

        // INSERT SALES RECORD: Save the transaction details
        $insert_query = "
            INSERT INTO sales_order 
            (sale_id, user_id, product_id, branch_id, quantity, price, sale_date_time) 
            VALUES 
            ('$current_sale_id', '$user_id', '$product_id', '$branch_id', $qty, $item_total, NOW())
        ";

        if (!mysqli_query($conn, $insert_query)) {
            throw new Exception("Sales Order Insert Failed: " . mysqli_error($conn));
        }

        // UPDATE STOCK: Deduct purchased quantity from the specific branch inventory
        $stock_update = "
            UPDATE inventory 
            SET quantity = quantity - $qty 
            WHERE product_id = '$product_id' AND branch_id = '$branch_id'
        ";

        if (!mysqli_query($conn, $stock_update)) {
            throw new Exception("Inventory Update Failed: " . mysqli_error($conn));
        }

        // CHECK STOCK: Ensure quantity does not drop below zero
        $check_stock = mysqli_query($conn, "SELECT quantity FROM inventory WHERE product_id = '$product_id' AND branch_id = '$branch_id'");
        $stock_data = mysqli_fetch_assoc($check_stock);

        if ($stock_data['quantity'] < 0) {
            throw new Exception("Insufficient stock for product: " . $product_id);
        }
    }

    // COMMIT: Save all changes to the database
    mysqli_commit($conn);

    echo json_encode([
        "status" => "success",
        "message" => "Transaction Completed Successfully",
        "sale_id" => $main_order_display_id
    ]);

} catch (Exception $e) {
    // ROLLBACK: Undo changes if any error occurs
    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>