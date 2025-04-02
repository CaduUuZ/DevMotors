<?php

// Inclui a classe Paciente
require_once '../classes/Paciente.php';
require_once '../classes/Exame.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário HTML
    $idPaciente = $_POST['registro'];
    $dataCadastro = $_POST['dataCadastro'];
    $nomeCompleto = $_POST['nome-completo'];
    $dataNascimento = $_POST['dataNascimento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $nomeMae = $_POST['nome-mae'];
    $lab = $_POST['lab'];
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
    $paciente = new Paciente($idPaciente, $dataCadastro,$nomeCompleto, $telefone, $email, $nomeMae, $dataNascimento );

    // Cria um novo objeto da classe Exame
    $exame = new Exame($paciente, $lab, $nomeMedicamento, $nomePatologia, $exameTexto);

}
?>