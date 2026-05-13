<?php
include '../../../backend/config/db_connection.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM product WHERE Product_id = '$id'");
    header("Location: ../../../frontend/modules/admin/product_management.php");
    exit();
}

if (isset($_POST['save_product'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $is_update = $_POST['is_update'];

    if ($is_update == "true") {
        $sql = "UPDATE product SET product_name='$name', category_name='$category', Price='$price' WHERE Product_id='$id'";
    } else {
        $sql = "INSERT INTO product (Product_id, product_name, category_name, Price) VALUES ('$id', '$name', '$category', '$price')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../../frontend/modules/admin/product_management.php?status=success");
        exit();
    }
}
?>