/**
 * Transfer Helper Logic
 * Specifically for the Inter-Branch Transfer module.
 */

// Function to show modal and populate with data directly from DOM element attributes
window.editTransfer = function(btn) {
    if (!btn) return;

    const id = btn.getAttribute('data-id');
    const sourceBranchId = btn.getAttribute('data-source-id') || '';
    const destBranchId = btn.getAttribute('data-dest-id') || '';
    const status = btn.getAttribute('data-status') || 'Pending';
    const productId = btn.getAttribute('data-product-id') || '';
    const quantity = btn.getAttribute('data-quantity') || 0;

    // Fill fields in the modal
    const fields = {
        'update-transfer-id': id,
        'update-source-branch': sourceBranchId,
        'update-dest-branch': destBranchId,
        'update-status': status,
        'update-product': productId,
        'update-quantity': quantity
    };

    for (const [fieldId, value] of Object.entries(fields)) {
        const el = document.getElementById(fieldId);
        if (el) el.value = value;
    }

    // Show modal
    const modal = document.getElementById('update-transfer-modal');
    if (modal) modal.style.display = 'flex';
};
