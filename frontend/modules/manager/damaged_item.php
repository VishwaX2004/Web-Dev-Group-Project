<?php
session_start();

include("../../backend/config/db_connection.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damage Item Management</title>

      <link rel="stylesheet" href="../assets/css/BM_damage_item.css">
</head>
<body>
  <div class="layout-wrapper">
  <?php include 'BM_sidebar.php'; ?>
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

    <select class="filter-select" id="severityFilter" onchange="filterTable()">
        <option value="">All Severities</option>
        <option value="Critical">Critical</option>
        <option value="Moderate">Moderate</option>
        <option value="Minor">Minor</option>
      </select>

    <select class="filter-select" id="statusFilter" onchange="filterTable()">
        <option value="">All Statues</option>
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="resolved">Resolved</option>
        <option value="Returned to Supplier">Returned to Supplier</option>
      </select>
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
          <tbody id="tableBody"></tbody>
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
    <div class="modal-header">
      <span class="modal-title" id="modalTitle">Report Damaged Item</span>
      <button class="icon-btn" onclick="closeModal('formModal')" style="border:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Damage ID *</label>
          <input class="form-input" id="fItemId" type="text" placeholder="e.g. DMG-0042">
        </div>
        <div class="form-group">
          <label class="form-label">Branch ID *</label>
          <input class="form-input" id="fbrancId" type="text" placeholder="e.g. BR-001">
        </div>
        <div class="form-group">
          <label class="form-label">Product ID *</label>
          <input class="form-input" id="fProductId" type="text" placeholder="e.g. PR0D-1234">
      </div>
        <div class="form-group">
          <label class="form-label">Quantity *</label>
          <input class="form-input" id="fQuantity" type="number" placeholder="e.g. 5">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Reason for Damage *</label>
        <textarea class="form-textarea" id="fDescription" placeholder="Describe the damage in detail…"></textarea>
      </div>
       <div class="form-group">
          <label class="form-label">Date Reported *</label>
          <input class="form-input" id="fDate" type="date">
        </div>
    </div>
    <div class="modal-footer"> <!-- modal form footer buttons -->
      <button class="btn btn-ghost" onclick="closeModal('formModal')">Cancel</button>
      <button class="btn btn-primary" onclick="saveItem()">Save Record</button>
    </div>
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

<script src="../../assets/js/damaged_item.js"></script>


</body>
</html>