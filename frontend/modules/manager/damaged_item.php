<?php

// Start the session to manage session variables like success messages
session_start();

// Include the database connection file from the backend directory
include("../../backend/config/db_connection.php");

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // --- ADD NEW DAMAGE RECORD ---
    // Check if the action_type is set to 'add' 

    if (isset($_POST['action_type']) && $_POST['action_type'] == 'add') {

    // Retrieve form data and assign them to variables
        $damage_id = $_POST['damage_id'];
        $branch_id = $_POST['branch_id'];
        $product_id =$_POST['product_id'];
        $quantity = $_POST['quantity'];
        $reason = $_POST['reason'];
        $reported_date = $_POST['reported_date'];

        // SQL query to insert the new damage record into the database
        $query = "INSERT INTO damaged_item (damage_id, branch_id, product_id, quantity, reason, reported_date) 
                  VALUES ('$damage_id', '$branch_id', '$product_id', '$quantity', '$reason', '$reported_date')";

        // Execute the query and check if it was successful
        if (mysqli_query($conn, $query)) {

        // Set a success message in the session and redirect to the same page to prevent resubmission
            $_SESSION['success_msg'] = "Damage record saved successfully!";
            header("Location: damaged_item.php");
            exit(); // Stop script execution after redirect
        }
    }

  
    // --- EDIT EXISTING DAMAGE RECORD ---
    // Check if the action_type is set to 'edit'
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'edit') {
        $damage_id = $_POST['damage_id'];
        $branch_id = $_POST['branch_id'];
        $product_id =$_POST['product_id'];
        $quantity = $_POST['quantity'];
        $reason = $_POST['reason'];
        $reported_date = $_POST['reported_date'];

        // SQL query to update the existing record based on the damage_id
        $query = "UPDATE damaged_item SET branch_id='$branch_id', product_id='$product_id', quantity='$quantity', reason='$reason', reported_date='$reported_date' WHERE damage_id='$damage_id'";

        // Execute the query and check for success
        if (mysqli_query($conn, $query)) {
            $_SESSION['success_msg'] = "Damage record updated successfully!";
            header("Location: damaged_item.php");
            exit();
        }
    }

    // --- DELETE DAMAGE RECORD ---
    // Check if the action_type is set to 'delete'
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'delete') {
        $delete_id = $_POST['delete_id'];

        // SQL query to delete the record from the database
        $query = "DELETE FROM damaged_item WHERE damage_id='$delete_id'";

        // Execute the query and check for success
        if (mysqli_query($conn, $query)) {
            $_SESSION['success_msg'] = "Damage record deleted successfully!";
            header("Location: damaged_item.php");
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

      <link rel="stylesheet" href="BM_damage_item.css">
</head>
<body>
  <div class="layout-wrapper">
  <?php include ('../assets/css/BM_sidebar.php'); ?>
    <div class="main">
  <header class="topbar">
    <div class="breadcrumb">
      <span>Inventory</span>
      <span class="breadcrumb-sep">›</span>
      <span class="active">Damaged Items Management</span>
    </div>
    <div class="topbar-actions">
      <button class="btn btn-ghost" onclick="exportData()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export Report
      </button>
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
    
      // Loop through each row of data
      while($row = mysqli_fetch_assoc($result)) {
          
          // Clean the 'reason' text so it doesn't break JavaScript (removes new lines and quotes)
          $safe_reason = htmlspecialchars(str_replace(array("\r", "\n"), array("\\r", "\\n"), $row['reason']), ENT_QUOTES);

          // Start a new table row
          echo "<tr>";
          echo "<td><span class='badge badge-critical'>" . $row['damage_id'] . "</span></td>";
          echo "<td>" . $row['branch_id'] . "</td>";
          echo "<td>" . $row['product_id'] . "</td>";
          echo "<td>" . $row['quantity'] . "</td>";
          echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
          echo "<td>" . $row['reported_date'] . "</td>";
          
          // Add action buttons for Edit and Delete
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
                // Close the table row
          echo "</tr>";
      }
  } else {
    // Show a "Not found" message if the database is empty
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
<!-- The dark background overlay for the first modal (Form Modal) -->
<div class="modal-overlay" id="formModal">
  <!-- The main white container box for the modal -->
  <div class="modal">
    
    <!-- The form that sends data to 'damaged_item.php' using the POST method -->
    <form method="POST" action="damaged_item.php">
      
      <!-- The top section of the modal (Header) -->
      <div class="modal-header">
        <!-- The title of the modal -->
        <span class="modal-title" id="modalTitle">Report Damaged Item</span>
        <!-- The close button. Clicking it triggers the 'closeModal' JavaScript function -->
        <button type="button" class="icon-btn" onclick="closeModal('formModal')" style="border:none;">
          <!-- SVG icon for the "X" (close) mark -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <!-- The main content area of the modal where inputs are placed (Body) -->
      <div class="modal-body">
        
        <!-- A hidden input field. This tells the server if the action is to "add" a new record or update an existing one -->
        <input type="hidden" name="action_type" id="actionType" value="add">
        
        <!-- A row container to place multiple form fields side-by-side -->
        <div class="form-row">
          
          <!-- Input group for the Damage ID -->
          <div class="form-group">
            <label class="form-label">Damage ID *</label>
            <!-- A required text input for the Damage ID -->
            <input class="form-input" name="damage_id" id="fItemId" type="text" placeholder="e.g. DMG-0042" required>
          </div>
          
          <!-- Input group for the Branch ID -->
          <div class="form-group">
            <label class="form-label">Branch ID *</label>
            <input class="form-input" name="branch_id" id="fbrancId" type="text" placeholder="e.g. B001" required>
          </div>
          
          <!-- Input group for the Product ID -->
          <div class="form-group">
            <label class="form-label">Product ID *</label>
            <input class="form-input" name="product_id" id="fProductId" type="text" placeholder="e.g. P123" required>
          </div>
          
          <!-- Input group for the Quantity -->
          <div class="form-group">
            <label class="form-label">Quantity *</label>
            <!-- A required number input for the quantity (only accepts numbers) -->
            <input class="form-input" name="quantity" id="fQuantity" type="number" placeholder="e.g. 5" required>
          </div>
        </div>
        
        <!-- Input group for the Reason for Damage -->
        <div class="form-group">
          <label class="form-label">Reason for Damage *</label>
          <!-- A textarea for writing a longer description of the damage -->
          <textarea class="form-textarea" name="reason" id="fDescription" placeholder="Describe the damage in detail…" required></textarea>
        </div>
        
        <!-- Input group for the Date Reported -->
        <div class="form-group">
          <label class="form-label">Date Reported *</label>
          <!-- A date picker input -->
          <input class="form-input" name="reported_date" id="fDate" type="date" required>
        </div>
      </div>
      
      <!-- The bottom section of the modal containing the action buttons (Footer) -->
      <div class="modal-footer"> 
        <!-- Button to cancel and close the modal without saving -->
        <button type="button" class="btn btn-ghost" onclick="closeModal('formModal')">Cancel</button>
        <!-- The main submit button to save the form data to the database -->
        <button type="submit" name="save_damage" class="btn btn-primary">Save Record</button>
      </div>
    </form>
  </div>
</div>

<!-- A second modal used only for viewing item details (Read-only) -->
<div class="modal-overlay" id="viewModal">
  <div class="modal">
    
    <!-- Header of the View Modal -->
    <div class="modal-header">
      <span class="modal-title">Item Details</span>
      <button class="icon-btn" onclick="closeModal('viewModal')" style="border:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    
    <!-- An empty body. JavaScript will dynamically insert the item details here when a user clicks "View" -->
    <div class="modal-body" id="viewBody"></div>
    
    <!-- Footer of the View Modal with a close button -->
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('viewModal')">Close</button>
    </div>
  </div>
</div>

<!-- A small pop-up notification box (Toast) that appears temporarily to show success/error messages -->
<div class="toast" id="toast">
  <!-- SVG icon for a checkmark (tick) -->
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  <!-- The span where the notification text will be injected by JavaScript -->
  <span id="toastMsg"></span>
</div>

<!-- A hidden form specifically used for deleting records (display is set to none so users can't see it) -->
<form id="deleteForm" method="POST" action="damaged_item.php" style="display:none;">
    <!-- Tells the server that the requested action is to "delete" -->
    <input type="hidden" name="action_type" value="delete">
    <!-- The ID of the item to be deleted will be placed here by JavaScript before submitting -->
    <input type="hidden" name="delete_id" id="deleteId">
</form>

<!-- Links the external JavaScript file that contains all the interactive functions for this page -->
<script src="../../assets/js/damaged_item.js"></script>

<!-- End of the HTML body and document -->
</body>
</html>