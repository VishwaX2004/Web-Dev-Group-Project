
// Sample data based on db_full.sql
let inventoryData = [
    { id: 'INV-701', productId: 'PROD-001', productName: 'Hydrating Face Serum', category: 'Skincare', quantity: 45, status: 'In Stock' },
    { id: 'INV-702', productId: 'PROD-002', productName: 'Matte Lipstick - Ruby', category: 'Makeup', quantity: 5, status: 'Low Stock' },
    { id: 'INV-703', productId: 'PROD-003', productName: 'Argon Oil Shampoo', category: 'Haircare', quantity: 0, status: 'Out of Stock' }
];

function renderInventory(data = inventoryData) {
    const tbody = document.getElementById('inventory-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';
    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-secondary/30 transition-colors group';
        
        let statusClass = 'bg-success-light text-success-text border-success/20';
        let statusDotClass = 'bg-success';
        if (item.status === 'Low Stock') {
            statusClass = 'bg-warning-light text-warning-text border-warning/20';
            statusDotClass = 'bg-warning';
        } else if (item.status === 'Out of Stock') {
            statusClass = 'bg-muted text-muted-foreground border-border';
            statusDotClass = 'bg-muted-foreground';
        } else if (item.status === 'Critical') {
            statusClass = 'bg-destructive/10 text-destructive border-destructive/20';
            statusDotClass = 'bg-destructive';
        }

        tr.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col">
                    <span class="font-medium text-foreground">${item.productName}</span>
                    <span class="text-xs text-muted-foreground">${item.productId}</span>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                ${item.category}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="font-headings font-semibold text-foreground">${item.quantity}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${statusClass}">
                    <span class="w-1.5 h-1.5 rounded-full ${statusDotClass} mr-1.5"></span>
                    ${item.status}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end gap-2">
                    <button class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-md transition-colors" title="Adjust Stock" onclick="adjustStock('${item.id}')">
                        <iconify-icon icon="lucide:edit-2" class="block size-[16px]" style="font-size: 16px"></iconify-icon>
                    </button>
                    <button class="p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-md transition-colors" title="Delete Record" onclick="deleteItem('${item.id}')">
                        <iconify-icon icon="lucide:trash-2" class="block size-[16px]" style="font-size: 16px"></iconify-icon>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Update stats
    updateStats();
}

function updateStats() {
    const totalItems = inventoryData.reduce((sum, item) => sum + item.quantity, 0);
    const lowStockCount = inventoryData.filter(item => item.status === 'Low Stock' || item.status === 'Critical').length;
    const categoriesCount = new Set(inventoryData.map(item => item.category)).size;

    document.getElementById('stat-total-items').textContent = totalItems.toLocaleString();
    document.getElementById('stat-low-stock').textContent = lowStockCount;
    document.getElementById('stat-categories').textContent = categoriesCount;
}

function adjustStock(id) {
    const item = inventoryData.find(i => i.id === id);
    if (!item) return;
    
    const newQty = prompt(`Adjust quantity for ${item.productName}:`, item.quantity);
    if (newQty !== null) {
        item.quantity = parseInt(newQty);
        if (item.quantity <= 0) item.status = 'Out of Stock';
        else if (item.quantity < 10) item.status = 'Low Stock';
        else item.status = 'In Stock';
        renderInventory();
    }
}

function deleteItem(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        inventoryData = inventoryData.filter(item => item.id !== id);
        renderInventory();
    }
}

// Search functionality
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

    const addStockBtn = document.getElementById('add-stock-btn');
    if (addStockBtn) {
        addStockBtn.addEventListener('click', () => {
            const name = prompt('Enter Product Name:');
            const id = 'PROD-' + Math.floor(Math.random() * 1000);
            const qty = parseInt(prompt('Enter Initial Quantity:'));
            const category = prompt('Enter Category (Skincare/Makeup/Haircare):');

            if (name && qty >= 0 && category) {
                const status = qty === 0 ? 'Out of Stock' : (qty < 10 ? 'Low Stock' : 'In Stock');
                inventoryData.push({
                    id: 'INV-' + Math.floor(Math.random() * 1000),
                    productId: id,
                    productName: name,
                    category: category,
                    quantity: qty,
                    status: status
                });
                renderInventory();
            }
        });
    }

    renderInventory();
});
