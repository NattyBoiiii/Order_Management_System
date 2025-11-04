<div id="editMenuModal" class="modal-overlay hidden">
    <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Edit Menu Item</h3>
        </div>
        <form id="editMenuForm" class="px-6 py-4">
            <input type="hidden" id="editMenuId">
            <div class="mb-4">
                <label for="editMenuName" class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                <input type="text" id="editMenuName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" required>
            </div>
            <div class="mb-4">
                <label for="editMenuPrice" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <input type="number" id="editMenuPrice" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" min="1" required>
            </div>
            <div class="mb-4">
                <label for="editMenuImage" class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                <input type="url" id="editMenuImage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="https://example.com/image.jpg">
                <p class="text-xs text-gray-500 mt-1">Optional: Enter image URL or leave blank</p>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" id="cancelEditMenu" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Update Item
                </button>
            </div>
        </form>
    </div>
</div>