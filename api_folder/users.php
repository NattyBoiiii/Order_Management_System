<?php
require_once 'dbConfig.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $sql = "
            SELECT 
                user_id,
                username,
                first_name,
                last_name,
                email,
                admin_role,
                admin_status,
                date_added
            FROM Users
            WHERE admin_role IN ('admin', 'superAdmin')
            ORDER BY date_added DESC
        ";

        $stmt = $pdo->query($sql);
        $users = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'data' => $users]);
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
        if (!isset($input['username']) || !isset($input['first_name']) || !isset($input['last_name']) 
            || !isset($input['email']) || !isset($input['password']) || !isset($input['admin_role'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit();
        }
        
        $username = trim($input['username']);
        $firstName = trim($input['first_name']);
        $lastName = trim($input['last_name']);
        $email = trim($input['email']);
        $password = $input['password'];
        $adminRole = $input['admin_role'];
        
        if (empty($username) || empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'All fields must be filled']);
            exit();
        }
        
        if (strlen($password) < 8) {
            echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters']);
            exit();
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Invalid email format']);
            exit();
        }
        
        if (!in_array($adminRole, ['admin', 'superAdmin'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid role']);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("SELECT user_id FROM Users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Username already exists']);
                exit();
            }
            
            $stmt = $pdo->prepare("SELECT user_id FROM Users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Email already exists']);
                exit();
            }
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO Users (username, first_name, last_name, email, admin_password, admin_role, admin_status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
            $stmt->execute([$username, $firstName, $lastName, $email, $hashedPassword, $adminRole]);
            
            echo json_encode(['success' => true, 'message' => 'User added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['action']) || !isset($input['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Action and user_id are required']);
        exit();
    }
    
    $action = $input['action'];
    $userId = intval($input['user_id']);
    
    try {
        if ($action === 'suspend') {
            $stmt = $pdo->prepare("UPDATE Users SET admin_status = 'inactive' WHERE user_id = ? AND admin_role IN ('admin', 'superAdmin')");
            $stmt->execute([$userId]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'User suspended successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found or cannot be suspended']);
            }
        } elseif ($action === 'activate') {
            $stmt = $pdo->prepare("UPDATE Users SET admin_status = 'active' WHERE user_id = ? AND admin_role IN ('admin', 'superAdmin')");
            $stmt->execute([$userId]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'User activated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found or cannot be activated']);
            }
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM Users WHERE user_id = ? AND admin_role IN ('admin', 'superAdmin')");
            $stmt->execute([$userId]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found or cannot be deleted']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>