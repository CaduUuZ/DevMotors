<?php
require_once('../config/db.php');
require_once('../telas/sidebar.php');

$dataHoje = date("Y-m-d");

// Contar o número de pacientes cadastrados hoje
$pacientesHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pacientes WHERE DATE(dataCadastro) = '$dataHoje'"))['total'];
// Contar o número de exames solicitados hoje
$examesHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM exames WHERE DATE(dataExame) = '$dataHoje'"))['total'];
// Contar o número de laudos emitidos hoje
//$laudosHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM laudos WHERE DATE(data_laudo) = '$dataHoje'"))['total'];
?>

<!-- Começo do HTML -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/home.css">
</head>
<body>

<div class="container mt-5">
  <h2 class="mb-4">📊 Painel de Resumo do Dia</h2>
  <div class="row g-4">

    <div class="col-md-4">
      <div class="card card-custom bg-primary text-white position-relative">
        <div class="card-body">
          <i class="bi bi-person-plus-fill card-icon"></i>
          <h5 class="card-title">Pacientes Cadastrados</h5>
          <p class="card-text display-6 fw-bold"><?= $pacientesHoje ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom bg-warning text-dark position-relative">
        <div class="card-body">
          <i class="bi bi-clipboard2-plus-fill card-icon"></i>
          <h5 class="card-title">Exames Solicitados</h5>
          <p class="card-text display-6 fw-bold"><?= $examesHoje ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom bg-success text-white position-relative">
        <div class="card-body">
          <i class="bi bi-file-earmark-medical-fill card-icon"></i>
          <h5 class="card-title">Laudos Emitidos</h5>
          <p class="card-text display-6 fw-bold"><?= $laudosHoje ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>