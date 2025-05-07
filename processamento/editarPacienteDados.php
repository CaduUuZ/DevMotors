<?php
require_once('../config/db.php');

/**
 * Função para calcular a idade com base na data de nascimento
 */
function calcularIdade($dataNascimento) {
    $nascimento = new DateTime($dataNascimento);
    $hoje = new DateTime();
    return $hoje->diff($nascimento)->y;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if ($conn->query($sql)) {
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
                    window.location.href = '../telas/pesquisaPaciente.php';
                });
            </script>
        </body>
        </html>
        ";
    } else {
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
                    window.history.back();
                });
            </script>
        </body>
        </html>
        ";
    }
}
//salva
?>