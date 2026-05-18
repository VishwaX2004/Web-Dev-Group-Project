<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Branch Manager Dashboard</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-box">
        <div class="logo-icon">BM</div>
        <div>
          <div class="logo-text">BranchPro</div>
          <div class="logo-sub">System Module v2.4</div>
        </div>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-label">Main Menu</div>

      <button class="nav-item active" onclick="setActive(this)">
        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
          <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
        </svg>
        Dashboard
      </button>

      <button class="nav-item" onclick="setActive(this)">
        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
          <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4zM3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
        </svg>
        Inventory Management
      </button>

      <button class="nav-item" onclick="setActive(this)">
        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
        </svg>
        Stock Requests
        <span class="nav-badge">3</span>
      </button>

      <button class="nav-item" onclick="setActive(this)">
        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
          <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
        </svg>
        Inter-Branch Transfer
      </button>

      <button class="nav-item" onclick="setActive(this)">
        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        Damaged Items
        <span class="nav-badge">5</span>
      </button>

      <button class="nav-item" onclick="setActive(this)">
        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"/>
        </svg>
        Purchase Orders
      </button>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-label">Settings</div>
      <button class="nav-item" onclick="setActive(this)">
        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
        </svg>
        Settings
      </button>
    </div>

    <div class="sidebar-bottom">
      <div class="user-card">
        <div class="user-avatar">TT</div>
        <div>
          <div class="user-name">Thisaru Thiwanka</div>
          <div class="user-role">Branch Manager</div>
        </div>
      </div>
    </div>
  </aside>

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