<?php


session_start();


include("../../../backend/config/db_connection.php");


$current_user_id = $_SESSION['user_id'] ?? 'USR-004'; 



$sql = "SELECT u.full_name, u.username, u.email, u.branch_id, u.role, b.branch_name 
        FROM users u 
        INNER JOIN branch b ON u.branch_id = b.branch_id
        WHERE u.user_id = '$current_user_id' AND u.role = 'manager' LIMIT 1";
        // limit 1 ain koroth eka query eka serch karanwa nonstop slow wenwa ita passe


$result = mysqli_query($conn, $sql);
// database eken hariyta manger kenk hambunda kiyala balanwa
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $full_name   = $row['full_name'];
    $username    = $row['username'];
    $email       = $row['email'];
    $branch_id   = $row['branch_id'];
    $role        = $row['role'];
    $branch_name = $row['branch_name']; 

    // Kamal Perera" -> "KP"
    $parts = explode(" ", $full_name);
    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ""));
} else {
   
    echo "<script>alert('Access Denied: Branch Managers only.'); window.location.href='../../index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Settings — BranchPro</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/BM_setting.css"/>
  <style>
      /* Edit karanna bari wenna cursor eka change kirima */
      .readonly-input {
          background: #f8faff !important;
          cursor: not-allowed !important;
          color: #64748b !important;
          border: 1px solid #e2e8f0 !important;
      }
  </style>
</head>
<body>

<div class="container">
    <?php include 'BM_sidebar.php'; ?>
</div>

<main class="main">
    <header class="topbar">
      <h1 class="page-title">Settings</h1>
      <div class="topbar-right">
        
        <div class="branch-tag">
           <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
        </svg>
          <?php echo $branch_name; ?> — <?php echo $branch_id; ?>
        </div>
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
        </svg>
        
      </div>
    </header>

    <div class="settings-wrapper">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Profile Information</h2>
          <p class="card-sub">Your account details </p>
        </div>

        <div class="avatar-section">
          <div class="profile-avatar" id="profileAvatar"><?php echo $initials; ?></div>
          <div class="avatar-details">
            <p class="avatar-name"><?php echo $full_name; ?></p>
            <p class="avatar-role"><?php echo $role; ?></p>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">FULL NAME</label>
            <input type="text" class="form-input readonly-input" value="<?php echo $full_name; ?>" readonly>
          </div>
          <div class="form-group">
            <label class="form-label">USERNAME</label>
            <input type="text" class="form-input readonly-input" value="<?php echo $username; ?>" readonly>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">EMAIL ADDRESS</label>
            <input type="email" class="form-input readonly-input" value="<?php echo $email; ?>" readonly>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">BRANCH ID</label>
            <input type="text" class="form-input readonly-input" value="<?php echo $branch_id; ?>" readonly>
          </div>
        </div>
      </div>

      <div class="card card-danger">
        <div class="danger-row">
          <div>
            <p class="danger-action-title">Log Out</p>
            <p class="danger-action-desc">Current session terminate</p>
          </div>
          <button class="btn-danger" onclick="showLogout()">
            Log Out
          </button>
        </div>
      </div>
    </div>
</main>

<div class="toast" id="toast"></div>

<div class="modal-overlay" id="logoutModal">
    <div class="modal">
      <div class="modal-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
      </div>
      <h3 class="modal-title">Are you sure?</h3>
      <p class="modal-msg">You will be logged out of your current session. You will need your credentials to log back in.</p>
      <div class="modal-actions">
        <button class="btn-outline" onclick="hideLogout()">Cancel</button>
        <button class="btn-danger" onclick="doLogout()">Yes, Log Out</button>
      </div>
    </div>
</div>

<script src="../../assets/js/BM_setting.js"></script>
</body>
</html>