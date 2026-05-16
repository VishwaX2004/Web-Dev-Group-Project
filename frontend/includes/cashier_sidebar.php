<?php
// Get the current file name to highlight the active menu item
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">

    <div class="logo">

        <div class="logo-icon">

            <i class="fa-solid fa-bolt"></i>
        </div>

        <div class="logo-text">

            <h2>Smart POS</h2>
            <p>RETAIL SYSTEM</p>

        </div>
    </div>

    <div class="menu">

        <a href="cashier_dashboard.php" class="<?php echo ($current_page == 'cashier_dashboard.php') ? 'active' : ''; ?>">

            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>

        </a>

        <a href="sales_order.php" class="<?php echo ($current_page == 'sales_order.php') ? 'active' : ''; ?>">

            <i class="fa-solid fa-file-invoice"></i>
            <span>Sales Orders</span>

        </a>

        <a href="returns.php" class="<?php echo ($current_page == 'returns.php') ? 'active' : ''; ?>">

            <i class="fa-solid fa-box-open"></i>
            <span>Return Processing</span>

        </a>

        <a href="inventory.php" class="<?php echo ($current_page == 'inventory.php') ? 'active' : ''; ?>">

            <i class="fa-solid fa-boxes-stacked"></i>
            <span>View Inventory</span>

        </a>
        
        <div class="sidebar-divider"></div>

        <a href="../../../backend/api/logout.php" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Log Out</span>
        </a>
        
    </div>

    <div class="sidebar-user-card">

        <div class="user-avatar">

            <?php echo isset($display_name) ? strtoupper(substr($display_name, 0, 1)) : 'U'; ?>

        </div>

        <div class="user-info">

            <span class="user-name"><?php echo isset($display_name) ? $display_name : 'Cashier'; ?></span>

            <span class="user-branch">

                <i class="fa-solid fa-location-dot" style="font-size: 9px;"></i> 
                <?php echo isset($display_branch) ? $display_branch : 'Branch Name'; ?>

            </span>

        </div>

    </div>

</div>