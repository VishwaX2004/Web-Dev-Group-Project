<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Settings — BranchPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/BM_setting.css"/>
  <link rel="stylesheet" href="../../assets/css/BM_sidebar.css">
</head>
<body>

<div class="container">
        <?php include 'BM_sidebar.php'; ?>
    </div>

  
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
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-input" value="Thisaru Thiwanka" readonly style="background:#f8f9ff; cursor:not-allowed; color:#888;" />
          </div>
          <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" class="form-input" value="thisaru" readonly style="background:#f8f9ff; cursor:not-allowed; color:#888;" />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-input" value="thisaru123@gmail.com" readonly style="background:#f8f9ff; cursor:not-allowed; color:#888;" />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Branch</label>
            <input type="text" class="form-input" value="Colombo Branch — BR-001" readonly style="background:#f8f9ff; cursor:not-allowed; color:#888;" />
          </div>
          
        </div>

        
      </div>

      

     
      <!-- DANGER ZONE -->
      <div class="card card-danger">
        <div class="card-header">
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
      <p class="modal-msg">current session එකෙන් log out වේ. නැවත login කිරීමට credentials ඕනේ වේ.</p>
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