<?php
// --- DATABASE CONNECTION ---
require_once __DIR__ . '/../../../backend/config/db_connection.php';

// --- FETCH INVENTORY DATA (JOIN query) ---
$sql = "
    SELECT
        i.inventory_id,
        b.branch_name,
        p.product_name,
        i.quantity,
        i.status
    FROM
        inventory i
    INNER JOIN
        branch b ON i.branch_id = b.branch_id
    INNER JOIN
        product p ON i.product_id = p.Product_id
    ORDER BY
        i.inventory_id ASC
";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Inventory Overview | Retail IMS</title>
    <meta name="description" content="Head Office read-only view of inventory across all branches. Retail Inventory Management System." />

    <!-- Bootstrap Icons CDN (icons only, no Bootstrap CSS/JS) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Page Stylesheet -->
    <link rel="stylesheet" href="../../assets/css/admin_inventory_overview.css" />
    <link rel="stylesheet" href="../../assets/css/admin_sidebar.css" />
</head>
<body>

<!-- Sidebar -->
<?php require_once __DIR__ . '/../../includes/admin_sidebar.php'; ?>

<!-- Main content pushed right of the fixed sidebar -->
<div style="margin-left: 260px;">

<!-- ══════════════════════════════════════════════════
     PAGE HEADER
══════════════════════════════════════════════════ -->
<div class="page-header">
    <div class="breadcrumb-custom">
        <i class="bi bi-house-door"></i>
        Dashboard
        <span class="bc-separator">/</span>
        <span class="bc-active">Inventory Overview</span>
    </div>
    <h1 class="page-title"><i class="bi bi-clipboard2-data title-icon"></i>Admin Inventory Overview</h1>
    <p class="page-subtitle">Read-only consolidated view of inventory levels across all branches.</p>
</div>

<?php
// ── COMPUTE STATS ──
$total_records    = 0;
$total_quantity   = 0;
$low_stock_count  = 0;
$out_stock_count  = 0;
$rows_cache       = []; // cache rows so we don't re-query

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows_cache[]  = $row;
        $total_records++;
        $total_quantity += (int)$row['quantity'];
        $status_lower   = strtolower(trim($row['status']));
        if (str_contains($status_lower, 'low'))       $low_stock_count++;
        if (str_contains($status_lower, 'out'))       $out_stock_count++;
    }
}
?>

<!-- ══════════════════════════════════════════════════
     STATS STRIP
══════════════════════════════════════════════════ -->
<div class="stats-strip">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-list-ul"></i></div>
        <div>
            <div class="stat-value"><?= $total_records ?></div>
            <div class="stat-label">Total Records</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
        <div>
            <div class="stat-value"><?= number_format($total_quantity) ?></div>
            <div class="stat-label">Total Units</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--warn"><i class="bi bi-exclamation-triangle"></i></div>
        <div>
            <div class="stat-value stat-value--warn"><?= $low_stock_count ?></div>
            <div class="stat-label">Low Stock Items</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--danger"><i class="bi bi-x-circle"></i></div>
        <div>
            <div class="stat-value stat-value--danger"><?= $out_stock_count ?></div>
            <div class="stat-label">Out of Stock</div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════
     MAIN TABLE CARD
══════════════════════════════════════════════════ -->
<div class="main-content">
    <div class="inventory-card">

        <!-- Card Header -->
        <div class="card-header-custom">
            <h2 class="card-title-text">
                <i class="bi bi-table"></i>
                Inventory Records
                <span class="read-only-badge"><i class="bi bi-eye"></i> Read Only</span>
            </h2>
            <!-- Live Search -->
            <div class="search-box">
                <i class="bi bi-search search-icon"></i>
                <input
                    type="text"
                    id="inventorySearch"
                    placeholder="Search table..."
                    oninput="filterTable()"
                    aria-label="Search inventory records"
                />
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="inventory-table" id="inventoryTable" aria-label="Inventory overview table">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash th-icon"></i>Inventory ID</th>
                        <th><i class="bi bi-building th-icon"></i>Branch Name</th>
                        <th><i class="bi bi-tag th-icon"></i>Product Name</th>
                        <th><i class="bi bi-stack th-icon"></i>Quantity</th>
                        <th><i class="bi bi-circle-fill th-icon"></i>Status</th>
                    </tr>
                </thead>
                <tbody id="inventoryBody">
                    <?php if (!empty($rows_cache)): ?>
                        <?php foreach ($rows_cache as $row): ?>
                            <?php
                                $status_raw   = trim($row['status']);
                                $status_lower = strtolower($status_raw);
                                $qty          = (int)$row['quantity'];

                                // Status CSS class
                                if (str_contains($status_lower, 'in'))          $badge_class = 'in-stock';
                                elseif (str_contains($status_lower, 'low'))     $badge_class = 'low-stock';
                                elseif (str_contains($status_lower, 'out'))     $badge_class = 'out-of-stock';
                                elseif (str_contains($status_lower, 'order'))   $badge_class = 'on-order';
                                else                                             $badge_class = 'default';

                                // Quantity colour class
                                if ($qty <= 5)       $qty_class = 'qty-low';
                                elseif ($qty <= 20)  $qty_class = 'qty-mid';
                                else                 $qty_class = 'qty-high';

                                // Status icon
                                $status_icons = [
                                    'in-stock'      => 'bi-check-circle-fill',
                                    'low-stock'     => 'bi-exclamation-circle-fill',
                                    'out-of-stock'  => 'bi-x-circle-fill',
                                    'on-order'      => 'bi-clock-fill',
                                    'default'       => 'bi-dash-circle',
                                ];
                                $icon = $status_icons[$badge_class] ?? 'bi-dash-circle';
                            ?>
                            <tr>
                                <td><span class="id-pill">#<?= htmlspecialchars($row['inventory_id']) ?></span></td>
                                <td>
                                    <span class="branch-badge">
                                        <i class="bi bi-building-fill"></i>
                                        <?= htmlspecialchars($row['branch_name']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['product_name']) ?></td>
                                <td class="qty-cell <?= $qty_class ?>"><?= number_format($qty) ?></td>
                                <td>
                                    <span class="status-badge <?= $badge_class ?>">
                                        <i class="bi <?= $icon ?>"></i>
                                        <?= htmlspecialchars($status_raw) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No inventory records found. Please ensure data exists and the database is connected.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Card Footer -->
        <div class="card-footer-custom">
            <div class="record-count">
                Showing <strong id="visibleCount"><?= $total_records ?></strong> of <strong><?= $total_records ?></strong> records
            </div>
            <div class="readonly-notice">
                <i class="bi bi-lock-fill"></i>
                Head Office view &mdash; no edits permitted
            </div>
        </div>

    </div><!-- /inventory-card -->
</div><!-- /main-content -->

</div><!-- /main content wrapper -->

<!-- Page Script -->
<script src="../../assets/js/admin_inventory_overview.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>
