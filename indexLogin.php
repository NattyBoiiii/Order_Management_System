<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ichiban Bowl - Ordering System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-gray-100 p-5">
    <?php include 'includes/navbar.php'; ?>
	<div id="sessionData" data-user-id="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id'], ENT_QUOTES) : ''; ?>" data-username="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES) : ''; ?>" style="display:none"></div>
    <div class="container mx-auto flex max-w-6xl gap-5">
        <div class="w-3/4 bg-white p-5 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-5 text-gray-800">Ichiban Bowl Menu</h2>
            <div class="mb-8">
                <div class="text-lg font-medium mb-3 pb-1 border-b-2 border-red-600 text-red-600">Filipino Dishes</div>
                <div class="grid grid-cols-4 gap-4">
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/pares.jpg" alt="Street Style Beef Rice Bowl" class="w-full h-36 object-cover">
                            <span class="category-tag">Filipino</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Street Style Beef Rice Bowl</div>
                            <div class="font-bold mb-2 text-red-600">₱120</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Street Style Beef Rice Bowl" data-price="120">Add to Cart</button>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/tapsilog.jpg" alt="Tapa Rice Bowl" class="w-full h-36 object-cover">
                            <span class="category-tag">Filipino</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Tapa Rice Bowl <br><br></div>
                            <div class="font-bold mb-2 text-red-600">₱120</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Tapa Rice Bowl" data-price="120">Add to Cart</button>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/porkSisig.jpg" alt="Sizzling Savory Rice Bowl" class="w-full h-36 object-cover">
                            <span class="category-tag">Filipino</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Sizzling Savory Rice Bowl</div>
                            <div class="font-bold mb-2 text-red-600">₱130</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Sizzling Savory Rice Bowl" data-price="130">Add to Cart</button>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/kebab.jpg" alt="Chargrilled Rice Bowl" class="w-full h-36 object-cover">
                            <span class="category-tag">Filipino</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Chargrilled Rice Bowl</div>
                            <div class="font-bold mb-2 text-red-600">₱130</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Chargrilled Rice Bowl" data-price="130">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <div class="text-lg font-medium mb-3 pb-1 border-b-2 border-red-600 text-red-600">Japanese Dishes</div>
                <div class="grid grid-cols-4 gap-4">
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/omuRice.jpg" alt="The Classic Omu Rice" class="w-full h-36 object-cover">
                            <span class="category-tag japanese-tag">Japanese</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">The Classic Omu Rice</div>
                            <div class="font-bold mb-2 text-red-600">₱120</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="The Classic Omu Rice" data-price="120">Add to Cart</button>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/katsudon.jpg" alt="Crispy Cutlet Rice Bowl" class="w-full h-36 object-cover">
                            <span class="category-tag japanese-tag">Japanese</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Crispy Cutlet Rice Bowl</div>
                            <div class="font-bold mb-2 text-red-600">₱120</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Crispy Cutlet Rice Bowl" data-price="120">Add to Cart</button>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/gyudon.jpg" alt="Umami Beef Rice Bowl" class="w-full h-36 object-cover">
                            <span class="category-tag japanese-tag">Japanese</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Umami Beef Rice Bowl</div>
                            <div class="font-bold mb-2 text-red-600">₱120</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Umami Beef Rice Bowl" data-price="120">Add to Cart</button>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/oyakodon.jpg" alt="Savory Nest Rice Bowl" class="w-full h-36 object-cover">
                            <span class="category-tag japanese-tag">Japanese</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Savory Nest Rice Bowl</div>
                            <div class="font-bold mb-2 text-red-600">₱150</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Savory Nest Rice Bowl" data-price="150">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-8" id="newArrivalsSection">
                <div class="text-lg font-medium mb-3 pb-1 border-b-2 border-red-600 text-red-600" id="newArrivalsTitle" style="display: none;">New Arrivals</div>
                <div class="grid grid-cols-2 gap-4" id="newArrivalsContainer">
                </div>
            </div>
            <div class="mb-8">
                <div class="text-lg font-medium mb-3 pb-1 border-b-2 border-red-600 text-red-600">Drinks</div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/redIcedTea.jpg" alt="Classic House Tea" class="w-full h-36 object-cover">
                            <span class="category-tag drinks-tag">Drink</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Classic House Tea</div>
                            <div class="font-bold mb-2 text-red-600">₱25</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Classic House Tea" data-price="25">Add to Cart</button>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-md bg-white">
                        <div class="relative">
                            <img src="assets/pictures/peachIcedTea.jpg" alt="Summer Peach" class="w-full h-36 object-cover">
                            <span class="category-tag drinks-tag">Drink</span>
                        </div>
                        <div class="p-4">
                            <div class="font-bold mb-1 text-gray-800">Summer Peach</div>
                            <div class="font-bold mb-2 text-red-600">₱25</div>
                            <div class="flex items-center mb-3">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">-</button>
                                <input type="number" class="w-12 text-center p-1 mx-1 border border-gray-200 rounded" value="1" min="1">
                                <button class="quantity-btn bg-gray-100 border-none w-6 h-6 rounded cursor-pointer">+</button>
                            </div>
                            <button class="w-full py-2 bg-red-600 text-white border-none rounded cursor-pointer hover:bg-red-700 transition-colors" 
                                    data-name="Summer Peach" data-price="25">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-1/4 bg-white p-5 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-5 text-gray-800">Your Cart</h2>
            <div class="cart-items max-h-96 overflow-y-auto mb-5" id="cartItems">
                <div class="empty-cart">Your cart is empty</div>
            </div>
            <div class="total-section mt-5 pt-3 border-t border-gray-200">
                <div>Total Amount:</div>
                <div class="total-amount text-xl font-bold text-red-600 text-right mt-2" id="totalAmount">₱0.00</div>
            </div>
            <button class="pay-btn w-full py-3 bg-red-600 text-white border-none rounded cursor-pointer mt-3 hover:bg-red-700 transition-colors" id="payBtn">Pay</button>
            <button class="receipt-btn w-full py-3 bg-gray-800 text-white border-none rounded cursor-pointer mt-3 hover:bg-gray-900 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed" id="receiptBtn" disabled>Print Receipt</button>
        </div>
    </div>
    <div class="payment-modal" id="paymentModal">
        <div class="modal-content bg-white p-5 rounded-lg w-96 max-w-[90%]">
            <div class="modal-title text-xl font-bold mb-5 text-red-600">Payment</div>
            <div class="input-group mb-4">
                <label class="block font-bold mb-1">Amount Due:</label>
                <input type="text" id="amountDue" class="w-full p-2 border border-gray-200 rounded" readonly>
            </div>
            <div class="input-group mb-4">
                <label class="block font-bold mb-1">Amount Paid:</label>
                <input type="number" id="amountPaid" class="w-full p-2 border border-gray-200 rounded" placeholder="Enter amount">
                <div class="error-message text-red-600 text-sm mt-1" id="paymentError">Payment amount must be at least the total amount and must be a valid number</div>
            </div>
            <div class="input-group mb-4">
                <label class="block font-bold mb-1">Change:</label>
                <input type="text" id="changeAmount" class="w-full p-2 border border-gray-200 rounded" readonly>
            </div>
            <div class="modal-buttons flex justify-end gap-2 mt-5">
                <button class="cancel-btn py-2 px-4 bg-gray-100 border-none rounded cursor-pointer" id="cancelPayment">Cancel</button>
                <button class="confirm-btn py-2 px-4 bg-red-600 text-white border-none rounded cursor-pointer" id="confirmPayment">Confirm Payment</button>
            </div>
        </div>
    </div>
    <script src="assets/scripts_folder/script.js"></script>
</body>
</html>