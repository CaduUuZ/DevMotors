<?php
// Inclui o arquivo de configuração do banco de dados
require_once('../config/db.php');
// Inclui o arquivo da barra lateral
include_once('sidebar.php');



// Verifica se há um ID de paciente para buscar
$buscaId = isset($_GET['buscaId']) ? trim($_GET['buscaId']) : null;

// Consulta SQL para buscar exames e informações dos pacientes
$sql = "SELECT e.idExame, e.exameTexto, e.dataExame, e.resultado, 
               p.idPaciente, p.nomeCompleto, p.idade 
        FROM exames e 
        JOIN pacientes p ON e.idPaciente = p.idPaciente";

// Adiciona uma condição de busca se o ID do paciente for informado
if (!empty($buscaId)) {
    $buscaId = $conn->real_escape_string($buscaId);
    $sql .= " WHERE p.idPaciente LIKE '%$buscaId%'";
}

// Ordena os resultados pela data do exame em ordem decrescente
$sql .= " ORDER BY e.dataExame DESC";

// Executa a consulta
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <!-- Configurações básicas da página -->
  <meta charset="UTF-8">
  <title>Lista de Exames</title>
  <!-- Importa o arquivo CSS para estilização -->
  <link rel="stylesheet" href="css/listaExames.css?v=6">
  <!-- Importa bibliotecas externas -->
  <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="container">
    <!-- Cabeçalho da página -->
    <div class="form-header">
      <h1>Exames Solicitados</h1>
      <p>Veja todos os exames solicitados pelos pacientes</p>
    </div>
    
    <!-- Formulário de busca -->
    <div class="search-container">
      <form method="GET" class="search-form">
        <label for="buscaId">Buscar por ID do Paciente:</label>
        <input type="text" name="buscaId" id="buscaId" placeholder="Ex: PAC123" value="<?= htmlspecialchars($buscaId) ?>">
        <button type="submit" class="btn-primary">Buscar</button>
        <?php if (!empty($buscaId)): ?>
          <!-- Botão para limpar a busca -->
          <a href="lista_exames.php" class="btn-primary">Limpar</a>
        <?php endif; ?>
      </form>
    </div>

    <!-- Exibe mensagens de sucesso ou erro -->
    <?php if (isset($_GET['success'])): ?>
      <div class="<?= $_GET['success'] == 1 ? 'success' : 'error' ?>">
        <?= $_GET['success'] == 1 ? 'Exame excluído com sucesso!' : htmlspecialchars($_GET['error']) ?>
      </div>
    <?php endif; ?>

    <!-- Tabela de exames -->
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>ID Exame</th>
            <th>ID Paciente</th>
              <th>Paciente</th>
              <th>Idade</th>
            <th>Exame</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <!-- Itera sobre os resultados e exibe cada linha -->
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['idExame'] ?></td>
                <td><?= $row['idPaciente'] ?></td>
                  <td><?= $row['nomeCompleto'] ?></td>
                  <td><?= $row['idade'] ?></td>
                <td><?= $row['exameTexto'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['dataExame'])) ?></td>
                <td class="actions-cell">
                  <div class="actions-container">
                    <?php if (!empty($row['resultado'])): ?>
                      <!-- Botões para visualizar ou editar o resultado -->
                      <a class="btn-primary small-btn" href="ver_laudo.php?idExame=<?= $row['idExame'] ?>">Visualizar</a>
                      <a class="btn-primary small-btn" href="editar_resultado.php?idExame=<?= $row['idExame'] ?>">Editar</a>
                    <?php else: ?>
                      <!-- Botão para inserir o resultado -->
                      <a class="btn-primary small-btn" href="form_resultado.php?idExame=<?= $row['idExame'] ?>">Inserir</a>
                    <?php endif; ?>
                    <!-- Botão para excluir o exame -->
                    <button type="button" class="btn-danger small-btn btn-excluir" data-id="<?= $row['idExame'] ?>">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <!-- Exibe uma mensagem caso nenhum exame seja encontrado -->
            <tr>
              <td colspan="<?= $cargoUsuario === 'admin' ? '7' : '5' ?>" class="no-results">Nenhum exame encontrado para o ID informado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Script para confirmação de exclusão com SweetAlert2 -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const botoesExcluir = document.querySelectorAll('.btn-excluir');

      botoesExcluir.forEach(botao => {
        botao.addEventListener('click', function () {
          const idExame = this.getAttribute('data-id');

          Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              // Redireciona para o script de exclusão
              window.location.href = `../processamento/excluir_exame.php?idExame=${idExame}`;
            }
          });
        });
      });
    });
  </script>
</body>
</html>
