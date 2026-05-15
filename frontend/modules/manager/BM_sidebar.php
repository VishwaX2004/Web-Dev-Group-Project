<?php
// 1. Session start කිරීම
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "retail_system"; 
$conn = mysqli_connect($host, $user, $pass, $db_name);

// 3. දැනට ලොග් වී සිටින Manager ගේ ID එක ගැනීම
// Login process එකේදී session එකට වැටෙන ID එක මෙතනට එනවා.
// පරීක්ෂා කරලා බලන්න පහසුවට USR-003 (Thisaru Thiwanka) default එකට දැම්මා.
$current_user_id = $_SESSION['user_id'] ?? 'USR-003'; 

// 4. Database එකෙන් නම සහ Role එක විතරක් Fetch කිරීම
$sql = "SELECT full_name, role FROM users WHERE user_id = '$current_user_id' LIMIT 1";
$result = mysqli_query($conn, $sql);

// Default අගයන් (කිසිම හේතුවකින් DB connection අවුල් වුනොත් පෙන්වන්න)
$display_name = "Branch Manager";
$display_role = "Manager";
$initials = "BM";

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $display_name = $row['full_name'];
    $display_role = $row['role'];

    // නමේ මුල් අකුරු (Initials) හදන logic එක
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
                <span class="brand-name">BranchPro</span>
                <span class="version">System Module v2.4</span>
            </div>
        </div>

        <div class="menu-section">
            <p class="menu-title">MAIN MENU</p>
            <nav>
                <a href="BM_Dashbord.php" class="nav-link <?php echo ($current_page=='BM_Dashbord.php')? 'active' :'';?>">
                    <i class="fa-solid fa-chart-simple"></i> Dashboard
                </a>
                <a href="#" class="nav-link"><i class="fa-solid fa-box-archive"></i> Inventory Management</a>
                <a href="BM_stock_request.php" class="nav-link <?php echo ($current_page=='BM_stock_request.php')? 'active' :''?>">
                    <i class="fa-solid fa-cart-shopping"></i> Stock Requests 
                </a>
                <a href="#" class="nav-link"><i class="fa-solid fa-arrow-right-arrow-left"></i> Inter-Branch Transfer</a>
                <a href="#" class="nav-link"><i class="fa-solid fa-circle-exclamation"></i> Damaged Items</a>
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