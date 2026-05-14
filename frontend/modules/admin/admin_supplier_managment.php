<?php
// --- DATABASE CONNECTION ---
$host = '127.0.0.1';
$port = '3308';
$db   = 'retail_system'; // <-- Change this
$user = 'root';               // <-- Change this
$pass = '';                   // <-- Change this
$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$success_msg = '';
$error_msg   = '';

// ─────────────────────────────────────────
// DELETE SUPPLIER (GET request)
// ─────────────────────────────────────────
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    $del_sql   = "DELETE FROM supplier WHERE supplier_id = ?";
    $del_stmt  = mysqli_prepare($conn, $del_sql);
    mysqli_stmt_bind_param($del_stmt, 'i', $delete_id);
    if (mysqli_stmt_execute($del_stmt)) {
        $success_msg = "Supplier #$delete_id deleted successfully.";
    } else {
        $error_msg = "Delete failed: " . mysqli_error($conn);
    }
    mysqli_stmt_close($del_stmt);
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

    <style>
        /* =========================================
           60-30-10 COLOR PALETTE
           Primary (60%) : #FFFFFF  — Pure White
           Secondary (30%): #4169E1  — Royal Blue
           Accent (10%)   : #000000  — Solid Black
        ========================================= */
        :root {
            --primary:        #FFFFFF;
            --secondary:      #4169E1;
            --accent:         #000000;
            --secondary-dark: #2f50b8;
            --secondary-light:#eef1fc;
            --border-color:   #e5e7eb;
            --muted:          #6b7280;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6fb;
            color: var(--accent);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .top-navbar {
            background: var(--secondary);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(65,105,225,.35);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .brand-wrap { display:flex; align-items:center; gap:.6rem; text-decoration:none; }
        .brand-icon {
            width:36px; height:36px; border-radius:8px;
            background:rgba(255,255,255,.2);
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:1.1rem;
        }
        .brand-text { color:#fff; font-weight:700; font-size:1.1rem; }
        .brand-text span { font-weight:300; opacity:.85; }
        .role-badge {
            background:rgba(255,255,255,.15); color:#fff;
            padding:4px 14px; border-radius:20px;
            font-size:.78rem; font-weight:500;
            border:1px solid rgba(255,255,255,.25);
            display:flex; align-items:center; gap:6px;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            background:var(--primary);
            border-bottom:1px solid var(--border-color);
            padding:1.75rem 2rem 1.5rem;
        }
        .breadcrumb-row {
            font-size:.8rem; color:var(--muted);
            display:flex; align-items:center; gap:6px;
            margin-bottom:.5rem;
        }
        .breadcrumb-row .bc-active { color:var(--secondary); font-weight:500; }
        .page-title  { font-size:1.5rem; font-weight:700; margin:0 0 .2rem; }
        .page-subtitle { font-size:.88rem; color:var(--muted); margin:0; }

        /* ── WRAPPER ── */
        .page-wrap { padding:1.75rem 2rem 3rem; display:flex; flex-direction:column; gap:1.5rem; }

        /* ── CARDS ── */
        .panel {
            background:var(--primary);
            border:1px solid var(--border-color);
            border-radius:14px;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
            overflow:hidden;
        }
        .panel-header {
            background:var(--secondary);
            padding:.9rem 1.4rem;
            display:flex; align-items:center; gap:.6rem;
        }
        .panel-header h2 {
            color:#fff; font-size:.95rem; font-weight:600; margin:0;
            display:flex; align-items:center; gap:7px;
        }
        .panel-body { padding:1.5rem; }

        /* ── FORM ── */
        .form-label {
            font-size:.82rem; font-weight:600;
            color:#374151; margin-bottom:.35rem;
        }
        .form-control {
            border:1px solid var(--border-color);
            border-radius:8px;
            font-size:.875rem;
            padding:.55rem .85rem;
            transition:border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color:var(--secondary);
            box-shadow:0 0 0 3px rgba(65,105,225,.15);
            outline:none;
        }

        /* Black accent submit button */
        .btn-accent {
            background:var(--accent);
            color:#fff;
            border:none;
            border-radius:8px;
            padding:.6rem 1.6rem;
            font-size:.875rem;
            font-weight:600;
            display:inline-flex; align-items:center; gap:7px;
            transition:background .2s, transform .1s;
            cursor:pointer;
        }
        .btn-accent:hover  { background:#1a1a1a; }
        .btn-accent:active { transform:scale(.97); }

        /* Delete button */
        .btn-delete {
            background:transparent;
            color:#dc2626;
            border:1px solid #fca5a5;
            border-radius:6px;
            padding:4px 12px;
            font-size:.78rem;
            font-weight:600;
            display:inline-flex; align-items:center; gap:5px;
            cursor:pointer;
            transition:background .15s, color .15s;
        }
        .btn-delete:hover { background:#fee2e2; border-color:#dc2626; }

        /* ── TABLE ── */
        .supplier-table { width:100%; border-collapse:collapse; font-size:.875rem; }
        .supplier-table thead tr { background:var(--secondary-light); }
        .supplier-table thead th {
            color:var(--secondary);
            font-weight:600; font-size:.77rem;
            text-transform:uppercase; letter-spacing:.06em;
            padding:11px 15px;
            border-bottom:2px solid var(--secondary);
            white-space:nowrap;
        }
        .supplier-table tbody tr {
            border-bottom:1px solid var(--border-color);
            transition:background .15s;
        }
        .supplier-table tbody tr:last-child { border-bottom:none; }
        .supplier-table tbody tr:hover { background:#f8f9fe; }
        .supplier-table tbody td { padding:12px 15px; color:#374151; vertical-align:middle; }

        .id-pill {
            display:inline-flex; align-items:center;
            background:var(--secondary-light); color:var(--secondary);
            font-weight:600; font-size:.78rem;
            padding:3px 10px; border-radius:20px;
        }

        /* ── ALERTS ── */
        .flash-alert {
            border-radius:10px; font-size:.875rem;
            padding:.75rem 1.1rem;
            display:flex; align-items:center; gap:8px;
            margin-bottom:1rem;
        }
        .flash-success { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
        .flash-error   { background:#fee2e2; color:#b91c1c; border:1px solid #fca5a5; }

        /* ── EMPTY STATE ── */
        .empty-state { text-align:center; padding:3.5rem 2rem; color:var(--muted); }
        .empty-state i { font-size:3rem; color:#d1d5db; display:block; margin-bottom:1rem; }

        /* ── TABLE FOOTER ── */
        .table-footer {
            background:#fafbff;
            border-top:1px solid var(--border-color);
            padding:.8rem 1.4rem;
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:.5rem;
        }
        .table-footer .rec-count { font-size:.82rem; color:var(--muted); }
        .table-footer .rec-count strong { color:var(--secondary); }

        /* ── SEARCH ── */
        .search-wrap { position:relative; }
        .search-wrap input {
            border:1px solid rgba(255,255,255,.35);
            background:rgba(255,255,255,.15);
            color:#fff; border-radius:8px;
            padding:5px 12px 5px 32px;
            font-size:.82rem; outline:none; width:200px;
            transition:background .2s, border .2s;
        }
        .search-wrap input::placeholder { color:rgba(255,255,255,.65); }
        .search-wrap input:focus { background:rgba(255,255,255,.25); border-color:rgba(255,255,255,.6); }
        .search-wrap .s-icon {
            position:absolute; left:9px; top:50%; transform:translateY(-50%);
            color:rgba(255,255,255,.75); font-size:.82rem; pointer-events:none;
        }

        @media(max-width:768px){
            .top-navbar  { padding:0 1rem; }
            .page-header { padding:1.25rem 1rem 1rem; }
            .page-wrap   { padding:1rem 1rem 2.5rem; }
            .panel-body  { padding:1rem; }
            .search-wrap input { width:100%; }
            .panel-header { flex-direction:column; align-items:flex-start; gap:.5rem; }
        }
    </style>
</head>
<body>

<!-- ══════════════════════════════
     NAVBAR
══════════════════════════════ -->
<nav class="top-navbar">
    <a href="#" class="brand-wrap">
        <div class="brand-icon"><i class="bi bi-boxes"></i></div>
        <div class="brand-text">Retail <span>IMS</span></div>
    </a>
    <div class="role-badge"><i class="bi bi-person-gear-fill"></i> Supplier Manager</div>
</nav>

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
    <?php if ($success_msg): ?>
        <div class="flash-alert flash-success" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success_msg) ?>
        </div>
    <?php endif; ?>
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
            <form method="POST" action="supplier_manage.php" id="addSupplierForm" novalidate>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/**
 * Delete confirmation dialog.
 * Uses a native confirm() to prevent accidental deletions.
 * On confirmation, redirects to the same page with a GET parameter.
 */
function confirmDelete(supplierId, supplierName) {
    const confirmed = window.confirm(
        "⚠️ Delete Supplier\n\n" +
        "Supplier: " + supplierName + " (ID: " + supplierId + ")\n\n" +
        "This action cannot be undone. Are you sure you want to delete this supplier?"
    );
    if (confirmed) {
        window.location.href = 'supplier_manage.php?delete_id=' + supplierId;
    }
}

/**
 * Live client-side table filter for the supplier table.
 */
function filterSuppliers() {
    const filter  = document.getElementById('supplierSearch').value.toLowerCase().trim();
    const rows    = document.querySelectorAll('#supplierBody tr');
    let   visible = 0;

    rows.forEach(row => {
        if (row.querySelector('.empty-state')) return; // skip empty state row
        const matches = row.textContent.toLowerCase().includes(filter);
        row.style.display = matches ? '' : 'none';
        if (matches) visible++;
    });

    const el = document.getElementById('visibleCount');
    if (el) el.textContent = visible;
}

/**
 * Client-side form validation before submission.
 */
document.getElementById('addSupplierForm').addEventListener('submit', function(e) {
    const fields = ['supplier_id', 'name', 'contact', 'address'];
    let valid = true;

    fields.forEach(id => {
        const el = document.getElementById(id);
        if (!el.value.trim()) {
            el.style.borderColor = '#dc2626';
            valid = false;
        } else {
            el.style.borderColor = '';
        }
    });

    if (!valid) {
        e.preventDefault();
        alert('Please fill in all required fields before submitting.');
    }
});
</script>
</body>
</html>
<?php mysqli_close($conn); ?>
