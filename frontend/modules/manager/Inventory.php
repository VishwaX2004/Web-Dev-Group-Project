<?php
session_start();
include("../../../backend/config/db_connection.php");

// Fetch inventory data
$branch_id = $_SESSION['branch_id'] ?? 'BR-001'; // Default for demo if session not set
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
?>
<div class="export-wrapper">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100;200;300;400;500;600;700;800;900&family=Geist:wght@100;200;300;400;500;600;700;800;900&family=IBM+Plex+Mono:wght@100;200;300;400;500;600;700&family=IBM+Plex+Sans:wght@100;200;300;400;500;600;700&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900&family=PT+Serif:wght@400;700&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&family=Shantell+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  />
  <html>
    <head>
      <link rel="stylesheet" href="../../assets/css/styles.css">
    </head>
    <body>
      <div class="flex h-screen w-full bg-background font-body overflow-hidden">
        <div class="flex flex-col flex-1 min-w-0">
          <header
            class="h-16 bg-surface border-b border-border flex items-center justify-between px-6 shrink-0"
          >
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
              <a
                class="hover:text-foreground transition-colors"
                data-media-type="branch-management-link"
                ><span data-file="/components/Header.jsx" data-idx="0"
                  >Branch Management</span
                ></a
              >
              <div class="flex items-center gap-2">
                <iconify-icon
                  icon="lucide:chevron-right"
                  class="block size-[16px]"
                  style="font-size: 16px"
                ></iconify-icon
                ><a
                  class="hover:text-foreground transition-colors font-medium text-foreground"
                  data-media-type="inventory-link"
                  ><span
                    data-file="/screens/InventoryManagement.jsx"
                    data-idx="15"
                    >Inventory</span
                  ></a
                >
              </div>
            </div>
            <div class="flex items-center gap-4">
              <div class="relative">
                <iconify-icon
                  icon="lucide:bell"
                  class="block text-muted-foreground hover:text-foreground transition-colors size-[20px]"
                  style="font-size: 20px"
                ></iconify-icon
                ><span
                  class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-destructive text-[10px] font-bold text-destructive-foreground"
                  >3</span
                >
              </div>
              <div
                class="h-8 w-8 rounded-full bg-secondary flex items-center justify-center overflow-hidden border border-border"
              >
                <iconify-icon
                  icon="lucide:user"
                  class="block text-muted-foreground size-[16px]"
                  style="font-size: 16px"
                ></iconify-icon>
              </div>
            </div>
          </header>
          <main class="flex-1 p-6 overflow-y-auto">
            <div class="flex flex-col gap-6">
              <div class="flex items-start justify-between">
                <div>
                  <h1
                    class="text-2xl font-headings font-bold text-foreground flex items-center gap-3"
                  >
                    <span
                      data-file="/screens/InventoryManagement.jsx"
                      data-idx="16"
                      >Inventory Management</span
                    ><span
                      class="text-xs font-normal bg-secondary text-secondary-foreground px-2 py-1 rounded-full border border-border"
                      ><span
                        data-file="/screens/InventoryManagement.jsx"
                        data-idx="17"
                        >Branch: Colombo-01</span
                      ></span
                    >
                  </h1>
                  <p class="text-muted-foreground text-sm mt-1">
                    <span
                      data-file="/screens/InventoryManagement.jsx"
                      data-idx="18"
                      >Manage and monitor stock levels for your assigned
                      branch.</span
                    >
                  </p>
                </div>
                <div class="flex items-center gap-3">
                  <button
                    class="flex items-center gap-2 px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors"
                    data-media-type="export-button"
                  >
                    <iconify-icon
                      icon="lucide:download"
                      class="block size-[16px]"
                      style="font-size: 16px"
                    ></iconify-icon
                    ><span
                      data-file="/screens/InventoryManagement.jsx"
                      data-idx="19"
                      >Export</span
                    ></button
                  ><button
                    id="add-stock-btn"
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary/90 transition-colors"
                    data-media-type="add-stock-button"
                  >
                    <iconify-icon
                      icon="lucide:plus"
                      class="block size-[16px]"
                      style="font-size: 16px"
                    ></iconify-icon
                    ><span
                      data-file="/screens/InventoryManagement.jsx"
                      data-idx="20"
                      >Add Stock</span
                    >
                  </button>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement.jsx"
                          data-idx="21"
                          >Total Items in Stock</span
                        ></span
                      >
                      <div class="p-2 rounded-md bg-secondary text-primary">
                        <iconify-icon
                          icon="lucide:package"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                      <div
                        id="stat-total-items"
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        4,291
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <iconify-icon
                          icon="lucide:trending-up"
                          class="block text-success size-[14px]"
                          style="font-size: 14px"
                        ></iconify-icon
                        ><span class="text-success-text"
                          ><span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="22"
                            >+12% from last month</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden border-warning/50 shadow-[0_0_15px_rgba(245,158,11,0.1)]"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement.jsx"
                          data-idx="23"
                          >Low Stock Alerts</span
                        ></span
                      >
                      <div
                        class="p-2 rounded-md bg-warning-light text-warning-text"
                      >
                        <iconify-icon
                          icon="lucide:alert-triangle"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                      <div
                        id="stat-low-stock"
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        23
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <iconify-icon
                          icon="lucide:alert-triangle"
                          class="block text-warning size-[14px]"
                          style="font-size: 14px"
                        ></iconify-icon
                        ><span class="text-warning-text"
                          ><span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="24"
                            >5 items critical</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement.jsx"
                          data-idx="25"
                          >Total Categories</span
                        ></span
                      >
                      <div class="p-2 rounded-md bg-secondary text-primary">
                        <iconify-icon
                          icon="lucide:layers"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                      <div
                        id="stat-categories"
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        15
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <span class="text-muted-foreground"
                          ><span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="26"
                            >No change</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden"
                >
                  <div class="p-6 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium text-muted-foreground"
                        ><span
                          data-file="/screens/InventoryManagement.jsx"
                          data-idx="27"
                          >Recent Adjustments</span
                        ></span
                      >
                      <div class="p-2 rounded-md bg-secondary text-primary">
                        <iconify-icon
                          icon="lucide:edit-3"
                          class="block size-[18px]"
                          style="font-size: 18px"
                        ></iconify-icon>
                      </div>
                    </div>
                    <div>
                      <div
                        class="text-2xl font-headings font-bold text-foreground"
                      >
                        142
                      </div>
                      <div class="flex items-center gap-1 mt-1 text-xs">
                        <iconify-icon
                          icon="lucide:trending-down"
                          class="block text-destructive size-[14px]"
                          style="font-size: 14px"
                        ></iconify-icon
                        ><span class="text-destructive"
                          ><span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="28"
                            >-5% vs last week</span
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden flex-1"
              >
                <div
                  class="px-6 py-4 border-b border-border flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                >
                  <h3
                    class="font-headings font-semibold text-lg text-foreground"
                  >
                    <span
                      data-file="/screens/InventoryManagement.jsx"
                      data-idx="29"
                      >Current Stock</span
                    >
                  </h3>
                  <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:w-64">
                      <iconify-icon
                        icon="lucide:search"
                        class="block absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground size-[16px]"
                        style="font-size: 16px"
                      ></iconify-icon>
                      <input
                        id="inventory-search"
                        type="text"
                        placeholder="Search items..."
                        class="w-full pl-9 pr-4 py-2 bg-input border border-border rounded-md text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                      />
                    </div>
                    <button
                      class="flex items-center gap-2 px-3 py-2 border border-border bg-surface text-sm rounded-md hover:bg-secondary transition-colors"
                      data-media-type="filter-button"
                    >
                      <iconify-icon
                        icon="lucide:filter"
                        class="block size-[16px]"
                        style="font-size: 16px"
                      ></iconify-icon
                      ><span class="hidden sm:inline"
                        ><span
                          data-file="/screens/InventoryManagement.jsx"
                          data-idx="31"
                          >Filter</span
                        ></span
                      >
                    </button>
                  </div>
                </div>
                <div class="overflow-x-auto">
                  <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                      <tr class="bg-secondary/50 border-b border-border">
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="32"
                            >Item Details</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="33"
                            >Category</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="34"
                            >Stock Quantity</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                        >
                          <span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="35"
                            >Status</span
                          >
                        </th>
                        <th
                          class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-right"
                        >
                          <span
                            data-file="/screens/InventoryManagement.jsx"
                            data-idx="36"
                            >Actions</span
                          >
                        </th>
                      </tr>
                    </thead>
                    <tbody id="inventory-table-body" class="divide-y divide-border">
                      <!-- Table rows will be rendered by JS -->
                    </tbody>
                  </table>
                </div>
                <div
                  class="px-6 py-4 border-t border-border flex items-center justify-between"
                >
                  <span class="text-sm text-muted-foreground"
                    ><span
                      data-file="/screens/InventoryManagement.jsx"
                      data-idx="39"
                      >Showing 1 to 5 of 4,291 entries</span
                    ></span
                  >
                  <div class="flex items-center gap-1">
                    <button
                      class="px-3 py-1 border border-border rounded-md text-sm text-muted-foreground hover:bg-secondary disabled:opacity-50"
                      disabled=""
                      data-media-type="prev-page-button"
                    >
                      <span
                        data-file="/screens/InventoryManagement.jsx"
                        data-idx="40"
                        >Prev</span
                      ></button
                    ><button
                      class="px-3 py-1 bg-primary text-primary-foreground rounded-md text-sm font-medium"
                      data-media-type="page-1-button"
                    >
                      1</button
                    ><button
                      class="px-3 py-1 border border-border rounded-md text-sm hover:bg-secondary"
                      data-media-type="page-2-button"
                    >
                      2</button
                    ><button
                      class="px-3 py-1 border border-border rounded-md text-sm hover:bg-secondary"
                      data-media-type="page-3-button"
                    >
                      3</button
                    ><span class="px-2 text-muted-foreground">...</span
                    ><button
                      class="px-3 py-1 border border-border rounded-md text-sm text-foreground hover:bg-secondary"
                      data-media-type="next-page-button"
                    >
                      <span
                        data-file="/screens/InventoryManagement.jsx"
                        data-idx="41"
                        >Next</span
                      >
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </body>
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <script>
        // Pass PHP data to JavaScript
        const inventoryData = <?php echo json_encode($inventory_list); ?>;
    </script>
    <script src="../../assets/js/inventory.js"></script>
  </html>
</div>
