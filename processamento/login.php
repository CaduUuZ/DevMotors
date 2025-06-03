<?php
require_once '../config/db.php';

// Obter dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta ao banco de dados
$sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login bem-sucedido
    header("Location: ../telas/home.php");
    exit();
} else {
    // Login incorreto
    echo "<script>alert('E-mail ou senha incorretos!'); window.location.href='../telas/index.html';</script>";
}

// Fechar conexão
$stmt->close();
$conn->close();
?>