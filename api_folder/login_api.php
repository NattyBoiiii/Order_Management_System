<?php
require_once 'dbConfig.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['username']) || !isset($input['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username and password are required']);
    exit();
}

$username = trim($input['username']);
$password = $input['password'];

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username and password cannot be empty']);
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT user_id, username, first_name, last_name, email, admin_password, admin_role, admin_status FROM Users WHERE username = ? AND admin_status = 'active'");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['admin_password'])) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['admin_role'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        
        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'username' => $user['username'],
                'role' => $user['admin_role']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>