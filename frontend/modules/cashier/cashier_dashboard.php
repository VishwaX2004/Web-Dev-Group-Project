<?php

// Start the PHP session to enable cross-page data persistence
session_start();

// Include the centralized database file
include("../../../backend/config/db_connection.php");

// Security Check: Verify if the user is authenticated and possesses the correct role
// If they are not logged in OR their role is anything other than 'cashier', redirect them to the index page
if (!isset($_SESSION['auth']) || $_SESSION['role'] != 'cashier') {

    header("Location: ../../index.php");

    exit(); 
}

// Retrieve the unique active user ID 
$user_id = $_SESSION['user_id'];

// SQL Query: Fetch the cashier's full name alongside their assigned branch name
$query = "SELECT u.full_name, b.branch_name, u.branch_id 
        FROM users u 
        JOIN branch b ON u.branch_id = b.branch_id 
        WHERE u.user_id = '$user_id' LIMIT 1";

$result = mysqli_query($conn, $query);         // Execute the query
$data = mysqli_fetch_assoc($result);          // Get the result set into an associative array

// Assing strings using the null coalescing operator (??) in case records are missing
$display_name = $data['full_name'] ?? 'Cashier';

$display_branch = $data['branch_name'] ?? 'Main Branch';

$branch_id = $data['branch_id'];



// Calculate Daily Sales Total
$today = date('Y-m-d'); // Fetch current server date in standard YYYY-MM-DD format

$sales_query = "SELECT SUM(price) as total_daily_sales FROM sales_order 
                WHERE branch_id = '$branch_id' 
                AND DATE(sale_date_time) = '$today'";

$sales_res = mysqli_query($conn, $sales_query);

$sales_data = mysqli_fetch_assoc($sales_res);

$daily_sales = $sales_data['total_daily_sales'] ?? 0; // Default to 0 

// Calculate Total Active Stock Levels
$stock_query = "SELECT SUM(quantity) as total_stock FROM inventory 
                WHERE branch_id = '$branch_id'";

$stock_res = mysqli_query($conn, $stock_query);

$stock_data = mysqli_fetch_assoc($stock_res);

$total_stock = $stock_data['total_stock'] ?? 0; // Default to 0 

// Retrieve Most Recent Order
$recent_card_query = "SELECT sale_id, price FROM sales_order 
                    WHERE branch_id = '$branch_id' 
                    ORDER BY sale_date_time DESC LIMIT 1";

$recent_card_res = mysqli_query($conn, $recent_card_query);

$recent_card_data = mysqli_fetch_assoc($recent_card_res);

$last_order_id = $recent_card_data['sale_id'] ?? 'N/A';

$last_order_price = $recent_card_data['price'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPOS - Cashier Dashboard</title>

    <!-- External and internal style links -->
    <link rel="stylesheet" href="../../assets/css/cashier_dashboard.css">
    <link rel="stylesheet" href="../../assets/css/cashier_sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- navigation sidebar -->
    <?php include("../../includes/cashier_sidebar.php"); ?>

    <!-- Main Content wrapper -->
    <div class="main">

        <!-- Upper Topbar Section -->
        <div class="topbar">
            <!-- Left Side Topbar: Dashboard Greeting Messages -->
            <div class="topbar-left">
                <h1>Cashier Dashboard</h1>
                <p>Welcome back, <strong><?php echo $display_name; ?></strong>!</p>
            </div>

            <!-- Right Side Topbar: Display Cashier Profile Card UI Component -->
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

        <!-- Cards -->
        <div class="cards">

            <!-- Card 1: Today's Sales -->
            <div class="card card-blue">
                <div class="card-top">
                    <span class="card-label">Daily Sales</span>

                    <div class="card-icon"><i class="fa-solid fa-chart-line"></i></div>
                </div>
                <!-- Format float price with 2 decimal points -->
                <h2 class="card-value">Rs. <?php echo number_format($daily_sales, 2); ?></h2>
                
                <p class="card-status status-up"><i class="fa-solid fa-arrow-up"></i> Today's Total</p>
            </div>

            <!-- Card 2: Total Inventory Quantity -->
            <div class="card card-orange">
                <div class="card-top">
                    <span class="card-label">Stock Levels</span>
                    <div class="card-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                </div>
                <h2 class="card-value"><?php echo number_format($total_stock); ?> <small>Items</small></h2>
                <p class="card-status status-neutral">Current branch stock</p>
            </div>

            <!-- Card 3: Last Sale Order -->
            <div class="card card-green">
                <div class="card-top">
                    <span class="card-label">Recent Order</span>
                    <div class="card-icon"><i class="fa-solid fa-receipt"></i></div>
                </div>
                <h2 class="card-value">Rs. <?php echo number_format($last_order_price, 2); ?></h2>
                <p class="card-status status-neutral">Order ID: #<?php echo $last_order_id; ?></p>
            </div>

        </div>

    </div>

</body>

</html>