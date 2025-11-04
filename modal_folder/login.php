<div id="loginModal" class="modal-overlay hidden">
  <div class="login-form-container" role="dialog" aria-modal="true">
    <h1 class="login-title">Ichiban Bowl POS</h1>
    <form id="loginForm">
      <div class="mb-4">
        <label for="modalUsername" class="login-label">Username</label>
        <input type="text" class="login-input" id="modalUsername" name="username" required>
      </div>
      <div class="mb-4">
        <label for="modalPassword" class="login-label">Password</label>
        <input type="password" class="login-input" id="modalPassword" name="password" required>
      </div>
      <button type="submit" class="login-button">Login</button>
      <button type="button" class="login-button mt-2 bg-gray-600 hover:bg-gray-700" id="cancelLoginBtn">Cancel</button>
    </form>
  </div>
  <button type="button" class="sr-only" aria-label="Close login modal"></button>
</div>