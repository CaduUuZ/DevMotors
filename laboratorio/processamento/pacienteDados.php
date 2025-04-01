<?php

// Inclui a classe Paciente
require_once '../classes/Paciente.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário HTML
    $registro = $_POST['registro'];
    $data = $_POST['data'];
    $periodo = $_POST['periodo'];
    $nomeCompleto = $_POST['nome-completo'];
    $dataNascimento = $_POST['dataNascimento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $nomeMae = $_POST['nome-mae'];
    $exameSolicitado = $_POST['examesolicitado'];
    $exameTexto = $_POST['exameTexto'];
    $medicamento = $_POST['remedio'];
    $patologia = $_POST['patologia'];

    // Se o paciente tomou medicamento
    if ($medicamento == 'medicamento-sim') {
        $nomeMedicamento = $_POST['nome_medicamento'];
    } else {
        $nomeMedicamento = null;
    }

    // Se o paciente tem patologia
    if ($patologia == 'patologia-sim') {
        $nomePatologia = $_POST['patologia_nome'];
    } else {
        $nomePatologia = null;
    }

    // Cria um novo objeto da classe Paciente
    $paciente = new Paciente($registro, $data, $periodo, $nomeCompleto, $dataNascimento, $telefone, $email, $nomeMae, $exameSolicitado, $nomeMedicamento, $nomePatologia);

    // Exibe as informações do paciente
    $informacoes = $paciente->exibirInformacoes();

    echo "<h2>Informações do Paciente</h2>";
    echo "<ul>";
    foreach ($informacoes as $key => $value) {
        echo "<li><strong>$key:</strong> $value</li>";
    }
    echo "<li><strong>Exame Selecionado:</strong> $exameTexto</li>";
    echo "</ul>";
}

?>
