<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include("../../../backend/config/db_connection.php");


$current_user_id = $_SESSION['user_id'] ?? 'U002'; 


$sql = "SELECT full_name, role FROM users WHERE user_id = '$current_user_id' LIMIT 1";
$result = mysqli_query($conn, $sql);


$display_name = "Branch Manager";
$display_role = "Manager";
$initials = "BM";

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $display_name = $row['full_name'];
    $display_role = $row['role'];

    
    $parts = explode(" ", $display_name);
    if (count($parts) >= 2) {
        $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
    } else {
        $initials = strtoupper(substr($parts[0], 0, 1));
    }
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/BM_sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <div class="logo-box">BM</div>
            <div class="brand-info">
                <span class="brand-name">Smart POS</span>
                <span class="version">Multi Branch Retail System</span>
            </div>
        </div>

        <div class="menu-section">
            <p class="menu-title">MAIN MENU</p>
            <nav>
                <a href="BM_Dashboard.php" class="nav-link <?php echo ($current_page=='BM_Dashboard.php')? 'active' :'';?>">
                    <i class="fa-solid fa-chart-simple"></i> Dashboard
                </a>
                <a href="BM_Inventory.php" class="nav-link <?php echo ($current_page=="BM_Inventory.php")? 'active' :'' ?>"><i class="fa-solid fa-box-archive"></i> Inventory Management</a>

                <a href="BM_stock_request.php" class="nav-link <?php echo ($current_page=='BM_stock_request.php')? 'active' :''?>">
                    <i class="fa-solid fa-cart-shopping"></i> Stock Requests 
                </a>

                

                <a href="BM_Inter_Branch_Transfer.php"class="nav-link <?php echo ($current_page=="BM_Inter_Branch_Transfer.php")? 'active' :'' ?>"><i class="fa-solid fa-arrow-right-arrow-left"></i> Inter-Branch Transfer</a>



                <a href="BM_damaged_item.php" class="nav-link <?php echo ($current_page=="BM_damaged_item.php")? 'active' :'' ?>"><i class="fa-solid fa-circle-exclamation"></i> Damaged Items</a>
               
            </nav>
        </div>

        <div class="menu-section settings-section"> 
            <p class="menu-title">SETTINGS</p>
            <nav>
                <a href="BM_setting.php" class="nav-link <?php echo ($current_page=="BM_setting.php")? 'active' :'' ?>">
                    <i class="fa-solid fa-gear"></i> Settings
                </a>
            </nav>
        </div>

        <div class="user-profile">
            <div class="avatar"><?php echo htmlspecialchars($initials); ?></div>
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($display_name); ?></span>
                <span class="user-role"><?php echo ucfirst(htmlspecialchars($display_role)); ?></span>
            </div>
        </div>
    </aside>
</body>
</html>
