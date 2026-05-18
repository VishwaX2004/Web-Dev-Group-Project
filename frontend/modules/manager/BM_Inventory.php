<?php
session_start();

include("../../../backend/config/db_connection.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Branch ID එක සෙෂන් එකෙන් ගන්නවා
$branch_id = $_SESSION['branch_id'] ?? 'B001'; 

// --- GET INVENTORY DATA (මේ බ්‍රාන්ච් එකට විතරයි) ---
$query = "SELECT i.inventory_id as id, 
                 i.product_id as productId, 
                 p.product_name as productName, 
                 p.category_name as category, 
                 i.quantity, 
                 i.status 
          FROM inventory i 
          INNER JOIN product p ON i.product_id = p.Product_id 
          WHERE i.branch_id = '$branch_id'";

$result = mysqli_query($conn, $query);
$inventory_list = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $inventory_list[] = $row;
    }
} else {
    die("Inventory Query Failed: " . mysqli_error($conn));
}

// --- GET CATEGORIES ---
$cat_query = "SELECT DISTINCT category_name FROM product WHERE category_name IS NOT NULL AND category_name != ''";
$cat_result = mysqli_query($conn, $cat_query);
$categories = [];

if ($cat_result) {
    while ($cat_row = mysqli_fetch_assoc($cat_result)) {
        $categories[] = $cat_row['category_name'];
    }
}

// --- GET ALL PRODUCTS FOR DROPDOWN ---
$prod_query = "SELECT Product_id, product_name, category_name FROM product";
$prod_result = mysqli_query($conn, $prod_query);
$all_products = [];

if ($prod_result) {
    while ($prod_row = mysqli_fetch_assoc($prod_result)) {
        $all_products[] = $prod_row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link class="main" rel="stylesheet" href="../../assets/css/manager_layout.css">
</head>
<body>
    <?php include 'BM_sidebar.php'; ?>
    
    <div class="main">
        <header class="dashboard-header">
            <div class="flex items-center gap-2 text-sm text-muted">
              <a href="#" class="text-muted">Branch Management</a>
              <div class="flex items-center gap-2">
                <iconify-icon icon="lucide:chevron-right" style="font-size: 16px"></iconify-icon>
                <span class="font-medium">Inventory</span>
              </div>
            </div>
        </header>

        <main class="main-content">
            <div class="flex flex-col gap-6">
                <div class="section-header">
                    <div>
                        <h1 class="page-title flex items-center gap-3">
                            Inventory Management
                            <span class="badge" style="background-color: var(--secondary); border: 1px solid var(--border); font-weight: 400;">Branch: <?php echo htmlspecialchars($branch_id); ?></span>
                        </h1>
                        <p class="page-subtitle">Manage and monitor stock levels for your assigned branch.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="add-stock-btn" class="btn btn-primary">
                            <iconify-icon icon="lucide:plus"></iconify-icon>
                            Add Stock
                        </button>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="card stat-card">
                        <div class="stat-header">
                            <span class="text-sm font-medium text-muted">Total Items in Stock</span>
                        </div>
                        <div id="stat-total-items" class="stat-value">0</div>
                    </div>
                    <div class="card stat-card" style="border-color: rgba(245, 158, 11, 0.5);">
                        <div class="stat-header">
                            <span class="text-sm font-medium text-muted">Low Stock Alerts</span>
                        </div>
                        <div id="stat-low-stock" class="stat-value">0</div>
                    </div>
                    <div class="card stat-card">
                        <div class="stat-header">
                            <span class="text-sm font-medium text-muted">Total Categories</span>
                        </div>
                        <div id="stat-categories" class="stat-value">0</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="font-bold text-sm">Current Stock</h3>
                        <div class="flex items-center gap-3">
                            <div style="position: relative;">
                                <iconify-icon icon="lucide:search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--muted-foreground); font-size: 16px;"></iconify-icon>
                                <input id="inventory-search" type="text" placeholder="Search items..." class="form-control" style="padding-left: 2.25rem; width: 16rem;" />
                            </div>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Item Details</th>
                                    <th>Category</th>
                                    <th>Stock Quantity</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inventory-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="add-stock-modal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="font-bold">Add New Stock</h3>
                <button id="close-modal-btn" class="btn btn-outline" style="border: none; padding: 0.25rem;">
                    <iconify-icon icon="lucide:x" style="font-size: 20px"></iconify-icon>
                </button>
            </div>
            <form id="add-stock-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Item Name</label>
                        <select name="product_id" id="product-name-select" class="form-control" required>
                            <option value="" disabled selected>Select Product...</option>
                            <?php foreach ($all_products as $prod): ?>
                                <option value="<?php echo htmlspecialchars($prod['Product_id']); ?>" data-category="<?php echo htmlspecialchars($prod['category_name']); ?>">
                                    <?php echo htmlspecialchars($prod['product_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category_name" id="category-select" required class="form-control" readonly style="pointer-events: none; background-color: #f3f4f6;">
                            <option value="" disabled selected>Select Category...</option>
                            <?php foreach ($categories as $cat_name): ?>
                                <option value="<?php echo htmlspecialchars($cat_name); ?>"><?php echo htmlspecialchars($cat_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" required min="1" placeholder="0" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-modal-btn" class="btn btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add to Inventory</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <script>
        const inventoryData = <?php 
            $cleaned_list = array_map(function($item) {
                $item['quantity'] = (int)$item['quantity'];
                return $item;
            }, $inventory_list);
            echo json_encode($cleaned_list); 
        ?>;
    </script>
    <script src="../../assets/js/manager_logic.js"></script>
    <script src="../../assets/js/inventory.js"></script>
</body>
</html>