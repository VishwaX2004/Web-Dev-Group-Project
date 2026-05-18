<?php
session_start();

include("../../../backend/config/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'add') {
        $damage_id = mysqli_real_escape_string($conn, $_POST['damage_id']);
        $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $reason = mysqli_real_escape_string($conn, $_POST['reason']);
        $reported_date = mysqli_real_escape_string($conn, $_POST['reported_date']);

        $query = "INSERT INTO damaged_item (damage_id, branch_id, product_id, quantity, reason, reported_date) 
                  VALUES ('$damage_id', '$branch_id', '$product_id', '$quantity', '$reason', '$reported_date')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success_msg'] = "Damage record saved successfully!";
            header("Location: BM_damaged_item.php");
            exit();
        }
    }

  
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'edit') {
        $damage_id = mysqli_real_escape_string($conn, $_POST['damage_id']);
        $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $reason = mysqli_real_escape_string($conn, $_POST['reason']);
        $reported_date = mysqli_real_escape_string($conn, $_POST['reported_date']);

        $query = "UPDATE damaged_item SET branch_id='$branch_id', product_id='$product_id', quantity='$quantity', reason='$reason', reported_date='$reported_date' WHERE damage_id='$damage_id'";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success_msg'] = "Damage record updated successfully!";
            header("Location: BM_damaged_item.php");
            exit();
        }
    }

    if (isset($_POST['action_type']) && $_POST['action_type'] == 'delete') {
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

        $query = "DELETE FROM damaged_item WHERE damage_id='$delete_id'";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success_msg'] = "Damage record deleted successfully!";
           header("Location: BM_damaged_item.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damage Item Management</title>

      <link rel="stylesheet" href="../../assets/css/manager_layout.css">
</head>
<body>
  <div class="layout-wrapper">



  
  <?php  include('BM_sidebar.php'); ?>


    <div class="main">
  <header class="topbar">
    <div class="breadcrumb">
      <span>Inventory</span>
      <span class="breadcrumb-sep">›</span>
      <span class="active">Damaged Items Management</span>
    </div>
    <div class="topbar-actions">
      
      <button class="btn btn-primary" onclick="openAddModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Report Damage Item
      </button>
    </div>
</header>

<div class="page-body">
    <div class="page-header">
      <div>
        <h1 class="page-title">Damaged Items Management</h1>
        <p class="page-sub">Track, assess and resolve damaged inventory items</p>
      </div>
    </div>
<div class="stats-row" id="statsRow"></div>

    <div class="toolbar">
      <div class="search-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input class="search-input" type="text" id="searchInput" placeholder="Search by item name or ID…" oninput="filterTable()">
</div>
  </div>

<!-- table details -->

<div class="table-card">
      <div class="table-scroll-area">
        <table>
          <thead>
            <tr>
              <th>Damage ID</th>
              <th>Branch_ID</th>
              <th>Product ID</th>
              <th>Quantity</th>
              <th>Reason</th>
              <th>Reported Date</th>
            </tr>
          </thead>
          <tbody id="tableBody">
  <?php
  $select_query = "SELECT * FROM damaged_item ORDER BY reported_date DESC";
  $result = mysqli_query($conn, $select_query);

  if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
          
          
          $safe_reason = htmlspecialchars(str_replace(array("\r", "\n"), array("\\r", "\\n"), $row['reason']), ENT_QUOTES);

          echo "<tr>";
          echo "<td><span class='badge badge-critical'>" . $row['damage_id'] . "</span></td>";
          echo "<td>" . $row['branch_id'] . "</td>";
          echo "<td>" . $row['product_id'] . "</td>";
          echo "<td>" . $row['quantity'] . "</td>";
          echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
          echo "<td>" . $row['reported_date'] . "</td>";
          
          echo "<td>
                  <div class='action-btns'>
                    <button class='icon-btn edit-btn' onclick='editItem(\"".$row['damage_id']."\", \"".$row['branch_id']."\", \"".$row['product_id']."\", \"".$row['quantity']."\", \"".$safe_reason."\", \"".$row['reported_date']."\")'>
                      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7\"/><path d=\"M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z\"/></svg>
                    </button>
                    <button class='icon-btn delete-btn' onclick='deleteItem(\"".$row['damage_id']."\")'>
                      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><polyline points=\"3 6 5 6 21 6\"/><path d=\"M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6\"/><path d=\"M10 11v6\"/><path d=\"M14 11v6\"/><path d=\"M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2\"/></svg>
                    </button>
                  </div>
                </td>";
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='7'><div class='empty-state'>No damaged items found</div></td></tr>";
  }
  ?>
</tbody>
        </table>
      </div>
      <div class="table-info-footer">
        <span id="paginationInfo"></span>
      </div>
    </div>
  </div>
</div>

<div class="modal-overlay" id="formModal">
  <div class="modal">
    <form method="POST" action="BM_damaged_item.php">
      
      <div class="modal-header">
        <span class="modal-title" id="modalTitle">Report Damaged Item</span>
        <button type="button" class="icon-btn" onclick="closeModal('formModal')" style="border:none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <div class="modal-body">
        
        <input type="hidden" name="action_type" id="actionType" value="add">
        
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Damage ID *</label>
            <input class="form-input" name="damage_id" id="fItemId" type="text" placeholder="e.g. DMG-0042" required>
          </div>
          <div class="form-group">
            <label class="form-label">Branch ID *</label>
            <input class="form-input" name="branch_id" id="fbrancId" type="text" placeholder="e.g. B001" required>
          </div>
          <div class="form-group">
            <label class="form-label">Product ID *</label>
            <input class="form-input" name="product_id" id="fProductId" type="text" placeholder="e.g. PR0D-1234" required>
          </div>
          <div class="form-group">
            <label class="form-label">Quantity *</label>
            <input class="form-input" name="quantity" id="fQuantity" type="number" placeholder="e.g. 5" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Reason for Damage *</label>
          <textarea class="form-textarea" name="reason" id="fDescription" placeholder="Describe the damage in detail…" required></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Date Reported *</label>
          <input class="form-input" name="reported_date" id="fDate" type="date" required>
        </div>
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-ghost" onclick="closeModal('formModal')">Cancel</button>
        <button type="submit" name="save_damage" class="btn btn-primary">Save Record</button>
      </div>
    </form>
  </div>
</div>

<div class="modal-overlay" id="viewModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Item Details</span>
      <button class="icon-btn" onclick="closeModal('viewModal')" style="border:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body" id="viewBody"></div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('viewModal')">Close</button>
    </div>
  </div>
</div>

<div class="toast" id="toast">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  <span id="toastMsg"></span>
</div>

<form id="deleteForm" method="POST" action="BM_damaged_item.php" style="display:none;">
    <input type="hidden" name="action_type" value="delete">
    <input type="hidden" name="delete_id" id="deleteId">
</form>

<script src="../../assets/js/damaged_item.js"></script>


</body>
</html>