document.addEventListener('DOMContentLoaded', function() {
    const sessionEl = document.getElementById('sessionData');
    const userId = sessionEl ? parseInt(sessionEl.getAttribute('data-user-id')) : null;
    const userRole = sessionEl ? sessionEl.getAttribute('data-role') : null;
    
    const addMenuBtn = document.getElementById('addMenuBtn');
    const addMenuModal = document.getElementById('addMenuModal');
    const editMenuModal = document.getElementById('editMenuModal');
    const addMenuForm = document.getElementById('addMenuForm');
    const editMenuForm = document.getElementById('editMenuForm');
    const cancelAddMenu = document.getElementById('cancelAddMenu');
    const cancelEditMenu = document.getElementById('cancelEditMenu');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const menuTableContainer = document.getElementById('menuTableContainer');
    const emptyState = document.getElementById('emptyState');
    const menuTableBody = document.getElementById('menuTableBody');
    
    loadMenus();
    
    if (addMenuBtn) {
        addMenuBtn.addEventListener('click', function() {
            addMenuModal.classList.remove('hidden');
        });
    }
    
    cancelAddMenu.addEventListener('click', function() {
        addMenuModal.classList.add('hidden');
        addMenuForm.reset();
    });
    
    cancelEditMenu.addEventListener('click', function() {
        editMenuModal.classList.add('hidden');
        editMenuForm.reset();
    });
    
    window.addEventListener('click', function(e) {
        if (e.target === addMenuModal) {
            addMenuModal.classList.add('hidden');
            addMenuForm.reset();
        }
        if (e.target === editMenuModal) {
            editMenuModal.classList.add('hidden');
            editMenuForm.reset();
        }
    });
    
    addMenuForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const name = document.getElementById('addMenuName').value.trim();
        const price = parseInt(document.getElementById('addMenuPrice').value);
        const imageUrl = document.getElementById('addMenuImage').value.trim();
        
        const submitBtn = addMenuForm.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding...';
        
        try {
            const response = await fetch('api_folder/menu_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'add',
                    name: name,
                    price: price,
                    image_url: imageUrl,
                    added_by: userId
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Menu item added successfully',
                    timer: 1500,
                    showConfirmButton: false
                });
                
                addMenuModal.classList.add('hidden');
                addMenuForm.reset();
                loadMenus();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to add menu item'
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
    
    editMenuForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const productId = parseInt(document.getElementById('editMenuId').value);
        const name = document.getElementById('editMenuName').value.trim();
        const price = parseInt(document.getElementById('editMenuPrice').value);
        const imageUrl = document.getElementById('editMenuImage').value.trim();
        
        const submitBtn = editMenuForm.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        try {
            const response = await fetch('api_folder/menu_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'update',
                    product_id: productId,
                    name: name,
                    price: price,
                    image_url: imageUrl
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Menu item updated successfully',
                    timer: 1500,
                    showConfirmButton: false
                });
                
                editMenuModal.classList.add('hidden');
                editMenuForm.reset();
                loadMenus();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update menu item'
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
    
    async function loadMenus() {
        loadingSpinner.classList.remove('hidden');
        menuTableContainer.classList.add('hidden');
        emptyState.classList.add('hidden');
        
        try {
            const response = await fetch('api_folder/menu_api.php');
            const data = await response.json();
            
            if (data.success) {
                if (data.data && data.data.length > 0) {
                    displayMenus(data.data);
                    menuTableContainer.classList.remove('hidden');
                } else {
                    emptyState.classList.remove('hidden');
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to load menu items'
                });
                emptyState.classList.remove('hidden');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while loading menu items'
            });
            emptyState.classList.remove('hidden');
        } finally {
            loadingSpinner.classList.add('hidden');
        }
    }
    
    function displayMenus(menus) {
        menuTableBody.innerHTML = '';
        
        menus.forEach(menu => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            
            const imageUrl = menu.sample_image_url || 'assets/pictures/default.png';
            const dateAdded = new Date(menu.date_added).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            
            const displayStatus = menu.display_status || 'hidden';
            const isVisible = displayStatus === 'visible';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="${imageUrl}" alt="${menu.name}" class="h-16 w-16 object-cover rounded-lg" 
                         onerror="this.src='assets/pictures/default.png'">
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${escapeHtml(menu.name)}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">₱${menu.product_price}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="status-badge ${displayStatus}">${displayStatus === 'visible' ? 'Visible' : 'Hidden'}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${escapeHtml(menu.added_by_username || 'Unknown')}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${dateAdded}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button class="editMenuBtn text-blue-600 hover:text-blue-900 mr-4" data-id="${menu.product_id}" 
                            data-name="${escapeHtml(menu.name)}" data-price="${menu.product_price}" 
                            data-image="${escapeHtml(menu.sample_image_url || '')}">
                        Edit
                    </button>
                    ${userRole === 'superAdmin' ? `
                    <button class="deleteMenuBtn text-red-600 hover:text-red-900 mr-4" data-id="${menu.product_id}" 
                            data-name="${escapeHtml(menu.name)}">
                        Delete
                    </button>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" class="displayToggle w-4 h-4" data-id="${menu.product_id}" ${isVisible ? 'checked' : ''}>
                        <span>Show</span>
                    </label>
                    ` : ''}
                </td>
            `;
            
            menuTableBody.appendChild(row);
        });
        
        document.querySelectorAll('.editMenuBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = this.getAttribute('data-price');
                const image = this.getAttribute('data-image');
                
                document.getElementById('editMenuId').value = id;
                document.getElementById('editMenuName').value = name;
                document.getElementById('editMenuPrice').value = price;
                document.getElementById('editMenuImage').value = image;
                
                editMenuModal.classList.remove('hidden');
            });
        });
        
        document.querySelectorAll('.deleteMenuBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = parseInt(this.getAttribute('data-id'));
                const name = this.getAttribute('data-name');
                
                deleteMenu(id, name);
            });
        });
        
        document.querySelectorAll('.displayToggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const productId = parseInt(this.getAttribute('data-id'));
                const isChecked = this.checked;
                toggleDisplayStatus(productId, isChecked);
            });
        });
    }
    
    async function toggleDisplayStatus(productId, isChecked) {
        const displayStatus = isChecked ? 'visible' : 'hidden';
        
        try {
            const response = await fetch('api_folder/menu_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'toggle_display',
                    product_id: productId,
                    display_status: displayStatus
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: `Menu item is now ${displayStatus}`,
                    timer: 1500,
                    showConfirmButton: false
                });
                
                try { localStorage.setItem('menuVisibilityChanged', String(Date.now())); } catch (e) {}

                loadMenus();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update display status'
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
    
    async function deleteMenu(productId, productName) {
        const result = await Swal.fire({
            icon: 'warning',
            title: 'Delete Menu Item?',
            text: `Are you sure you want to delete "${productName}"? This action cannot be undone.`,
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        });
        
        if (result.isConfirmed) {
            try {
                const response = await fetch('api_folder/menu_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        product_id: productId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Menu item deleted successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    loadMenus();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to delete menu item'
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
});