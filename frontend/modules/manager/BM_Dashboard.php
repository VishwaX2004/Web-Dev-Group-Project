<?php
// 1. Session is start
session_start();


include("../../../backend/config/db_connection.php");


//Null coalescing operator 
//thma log wela nathm user default id ekk denwa 
//id eka null unoth db ekn data enne na
$user_id = $_SESSION['user_id'] ?? 'USR-004';


$user_branch_query = "SELECT u.branch_id, b.branch_name 
                      FROM users u 
                      INNER JOIN branch b ON u.branch_id = b.branch_id 
                      WHERE u.user_id = '$user_id' LIMIT 1";

$user_branch_result = mysqli_query($conn, $user_branch_query);
$user_branch_row = mysqli_fetch_assoc($user_branch_result);

$branch_id = $user_branch_row['branch_id'] ?? 'BR-001';
$branch_name = $user_branch_row['branch_name'] ?? 'Unknown';


// connect db 

// get total stock count 
$stock_query = "SELECT SUM(quantity) AS total_stock FROM inventory WHERE branch_id = '$branch_id'";
$stock_result = mysqli_query($conn, $stock_query);
$stock_row = mysqli_fetch_assoc($stock_result);
// stock nathm 0 wenwa
$total_stock = $stock_row['total_stock'] ?? 0;

// get Pending Requests 
$pending_query = "SELECT COUNT(*) AS pending_count FROM stock_requests WHERE branch_id = '$branch_id' AND status = 'Pending'";
$pending_result = mysqli_query($conn, $pending_query);
$pending_row = mysqli_fetch_assoc($pending_result);
$pending_count = $pending_row['pending_count'] ?? 0;

// get  Damaged Items 

$damaged_query = "SELECT COUNT(*) AS total_damaged FROM damaged_item WHERE branch_id = '$branch_id'";
$damaged_result = mysqli_query($conn, $damaged_query);

$total_damaged = 0;

// when sql query fail not popup error massge becurse total-damged=0
if ($damaged_result) {
    $damaged_row = mysqli_fetch_assoc($damaged_result);
    $total_damaged = $damaged_row['total_damaged'] ?? 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Branch Manager Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/BM_Dashboard.css" />
</head>
<body>

<div class="container">
    <?php include 'BM_sidebar.php'; ?>
</div>

<div class="main">
    <div class="topbar">
      <div class="topbar-title">Branch Overview</div>
      
      <div class="topbar-branch">
        
        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
        </svg>
        
        <?php echo $branch_name; ?> — <?php echo $branch_id; ?>
      </div>
      
      <div class="topbar-notif">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
        </svg>
        <span class="notif-dot"></span>
      </div>
    </div>

    <div class="content">
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon" style="background:#eff6ff;">📦</div>
          <div class="stat-label">Total Stock Items</div>
          <div class="stat-value"><?php echo number_format($total_stock); ?></div>
          <div class="stat-change up">↑ Real-time update</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon" style="background:#fef9c3;">📋</div>
          <div class="stat-label">Pending Requests</div>
          <div class="stat-value"><?php echo $pending_count; ?></div>
          <div class="stat-change amber">Awaiting Approval</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon" style="background:#fee2e2;">⚠️</div>
          <div class="stat-label">Damaged Items</div>
          <div class="stat-value"><?php echo number_format($total_damaged); ?></div>
          <div class="stat-change red">To be reviewed</div>
        </div>
      </div>

      <div class="section-title">Recent Activity</div>
      <div class="activity-card">
        <div class="activity-row">
          <div class="activity-dot" style="background:#4169E1;"></div>
          <div class="activity-msg">New stock request raised — Product ID: P-0214, Qty: 50</div>
          <span class="status-pill pill-amber">Pending</span>
          <div class="activity-time">10 min ago</div>
        </div>
        <div class="activity-row">
          <div class="activity-dot" style="background:#16a34a;"></div>
          <div class="activity-msg">Inter-branch transfer from Kandy Branch received successfully</div>
          <span class="status-pill pill-green">Received</span>
          <div class="activity-time">1 hr ago</div>
        </div>
        <div class="activity-row">
          <div class="activity-dot" style="background:#dc2626;"></div>
          <div class="activity-msg">Damaged items reported — Checking for write-off</div>
          <span class="status-pill pill-red">Rejected</span>
          <div class="activity-time">3 hrs ago</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>