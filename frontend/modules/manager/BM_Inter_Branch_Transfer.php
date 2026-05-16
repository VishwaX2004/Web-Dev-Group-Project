<?php
session_start();
include("../../../backend/config/db_connection.php");

// Fetch transfer history
$branch_id = $_SESSION['branch_id'] ?? 'B001'; 
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
              <span class="font-medium">Inter-Branch Transfer</span>
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
                <h1 class="page-title flex items-center gap-3">Inter-Branch Transfer</h1>
                <p class="page-subtitle">Create and monitor stock movements between branch locations.</p>
              </div>
              <div class="flex items-center gap-3">
                <button class="btn btn-outline">
                  <iconify-icon icon="lucide:download"></iconify-icon>
                  Export History
                </button>
                <button class="btn btn-primary">
                  <iconify-icon icon="lucide:plus"></iconify-icon>
                  New Transfer
                </button>
              </div>
            </div>

            <div class="stats-grid" style="grid-template-columns: repeat(1, minmax(0, 1fr)) 2fr; display: grid; gap: 1.5rem;">
              <!-- Create Form Card -->
              <div class="card h-fit">
                <div class="card-header">
                  <div>
                    <h3 class="font-bold">Create Transfer Order</h3>
                    <p class="text-sm text-muted">Initiate a new stock movement</p>
                  </div>
                </div>
                <form id="create-transfer-form" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <div class="form-group">
                      <label class="form-label">Source Branch</label>
                      <select name="source_branch_id" required class="form-control">
                        <option value="" disabled selected>Select Source...</option>
                        <?php foreach ($branches as $branch): ?>
                          <option value="<?php echo $branch['branch_id']; ?>" <?php echo ($branch['branch_id'] == $branch_id) ? 'selected' : ''; ?>>
                            <?php echo $branch['branch_name']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Destination Branch</label>
                      <select name="dest_branch_id" required class="form-control">
                        <option value="" disabled selected>Select Destination...</option>
                        <?php foreach ($branches as $branch): ?>
                          <option value="<?php echo $branch['branch_id']; ?>"><?php echo $branch['branch_name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Product</label>
                      <select name="product_id" required class="form-control">
                        <option value="" disabled selected>Search or select product...</option>
                        <?php foreach ($products as $product): ?>
                          <option value="<?php echo $product['Product_id']; ?>"><?php echo $product['product_name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Quantity</label>
                      <input type="number" name="quantity" required min="1" placeholder="Enter quantity..." class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary" style="justify-content: center; width: 100%; padding: 0.75rem;">
                      <iconify-icon icon="lucide:send"></iconify-icon>
                      <span>Submit Transfer</span>
                    </button>
                </form>
              </div>

              <!-- History Table Card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="font-bold">Transfer History</h3>
                  <div class="flex items-center gap-3">
                    <div style="position: relative;">
                      <iconify-icon icon="lucide:search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--muted-foreground); font-size: 14px;"></iconify-icon>
                      <input id="transfer-search" type="text" placeholder="Search ID..." class="form-control" style="padding-left: 2.25rem; font-size: 0.75rem; width: 12rem; height: 2.25rem;" />
                    </div>
                    <button class="btn btn-outline" style="padding: 0.375rem 0.75rem;">
                      <iconify-icon icon="lucide:filter" style="font-size: 14px"></iconify-icon>
                      Filter
                    </button>
                  </div>
                </div>
                
                <div class="table-container" style="border-top: 1px solid var(--border);">
                  <table class="data-table" style="min-width: 1100px;">
                    <thead>
                      <tr>
                        <th style="width: 150px;">Transfer ID</th>
                        <th>Route</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="transfer-table-body">
                      <!-- Rendered by JS -->
                    </tbody>
                  </table>
                </div>

                <div class="card-header" style="background-color: var(--surface); justify-content: center;">
                  <button class="btn" style="color: var(--primary); background: transparent; border: none;">
                    View All Transfers
                  </button>
                </div>
              </div>
            </div>
          </div>
        </main>
    </div>

    <!-- Update Transfer Modal -->
    <div id="update-transfer-modal" class="modal-overlay">
        <div class="modal-container">
          <div class="modal-header" style="background-color: rgba(243, 244, 246, 0.3);">
            <h3 class="font-bold">Update Transfer Order</h3>
            <button id="close-update-modal-btn" class="btn btn-outline" style="border: none; padding: 0.25rem;">
              <iconify-icon icon="lucide:x" style="font-size: 20px"></iconify-icon>
            </button>
          </div>
          <form id="update-transfer-form">
            <input type="hidden" name="transfer_id" id="update-transfer-id" />
            <div class="modal-body">
              <div class="form-group">
                <label class="form-label">Source Branch</label>
                <select name="source_branch_id" id="update-source-branch" required class="form-control">
                  <?php foreach ($branches as $branch): ?>
                    <option value="<?php echo $branch['branch_id']; ?>"><?php echo $branch['branch_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Destination Branch</label>
                <select name="dest_branch_id" id="update-dest-branch" required class="form-control">
                  <?php foreach ($branches as $branch): ?>
                    <option value="<?php echo $branch['branch_id']; ?>"><?php echo $branch['branch_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" id="update-status" required class="form-control">
                  <option value="Pending">Pending</option>
                  <option value="Shipped">Shipped</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Product</label>
                <select name="product_id" id="update-product" required class="form-control">
                  <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['Product_id']; ?>"><?php echo $product['product_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" id="update-quantity" required min="1" class="form-control" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="cancel-update-modal-btn" class="btn btn-outline">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
    </div>

    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <script>
        // Data from PHP
        const transferData = <?php echo json_encode($transfer_list); ?>;
    </script>
    <!-- Vanilla JS Assets -->
    <script src="../../assets/js/manager_logic.js"></script>
    <script src="../../assets/js/BM_transfer_helper.js"></script>
    <script src="../../assets/js/transfer.js"></script>
</body>
</html>
