<?php 
include '../../../backend/config/db_connection.php';



$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM product WHERE Product_id = '$id'");
    $edit_data = mysqli_fetch_assoc($res);
}

$result = mysqli_query($conn, "SELECT * FROM product");
?>


<!DOCTYPE html>
<!--all products are fetched in to the variable result -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link rel="stylesheet" href="../../assets/css/admin_product.css">
    <link rel="stylesheet" href="../../assets/css/admin_sidebar.css">
</head>
<body>
    <div>
        <?php include("../../includes/admin_sidebar.php"); ?>
    </div>

    <div class="main-content">
        <div class="container">
            <h2 class="header-title"> Product Management</h2>

            <div class="form-section">
                <h3><?php echo $edit_data ? 'Edit Product' : 'Add New Product'; ?></h3>
        
                <form method="POST" action="../../../backend/api/admin/product_process.php">
                    <input type="hidden" name="is_update" value="<?php echo $edit_data ? 'true' : 'false'; ?>">
                    
                    <div class="form-grid">
                        <input type="text" name="product_id" placeholder="Product ID" 
                               value="<?php echo $edit_data ? $edit_data['Product_id'] : ''; ?>" 
                               <?php echo $edit_data ? 'readonly' : ''; ?> required>
                               <!--check edit dat is available or not if availabale  atuomaticaaly refile the form but it make read only-->

                        <input type="text" name="product_name" placeholder="Product Name" 
                               value="<?php echo $edit_data ? $edit_data['product_name'] : ''; ?>" required>
                        
                        <select name="category" required>
                            <option value="">Category</option>
                            <option value="CAT-SKIN" <?php echo ($edit_data && $edit_data['category_name'] == 'CAT-SKIN') ? 'selected' : ''; ?>>CAT-SKIN</option>
                            <option value="CAT-MAKE" <?php echo ($edit_data && $edit_data['category_name'] == 'CAT-MAKE') ? 'selected' : ''; ?>>CAT-MAKE</option>
                            <option value="CAT-HAIR" <?php echo ($edit_data && $edit_data['category_name'] == 'CAT-HAIR') ? 'selected' : ''; ?>>CAT-HAIR</option>
                        </select>
                        
                        <input type="number" step="0.01" name="price" placeholder="Price" 
                               value="<?php echo $edit_data ? $edit_data['price'] : ''; ?>" required>
                        
                        <button type="submit" name="save_product" class="btn-save <?php echo $edit_data ? 'btn-update' : ''; ?>">
                            <?php echo $edit_data ? 'Update' : 'Save'; ?>
                        </button>

                        <?php if ($edit_data): ?>
                            <a href="product_management.php" style="font-size:14px; color:#64748b;">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>NAME</th><th>CATEGORY</th><th>PRICE</th><th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['Product_id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo number_format($row['price'], 2); ?></td>
                        <td>
                            <a href="?edit=<?php echo $row['Product_id']; ?>" class="btn-edit">Edit</a>

                            <a href="../../../backend/api/admin/product_process.php?delete=<?php echo $row['Product_id']; ?>" 
                               class="btn-delete" onclick="return confirm('Delete this product?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>