document.addEventListener('DOMContentLoaded', function() {
    const addUserBtn = document.getElementById('addUserBtn');
    const addUserModal = document.getElementById('addUserModal');
    const closeAddUserModalBtn = document.getElementById('closeAddUserModalBtn');
    const addUserForm = document.getElementById('addUserForm');
    const userTableBody = document.getElementById('userTableBody');

    loadUsers();

    if (addUserBtn) {
        addUserBtn.addEventListener('click', function() {
            if (addUserModal) {
                addUserModal.classList.remove('hidden');
            }
        });
    }

    if (closeAddUserModalBtn && addUserForm) {
        closeAddUserModalBtn.addEventListener('click', function() {
            if (addUserModal) {
                addUserModal.classList.add('hidden');
            }
            addUserForm.reset();
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target === addUserModal) {
            addUserModal.classList.add('hidden');
            if (addUserForm) {
                addUserForm.reset();
            }
        }
    });

    if (addUserForm) {
        addUserForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('addUsername').value.trim();
            const firstName = document.getElementById('addFirstName').value.trim();
            const lastName = document.getElementById('addLastName').value.trim();
            const email = document.getElementById('addEmail').value.trim();
            const password = document.getElementById('addPassword').value;
            const adminRole = document.getElementById('addRole').value;
            
            const submitBtn = addUserForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Adding...';
            
            try {
                const response = await fetch('api_folder/users.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'add',
                        username: username,
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        password: password,
                        admin_role: adminRole
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'User added successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    addUserModal.classList.add('hidden');
                    addUserForm.reset();
                    loadUsers();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to add user'
                    });
                    
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again later.'
                });
                
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
            }
        });
    }

    function loadUsers() {
        userTableBody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Loading users...</td></tr>';
        
        fetch('api_folder/users.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayUsers(data.data);
                } else {
                    userTableBody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-red-500">Error: ' + (data.message || 'Failed to load users') + '</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                userTableBody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-red-500">Error loading users. Please try again.</td></tr>';
            });
    }

    function displayUsers(users) {
        if (!users || users.length === 0) {
            userTableBody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">No users found.</td></tr>';
            return;
        }
        
        let html = '';
        const canManage = userTableBody && userTableBody.dataset && userTableBody.dataset.role === 'superAdmin';
        users.forEach(user => {
            const dateAdded = new Date(user.date_added);
            const formattedDate = dateAdded.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const roleBadge = user.admin_role === 'superAdmin' 
                ? '<span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">Super Admin</span>'
                : '<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Admin</span>';
            
            const statusBadge = user.admin_status === 'active'
                ? '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Active</span>'
                : '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Inactive</span>';
            
            const suspendText = user.admin_status === 'active' ? 'Suspend' : 'Activate';
            const suspendColor = user.admin_status === 'active' ? 'text-yellow-600 hover:text-yellow-800' : 'text-green-600 hover:text-green-800';
            const suspendIcon = user.admin_status === 'active' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            
            const actionsHtml = `
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-700">${user.user_id}</td>
                    <td class="px-4 py-3 text-gray-700 font-medium">${escapeHtml(user.username)}</td>
                    <td class="px-4 py-3 text-gray-700">${escapeHtml(user.first_name)} ${escapeHtml(user.last_name)}</td>
                    <td class="px-4 py-3 text-gray-700">${escapeHtml(user.email)}</td>
                    <td class="px-4 py-3">${roleBadge}</td>
                    <td class="px-4 py-3">${statusBadge}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">${formattedDate}</td>
                    <td class="px-4 py-3">
                        ${canManage ? `
                            <div class="flex items-center gap-2">
                                <button class="${suspendColor} transition-colors" onclick="suspendUser(${user.user_id}, '${user.admin_status}')" title="${suspendText} User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        ${suspendIcon}
                                    </svg>
                                </button>
                                <button class="text-red-600 hover:text-red-800 transition-colors" onclick="deleteUser(${user.user_id})" title="Delete User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        ` : `
                            <div class="flex items-center gap-2 text-gray-400" title="Only Super Admin can manage users">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    ${suspendIcon}
                                </svg>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                        `}
                    </td>
                </tr>
            `;
            html += actionsHtml;
        });
        
        userTableBody.innerHTML = html;
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    window.suspendUser = async function(userId, currentStatus) {
        const action = currentStatus === 'active' ? 'suspend' : 'activate';
        const actionText = currentStatus === 'active' ? 'suspend' : 'activate';
        
        const result = await Swal.fire({
            title: `Are you sure?`,
            text: `Do you want to ${actionText} this user?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: currentStatus === 'active' ? '#d97706' : '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Yes, ${actionText} it!`,
            cancelButtonText: 'Cancel'
        });
        
        if (result.isConfirmed) {
            try {
                const response = await fetch('api_folder/users.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: action,
                        user_id: userId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    loadUsers();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to update user status'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again later.'
                });
            }
        }
    };

    window.deleteUser = async function(userId) {
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! This will permanently delete the user.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        });
        
        if (result.isConfirmed) {
            try {
                const response = await fetch('api_folder/users.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        user_id: userId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    loadUsers();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to delete user'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again later.'
                });
            }
        }
    };
});