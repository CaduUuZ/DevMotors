<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idPaciente']) && !empty($_POST['idPaciente'])) {
        $idPaciente = $_POST['idPaciente'];
        $nome = trim($_POST['nome']);
        $idade = isset($_POST['idade']) && is_numeric($_POST['idade']) ? (int)$_POST['idade'] : null;
        $email = !empty(trim($_POST['email'])) ? trim($_POST['email']) : null;
        $telefone = !empty(trim($_POST['telefone'])) ? trim($_POST['telefone']) : null;
        $dataNascimento = !empty(trim($_POST['dataNascimento'])) ? trim($_POST['dataNascimento']) : null;
        $patologia = !empty(trim($_POST['patologia'])) ? trim($_POST['patologia']) : null;
        $medicamento = !empty(trim($_POST['medicamento'])) ? trim($_POST['medicamento']) : null;

        if (empty($nome)) {
            header("Location: ../views/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Nome é obrigatório"));
            exit;
        }

        $query = "UPDATE pacientes SET nome = ?";
        $types = "s";
        $params = [$nome];

        if ($idade !== null) {
            $query .= ", idade = ?";
            $types .= "i";
            $params[] = $idade;
        } else {
            $query .= ", idade = NULL";
        }

        if ($email !== null) {
            $query .= ", email = ?";
            $types .= "s";
            $params[] = $email;
        } else {
            $query .= ", email = NULL";
        }

        if ($telefone !== null) {
            $query .= ", telefone = ?";
            $types .= "s";
            $params[] = $telefone;
        } else {
            $query .= ", telefone = NULL";
        }

        if ($dataNascimento !== null) {
            $query .= ", dataNascimento = ?";
            $types .= "s";
            $params[] = $dataNascimento;
        } else {
            $query .= ", dataNascimento = NULL";
        }

        if ($patologia !== null) {
            $query .= ", patologia = ?";
            $types .= "s";
            $params[] = $patologia;
        } else {
            $query .= ", patologia = NULL";
        }

        if ($medicamento !== null) {
            $query .= ", medicamento = ?";
            $types .= "s";
            $params[] = $medicamento;
        } else {
            $query .= ", medicamento = NULL";
        }

        $query .= " WHERE idPaciente = ?";
        $types .= "i";
        $params[] = $idPaciente;

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            header("Location: ../views/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Erro no banco de dados: " . $conn->error));
            exit;
        }

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            header("Location: ../views/pesquisaPaciente.php?search=" . urlencode($nome) . "&edit_success=1");
            exit;
        } else {
            header("Location: ../views/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Erro ao atualizar paciente"));
            exit;
        }
    } else {
        header("Location: ../views/pesquisaPaciente.php?edit_success=0&error=" . urlencode("ID do paciente não foi encontrado"));
        exit;
    }
} else {
    header("Location: ../views/pesquisaPaciente.php");
    exit;
}
?>
