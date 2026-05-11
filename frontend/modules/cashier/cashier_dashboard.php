<?php
// ============================================
// CASHIER DASHBOARD - MAIN VIEW
// ============================================

session_start();
// Include database connection
include("../../../backend/config/db_connection.php");

// 1. SECURITY: Check if user is logged in and is a cashier
if (!isset($_SESSION['auth']) || $_SESSION['role'] != 'cashier') {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. DATA FETCHING: Get User and Branch details using JOIN
// Note: Using table 'branch' as per your structure
$query = "SELECT u.full_name, b.branch_name 
          FROM users u 
          JOIN branch b ON u.branch_id = b.branch_id 
          WHERE u.user_id = '$user_id' LIMIT 1";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$display_name = $data['full_name'] ?? 'Cashier';
$display_branch = $data['branch_name'] ?? 'Main Branch';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPOS - Cashier Dashboard</title>
    
    <link rel="stylesheet" href="../../assets/css/cashier_dashboard.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <?php include("../../includes/cashier_sidebar.php"); ?>

    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <h1>Cashier Dashboard</h1>
                <p>Welcome back, <strong><?php echo $display_name; ?></strong>!</p>
            </div>

            <div class="topbar-right"> 
                <div class="profile-header-card">
                    <div class="profile-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="profile-details">
                        <h4><?php echo $display_name; ?></h4>
                        <p><?php echo $display_branch; ?> • Cashier</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="cards">
            
            <div class="card card-blue">
                <div class="card-top">
                    <span class="card-label">Daily Sales</span>
                    <div class="card-icon"><i class="fa-solid fa-chart-line"></i></div>
                </div>
                <h2 class="card-value">Rs. 45,250.00</h2>
                <p class="card-status status-up"><i class="fa-solid fa-arrow-up"></i> +12% from yesterday</p>
            </div>

            <div class="card card-orange">
                <div class="card-top">
                    <span class="card-label">Stock Levels</span>
                    <div class="card-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                </div>
                <h2 class="card-value">1,240 <small>Items</small></h2>
                <p class="card-status status-neutral">Across all categories</p>
            </div>

            <div class="card card-green">
                <div class="card-top">
                    <span class="card-label">Recent Order</span>
                    <div class="card-icon"><i class="fa-solid fa-receipt"></i></div>
                </div>
                <h2 class="card-value">Rs. 1,850.00</h2>
                <p class="card-status status-neutral">Order ID: #ORD-9921</p>
            </div>

        </div>

        <div class="grid">
            <div class="sales-box">
                <div class="section-header">
                    <h3>Recent Transactions</h3>
                    <button class="view-all-btn">View All</button>
                </div>
                <div class="placeholder-chart">
                    <i class="fa-solid fa-chart-simple" style="font-size: 40px; margin-bottom: 10px; opacity: 0.2;"></i>
                    <p>Analytics Chart Placeholder</p>
                </div>
            </div>
            
            <div class="action-box">
                <h3 style="margin-bottom: 24px;">Quick Actions</h3>
                <button class="action-btn primary"><i class="fa-solid fa-plus"></i> New Sale</button>
                <button class="action-btn light"><i class="fa-solid fa-barcode"></i> Scan Item</button>
                <button class="action-btn light"><i class="fa-solid fa-print"></i> Last Receipt</button>
            </div>
        </div>
    </div>

</body>
</html>