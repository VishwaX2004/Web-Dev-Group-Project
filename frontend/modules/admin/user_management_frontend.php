<?php
require_once __DIR__ . '/../../../backend/api/admin/user_management_backend.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Retail System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../../frontend/assets/css/admin_sidebar.css">
    <link rel="stylesheet" href="../../../frontend/assets/css/user_management.css">
</head>
<body>
      <?php include("../../includes/admin_sidebar.php"); ?>

    <div class="main-content">
        <div class="page-header">
            <div class="page-title">
                <h1>User Management</h1>
                <p>Manage system access and employee roles across all branches.</p>
            </div>
            <?php if (!$editUser && !isset($_GET['add'])): ?>
                <a href="?add=true" class="btn-primary">
                    <i class="fas fa-plus"></i> Add New User
                </a>
            <?php endif; ?>
        </div>

        <?php if ($message): ?>
            <div class="alert <?php echo $messageType; ?>">
                <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['add']) || $editUser): ?>
        <div class="form-container">
            <h3><?php echo $editUser ? 'Edit User' : 'Add New User'; ?></h3>
            
            <form method="POST" action="" id="userForm">
                <?php if ($editUser): ?>
                    <input type="hidden" name="user_id" value="<?php echo $editUser['user_id']; ?>">
                    <input type="hidden" name="edit_submit" value="1">
                <?php else: ?>
                    <input type="hidden" name="add_submit" value="1">
                    <div class="auto-id-info">
                        <i class="fas fa-info-circle"></i> User ID will be auto-generated (USR-001, USR-002, ...)
                    </div>
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="full_name" id="fullName" required 
                               value="<?php echo $editUser ? htmlspecialchars($editUser['full_name']) : ''; ?>"
                               placeholder="Enter full name">
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" id="email" required 
                               value="<?php echo $editUser ? htmlspecialchars($editUser['email']) : ''; ?>"
                               placeholder="Enter email">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="role">
                            <option value="admin" <?php echo ($editUser && $editUser['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="manager" <?php echo ($editUser && $editUser['role'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                            <option value="cashier" <?php echo ($editUser && $editUser['role'] == 'cashier') ? 'selected' : ''; ?>>Cashier</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Branch ID</label>
                        <input type="text" name="branch_id" id="branchId" required 
                               value="<?php echo $editUser ? htmlspecialchars($editUser['branch_id']) : ''; ?>"
                               placeholder="e.g., BR-001">
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> <?php echo $editUser ? 'Update User' : 'Save User'; ?>
                    </button>
                    <a href="user_management_frontend.php" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search users by name, ID or email...">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Branch ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" style="text-align:center; padding:2rem;">No users found</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="user-row">
                                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <?php 
                                    $role_class = strtolower(htmlspecialchars($user['role']));
                                    ?>
                                    <span class="role-badge <?php echo $role_class; ?>">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($user['branch_id']); ?></td>
                                <td class="action-icons">
                                    <a href="?edit=<?php echo $user['user_id']; ?>" class="btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="?delete=<?php echo $user['user_id']; ?>" 
                                       class="btn-danger delete-btn"
                                       onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../../frontend/assets/js/user_management.js"></script>
</body>
</html>