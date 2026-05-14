// Logout functions
function showLogout() { 
    document.getElementById('logoutModal').classList.add('show'); 
}

function hideLogout() { 
    document.getElementById('logoutModal').classList.remove('show'); 
}

function doLogout() {
    hideLogout();
    showToast('Logging out...', 'info');
    // Session destroy karana logout.php file ekakata redirect karanna
    setTimeout(() => { 
        window.location.href = '../../logout.php'; 
    }, 1000);
}

// Toast notification function
function showToast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast show toast-' + type;
    setTimeout(() => t.className = 'toast', 3000);
}