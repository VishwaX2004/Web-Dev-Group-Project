<?php
session_start();
include("../../../backend/config/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventory_id = $_POST['inventory_id'] ?? '';

    if (empty($inventory_id)) {
        header("Location: BM_Inventory.php?err=" . urlencode("Inventory ID is required."));
        exit;
    }

    $query = "DELETE FROM inventory WHERE inventory_id = '$inventory_id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: BM_Inventory.php?msg=" . urlencode("Record deleted successfully."));
        exit;
    } else {
        header("Location: BM_Inventory.php?err=" . urlencode("Failed to delete record: " . mysqli_error($conn)));
        exit;
    }
} else {
    header("Location: BM_Inventory.php?err=" . urlencode("Method not allowed."));
    exit;
}
?>
