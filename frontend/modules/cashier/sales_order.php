<?php
// Start the session to track logged-in users
session_start();

    // Connect to the database
    include("../../../backend/config/db_connection.php");

    // Security check: If the user isn't logged in OR is not a cashier, kick them out to index.php
    if (!isset($_SESSION['auth']) || $_SESSION['role'] != 'cashier') {

        header("Location: ../../index.php");

        exit();
    }

    // Get the logged-in user's ID
    $user_id = $_SESSION['user_id'];

    // Clean the user ID to prevent database security issues (SQL injection)
    $safe_user_id = mysqli_real_escape_string($conn, $user_id);

    // SQL query to find the cashier's full name and their assigned branch name
    $query = "SELECT u.full_name, u.branch_id, b.branch_name FROM users u 
            JOIN branch b ON u.branch_id = b.branch_id 
            WHERE u.user_id = '$safe_user_id' LIMIT 1";

    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);

    // Set fallback default text if the database returns empty info
    $display_name = $user_data['full_name'] ?? 'Cashier';

    $display_branch = $user_data['branch_name'] ?? 'Main Branch';

    $branch_id = $user_data['branch_id'] ?? 0;

    // Fetch all products that are currently in stock (> 0) for this specific branch
    $product_query = "SELECT p.product_id, p.product_name, p.price, i.quantity 
                    FROM product p 
                    INNER JOIN inventory i ON p.product_id = i.product_id 
                    WHERE i.quantity > 0 AND i.branch_id = '$branch_id'";
    $product_result = mysqli_query($conn, $product_query);

    // Fetch the 10 most recent transactions completed at this branch
    $history_query = "SELECT s.*, p.product_name FROM sales_order s 
                    JOIN product p ON s.product_id = p.product_id 
                    WHERE s.branch_id = '$branch_id' 
                    ORDER BY s.sale_date_time DESC LIMIT 10";
    $history_result = mysqli_query($conn, $history_query);
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Sales Order - SmartPOS</title>

    <!-- Link external stylesheets for web-icons (FontAwesome) and custom page layouts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="stylesheet" href="../../assets/css/cashier_sales_order.css">

    <link rel="stylesheet" href="../../assets/css/cashier_sidebar.css">

</head>

<body>
    <!-- Include the navigation sidebar standard across the cashier portal -->
    <?php include("../../includes/cashier_sidebar.php"); ?>

    <div class="main">
        <!-- Header area showing the branch name and the active cashier's name -->
        <div class="page-header">

            <div class="header-info">

                <h1>Sales Order - <?php echo htmlspecialchars($display_branch); ?></h1>

                <p>Cashier: <?php echo htmlspecialchars($display_name); ?></p>

            </div>
        </div>

        <div class="sales-grid">
            <!-- Left column: Handles item selections, temporary cart display, and recent logs -->
            <div class="left-col">

                <div class="card">

                    <div class="section-title"><i class="fa-solid fa-cart-plus"></i> Product Selection</div>
                    
                    <div class="form-row">
                        <!-- Dropdown choice field for available products -->
                        <div class="input-group">

                            <label>Select Product</label>

                            <select id="product-select">

                                <option value="">Choose item...</option>

                                <!-- Loop through the branch items database query results -->
                                <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
                                    <!-- Store extra product attributes directly in the HTML option tag data- attributes -->
                                    <option value="<?php echo $product['product_id']; ?>"
                                            data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                                            data-price="<?php echo $product['price']; ?>"
                                            data-stock="<?php echo $product['quantity']; ?>">
                                        <?php echo $product['product_id'] . " - " . htmlspecialchars($product['product_name']); ?> 
                                        (Stock: <?php echo $product['quantity']; ?>)
                                    </option>
                                <?php endwhile; ?>

                            </select>

                        </div>

                        <!-- Quantity Input Field -->
                        <div class="input-group">

                            <label>Quantity</label>

                            <input type="number" id="product-qty" value="1" min="1">
                        </div>

                    </div>

                    <!-- Button triggering JavaScript function to add selected item to the cart -->
                    <button class="btn btn-primary" onclick="addToCart()" style="width:100%;">Add to Order</button>

                    <!-- Table structure where JavaScript will actively render added cart items -->
                    <table class="cart-table" style="margin-top:20px;">

                        <thead>

                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th style="text-align:center;">Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody id="cart-body"></tbody>

                    </table>

                </div>

                <!-- History display table showing the latest 10 overall sales records -->
                <div class="card">

                    <div class="section-title"><i class="fa-solid fa-history"></i> Recent Branch Sales</div>

                    <table class="cart-table">

                        <thead>
                            <tr><th>Sale ID</th><th>Product</th><th>Qty</th><th>Total</th><th>Date</th></tr>
                        </thead>

                        <tbody>
                            <!-- Loop through database history query results -->
                            <?php while($row = mysqli_fetch_assoc($history_result)): ?>
                            <tr>
                                <td><small><?php echo $row['sale_id']; ?></small></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>Rs. <?php echo number_format($row['price'], 2); ?></td>
                                <td><small><?php echo $row['sale_date_time']; ?></small></td>
                            </tr>
                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- Right column: Handles calculation summary totals and payments -->
            <div class="right-col">

                <div class="summary-box">

                    <div class="summary-total">

                        <span>Grand Total</span>
                        <span id="grand-total">Rs. 0.00</span>

                    </div>

                </div>

                <div class="card payment-card">
                    <!-- Cash amount handed over by the buyer -->
                    <div class="input-group">

                        <label>Amount Tendered</label>

                        <input type="number" id="amount-paid" placeholder="0.00" oninput="calcBalance()">

                    </div>

                    <!-- Change return calculation display (Read-only box) -->
                    <div class="input-group">

                        <label>Change Balance</label>

                        <input type="text" id="balance" readonly placeholder="Rs. 0.00">

                    </div>
                    
                    <!-- Submission checkout confirmation button -->
                    <button class="complete-btn" onclick="completeOrder()">COMPLETE TRANSACTION</button>

                </div>

            </div>

        </div>

    </div>

    <!-- Hidden element used to store the active branch ID safely for JavaScript to grab later -->
    <input type="hidden" id="branch-id-val" value="<?php echo $branch_id; ?>">

    <!-- Link the logic script engine script -->
    <script src="../../assets/js/cashier_sales_order.js"></script>

</body>

</html>