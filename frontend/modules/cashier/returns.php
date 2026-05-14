<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Temporary login fallback (remove later)
if (!isset($_SESSION['auth'])) {
    $_SESSION['auth'] = true;
    $_SESSION['role'] = 'cashier';
    $_SESSION['user_id'] = 'USR-002';
    $_SESSION['branch_id'] = 'BR-002';
}

if (!isset($_SESSION['auth']) || $_SESSION['role'] != 'cashier') {
    header("Location: ../../index.php");
    exit();
}

require_once '../../../backend/api/cashier/return_logic.php';

// Get user details for sidebar
$user_id = $_SESSION['user_id'];
$query = "SELECT u.full_name, b.branch_name FROM users u JOIN branch b ON u.branch_id = b.branch_id WHERE u.user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$display_name = $data['full_name'] ?? 'Cashier';
$display_branch = $data['branch_name'] ?? 'Main Branch';

$branch_id = $_SESSION['branch_id'];
$message = '';
$message_type = '';

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $res = createReturn(
            $_POST['sale_id'], $_POST['product_id'], (int)$_POST['quantity'],
            $_POST['reason'], $_POST['status'], $branch_id, $user_id
        );
        $message = $res['message'];
        $message_type = $res['success'] ? 'success' : 'error';
    } elseif ($action === 'update_status') {
        $res = updateReturnStatus(
            $_POST['return_id'], $_POST['status'], $_POST['old_status'],
            (int)$_POST['quantity'], $_POST['product_id'], $branch_id
        );
        $message = $res['message'];
        $message_type = $res['success'] ? 'success' : 'error';
    } elseif ($action === 'delete') {
        $res = deleteReturn(
            $_POST['return_id'], $_POST['status'],
            (int)$_POST['quantity'], $_POST['product_id'], $branch_id
        );
        $message = $res['message'];
        $message_type = $res['success'] ? 'success' : 'error';
    }
}

$stats = getReturnStats();
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$returns_data = searchReturns($search);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Processing - SmartPOS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/cashier_sidebar.css">
    <link rel="stylesheet" href="../../assets/css/cashier_returns.css">
</head>
<body>
    <?php include("../../includes/cashier_sidebar.php"); ?>
    <div class="main">
        <div class="container">
            <div class="returns-card">
                <h1>Return Processing</h1>
                <?php if ($message): ?>
                    <div class="message <?php echo $message_type; ?>"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <div class="stats">
                    <div class="stat-card"><div class="number"><?php echo $stats['total']; ?></div><div class="label">Total Returns</div></div>
                    <div class="stat-card"><div class="number"><?php echo $stats['pending']; ?></div><div class="label">Pending</div></div>
                    <div class="stat-card"><div class="number"><?php echo $stats['approved']; ?></div><div class="label">Approved</div></div>
                    <div class="stat-card"><div class="number"><?php echo $stats['rejected']; ?></div><div class="label">Rejected</div></div>
                </div>
                <h2>Create New Return</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="form-row">
                        <label>Sale ID <input type="text" name="sale_id" required placeholder="SALE-5001"></label>
                        <label>Product ID <input type="text" name="product_id" required placeholder="PROD-001"></label>
                        <label>Quantity <input type="number" name="quantity" value="1" min="1"></label>
                        <label>Reason <select name="reason"><option>Defective</option><option>Wrong Item</option><option>Changed Mind</option><option>Other</option></select></label>
                        <label>Status <select name="status"><option>Pending</option><option>Approved</option><option>Rejected</option></select></label>
                        <button type="submit">Submit Return</button>
                    </div>
                </form>
                <div class="search-bar">
                    <form method="GET">
                        <input type="text" name="search" placeholder="Search by Sale ID, Product ID, Return ID"
                               value="<?php echo htmlspecialchars($search); ?>"
                               onkeypress="if(event.key === 'Enter') this.form.submit();">
                    </form>
                </div>
                <table class="returns-table">
                    <thead><tr><th>Return ID</th><th>Sale ID</th><th>Product ID</th><th>Product Name</th><th>Qty</th><th>Reason</th><th>Status</th><th>Return Date</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php if (empty($returns_data)): ?>
                            <tr><td colspan="9">No returns found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($returns_data as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['return_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['sale_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo htmlspecialchars($row['reason']); ?></td>
                                <td>
                                    <form method="POST" style="margin:0;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="return_id" value="<?php echo $row['return_id']; ?>">
                                        <input type="hidden" name="quantity" value="<?php echo $row['quantity']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                        <input type="hidden" name="old_status" value="<?php echo $row['status']; ?>">
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <option value="Pending" <?php echo $row['status']=='Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Approved" <?php echo $row['status']=='Approved' ? 'selected' : ''; ?>>Approved</option>
                                            <option value="Rejected" <?php echo $row['status']=='Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                                <td><?php echo date('Y-m-d', strtotime($row['return_date'])); ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('Delete this return?')" style="margin:0;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="return_id" value="<?php echo $row['return_id']; ?>">
                                        <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                                        <input type="hidden" name="quantity" value="<?php echo $row['quantity']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                        <button type="submit" class="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>