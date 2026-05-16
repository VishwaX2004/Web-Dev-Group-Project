document.addEventListener('DOMContentLoaded', function() {
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            let searchTerm = this.value.toLowerCase();
            let rows = document.querySelectorAll('.branch-row');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
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
            if (!confirm('Are you sure you want to delete this branch?')) {
                e.preventDefault();
            }
        });
    });
    
    const branchForm = document.getElementById('branchForm');
    if (branchForm) {
        branchForm.addEventListener('submit', function(e) {
            const branchName = document.getElementById('branchName');
            const location = document.getElementById('location');
            const contact = document.getElementById('branchContact');
            
            if (!branchName.value.trim()) {
                alert('Branch Name is required!');
                e.preventDefault();
                return false;
            }
            if (!location.value.trim()) {
                alert('Location is required!');
                e.preventDefault();
                return false;
            }
            if (!contact.value.trim()) {
                alert('Contact Number is required!');
                e.preventDefault();
                return false;
            }
        });
    }
});