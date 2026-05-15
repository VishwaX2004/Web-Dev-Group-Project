<?php
session_start();
include("../../../backend/config/db_connection.php");

// Fetch transfer history
$branch_id = $_SESSION['branch_id'] ?? 'BR-001'; 
$query = "SELECT t.transfer_id as id, sb.branch_name as source, db.branch_name as destination, p.product_name as product, t.quantity, t.status, 'Recently' as date,
                 t.source_branch_id, t.dest_branch_id, t.product_id
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

// Fetch all branches for the modal
$branch_query = "SELECT branch_id, branch_name FROM branch";
$branch_result = mysqli_query($conn, $branch_query);
$branches = [];
while ($b_row = mysqli_fetch_assoc($branch_result)) {
    $branches[] = $b_row;
}

// Fetch all products for the modal
$product_query = "SELECT Product_id, product_name FROM product";
$product_result = mysqli_query($conn, $product_query);
$products = [];
while ($p_row = mysqli_fetch_assoc($product_result)) {
    $products[] = $p_row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inter-Branch Transfer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
        /* Force modal visibility and centering */
        #update-transfer-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-background font-body">
    <?php include 'BM_sidebar.php'; ?>
    
    <div class="main">
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-6 shrink-0">
          <div class="flex items-center gap-2 text-sm text-muted-foreground">
            <a class="hover:text-foreground transition-colors">Branch Management</a>
            <div class="flex items-center gap-2">
              <iconify-icon icon="lucide:chevron-right" style="font-size: 16px"></iconify-icon>
              <a class="hover:text-foreground transition-colors font-medium text-foreground">Inter-Branch Transfer</a>
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
            <div class="flex items-start justify-between">
              <div>
                <h1 class="text-2xl font-headings font-bold text-foreground flex items-center gap-3">Inter-Branch Transfer</h1>
                <p class="text-muted-foreground text-sm mt-1">Create and monitor stock movements between branch locations.</p>
              </div>
              <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors">
                  <iconify-icon icon="lucide:download" style="font-size: 16px"></iconify-icon>
                  Export History
                </button>
                <button class="flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary-hover transition-colors">
                  <iconify-icon icon="lucide:plus" style="font-size: 16px"></iconify-icon>
                  New Transfer
                </button>
              </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <!-- Create Form -->
              <div class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden lg:col-span-1 h-fit">
                <div class="px-6 py-4 border-b border-border">
                  <h3 class="font-headings font-semibold text-lg text-foreground">Create Transfer Order</h3>
                  <p class="text-sm text-muted-foreground mt-1">Initiate a new stock movement</p>
                </div>
                <form id="create-transfer-form" class="p-6 flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                      <label class="text-sm font-medium text-foreground">Source Branch</label>
                      <select name="source_branch_id" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="" disabled selected>Select Source...</option>
                        <?php foreach ($branches as $branch): ?>
                          <option value="<?php echo $branch['branch_id']; ?>" <?php echo ($branch['branch_id'] == $branch_id) ? 'selected' : ''; ?>>
                            <?php echo $branch['branch_name']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="flex flex-col gap-1.5">
                      <label class="text-sm font-medium text-foreground">Destination Branch</label>
                      <select name="dest_branch_id" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="" disabled selected>Select Destination...</option>
                        <?php foreach ($branches as $branch): ?>
                          <option value="<?php echo $branch['branch_id']; ?>"><?php echo $branch['branch_name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="flex flex-col gap-1.5">
                      <label class="text-sm font-medium text-foreground">Product</label>
                      <select name="product_id" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="" disabled selected>Search or select product...</option>
                        <?php foreach ($products as $product): ?>
                          <option value="<?php echo $product['Product_id']; ?>"><?php echo $product['product_name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="flex flex-col gap-1.5">
                      <label class="text-sm font-medium text-foreground">Quantity</label>
                      <input type="number" name="quantity" required min="1" placeholder="Enter quantity..." class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary" />
                    </div>
                    <button type="submit" class="w-full bg-primary text-primary-foreground py-2.5 rounded-md font-medium flex items-center justify-center gap-2 hover:bg-primary-hover transition-colors shadow-sm">
                      <iconify-icon icon="lucide:send" style="font-size: 16px"></iconify-icon>
                      <span>Submit Transfer</span>
                    </button>
                </form>
              </div>

              <!-- History Table -->
              <div class="bg-surface rounded-lg border border-border shadow-sm overflow-hidden lg:col-span-2">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                  <h3 class="font-headings font-semibold text-lg text-foreground">Transfer History</h3>
                  <div class="flex items-center gap-3">
                    <div class="flex items-center bg-input border border-border rounded-md px-3 py-1.5">
                      <iconify-icon icon="lucide:search" class="block text-muted-foreground mr-2" style="font-size: 14px"></iconify-icon>
                      <input id="transfer-search" type="text" placeholder="Search ID..." class="bg-transparent border-none text-sm text-foreground focus:outline-none w-full" />
                    </div>
                    <button class="flex items-center gap-2 px-3 py-1.5 border border-border rounded-md text-sm font-medium text-foreground hover:bg-secondary transition-colors">
                      <iconify-icon icon="lucide:filter" style="font-size: 14px"></iconify-icon>
                      Filter
                    </button>
                  </div>
                </div>
                
                <div style="width: 100%; overflow-x: auto; border-top: 1px solid #e5e7eb;">
                  <table style="width: 100%; min-width: 1100px; text-align: left; border-collapse: collapse;">
                    <thead>
                      <tr class="bg-secondary/50 border-b border-border">
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left" style="width: 150px;">Transfer ID</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left">Route</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left">Product</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-left">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider text-right">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="transfer-table-body" class="divide-y divide-border">
                      <!-- Rendered by JS -->
                    </tbody>
                  </table>
                </div>

                <div class="px-6 py-4 border-t border-border flex items-center justify-center">
                  <button class="text-sm text-primary font-medium hover:text-primary-hover transition-colors">
                    View All Transfers
                  </button>
                </div>
              </div>
            </div>
          </div>
        </main>
    </div>

    <!-- Update Transfer Modal -->
    <div id="update-transfer-modal">
        <div class="bg-surface rounded-lg border border-border shadow-xl w-full max-w-md overflow-hidden">
          <div class="px-6 py-4 border-b border-border flex items-center justify-between bg-secondary/30">
            <h3 class="font-headings font-semibold text-lg text-foreground">Update Transfer Order</h3>
            <button id="close-update-modal-btn" class="text-muted-foreground hover:text-foreground transition-colors p-1 rounded-md hover:bg-secondary">
              <iconify-icon icon="lucide:x" style="font-size: 20px"></iconify-icon>
            </button>
          </div>
          <form id="update-transfer-form">
            <input type="hidden" name="transfer_id" id="update-transfer-id" />
            <div class="p-6 flex flex-col gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground">Source Branch</label>
                <select name="source_branch_id" id="update-source-branch" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                  <?php foreach ($branches as $branch): ?>
                    <option value="<?php echo $branch['branch_id']; ?>"><?php echo $branch['branch_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground">Destination Branch</label>
                <select name="dest_branch_id" id="update-dest-branch" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                  <?php foreach ($branches as $branch): ?>
                    <option value="<?php echo $branch['branch_id']; ?>"><?php echo $branch['branch_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground">Status</label>
                <select name="status" id="update-status" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                  <option value="Pending">Pending</option>
                  <option value="Shipped">Shipped</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground">Product</label>
                <select name="product_id" id="update-product" required class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                  <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['Product_id']; ?>"><?php echo $product['product_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-foreground">Quantity</label>
                <input type="number" name="quantity" id="update-quantity" required min="1" class="border border-border rounded-md px-3 py-2 bg-input text-foreground text-sm focus:outline-none focus:ring-1 focus:ring-primary" />
              </div>
            </div>
            <div class="px-6 py-4 border-t border-border flex items-center justify-end gap-3">
              <button type="button" id="cancel-update-modal-btn" class="px-4 py-2 border border-border bg-surface text-sm font-medium rounded-md hover:bg-secondary transition-colors text-foreground">Cancel</button>
              <button type="submit" class="px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow-sm hover:bg-primary-hover transition-colors">Save Changes</button>
            </div>
          </form>
        </div>
    </div>

    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <script>
        // Data from PHP
        const transferData = <?php echo json_encode($transfer_list); ?>;

        // Function to show modal
        window.editTransfer = function(id) {
            console.log('Edit clicked for ID:', id);
            const item = transferData.find(t => t.id == id);
            if (!item) {
                console.error('No data found for ID:', id);
                return;
            }

            // Fill fields
            document.getElementById('update-transfer-id').value = item.id;
            document.getElementById('update-source-branch').value = item.source_branch_id || '';
            document.getElementById('update-dest-branch').value = item.dest_branch_id || '';
            document.getElementById('update-status').value = item.status || 'Pending';
            document.getElementById('update-product').value = item.product_id || '';
            document.getElementById('update-quantity').value = item.quantity || 0;

            // Show modal
            const modal = document.getElementById('update-transfer-modal');
            modal.style.display = 'flex';
        };
    </script>
    <script src="../../assets/js/transfer.js"></script>
</body>
</html>
