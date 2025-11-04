<?php
require_once 'dbConfig.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $dateStart = isset($_GET['date_start']) ? $_GET['date_start'] : null;
        $dateEnd = isset($_GET['date_end']) ? $_GET['date_end'] : null;
        
        $sql = "
            SELECT 
                r.report_id as transaction_id,
                r.product_id as cashier_id,
                r.report_details,
                r.date_added,
                u.username as cashier_username,
                u.first_name,
                u.last_name
            FROM Reports r
            LEFT JOIN Users u ON r.product_id = u.user_id
        ";
        
        $conditions = [];
        $params = [];
        
        if ($dateStart) {
            $conditions[] = "DATE(r.date_added) >= ?";
            $params[] = $dateStart;
        }
        
        if ($dateEnd) {
            $conditions[] = "DATE(r.date_added) <= ?";
            $params[] = $dateEnd;
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY r.date_added DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll();
        
        $transactions = [];
        $totalSum = 0;
        
        foreach ($results as $row) {
            $details = json_decode($row['report_details'], true);
            if ($details && isset($details['items']) && isset($details['total_amount'])) {
                $transaction = [
                    'transaction_id' => $row['transaction_id'],
                    'items' => json_encode($details['items']),
                    'total_amount' => $details['total_amount'],
                    'cashier_id' => $row['cashier_id'],
                    'date_added' => $row['date_added'],
                    'cashier_username' => $row['cashier_username'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name']
                ];
                $transactions[] = $transaction;
                $totalSum += floatval($details['total_amount']);
            }
        }
        
        echo json_encode([
            'success' => true, 
            'data' => $transactions,
            'total_sum' => $totalSum
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['items']) || !isset($input['total_amount'])) {
        echo json_encode(['success' => false, 'message' => 'Items and total_amount are required']);
        exit();
    }
    
    $items = $input['items'];
    $totalAmount = floatval($input['total_amount']);
    $cashierId = isset($input['cashier_id']) && $input['cashier_id'] ? intval($input['cashier_id']) : 0;
    
    $reportDetails = json_encode([
        'items' => $items,
        'total_amount' => $totalAmount
    ]);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO Reports (product_id, report_details) VALUES (?, ?)");
        $stmt->execute([$cashierId, $reportDetails]);
        
        echo json_encode(['success' => true, 'message' => 'Transaction saved successfully', 'id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>