
// Sample data fallback
if (typeof transferData === 'undefined') {
    window.transferData = [
        { id: 'TRF-101', source: 'Colombo Main', destination: 'Kandy Central', product: 'Matte Lipstick - Ruby', quantity: 15, status: 'Completed', date: 'Today, 10:30 AM' },
        { id: 'TRF-102', source: 'Kandy Central', destination: 'Colombo Main', product: 'Argon Oil Shampoo', quantity: 10, status: 'Shipped', date: 'Yesterday, 14:15 PM' }
    ];
}

function renderTransfers(data = transferData) {
    const tbody = document.getElementById('transfer-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';
    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-secondary/30 transition-colors';

        let statusClass = 'bg-warning-light text-warning-text border-warning/20';
        let statusDotClass = 'bg-warning';

        if (item.status === 'Completed') {
            statusClass = 'bg-success-light text-success-text border-success/20';
            statusDotClass = 'bg-success';
        } else if (item.status === 'Cancelled' || item.status === 'Rejected') {
            statusClass = 'bg-destructive/10 text-destructive border-destructive/20';
            statusDotClass = 'bg-destructive';
        }

        tr.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col">
                    <span class="font-medium text-foreground">${item.id}</span>
                    <span class="text-xs text-muted-foreground">${item.date}</span>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2 text-sm text-foreground">
                    <span>${item.source}</span>
                    <iconify-icon icon="lucide:arrow-right" class="block text-muted-foreground size-[14px]" style="font-size: 14px"></iconify-icon>
                    <span class="font-medium">${item.destination}</span>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col">
                    <span class="text-sm text-foreground font-medium">${item.product}</span>
                    <span class="text-xs text-muted-foreground">${item.quantity} Units</span>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${statusClass}">
                    <span class="w-1.5 h-1.5 rounded-full ${statusDotClass} mr-1.5"></span>
                    ${item.status}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button class="edit-btn p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-md transition-colors" 
                        title="Edit Transfer" data-id="${item.id}">
                    <iconify-icon icon="lucide:edit-2" class="block size-[16px]" style="font-size: 16px"></iconify-icon>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function editTransfer(id) {
    const item = transferData.find(t => t.id == id);
    if (!item) return;

    const modal = document.getElementById('update-transfer-modal');
    if (!modal) return;

    // Fill modal fields
    document.getElementById('update-transfer-id').value = item.id;
    document.getElementById('update-source-branch').value = item.source_branch_id;
    document.getElementById('update-dest-branch').value = item.dest_branch_id;
    document.getElementById('update-product').value = item.product_id;
    document.getElementById('update-quantity').value = item.quantity;

    // Show modal explicitly
    modal.style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', () => {
    // Event delegation for Edit buttons
    const tbody = document.getElementById('transfer-table-body');
    if (tbody) {
        tbody.addEventListener('click', (e) => {
            const btn = e.target.closest('.edit-btn');
            if (btn) {
                const id = btn.getAttribute('data-id');
                editTransfer(id);
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('transfer-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = transferData.filter(item =>
                item.id.toLowerCase().includes(term) ||
                item.product.toLowerCase().includes(term) ||
                item.source.toLowerCase().includes(term) ||
                item.destination.toLowerCase().includes(term)
            );
            renderTransfers(filtered);
        });
    }

    // Modal Close Logic
    const updateModal = document.getElementById('update-transfer-modal');
    const closeUpdateBtn = document.getElementById('close-update-modal-btn');
    const cancelUpdateBtn = document.getElementById('cancel-update-modal-btn');
    
    if (updateModal) {
        const hideModal = () => updateModal.style.display = 'none';
        if (closeUpdateBtn) closeUpdateBtn.addEventListener('click', hideModal);
        if (cancelUpdateBtn) cancelUpdateBtn.addEventListener('click', hideModal);
    }

    const createForm = document.getElementById('create-transfer-form');
    if (createForm) {
        createForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(createForm);
            fetch('BM_create_transfer_action.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) { alert(data.message); location.reload(); }
                else { alert('Error: ' + data.message); }
            });
        });
    }

    const updateForm = document.getElementById('update-transfer-form');
    if (updateForm) {
        updateForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(updateForm);
            fetch('BM_update_transfer_action.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) { location.reload(); }
                else { alert('Error: ' + data.message); }
            });
        });
    }

    renderTransfers();
});
