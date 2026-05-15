<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Security Check: Ensure user is logged in as cashier
if (!isset($_SESSION['auth']) || $_SESSION['role'] != 'cashier') {
    header("Location: ../../index.php");
    exit();
}

require_once '../../../backend/api/cashier/inventory_logic.php';

// Get user details for branch name
$user_id = $_SESSION['user_id'];
$query = "SELECT u.full_name, b.branch_name 
          FROM users u 
          JOIN branch b ON u.branch_id = b.branch_id 
          WHERE u.user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$display_name = $data['full_name'] ?? 'Cashier';
$display_branch = $data['branch_name'] ?? 'Main Branch';

$branch_id = $_SESSION['branch_id'];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$inventory_data = getInventoryData($branch_id, $search);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inventory - SmartPOS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/cashier_sidebar.css">
    <link rel="stylesheet" href="../../assets/css/cashier_inventory.css">
</head>
<body>

    <?php include("../../includes/cashier_sidebar.php"); ?>

    <div class="main">
        <div class="container">
            <div class="inventory-card">
                <h1>View Inventory</h1>
                <div class="subtitle">Real‑time stock levels for <?php echo htmlspecialchars($display_branch); ?></div>

                <div class="search-bar">
                    <form method="GET">
                        <input type="text" name="search" placeholder="Search by Product ID, Name, or Category..."
                               value="<?php echo htmlspecialchars($search); ?>">
                    </form>
                </div>

                <div style="overflow-x: auto;">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Stock Level</th>
                                <th>Status</th>
                                <th>Branch</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($inventory_data)): ?>
                                <tr><td colspan="7" style="text-align:center; padding: 30px; color: #64748B;">No products found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($inventory_data as $row):
                                    $level = (int)$row['quantity'];
                                    if ($level <= 5) {
                                        $badge = 'status-low';
                                        $status_text = 'Low Stock';
                                    } elseif ($level <= 20) {
                                        $badge = 'status-medium';
                                        $status_text = 'Medium';
                                    } else {
                                        $badge = 'status-high';
                                        $status_text = 'In Stock';
                                    }
                                    $last_updated = date('Y-m-d H:i');
                                ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($row['Product_id']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td>
                                    <td><?php echo $level; ?> units</td>
                                    <td><span class="status-badge <?php echo $badge; ?>"><?php echo $status_text; ?></span></td>
                                    <td><?php echo htmlspecialchars($display_branch); ?></td>
                                    <td style="color: #94A3B8; font-size: 13px;"><?php echo $last_updated; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="legend">
                    <div class="legend-item"><div class="legend-color high"></div> In Stock (21+ units)</div>
                    <div class="legend-item"><div class="legend-color medium"></div> Medium (6‑20 units)</div>
                    <div class="legend-item"><div class="legend-color low"></div> Low Stock (≤5 units)</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>