<?php
require_once('../config/db.php');

if (isset($_GET['idExame'])) {
    $idExame = $conn->real_escape_string($_GET['idExame']);

    $sql = "DELETE FROM exames WHERE idExame = '$idExame'";
    if ($conn->query($sql)) {
        header("Location: ../telas/listaExames.php?success=1");
        exit;
    } else {
        header("Location: ../telas/listaExames.php?success=0&error=" . urlencode("Erro ao excluir exame: " . $conn->error));
        exit;
    }
} else {
    header("Location: ../telas/listaExames.php?success=0&error=" . urlencode("ID do exame não informado."));
    exit;
}
?>
