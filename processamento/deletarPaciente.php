<?php
require_once('../config/db.php');

if (isset($_GET['id'])) {
    $idPaciente = $conn->real_escape_string($_GET['id']);

    // Excluir os exames relacionados ao paciente
    $sqlExames = "DELETE FROM exames WHERE idPaciente = '$idPaciente'";
    if (!$conn->query($sqlExames)) {
        // Redirecionar com erro ao excluir exames
        header("Location: ../telas/pesquisaPaciente.php?success=0&error=" . urlencode("Erro ao excluir exames: " . $conn->error));
        exit;
    }

    // Excluir o paciente
    $sqlPaciente = "DELETE FROM pacientes WHERE idPaciente = '$idPaciente'";
    if ($conn->query($sqlPaciente)) {
        // Redirecionar para a página de pesquisa com um parâmetro de sucesso
        header("Location: ../telas/pesquisaPaciente.php?success=1");
        exit;
    } else {
        // Redirecionar com erro ao excluir paciente
        header("Location: ../telas/pesquisaPaciente.php?success=0&error=" . urlencode("Erro ao excluir paciente: " . $conn->error));
        exit;
    }
} else {
    // Redirecionar com erro de ID ausente
    header("Location: ../telas/pesquisaPaciente.php?success=0&error=" . urlencode("ID do paciente não informado."));
    exit;
}
?>