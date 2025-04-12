<?php
require_once '../config/db.php';

$dataHoje = date("Y-m-d");

// Contagem de pacientes cadastrados hoje
$pacientesHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pacientes WHERE DATE(dataCadastro) = '$dataHoje'"))['total'];

// Contagem de exames solicitados hoje
$examesHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM exames WHERE DATE(dataExame) = '$dataHoje'"))['total'];

// Contagem de laudos feitos hoje
$laudosHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM laudos WHERE DATE(data_laudo) = '$dataHoje'"))['total'];
?>

<!-- HTML -->
<div class="container mt-5">
  <h2 class="mb-4">Resumo do Dia</h2>
  <div class="row">

    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3 shadow">
        <div class="card-body">
          <h5 class="card-title">Pacientes Cadastrados</h5>
          <p class="card-text display-5"><?= $pacientesHoje ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-warning mb-3 shadow">
        <div class="card-body">
          <h5 class="card-title">Exames Solicitados</h5>
          <p class="card-text display-5"><?= $examesHoje ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-success mb-3 shadow">
        <div class="card-body">
          <h5 class="card-title">Laudos Emitidos</h5>
          <p class="card-text display-5"><?= $laudosHoje ?></p>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include 'sidebar.php'; ?> 