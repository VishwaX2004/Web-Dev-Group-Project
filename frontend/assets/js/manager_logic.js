/**
 * Manager Logic (Vanilla JS)
 * Common UI interactions for the Branch Manager dashboard.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Modal Toggling Helper
    const setupModal = (triggerId, modalId, closeBtnId, cancelBtnId) => {
        const trigger = document.getElementById(triggerId);
        const modal = document.getElementById(modalId);
        const closeBtn = document.getElementById(closeBtnId);
        const cancelBtn = document.getElementById(cancelBtnId);

        if (!modal) return;

        const showModal = () => {
            modal.style.display = 'flex';
        };

        const hideModal = () => {
            modal.style.display = 'none';
        };

        if (trigger) trigger.addEventListener('click', showModal);
        if (closeBtn) closeBtn.addEventListener('click', hideModal);
        if (cancelBtn) cancelBtn.addEventListener('click', hideModal);

        // Close on clicking overlay
        modal.addEventListener('click', (e) => {
            if (e.target === modal) hideModal();
        });
    };

    // Initialize Inventory Add Stock Modal
    setupModal('add-stock-btn', 'add-stock-modal', 'close-modal-btn', 'cancel-modal-btn');

    // Initialize Transfer Update Modal (listeners are often handled in module-specific JS)
    // but the overlay-click logic is useful here.
    const updateTransferModal = document.getElementById('update-transfer-modal');
    if (updateTransferModal) {
        updateTransferModal.addEventListener('click', (e) => {
            if (e.target === updateTransferModal) updateTransferModal.style.display = 'none';
        });
    }
});
