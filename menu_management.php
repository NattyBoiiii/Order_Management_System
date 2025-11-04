<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: indexLogin.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - Ichiban Bowl Ordering System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-5">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto max-w-7xl">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Menu Management</h2>
                <button id="addMenuBtn" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    + Add Menu Item
                </button>
            </div>
            <div id="loadingSpinner" class="text-center py-10">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-red-600"></div>
                <p class="mt-2 text-gray-600">Loading menu items...</p>
            </div>
            <div id="menuTableContainer" class="hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-red-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Added By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date Added</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="menuTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="emptyState" class="hidden text-center py-10">
                <p class="text-gray-600 text-lg">No menu items found. 
                Click "Add Menu Item" to get started.
                </p>
            </div>
        </div>
    </div>
    <div id="sessionData" data-user-id="<?php echo htmlspecialchars($userId, ENT_QUOTES); ?>" 
         data-role="<?php echo htmlspecialchars($userRole, ENT_QUOTES); ?>" style="display:none"></div>
    <?php include 'modal_folder/add_menu.php'; ?>
    <?php include 'modal_folder/edit_menu.php'; ?>
    <script src="assets/scripts_folder/menu.js"></script>
</body>
</html>