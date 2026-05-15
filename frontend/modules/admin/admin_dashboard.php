<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin_dash.css">
</head>
<body>

<div>

<?php require_once __DIR__ . '/../../includes/admin_sidebar.php'; ?>


</div>

    <div class="main-content">
        <div class="header">
            <h1>  Admin Dashboard</h1>
            <p>WELCOME TO THE ADMIN PANEL</p>
        </div>

        
        <h2 class="title">System Modules</h2>

        <div class="card-container">
            <div class="card" id="users">
                <h3>User Management</h3>
                <p>Register new users and assign roles (Admin, Manager, Cashier)</p>
                <a href="../admin/user_management_frontend.php" class="btn">Manage Users →</a>
            </div>

            <div class="card" id="branches">
                <h3> Branch Management</h3>
                <p>Add and manage branch locations and contact details</p>
                <a href="../admin/branch_management_frontend.php" class="btn">Manage Branches →</a>
            </div>

            <div class="card" id="products">
                <h3> Product Management</h3>
                <p>Define product categories and prise list</p>
                <a href="../admin/product_management.php" class="btn">Manage Products →</a>
            </div>

            <div class="card" id="inventory">
                <h3> Inventory Overview</h3>
                <p>View of stock levels across all branches</p>
                <a href="../admin/admin_inventory_overview.php" class="btn">View Global Stock →</a>
            </div>

            <div class="card" id="suppliers">
                <h3>Supplier Management</h3>
                <p>Manage and add the supliers and informations</p>
                <a href="../admin/admin_supplier_managment.php" class="btn">Manage Suppliers →</a>
            </div>

            <div class="card" id="reports">
                <h3> Reports & Analytics</h3>
                <p>Monitor revenue, stock levels, and business losses</p>
                <a href="" class="btn">View Reports →</a>
            </div>
        </div>
    </div>

</body>
</html>