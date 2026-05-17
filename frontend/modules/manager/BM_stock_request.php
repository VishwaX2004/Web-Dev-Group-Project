<?php

// 1. Session is start
session_start();


include("../../../backend/config/db_connection.php");


//Null coalescing operator 
//thma log wela nathm user default id ekk denwa 
//id eka null unoth db ekn data enne na
$user_id = $_SESSION['user_id'] ?? 'U002';


$user_branch_query = "SELECT u.branch_id, b.branch_name 
                      FROM users u 
                      INNER JOIN branch b ON u.branch_id = b.branch_id 
                      WHERE u.user_id = '$user_id' LIMIT 1";

$user_branch_result = mysqli_query($conn, $user_branch_query);
$user_branch_row = mysqli_fetch_assoc($user_branch_result);

$branch_id = $user_branch_row['branch_id'] ?? 'B001';
$branch_name = $user_branch_row['branch_name'] ?? 'Unknown';


// 4. Insert Data 
if (isset($_POST['btn_submit'])) {
    // session eken gththa branch id eka gnnwa 
    $branchId = $branch_id; 
    $supplierId = $_POST['supplierId'];
    $productId  = $_POST['productId'];
    //quntity eka int karanwa mainly
    $qty = (int)$_POST['qty'];
    $status = "Pending";

    // SQL Insert Query
    $sql = "INSERT INTO stock_requests (branch_id, supplier_id, product_id, quantity, status, requested_date) 
            VALUES ('$branchId', '$supplierId', '$productId', '$qty', '$status', NOW())";

    if (mysqli_query($conn, $sql)) {
       
    } else {
        echo "<script>alert('❌ Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BranchPro – Stock Requests</title>
    <link rel="stylesheet" href="../../assets/css/BM_stock_request.css">
    //Font Awesome
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="container">
        <?php include 'BM_sidebar.php'; ?>

        <main class="main-content">
            <header class="header-bar">
                <h2 class="title-text">Stock Requests</h2>
                <div class="top-right-info">
                    
                    <div class="location-tag">
                       <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                    <?php echo $branch_name; ?> — <?php echo $branch_id; ?>
                    </div>
                    
                    <div class="notif-btn">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                            </svg><span class="notif-dot"></span>
                             </div>
                </div>
            </header>

            <div class="action-bar">
                <button class="btn btn-primary" onclick="openModal()"><i class="fa-solid fa-plus"></i> CREATE</button>
                <button class="btn btn-dark" onclick="window.location.reload()"><i class="fa-solid fa-rotate-right"></i> REFRESH</button>
                
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h4>Stock Request List</h4>
                    <p>All replenishment requests for <?php echo $branch_name; ?></p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>REQUEST ID</th>
                            <th>BRANCH ID</th>
                            <th>SUPPLIER ID</th>
                            <th>PRODUCT ID</th>
                            <th>QUANTITY</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php
                        
                        $fetch_sql = "SELECT * FROM stock_requests WHERE branch_id = '$branch_id' ORDER BY requested_date DESC";
                        $result = mysqli_query($conn, $fetch_sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $status_lower = strtolower($row['status']);
                                ?>
                                <tr>
                                    <td class="id-link">REQ-<?php echo $row['request_id']; ?></td>
                                    <td><?php echo $row['branch_id']; ?></td>
                                    <td><?php echo $row['supplier_id']; ?></td>
                                    <td class="id-link"><?php echo $row['product_id']; ?></td>
                                    <td><span class="qty-box"><?php echo $row['quantity']; ?></span></td>
                                    <td><?php echo $row['requested_date']; ?></td>
                                    <td><span class="status <?php echo $status_lower; ?>"><?php echo $row['status']; ?></span></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center;'>No records found for this branch.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <form method="POST">
                <div class="modal-header">
                    <h3>➕ New Stock Request</h3>
                    <button type="button" class="modal-close" onclick="closeModal()">❌</button>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Branch ID</label>
                        <input class="form-input" name="branchId" value="<?php echo $branch_id; ?>" readonly style="background: #f3f4f6; color: #6b7280; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Supplier ID</label>
                        <input class="form-input" name="supplierId" placeholder="e.g. SUP-901" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Product ID</label>
                        <input class="form-input" name="productId" placeholder="e.g. PROD-001" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input class="form-input" name="qty" type="number" placeholder="0" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="btn_submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../assets/js/BM_stock_request.js"></script>
</body>
</html>