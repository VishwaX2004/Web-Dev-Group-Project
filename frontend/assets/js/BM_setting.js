// Logout functions wen user click logout button then add css 'show' class 
function showLogout() { 
    document.getElementById('logoutModal').classList.add('show'); 
}

//when user cancel logout button then popup massege hide and remove css class 'show'
function hideLogout() { 
    document.getElementById('logoutModal').classList.remove('show'); 
}

function doLogout() {
    hideLogout();
    showToast('Logging out...', 'info');
    // Session destroy karana logout.php file ekakata redirect karanna
    setTimeout(() => { 
       window.location.href = "http://localhost/Web-Dev-Group-Project/backend/api/logout.php";
    }, 1000);

   
}

// Toast notification function
function showToast(msg, type) {
    const t = document.getElementById('toast');//select id 
    t.textContent = msg;
    t.className = 'toast show toast-' + type; //add css classes, this is a methos when we using js to css control.
    setTimeout(() => t.className = 'toast', 3000);
}