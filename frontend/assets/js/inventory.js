/**
 * Inventory Management (Vanilla JS)
 */

if (typeof inventoryData === 'undefined') {
    window.inventoryData = [];
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
            statusClass = '';
        }

        tr.innerHTML = `
            <td>
                <div class="flex flex-col">
                    <span class="font-medium">${item.productName}</span>
                    <span class="text-sm text-muted">${item.productId}</span>
                </div>
            </td>
            <td>${item.category}</td>
            <td><span class="font-bold">${item.quantity}</span></td>
            <td><span class="badge ${statusClass}">${item.status}</span></td>
            <td style="text-align: right;">
                <div class="flex items-center justify-end gap-2">
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

document.addEventListener('DOMContentLoaded', () => {
    // 1. Auto-select category when product changes
    const productSelect = document.getElementById('product-name-select');
    const categorySelect = document.getElementById('category-select');

    if (productSelect && categorySelect) {
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const category = selectedOption.getAttribute('data-category');
            
            if (category) {
                // Find and select the matching category
                for (let i = 0; i < categorySelect.options.length; i++) {
                    if (categorySelect.options[i].value === category) {
                        categorySelect.selectedIndex = i;
                        break;
                    }
                }
            }
        });
    }

    // 2. Search filtering
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

    // 3. Form Submission Handling
    const form = document.getElementById('add-stock-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            // Temporary fix for disabled dropdown not sending value
            if(categorySelect.disabled || categorySelect.hasAttribute('readonly')) {
                formData.append('category_name', categorySelect.value);
            }

            const params = new URLSearchParams(formData);

            fetch('BM_add_inventory_action.php', {
                method: 'POST',
                body: params
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || "Stock added successfully!");
                    location.reload(); // Refresh the page to see new data
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error("Submission Error: ", err);
                alert("Server error occurred. Please check console.");
            });
        });
    }

    renderInventory();
});