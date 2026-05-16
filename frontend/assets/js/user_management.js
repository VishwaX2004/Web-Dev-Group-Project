document.addEventListener('DOMContentLoaded', function() {
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            let searchTerm = this.value.toLowerCase();
            let rows = document.querySelectorAll('.user-row');
            
            rows.forEach(row => {
                let userId = row.cells[0]?.textContent.toLowerCase() || '';
                let name = row.cells[1]?.textContent.toLowerCase() || '';
                let email = row.cells[2]?.textContent.toLowerCase() || '';
                
                if (userId.includes(searchTerm) || name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this user?')) {
                e.preventDefault();
            }
        });
    });
    
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', function(e) {
            const fullName = document.getElementById('fullName');
            const email = document.getElementById('email');
            const branchId = document.getElementById('branchId');
            
            if (!fullName.value.trim()) {
                alert('Full Name is required!');
                e.preventDefault();
                return false;
            }
            if (!email.value.trim()) {
                alert('Email is required!');
                e.preventDefault();
                return false;
            }
            if (!branchId.value.trim()) {
                alert('Branch ID is required!');
                e.preventDefault();
                return false;
            }
        });
    }
});