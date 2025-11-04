document.addEventListener('DOMContentLoaded', function() {
    const cart = [];
    let total = 0;
    let paymentSuccessful = false;
    let paymentAmount = 0;
    let changeAmount = 0;
	let lastTransactionId = null;

    initializeEventListeners();

    document.getElementById('payBtn').addEventListener('click', function() {
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        const modal = document.getElementById('paymentModal');
        document.getElementById('amountDue').value = `₱${total.toFixed(2)}`;
        document.getElementById('amountPaid').value = '';
        document.getElementById('changeAmount').value = '₱0.00';
        document.getElementById('paymentError').style.display = 'none';
        modal.style.display = 'flex';

        document.getElementById('amountPaid').focus();
    });

    document.getElementById('cancelPayment').addEventListener('click', function() {
        document.getElementById('paymentModal').style.display = 'none';
    });

    document.getElementById('amountPaid').addEventListener('input', function() {
        const amountPaid = parseFloat(this.value) || 0;
        const change = amountPaid - total;
        
        if (amountPaid >= total && !isNaN(amountPaid)) {
            document.getElementById('changeAmount').value = `₱${change.toFixed(2)}`;
            document.getElementById('paymentError').style.display = 'none';
        } else {
            document.getElementById('changeAmount').value = '₱0.00';
        }
    });

    document.getElementById('confirmPayment').addEventListener('click', function() {
        const amountPaidInput = document.getElementById('amountPaid');
        const amountPaid = parseFloat(amountPaidInput.value);
        const errorElement = document.getElementById('paymentError');
        
        if (isNaN(amountPaid)) {
            errorElement.style.display = 'block';
            amountPaidInput.focus();
            return;
        }
        
        if (amountPaid < total) {
            errorElement.style.display = 'block';
            amountPaidInput.focus();
            return;
        }

        paymentSuccessful = true;
        paymentAmount = amountPaid;
        changeAmount = amountPaid - total;

        document.getElementById('receiptBtn').disabled = false;
        document.getElementById('paymentModal').style.display = 'none';
        alert(`Payment successful!\nAmount Paid: ₱${paymentAmount.toFixed(2)}\nChange: ₱${changeAmount.toFixed(2)}`);
    });

    document.getElementById('receiptBtn').addEventListener('click', function() {
        if (!paymentSuccessful) {
            alert('Please complete payment first before printing receipt.');
            return;
        }
        
        printReceipt();
    });

    function addToCart(name, price, quantity) {
        const existingItemIndex = cart.findIndex(item => item.name === name);
        
        if (existingItemIndex !== -1) {
            cart[existingItemIndex].quantity += quantity;
        } else {
            cart.push({
                name: name,
                price: price,
                quantity: quantity
            });
        }

        total += price * quantity;

        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartItemsContainer = document.getElementById('cartItems');
        const totalAmountElement = document.getElementById('totalAmount');

        cartItemsContainer.innerHTML = '';
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<div class="empty-cart">Your cart is empty</div>';
            totalAmountElement.textContent = '₱0.00';
            paymentSuccessful = false;
            document.getElementById('receiptBtn').disabled = true;
            return;
        }

        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'flex justify-between py-2 border-b border-gray-100';
            itemElement.innerHTML = `
                <div class="cart-item-name w-2/3">${item.name}</div>
                <div class="cart-item-quantity text-center w-1/6">x ${item.quantity}</div>
                <div class="cart-item-price text-right w-1/6">₱${(item.price * item.quantity).toFixed(2)}</div>
            `;
            cartItemsContainer.appendChild(itemElement);
        });
        
        totalAmountElement.textContent = `₱${total.toFixed(2)}`;
    }

    async function printReceipt() {
        try {
            lastTransactionId = await saveTransaction('pending');
        } catch (e) {
            alert('Saving transaction failed. Proceeding to print receipt.');
        }
        let receiptContent = `
            <style>
                body { 
                    font-family: Arial; 
                    padding: 15px;
                    max-width: 300px;
                    margin: 0 auto;
                }
                .receipt-header { 
                    text-align: center; 
                    margin-bottom: 15px;
                    border-bottom: 2px solid #e53935;
                    padding-bottom: 10px;
                }
                .receipt-title { 
                    font-size: 22px; 
                    font-weight: bold; 
                    color: #e53935; 
                    margin-bottom: 5px; 
                }
                .receipt-subtitle { 
                    font-size: 14px; 
                    color: #666; 
                }
                .receipt-date { 
                    font-size: 12px;
                    color: #666; 
                    margin-top: 5px;
                }
                .receipt-item { 
                    display: flex; 
                    justify-content: space-between; 
                    margin-bottom: 3px;
                    font-size: 14px;
                }
                .receipt-total { 
                    font-weight: bold; 
                    margin-top: 10px; 
                    border-top: 1px solid #ddd; 
                    padding-top: 10px; 
                    font-size: 16px;
                }
                .receipt-payment { 
                    margin-top: 5px; 
                    font-size: 14px;
                }
                .receipt-change { 
                    margin-bottom: 10px; 
                    font-size: 14px;
                }
                .receipt-footer { 
                    margin-top: 20px; 
                    text-align: center; 
                    font-style: italic; 
                    color: #666;
                    font-size: 12px;
                    border-top: 1px solid #ddd;
                    padding-top: 10px;
                }
            </style>
            <div class="receipt-header">
                <div class="receipt-title">ICHIBAN BOWL</div>
                <div class="receipt-subtitle">Japanese-Filipino Fusion</div>
                <div class="receipt-date">${new Date().toLocaleString()}</div>
            </div>
            <div class="receipt-items">
        `;
        
        cart.forEach(item => {
            receiptContent += `
                <div class="receipt-item">
                    <span>${item.name} x${item.quantity}</span>
                    <span>₱${(item.price * item.quantity).toFixed(2)}</span>
                </div>
            `;
        });
        
        receiptContent += `
                <div class="receipt-total">
                    <span>TOTAL:</span>
                    <span>₱${total.toFixed(2)}</span>
                </div>
                <div class="receipt-payment">
                    <span>PAID:</span>
                    <span>₱${paymentAmount.toFixed(2)}</span>
                </div>
                <div class="receipt-change">
                    <span>CHANGE:</span>
                    <span>₱${changeAmount.toFixed(2)}</span>
                </div>
            </div>
            <div class="receipt-footer">
                Thank you for your order!<br>
                Visit us again soon
            </div>
        `;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(receiptContent);
        printWindow.document.close();

        setTimeout(() => {
            printWindow.print();

            cart.length = 0;
            total = 0;
            paymentSuccessful = false;
            document.getElementById('receiptBtn').disabled = true;
            updateCartDisplay();
        }, 200);
    }

    async function saveTransaction(status = 'confirmed') {
		const sessionEl = document.getElementById('sessionData');
		const cashierIdAttr = sessionEl ? sessionEl.getAttribute('data-user-id') : null;
		const cashierId = cashierIdAttr && cashierIdAttr.trim() !== '' ? cashierIdAttr : null;
		const payload = {
			items: cart.map(i => ({ name: i.name, price: i.price, quantity: i.quantity })),
			total_amount: total,
			cashier_id: cashierId,
            status: status
		};
		const res = await fetch('api_folder/transactions.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(payload)
		});
		if (!res.ok) throw new Error('Failed');
		const data = await res.json();
		return data.id;
	}

    async function loadVisibleMenuItems() {
        try {
            const response = await fetch('api_folder/menu_api.php?visible=1');
            const data = await response.json();
            
            if (data.success && data.data) {
                displayVisibleItems(data.data);
            }
        } catch (error) {
            console.error('Error loading visible menu items:', error);
        }
    }

    function displayVisibleItems(items) {
        const container = document.getElementById('newArrivalsContainer');
        const title = document.getElementById('newArrivalsTitle');
        
        if (items.length === 0) {
            container.innerHTML = '';
            title.style.display = 'none';
            return;
        }
        
        title.style.display = 'block';
        container.innerHTML = '';
        
        items.forEach(item => {
            const imageUrl = item.sample_image_url || 'assets/pictures/default.png';
            const menuItem = document.createElement('div');
            menuItem.className = 'border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white';
            menuItem.innerHTML = `
                <div class="relative">
                    <img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(item.name)}" class="w-full h-36 object-cover" 
                         onerror="this.src='assets/pictures/default.png'">
                    <span class="category-tag drinks-tag">New</span>
                </div>
                <div class="p-4">
                    <div class="font-bold mb-1 text-gray-800">${escapeHtml(item.name)}</div>
                    <div class="font-bold mb-2 text-red-600">₱${item.product_price}</div>
                    <div class="flex items-center mb-3">
                        <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                        <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                        <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                    </div>
                    <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                            data-name="${escapeHtml(item.name)}" data-price="${item.product_price}">Add to Cart</button>
                </div>
            `;
            
            container.appendChild(menuItem);
        });
        
        initializeEventListeners();
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text ? text.replace(/[&<>"']/g, m => map[m]) : '';
    }

    function initializeEventListeners() {
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            if (!btn.hasAttribute('data-initialized')) {
                btn.setAttribute('data-initialized', 'true');
                btn.addEventListener('click', function() {
                    const parent = this.closest('.flex.items-center');
                    const input = parent.querySelector('input[type="number"]');
                    let value = parseInt(input.value);
                    
                    if (this.textContent === '-') {
                        if (value > 1) {
                            input.value = value - 1;
                        }
                    } else {
                        input.value = value + 1;
                    }
                });
            }
        });

        document.querySelectorAll('button[data-name]').forEach(button => {
            if (!button.hasAttribute('data-initialized')) {
                button.setAttribute('data-initialized', 'true');
                button.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const price = parseFloat(this.getAttribute('data-price'));
                    const inputEl = this.closest('.p-4').querySelector('input[type="number"]');
                    const parsedQty = parseInt(inputEl.value);
                    const quantity = Math.max(1, isNaN(parsedQty) ? 1 : parsedQty);

                    addToCart(name, price, quantity);

                    inputEl.value = 1;
                });
            }
        });
    }

    loadVisibleMenuItems();

    window.addEventListener('storage', function(e) {
        if (e && e.key === 'menuVisibilityChanged') {
            loadVisibleMenuItems();
        }
    });
});