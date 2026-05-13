// --- Functions (From your original Logic) ---
        function openModal() { document.getElementById('modalOverlay').classList.add('open'); }
        function closeModal() { document.getElementById('modalOverlay').classList.remove('open'); }
        
        function submitRequest() {
            const pid = document.getElementById('productId').value.trim();
            const qty = document.getElementById('qty').value.trim();
            const name = document.getElementById('productName').value.trim();

            if (!pid || !qty || !name) {
                showToast('⚠️ Please fill all fields');
                return;
            }

            const tbody = document.getElementById('tableBody');
            const newRow = document.createElement('tr');
            const timeStr = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

            newRow.innerHTML = `
                <td class="id-link">SR-00${42 + tbody.rows.length}</td>
                <td class="id-link">${pid.toUpperCase()}</td>
                <td>${name}</td>
                <td><span class="qty-box">${qty}</span></td>
                <td>Kumara Perera</td>
                <td>Today, ${timeStr}</td>
                <td><span class="status pending">Pending</span></td>
                <td><button class="view-btn">View</button></td>
            `;

            tbody.insertBefore(newRow, tbody.firstChild);
            closeModal();
            showToast('✅ Request submitted!');
            // Reset
            document.getElementById('productId').value = '';
            document.getElementById('qty').value = '';
            document.getElementById('productName').value = '';
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        function filterTable(val) {
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(r => {
                r.style.display = r.textContent.toLowerCase().includes(val.toLowerCase()) ? '' : 'none';
            });
        }