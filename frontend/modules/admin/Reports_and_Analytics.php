<?php
session_start();

include("../../../backend/config/db_connection.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - Admin</title>
    <link rel="stylesheet" href="../../assets/css/admin_sidebar.css">
    <link rel="stylesheet" href="../../assets/css/Reports_and_Analytics.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <?php include 'admin_sidebar.php'; ?> 

    <div class="main-content">
        
        <header class="topbar">
            <div class="breadcrumb">
                <span>Admin</span>
                <span class="breadcrumb-sep">›</span>
                <span class="active">Reports & Analytics</span>
            </div>
        </header>

        <div class="page-body">
            <div class="page-header-section">
                <h1>Reports & Analytics</h1>
                <p>Aggregates data from Sales, Inventory, and Damaged Items for cross-branch insights.</p>
            </div>

            <div class="analytics-report-card">
                <div class="analytics-card-content">
                    <i class="fa-solid fa-file-excel analytics-icon"></i>
                    <h2 class="analytics-title">Comprehensive System Report</h2>
                    <p class="analytics-description">
                        Click the button below to generate and download an overall analytical report.<br>
                        This report compiles total sales quantities, generated revenue, current inventory levels, and damaged item records.
                    </p>
                    
                    <form action="export_analytics.php" method="POST">
                        <button type="submit" name="export_excel" class="analytics-btn-green">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Generate & Download Excel Report
                        </button>
                    </form>
                </div>
            </div>

            <div class="analytics-table-container">
                <table class="analytics-custom-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Total Sold Qty</th>
                            <th>Total Revenue (LKR)</th>
                            <th>Current Inventory</th>
                            <th>Total Damaged</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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
                                echo "<tr>";
                                echo "<td><span class='analytics-badge-id'>" . $row['Product_id'] . "</span></td>";
                                echo "<td><strong>" . htmlspecialchars($row['product_name']) . "</strong></td>";
                                echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
                                echo "<td>" . $row['total_sales_qty'] . "</td>";
                                echo "<td style='color: #16a34a; font-weight:600;'>" . number_format($row['total_revenue'], 2) . "</td>";
                                echo "<td>" . $row['current_inventory'] . "</td>";
                                echo "<td style='color: #dc2626; font-weight:600;'>" . $row['total_damaged'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center; padding: 30px;'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div> </div>
</body>
</html>