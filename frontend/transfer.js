
// Sample data based on db_full.sql
let transferData = [
    { id: 'TRF-101', source: 'Colombo Main', destination: 'Kandy Central', product: 'Matte Lipstick - Ruby', quantity: 15, status: 'Completed', date: 'Today, 10:30 AM' },
    { id: 'TRF-102', source: 'Kandy Central', destination: 'Colombo Main', product: 'Argon Oil Shampoo', quantity: 10, status: 'Shipped', date: 'Yesterday, 14:15 PM' }
];

function renderTransfers(data = transferData) {
    const tbody = document.getElementById('transfer-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';
    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-secondary/30 transition-colors';
        
        let statusClass = 'bg-warning-light text-warning-text border-warning/20';
        let statusDotClass = 'bg-warning';
        if (item.status === 'Completed' || item.status === 'Received') {
            statusClass = 'bg-success-light text-success-text border-success/20';
            statusDotClass = 'bg-success';
        } else if (item.status === 'Shipped' || item.status === 'In Transit') {
            statusClass = 'bg-primary/10 text-primary border-primary/20';
            statusDotClass = 'bg-primary';
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
        `;
        tbody.appendChild(tr);
    });
}

document.addEventListener('DOMContentLoaded', () => {
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

    const submitBtn = document.getElementById('submit-transfer-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', () => {
            const dest = document.getElementById('dest-branch-select').textContent.trim();
            const product = document.getElementById('product-select').textContent.trim();
            const qty = document.getElementById('qty-input').textContent.trim();

            if (dest.includes('Select') || product.includes('Search') || qty.includes('Enter')) {
                alert('Please fill all fields. (Note: In this demo, click the fields to set values)');
                return;
            }

            const newTransfer = {
                id: 'TRF-' + (1000 + transferData.length + 1),
                source: 'Colombo Main',
                destination: dest,
                product: product,
                quantity: parseInt(qty),
                status: 'Pending',
                date: 'Just now'
            };

            transferData.unshift(newTransfer);
            renderTransfers();
            alert('Transfer request submitted successfully!');
            
            // Reset fields
            document.getElementById('dest-branch-select').innerHTML = 'Select Destination...';
            document.getElementById('product-select').innerHTML = 'Search or select product...';
            document.getElementById('qty-input').innerHTML = 'Enter quantity...';
        });
    }

    // Demo interactivity for selectors
    const selectors = [
        { id: 'dest-branch-select', options: ['Kandy Central', 'Galle Fort', 'Jaffna North'] },
        { id: 'product-select', options: ['Hydrating Face Serum', 'Matte Lipstick - Ruby', 'Argon Oil Shampoo'] },
        { id: 'qty-input', options: ['10', '20', '50', '100'] }
    ];

    selectors.forEach(sel => {
        const el = document.getElementById(sel.id);
        if (el) {
            el.addEventListener('click', () => {
                const choice = prompt(`Select ${sel.id.split('-')[0]}:\n${sel.options.join('\n')}`);
                if (sel.options.includes(choice)) {
                    el.textContent = choice;
                    el.classList.remove('text-muted-foreground');
                    el.classList.add('text-foreground');
                }
            });
        }
    });

    renderTransfers();
});
