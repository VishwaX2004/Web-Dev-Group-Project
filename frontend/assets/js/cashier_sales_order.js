
let cart = [];

function addToCart() {
    const select = document.getElementById('product-select');
    const qtyInput = document.getElementById('product-qty');
    const name = select.value;
    const price = parseFloat(select.options[select.selectedIndex].getAttribute('data-price'));
    const qty = parseInt(qtyInput.value);

    if (name === "0") return alert("Please select a product");

    const total = price * qty;
    cart.push({ name, price, qty, total });
    renderCart();
}

function renderCart() {
    const tbody = document.getElementById('cart-body');
    tbody.innerHTML = '';
    let subtotal = 0;

    cart.forEach((item, index) => {
        subtotal += item.total;
        tbody.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>Rs.${item.price.toLocaleString()}</td>
                        <td>${item.qty}</td>
                        <td>Rs.${item.total.toLocaleString()}</td>
                        <td><i class="fa-solid fa-trash" style="color:#DC2626; cursor:pointer" onclick="removeItem(${index})"></i></td>
                    </tr>
                `;
    });

    const tax = subtotal * 0.05;
    const grandTotal = subtotal + tax;

    document.getElementById('subtotal').innerText = `Rs. ${subtotal.toLocaleString()}`;
    document.getElementById('tax').innerText = `Rs. ${tax.toLocaleString()}`;
    document.getElementById('grand-total').innerText = `Rs. ${grandTotal.toLocaleString()}`;
    calcBalance();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

function calcBalance() {
    const totalText = document.getElementById('grand-total').innerText.replace('Rs. ', '').replace(/,/g, '');
    const total = parseFloat(totalText);
    const paid = parseFloat(document.getElementById('amount-paid').value) || 0;
    const balance = paid - total;

    document.getElementById('balance').value = balance > 0 ? `Rs. ${balance.toLocaleString()}` : "Rs. 0.00";
}

function completeOrder() {
    if (cart.length === 0) return alert("Cart is empty!");
    alert("Order Processed Successfully!");
    cart = [];
    document.getElementById('amount-paid').value = '';
    renderCart();
}