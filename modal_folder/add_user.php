<div id="addUserModal" class="modal-overlay hidden">
    <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Add Admin/SuperAdmin User</h3>
        </div>
        <form id="addUserForm" class="px-6 py-4">
            <div class="mb-4">
                <label for="addUsername" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="addUsername" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" required>
            </div>
            <div class="mb-4">
                <label for="addFirstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <input type="text" id="addFirstName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" required>
            </div>
            <div class="mb-4">
                <label for="addLastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <input type="text" id="addLastName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" required>
            </div>
            <div class="mb-4">
                <label for="addEmail" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="addEmail" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" required>
            </div>
            <div class="mb-4">
                <label for="addPassword" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="addPassword" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" required minlength="6">
                <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
            </div>
            <div class="mb-4">
                <label for="addRole" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select id="addRole" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" required>
                    <option value="admin">Admin</option>
                    <option value="superAdmin">Super Admin</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" id="closeAddUserModalBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Add User
                </button>
            </div>
        </form>
    </div>
</div>

