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
$sql = "SELECT e.idExame, e.exameTexto, e.idPaciente, e.dataExame,
               p.nomeCompleto, p.idade
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
  <title>Inserir Resultado</title>
  <!-- Importa o arquivo CSS para estilização -->
  <link rel="stylesheet" href="css/solicitarExame.css">
</head>
<body>
  <div class="container">
    <!-- Cabeçalho do formulário -->
    <div class="form-header">
      <h1>Resultado do Exame</h1>
      <p>Preencha abaixo o resultado para este exame</p>
    </div>

    <!-- Formulário para inserir o resultado do exame -->
    <form action="../processamento/form_resultadoDados.php" method="POST">
      <!-- Campo oculto para armazenar o ID do exame -->
      <input type="hidden" name="idExame" value="<?= $exame['idExame'] ?>">

      <!-- Campo para exibir o nome do paciente -->
      <div class="form-group">
        <label>Paciente:</label>
        <input type="text" value="<?= $exame['nomeCompleto'] ?>" disabled>
      </div>

      <!-- Campo para exibir o tipo de exame -->
      <div class="form-group">
        <label>Tipo de Exame:</label>
        <input type="text" value="<?= $exame['exameTexto'] ?>" disabled>
      </div>

      <!-- Campo para inserir o resultado do exame -->
      <div class="form-group">
        <label for="resultado">Resultado:</label>
        <textarea name="resultado" id="resultado" rows="6" placeholder="Descreva o resultado do exame..." required></textarea>
      </div>

      <!-- Botões para salvar ou cancelar -->
      <div class="buttons">
        <button type="submit" class="btn-primary">Salvar Resultado</button>
        <a href="listaExames.php" class="btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</body>
</html>
