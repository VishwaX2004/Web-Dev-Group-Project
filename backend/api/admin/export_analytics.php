<?php
// Session eka patan gannawa (System eke login wela inna user ge details ganna)
session_start();

// Database connection file eka link karanawa
include("../../../backend/config/db_connection.php"); 

// 'export_excel' kiyana button eka click karalada kiyala check karanawa
if(isset($_POST['export_excel'])) {
    
    // Download wena CSV file ekata namak hadanawa, ada dawasath (date) ekkama
    $filename = "System_Analytics_Report_" . date('Y-m-d') . ".csv";
    
    // Browser ekata kiyanawa meka screen eke pennanna epa, kelinma download karanna (attachment) kiyala
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");
    
    // File ekak hadala ekata liyanna (write mode - 'w') open karanawa, output eka kelinma browser ekata yawanna
    $file = fopen('php://output', 'w');
    
    // Excel sheet eke uda peliye (Column titles) thiyenna ona nam tika array ekakata gannawa
    $headers = array("Product ID", "Product Name", "Category", "Total Sold Qty", "Total Revenue (LKR)", "Current Inventory Qty", "Total Damaged Qty");
    
    // Ara gaththa column titles tika CSV file ekata liyanawa
    fputcsv($file, $headers);
    
    // Main query eka: Product table eken data aran, anith tables (sales, inventory, damage) walin total ganna subqueries use karanawa
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
    
    // SQL query eka database eke run karanawa
    $result = mysqli_query($conn, $query);
    
    // Database eke data (rows) thiyenawada kiyala check karanawa
    if (mysqli_num_rows($result) > 0) {
        
        // Data thiyenawanam, eka peliya gane (row by row) gannawa
        while ($row = mysqli_fetch_assoc($result)) {
            
            // Row eke data tika line ekakata (array) gannawa
            $lineData = array(
                $row['Product_id'], 
                $row['product_name'], 
                $row['category_name'], 
                $row['total_sales_qty'], 
                // Salli gana (revenue) dashama sthana 2kata (2 decimal places) hadanawa
                number_format($row['total_revenue'], 2, '.', ''), 
                $row['current_inventory'], 
                $row['total_damaged']
            );
            
            // Ara hadagaththa data array eka CSV file ekata liyanawa
            fputcsv($file, $lineData);
        }
    } else {
        // Data mokuth nattam, "No records found" kiyala excel file eke liyanawa
        fputcsv($file, array("No records found in the database"));
    }
    
    // File eka close karala, script eka nawathanawa
    fclose($file);
    exit;
}
?>