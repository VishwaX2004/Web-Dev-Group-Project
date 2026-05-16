<?php
session_start();

include("../../config/db_connection.php");

header("Content-Type: application/json");

if (!isset($_SESSION['auth'])) {

    echo json_encode(["status" => "error", "message" => "Unauthorized"]);

    exit();
}

$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);

$cart = $data['cart'] ?? [];

$branch_id = mysqli_real_escape_string($conn, $data['branch_id']);

if (empty($cart)) {

    echo json_encode(["status" => "error", "message" => "Empty Cart"]);

    exit();
}

mysqli_begin_transaction($conn);

try {

    $order_timestamp = date("His");

    $main_sale_id = "SALE-" . date("md") . "-" . $order_timestamp;

    foreach ($cart as $index => $item) {

        $pid = mysqli_real_escape_string($conn, $item['product_id']);

        $qty = (int)$item['qty'];

        $price = (float)$item['total'];

        $row_id = $main_sale_id . "-" . $index;

        // 1. Insert Sales Record
        $sql = "INSERT INTO sales_order (sale_id, user_id, product_id, branch_id, quantity, price, sale_date_time) 
                VALUES ('$row_id', '$user_id', '$pid', '$branch_id', $qty, $price, NOW())";
        
        if (!mysqli_query($conn, $sql)) throw new Exception("Insert Error");

        // 2. Deduct from Inventory (The stock reduction logic)
        $update_stock = "UPDATE inventory SET quantity = quantity - $qty 
                         WHERE product_id = '$pid' AND branch_id = '$branch_id'";
        
        if (!mysqli_query($conn, $update_stock)) throw new Exception("Stock Update Error");

        // 3. Final Stock Safety Check
        $check = mysqli_query($conn, "SELECT quantity FROM inventory WHERE product_id = '$pid' AND branch_id = '$branch_id'");
        $stock = mysqli_fetch_assoc($check);
        if ($stock['quantity'] < 0) throw new Exception("Stock became negative for: " . $pid);
    }

    mysqli_commit($conn);

    echo json_encode(["status" => "success", "sale_id" => $main_sale_id]);

} catch (Exception $e) {

    mysqli_rollback($conn);
    
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>