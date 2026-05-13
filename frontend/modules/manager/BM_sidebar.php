

<?php

    $current_page=basename($_SERVER['PHP_SELF']);
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
                        <i class="fa-solid fa-chart-simple"></i> Dashboard</a>

                    <a href="#" class="nav-link" class="nav-link ">
                        <i class="fa-solid fa-box-archive"></i> Inventory Management</a>

                    <a href="BM_stock_request.php" class="nav-link <?php echo ($current_page=='BM_stock_request.php')? 'active' :''?>">
                        <i class="fa-solid fa-cart-shopping"></i> Stock Requests <span class="badge red">3</span>
                    </a>
                    <a href="#" class="nav-link"><i class="fa-solid fa-arrow-right-arrow-left"></i> Inter-Branch Transfer</a>
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-circle-exclamation"></i> Damaged Items <span class="badge red">5</span>
                    </a>
                   
                </nav>
            </div>

            <div class="menu-section settings-section"> 
                <p class="menu-title">SETTINGS</p>
                <nav>
                    <a href="BM_setting.php" class="nav-link <?php echo ($current_page=="BM_setting.php")? 'active' :'' ?>"><i class="fa-solid fa-gear"></i> Settings</a>
                </nav>
            </div>

            <div class="user-profile">
                <div class="avatar">KP</div>
                <div class="user-info">
                    <span class="user-name">Kumara Perera</span>
                    <span class="user-role">Branch Manager</span>
                </div>
            </div>
        </aside>
</body>
</html>



