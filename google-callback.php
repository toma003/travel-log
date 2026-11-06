<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['credential'])) {
    echo json_encode(['success' => false, 'message' => 'Missing Google token.']);
    exit();
}

$id_token = $input['credential'];

$verify_url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($id_token);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

if ($response === FALSE) {
    echo json_encode(['success' => false, 'message' => 'Token verification failed.']);
    exit();
}

$data = json_decode($response, true);

if (isset($data['email']) && !empty($data['email'])) {
    $email = $data['email'];
    $name = $data['name'] ?? explode('@', $email)[0];

    // Check if user already exists in MySQL using PDO
    $stmt = $pdo->prepare("SELECT id, full_name FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // User exists -> Create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'] ?? $name;
    } else {
        // New user -> Insert into database using PDO
        $random_password = password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT);
        
        $insert_stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        
        if ($insert_stmt->execute([$name, $email, $random_password])) {
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
        } else {
            echo json_encode(['success' => false, 'message' => 'Database registration failed.']);
            exit();
        }
    }

    echo json_encode(['success' => true]);
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Google account data.']);
    exit();
}
?>