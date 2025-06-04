<?php
session_start();

require_once '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email e senha são obrigatórios']);
        exit;
    }

    if ($action === 'login') {
        try {
            $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                echo json_encode(['success' => true, 'redirect' => 'home.php']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Email ou senha incorretos']);
            }
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erro no servidor']);
        }
    } 
    
    elseif ($action === 'register') {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Este email já está cadastrado']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $password]);

            echo json_encode(['success' => true, 'message' => 'Usuário registrado com sucesso']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao registrar usuário']);
        }
    }
}
?>
