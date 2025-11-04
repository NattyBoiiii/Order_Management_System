<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: indexLogin.php");
    exit();
}

$userRole = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Ichiban Bowl Ordering System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-gray-100 p-5">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto max-w-7xl">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">User Management</h1>
            <div class="overflow-x-auto">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Registered Users</h2>
                        <?php if($userRole === 'superAdmin'): ?>
                        <button id="addUserBtn" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            + Add User Admin/SuperAdmin
                        </button>
                        <?php endif; ?>
                    </div>
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-red-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">User ID</th>
                            <th class="px-4 py-3 text-left font-semibold">Username</th>
                            <th class="px-4 py-3 text-left font-semibold">Full Name</th>
                            <th class="px-4 py-3 text-left font-semibold">Email</th>
                            <th class="px-4 py-3 text-left font-semibold">Role</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Date Added</th>
                            <th class="px-4 py-3 text-left font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" data-role="<?php echo htmlspecialchars($userRole); ?>">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'modal_folder/add_user.php'; ?>
    <script src="assets/scripts_folder/user_management.js"></script>
</body>
</html>