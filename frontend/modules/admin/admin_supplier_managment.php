<?php
// --- DATABASE CONNECTION ---
require_once __DIR__ . '/../../../backend/config/db_connection.php';

$success_msg = '';
$error_msg   = '';

// ─────────────────────────────────────────
// DELETE SUPPLIER (GET request)
// ─────────────────────────────────────────
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];

    mysqli_begin_transaction($conn);
    try {
        // Delete related stock_requests first
        $del_stock = mysqli_prepare($conn, "DELETE FROM stock_requests WHERE supplier_id = ?");
        mysqli_stmt_bind_param($del_stock, 'i', $delete_id);
        mysqli_stmt_execute($del_stock);
        mysqli_stmt_close($del_stock);

        // Delete related purchase orders
        $del_orders = mysqli_prepare($conn, "DELETE FROM purchase_orders WHERE supplier_id = ?");
        mysqli_stmt_bind_param($del_orders, 'i', $delete_id);
        mysqli_stmt_execute($del_orders);
        mysqli_stmt_close($del_orders);

        // Now delete the supplier
        $del_stmt = mysqli_prepare($conn, "DELETE FROM supplier WHERE supplier_id = ?");
        mysqli_stmt_bind_param($del_stmt, 'i', $delete_id);
        mysqli_stmt_execute($del_stmt);
        mysqli_stmt_close($del_stmt);

        mysqli_commit($conn);
        $success_msg = "Supplier #$delete_id deleted successfully.";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $error_msg = "Delete failed: " . $e->getMessage();
    }
}

// ─────────────────────────────────────────
// ADD SUPPLIER (POST request)
// ─────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier'])) {
    $supplier_id = trim($_POST['supplier_id']);
    $name        = trim($_POST['name']);
    $contact     = trim($_POST['contact']);
    $address     = trim($_POST['address']);

    if ($supplier_id === '' || $name === '' || $contact === '' || $address === '') {
        $error_msg = "All fields are required. Please fill in every input.";
    } else {
        $ins_sql  = "INSERT INTO supplier (supplier_id, name, contact, address) VALUES (?, ?, ?, ?)";
        $ins_stmt = mysqli_prepare($conn, $ins_sql);
        mysqli_stmt_bind_param($ins_stmt, 'isss', $supplier_id, $name, $contact, $address);
        if (mysqli_stmt_execute($ins_stmt)) {
            $success_msg = "Supplier \"$name\" added successfully.";
        } else {
            $error_msg = "Insert failed: " . mysqli_error($conn);
        }
        mysqli_stmt_close($ins_stmt);
    }
}

