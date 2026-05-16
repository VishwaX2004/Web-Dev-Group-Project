<?php
// 1. Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "retail_system"; 

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Insert Data (Form Submit karaddi)
if (isset($_POST['btn_submit'])) {
    $branchId = mysqli_real_escape_string($conn, $_POST['branchId']);
    $supplierId = mysqli_real_escape_string($conn, $_POST['supplierId']);
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);
    $qty = (int)$_POST['qty'];
    $status = "Pending";



    // SQL Insert Query (Image_48593f.jpg ekata galapena widiyata)
   $sql = "INSERT INTO stock_requests (branch_id, supplier_id, product_id, quantity, status, requested_date) 
        VALUES ('$branchId', '$supplierId', '$productId', '$qty', '$status', NOW())";

    if (mysqli_query($conn, $sql)) {
        // Success notification ekak dila page eka refresh karanawa
       
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="container">
        <?php include 'BM_sidebar.php'; ?>

        <main class="main-content">
            <header class="header-bar">
                <h2 class="title-text">Stock Requests</h2>
                <div class="top-right-info">
                    <div class="location-tag">📍 Colombo Branch — B001</div>
                    <div class="notif-btn">🔔<span class="notif-dot"></span></div>
                </div>
            </header>

            <div class="action-bar">
                <button class="btn btn-primary" onclick="openModal()"><i class="fa-solid fa-plus"></i> CREATE</button>
                <button class="btn btn-dark" onclick="window.location.reload()"><i class="fa-solid fa-rotate-right"></i> REFRESH</button>
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h4>Stock Request List</h4>
                    <p>All replenishment requests for Colombo Branch</p>
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
                        // 3. Load Data from Database
                        $fetch_sql = "SELECT * FROM stock_requests ORDER BY requested_date DESC";
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
                            echo "<tr><td colspan='7' style='text-align:center;'>No records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Form -->
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
                        <input class="form-input" name="branchId" placeholder="e.g. B001" required>
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