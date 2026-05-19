<?php
session_start();
include("../../../backend/config/db_connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventory_id = $_POST['inventory_id'] ?? '';

    if (empty($inventory_id)) {
        echo json_encode(['success' => false, 'message' => 'Inventory ID is required.']);
        exit;
    }

    $query = "DELETE FROM inventory WHERE inventory_id = '$inventory_id'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Record deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete record: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>
