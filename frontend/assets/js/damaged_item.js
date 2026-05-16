function openAddModal() {
  document.getElementById('modalTitle').textContent = 'Report Damaged Item';
  

  const fields = ['fItemId', 'fbrancId', 'fProductId', 'fQuantity', 'fDescription'];
  fields.forEach(id => {
      let el = document.getElementById(id);
      if (el) el.value = ''; 
  });
  

  const dateField = document.getElementById('fDate');
  if (dateField) {
      dateField.value = new Date().toISOString().split('T')[0];
  }
  
  document.getElementById('formModal').classList.add('open');
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove('open');
}

function editItem(damage_id, branch_id, product_id, quantity, reason, reported_date) {
    document.getElementById('modalTitle').textContent = 'Edit Damaged Item';

    document.getElementById('actionType').value = 'edit';

    document.getElementById('fItemId').value = damage_id;
    document.getElementById('fItemId').readOnly = true;
    document.getElementById('fbrancId').value = branch_id;
    document.getElementById('fProductId').value = product_id;
    document.getElementById('fQuantity').value = quantity;
    document.getElementById('fDescription').value = reason;
    document.getElementById('fDate').value = reported_date;

    document.getElementById('formModal').classList.add('open');
}

function deleteItem(damage_id) {

    if (confirm("Are you sure you want to delete Damage ID: " + damage_id + "?")) {

        document.getElementById('deleteId').value = damage_id;
        document.getElementById('deleteForm').submit();
    }
}


function filterTable() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const rows = document.querySelectorAll('#tableBody tr');

  rows.forEach(row => {
      
      const text = row.textContent.toLowerCase();
      if(text.includes(q)) {
          row.style.display = '';
      } else {
          row.style.display = 'none';
      }
  });
}