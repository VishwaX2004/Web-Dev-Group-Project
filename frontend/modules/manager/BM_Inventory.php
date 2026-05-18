<?php
session_start();

include("../../../backend/config/db_connection.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Branch ID එක සෙෂන් එකෙන් ගන්නවා
$branch_id = $_SESSION['branch_id'] ?? 'B001'; 


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


$cat_query = "SELECT DISTINCT category_name FROM product WHERE category_name IS NOT NULL AND category_name != ''";
$cat_result = mysqli_query($conn, $cat_query);
$categories = [];

if ($cat_result) {
    while ($cat_row = mysqli_fetch_assoc($cat_result)) {
        $categories[] = $cat_row['category_name'];
    }
} else {
    die("Category Query Failed: " . mysqli_error($conn));
}

// Fetch all products for the Add Stock dropdown
$prod_query = "SELECT DISTINCT product_name, category_name FROM product WHERE product_name IS NOT NULL AND product_name != '' ORDER BY product_name ASC";
$prod_result = mysqli_query($conn, $prod_query);
$all_products = [];
if ($prod_result) {
    while ($prod_row = mysqli_fetch_assoc($prod_result)) {
        $all_products[] = $prod_row;
    }
} else {
    die("Product Query Failed: " . mysqli_error($conn));
}

// 5. Calculate statistics directly on the server
$total_items = 0;
$low_stock_count = 0;
$categories_set = [];
foreach ($inventory_list as $item) {
    $total_items += intval($item['quantity']);
    if ($item['status'] === 'Low Stock' || $item['status'] === 'Critical') {
        $low_stock_count++;
    }
    if (!empty($item['category'])) {
        $categories_set[$item['category']] = true;
    }
}
$total_categories = count($categories_set);
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
            <div class="flex items-center gap-4">
              <div style="position: relative;">
                <iconify-icon icon="lucide:bell" class="text-muted" style="font-size: 20px"></iconify-icon>
                <span style="position: absolute; top: -4px; right: -4px; display: flex; height: 16px; width: 16px; align-items: center; justify-content: center; border-radius: 50%; background-color: var(--destructive); color: white; font-size: 10px; font-weight: 700;">3</span>
              </div>
              <div style="height: 32px; width: 32px; border-radius: 50%; background-color: var(--secondary); display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid var(--border);">
                <iconify-icon icon="lucide:user" class="text-muted" style="font-size: 16px"></iconify-icon>
              </div>
            </div>
        </header>

        <main class="main-content">
            <div class="flex flex-col gap-6">
                <div class="section-header">
                    <div>
                        <h1 class="page-title flex items-center gap-3">
                            Inventory Management
                            <span class="badge" style="background-color: var(--secondary); border: 1px solid var(--border); font-weight: 400;">Branch: Colombo-01</span>
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
                            <div style="padding: 0.5rem; border-radius: 0.375rem; background-color: var(--secondary); color: var(--primary);">
                                <iconify-icon icon="lucide:package" style="font-size: 18px"></iconify-icon>
                            </div>
                        </div>
                        <div id="stat-total-items" class="stat-value"><?php echo number_format($total_items); ?></div>
                        <div class="stat-trend trend-up">
                            <iconify-icon icon="lucide:trending-up"></iconify-icon>
                            <span>+12% from last month</span>
                        </div>
                    </div>

                    <div class="card stat-card" style="border-color: rgba(245, 158, 11, 0.5);">
                        <div class="stat-header">
                            <span class="text-sm font-medium text-muted">Low Stock Alerts</span>
                            <div style="padding: 0.5rem; border-radius: 0.375rem; background-color: var(--warning-light); color: var(--warning-text);">
                                <iconify-icon icon="lucide:alert-triangle" style="font-size: 18px"></iconify-icon>
                            </div>
                        </div>
                        <div id="stat-low-stock" class="stat-value"><?php echo htmlspecialchars($low_stock_count); ?></div>
                        <div class="stat-trend trend-down" style="color: var(--warning-text);">
                            <iconify-icon icon="lucide:alert-triangle"></iconify-icon>
                            <span>5 items critical</span>
                        </div>
                    </div>

                    <div class="card stat-card">
                        <div class="stat-header">
                            <span class="text-sm font-medium text-muted">Total Categories</span>
                            <div style="padding: 0.5rem; border-radius: 0.375rem; background-color: var(--secondary); color: var(--primary);">
                                <iconify-icon icon="lucide:layers" style="font-size: 18px"></iconify-icon>
                            </div>
                        </div>
                        <div id="stat-categories" class="stat-value"><?php echo htmlspecialchars($total_categories); ?></div>
                        <div class="stat-trend text-muted">
                            <span>No change</span>
                        </div>
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
                                <?php foreach ($inventory_list as $item): 
                                    $statusClass = 'badge-success';
                                    if ($item['status'] === 'Low Stock' || $item['status'] === 'Critical') {
                                        $statusClass = 'badge-warning';
                                    } else if ($item['status'] === 'Out of Stock') {
                                        $statusClass = ''; // Default/muted
                                    }
                                ?>
                                    <tr class="inventory-row">
                                        <td>
                                            <div class="flex flex-col">
                                                <span class="font-medium item-name"><?php echo htmlspecialchars($item['productName']); ?></span>
                                                <span class="text-sm text-muted item-id"><?php echo htmlspecialchars($item['productId']); ?></span>
                                            </div>
                                        </td>
                                        <td class="item-category">
                                            <?php echo htmlspecialchars($item['category']); ?>
                                        </td>
                                        <td>
                                            <span class="font-bold"><?php echo htmlspecialchars($item['quantity']); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $statusClass; ?>">
                                                <?php echo htmlspecialchars($item['status']); ?>
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <div class="flex items-center justify-end gap-2">
                                                <button class="btn btn-outline edit-stock-btn" 
                                                        style="border: none; padding: 0.25rem; cursor: pointer;" 
                                                        title="Adjust Stock"
                                                        data-id="<?php echo htmlspecialchars($item['id']); ?>"
                                                        data-name="<?php echo htmlspecialchars($item['productName']); ?>"
                                                        data-quantity="<?php echo htmlspecialchars($item['quantity']); ?>">
                                                    <iconify-icon icon="lucide:edit-2" style="font-size: 16px"></iconify-icon>
                                                </button>
                                                <form action="BM_delete_inventory_action.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" style="display:inline;">
                                                    <input type="hidden" name="inventory_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                                    <button type="submit" class="btn btn-outline" style="border: none; padding: 0.25rem; color: var(--destructive); cursor: pointer;" title="Delete Record">
                                                        <iconify-icon icon="lucide:trash-2" style="font-size: 16px"></iconify-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-header" style="background-color: var(--surface);">
                        <span class="text-sm text-muted">Showing entries</span>
                        <div class="flex gap-1">
                            <button class="btn btn-outline" style="padding: 0.25rem 0.75rem;" disabled>Prev</button>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.75rem;">1</button>
                            <button class="btn btn-outline" style="padding: 0.25rem 0.75rem;">2</button>
                            <button class="btn btn-outline" style="padding: 0.25rem 0.75rem;">Next</button>
                        </div>
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
            <form id="add-stock-form" action="BM_add_inventory_action.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Item Name</label>
                        <!-- Dropdown select for Add New Stock -->
                        <select name="product_name" id="product-name-select" class="form-control" required>
                            <option value="" disabled selected>Select Product...</option>
                            <?php foreach ($all_products as $prod): ?>
                                <option value="<?php echo htmlspecialchars($prod['product_name']); ?>" data-category="<?php echo htmlspecialchars($prod['category_name']); ?>">
                                    <?php echo htmlspecialchars($prod['product_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Readonly textbox for Adjust Stock -->
                        <input type="text" name="product_name" id="product-name-input" class="form-control" readonly style="display: none;" disabled />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category_name" required class="form-control">
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
        // Simple PHP alerts for success/failure redirects
        <?php if (isset($_GET['msg'])): ?>
            alert("<?php echo htmlspecialchars($_GET['msg']); ?>");
        <?php endif; ?>
        <?php if (isset($_GET['err'])): ?>
            alert("Error: <?php echo htmlspecialchars($_GET['err']); ?>");
        <?php endif; ?>

        // Clear query parameters from URL to prevent showing alerts again on page refresh
        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('msg');
            url.searchParams.delete('err');
            window.history.replaceState({ path: url.href }, '', url.href);
        }
    </script>
    <script src="../../assets/js/manager_logic.js"></script>
    <script src="../../assets/js/inventory.js"></script>
</body>
</html>