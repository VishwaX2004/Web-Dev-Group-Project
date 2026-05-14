<?php
require_once __DIR__ . '/../../config/db_connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function updateInventory($conn, $product_id, $branch_id, $delta) {
    $stmt = mysqli_prepare($conn, "UPDATE inventory SET quantity = quantity + ? WHERE product_id = ? AND branch_id = ?");
    mysqli_stmt_bind_param($stmt, "iss", $delta, $product_id, $branch_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function createReturn($sale_id, $product_id, $quantity, $reason, $status, $branch_id, $user_id) {
    global $conn;
    $errors = [];
    $stmt = mysqli_prepare($conn, "SELECT quantity FROM sales_order WHERE sale_id = ? AND product_id = ?");
    mysqli_stmt_bind_param($stmt, "ss", $sale_id, $product_id);
    mysqli_stmt_execute($stmt);
    $saleItem = mysqli_stmt_get_result($stmt)->fetch_assoc();
    mysqli_stmt_close($stmt);
    if (!$saleItem) {
        $errors[] = "Sale ID and Product ID do not match.";
    } elseif ($quantity > $saleItem['quantity']) {
        $errors[] = "Quantity exceeds original purchase.";
    }
    $stmt = mysqli_prepare($conn, "SELECT return_id FROM returns WHERE sale_id = ? AND product_id = ?");
    mysqli_stmt_bind_param($stmt, "ss", $sale_id, $product_id);
    mysqli_stmt_execute($stmt);
    $duplicate = mysqli_stmt_get_result($stmt)->num_rows > 0;
    mysqli_stmt_close($stmt);
    if ($duplicate) $errors[] = "Return already exists for this sale+product.";

    if (empty($errors)) {
        $return_id = 'RET-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $return_date = date('Y-m-d H:i:s');
        $stmt = mysqli_prepare($conn, "INSERT INTO returns (return_id, sale_id, product_id, branch_id, quantity, reason, status, return_date, processed_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssissss", $return_id, $sale_id, $product_id, $branch_id, $quantity, $reason, $status, $return_date, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            if ($status === 'Approved') updateInventory($conn, $product_id, $branch_id, $quantity);
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Return created successfully.'];
        } else {
            return ['success' => false, 'message' => 'DB error: ' . mysqli_stmt_error($stmt)];
        }
    } else {
        return ['success' => false, 'message' => implode(", ", $errors)];
    }
}

function updateReturnStatus($return_id, $new_status, $old_status, $quantity, $product_id, $branch_id) {
    global $conn;
    mysqli_begin_transaction($conn);
    try {
        $stmt = mysqli_prepare($conn, "UPDATE returns SET status = ? WHERE return_id = ?");
        mysqli_stmt_bind_param($stmt, "ss", $new_status, $return_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($new_status === 'Approved' && $old_status !== 'Approved') {
            updateInventory($conn, $product_id, $branch_id, $quantity);
        } elseif ($old_status === 'Approved' && $new_status !== 'Approved') {
            updateInventory($conn, $product_id, $branch_id, -$quantity);
        }
        mysqli_commit($conn);
        return ['success' => true, 'message' => 'Status updated.'];
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return ['success' => false, 'message' => 'Update failed.'];
    }
}

function deleteReturn($return_id, $status, $quantity, $product_id, $branch_id) {
    global $conn;
    mysqli_begin_transaction($conn);
    try {
        if ($status === 'Approved') {
            updateInventory($conn, $product_id, $branch_id, -$quantity);
        }
        $stmt = mysqli_prepare($conn, "DELETE FROM returns WHERE return_id = ?");
        mysqli_stmt_bind_param($stmt, "s", $return_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_commit($conn);
        return ['success' => true, 'message' => 'Return deleted.'];
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return ['success' => false, 'message' => 'Delete failed.'];
    }
}

function getReturnStats() {
    global $conn;
    $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM returns"))['c'];
    $pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM returns WHERE status='Pending'"))['c'];
    $approved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM returns WHERE status='Approved'"))['c'];
    $rejected = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM returns WHERE status='Rejected'"))['c'];
    return ['total' => $total, 'pending' => $pending, 'approved' => $approved, 'rejected' => $rejected];
}

function searchReturns($search) {
    global $conn;
    $like = "%$search%";
    $query = "SELECT r.return_id, r.sale_id, r.product_id, r.quantity, r.reason, r.status, DATE(r.return_date) as return_date, p.product_name
              FROM returns r
              JOIN product p ON r.product_id = p.Product_id
              WHERE r.sale_id LIKE ? OR r.product_id LIKE ? OR r.return_id LIKE ?
              ORDER BY r.return_date DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
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