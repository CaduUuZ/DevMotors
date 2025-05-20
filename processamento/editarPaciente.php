<?php
require_once('../config/db.php'); // Inclui a configuração do banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o método da requisição é POST
    // Verifica se o idPaciente foi enviado
    if (isset($_POST['idPaciente']) && !empty($_POST['idPaciente'])) {
        // Sanitiza e captura os dados
        $idPaciente = $_POST['idPaciente']; // ID do paciente a ser editado
        $nomeCompleto = trim($_POST['nomeCompleto']); // Nome completo do paciente
        $idade = isset($_POST['idade']) && is_numeric($_POST['idade']) ? (int)$_POST['idade'] : null; // Idade do paciente
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) ? trim($_POST['email']) : null; // E-mail validado
        $telefone = trim($_POST['telefone']); // Telefone do paciente
        $patologia = !empty(trim($_POST['patologia'])) ? trim($_POST['patologia']) : null; // Patologia do paciente
        $medicamento = !empty(trim($_POST['medicamento'])) ? trim($_POST['medicamento']) : null; // Medicamento do paciente

        // Verifica se o nome foi enviado
        if (empty($nomeCompleto)) {
            // Redireciona com erro se o nome estiver vazio
            header("Location: ../telas/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Nome Completo é obrigatório"));
            exit;
        }

        // Montar a query dinamicamente
        $query = "UPDATE pacientes SET nomeCompleto = ?"; // Inicia a query de atualização
        $types = "s"; // Tipo do parâmetro (string)
        $params = [$nomeCompleto]; // Parâmetros para bind

        // Adiciona os campos dinamicamente à query
        if ($idade !== null) {
            $query .= ", idade = ?";
            $types .= "i"; // Tipo inteiro
            $params[] = $idade;
        } else {
            $query .= ", idade = NULL";
        }

        if ($email !== null) {
            $query .= ", email = ?";
            $types .= "s"; // Tipo string
            $params[] = $email;
        } else {
            $query .= ", email = NULL";
        }

        if ($telefone !== '') {
            $query .= ", telefone = ?";
            $types .= "s"; // Tipo string
            $params[] = $telefone;
        } else {
            $query .= ", telefone = NULL";
        }

        if ($patologia !== null) {
            $query .= ", patologia = ?";
            $types .= "s"; // Tipo string
            $params[] = $patologia;
        } else {
            $query .= ", patologia = NULL";
        }

        if ($medicamento !== null) {
            $query .= ", medicamento = ?";
            $types .= "s"; // Tipo string
            $params[] = $medicamento;
        } else {
            $query .= ", medicamento = NULL";
        }

        $query .= " WHERE idPaciente = ?"; // Condição para o ID do paciente
        $types .= "i"; // Tipo inteiro para idPaciente
        $params[] = $idPaciente;

        // Preparar e executar
        $stmt = $conn->prepare($query); // Prepara a query
        if (!$stmt) {
            // Redireciona com erro se a preparação falhar
            header("Location: ../telas/pesquisaPaciente.php?edit_success=0&error=" . urlencode("Erro no banco de dados: " . $conn->error));
            exit;
        }

        $stmt->bind_param($types, ...$params); // Associa os parâmetros à query

        if ($stmt->execute()) {
            // Redireciona com sucesso
            header("Location: ../telas/pesquisaPaciente.php?edit_success=1");
            exit;
        } else {
            // Redireciona com erro ao executar
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
