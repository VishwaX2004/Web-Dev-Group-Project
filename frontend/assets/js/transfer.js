/**
 * Inter-Branch Transfer Logic (Vanilla JS)
 */

document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.getElementById('transfer-table-body');
    const searchInput = document.getElementById('transfer-search');
    const updateModal = document.getElementById('update-transfer-modal');

    // 1. Click delegation on table body to handle edit button clicks
    if (tbody) {
        tbody.addEventListener('click', (e) => {
            const btn = e.target.closest('.edit-btn');
            if (btn) {
                if (window.editTransfer) {
                    window.editTransfer(btn);
                }
            }
        });
    }

    // 2. Real-time Search Logic (DOM-based)
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.transfer-row');

            rows.forEach(row => {
                const id = row.querySelector('.transfer-id').textContent.toLowerCase();
                const source = row.querySelector('.transfer-source').textContent.toLowerCase();
                const dest = row.querySelector('.transfer-destination').textContent.toLowerCase();
                const product = row.querySelector('.transfer-product').textContent.toLowerCase();

                if (id.includes(term) || source.includes(term) || dest.includes(term) || product.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // 3. Modal Close handlers
    const closeBtn = document.getElementById('close-update-modal-btn');
    const cancelBtn = document.getElementById('cancel-update-modal-btn');

    const closeModal = () => {
        if (updateModal) updateModal.style.display = 'none';
    };

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Close on clicking outside modal
    if (updateModal) {
        updateModal.addEventListener('click', (e) => {
            if (e.target === updateModal) {
                closeModal();
            }
        });
    }
});
