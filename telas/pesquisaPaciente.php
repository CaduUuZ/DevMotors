<?php
require_once('../config/db.php'); // Inclui a configuração do banco de dados
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Metadados e links para estilos e scripts -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/pesquisaPaciente.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Pacientes</title>
</head>

<body>
  <?php include 'sidebar.php'; ?> <!-- Inclui o menu lateral -->

  <div class="container controls-container">
    <!-- Botão para adicionar novo paciente e barra de pesquisa -->
    <div class="form-row">
      <div class="buttons">
        <button class="btn-primary" onclick="window.location.href='cadastroPaciente.php'">Novo Paciente</button>
      </div>
      <div class="search-container">
        <form method="GET" action="">
          <!-- Campo de pesquisa -->
          <input type="text" name="search" placeholder="Digite o nome ou código do paciente:" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
          <button id="procura" type="submit">Procurar</button>
        </form>
      </div>
    </div>
  </div>

  <div class="container" id="Lista">
    <!-- Lista de pacientes -->
    <div class="form-group">
      <h2>Lista de Pacientes</h2>
      <ul class="pacientes">
        <?php
        // Consulta SQL para buscar pacientes
        $search = $_GET['search'] ?? '';
        $sql = "SELECT idPaciente, nomeCompleto, idade, email, telefone FROM pacientes";
        if (!empty($search)) {
          $search = $conn->real_escape_string($search); // Sanitiza a entrada
          $sql .= " WHERE idPaciente LIKE '%$search%' OR nomeCompleto LIKE '%$search%'";
        }
        $sql .= " ORDER BY nomeCompleto ASC";

        $result = $conn->query($sql);

        // Exibe os pacientes encontrados ou uma mensagem de nenhum resultado
        if ($result && $result->num_rows > 0) {
          while ($paciente = $result->fetch_assoc()) {
            echo '
          <li>
            <h3>' . htmlspecialchars($paciente['idPaciente']) . ' - ' . htmlspecialchars($paciente['nomeCompleto'])  . ' - ' . htmlspecialchars($paciente['email']) . '</h3>
            <div class="actions">
              <!-- Botão para editar paciente -->
              <button class="editar" 
                data-id="' . $paciente['idPaciente'] . '" 
                data-nome="' . htmlspecialchars($paciente['nomeCompleto']) . '"
                data-idade="' . htmlspecialchars($paciente['idade']) . '"
                data-email="' . htmlspecialchars($paciente['email']) . '"
                data-telefone="' . htmlspecialchars($paciente['telefone']) . '">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
              <!-- Botão para excluir paciente -->
              <button class="lixo" onclick="confirmarExclusao(\'' . $paciente['idPaciente'] . '\')">
                <span class=""><i class="fa-solid fa-trash"></i></span>
              </button>
            </div>
          </li>';
          }
        } else {
          echo '<li><h3>Nenhum paciente encontrado.</h3></li>'; // Mensagem caso nenhum paciente seja encontrado
        }
        ?>
      </ul>
    </div>
  </div>

  <!-- Modal Bootstrap para Editar Paciente -->
  <div class="modal fade" id="editPacienteModal" tabindex="-1" aria-labelledby="editPacienteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="../processamento/editarPaciente.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPacienteModalLabel">Editar Paciente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <!-- Campos do formulário para edição -->
          <input type="hidden" name="idPaciente" id="modal-idPaciente">

          <div class="mb-3">
            <label for="modal-nomeCompleto" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" name="nomeCompleto" id="modal-nomeCompleto" required>
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
            <input type="text" class="form-control" name="nomeMedicamento" id="modal-nomeMedicamento">
          </div>

          <div class="mb-3">
            <label for="modal-nomePatologia" class="form-label">Nome Patologia</label>
            <input type="text" class="form-control" name="nomePatologia" id="modal-nomePatologia">
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
    // Função para confirmar exclusão com SweetAlert2
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
          window.location.href = '../processamento/deletarPaciente.php?id=' + idPaciente;
        }
      });
    }

    // Preencher modal com os dados do paciente
    document.querySelectorAll('.editar').forEach(btn => {
      btn.addEventListener('click', function() {
        document.getElementById('modal-idPaciente').value = this.dataset.id;
        document.getElementById('modal-nomeCompleto').value = this.dataset.nome;
        document.getElementById('modal-idade').value = this.dataset.idade;
        document.getElementById('modal-email').value = this.dataset.email;
        document.getElementById('modal-telefone').value = this.dataset.telefone;

        const modal = new bootstrap.Modal(document.getElementById('editPacienteModal'));
        modal.show();
      });
    });

    // Exibir alerta se houver sucesso ou erro
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

    // Função para obter parâmetros da URL
    function getQueryParam(param) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }

    // Exibir mensagens de sucesso ou erro ao editar
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