<?php
session_start();
include("../../../backend/config/db_connection.php");

// Fetch transfer history
$branch_id = $_SESSION['branch_id'] ?? 'BR-001'; // Default for demo if session not set
$query = "SELECT t.transfer_id as id, sb.branch_name as source, db.branch_name as destination, p.product_name as product, t.quantity, t.status, 'Recently' as date
          FROM inter_branch_transfer t
          JOIN branch sb ON t.source_branch_id = sb.branch_id
          JOIN branch db ON t.dest_branch_id = db.branch_id
          JOIN product p ON t.product_id = p.Product_id
          WHERE t.source_branch_id = '$branch_id' OR t.dest_branch_id = '$branch_id'";
$result = mysqli_query($conn, $query);
$transfer_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $transfer_list[] = $row;
}
?>
<div class="export-wrapper">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100;200;300;400;500;600;700;800;900&family=Geist:wght@100;200;300;400;500;600;700;800;900&family=IBM+Plex+Mono:wght@100;200;300;400;500;600;700&family=IBM+Plex+Sans:wght@100;200;300;400;500;600;700&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900&family=PT+Serif:wght@400;700&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&family=Shantell+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <html>

  <head>
    <link rel="stylesheet" href="../../assets/css/styles.css">
  </head>

  <body>
    <div class="flex h-screen w-full bg-background font-body overflow-hidden">
      <div class="flex flex-col flex-1 min-w-0">
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-6 shrink-0">
          <div class="flex items-center gap-2 text-sm text-muted-foreground">
            <a class="hover:text-foreground transition-colors" data-media-type="branch-management-link"><span
                data-file="/components/Header.jsx" data-idx="0">Branch Management</span></a>
            <div class="flex items-center gap-2">
              <iconify-icon icon="lucide:chevron-right" class="block size-[16px]"
                style="font-size: 16px"></iconify-icon><a
                class="hover:text-foreground transition-colors font-medium text-foreground"
                data-media-type="inter-branch-transfer-link"><span data-file="/screens/new_screen1.jsx"
                  data-idx="16">Inter-Branch Transfer</span></a>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <div class="relative">
              <iconify-icon icon="lucide:bell"
                class="block text-muted-foreground hover:text-foreground transition-colors size-[20px]"
                style="font-size: 20px"></iconify-icon><span
                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-destructive text-[10px] font-bold text-destructive-foreground">3</span>
            </div>
            <div
              class="h-8 w-8 rounded-full bg-secondary flex items-center justify-center overflow-hidden border border-border">
              <iconify-icon icon="lucide:user" class="block text-muted-foreground size-[16px]"
                style="font-size: 16px"></iconify-icon>
            </div>
          </div>
        </header>
        <main class="flex-1 p-6 overflow-y-auto">
          <div class="flex flex-col gap-6">
            <div class="flex items-start justify-between">
              <div>
                <h1 class="text-2xl font-headings font-bold text-foreground flex items-center gap-3">
                  <span data-file="/screens/new_screen1.jsx" data-idx="17">Inter-Branch Transfer</span>
                </h1>
                <p class="text-muted-foreground text-sm mt-1">
                  <span data-file="/screens/new_screen1.jsx" data-idx="18">Create and monitor stock movements between
                    branch
                    locations.</span>
                </p>
              </div>
              <div class="flex items-center gap-3">
                <button
                  class="flex items-center gap-2 px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors"
                  data-media-type="export-history-button">
                  <iconify-icon icon="lucide:download" class="block size-[16px]"
                    style="font-size: 16px"></iconify-icon><span data-file="/screens/new_screen1.jsx"
                    data-idx="19">Export History</span></button><button
                  class="flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary-hover transition-colors"
                  data-media-type="new-transfer-button">
                  <iconify-icon icon="lucide:plus" class="block size-[16px]"
                    style="font-size: 16px"></iconify-icon><span data-file="/screens/new_screen1.jsx" data-idx="20">New
                    Transfer</span>
                </button>
              </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <div class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden lg:col-span-1 h-fit">
                <div class="px-6 py-4 border-b border-border">
                  <h3 class="font-headings font-semibold text-lg text-foreground">
                    <span data-file="/screens/new_screen1.jsx" data-idx="21">Create Transfer Order</span>
                  </h3>
                  <p class="text-sm text-muted-foreground mt-1">
                    <span data-file="/screens/new_screen1.jsx" data-idx="22">Initiate a new stock movement</span>
                  </p>
                </div>
                <div class="p-6 flex flex-col gap-4">
                  <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-foreground"><span data-file="/screens/new_screen1.jsx"
                        data-idx="23">Source Branch</span></label>
                    <div
                      class="border border-border rounded-md px-3 py-2 bg-input text-muted-foreground flex justify-between items-center cursor-not-allowed opacity-70">
                      <span data-file="/screens/new_screen1.jsx" data-idx="24">Colombo Main
                        (Assigned)</span><iconify-icon icon="lucide:lock" class="block size-[16px]"
                        style="font-size: 16px"></iconify-icon>
                    </div>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-foreground"><span data-file="/screens/new_screen1.jsx"
                        data-idx="25">Destination Branch</span></label>
                    <div id="dest-branch-select"
                      class="border border-border rounded-md px-3 py-2 bg-input text-foreground flex justify-between items-center cursor-pointer hover:border-primary transition-colors"
                      data-media-type="destination-branch-button">
                      <span data-file="/screens/new_screen1.jsx" data-idx="26">Select Destination...</span><iconify-icon
                        icon="lucide:chevron-down" class="block text-muted-foreground size-[16px]"
                        style="font-size: 16px"></iconify-icon>
                    </div>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-foreground"><span data-file="/screens/new_screen1.jsx"
                        data-idx="27">Product</span></label>
                    <div id="product-select"
                      class="border border-border rounded-md px-3 py-2 bg-input text-foreground flex justify-between items-center cursor-pointer hover:border-primary transition-colors"
                      data-media-type="product-select-button">
                      <span data-file="/screens/new_screen1.jsx" data-idx="28">Search or select
                        product...</span><iconify-icon icon="lucide:search"
                        class="block text-muted-foreground size-[16px]" style="font-size: 16px"></iconify-icon>
                    </div>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-foreground"><span data-file="/screens/new_screen1.jsx"
                        data-idx="29">Quantity</span></label>
                    <div id="qty-input"
                      class="border border-border rounded-md px-3 py-2 bg-input text-foreground flex justify-between items-center">
                      <span class="text-muted-foreground"><span data-file="/screens/new_screen1.jsx" data-idx="30">Enter
                          quantity...</span></span>
                      <div class="flex flex-col">
                        <iconify-icon icon="lucide:chevron-up"
                          class="block text-muted-foreground hover:text-foreground cursor-pointer size-[12px]"
                          style="font-size: 12px"></iconify-icon><iconify-icon icon="lucide:chevron-down"
                          class="block text-muted-foreground hover:text-foreground cursor-pointer size-[12px]"
                          style="font-size: 12px"></iconify-icon>
                      </div>
                    </div>
                  </div>
                  <div class="pt-2 mt-2 border-t border-border">
                    <button id="submit-transfer-btn"
                      class="w-full bg-accent text-accent-foreground py-2.5 rounded-md font-medium flex items-center justify-center gap-2 hover:bg-accent/90 transition-colors shadow-sm"
                      data-media-type="submit-transfer-button">
                      <iconify-icon icon="lucide:send" class="block size-[16px]"
                        style="font-size: 16px"></iconify-icon><span data-file="/screens/new_screen1.jsx"
                        data-idx="31">Submit Transfer</span>
                    </button>
                  </div>
                </div>
              </div>
              <div class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden lg:col-span-2">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                  <h3 class="font-headings font-semibold text-lg text-foreground">
                    <span data-file="/screens/new_screen1.jsx" data-idx="32">Transfer History</span>
                  </h3>
                  <div class="flex items-center gap-3">
                    <div class="flex items-center bg-input border border-border rounded-md px-3 py-1.5">
                      <iconify-icon icon="lucide:search" class="block text-muted-foreground mr-2 size-[14px]"
                        style="font-size: 14px"></iconify-icon><input id="transfer-search" type="text"
                        placeholder="Search ID..."
                        class="bg-transparent border-none text-sm text-foreground focus:outline-none w-full" />
                    </div>
                    <button
                      class="flex items-center gap-2 px-3 py-1.5 border border-border rounded-md text-sm font-medium text-foreground hover:bg-secondary transition-colors"
                      data-media-type="filter-button">
                      <iconify-icon icon="lucide:filter" class="block size-[14px]"
                        style="font-size: 14px"></iconify-icon><span data-file="/screens/new_screen1.jsx"
                        data-idx="34">Filter</span>
                    </button>
                  </div>
                </div>
                <div class="overflow-x-auto">
                  <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                      <tr class="bg-secondary/50 border-b border-border">
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                          <span data-file="/screens/new_screen1.jsx" data-idx="35">Transfer ID</span>
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                          <span data-file="/screens/new_screen1.jsx" data-idx="36">Route</span>
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                          <span data-file="/screens/new_screen1.jsx" data-idx="37">Product</span>
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                          <span data-file="/screens/new_screen1.jsx" data-idx="38">Status</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="transfer-table-body" class="divide-y divide-border">
                      <!-- Table rows will be rendered by JS -->
                    </tbody>
                  </table>
                </div>
                <div class="px-6 py-4 border-t border-border flex items-center justify-center">
                  <button class="text-sm text-primary font-medium hover:text-primary-hover transition-colors"
                    data-media-type="view-all-transfers-button">
                    <span data-file="/screens/new_screen1.jsx" data-idx="40">View All Transfers</span>
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
    const transferData = <?php echo json_encode($transfer_list); ?>;
  </script>
  <script src="../../assets/js/transfer.js"></script>

  </html>
</div>
