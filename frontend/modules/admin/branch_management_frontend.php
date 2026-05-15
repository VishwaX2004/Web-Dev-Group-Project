<?php
require_once __DIR__ . '/../../../backend/api/admin/branch_management_backend.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management | Retail System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../../frontend/assets/css/admin_sidebar.css">
    <link rel="stylesheet" href="../../../frontend/assets/css/branch_management.css">
</head>
<body>
    <?php include __DIR__ . '/../../../frontend/includes/admin_sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="page-title">
                <h1>Branch Management</h1>
                <p>Manage store locations, contact details, and operational status.</p>
            </div>
            <?php if (!$editBranch && !isset($_GET['add'])): ?>
                <a href="?add=true" class="btn-primary">
                    <i class="fas fa-plus"></i> Add New Branch
                </a>
            <?php endif; ?>
        </div>

        <?php if ($message): ?>
            <div class="alert <?php echo $messageType; ?>">
                <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['add']) || $editBranch): ?>
        <div class="form-container">
            <h3><?php echo $editBranch ? 'Edit Branch' : 'Add New Branch'; ?></h3>
            
            <form method="POST" action="" id="branchForm">
                <?php if ($editBranch): ?>
                    <input type="hidden" name="branch_id" value="<?php echo htmlspecialchars($editBranch['branch_id']); ?>">
                    <input type="hidden" name="edit_submit" value="1">
                <?php else: ?>
                    <input type="hidden" name="add_submit" value="1">
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Branch Name *</label>
                        <input type="text" name="branch_name" id="branchName" required 
                               value="<?php echo $editBranch ? htmlspecialchars($editBranch['branch_name']) : ''; ?>"
                               placeholder="Enter branch name">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="branch_status" id="branchStatus">
                            <option value="Active" <?php echo ($editBranch && $editBranch['branch_status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($editBranch && $editBranch['branch_status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Location *</label>
                    <input type="text" name="location" id="location" required 
                           value="<?php echo $editBranch ? htmlspecialchars($editBranch['location']) : ''; ?>"
                           placeholder="Full address">
                </div>
                
                <div class="form-group">
                    <label>Contact Number *</label>
                    <input type="text" name="branch_contact" id="branchContact" required 
                           value="<?php echo $editBranch ? htmlspecialchars($editBranch['branch_contact']) : ''; ?>"
                           placeholder="Phone number">
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> <?php echo $editBranch ? 'Update Branch' : 'Save Branch'; ?>
                    </button>
                    <a href="branch_management_frontend.php" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search branches by name, ID, or location...">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Branch ID</th>
                        <th>Branch Name</th>
                        <th>Location</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="branchTableBody">
                    <?php if (empty($branches)): ?>
                        <td><td colspan="6" style="text-align:center; padding:2rem;">No branches found</td></tr>
                    <?php else: ?>
                        <?php foreach ($branches as $branch): ?>
                            <tr class="branch-row">
                                <td><?php echo htmlspecialchars($branch['branch_id']); ?></td>
                                <td><?php echo htmlspecialchars($branch['branch_name']); ?></td>
                                <td><?php echo htmlspecialchars($branch['location']); ?></td>
                                <td><?php echo htmlspecialchars($branch['branch_contact']); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $branch['branch_status']; ?>">
                                        <?php echo $branch['branch_status']; ?>
                                    </span>
                                </td>
                                <td class="action-icons">
                                    <a href="?edit=<?php echo $branch['branch_id']; ?>" class="btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="?delete=<?php echo $branch['branch_id']; ?>" 
                                       class="btn-danger delete-btn"
                                       onclick="return confirm('Are you sure you want to delete this branch?')">
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

    <script src="../../../frontend/assets/js/branch_management.js"></script>
</body>
</html>