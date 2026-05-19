<?php
// Start the session to access user login data
session_start();

// Connect to the database
include("../../config/db_connection.php");

// Set the response type to JSON
header("Content-Type: application/json");

// Check if the user is logged in. If not, stop and show an error.
if (!isset($_SESSION['auth'])) {

    echo json_encode(["status" => "error", "message" => "Unauthorized"]);

    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Get the raw data sent to this script and turn it into a PHP array
$data = json_decode(file_get_contents("php://input"), true);

// Get the cart items (default to an empty list if missing)
$cart = $data['cart'] ?? [];

// Clean the branch ID to prevent database security issues (SQL injection)
$branch_id = mysqli_real_escape_string($conn, $data['branch_id']);

// If the cart has no items, stop and show an error
if (empty($cart)) {

    echo json_encode(["status" => "error", "message" => "Empty Cart"]);

    exit();
}

// Start a database transaction (makes sure all queries succeed or none do)
mysqli_begin_transaction($conn);

try {
    // Create a unique base ID for the sale using the current time
    $order_timestamp = date("His");

    $main_sale_id = "SALE-" . date("md") . "-" . $order_timestamp;

    // Loop through each item in the cart
    foreach ($cart as $index => $item) {
        // Clean the product ID and format numbers properly
        $pid = mysqli_real_escape_string($conn, $item['product_id']);

        $qty = (int)$item['qty'];

        $price = (float)$item['total'];

        // Create a unique ID for this specific row in the database
        $row_id = $main_sale_id . "-" . $index;

        // 1. Save the item sale details into the database
        $sql = "INSERT INTO sales_order (sale_id, user_id, product_id, branch_id, quantity, price, sale_date_time) 
                VALUES ('$row_id', '$user_id', '$pid', '$branch_id', $qty, $price, NOW())";
        
        if (!mysqli_query($conn, $sql)) throw new Exception("Insert Error");

        // 2. Reduce the item quantity in the inventory for this branch
        $update_stock = "UPDATE inventory SET quantity = quantity - $qty 
                         WHERE product_id = '$pid' AND branch_id = '$branch_id'";
        
        if (!mysqli_query($conn, $update_stock)) throw new Exception("Stock Update Error");

        // 3. Look up the current stock to make sure it didn't drop below zero
        $check = mysqli_query($conn, "SELECT quantity FROM inventory WHERE product_id = '$pid' AND branch_id = '$branch_id'");
        
        $stock = mysqli_fetch_assoc($check);
        
        // If stock goes below 0, stop everything and show an error
        if ($stock['quantity'] < 0) throw new Exception("Stock became negative for: " . $pid);
    }

    // If everything worked perfectly, save all changes permanently
    mysqli_commit($conn);

    // Send a success message back
    echo json_encode(["status" => "success", "sale_id" => $main_sale_id]);

} catch (Exception $e) {
    // If any error happened above, undo all database changes made in this loop
    mysqli_rollback($conn);
    
    // Send the error message back
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>