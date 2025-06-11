<?php
require_once('../config/db.php');
require_once('../views/sidebar.php');

$dataHoje = date("Y-m-d");
$mesAtual = date("m");
$anoAtual = date("Y");
$primeiroDiaMes = date("Y-m-01");
$ultimoDiaMes = date("Y-m-t");

// Dados para o dia atual
$pacientesHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pacientes WHERE DATE(dataCadastro) = '$dataHoje'"))['total'];
$examesHoje = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM exames WHERE DATE(dataExame) = '$dataHoje'"))['total'];
// Remover referência à tabela laudos que não existe
$laudosHoje = 0; // Valor padrão já que a tabela não existe

// Consultar os dados de pacientes por dia no mês atual
$sqlPacientesMes = "SELECT DAY(dataCadastro) as dia, COUNT(*) as total 
                    FROM pacientes 
                    WHERE MONTH(dataCadastro) = $mesAtual AND YEAR(dataCadastro) = $anoAtual 
                    GROUP BY DAY(dataCadastro)";
$resultPacientes = mysqli_query($conn, $sqlPacientesMes);

if (!$resultPacientes) {
    die("Erro na consulta de pacientes do mês: " . mysqli_error($conn));
}

// Consultar os dados de exames por dia no mês atual
$sqlExamesMes = "SELECT DAY(dataExame) as dia, COUNT(*) as total 
                 FROM exames 
                 WHERE MONTH(dataExame) = $mesAtual AND YEAR(dataExame) = $anoAtual 
                 GROUP BY DAY(dataExame)";
$resultExames = mysqli_query($conn, $sqlExamesMes);

if (!$resultExames) {
    die("Erro na consulta de exames do mês: " . mysqli_error($conn));
}

// Inicializar arrays para armazenar dados diários (com zeros para todos os dias do mês)
$diasDoMes = intval(date('t')); // Total de dias no mês atual
$dadosPacientes = array_fill(1, $diasDoMes, 0);
$dadosExames = array_fill(1, $diasDoMes, 0);
$dadosLaudos = array_fill(1, $diasDoMes, 0); // Mantendo array para compatibilidade, mas sempre será zero

// Preencher os arrays com os dados reais
while ($row = mysqli_fetch_assoc($resultPacientes)) {
    $dadosPacientes[intval($row['dia'])] = intval($row['total']);
}

while ($row = mysqli_fetch_assoc($resultExames)) {
    $dadosExames[intval($row['dia'])] = intval($row['total']);
}

// Converter para formato JSON para uso no JavaScript
$jsonPacientes = json_encode(array_values($dadosPacientes));
$jsonExames = json_encode(array_values($dadosExames));
// Remover referência à tabela laudos que não existe

// Nome do mês atual
$nomesMeses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];
$nomeMesAtual = $nomesMeses[intval($mesAtual)];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Estatísticas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/home.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <!-- Removendo o card de laudos já que a tabela não existe
    <div class="col-md-4">
      <div class="card card-custom bg-success text-white position-relative">
        <div class="card-body">
          <i class="bi bi-file-earmark-medical-fill card-icon"></i>
          <h5 class="card-title">Laudos Emitidos</h5>
          <p class="card-text display-6 fw-bold"><?= $laudosHoje ?></p>
        </div>
      </div>
    </div>
    -->
  </div>
  
  <h2 class="mt-5 mb-4">📈 Estatísticas de <?= $nomeMesAtual ?> <?= $anoAtual ?></h2>
  
  <!-- Tabs para selecionar entre diferentes visualizações de gráficos -->
  <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="line-tab" data-bs-toggle="tab" data-bs-target="#line-chart" type="button" role="tab" aria-controls="line-chart" aria-selected="true">Linha</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="bar-tab" data-bs-toggle="tab" data-bs-target="#bar-chart" type="button" role="tab" aria-controls="bar-chart" aria-selected="false">Barras</button>
    </li>
  </ul>
  
  <!-- Conteúdo das tabs -->
  <div class="tab-content" id="myTabContent">
    <!-- Gráfico de Linha -->
    <div class="tab-pane fade show active" id="line-chart" role="tabpanel" aria-labelledby="line-tab">
      <div class="card shadow-sm">
        <div class="card-body">
          <canvas id="graficoLinha"></canvas>
        </div>
      </div>
    </div>
    
    <!-- Gráfico de Barras -->
    <div class="tab-pane fade" id="bar-chart" role="tabpanel" aria-labelledby="bar-tab">
      <div class="card shadow-sm">
        <div class="card-body">
          <canvas id="graficoBarras"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-header bg-light">
          <h5 class="mb-0">Comparativo Diário</h5>
        </div>
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
  </div>
</div>

<script>
// Dados para os gráficos
const diasDoMes = Array.from({length: <?= $diasDoMes ?>}, (_, i) => i + 1);
const dadosPacientes = <?= $jsonPacientes ?>;
const dadosExames = <?= $jsonExames ?>;
// Removendo referência a laudos que não existem no banco de dados
// const dadosLaudos = <?= $jsonLaudos ?>;

// Configurações comuns
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
    },
    tooltip: {
      mode: 'index',
      intersect: false,
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
const graficoLinha = new Chart(ctxLinha, {
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

// Gráfico de Barras
const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
const graficoBarras = new Chart(ctxBarras, {
  type: 'bar',
  data: {
    labels: diasDoMes,
    datasets: [
      {
        label: 'Pacientes',
        data: dadosPacientes,
        backgroundColor: 'rgba(13, 110, 253, 0.7)',
        borderColor: 'rgba(13, 110, 253, 1)',
        borderWidth: 1
      },
      {
        label: 'Exames',
        data: dadosExames,
        backgroundColor: 'rgba(255, 193, 7, 0.7)',
        borderColor: 'rgba(255, 193, 7, 1)',
        borderWidth: 1
      }
    ]
  },
  options: {
    ...opcoes,
    scales: {
      ...opcoes.scales,
      x: {
        ...opcoes.scales.x,
        stacked: false
      },
      y: {
        ...opcoes.scales.y,
        stacked: false
      }
    }
  }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>