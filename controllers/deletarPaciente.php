<?php
require_once '../config/db.php';
require_once '../dao/PacienteDAO.php';
require_once '../dao/ExameDAO.php';

if (isset($_GET['id'])) {
    $idPaciente = $_GET['id'];

    try {
        $exameDAO = new ExameDAO($conn);
        $pacienteDAO = new PacienteDAO($conn);

        // Excluir exames relacionados
        $exames = $exameDAO->buscarPorPaciente($idPaciente);
        foreach ($exames as $exame) {
            $exameDAO->excluir($exame->getIdExame());
        }

        // Excluir paciente
        $pacienteDAO->excluir($idPaciente);

        header("Location: ../views/pesquisaPaciente.php?success=1");
        exit;
    } catch (Exception $e) {
        $msg = urlencode("Erro ao excluir paciente ou exames: " . $e->getMessage());
        header("Location: ../views/pesquisaPaciente.php?success=0&error={$msg}");
        exit;
    }
} else {
    $msg = urlencode("ID do paciente não informado.");
    header("Location: ../views/pesquisaPaciente.php?success=0&error={$msg}");
    exit;
}
