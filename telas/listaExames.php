<?php require_once('../config/db.php'); include_once('sidebar.php'); 

// Verifica se há um ID de paciente para buscar
$buscaId = isset($_GET['buscaId']) ? trim($_GET['buscaId']) : null; 

// Consulta SQL
$sql = "SELECT e.idExame, e.exameTexto, e.dataExame, e.resultado, 
               p.idPaciente, p.nomeCompleto, p.idade 
        FROM exames e 
        JOIN pacientes p ON e.idPaciente = p.idPaciente"; 

if (!empty($buscaId)) { 
    $buscaId = $conn->real_escape_string($buscaId); 
    $sql .= " WHERE p.idPaciente LIKE '%$buscaId%'"; 
} 

$sql .= " ORDER BY e.dataExame DESC"; 

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Exames</title>
  <link rel="stylesheet" href="css/listaExames.css?v=6">
  <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
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
        <input type="text" name="buscaId" id="buscaId" placeholder="Ex: PAC123" value="<?= htmlspecialchars($buscaId) ?>">
        <button type="submit" class="btn-primary">Buscar</button>
        <?php if (!empty($buscaId)): ?>
          <a href="lista_exames.php" class="btn-primary">Limpar</a>
        <?php endif; ?>
      </form>
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
          <?php if ($result->num_rows > 0): ?>
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
                      <a class="btn-primary small-btn" href="ver_laudo.php?idExame=<?= $row['idExame'] ?>">Visualizar</a>
                      <a class="btn-primary small-btn" href="editar_resultado.php?idExame=<?= $row['idExame'] ?>">Editar</a>
                    <?php else: ?>
                      <a class="btn-primary small-btn" href="form_resultado.php?idExame=<?= $row['idExame'] ?>">Inserir</a>
                    <?php endif; ?>
                    <a class="btn-danger small-btn" href="excluir_exame.php?idExame=<?= $row['idExame'] ?>" onclick="return confirm('Tem certeza que deseja excluir este exame?');"><i class="fa-solid fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="no-results">Nenhum exame encontrado para o ID informado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>