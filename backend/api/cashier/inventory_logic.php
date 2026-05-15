<?php
require_once __DIR__ . '/../../config/db_connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getInventoryData($branch_id, $search = '') {
    global $conn;
    $like = "%$search%";
    $query = "SELECT p.Product_id, p.product_name, p.category_name, i.quantity
              FROM inventory i
              JOIN product p ON i.product_id = p.Product_id
              WHERE i.branch_id = ? 
                AND (p.Product_id LIKE ? OR p.product_name LIKE ? OR p.category_name LIKE ?)
              ORDER BY p.product_name";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $branch_id, $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $data;
}
?>