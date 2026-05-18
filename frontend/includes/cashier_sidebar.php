<?php
// Find out the name of the current file to highlight the active menu button
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<div class="sidebar">

    <!-- Logo Section -->
    <div class="logo">
        <div class="logo-icon">
            <!-- Bolt Icon -->
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div class="logo-text">
            <h2>Smart POS</h2>
            <p>RETAIL SYSTEM</p>
        </div>
    </div>

    <!-- Navigation Menu Links -->
    <div class="menu">

        <!-- Link to Dashboard (Highlights if active) -->
        <a href="cashier_dashboard.php" class="<?php echo ($current_page == 'cashier_dashboard.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <!-- Link to Sales Orders (Highlights if active) -->
        <a href="sales_order.php" class="<?php echo ($current_page == 'sales_order.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-file-invoice"></i>
            <span>Sales Orders</span>
        </a>

        <!-- Link to Return Processing (Highlights if active) -->
        <a href="returns.php" class="<?php echo ($current_page == 'returns.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-box-open"></i>
            <span>Return Processing</span>
        </a>

        <!-- Link to Inventory Page (Highlights if active) -->
        <a href="inventory.php" class="<?php echo ($current_page == 'inventory.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>View Inventory</span>
        </a>
        
        <!-- Separation Line -->
        <div class="sidebar-divider"></div>

        <!-- Log Out Button -->
        <a href="../../../backend/api/logout.php" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Log Out</span>
        </a>
        
    </div>

    <!-- User Profile Card at the Bottom -->
    <div class="sidebar-user-card">

        <!-- User Avatar Circle -->
        <div class="user-avatar">
            <?php 
            // Show the first letter of the user's name in uppercase. Show 'U' if no name is found.
            echo isset($display_name) ? strtoupper(substr($display_name, 0, 1)) : 'U'; 
            ?>
        </div>

        <!-- User Text Info -->
        <div class="user-info">
            <!-- User's Name -->
            <span class="user-name"><?php echo isset($display_name) ? $display_name : 'Cashier'; ?></span>

            <!-- Branch Location -->
            <span class="user-branch">
                <i class="fa-solid fa-location-dot" style="font-size: 9px;"></i> 
                <?php echo isset($display_branch) ? $display_branch : 'Branch Name'; ?>
            </span>
        </div>

    </div>

</div>