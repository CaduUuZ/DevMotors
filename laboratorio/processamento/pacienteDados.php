<?php
// Inclui as classes 
require_once '../classes/Paciente.php';
require_once '../classes/Exame.php';

// Pegando os dados do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPaciente = gerar_id_aleatorio(8);
    $dataCadastro = $_POST['dataCadastro'];
    $nomeCompleto = $_POST['nome-completo'];
    $dataNascimento = $_POST['dataNascimento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $nomeMae = $_POST['nome-mae'];
    $idadePaciente = calcularIdade($dataNascimento);
    $nomeMedicamento = $_POST['remedio-nome'];
    $nomePatologia = $_POST['patologia_nome'];
    $laboratorio = $_POST['laboratorio'];
    $exameTexto = $_POST['exameTexto'];

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
        $dataNascimento,
        $telefone,
        $email,
        $nomeMae,
        $idadePaciente,
        $nomeMedicamento,
        $nomePatologia
    );

    $exame = new Exame(
        $paciente, 
        $laboratorio, 
        $exameTexto
    );
}

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

/*
 *  Gera id aleatorio para paciente de 8 caracteres somente com números 
 *  e letras maiúsculas
 */
function gerar_id_aleatorio($tamanho = 8) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $idPaciente = '';
    
    for ($i = 0; $i < $tamanho; $i++) {
        $idPaciente .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    
    return $idPaciente;
}
?>
