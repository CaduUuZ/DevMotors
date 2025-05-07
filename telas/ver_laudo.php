<?php
require_once('../config/db.php');

if (!isset($_GET['idExame'])) {
    echo "ID do exame não informado.";
    exit;
}

$idExame = $_GET['idExame'];

$sql = "SELECT e.idExame, e.exameTexto, e.resultado, e.dataExame,
               p.nomeCompleto, p.idade, p.idPaciente
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

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Laudo do Exame</title>
  <link rel="stylesheet" href="css/solicitarExame.css">
  <link rel="stylesheet" href="css/ver_laudo.css">
</head>
<body>
  <div class="laudo-box">
    <div class="laudo-header">
      <h2>Laudo Laboratorial</h2>
      <p>Emitido em: <?= date('d/m/Y H:i', strtotime($exame['dataExame'])) ?></p>
    </div>

    <div class="laudo-section">
      <strong>Paciente:</strong> <?= $exame['nomeCompleto'] ?> <br>
      <strong>ID Paciente:</strong> <?= $exame['idPaciente'] ?> <br>
      <strong>Idade:</strong> <?= $exame['idade'] ?> anos
    </div>

    <div class="laudo-section">
      <strong>Exame:</strong> <?= $exame['exameTexto'] ?>
    </div>

    <div class="laudo-section">
      <strong>Resultado:</strong>
      <div class="resultado-box"><?= nl2br($exame['resultado']) ?></div>
    </div>

    <div class="buttons">
      <a href="listaExames.php" class="btn-secondary">Voltar</a>
    </div>
  </div>
</body>
</html>
