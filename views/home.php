<?php

require_once('../config/db.php');
require_once('../views/sidebar.php');

// Configurar o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Obter a data de hoje
$dataHoje = mysqli_real_escape_string($conn, date("Y-m-d"));

// Contar o número de pacientes cadastrados hoje
$resultPacientes = mysqli_query($conn, "SELECT COUNT(*) as total FROM pacientes WHERE DATE(dataCadastro) = '$dataHoje'");
if (!$resultPacientes) {
    die("Erro na consulta de pacientes: " . mysqli_error($conn));
}
$pacientesHoje = mysqli_fetch_assoc($resultPacientes)['total'] ?? 0;

// Contar o número de exames solicitados hoje
$resultExames = mysqli_query($conn, "SELECT COUNT(*) as total FROM exames WHERE DATE(dataExame) = '$dataHoje'");
if (!$resultExames) {
    die("Erro na consulta de exames: " . mysqli_error($conn));
}
$examesHoje = mysqli_fetch_assoc($resultExames)['total'] ?? 0;

// Obter o mês atual
$mesAtual = date("m");
$anoAtual = date("Y");
$diasDoMes = intval(date('t')); // Total de dias no mês atual

// Consultar os dados de pacientes por dia no mês atual
$sqlPacientesMes = "SELECT DAY(dataCadastro) as dia, COUNT(*) as total 
                    FROM pacientes 
                    WHERE MONTH(dataCadastro) = $mesAtual AND YEAR(dataCadastro) = $anoAtual 
                    GROUP BY DAY(dataCadastro)";
$resultPacientesMes = mysqli_query($conn, $sqlPacientesMes);

$dadosPacientes = array_fill(1, $diasDoMes, 0);
while ($row = mysqli_fetch_assoc($resultPacientesMes)) {
    $dadosPacientes[intval($row['dia'])] = intval($row['total']);
}

// Consultar os dados de exames por dia no mês atual
$sqlExamesMes = "SELECT DAY(dataExame) as dia, COUNT(*) as total 
                 FROM exames 
                 WHERE MONTH(dataExame) = $mesAtual AND YEAR(dataExame) = $anoAtual 
                 GROUP BY DAY(dataExame)";
$resultExamesMes = mysqli_query($conn, $sqlExamesMes);

$dadosExames = array_fill(1, $diasDoMes, 0);
while ($row = mysqli_fetch_assoc($resultExamesMes)) {
    $dadosExames[intval($row['dia'])] = intval($row['total']);
}

// Converter os dados para JSON para uso no JavaScript
$jsonPacientes = json_encode(array_values($dadosPacientes));
$jsonExames = json_encode(array_values($dadosExames));

// Nome do mês atual
$nomesMeses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];
$nomeMesAtual = $nomesMeses[intval($mesAtual)];
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container mt-5">
  <h2 class="mb-4">📊 Painel de Resumo do Dia</h2>
  <div class="row g-4">

    <div class="col-md-6">
      <div class="card card-custom bg-primary text-white position-relative">
        <div class="card-body">
          <i class="bi bi-person-plus-fill card-icon"></i>
          <h5 class="card-title">Pacientes Cadastrados</h5>
          <p class="card-text display-6 fw-bold"><?= $pacientesHoje ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card card-custom bg-warning text-dark position-relative">
        <div class="card-body">
          <i class="bi bi-clipboard2-plus-fill card-icon"></i>
          <h5 class="card-title">Exames Solicitados</h5>
          <p class="card-text display-6 fw-bold"><?= $examesHoje ?></p>
        </div>
      </div>
    </div>
  </div>

  <h2 class="mt-5 mb-4">📈 Estatísticas de <?= $nomeMesAtual ?> <?= $anoAtual ?></h2>
  
  <div class="card shadow-sm mb-5">
    <div class="card-body">
      <canvas id="graficoLinha"></canvas>
    </div>
  </div>

  <h2 class="mb-4">📋 Tabela de Estatísticas Diárias</h2>
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Dia</th>
              <th>Pacientes</th>
              <th>Exames</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $totalPacientesMes = 0;
            $totalExamesMes = 0;

            for ($i = 1; $i <= $diasDoMes; $i++) {
                $dataFormatada = sprintf("%02d/%s", $i, date("m/Y"));
                $totalDia = $dadosPacientes[$i] + $dadosExames[$i];

                $totalPacientesMes += $dadosPacientes[$i];
                $totalExamesMes += $dadosExames[$i];

                // Destacar o dia atual
                $classeDestaque = ($i == date("j")) ? 'table-primary' : '';

                echo "<tr class='$classeDestaque'>";
                echo "<td>{$dataFormatada}</td>";
                echo "<td>{$dadosPacientes[$i]}</td>";
                echo "<td>{$dadosExames[$i]}</td>";
                echo "<td>{$totalDia}</td>";
                echo "</tr>";
            }
            ?>
            <tr class="table-secondary fw-bold">
              <td>Total do Mês</td>
              <td><?= $totalPacientesMes ?></td>
              <td><?= $totalExamesMes ?></td>
              <td><?= $totalPacientesMes + $totalExamesMes ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
// Dados para os gráficos
const diasDoMes = Array.from({length: <?= $diasDoMes ?>}, (_, i) => i + 1);
const dadosPacientes = <?= $jsonPacientes ?>;
const dadosExames = <?= $jsonExames ?>;

// Configurações do gráfico
const opcoes = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Atividades Diárias - <?= $nomeMesAtual ?> <?= $anoAtual ?>'
    }
  },
  scales: {
    x: {
      title: {
        display: true,
        text: 'Dia do Mês'
      }
    },
    y: {
      beginAtZero: true,
      title: {
        display: true,
        text: 'Quantidade'
      }
    }
  }
};

// Gráfico de Linha
const ctxLinha = document.getElementById('graficoLinha').getContext('2d');
new Chart(ctxLinha, {
  type: 'line',
  data: {
    labels: diasDoMes,
    datasets: [
      {
        label: 'Pacientes',
        data: dadosPacientes,
        borderColor: 'rgba(13, 110, 253, 0.8)',
        backgroundColor: 'rgba(13, 110, 253, 0.1)',
        borderWidth: 2,
        tension: 0.3,
        fill: true
      },
      {
        label: 'Exames',
        data: dadosExames,
        borderColor: 'rgba(255, 193, 7, 0.8)',
        backgroundColor: 'rgba(255, 193, 7, 0.1)',
        borderWidth: 2,
        tension: 0.3,
        fill: true
      }
    ]
  },
  options: opcoes
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>