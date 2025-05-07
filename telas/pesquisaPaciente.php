<?php
require_once('../config/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=delete,edit" />
    <link rel="stylesheet" href="css/pesquisaPaciente.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Pacientes</title>
    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
        }
    </style>
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
                    <input type="text" name="search" placeholder="Digite o nome ou código do paciente:" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button id="procura" type="submit">Procurar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container" id="Lista">
        <div class="form-group">
            <h2>Lista de Pacientes</h2>
            <ul class="pacientes">
                <?php
                // Obter o termo de busca
                $search = $_GET['search'] ?? '';

                // Consulta ao banco de dados
                $sql = "SELECT idPaciente, nomeCompleto FROM pacientes";
                if (!empty($search)) {
                    $search = $conn->real_escape_string($search);
                    $sql .= " WHERE idPaciente LIKE '%$search%' OR nomeCompleto LIKE '%$search%'";
                }
                $sql .= " ORDER BY nomeCompleto ASC";

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($paciente = $result->fetch_assoc()) {
                        echo '
                        <li>
                            <h3>' . htmlspecialchars($paciente['idPaciente']) . ' - ' . htmlspecialchars($paciente['nomeCompleto']) . '</h3>
                            <div class="actions">
                                <button class="editar" onclick="window.location.href=\'../processamento/editarPaciente.php?id=' . $paciente['idPaciente'] . '\'">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <button class="lixo" onclick="confirmarExclusao(\'' . $paciente['idPaciente'] . '\')">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </li>';
                    }
                } else {
                    echo '<li><h3>Nenhum paciente encontrado.</h3></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <script>
        // Função para confirmar exclusão
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
                    // Redirecionar para o script de exclusão
                    window.location.href = '../processamento/deletarPaciente.php?id=' + idPaciente;
                }
            });
        }

        // Exibir mensagem de sucesso ou erro após exclusão
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
    </script>
</body>
</html>
