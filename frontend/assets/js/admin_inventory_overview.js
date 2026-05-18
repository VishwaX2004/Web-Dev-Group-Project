/**
 * admin_inventory_overview.js
 * Live client-side table filter for the Admin Inventory Overview page.
 * Searches across all visible columns and updates the visible record count.
 */

function filterTable() {
    const input  = document.getElementById('inventorySearch');
    const filter = input.value.toLowerCase().trim();
    const tbody  = document.getElementById('inventoryBody');
    const rows   = tbody.querySelectorAll('tr');
    let visible  = 0;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    const countEl = document.getElementById('visibleCount');
    if (countEl) countEl.textContent = visible;
}
