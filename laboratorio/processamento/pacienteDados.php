<?php

// Inclui as classes necessárias
require_once '../classes/Paciente.php';
require_once '../classes/Exame.php';

/**
 * Calcula a idade com base na data de nascimento
 * @param string $dataNascimento Data no formato aceito pelo DateTime
 * @return int Idade em anos
 */
function calcularIdade($dataNascimento) {
    $nascimento = new DateTime($dataNascimento);
    $hoje = new DateTime();
    return $hoje->diff($nascimento)->y;
}

// Processa o formulário apenas quando for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura dados do formulário
    $idPaciente = $_POST['registro'];
    $dataCadastro = $_POST['dataCadastro'];
    $nomeCompleto = $_POST['nome-completo'];
    $dataNascimento = $_POST['dataNascimento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $nomeMae = $_POST['nome-mae'];
    $lab = $_POST['lab'];
    $exameTexto = $_POST['exameTexto'];
    
    // Calcula a idade do paciente
    $idadePaciente = calcularIdade($dataNascimento);
    
    // Verifica se o paciente tem medicamento
    $nomeMedicamento = ($_POST['remedio'] == 'medicamento-sim') 
        ? $_POST['nome_medicamento'] 
        : null;
    
    // Verifica se o paciente tem patologia
    $nomePatologia = ($_POST['patologia'] == 'patologia-sim') 
        ? $_POST['patologia_nome'] 
        : null;

    // Cria objetos de paciente e exame
    $paciente = new Paciente(
        $idPaciente, 
        $dataCadastro, 
        $nomeCompleto, 
        $telefone, 
        $email, 
        $nomeMae, 
        $dataNascimento, 
        $idadePaciente
    );

    $exame = new Exame(
        $paciente, 
        $lab, 
        $nomeMedicamento, 
        $nomePatologia, 
        $exameTexto
    );
    
}
?>