/**
 * Transfer Helper Logic
 * Specifically for the Inter-Branch Transfer module.
 */

// Function to show modal and populate with data
window.editTransfer = function(id) {
    console.log('Edit clicked for ID:', id);
    
    // transferData should be globally available from the PHP file
    if (typeof transferData === 'undefined') {
        console.error('transferData is not defined');
        return;
    }

    const item = transferData.find(t => t.id == id);
    if (!item) {
        console.error('No data found for ID:', id);
        return;
    }

    // Fill fields
    const fields = {
        'update-transfer-id': item.id,
        'update-source-branch': item.source_branch_id || '',
        'update-dest-branch': item.dest_branch_id || '',
        'update-status': item.status || 'Pending',
        'update-product': item.product_id || '',
        'update-quantity': item.quantity || 0
    };

    for (const [id, value] of Object.entries(fields)) {
        const el = document.getElementById(id);
        if (el) el.value = value;
    }

    // Show modal
    const modal = document.getElementById('update-transfer-modal');
    if (modal) modal.style.display = 'flex';
};
