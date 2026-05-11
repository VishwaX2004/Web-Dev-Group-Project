<?php
// Set current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Get name and branch from the variables set in dashboard
$sidebar_name = isset($display_name) ? $display_name : 'Cashier';
$sidebar_branch = isset($display_branch) ? $display_branch : 'Branch';
?>

<div class="sidebar">
    <div class="logo">
        <div class="logo-icon">
            <i class="fa-solid fa-store"></i>
        </div>
        <div class="logo-text">
            <h2>SmartPOS</h2>
            <p>Cashier Panel</p>
        </div>
    </div>

    <div class="menu">
        <a href="cashier_dashboard.php" class="<?php echo ($current_page == 'cashier_dashboard') ? 'active' : ''; ?>">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>
        <a href="sales.php" class="<?php echo ($current_page == 'sales') ? 'active' : ''; ?>">
            <i class="fa-solid fa-cash-register"></i>
            <span>Sales</span>
        </a>
        <a href="returns.php" class="<?php echo ($current_page == 'returns') ? 'active' : ''; ?>">
            <i class="fa-solid fa-rotate-left"></i>
            <span>Returns</span>
        </a>
        
        <div class="sidebar-divider"></div>
        
        <a href="../../index.php" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>

    <div class="sidebar-user-card">
        <div class="user-avatar">
            <?php echo strtoupper(substr($sidebar_name, 0, 1)); ?>
        </div>
        <div class="user-info">
            <span class="user-name"><?php echo $sidebar_name; ?></span>
            <span class="user-branch"><?php echo $sidebar_branch; ?></span>
        </div>
    </div>
</div>