// ─────────────────────────────────────────
// FETCH ALL SUPPLIERS
// ─────────────────────────────────────────
$suppliers_result = mysqli_query($conn, "SELECT * FROM supplier ORDER BY supplier_id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supplier Management | Retail IMS</title>
    <meta name="description" content="Add, view, and delete suppliers in the Retail Inventory Management System." />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/admin_supplier_managment.css" />
    <link rel="stylesheet" href="../../assets/css/admin_sidebar.css" />
</head>
<body>

<!-- Sidebar -->
      <?php include("../../includes/admin_sidebar.php"); ?>

<!-- Main content pushed right of the fixed sidebar -->
<div style="margin-left: 260px;">

<!-- ══════════════════════════════
     PAGE HEADER
══════════════════════════════ -->
<div class="page-header">
    <div class="breadcrumb-row">
        <i class="bi bi-house-door"></i> Dashboard
        <span style="opacity:.4">/</span>
        <span class="bc-active">Supplier Management</span>
    </div>
    <h1 class="page-title"><i class="bi bi-truck me-2" style="color:var(--secondary)"></i>Supplier Management</h1>
    <p class="page-subtitle">Add new suppliers and manage the existing supplier directory.</p>
</div>

<div class="page-wrap">

    <!-- Flash messages -->
    <?php if ($error_msg): ?>
        <div class="flash-alert flash-error" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($error_msg) ?>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════
         SECTION 1 – ADD SUPPLIER FORM
    ══════════════════════════════ -->
    <div class="panel">
        <div class="panel-header">
            <h2><i class="bi bi-person-plus-fill"></i> Add New Supplier</h2>
        </div>
        <div class="panel-body">
            <form method="POST" action="admin_supplier_managment.php" id="addSupplierForm" novalidate>
                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <label for="supplier_id" class="form-label">Supplier ID <span style="color:#dc2626">*</span></label>
                        <input
                            type="number"
                            id="supplier_id"
                            name="supplier_id"
                            class="form-control"
                            placeholder="e.g. 101"
                            min="1"
                            required
                        />
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="name" class="form-label">Supplier Name <span style="color:#dc2626">*</span></label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="e.g. Global Traders Ltd."
                            required
                        />
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="contact" class="form-label">Contact <span style="color:#dc2626">*</span></label>
                        <input
                            type="text"
                            id="contact"
                            name="contact"
                            class="form-control"
                            placeholder="e.g. +1 555-0100"
                            required
                        />
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="address" class="form-label">Address <span style="color:#dc2626">*</span></label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            class="form-control"
                            placeholder="e.g. 42 Main St, City"
                            required
                        />
                    </div>
                    <div class="col-12">
                        <button type="submit" name="add_supplier" class="btn-accent" id="addSupplierBtn">
                            <i class="bi bi-plus-circle-fill"></i> Add Supplier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ══════════════════════════════
         SECTION 2 – SUPPLIER TABLE
    ══════════════════════════════ -->
    <div class="panel">
        <div class="panel-header" style="justify-content:space-between; flex-wrap:wrap;">
            <h2><i class="bi bi-table"></i> All Suppliers</h2>
            <div class="search-wrap">
                <i class="bi bi-search s-icon"></i>
                <input
                    type="text"
                    id="supplierSearch"
                    placeholder="Search suppliers..."
                    oninput="filterSuppliers()"
                    aria-label="Search suppliers"
                />
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="supplier-table" id="supplierTable" aria-label="Supplier records">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash me-1"></i>Supplier ID</th>
                        <th><i class="bi bi-person me-1"></i>Name</th>
                        <th><i class="bi bi-telephone me-1"></i>Contact</th>
                        <th><i class="bi bi-geo-alt me-1"></i>Address</th>
                        <th><i class="bi bi-gear me-1"></i>Action</th>
                    </tr>
                </thead>
                <tbody id="supplierBody">
                    <?php
                    $supplier_count = 0;
                    if ($suppliers_result && mysqli_num_rows($suppliers_result) > 0):
                        while ($s = mysqli_fetch_assoc($suppliers_result)):
                            $supplier_count++;
                    ?>
                    <tr>
                        <td><span class="id-pill">#<?= htmlspecialchars($s['supplier_id']) ?></span></td>
                        <td><?= htmlspecialchars($s['name']) ?></td>
                        <td><?= htmlspecialchars($s['contact']) ?></td>
                        <td><?= htmlspecialchars($s['address']) ?></td>
                        <td>
                            <button
                                class="btn-delete"
                                onclick="confirmDelete(<?= (int)$s['supplier_id'] ?>, '<?= htmlspecialchars(addslashes($s['name'])) ?>')"
                                id="delete-btn-<?= (int)$s['supplier_id'] ?>"
                                aria-label="Delete supplier <?= htmlspecialchars($s['name']) ?>">
                                <i class="bi bi-trash3-fill"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>No suppliers found. Add your first supplier using the form above.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="rec-count">
                Showing <strong id="visibleCount"><?= $supplier_count ?></strong> of
                <strong><?= $supplier_count ?></strong> suppliers
            </div>
        </div>
    </div>

</div><!-- /page-wrap -->

</div><!-- /main content wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/admin_supplier_managment.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>
