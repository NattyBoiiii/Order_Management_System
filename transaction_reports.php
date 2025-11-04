<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: indexLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Reports - Ichiban Bowl Ordering System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-gray-100 p-5">
    <?php include 'includes/navbar.php'; ?> 
    <div class="container mx-auto max-w-7xl">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Transaction Reports</h1>
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Filter Transactions</h2>
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="dateStart" class="block text-sm font-medium text-gray-700 mb-2">Date Start</label>
                        <input type="date" id="dateStart" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-red-600">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="dateEnd" class="block text-sm font-medium text-gray-700 mb-2">Date End</label>
                        <input type="date" id="dateEnd" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-red-600">
                    </div>
                    <div class="flex gap-2">
                        <button id="filterBtn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Filter
                        </button>
                        <button id="clearBtn" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                            Clear
                        </button>
                        <button id="printPdfBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print PDF
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-red-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Transaction ID</th>
                            <th class="px-4 py-3 text-left font-semibold">Date & Time</th>
                            <th class="px-4 py-3 text-left font-semibold">Items</th>
                            <th class="px-4 py-3 text-left font-semibold">Cashier/Admin</th>
                            <th class="px-4 py-3 text-right font-semibold">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsTableBody">
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                Loading transactions...
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-gray-100 font-bold">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right text-gray-700">Total Sum:</td>
                            <td id="totalSum" class="px-4 py-3 text-right text-red-600 text-lg">₱0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script src="assets/scripts_folder/transaction_reports.js"></script>
</body>
</html>