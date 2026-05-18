// --- Modal Control ---
function openModal() { 
    document.getElementById('modalOverlay').classList.add('open'); 
}

function closeModal() { 
    document.getElementById('modalOverlay').classList.remove('open'); 
}

// --- Search Filter ---
function filterTable(val) {
    const rows = document.querySelectorAll('#tableBody tr');
    const searchVal = val.toLowerCase();

    rows.forEach(r => {
        // Table row eke text eka check kara match nethnam hide karanawa
        r.style.display = r.textContent.toLowerCase().includes(searchVal) ? '' : 'none';
    });
}


