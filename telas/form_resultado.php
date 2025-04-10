<?php
require_once('../config/db.php');

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

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Inserir Resultado</title>
  <link rel="stylesheet" href="css/solicitarExame.css">
</head>
<body>
  <div class="container">
    <div class="form-header">
      <h1>Resultado do Exame</h1>
      <p>Preencha abaixo o resultado para este exame</p>
    </div>

    <form action="../processamento/form_resultadoDados.php" method="POST">
      <input type="hidden" name="idExame" value="<?= $exame['idExame'] ?>">

      <div class="form-group">
        <label>Paciente:</label>
        <input type="text" value="<?= $exame['nomeCompleto'] ?>" disabled>
      </div>

      <div class="form-group">
        <label>Tipo de Exame:</label>
        <input type="text" value="<?= $exame['exameTexto'] ?>" disabled>
      </div>

      <div class="form-group">
        <label for="resultado">Resultado:</label>
        <textarea name="resultado" id="resultado" rows="6" placeholder="Descreva o resultado do exame..." required></textarea>
      </div>

      <div class="buttons">
        <button type="submit" class="btn-primary">Salvar Resultado</button>
        <a href="listaExames.php" class="btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</body>
</html>
