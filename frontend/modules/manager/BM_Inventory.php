<?php
session_start();
include("../../../backend/config/db_connection.php");

// Fetch inventory data
$branch_id = $_SESSION['branch_id'] ?? 'B001'; 
$query = "SELECT i.inventory_id as id, i.product_id as productId, p.product_name as productName, c.category_name as category, i.quantity, i.status 
          FROM inventory i 
          JOIN product p ON i.product_id = p.Product_id 
          JOIN category c ON p.category_name = c.Category_id
          WHERE i.branch_id = '$branch_id'";
$result = mysqli_query($conn, $query);
$inventory_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $inventory_list[] = $row;
}

// Fetch categories for the modal
$cat_query = "SELECT Category_id, category_name FROM category";
$cat_result = mysqli_query($conn, $cat_query);
$categories = [];
while ($cat_row = mysqli_fetch_assoc($cat_result)) {
    $categories[] = $cat_row;
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
    <!-- Vanilla CSS Assets -->
    <link rel="stylesheet" href="../../assets/css/manager_layout.css">
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
                <!-- Page Title -->
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

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="card stat-card">
                        <div class="stat-header">
                            <span class="text-sm font-medium text-muted">Total Items in Stock</span>
                            <div style="padding: 0.5rem; border-radius: 0.375rem; background-color: var(--secondary); color: var(--primary);">
                                <iconify-icon icon="lucide:package" style="font-size: 18px"></iconify-icon>
                            </div>
                        </div>
                        <div id="stat-total-items" class="stat-value">0</div>
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
                        <div id="stat-low-stock" class="stat-value">0</div>
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
                        <div id="stat-categories" class="stat-value">0</div>
                        <div class="stat-trend text-muted">
                            <span>No change</span>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
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
                                <!-- Rendered by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
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

    <!-- Add Stock Modal -->
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
                        <input type="text" name="product_name" required placeholder="e.g. Organic Coffee Beans" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category_id" required class="form-control">
                            <option value="" disabled selected>Select Category...</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['Category_id']; ?>"><?php echo $cat['category_name']; ?></option>
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
        const inventoryData = <?php echo json_encode($inventory_list); ?>;
    </script>
    <!-- Vanilla JS Assets -->
    <script src="../../assets/js/manager_logic.js"></script>
    <script src="../../assets/js/inventory.js"></script>
</body>
</html>
