<?php
// Inclui as classes necessárias
require_once '../models/Paciente.php';
require_once '../config/db.php';
require_once '../DAO/PacienteDAO.php';

/**
 * Função para calcular a idade com base na data de nascimento
 */
function calcularIdade($dataNascimento) {
    $nascimento = new DateTime($dataNascimento);
    $hoje = new DateTime();
    return $hoje->diff($nascimento)->y;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $idPaciente = $_POST['idPaciente'] ?? null; // ID opcional, pode ser gerado automaticamente
        $nomeCompleto = $_POST['nome-completo'];
        $dataNascimento = $_POST['dataNascimento'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $nomeMae = $_POST['nome-mae'] ?? null;
        $idade = calcularIdade($dataNascimento);

        // Cria o objeto Paciente
        $paciente = new Paciente(
            $idPaciente,
            $nomeCompleto,
            $dataNascimento,
            $telefone,
            $email,
            $nomeMae,
            $idade,
            null, // medicamento
            null  // patologia
        );

        // Instancia o DAO e salva o paciente
        $dao = new PacienteDAO($conn);
        $dao->salvar($paciente);

        // Sucesso
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
                    text: 'Paciente cadastrado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../views/home.php';
                });
            </script>
        </body>
        </html>
        ";

    } catch (Exception $e) {
        $mensagemErro = json_encode($e->getMessage());

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
?>
