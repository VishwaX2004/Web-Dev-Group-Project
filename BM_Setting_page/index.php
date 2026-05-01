<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Settings — BranchPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="settings.css"/>
</head>
<body>

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-logo">BM</div>
      <div class="brand-info">
        <span class="brand-name">BranchPro</span>
        <span class="brand-sub">System Module v2.4</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      <p class="nav-label">MAIN MENU</p>
      <a href="#" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="2" width="7" height="7" rx="1.5"/><rect x="11" y="2" width="7" height="7" rx="1.5"/><rect x="2" y="11" width="7" height="7" rx="1.5"/><rect x="11" y="11" width="7" height="7" rx="1.5"/></svg>
        Dashboard
      </a>
      <a href="#" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="4" width="16" height="12" rx="1.5"/><path d="M2 8h16"/></svg>
        Inventory Management
      </a>
      <a href="#" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="7" cy="16" r="1.5"/><circle cx="14" cy="16" r="1.5"/><path d="M1 2h2l2.5 9h8l2-6H5.5"/></svg>
        Stock Requests
        <span class="badge">3</span>
      </a>
      <a href="#" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 10h12M10 4l6 6-6 6"/></svg>
        Inter-Branch Transfer
      </a>
      <a href="#" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="10" cy="10" r="8"/><path d="M10 6v4l3 3"/></svg>
        Damaged Items
        <span class="badge badge-red">5</span>
      </a>
      <a href="#" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 4h12v12H4zM8 4v12M4 8h12"/></svg>
        Purchase Orders
      </a>
    </nav>

    <nav class="sidebar-nav">
      <p class="nav-label">SETTINGS</p>
      <a href="#" class="nav-item active">
        <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="10" cy="10" r="2.5"/><path d="M10 2v1.5M10 16.5V18M2 10h1.5M16.5 10H18M4.2 4.2l1.1 1.1M14.7 14.7l1.1 1.1M4.2 15.8l1.1-1.1M14.7 5.3l1.1-1.1"/></svg>
        Settings
      </a>
    </nav>

    <div class="sidebar-user">
      <div class="user-avatar">KP</div>
      <div class="user-info">
        <span class="user-name">Kumara Perera</span>
        <span class="user-role">Branch Manager</span>
      </div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main">

    <!-- TOP BAR -->
    <header class="topbar">
      <h1 class="page-title">Settings</h1>
      <div class="topbar-right">
        <div class="branch-tag">
          <span class="branch-dot">📍</span>
          Colombo Branch — BR-001
        </div>
        <button class="bell-btn">🔔</button>
      </div>
    </header>

    <!-- SETTINGS CONTENT -->
    <div class="settings-wrapper">

      <!-- PROFILE CARD -->
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Profile Information</h2>
          <p class="card-sub">Your account details update</p>
        </div>

        <div class="avatar-section">
          <div class="profile-avatar" id="profileAvatar">KP</div>
          <div class="avatar-details">
            <p class="avatar-name" id="avatarNameDisplay">Kumara Perera</p>
            <p class="avatar-role">Branch Manager</p>
            <button class="btn-outline btn-sm">Change Photo</button>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-input" id="fullName" value="Kumara Perera" placeholder="Enter full name" />
          </div>
          <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" class="form-input" value="kumara.perera" placeholder="Enter username" />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-input" value="kumara@branchpro.lk" placeholder="Enter email" />
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" class="form-input" value="+94 77 123 4567" placeholder="Enter phone" />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Branch</label>
            <input type="text" class="form-input" value="Colombo Branch — BR-001" readonly style="background:#f8f9ff; cursor:not-allowed; color:#888;" />
          </div>
          <div class="form-group">
            <label class="form-label">Role</label>
            <input type="text" class="form-input" value="Branch Manager" readonly style="background:#f8f9ff; cursor:not-allowed; color:#888;" />
          </div>
        </div>

        <div class="card-footer">
          <button class="btn-outline" onclick="resetForm()">Cancel</button>
          <button class="btn-primary" onclick="saveProfile()">Save Changes</button>
        </div>
      </div>

      <!-- PASSWORD CARD -->
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Change Password</h2>
          <p class="card-sub">Account security update </p>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Current Password</label>
            <div class="input-pw-wrap">
              <input type="password" class="form-input" id="curPw" placeholder="Current password" />
              <button class="eye-btn" onclick="togglePw('curPw',this)">👁</button>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">New Password</label>
            <div class="input-pw-wrap">
              <input type="password" class="form-input" id="newPw" placeholder="New password" />
              <button class="eye-btn" onclick="togglePw('newPw',this)">👁</button>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Confirm New Password</label>
            <div class="input-pw-wrap">
              <input type="password" class="form-input" id="confPw" placeholder="Confirm password" />
              <button class="eye-btn" onclick="togglePw('confPw',this)">👁</button>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <button class="btn-primary" onclick="savePassword()">Update Password</button>
        </div>
      </div>

      <!-- PREFERENCES CARD -->
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Preferences</h2>
          <p class="card-sub">Notification and system preferences</p>
        </div>

        <div class="pref-list">
          <div class="pref-row">
            <div>
              <p class="pref-title">Email Notifications</p>
              <p class="pref-desc">Stock request updates email  receive </p>
            </div>
            <label class="toggle">
              <input type="checkbox" checked />
              <span class="slider"></span>
            </label>
          </div>
          <div class="pref-row">
            <div>
              <p class="pref-title">Low Stock Alerts</p>
              <p class="pref-desc">Stock level low  alert send </p>
            </div>
            <label class="toggle">
              <input type="checkbox" checked />
              <span class="slider"></span>
            </label>
          </div>
          <div class="pref-row">
            <div>
              <p class="pref-title">Request Approval Alerts</p>
              <p class="pref-desc">Approval status change notifications</p>
            </div>
            <label class="toggle">
              <input type="checkbox" />
              <span class="slider"></span>
            </label>
          </div>
        </div>
      </div>

      <!-- DANGER ZONE -->
      <div class="card card-danger">
        <div class="card-header">
          <h2 class="card-title danger-title">Danger Zone</h2>
          <p class="card-sub">Irreversible actions </p>
        </div>
        <div class="danger-row">
          <div>
            <p class="danger-action-title">Log Out</p>
            <p class="danger-action-desc">Current session terminate</p>
          </div>
          <button class="btn-danger" onclick="showLogout()">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2H3a1 1 0 00-1 1v10a1 1 0 001 1h3M10 11l3-3-3-3M13 8H6"/></svg>
            Log Out
          </button>
        </div>
        <div class="divider"></div>
        <div class="danger-row">
          <div>
            <p class="danger-action-title">Deactivate Account</p>
            <p class="danger-action-desc">Account deactivate කරනවා — admin විසින් reactivate කළ යුතු වේ</p>
          </div>
          <button class="btn-danger btn-danger-dark">Deactivate</button>
        </div>
      </div>

    </div>
  </main>

  <!-- TOAST -->
  <div class="toast" id="toast"></div>

  <!-- LOGOUT MODAL -->
  <div class="modal-overlay" id="logoutModal">
    <div class="modal">
      <div class="modal-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
      </div>
      <h3 class="modal-title">Log out වෙනවාද?</h3>
      <p class="modal-msg">ඔබ current session එකෙන් log out වේ. නැවත login කිරීමට credentials ඕනේ වේ.</p>
      <div class="modal-actions">
        <button class="btn-outline" onclick="hideLogout()">Cancel</button>
        <button class="btn-danger" onclick="doLogout()">Yes, Log Out</button>
      </div>
    </div>
  </div>

  <script>
    // Name live update
    document.getElementById('fullName').addEventListener('input', function () {
      const val = this.value.trim();
      const initials = val.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
      document.getElementById('profileAvatar').textContent = initials || 'KP';
      document.getElementById('avatarNameDisplay').textContent = val || 'Kumara Perera';
    });

    function saveProfile() {
      showToast('✔ Profile saved successfully!', 'success');
    }

    function resetForm() {
      document.getElementById('fullName').value = 'Kumara Perera';
      document.getElementById('profileAvatar').textContent = 'KP';
      document.getElementById('avatarNameDisplay').textContent = 'Kumara Perera';
      showToast('Changes discarded.', 'info');
    }

    function savePassword() {
      const np = document.getElementById('newPw').value;
      const cp = document.getElementById('confPw').value;
      if (!np) { showToast('⚠ New password ඇතුළත් කරන්න.', 'error'); return; }
      if (np !== cp) { showToast('⚠ Passwords match නොවේ.', 'error'); return; }
      showToast('✔ Password updated!', 'success');
      document.getElementById('curPw').value = '';
      document.getElementById('newPw').value = '';
      document.getElementById('confPw').value = '';
    }

    function togglePw(id, btn) {
      const inp = document.getElementById(id);
      inp.type = inp.type === 'password' ? 'text' : 'password';
    }

    function showLogout() { document.getElementById('logoutModal').classList.add('show'); }
    function hideLogout() { document.getElementById('logoutModal').classList.remove('show'); }
    function doLogout() {
      hideLogout();
      showToast('Logging out...', 'info');
      setTimeout(() => { alert('Logged out! (Redirect to login page here)'); }, 1000);
    }

    function showToast(msg, type) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.className = 'toast show toast-' + type;
      setTimeout(() => t.className = 'toast', 3000);
    }
  </script>
</body>
</html>