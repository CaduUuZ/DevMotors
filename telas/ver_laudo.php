<?php
// Inclui o arquivo de configuração do banco de dados
require_once('../config/db.php');

// Verifica se o ID do exame foi informado
if (!isset($_GET['idExame'])) {
    // Exibe uma mensagem de erro e encerra o script caso o ID não seja informado
    echo "ID do exame não informado.";
    exit;
}

// Obtém o ID do exame da URL
$idExame = $_GET['idExame'];

// Consulta SQL para buscar os dados do exame e do paciente
$sql = "SELECT e.idExame, e.exameTexto, e.resultado, e.dataExame,
               p.nomeCompleto, p.idade, p.idPaciente
        FROM exames e
        JOIN pacientes p ON e.idPaciente = p.idPaciente
        WHERE e.idExame = ?";

// Prepara e executa a consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idExame);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o exame foi encontrado
if ($result->num_rows === 0) {
    // Exibe uma mensagem de erro e encerra o script caso o exame não seja encontrado
    echo "Exame não encontrado.";
    exit;
}

// Obtém os dados do exame
$exame = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <!-- Configurações básicas da página -->
  <meta charset="UTF-8">
  <title>Laudo do Exame</title>
  <!-- Importa os arquivos CSS para estilização -->
  <link rel="stylesheet" href="css/solicitarExame.css">
  <link rel="stylesheet" href="css/ver_laudo.css">
</head>
<body>
  <div class="laudo-box">
    <!-- Cabeçalho do laudo -->
    <div class="laudo-header">
      <h2>Laudo Laboratorial</h2>
      <p>Emitido em: <?= date('d/m/Y H:i', strtotime($exame['dataExame'])) ?></p>
    </div>

    <!-- Seção com informações do paciente -->
    <div class="laudo-section">
      <strong>Paciente:</strong> <?= $exame['nomeCompleto'] ?> <br>
      <strong>ID Paciente:</strong> <?= $exame['idPaciente'] ?> <br>
      <strong>Idade:</strong> <?= $exame['idade'] ?> anos
    </div>

    <!-- Seção com informações do exame -->
    <div class="laudo-section">
      <strong>Exame:</strong> <?= $exame['exameTexto'] ?>
    </div>

    <!-- Seção com o resultado do exame -->
    <div class="laudo-section">
      <strong>Resultado:</strong>
      <div class="resultado-box"><?= nl2br($exame['resultado']) ?></div>
    </div>

    <!-- Botão para voltar à lista de exames -->
    <div class="buttons">
      <a href="listaExames.php" class="btn-secondary">Voltar</a>
    </div>
  </div>
</body>
</html>
