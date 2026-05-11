<?php
// ============================================
// CASHIER AUTHENTICATION & DATA FETCHING
// ============================================

session_start();

// Check if user is logged in
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: /Web-Dev-Group-Project/frontend/index.php");
    exit();
}

// Check role
if ($_SESSION['role'] !== 'cashier') {
    header("Location: /Web-Dev-Group-Project/frontend/index.php");
    exit();
}

// Database Connection
$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "retail_system";
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Get logged in user info and branch name from database
// Note: Ensure $_SESSION['user_id'] is set during your login process
$logged_user_id = $_SESSION['user_id'];
$query = "SELECT u.full_name, b.branch_name 
          FROM Users u 
          JOIN Branch b ON u.branch_id = b.branch_id 
          WHERE u.user_id = '$logged_user_id'";

$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

// Set display names for header and sidebar
$display_name = $user_data['full_name'] ?? 'User';
$display_branch = $user_data['branch_name'] ?? 'Branch';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPOS | Cashier Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/cashier_dashboard.css">
</head>

<body>

    <?php include '../../includes/cashier_sidebar.php'; ?>

    <div class="main">

        <div class="topbar">

            <div class="topbar-left">
                <h1>Dashboard</h1>
                <p>Welcome back, <strong><?php echo $display_name; ?></strong>!</p>
            </div>

            <div class="topbar-right">

                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search here...">
                </div>

                <div class="top-icon">
                    <i class="fa-regular fa-bell"></i>
                    <span class="notification-dot" style="position: absolute; top: 12px; right: 12px; width: 8px; height: 8px; background: #EF4444; border-radius: 50%; border: 2px solid #fff;"></span>
                </div>

                <div class="profile-header-card" style="display: flex; align-items: center; gap: 12px; padding: 6px 14px; background: #F8FAFC; border-radius: 14px; border: 1px solid #F1F5F9; cursor: pointer;">
                    <div class="profile-avatar" style="width: 40px; height: 40px; background: #DBEAFE; color: #2563EB; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div class="profile-details">
                        <h4 style="font-size: 13px; font-weight: 700; color: #1E293B;"><?php echo $display_name; ?></h4>
                        <p style="font-size: 11px; color: #64748B; font-weight: 500;"><?php echo $display_branch; ?></p>
                    </div>
                </div>

            </div>

        </div>

        <div class="cards">

            <div class="card">
                <div class="card-top">
                    <div class="card-title">Today's Revenue</div>
                    <div class="card-icon blue">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                </div>
                <h2>Rs.125K</h2>
                <span>+12.5% this week</span>
            </div>

            <div class="card">
                <div class="card-top">
                    <div class="card-title">Orders</div>
                    <div class="card-icon green">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>
                <h2>1,245</h2>
                <span style="color: #16A34A;">+8 new orders</span>
            </div>

            <div class="card">
                <div class="card-top">
                    <div class="card-title">Returns</div>
                    <div class="card-icon orange">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                </div>
                <h2>05</h2>
                <span style="color: #D97706;">Updated today</span>
            </div>

            <div class="card">
                <div class="card-top">
                    <div class="card-title">Low Stock</div>
                    <div class="card-icon red">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <h2>08</h2>
                <span style="color: #DC2626;">Need restock</span>
            </div>

        </div>

        <div class="grid">

            <div class="sales-box">
                <div class="section-header">
                    <h3>Sales Analytics</h3>
                    <button>View Report</button>
                </div>
                <div class="chart"></div>
            </div>

            <div class="action-box">
                <h3>Quick Actions</h3>

                <button class="action-btn primary">
                    <i class="fa-solid fa-plus"></i>
                    New Sale
                </button>

                <button class="action-btn light">
                    <i class="fa-solid fa-rotate-left"></i>
                    Process Return
                </button>

                <button class="action-btn light">
                    <i class="fa-solid fa-print"></i>
                    Print Receipt
                </button>

                <button class="action-btn light">
                    <i class="fa-solid fa-box"></i>
                    Check Inventory
                </button>
            </div>

        </div>

        <div class="table-box">
            <div class="section-header">
                <h3>Recent Orders</h3>
                <button>See All</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#INV001</td>
                        <td>
                            <div class="customer">
                                <div class="customer-icon"><i class="fa-solid fa-user"></i></div>
                                <span>Nimal Perera</span>
                            </div>
                        </td>
                        <td>Rs.4,500</td>
                        <td><span class="badge success">Paid</span></td>
                    </tr>
                    <tr>
                        <td>#INV002</td>
                        <td>
                            <div class="customer">
                                <div class="customer-icon"><i class="fa-solid fa-user"></i></div>
                                <span>Kamal Silva</span>
                            </div>
                        </td>
                        <td>Rs.8,200</td>
                        <td><span class="badge pending">Pending</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div> <script src="../../assets/js/cashier_dashboard.js"></script>

</body>

</html>