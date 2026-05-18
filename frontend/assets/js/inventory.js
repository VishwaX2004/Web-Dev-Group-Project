/**
 * Inventory Management (Vanilla JS)
 */

// Sample data fallback
if (typeof inventoryData === 'undefined') {
    window.inventoryData = [
        { id: 'INV-701', productId: 'PROD-001', productName: 'Hydrating Face Serum', category: 'Skincare', quantity: 45, status: 'In Stock' },
        { id: 'INV-702', productId: 'PROD-002', productName: 'Matte Lipstick - Ruby', category: 'Makeup', quantity: 5, status: 'Low Stock' }
    ];
}

function renderInventory(data = inventoryData) {
    const tbody = document.getElementById('inventory-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';
    data.forEach(item => {
        const tr = document.createElement('tr');

        let statusClass = 'badge-success';
        if (item.status === 'Low Stock' || item.status === 'Critical') {
            statusClass = 'badge-warning';
        } else if (item.status === 'Out of Stock') {
            statusClass = ''; // Default/muted
        }

        tr.innerHTML = `
            <td>
                <div class="flex flex-col">
                    <span class="font-medium">${item.productName}</span>
                    <span class="text-sm text-muted">${item.productId}</span>
                </div>
            </td>
            <td>
                ${item.category}
            </td>
            <td>
                <span class="font-bold">${item.quantity}</span>
            </td>
            <td>
                <span class="badge ${statusClass}">
                    ${item.status}
                </span>
            </td>
            <td style="text-align: right;">
                <div class="flex items-center justify-end gap-2">
                    <button class="btn btn-outline" style="border: none; padding: 0.25rem;" title="Adjust Stock" onclick="adjustStock('${item.id}')">
                        <iconify-icon icon="lucide:edit-2" style="font-size: 16px"></iconify-icon>
                    </button>
                    <button class="btn btn-outline" style="border: none; padding: 0.25rem; color: var(--destructive);" title="Delete Record" onclick="deleteItem('${item.id}')">
                        <iconify-icon icon="lucide:trash-2" style="font-size: 16px"></iconify-icon>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    updateStats();
}

function updateStats() {
    const totalItems = inventoryData.reduce((sum, item) => sum + item.quantity, 0);
    const lowStockCount = inventoryData.filter(item => item.status === 'Low Stock' || item.status === 'Critical').length;
    const categoriesCount = new Set(inventoryData.map(item => item.category)).size;

    const elTotal = document.getElementById('stat-total-items');
    const elLow = document.getElementById('stat-low-stock');
    const elCat = document.getElementById('stat-categories');

    if (elTotal) elTotal.textContent = totalItems.toLocaleString();
    if (elLow) elLow.textContent = lowStockCount;
    if (elCat) elCat.textContent = categoriesCount;
}

function adjustStock(id) {
    const item = inventoryData.find(i => i.id === id);
    if (!item) return;

    const newQty = prompt(`Adjust quantity for ${item.productName}:`, item.quantity);
    if (newQty !== null) {
        item.quantity = parseInt(newQty);
        renderInventory();
    }
}

function deleteItem(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        const formData = new FormData();
        formData.append('inventory_id', id);

        fetch('BM_delete_inventory_action.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('inventory-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = inventoryData.filter(item =>
                item.productName.toLowerCase().includes(term) ||
                item.productId.toLowerCase().includes(term) ||
                item.category.toLowerCase().includes(term)
            );
            renderInventory(filtered);
        });
    }

    const form = document.getElementById('add-stock-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            fetch('BM_add_inventory_action.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    }

    renderInventory();
});
