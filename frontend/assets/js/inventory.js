/**
 * Inventory Management (Vanilla JS)
 */

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('inventory-search');
    const addStockModal = document.getElementById('add-stock-modal');
    const addStockForm = document.getElementById('add-stock-form');
    
    // 1. Search Bar Filter Logic (Pure DOM manipulation)
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.inventory-row');
            
            rows.forEach(row => {
                const name = row.querySelector('.item-name').textContent.toLowerCase();
                const id = row.querySelector('.item-id').textContent.toLowerCase();
                const category = row.querySelector('.item-category').textContent.toLowerCase();
                
                if (name.includes(term) || id.includes(term) || category.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // 2. Add Stock Modal controls
    const addStockBtn = document.getElementById('add-stock-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');

    if (addStockBtn && addStockModal) {
        addStockBtn.addEventListener('click', () => {
            const productNameInput = addStockModal.querySelector('input[name="product_name"]');
            const categorySelect = addStockModal.querySelector('select[name="category_name"]');
            const quantityInput = addStockModal.querySelector('input[name="quantity"]');
            const modalTitle = addStockModal.querySelector('.modal-header h3');
            const submitBtn = addStockModal.querySelector('.modal-footer .btn-primary');

            // Reset modal to creation state
            productNameInput.value = '';
            productNameInput.readOnly = false;
            categorySelect.value = '';
            quantityInput.value = '';
            quantityInput.placeholder = '0';
            modalTitle.textContent = 'Add New Stock';
            submitBtn.textContent = 'Add to Inventory';
            
            addStockModal.style.display = 'flex';
        });
    }

    // Close Modal helpers
    const closeModal = () => {
        if (addStockModal) addStockModal.style.display = 'none';
    };

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

    // Close on clicking outside modal container
    if (addStockModal) {
        addStockModal.addEventListener('click', (e) => {
            if (e.target === addStockModal) {
                closeModal();
            }
        });
    }

    // 3. Edit/Adjust Stock Button Handler
    const editBtns = document.querySelectorAll('.edit-stock-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const name = btn.getAttribute('data-name');
            const category = btn.closest('tr').querySelector('.item-category').textContent.trim();
            
            const productNameInput = addStockModal.querySelector('input[name="product_name"]');
            const categorySelect = addStockModal.querySelector('select[name="category_name"]');
            const quantityInput = addStockModal.querySelector('input[name="quantity"]');
            const modalTitle = addStockModal.querySelector('.modal-header h3');
            const submitBtn = addStockModal.querySelector('.modal-footer .btn-primary');

            // Open modal in Adjust state
            productNameInput.value = name;
            productNameInput.readOnly = true; // Protect name edit
            
            // Auto-select category
            for (let option of categorySelect.options) {
                if (option.text === category) {
                    categorySelect.value = option.value;
                    break;
                }
            }

            quantityInput.value = '';
            quantityInput.placeholder = 'Enter quantity to add...';
            modalTitle.textContent = 'Adjust Stock - ' + name;
            submitBtn.textContent = 'Adjust Stock';

            addStockModal.style.display = 'flex';
            quantityInput.focus();
        });
    });
});
