<?php
require_once('../config/db.php');
include_once('sidebar.php');

// Busca exames com dados do paciente
$sql = "SELECT e.idExame, e.exameTexto, e.dataExame, e.resultado,
               p.idPaciente, p.nomeCompleto, p.idade 
        FROM exames e
        JOIN pacientes p ON e.idPaciente = p.idPaciente
        ORDER BY e.dataExame DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Exames</title>
  <link rel="stylesheet" href="css/listaExames.css">
</head>
<body>
  <div class="container">
    <div class="form-header">
      <h1>Exames Solicitados</h1>
      <p>Veja todos os exames solicitados pelos pacientes</p>
    </div>

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
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['idExame'] ?></td>
              <td><?= $row['idPaciente'] ?></td>
              <td><?= $row['nomeCompleto'] ?></td>
              <td><?= $row['idade'] ?></td>
              <td><?= $row['exameTexto'] ?></td>
              <td><?= date('d/m/Y H:i', strtotime($row['dataExame'])) ?></td>
              <td>
                <?php if (!empty($row['resultado'])): ?>
                  <a class="btn-primary small-btn" href="ver_laudo.php?idExame=<?= $row['idExame'] ?>">Visualizar Laudo</a>
                <?php else: ?>
                  <a class="btn-primary small-btn" href="form_resultado.php?idExame=<?= $row['idExame'] ?>">Inserir Resultado</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
