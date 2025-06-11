<?php
require_once '../config/db.php';
require_once '../dao/ExameDAO.php';

if (isset($_GET['idExame'])) {
    $idExame = $_GET['idExame'];

    try {
        $exameDAO = new ExameDAO($conn);
        $exameDAO->excluir($idExame);

        header("Location: ../views/listaExames.php?success=1");
        exit;
    } catch (Exception $e) {
        $msg = urlencode("Erro ao excluir exame: " . $e->getMessage());
        header("Location: ../views/listaExames.php?success=0&error={$msg}");
        exit;
    }
} else {
    $msg = urlencode("ID do exame não informado.");
    header("Location: ../views/listaExames.php?success=0&error={$msg}");
    exit;
}
