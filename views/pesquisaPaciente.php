<?php
require_once('../config/db.php'); 
require_once('../dao/PacienteDAO.php'); 
require_once('../models/Paciente.php'); 

$pacienteDAO = new PacienteDAO($conn);
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    if (is_numeric($search)) {
        // Busca por ID
        $paciente = $pacienteDAO->buscarPorId($search);
        $pacientes = $paciente ? [$paciente] : [];
    } else {
        // Busca por nome
        $pacientes = $pacienteDAO->buscarPorNome($search);
    }
} else {
    $pacientes = $pacienteDAO->buscarTodos();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/pesquisaPaciente.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Pacientes</title>
</head>

<body>
  <?php include 'sidebar.php'; ?>

  <div class="container controls-container">
    <div class="form-row">
      <div class="buttons">
        <button class="btn-primary" onclick="window.location.href='cadastroPaciente.php'">Novo Paciente</button>
      </div>
      <div class="search-container">
        <form method="GET" action="">
          <input type="text" name="search" placeholder="Digite o nome ou código do paciente:" value="<?= htmlspecialchars($search) ?>">
          <button id="procura" type="submit">Procurar</button>
        </form>
      </div>
    </div>
  </div>

  <div class="container" id="Lista">
    <div class="form-group">
      <h2>Lista de Pacientes</h2>
      <ul class="pacientes">
        <?php if (!empty($pacientes)): ?>
          <?php foreach ($pacientes as $paciente): ?>
            <li>
              <h3><?= htmlspecialchars($paciente->getIdPaciente()) ?> - <?= htmlspecialchars($paciente->getNome()) ?> - <?= htmlspecialchars($paciente->getEmail()) ?></h3>
              <div class="actions">
                <button class="editar"
                  data-id="<?= $paciente->getIdPaciente() ?>"
                  data-nome="<?= htmlspecialchars($paciente->getNome()) ?>"
                  data-idade="<?= htmlspecialchars($paciente->getIdade()) ?>"
                  data-email="<?= htmlspecialchars($paciente->getEmail()) ?>"
                  data-telefone="<?= htmlspecialchars($paciente->getTelefone()) ?>"
                  data-dataNascimento="<?= htmlspecialchars($paciente->getDataNascimento()) ?>"
                  data-nomeMedicamento="<?= htmlspecialchars($paciente->getMedicamento()) ?>"
                  data-nomePatologia="<?= htmlspecialchars($paciente->getPatologia()) ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="lixo" onclick="confirmarExclusao('<?= $paciente->getIdPaciente() ?>')">
                  <span><i class="fa-solid fa-trash"></i></span>
                </button>
              </div>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li><h3>Nenhum paciente encontrado.</h3></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <div class="modal fade" id="editPacienteModal" tabindex="-1" aria-labelledby="editPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="../controllers/editarPaciente.php">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editPacienteModalLabel">Editar Paciente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="idPaciente" id="modal-idPaciente">

            <div class="mb-3">
              <label for="modal-nomeCompleto" class="form-label">Nome Completo</label>
              <input type="text" class="form-control" name="nome" id="modal-nomeCompleto" required>
            </div>

            <div class="mb-3">
              <label for="modal-idade" class="form-label">Idade</label>
              <input type="number" class="form-control" name="idade" id="modal-idade">
            </div>

            <div class="mb-3">
              <label for="modal-email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="modal-email">
            </div>

            <div class="mb-3">
              <label for="modal-telefone" class="form-label">Telefone</label>
              <input type="text" class="form-control" name="telefone" id="modal-telefone">
            </div>

            <div class="mb-3">
              <label for="modal-dataNascimento" class="form-label">Data Nascimento</label>
              <input type="date" class="form-control" name="dataNascimento" id="modal-dataNascimento">
            </div>

            <div class="mb-3">
              <label for="modal-nomeMedicamento" class="form-label">Nome Medicamento</label>
              <input type="text" class="form-control" name="medicamento" id="modal-nomeMedicamento">
            </div>

            <div class="mb-3">
              <label for="modal-nomePatologia" class="form-label">Nome Patologia</label>
              <input type="text" class="form-control" name="patologia" id="modal-nomePatologia">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    function confirmarExclusao(idPaciente) {
      Swal.fire({
        title: "Tem certeza?",
        text: "Você não poderá reverter esta ação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '../controllers/deletarPaciente.php?id=' + idPaciente;
        }
      });
    }

    document.querySelectorAll('.editar').forEach(btn => {
      btn.addEventListener('click', function() {
        document.getElementById('modal-idPaciente').value = this.dataset.id;
        document.getElementById('modal-nomeCompleto').value = this.dataset.nome;
        document.getElementById('modal-idade').value = this.dataset.idade;
        document.getElementById('modal-email').value = this.dataset.email !== "null" ? this.dataset.email : "";
        document.getElementById('modal-telefone').value = this.dataset.telefone !== "null" ? this.dataset.telefone : "";

        // Corrige data para o formato do input date
        let dataNasc = this.dataset.dataNascimento;
        if (dataNasc && dataNasc.length >= 10) {
          dataNasc = dataNasc.substring(0, 10);
        } else {
          dataNasc = "";
        }
        document.getElementById('modal-dataNascimento').value = dataNasc;

        document.getElementById('modal-nomeMedicamento').value = this.dataset.nomeMedicamento !== "null" ? this.dataset.nomeMedicamento : "";
        document.getElementById('modal-nomePatologia').value = this.dataset.nomePatologia !== "null" ? this.dataset.nomePatologia : "";

        const modal = new bootstrap.Modal(document.getElementById('editPacienteModal'));
        modal.show();
      });
    });

    <?php if (isset($_GET['success'])): ?>
      <?php if ($_GET['success'] == 1): ?>
        Swal.fire({
          title: "Excluído!",
          text: "O paciente foi excluído com sucesso.",
          icon: "success",
          confirmButtonColor: "#3085d6"
        });
      <?php elseif ($_GET['success'] == 0 && isset($_GET['error'])): ?>
        Swal.fire({
          title: "Erro!",
          text: "<?= htmlspecialchars($_GET['error']) ?>",
          icon: "error",
          confirmButtonColor: "#3085d6"
        });
      <?php endif; ?>
    <?php endif; ?>

    function getQueryParam(param) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }

    const editSuccess = getQueryParam('edit_success');
    const errorMsg = getQueryParam('error');

    if (editSuccess !== null) {
      if (editSuccess === '1') {
        Swal.fire({
          title: "Sucesso!",
          text: "Paciente atualizado com sucesso.",
          icon: "success",
          confirmButtonColor: "#3085d6"
        });
      } else if (editSuccess === '0') {
        Swal.fire({
          title: "Erro!",
          text: errorMsg ? decodeURIComponent(errorMsg) : "Ocorreu um erro ao atualizar o paciente.",
          icon: "error",
          confirmButtonColor: "#3085d6"
        });
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
