
function confirmDelete(supplierId, supplierName) {
    const confirmed = window.confirm(
        "⚠️ Delete Supplier\n\n" +
        "Supplier: " + supplierName + " (ID: " + supplierId + ")\n\n" +
        "This action cannot be undone. Are you sure you want to delete this supplier?"
    );
    if (confirmed) {
        window.location.href = 'admin_supplier_managment.php?delete_id=' + supplierId;
    }
}


// Live client-side table filter for the supplier table.

function filterSuppliers() {
    const filter = document.getElementById('supplierSearch').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#supplierBody tr');
    let visible = 0;

    rows.forEach(row => {
        if (row.querySelector('.empty-state')) return; // skip empty state row
        const matches = row.textContent.toLowerCase().includes(filter);
        row.style.display = matches ? '' : 'none';
        if (matches) visible++;
    });

    const el = document.getElementById('visibleCount');
    if (el) el.textContent = visible;
}

//Client-side form validation before submission.

document.getElementById('addSupplierForm').addEventListener('submit', function (e) {
    const fields = ['supplier_id', 'name', 'contact', 'address'];
    let valid = true;

    fields.forEach(id => {
        const el = document.getElementById(id);
        if (!el.value.trim()) {
            el.style.borderColor = '#dc2626';
            valid = false;
        } else {
            el.style.borderColor = '';
        }
    });

    if (!valid) {
        e.preventDefault();
        alert('Please fill in all required fields before submitting.');
    }
});
