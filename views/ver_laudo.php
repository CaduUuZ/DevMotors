<?php
require_once('../config/db.php');


try {
    $pdo = new PDO("mysql:host=localhost;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Conectar ao banco


// Função para buscar dados do exame
function buscarExame($pdo, $idExame) {
    $sql = "
        SELECT 
            e.*,
            p.*
        FROM exames e
        JOIN pacientes p ON e.idPaciente = p.idPaciente
        WHERE e.idExame = :id
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $idExame);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para processar JSON dos resultados
function processarResultados($jsonString) {
    if (empty($jsonString)) return [];
    
    $dados = json_decode($jsonString, true);
    if (!$dados) return [];
    
    $nomes = [
        'agar_sangue' => 'Ágar Sangue',
        'agar_chocolate' => 'Ágar Chocolate',
        'coloracao_gram' => 'Coloração de Gram',
        'agar_manitol' => 'Ágar Manitol',
        'teste_catalase' => 'Teste Catalase',
        'teste_coagulase' => 'Teste Coagulase',
        'teste_novobiocina' => 'Teste Novobiocina',
        'agar_macconkey' => 'Ágar MacConkey',
        'teste_oxidase' => 'Teste Oxidase',
        'epm' => 'EPM',
        'citrato' => 'Citrato',
        'resultado_gram_positivo' => 'Gram Positivo',
        'resultado_gram_negativo' => 'Gram Negativo',
        'resultado_bgp' => 'BGP',
        'resultado_bgn' => 'BGN',
        'agar_manitol_bgp' => 'Ágar Manitol BGP',
        'agar_manitol_bgn' => 'Ágar Manitol BGN',
        'teste_catalase_bgp' => 'Teste Catalase BGP',
        'teste_catalase_bgn' => 'Teste Catalase BGN',
        'teste_coagulase_bgp' => 'Teste Coagulase BGP',
        'teste_coagulase_bgn' => 'Teste Coagulase BGN',
        'teste_novobiocina_bgp' => 'Teste Novobiocina BGP',
        'teste_novobiocina_bgn' => 'Teste Novobiocina BGN',
        'teste_oxidase_bgp' => 'Teste Oxidase BGP',
        'teste_oxidase_bgn' => 'Teste Oxidase BGN',
        'citrato_bgp' => 'Citrato BGP',
        'citrato_bgn' => 'Citrato BGN',
        'resultado_agar_sangue' => 'Resultado Ágar Sangue',
        'resultado_agar_chocolate' => 'Resultado Ágar Chocolate',
        'teste_novobiocina_bgp' => 'Teste Novobiocina BGP',
        'teste_novobiocina_bgn' => 'Teste Novobiocina BGN',
        'agar_macconkey_bgn' => 'Ágar MacConkey BGN',
        'agar_macconkey_bgp' => 'Ágar MacConkey BGP',
        'epm_bgn' => 'EPM BGN',
        'epm_bgp' => 'EPM BGP',
        'mili_bgn' => 'Mili BGN',
        'resultado_bgp' => 'Resultado BGP',
        'resultado_bgn' => 'Resultado BGN',
    ];
    
    $resultados = [];
    foreach ($dados as $key => $valor) {
        if (!empty($valor)) {
            $nome = isset($nomes[$key]) ? $nomes[$key] : $key;
            $resultados[] = [
                'teste' => $nome,
                'resultado' => $valor
            ];
        }
    }
    
    return $resultados;
}

// Verificar se foi passado ID do exame
if (!isset($_GET['id'])) {
    die("Erro: ID do exame não informado. Use: ?id=123");
}

$idExame = $_GET['id'];
$dados = buscarExame($pdo, $idExame);

if (!$dados) {
    die("Exame não encontrado!");
}

$resultados = processarResultados($dados['informacoesAdicionais']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laudo - <?= htmlspecialchars($dados['nome']) ?></title>
    <link rel="stylesheet" href="./css/ver_laudo.css">
</head>
<body>
    <!-- Botão de imprimir -->
    <div class="no-print" style="text-align: center;">
        <button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir Laudo</button>
    </div>

    <!-- Cabeçalho -->
    <div class="cabecalho">
        <h1>LABORATÓRIO DE ANÁLISES CLÍNICAS</h1>
        <p><?= htmlspecialchars($dados['laboratorio']) ?></p>
        <p>LAUDO DE EXAME LABORATORIAL</p>
    </div>

    <!-- Dados do Paciente -->
    <div class="dados">
        <h3>DADOS DO PACIENTE</h3>
        <div class="linha">
            <span class="label">Nome:</span>
            <?= htmlspecialchars($dados['nome']) ?>
        </div>
        <div class="linha">
            <span class="label">ID Paciente:</span>
            <?= htmlspecialchars($dados['idPaciente']) ?>
        </div>
        <div class="linha">
            <span class="label">Data Nascimento:</span>
            <?= date('d/m/Y', strtotime($dados['dataNascimento'])) ?>
        </div>
        <div class="linha">
            <span class="label">Idade:</span>
            <?= $dados['idade'] ?> anos
        </div>
        <?php if (!empty($dados['telefone'])): ?>
        <div class="linha">
            <span class="label">Telefone:</span>
            <?= htmlspecialchars($dados['telefone']) ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($dados['nomeMae'])): ?>
        <div class="linha">
            <span class="label">Nome da Mãe:</span>
            <?= htmlspecialchars($dados['nomeMae']) ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Dados do Exame -->
    <div class="dados">
        <h3>DADOS DO EXAME</h3>
        <div class="linha">
            <span class="label">Tipo de Exame:</span>
            <?= htmlspecialchars($dados['exameTexto']) ?>
        </div>
        <div class="linha">
            <span class="label">Data do Exame:</span>
            <?= date('d/m/Y H:i', strtotime($dados['dataExame'])) ?>
        </div>
        <div class="linha">
            <span class="label">Laboratório:</span>
            <?= htmlspecialchars($dados['laboratorio']) ?>
        </div>
        <?php if (!empty($dados['nomeMedicamento'])): ?>
        <div class="linha">
            <span class="label">Medicamento:</span>
            <?= htmlspecialchars($dados['nomeMedicamento']) ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($dados['nomePatologia'])): ?>
        <div class="linha">
            <span class="label">Patologia:</span>
            <?= htmlspecialchars($dados['nomePatologia']) ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Resultados -->
    <?php if (!empty($resultados)): ?>
    <div class="resultados">
        <h3>RESULTADOS</h3>
        <?php foreach ($resultados as $resultado): ?>
        <div class="teste-item">
            <span><strong><?= htmlspecialchars($resultado['teste']) ?>:</strong></span>
            <span class="<?= strtolower($resultado['resultado']) == 'positivo' ? 'positivo' : 'negativo' ?>">
                <?= htmlspecialchars($resultado['resultado']) ?>
            </span>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Resultado Geral -->
    <?php if (!empty($dados['resultado'])): ?>
    <div class="dados">
        <h3>RESULTADO GERAL</h3>
        <p><?= nl2br(htmlspecialchars($dados['resultado'])) ?></p>
    </div>
    <?php endif; ?>

    <!-- Assinatura -->
    <div class="assinatura">
        <p>Data de emissão: <?= date('d/m/Y H:i:s') ?></p>
        <br><br>
        <p>_____________________________________</p>
        <p><strong>Responsável Técnico</strong></p>
        <p>Laboratório de Análises Clínicas</p>
    </div>

    <script>
        // Auto imprimir se tiver parâmetro print=1
        if (window.location.search.includes('print=1')) {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>