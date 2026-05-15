/**
 * Frontend logic for Sales Order Processing
 */
let cart = [];

/**
 * Adds selected product to the cart or updates quantity if already exists
 */
function addToCart() {
    const productSelect = document.getElementById("product-select");
    const selectedOption = productSelect.options[productSelect.selectedIndex];

    if (!selectedOption.value) {
        alert("Please select a product");
        return;
    }

    const product_id = selectedOption.value;
    const product_name = selectedOption.dataset.name;
    const price = parseFloat(selectedOption.dataset.price);
    const stock = parseInt(selectedOption.dataset.stock);
    const qtyInput = document.getElementById("product-qty");
    const qty = parseInt(qtyInput.value);

    if (qty <= 0 || isNaN(qty)) {
        alert("Invalid quantity");
        return;
    }

    const existing = cart.find(item => item.product_id == product_id);
    const currentInCart = existing ? existing.qty : 0;

    // Validate if total quantity exceeds physical stock
    if ((currentInCart + qty) > stock) {
        alert("Insufficient stock! Available in this branch: " + stock);
        return;
    }

    if (existing) {
        existing.qty += qty;
        existing.total = existing.qty * existing.price;
    } else {
        cart.push({
            product_id: product_id,
            product_name: product_name,
            price: price,
            qty: qty,
            stock: stock, // Store stock limit for later adjustments
            total: qty * price
        });
    }
    
    qtyInput.value = 1; // Reset qty input
    renderCart();
}

/**
 * Updates the quantity of an item already in the cart
 * @param {number} index - Index of item in cart array
 * @param {number} change - Amount to change (+1 or -1)
 */
function updateQty(index, change) {
    const item = cart[index];
    const newQty = item.qty + change;

    if (newQty > item.stock) {
        alert("Cannot exceed available stock (" + item.stock + ")");
        return;
    }

    if (newQty <= 0) {
        // If qty reaches zero, remove the item
        removeItem(index);
    } else {
        item.qty = newQty;
        item.total = item.qty * item.price;
        renderCart();
    }
}

/**
 * Removes an item completely from the cart
 */
function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

/**
 * Renders the HTML table for the current cart
 */
function renderCart() {
    const cartBody = document.getElementById("cart-body");
    cartBody.innerHTML = "";
    let subtotal = 0;

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

    document.getElementById("grand-total").innerText = "Rs. " + subtotal.toFixed(2);
    calcBalance();
}

/**
 * Calculates change balance based on amount tendered
 */
function calcBalance() {
    const total = parseFloat(document.getElementById("grand-total").innerText.replace("Rs. ", "").replace(",", "")) || 0;
    const paid = parseFloat(document.getElementById("amount-paid").value) || 0;
    const balance = paid - total;
    document.getElementById("balance").value = "Rs. " + balance.toFixed(2);
}

/**
 * Sends cart data to the backend for processing
 */
function completeOrder() {
    if (cart.length === 0) {
        alert("Cart is empty");
        return;
    }

    const paid = parseFloat(document.getElementById("amount-paid").value);
    const total = parseFloat(document.getElementById("grand-total").innerText.replace("Rs. ", "").replace(",", ""));
    const branch_id = document.getElementById("branch-id-val").value;

    if (isNaN(paid) || paid < total) {
        alert("Payment incomplete or invalid.");
        return;
    }

    if (!confirm("Finalize this transaction?")) return;

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
        if (data.status === "success") {
            alert("Order Success! Order ID: " + data.sale_id);
            location.reload();
        } else {
            alert("Process Failed: " + data.message);
        }
    })
    .catch(e => alert("System communication error."));
}