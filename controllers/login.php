<?php
require_once '../config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    if (isset($_POST["login"])) {
        // Login
        $sql = "SELECT senha FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($senha, $row["senha"])) {
                $_SESSION["usuario_email"] = $email;
                header("Location: ../views/home.php");
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='../views/index.html';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Email não encontrado!'); window.location.href='../views/index.html';</script>";
            exit();
        }
    } elseif (isset($_POST["register"])) {
        // Registro
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email já está registrado!'); window.location.href='../views/index.html';</script>";
            exit();
        } else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (email, senha) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $senhaHash);

            if ($stmt->execute()) {
                $_SESSION['usuario_email'] = $email;
                header("Location: ../views/home.php");
                exit();
            } else {
                echo "<script>alert('Erro ao registrar!'); window.location.href='../views/index.html';</script>";
                exit();
            }
        }
    } elseif (isset($_POST["update_password"])) {
        // Atualizar senha no banco (somente para depuração)
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET senha = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $senhaHash, $email);
        $stmt->execute();
    }
}

$conn->close();
?>
