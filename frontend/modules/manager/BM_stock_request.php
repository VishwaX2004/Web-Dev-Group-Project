<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BranchPro – Stock Requests</title>
    <link rel="stylesheet" href="../../assets/css/BM_stock_request.css">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="container">
        
        <?php include 'BM_sidebar.php'; ?>

        <main class="main-content">+
            <header class="header-bar">
                <h2 class="title-text">Stock Requests</h2>
                <div class="top-right-info">
                    <div class="location-tag">📍 Colombo Branch — BR-001</div>
                    <div class="notif-btn">🔔<span class="notif-dot"></span></div>
                </div>
            </header>

            <div class="action-bar">
                <button class="btn btn-primary" onclick="openModal()"><i class="fa-solid fa-plus"></i> CREATE</button>
                <button class="btn btn-dark" onclick="showToast('📄 Refreshed latest requests')"><i class="fa-solid fa-rotate-right"></i> READ</button>
                <button class="btn btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search requests..." oninput="filterTable(this.value)">
                </div>
            </div>

            <div class="summary-strip">
                <span>📦 Total Requests: 12</span>
                <span>🕒 Pending: 3</span>
                <span>✅ Approved Today: 2</span>
                <span>❌ Rejected: 1</span>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h4>Stock Request List</h4>
                    <p>All replenishment requests for Colombo Branch</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>REQUEST ID</th>
                            <th>PRODUCT ID</th>
                            <th>PRODUCT NAME</th>
                            <th>QTY REQUESTED</th>
                            <th>REQUESTED BY</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td class="id-link">SR-0041</td>
                            <td class="id-link">P-0214</td>
                            <td>Paracetamol 500mg</td>
                            <td><span class="qty-box">50</span></td>
                            <td>Kumara Perera</td>
                            <td>Today, 10:14 AM</td>
                            <td><span class="status pending">Pending</span></td>
                            <td><button class="view-btn">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h3>➕ New Stock Request</h3>
                <button class="modal-close" onclick="closeModal()">❌</button>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Product ID</label>
                    <input class="form-input" id="productId" placeholder="e.g. P-0214">
                </div>
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input class="form-input" id="qty" type="number" placeholder="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input class="form-input" id="productName" placeholder="e.g. Paracetamol 500mg">
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal()">Cancel</button>
                <button class="btn btn-primary" onclick="submitRequest()">Submit Request</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast">
        <span id="toastMsg">Done</span>
    </div>

    <script>
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
    </script>
</body>
</html>