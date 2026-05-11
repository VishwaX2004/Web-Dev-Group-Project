<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damage Item Management</title>

    <style>


    </style>
</head>
<body>
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


<script>
function filterTable() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const sev = document.getElementById('severityFilter').value;
  const sta = document.getElementById('statusFilter').value;
  filtered = items.filter(i =>
    (i.name.toLowerCase().includes(q) || i.itemId.toLowerCase().includes(q)) &&
    (sev ? i.severity === sev : true) &&
    (sta ? i.status === sta : true)
  );
}
</script>

</body>
</html>