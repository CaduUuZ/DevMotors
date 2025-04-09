<?php
// Inclui as classes
require_once '../classes/Paciente.php';
require_once '../classes/Exame.php';
require_once '../config/db.php';

/**
 * Função para calcular a idade com base na data de nascimento
 */
function calcularIdade($dataNascimento) {
    $nascimento = new DateTime($dataNascimento);
    $hoje = new DateTime();
    return $hoje->diff($nascimento)->y;
}

/**
 * Gera ID aleatório de 8 caracteres (números + letras maiúsculas)
 */
function gerar_id_aleatorio($tamanho = 8) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $idPaciente = '';
    
    for ($i = 0; $i < $tamanho; $i++) {
        $idPaciente .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    
    return $idPaciente;
}

// Verifica se foi enviado um formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Dados do formulário
        $idPaciente = gerar_id_aleatorio(8);
        $nomeCompleto = $_POST['nome-completo'];
        $dataNascimento = $_POST['dataNascimento'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $nomeMae = $_POST['nome-mae'];
        $idadePaciente = calcularIdade($dataNascimento);

        $nomeMedicamento = ($_POST['remedio'] === 'medicamento-sim') ? $_POST['nome_medicamento'] : null;
        $nomePatologia = ($_POST['patologia'] === 'patologia-sim') ? $_POST['patologia_nome'] : null;

        // Cria objeto paciente
        $paciente = new Paciente(
            $idPaciente,
            $nomeCompleto,
            $dataNascimento,
            $telefone,
            $email,
            $nomeMae,
            $idadePaciente,
            $nomeMedicamento,
            $nomePatologia
        );

        // Salva no banco
        $paciente->salvar($conn);
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
                    window.location.href = '../telas/home.php';
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
