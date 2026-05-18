/**
 * Inter-Branch Transfer Logic (Vanilla JS)
 */

// Sample data fallback
if (typeof transferData === 'undefined') {
    window.transferData = [
        { id: 'TRF-101', source: 'Colombo Main', destination: 'Kandy Central', product: 'Matte Lipstick - Ruby', quantity: 15, status: 'Completed', date: 'Today, 10:30 AM' }
    ];
}

function renderTransfers(data = transferData) {
    const tbody = document.getElementById('transfer-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';
    data.forEach(item => {
        const tr = document.createElement('tr');

        let statusClass = 'badge-warning';
        if (item.status === 'Completed') {
            statusClass = 'badge-success';
        } else if (item.status === 'Cancelled' || item.status === 'Rejected') {
            statusClass = ''; // Default
        }

        tr.innerHTML = `
            <td>
                <div class="flex flex-col">
                    <span class="font-medium">${item.id}</span>
                    <span class="text-sm text-muted">${item.date}</span>
                </div>
            </td>
            <td>
                <div class="flex items-center gap-2 text-sm">
                    <span>${item.source}</span>
                    <iconify-icon icon="lucide:arrow-right" class="text-muted" style="font-size: 14px"></iconify-icon>
                    <span class="font-medium">${item.destination}</span>
                </div>
            </td>
            <td>
                <div class="flex flex-col">
                    <span class="font-medium">${item.product}</span>
                    <span class="text-sm text-muted">${item.quantity} Units</span>
                </div>
            </td>
            <td>
                <span class="badge ${statusClass}">
                    ${item.status}
                </span>
            </td>
            <td style="text-align: right;">
                <button class="btn btn-outline edit-btn" style="border: none; padding: 0.375rem;" title="Edit Transfer" data-id="${item.id}">
                    <iconify-icon icon="lucide:edit-2" style="font-size: 16px"></iconify-icon>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    // Event delegation for Edit buttons
    const tbody = document.getElementById('transfer-table-body');
    if (tbody) {
        tbody.addEventListener('click', (e) => {
            const btn = e.target.closest('.edit-btn');
            if (btn) {
                const id = btn.getAttribute('data-id');
                if (window.editTransfer) window.editTransfer(id);
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

    // Create Form Handler
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

    // Update Form Handler
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
