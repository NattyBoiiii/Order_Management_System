<?php
require_once 'dbConfig.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $visibleOnly = isset($_GET['visible']) && $_GET['visible'] === '1';
        $sql = "
            SELECT 
                p.product_id,
                p.name,
                p.sample_image_url,
                p.product_price,
                p.added_by,
                p.display_status,
                p.date_added,
                u.username as added_by_username
            FROM Products p
            LEFT JOIN Users u ON p.added_by = u.user_id
        ";
        if ($visibleOnly) {
            $sql .= " WHERE p.display_status = 'visible' ";
        }
        $sql .= " ORDER BY p.date_added DESC";

        $stmt = $pdo->query($sql);
        $products = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'data' => $products]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['action'])) {
        echo json_encode(['success' => false, 'message' => 'Action is required']);
        exit();
    }
    
    $action = $input['action'];
    
    if ($action === 'add') {
        if (!isset($input['name']) || !isset($input['price']) || !isset($input['added_by'])) {
            echo json_encode(['success' => false, 'message' => 'Name, price, and added_by are required']);
            exit();
        }
        
        $name = trim($input['name']);
        $price = intval($input['price']);
        $imageUrl = isset($input['image_url']) ? trim($input['image_url']) : '';
        $addedBy = intval($input['added_by']);
        
        if (empty($name) || $price <= 0) {
            echo json_encode(['success' => false, 'message' => 'Name cannot be empty and price must be greater than 0']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO Products (name, sample_image_url, product_price, added_by, display_status) VALUES (?, ?, ?, ?, 'hidden')");
            $stmt->execute([$name, $imageUrl, $price, $addedBy]);
            
            echo json_encode(['success' => true, 'message' => 'Product added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } elseif ($action === 'update') {
        if (!isset($input['product_id']) || !isset($input['name']) || !isset($input['price'])) {
            echo json_encode(['success' => false, 'message' => 'Product ID, name, and price are required']);
            exit();
        }
        
        $productId = intval($input['product_id']);
        $name = trim($input['name']);
        $price = intval($input['price']);
        $imageUrl = isset($input['image_url']) ? trim($input['image_url']) : '';
        
        if (empty($name) || $price <= 0) {
            echo json_encode(['success' => false, 'message' => 'Name cannot be empty and price must be greater than 0']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE Products SET name = ?, sample_image_url = ?, product_price = ? WHERE product_id = ?");
            $stmt->execute([$name, $imageUrl, $price, $productId]);
            
            echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } elseif ($action === 'toggle_display') {
        if (!isset($input['product_id']) || !isset($input['display_status'])) {
            echo json_encode(['success' => false, 'message' => 'Product ID and display status are required']);
            exit();
        }
        
        $productId = intval($input['product_id']);
        $displayStatus = $input['display_status'] === 'visible' ? 'visible' : 'hidden';
        
        try {
            $stmt = $pdo->prepare("UPDATE Products SET display_status = ? WHERE product_id = ?");
            $stmt->execute([$displayStatus, $productId]);
            
            echo json_encode(['success' => true, 'message' => 'Product display status updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } elseif ($action === 'delete') {
        if (!isset($input['product_id'])) {
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            exit();
        }
        
        $productId = intval($input['product_id']);
        
        try {
            $stmt = $pdo->prepare("DELETE FROM Products WHERE product_id = ?");
            $stmt->execute([$productId]);
            
            echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>