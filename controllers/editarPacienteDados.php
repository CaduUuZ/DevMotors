<?php
require_once('../config/db.php'); // Inclui o arquivo de configuração do banco de dados

/**
 * Função para calcular a idade com base na data de nascimento
 */
function calcularIdade($dataNascimento) {
    $nascimento = new DateTime($dataNascimento); // Cria um objeto DateTime com a data de nascimento
    $hoje = new DateTime(); // Obtém a data atual
    return $hoje->diff($nascimento)->y; // Calcula a diferença em anos
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o método da requisição é POST
    // Escapa os dados recebidos para evitar SQL Injection
    $idPaciente = $conn->real_escape_string($_POST['idPaciente']);
    $nomeCompleto = $conn->real_escape_string($_POST['nome-completo']);
    $dataNascimento = $conn->real_escape_string($_POST['dataNascimento']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $email = $conn->real_escape_string($_POST['email']);

    // Calcular a idade com base na data de nascimento
    $idade = calcularIdade($dataNascimento);

    // Atualizar os dados no banco de dados
    $sql = "UPDATE pacientes 
            SET nomeCompleto = '$nomeCompleto', 
                dataNascimento = '$dataNascimento', 
                idade = '$idade', 
                telefone = '$telefone', 
                email = '$email' 
            WHERE idPaciente = '$idPaciente'";

    if ($conn->query($sql)) { // Verifica se a consulta foi executada com sucesso
        // Exibe um alerta de sucesso usando SweetAlert2
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Paciente atualizado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../telas/pesquisaPaciente.php'; // Redireciona para a página de pesquisa
                });
            </script>
        </body>
        </html>
        ";
    } else {
        // Exibe um alerta de erro com a mensagem retornada pelo banco de dados
        $mensagemErro = json_encode($conn->error);
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: 'Erro!',
                    text: $mensagemErro,
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.back(); // Retorna à página anterior
                });
            </script>
        </body>
        </html>
        ";
    }
}
//salva
?>