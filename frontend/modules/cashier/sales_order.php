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
    <title>Sales Order - SmartPOS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="stylesheet" href="../../assets/css/cashier_sales_order.css">

    <link rel="stylesheet" href="../../assets/css/cashier_sidebar.css">
</head>

<body>

    <?php include("../../includes/cashier_sidebar.php"); ?>

    <!-- MAIN -->
    <div class="main">

        <div class="page-header">
            <div class="header-info">
                <h1>Sales Order</h1>
                <p>Transaction ID: <span id="display-inv">#INV-8821</span></p>
            </div>
            <div class="btn-group">
                <button class="btn btn-outline"><i class="fa-solid fa-print"></i> Print Last</button>
                <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> New Customer</button>
            </div>
        </div>

        <div class="sales-grid">

            <!-- LEFT COLUMN -->
            <div class="left-col">
                <div class="card">
                    <div class="section-title"><i class="fa-solid fa-cart-plus" style="color:var(--primary)"></i>
                        Product Selection</div>

                    <div class="form-row">
                        <div class="input-group">
                            <label>Select Product</label>
                            <select id="product-select">
                                <option value="0" data-price="0">Choose item...</option>
                                <option value="Wireless Mouse" data-price="4500">Wireless Mouse (Rs. 4,500)</option>
                                <option value="Mechanical Keyboard" data-price="12000">Mechanical Keyboard (Rs. 12,000)
                                </option>
                                <option value="USB-C Hub" data-price="3500">USB-C Hub (Rs. 3,500)</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Quantity</label>
                            <input type="number" id="product-qty" value="1" min="1">
                        </div>
                    </div>

                    <button class="btn btn-primary" onclick="addToCart()" style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-plus"></i> Add to Order
                    </button>

                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-body">
                            <!-- Items added here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="right-col">
                <div class="summary-box">
                    <div class="section-title" style="color: white;">Order Summary</div>

                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span id="subtotal">Rs. 0.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Tax (5%)</span>
                        <span id="tax">Rs. 0.00</span>
                    </div>
                    <div class="summary-total">
                        <span>Grand Total</span>
                        <span id="grand-total">Rs. 0.00</span>
                    </div>
                </div>

                <div class="card payment-card">
                    <div class="section-title">Payment</div>
                    <div class="input-group">
                        <label>Amount Tendered</label>
                        <input type="number" id="amount-paid" placeholder="0.00" oninput="calcBalance()">
                    </div>
                    <div class="input-group">
                        <label>Change Balance</label>
                        <input type="text" id="balance" readonly placeholder="Rs. 0.00" style="background:#F1F5F9">
                    </div>
                    <button class="complete-btn" onclick="completeOrder()">
                        COMPLETE TRANSACTION
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script src="../../assets/js/cashier_dashboard.js"></script>
</body>

</html>