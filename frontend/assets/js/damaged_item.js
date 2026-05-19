// This function opens the modal (popup box) to add a NEW damaged item
function openAddModal() {
  // Set the title of the popup box to show we are adding a new item
  document.getElementById('modalTitle').textContent = 'Report Damaged Item';
  
  // List of all the input boxes inside the form
  const fields = ['fItemId', 'fbrancId', 'fProductId', 'fQuantity', 'fDescription'];
  
  // Go through each input box and clear out any old typing so it's fresh and empty
  fields.forEach(id => {
      let el = document.getElementById(id);
      if (el) el.value = ''; 
  });
  
  // Find the date input box
  const dateField = document.getElementById('fDate');
  if (dateField) {
      // Automatically fill the date box with today's date (YYYY-MM-DD format)
      dateField.value = new Date().toISOString().split('T')[0];
  }
  
  // Finally, show the popup box on the screen by adding the 'open' class
  document.getElementById('formModal').classList.add('open');
}

// This function closes any modal (popup box) when you click 'Cancel' or the 'X' button
function closeModal(modalId) {
  // Hide the popup box by removing the 'open' class
  document.getElementById(modalId).classList.remove('open');
}

// This function opens the modal but fills it with data so you can EDIT an existing item
function editItem(damage_id, branch_id, product_id, quantity, reason, reported_date) {
    // Change the title of the popup box to show we are editing
    document.getElementById('modalTitle').textContent = 'Edit Damaged Item';

    // Tell the hidden input that our action is now 'edit' instead of 'add'
    document.getElementById('actionType').value = 'edit';

    // Fill all the input boxes with the current data of the item you clicked
    document.getElementById('fItemId').value = damage_id;
    // Make sure the Damage ID cannot be changed by the user (read-only)
    document.getElementById('fItemId').readOnly = true; 
    document.getElementById('fbrancId').value = branch_id;
    document.getElementById('fProductId').value = product_id;
    document.getElementById('fQuantity').value = quantity;
    document.getElementById('fDescription').value = reason;
    document.getElementById('fDate').value = reported_date;

    // Show the popup box on the screen with all the data filled in
    document.getElementById('formModal').classList.add('open');
}

// This function is triggered when you click the trash can icon to delete an item
function deleteItem(damage_id) {
    // Show a browser confirmation pop-up asking "Are you sure?"
    if (confirm("Are you sure you want to delete Damage ID: " + damage_id + "?")) {
        // If they click 'OK', put the ID into the hidden delete form
        document.getElementById('deleteId').value = damage_id;
        // Submit the hidden form to delete the record from the database
        document.getElementById('deleteForm').submit();
    }
}

// This function filters the table rows based on what you type in the search bar
function filterTable() {
  // Get whatever text the user typed in the search bar and make it all lowercase
  const q = document.getElementById('searchInput').value.toLowerCase();
  // Get a list of every single row inside the data table
  const rows = document.querySelectorAll('#tableBody tr');

  // Check every row one by one
  rows.forEach(row => {
      // Get all the text inside that specific row and make it lowercase
      const text = row.textContent.toLowerCase();
      
      // If the row's text contains the words the user searched for...
      if(text.includes(q)) {
          // Keep showing the row
          row.style.display = '';
      } else {
          // Otherwise, hide the row completely
          row.style.display = 'none';
      }
  });
}