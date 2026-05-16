<?php
session_start();


include("../../../backend/config/db_connection.php"); 

if(isset($_POST['export_excel'])) {
    
    
    $filename = "System_Analytics_Report_" . date('Y-m-d') . ".csv";
    
    
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");
    
    
    $file = fopen('php://output', 'w');
    
    
    $headers = array("Product ID", "Product Name", "Category", "Total Sold Qty", "Total Revenue (LKR)", "Current Inventory Qty", "Total Damaged Qty");
    fputcsv($file, $headers);
    
    
    $query = "
        SELECT 
            p.Product_id, 
            p.product_name, 
            p.category_name,
            (SELECT COALESCE(SUM(quantity), 0) FROM sales_order WHERE product_id = p.Product_id) AS total_sales_qty,
            (SELECT COALESCE(SUM(price), 0) FROM sales_order WHERE product_id = p.Product_id) AS total_revenue,
            (SELECT COALESCE(SUM(quantity), 0) FROM inventory WHERE product_id = p.Product_id) AS current_inventory,
            (SELECT COALESCE(SUM(quantity), 0) FROM damaged_item WHERE product_id = p.Product_id) AS total_damaged
        FROM product p
        ORDER BY p.Product_id ASC
    ";
    
    $result = mysqli_query($conn, $query);
    
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $lineData = array(
                $row['Product_id'], 
                $row['product_name'], 
                $row['category_name'], 
                $row['total_sales_qty'], 
                number_format($row['total_revenue'], 2, '.', ''), 
                $row['current_inventory'], 
                $row['total_damaged']
            );
            fputcsv($file, $lineData);
        }
    } else {
        
        fputcsv($file, array("No records found in the database"));
    }
    
    fclose($file);
    exit;
}
?>