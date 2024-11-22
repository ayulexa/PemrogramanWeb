let cart = [];
let totalCost = 0;

function addToCart(name, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    cart.push({ name: name, price: price });
    localStorage.setItem('cart', JSON.stringify(cart));

    updateCartDisplay();
}

function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    cart.splice(index, 1);  // Remove item from the cart array
    localStorage.setItem('cart', JSON.stringify(cart));  // Update localStorage
    updateCartDisplay();
}

function clearCart() {
    localStorage.removeItem('cart');
    updateCartDisplay();
}

function updateCartDisplay() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartItemsContainer = document.getElementById('cart-items');
    let totalCostElement = document.getElementById('total-cost');
    let totalCost = 0;

    cartItemsContainer.innerHTML = '';

    cart.forEach((item, index) => {
        let listItem = document.createElement('li');
        // Using a trash icon instead of 'Remove' text
        listItem.innerHTML = `${item.name} - $${item.price.toFixed(2)} <button onclick="removeFromCart(${index})"><i class="fa fa-trash"></i></button>`;
        cartItemsContainer.appendChild(listItem);
        totalCost += item.price;
    });

    totalCostElement.textContent = totalCost.toFixed(2);
}


function appendToCash(number) {
    let cashInput = document.getElementById('cash-input');
    cashInput.value += number;
    updateBalance();
}

function clearCash() {
    document.getElementById('cash-input').value = '';
}

function updateBalance() {
    let totalCost = parseFloat(document.getElementById('total-cost').textContent);
    let cashGiven = parseFloat(document.getElementById('cash-input').value) || 0;
    let balanceElement = document.getElementById('balance');
    let balance = cashGiven - totalCost;

    balanceElement.textContent = balance.toFixed(2);
}

function printInvoice() {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    const totalCost = parseFloat(document.getElementById('total-cost').innerText);
    const cashInput = parseFloat(document.getElementById('cash-input').value) || 0;
    const balance = parseFloat(document.getElementById('balance').innerText);

    const orderData = {
        cart: cartItems,
        totalPrice: totalCost,
        orderTime: new Date().toLocaleString()
    };

    fetch('save_order.php', {
        method: 'POST',
        body: JSON.stringify(orderData),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Order saved successfully!');
            localStorage.removeItem('cart');
            updateCartDisplay();

            // Show the printable receipt
            const receiptWindow = window.open('', 'Receipt', 'width=600,height=400');
            receiptWindow.document.write(`
                <html>
                    <head><title>Receipt</title></head>
                    <body>
                        <h1>PizzaMania - Receipt</h1>
                        <ul>
                            ${cartItems.map(item => `<li>${item.name} - $${item.price.toFixed(2)}</li>`).join('')}
                        </ul>
                        <p>Total: $${totalCost.toFixed(2)}</p>
                        <p>Cash Given: $${cashInput.toFixed(2)}</p>
                        <p>Balance: $${balance.toFixed(2)}</p>
                        <p>Thank you for your purchase!</p>
                    </body>
                </html>
            `);
            receiptWindow.document.close();
            receiptWindow.print();
        } else {
            alert('Failed to save the order: ' + data.message);
        }
    });
}

function showOrderHistory() {
    const historySection = document.getElementById('order-history-section');
    const historyList = document.getElementById('order-history-list');

    // Make an AJAX request to fetch order history
    fetch('fetch_order_history.php')
        .then(response => response.json())
        .then(data => {
            historyList.innerHTML = '';  // Clear any previous history

            if (data.length > 0) {
                data.forEach(order => {
                    // Create a string to display the details properly
                    let orderDetails = order.order_details.map(item => `${item.name} - $${item.price.toFixed(2)}`).join(', ');

                    const li = document.createElement('li');
                    li.innerHTML = `Order #${order.id} - ${order.order_time} - $${order.total_price} <br> Details: ${orderDetails}`;
                    historyList.appendChild(li);
                });
            } else {
                historyList.innerHTML = '<p>No previous orders found.</p>';
            }

            // Show the history section
            historySection.style.display = 'block';
        })
        .catch(error => console.error('Error fetching order history:', error));
}


