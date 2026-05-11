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
</body>
</html>