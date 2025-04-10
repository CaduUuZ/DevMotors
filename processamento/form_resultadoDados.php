<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idExame = $_POST['idExame'];
    $resultado = $_POST['resultado'];

    $sqlUpdate = "UPDATE exames SET resultado = ? WHERE idExame = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $resultado, $idExame);

    if ($stmtUpdate->execute()) {
        header("Location: ../telas/listaExames.php?status=success");
        exit;
    } else {
        echo "Erro ao salvar resultado: " . $conn->error;
    }
}

// Parte de exibição
if (!isset($_GET['idExame'])) {
    echo "ID do exame não informado.";
    exit;
}

$idExame = $_GET['idExame'];

$sql = "SELECT e.idExame, e.exameTexto, e.idPaciente, e.dataExame,
               p.nomeCompleto, p.idade
        FROM exames e
        JOIN pacientes p ON e.idPaciente = p.idPaciente
        WHERE e.idExame = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idExame);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Exame não encontrado.";
    exit;
}

$exame = $result->fetch_assoc();
?>
