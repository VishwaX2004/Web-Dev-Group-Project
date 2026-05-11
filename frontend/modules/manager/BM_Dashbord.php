<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Branch Manager Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/BM_Dashboard.css" />
  <link rel="stylesheet" href="../../assets/css/BM_sidebar.css">
</head>
<body>


<div class="container">
        <?php include 'BM_sidebar.php'; ?>
    </div>


  <div class="main">

    <div class="topbar">
      <div class="topbar-title">Branch Overview</div>
      <div class="topbar-branch">
        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
        </svg>
        Colombo Branch — BR-001
      </div>
      <div class="topbar-notif">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
        </svg>
        <span class="notif-dot"></span>
      </div>
    </div>

    <div class="content">

      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon" style="background:#eff6ff;">📦</div>
          <div class="stat-label">Total Stock Items</div>
          <div class="stat-value">1,284</div>
          <div class="stat-change up">↑ 4.2% this week</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#fef9c3;">📋</div>
          <div class="stat-label">Pending Requests</div>
          <div class="stat-value">3</div>
          <div class="stat-change down">↓ 2 approved today</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#fee2e2;">⚠️</div>
          <div class="stat-label">Damaged Items</div>
          <div class="stat-value">5</div>
          <div class="stat-change up">↑ 2 new reported</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#dcfce7;">🧾</div>
          <div class="stat-label">Purchase Orders</div>
          <div class="stat-value">12</div>
          <div class="stat-change up">↑ 3 approved</div>
        </div>
      </div>

      <div class="section-title">System Modules</div>

      <div class="section-title">Recent Activity</div>
      <div class="activity-card">
        <div class="activity-row">
          <div class="activity-dot" style="background:#4169E1;"></div>
          <div class="activity-msg">New stock request raised — Product ID: P-0214, Qty: 50</div>
          <span class="status-pill pill-amber">Pending</span>
          <div class="activity-time">10 min ago</div>
        </div>
        <div class="activity-row">
          <div class="activity-dot" style="background:#16a34a;"></div>
          <div class="activity-msg">Inter-branch transfer from Kandy Branch received successfully</div>
          <span class="status-pill pill-green">Received</span>
          <div class="activity-time">1 hr ago</div>
        </div>
        <div class="activity-row">
          <div class="activity-dot" style="background:#dc2626;"></div>
          <div class="activity-msg">2 damaged items logged — P-0088, flagged for write-off review</div>
          <span class="status-pill pill-red">Flagged</span>
          <div class="activity-time">3 hrs ago</div>
        </div>
        <div class="activity-row">
          <div class="activity-dot" style="background:#16a34a;"></div>
          <div class="activity-msg">Purchase Order PO-0041 approved and sent to supplier</div>
          <span class="status-pill pill-green">Approved</span>
          <div class="activity-time">Yesterday</div>
        </div>
        <div class="activity-row">
          <div class="activity-dot" style="background:#4169E1;"></div>
          <div class="activity-msg">Inventory audit completed — 12 items manually adjusted</div>
          <span class="status-pill pill-blue">Updated</span>
          <div class="activity-time">Yesterday</div>
        </div>
      </div>

    </div>
  </div>

 

</body>
</html>