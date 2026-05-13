<?php
session_start();
include("../../../backend/config/db_connection.php");

// SECURITY
if (!isset($_SESSION['auth']) || $_SESSION['role'] != 'cashier') {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// USER DETAILS
$safe_user_id = mysqli_real_escape_string($conn, $user_id);
$query = "
    SELECT u.full_name, b.branch_name 
    FROM users u 
    JOIN branch b ON u.branch_id = b.branch_id 
    WHERE u.user_id = '$safe_user_id' 
    LIMIT 1
";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

$display_name = $user_data['full_name'] ?? 'Cashier';
$display_branch = $user_data['branch_name'] ?? 'Main Branch';

// PRODUCTS WITH INVENTORY
$product_query = "
    SELECT p.product_id, p.product_name, p.price, i.quantity 
    FROM product p 
    INNER JOIN inventory i ON p.product_id = i.product_id 
    WHERE i.quantity > 0
";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Order - SmartPOS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/cashier_sales_order.css">
    <link rel="stylesheet" href="../../assets/css/cashier_sidebar.css">
</head>
<body>
    <?php include("../../includes/cashier_sidebar.php"); ?>

    <div class="main">
        <div class="page-header">
            <div class="header-info">
                <h1>Sales Order</h1>
                <p>Create and manage transactions</p>
            </div>
        </div>

        <div class="sales-grid">
            <div class="left-col">
                <div class="card">
                    <div class="section-title">
                        <i class="fa-solid fa-cart-plus" style="color:var(--primary)"></i>
                        Product Selection
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label>Select Product</label>
                            <select id="product-select">
                                <option value="">Choose item...</option>
                                <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
                                    <option value="<?php echo $product['product_id']; ?>" 
                                            data-name="<?php echo htmlspecialchars($product['product_name']); ?>" 
                                            data-price="<?php echo $product['price']; ?>" 
                                            data-stock="<?php echo $product['quantity']; ?>">
                                        <?php echo $product['product_id'] . " - " . $product['product_name']; ?> 
                                        (Stock: <?php echo $product['quantity']; ?>) - 
                                        Rs. <?php echo number_format($product['price'], 2); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Quantity</label>
                            <input type="number" id="product-qty" value="1" min="1">
                        </div>
                    </div>
                    <button class="btn btn-primary" onclick="addToCart()" style="width:100%;justify-content:center;">
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
                        <tbody id="cart-body"></tbody>
                    </table>
                </div>
            </div>

            <div class="right-col">
                <div class="summary-box">
                    <div class="section-title" style="color:white;">Order Summary</div>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span id="subtotal">Rs. 0.00</span>
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
                    <button class="complete-btn" onclick="completeOrder()">COMPLETE TRANSACTION</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../../assets/js/cashier_sales_order.js"></script>
</body>
</html>