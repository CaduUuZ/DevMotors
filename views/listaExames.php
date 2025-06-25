<?php
require_once('../config/db.php');
require_once('../dao/ExameDAO.php');
require_once('../models/Paciente.php');
require_once('../models/Exame.php');
include_once('../views/sidebar.php');

// Instancia o DAO
$exameDAO = new ExameDAO($conn);

// Verifica se há busca por ID
$buscaId = isset($_GET['buscaId']) ? trim($_GET['buscaId']) : null;

try {
    if (!empty($buscaId)) {
        $exames = $exameDAO->buscarPorPaciente($buscaId);
    } else {
        $exames = $exameDAO->buscarTodos();
    }
} catch (Exception $e) {
    die("Erro ao carregar exames: " . $e->getMessage());
}

// Garante que $exames seja sempre um array
if (!is_array($exames)) {
    $exames = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Exames</title>
  <link rel="stylesheet" href="css/listaExames.css?v=6">
  <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container">
  <div class="form-header">
    <h1>Exames Solicitados</h1>
    <p>Veja todos os exames solicitados pelos pacientes</p>
  </div>

  <div class="search-container">
    <form method="GET" class="search-form">
      <label for="buscaId">Buscar por ID do Paciente:</label>
      <input type="text" name="buscaId" id="buscaId" placeholder="Ex: 1234" value="<?= htmlspecialchars($buscaId) ?>">
      <button type="submit" class="btn-primary">Buscar</button>
    </form>
  </div>

  <?php if (isset($_GET['success'])): ?>
    <div class="<?= $_GET['success'] == 1 ? 'success' : 'error' ?>">
      <?= $_GET['success'] == 1 ? 'Exame excluído com sucesso!' : htmlspecialchars($_GET['error']) ?>
    </div>
  <?php endif; ?>

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
        <?php if (count($exames) > 0): ?>
          <?php foreach ($exames as $exame): ?>
            <tr>
              <td><?= $exame->getIdExame() ?></td>
              <td><?= $exame->getPaciente()->getIdPaciente() ?></td>
              <td><?= $exame->getPaciente()->getNome() ?></td>
              <td><?= $exame->getPaciente()->getIdade() ?></td>
              <td><?= $exame->getExameTexto() ?></td>
              <td>
                <?= !empty($exame->getDataExame()) ? (new DateTime($exame->getDataExame()))->format('d/m/Y H:i') : '-' ?>
              </td>
              <td class="actions-cell">
                <div class="actions-container">
                  <?php if (!empty($exame->getResultado())): ?>
                    <a class="btn-primary small-btn" href="ver_laudo.php?idExame=<?= $exame->getIdExame() ?>">Visualizar</a>
                    <a class="btn-primary small-btn" href="editar_resultado.php?idExame=<?= $exame->getIdExame() ?>">Editar</a>
                  <?php else: ?>
                    <a class="btn-primary small-btn" href="form_resultado.php?idExame=<?= $exame->getIdExame() ?>">Inserir</a>
                  <?php endif; ?>
                  <button type="button" class="btn-danger small-btn btn-excluir" data-id="<?= $exame->getIdExame() ?>">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="no-results">Nenhum exame encontrado para o ID informado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

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
          window.location.href = `../controllers/excluir_exame.php?idExame=${idExame}`;
        }
      });
    });
  });
});
</script>
</body>
</html>
