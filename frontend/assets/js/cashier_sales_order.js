let cart = [];

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
    const qty = parseInt(document.getElementById("product-qty").value);

    if (qty <= 0 || isNaN(qty)) {
        alert("Invalid quantity");
        return;
    }

    if (qty > stock) {
        alert("Not enough stock available in this branch");
        return;
    }

    const existing = cart.find(item => item.product_id == product_id);

    if (existing) {
        if ((existing.qty + qty) > stock) {
            alert("Total quantity exceeds available stock");
            return;
        }
        existing.qty += qty;
        existing.total = existing.qty * existing.price;
    } else {
        cart.push({
            product_id: product_id,
            product_name: product_name,
            price: price,
            qty: qty,
            total: qty * price
        });
    }

    renderCart();
}

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
                <td>${item.qty}</td>
                <td>Rs. ${item.total.toFixed(2)}</td>
                <td>
                    <button onclick="removeItem(${index})" style="background:red;color:white;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;">X</button>
                </td>
            </tr>
        `;
    });

    document.getElementById("subtotal").innerText = "Rs. " + subtotal.toFixed(2);
    document.getElementById("grand-total").innerText = "Rs. " + subtotal.toFixed(2);
    calcBalance();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

function calcBalance() {
    const grandTotalText = document.getElementById("grand-total").innerText.replace("Rs. ", "").replace(",", "");
    const grandTotal = parseFloat(grandTotalText) || 0;
    const amountPaid = parseFloat(document.getElementById("amount-paid").value) || 0;
    const balance = amountPaid - grandTotal;
    document.getElementById("balance").value = "Rs. " + balance.toFixed(2);
}

function completeOrder() {
    if (cart.length === 0) {
        alert("Cart is empty");
        return;
    }

    const amountPaid = parseFloat(document.getElementById("amount-paid").value);
    const grandTotalText = document.getElementById("grand-total").innerText.replace("Rs. ", "").replace(",", "");
    const grandTotal = parseFloat(grandTotalText);
    const branch_id = document.getElementById("branch-id-val").value;

    if (isNaN(amountPaid) || amountPaid < grandTotal) {
        alert("Insufficient or invalid payment amount");
        return;
    }

    fetch("../../../backend/api/cashier/cashier_sales_order_process.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            cart: cart,
            total_amount: grandTotal,
            amount_paid: amountPaid,
            branch_id: branch_id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Transaction Complete!\n\nSale ID: " + data.sale_id);
            location.reload();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Transaction Failed");
    });
}