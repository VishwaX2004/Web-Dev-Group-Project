// This array holds the items added to the shopping cart
let cart = [];

/**
 * Adds a chosen product to the cart.
 * If the product is already in the cart, it just adds to the quantity.
 */
function addToCart() {
    const productSelect = document.getElementById("product-select");
    const selectedOption = productSelect.options[productSelect.selectedIndex];

    // Check if the user actually chose a product
    if (!selectedOption.value) {
        alert("Please select a product");
        return;
    }

    // Get product details from the HTML attributes
    const product_id = selectedOption.value;

    const product_name = selectedOption.dataset.name;

    const price = parseFloat(selectedOption.dataset.price);

    const stock = parseInt(selectedOption.dataset.stock);

    const qtyInput = document.getElementById("product-qty");

    const qty = parseInt(qtyInput.value);

    // Make sure the entered quantity is a number greater than 0
    if (qty <= 0 || isNaN(qty)) {

        alert("Invalid quantity");

        return;
    }

    // Check if this product is already in the cart
    const existing = cart.find(item => item.product_id == product_id);

    const currentInCart = existing ? existing.qty : 0;

    // Stop the user if they try to buy more than what is in stock
    if ((currentInCart + qty) > stock) {

        alert("Insufficient stock! Available in this branch: " + stock);

        return;
    }

    // If the item is already in the cart, increase its quantity. Otherwise, add it as a new item.
    if (existing) {

        existing.qty += qty;

        existing.total = existing.qty * existing.price;

    } else {

        cart.push({
            product_id: product_id,
            product_name: product_name,
            price: price,
            qty: qty,
            stock: stock, // Save the stock limit to check later if they change quantities
            total: qty * price
        });
    }
    
    // Reset the quantity input box back to 1
    qtyInput.value = 1; 

    renderCart();
}

/**
 * Changes the quantity of an item that is already in the cart (+1 or -1).
 * 
 * @param {number} index - Where the item is in the cart array.
 * @param {number} change - The change amount (like +1 or -1).
 */
function updateQty(index, change) {
    const item = cart[index];
    const newQty = item.qty + change;

    // Do not let the user add more than the available stock
    if (newQty > item.stock) {

        alert("Cannot exceed available stock (" + item.stock + ")");

        return;
    }

    // If quantity goes down to 0 or less, remove the item completely
    if (newQty <= 0) {

        removeItem(index);

    } else {

        item.qty = newQty;
        item.total = item.qty * item.price;
        renderCart();
    }
}

/**
 * Removes an item completely from the cart array.
 * 
 * @param {number} index - Where the item is in the cart array.
 */
function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

/**
 * Clears the cart table on the screen and redraws it using the latest cart data.
 */
function renderCart() {
    const cartBody = document.getElementById("cart-body");
    cartBody.innerHTML = ""; // Clear the table first

    let subtotal = 0;

    // Go through each item in the cart and create a table row for it
    cart.forEach((item, index) => {
        subtotal += item.total;

        cartBody.innerHTML += `
            <tr>
                <td>${item.product_name}<br><small>ID: ${item.product_id}</small></td>
                <td>Rs. ${item.price.toFixed(2)}</td>
                <td style="text-align:center;">
                    <div class="qty-control">
                        <button onclick="updateQty(${index}, -1)" class="qty-btn">-</button>
                        <span class="qty-val">${item.qty}</span>
                        <button onclick="updateQty(${index}, 1)" class="qty-btn">+</button>
                    </div>
                </td>
                <td>Rs. ${item.total.toFixed(2)}</td>
                <td>
                    <button onclick="removeItem(${index})" class="btn-remove">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>`;
    });

    // Update the total price on the screen
    document.getElementById("grand-total").innerText = "Rs. " + subtotal.toFixed(2);

    // Calculate the change/balance immediately
    calcBalance();
}

/**
 * Calculates the change money to give back to the customer.
 */
function calcBalance() {
    // Clean up text format to get pure numbers for total and paid amount
    const total = parseFloat(document.getElementById("grand-total").innerText.replace("Rs. ", "").replace(",", "")) || 0;
    
    const paid = parseFloat(document.getElementById("amount-paid").value) || 0;

    // Calculate change (Amount Paid minus Total Price)
    const balance = paid - total;

    // Show the calculated balance on the screen
    document.getElementById("balance").value = "Rs. " + balance.toFixed(2);
}

/**
 * Checks all numbers and sends the cart data to the database to finish the order.
 */
function completeOrder() {
    // Do not allow checkout if the cart is empty
    if (cart.length === 0) {
        alert("Cart is empty");
        return;
    }

    const paid = parseFloat(document.getElementById("amount-paid").value);

    const total = parseFloat(document.getElementById("grand-total").innerText.replace("Rs. ", "").replace(",", ""));

    const branch_id = document.getElementById("branch-id-val").value;

    // Make sure the customer paid enough money
    if (isNaN(paid) || paid < total) {

        alert("Payment incomplete or invalid.");

        return;
    }

    // Ask for final confirmation before saving the transaction
    if (!confirm("Finalize this transaction?")) return;

    // Send the data to the backend PHP file using a POST request
    fetch("../../../backend/api/cashier/cashier_sales_order_process.php", {

        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            cart: cart,
            total_amount: total,
            amount_paid: paid,
            branch_id: branch_id
        })
    })
    .then(r => r.json())
    .then(data => {
        // Check if the backend saved the order successfully
        if (data.status === "success") {

            alert("Order Success! Order ID: " + data.sale_id);

            location.reload(); // Refresh the page to start a new sale

        } else {

            // If the backend returned an error, show the message
            alert("Process Failed: " + data.message);
        }
    })
    .catch(e => alert("System communication error."));
}