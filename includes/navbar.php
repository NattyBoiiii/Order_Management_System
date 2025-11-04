<?php
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
<nav class="bg-red-600 text-white shadow-lg mb-5">
  <div class="container mx-auto px-4 py-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
      <div class="mb-3 md:mb-0">
        <a class="text-xl font-bold hover:text-red-200 transition-colors" href="indexLogin.php">
          Welcome to Ichiban Bowl Ordering System
        </a>
      </div>
      <div class="flex flex-wrap items-center gap-3">
        <?php if ($isLoggedIn): ?>
          <span class="px-4 py-2 text-red-200">Welcome! <?php echo htmlspecialchars($username); ?></span>
        <?php endif; ?>
        <?php if ($isLoggedIn && ($userRole === 'admin' || $userRole === 'superAdmin')): ?>
          <a class="px-4 py-2 rounded hover:bg-red-700 transition-colors" href="menu_management.php">Menu Management</a>
          <a class="px-4 py-2 rounded hover:bg-red-700 transition-colors" href="user_management.php">User Management</a>
          <a class="px-4 py-2 rounded hover:bg-red-700 transition-colors" href="transaction_reports.php">Transaction Reports</a>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
          <a class="px-4 py-2 rounded hover:bg-red-700 transition-colors" href="logout.php">Logout</a>
        <?php else: ?>
          <button id="loginBtn" class="px-4 py-2 rounded hover:bg-red-700 transition-colors bg-red-700 border-none cursor-pointer">Login</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<?php include __DIR__ . '/../modal_folder/login.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/scripts_folder/navbar.js"></script>
