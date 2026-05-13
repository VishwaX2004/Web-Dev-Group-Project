let items = []; 
let filtered = [];
let editingId = null;

function filterTable() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const sev = document.getElementById('severityFilter').value;
  const sta = document.getElementById('statusFilter').value;
  filtered = items.filter(i =>
    (i.name.toLowerCase().includes(q) || i.itemId.toLowerCase().includes(q)) &&
    (sev ? i.severity === sev : true) &&
    (sta ? i.status === sta : true)
  );
}


function openAddModal() {
  editingId = null;
  document.getElementById('modalTitle').textContent = 'Report Damaged Item';
  const fields = ['fItemId', 'fbrancId', 'fProductId', 'fQuantity', 'fDescription', 'fDate'];
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

function saveItem() {
    alert("Save button clicked! Backend eka thama hadala na.");
}