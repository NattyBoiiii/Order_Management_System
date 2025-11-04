document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const cancelLoginBtn = document.getElementById('cancelLoginBtn');
    const loginForm = document.getElementById('loginForm');
    
    if (loginBtn) {
        loginBtn.addEventListener('click', function() {
            loginModal.classList.remove('hidden');
        });
    }
    
    if (cancelLoginBtn) {
        cancelLoginBtn.addEventListener('click', function() {
            loginModal.classList.add('hidden');
            loginForm.reset();
        });
    }
    
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('modalUsername').value.trim();
            const password = document.getElementById('modalPassword').value;
            
            if (!username || !password) {
                if (loginModal) loginModal.classList.add('hidden');
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please enter both username and password'
                });
                return;
            }
            
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Logging in...';
            
            try {
                const response = await fetch('api_folder/login_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    if (loginModal) loginModal.classList.add('hidden');
                    await Swal.fire({
                        icon: 'success',
                        title: 'Login Successful!',
                        text: 'Welcome back, ' + data.user.username + '!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    window.location.reload();
                } else {
                    if (loginModal) loginModal.classList.add('hidden');
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: data.message || 'Invalid username or password'
                    });
                    
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                }
            } catch (error) {
                if (loginModal) loginModal.classList.add('hidden');
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
});