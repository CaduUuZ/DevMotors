<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o idPaciente foi enviado
    if (isset($_POST['idPaciente']) && !empty($_POST['idPaciente'])) {
        // Sanitiza e captura os dados
        $idPaciente = $_POST['idPaciente'];
        $nomeCompleto = trim($_POST['nomeCompleto']);
        $idade = isset($_POST['idade']) && is_numeric($_POST['idade']) ? (int)$_POST['idade'] : null;
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) ? trim($_POST['email']) : null;
        $telefone = trim($_POST['telefone']);
        $patologia = !empty(trim($_POST['patologia'])) ? trim($_POST['patologia']) : null;
        $medicamento = !empty(trim($_POST['medicamento'])) ? trim($_POST['medicamento']) : null;

        // Verifica se o nome foi enviado
        if (empty($nomeCompleto)) {
            header("Location: ../telas/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Nome Completo é obrigatório"));
            exit;
        }

        // Montar a query dinamicamente
        $query = "UPDATE pacientes SET nomeCompleto = ?";
        $types = "s";
        $params = [$nomeCompleto];

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

        if ($telefone !== '') {
            $query .= ", telefone = ?";
            $types .= "s";
            $params[] = $telefone;
        } else {
            $query .= ", telefone = NULL";
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
        $types .= "i"; // supondo que idPaciente seja int, se for string mude para "s"
        $params[] = $idPaciente;

        // Preparar e executar
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            header("Location: ../telas/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Erro no banco de dados: " . $conn->error));
            exit;
        }

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            header("Location: ../telas/pesquisaPaciente.php?edit_success=1");
            exit;
        } else {
            header("Location: ../telas/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Erro ao atualizar paciente"));
            exit;
        }
    } else {
        // idPaciente não enviado ou vazio
        header("Location: ../telas/pesquisaPaciente.php?edit_success=0&error=" . urlencode("ID do paciente não foi encontrado"));
        exit;
    }
} else {
    // Método inválido, não POST
    header("Location: ../telas/pesquisaPaciente.php");
    exit;
}
?>
