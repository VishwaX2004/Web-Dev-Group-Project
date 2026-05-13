<?php
session_start();
include("../../config/db_connection.php");
header("Content-Type: application/json");

// AUTH CHECK
if (!isset($_SESSION['auth'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized Access"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

// GET JSON DATA
$data = json_decode(file_get_contents("php://input"), true);
$cart = $data['cart'];
$total_amount = $data['total_amount'];
$amount_paid = $data['amount_paid'];

if (empty($cart)) {
    echo json_encode([
        "status" => "error",
        "message" => "Cart Empty"
    ]);
    exit();
}

// START TRANSACTION
mysqli_begin_transaction($conn);

try {
    // පොදු timestamp එකක් ගන්නවා (Items ඔක්කොම එකම වෙලාවක record වෙන්න)
    $timestamp = time();

    foreach ($cart as $index => $item) {
        $product_id = mysqli_real_escape_string($conn, $item['product_id']);
        $qty = (int)$item['qty'];
        $item_total = (float)$item['total'];

        /* FIX: Primary Key Error එක විසඳීමට ක්‍රමය.
           සෑම product එකකටම වෙනස් sale_id එකක් ලැබීමට index එක එකතු කරනවා.
           උදා: SALE-1778659721-0, SALE-1778659721-1...
        */
        $current_sale_id = "SALE-" . $timestamp . "-" . $index;

        // INSERT SALES RECORD
        $insert_query = "
            INSERT INTO sales_order 
            (
                sale_id, 
                user_id, 
                product_id, 
                quantity, 
                price
            ) 
            VALUES 
            (
                '$current_sale_id', 
                '$user_id', 
                '$product_id', 
                $qty, 
                $item_total
            )
        ";

        if (!mysqli_query($conn, $insert_query)) {
            throw new Exception("Sales Order Insert Failed: " . mysqli_error($conn));
        }

        // UPDATE STOCK
        $stock_update = "
            UPDATE inventory 
            SET quantity = quantity - $qty 
            WHERE product_id = '$product_id'
        ";
        
        if (!mysqli_query($conn, $stock_update)) {
            throw new Exception("Inventory Update Failed: " . mysqli_error($conn));
        }
    }

    // COMMIT
    mysqli_commit($conn);

    echo json_encode([
        "status" => "success",
        "sale_id" => "ORDER-" . $timestamp // Alert එකේ පෙන්වන්න පොදු ID එකක්
    ]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>