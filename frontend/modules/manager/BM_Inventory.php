<?php
session_start();
include("../../../backend/config/db_connection.php");

// Fetch inventory data
$branch_id = $_SESSION['branch_id'] ?? 'BR-001'; 
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
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-background font-body">
    <?php include 'BM_sidebar.php'; ?>
    
    <div class="main">
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-6 shrink-0">
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
              <a class="hover:text-foreground transition-colors" data-media-type="branch-management-link">Branch Management</a>
              <div class="flex items-center gap-2">
                <iconify-icon icon="lucide:chevron-right" class="block size-[16px]" style="font-size: 16px"></iconify-icon>
                <a class="hover:text-foreground transition-colors font-medium text-foreground">Inventory</a>
              </div>
            </div>
            <div class="flex items-center gap-4">
              <div class="relative">
                <iconify-icon icon="lucide:bell" class="block text-muted-foreground hover:text-foreground transition-colors size-[20px]" style="font-size: 20px"></iconify-icon>
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-destructive text-[10px] font-bold text-destructive-foreground">3</span>
              </div>
              <div class="h-8 w-8 rounded-full bg-secondary flex items-center justify-center overflow-hidden border border-border">
                <iconify-icon icon="lucide:user" class="block text-muted-foreground size-[16px]" style="font-size: 16px"></iconify-icon>
              </div>
            </div>
        </header>

        <main class="flex-1 p-6">
            <div class="flex flex-col gap-6">
                <!-- Page Title -->
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-headings font-bold text-foreground flex items-center gap-3">
                            Inventory Management
                            <span class="text-xs font-normal bg-secondary text-secondary-foreground px-2 py-1 rounded-full border border-border">Branch: Colombo-01</span>
                        </h1>
                        <p class="text-muted-foreground text-sm mt-1">Manage and monitor stock levels for your assigned branch.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button class="flex items-center gap-2 px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors">
                            <iconify-icon icon="lucide:download" class="block size-[16px]" style="font-size: 16px"></iconify-icon>
                            Export
                        </button>
                        <button id="add-stock-btn" class="flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary/90 transition-colors">
                            <iconify-icon icon="lucide:plus" class="block size-[16px]" style="font-size: 16px"></iconify-icon>
                            Add Stock
                        </button>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-surface rounded-lg border border-border shadow-sm p-5 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-muted-foreground">Total Items in Stock</span>
                            <div class="p-2 rounded-md bg-secondary text-primary">
                                <iconify-icon icon="lucide:package" class="block size-[18px]" style="font-size: 18px"></iconify-icon>
                            </div>
                        </div>
                        <div id="stat-total-items" class="text-2xl font-headings font-bold text-foreground">0</div>
                        <div class="flex items-center gap-1 text-xs text-success">
                            <iconify-icon icon="lucide:trending-up" style="font-size: 14px"></iconify-icon>
                            <span>+12% from last month</span>
                        </div>
                    </div>

                    <div class="bg-surface rounded-lg border border-border shadow-sm p-5 flex flex-col gap-4 border-warning/50">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-muted-foreground">Low Stock Alerts</span>
                            <div class="p-2 rounded-md bg-warning-light text-warning-text">
                                <iconify-icon icon="lucide:alert-triangle" class="block size-[18px]" style="font-size: 18px"></iconify-icon>
                            </div>
                        </div>
                        <div id="stat-low-stock" class="text-2xl font-headings font-bold text-foreground">0</div>
                        <div class="flex items-center gap-1 text-xs text-warning-text">
                            <iconify-icon icon="lucide:alert-triangle" style="font-size: 14px"></iconify-icon>
                            <span>5 items critical</span>
                        </div>
                    </div>

                    <div class="bg-surface rounded-lg border border-border shadow-sm p-5 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-muted-foreground">Total Categories</span>
                            <div class="p-2 rounded-md bg-secondary text-primary">
                                <iconify-icon icon="lucide:layers" class="block size-[18px]" style="font-size: 18px"></iconify-icon>
                            </div>
                        </div>
                        <div id="stat-categories" class="text-2xl font-headings font-bold text-foreground">0</div>
                        <div class="flex items-center gap-1 text-xs text-muted-foreground">
                            <span>No change</span>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden flex-1">
                    <div class="px-6 py-4 border-b border-border flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <h3 class="font-headings font-semibold text-lg text-foreground">Current Stock</h3>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <iconify-icon icon="lucide:search" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" style="font-size: 16px"></iconify-icon>
                                <input id="inventory-search" type="text" placeholder="Search items..." class="pl-9 pr-4 py-2 bg-input border border-border rounded-md text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary w-64" />
                            </div>
                            <button class="flex items-center gap-2 px-3 py-2 border border-border bg-surface text-sm rounded-md hover:bg-secondary transition-colors">
                                <iconify-icon icon="lucide:filter" style="font-size: 16px"></iconify-icon>
                                Filter
                            </button>
                        </div>
                    </div>
                    
                    <!-- Scrollable Table -->
                    <div style="width: 100%; overflow-x: auto; border-top: 1px solid #e5e7eb;">
                        <table style="width: 100%; min-width: 1000px; text-align: left; border-collapse: collapse;">
                            <thead>
                                <tr class="bg-secondary/50 border-b border-border">
                                    <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left">Item Details</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left">Category</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left">Stock Quantity</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left">Status</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inventory-table-body" class="divide-y divide-border">
                                <!-- Rendered by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-border flex items-center justify-between bg-surface">
                        <span class="text-sm text-muted-foreground">Showing 1 to 5 of entries</span>
                        <div class="flex items-center gap-1">
                            <button class="px-3 py-1 border border-border rounded-md text-sm text-muted-foreground hover:bg-secondary disabled:opacity-50" disabled>Prev</button>
                            <button class="px-3 py-1 bg-primary text-primary-foreground rounded-md text-sm font-medium">1</button>
                            <button class="px-3 py-1 border border-border rounded-md text-sm hover:bg-secondary">2</button>
                            <button class="px-3 py-1 border border-border rounded-md text-sm hover:bg-secondary">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Stock Modal -->
    <div id="add-stock-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-foreground/20 backdrop-blur-sm p-4 hidden">
        <div class="bg-surface rounded-lg border border-border shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                <h3 class="font-headings font-semibold text-lg text-foreground">Add New Stock</h3>
                <button id="close-modal-btn" class="text-muted-foreground hover:text-foreground transition-colors p-1 rounded-md hover:bg-secondary">
                    <iconify-icon icon="lucide:x" style="font-size: 20px"></iconify-icon>
                </button>
            </div>
            <form id="add-stock-form">
                <div class="p-6 flex flex-col gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-foreground">Item Name</label>
                        <input type="text" name="product_name" required placeholder="e.g. Organic Coffee Beans" class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-foreground">Category</label>
                        <select name="category_id" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%20stroke%3D%22currentColor%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%222%22%20d%3D%22m19%209-7%207-7-7%22%2F%3E%3C%2Fsvg%3E')] bg-[length:16px_16px] bg-[right_0.75rem_center] bg-no-repeat">
                            <option value="" disabled selected>Select Category...</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['Category_id']; ?>"><?php echo $cat['category_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-foreground">Quantity</label>
                        <input type="number" name="quantity" required min="1" placeholder="0" class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary" />
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-border bg-secondary/30 flex items-center justify-end gap-3">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors text-foreground">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary-hover transition-colors">Add to Inventory</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <script>
        const inventoryData = <?php echo json_encode($inventory_list); ?>;
    </script>
    <script src="../../assets/js/inventory.js"></script>
</body>
</html>
