<?php

// Inclui os arquivos necessários para conexão com o banco de dados e classes
require_once '../config/db.php';
require_once '../classes/Paciente.php';
require_once '../classes/Exame.php';

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário
    $nomePaciente = $_POST['procurarPaciente'] ?? '';
    $laboratorio = $_POST['laboratorio'] ?? '';
    $exameTexto = $_POST['exameTexto'] ?? '';

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nomePaciente) || empty($laboratorio) || empty($exameTexto)) {
        echo "<script>alert('Todos os campos são obrigatórios.');</script>";
        exit;
    }

    // Busca o paciente no banco de dados pelo ID ou nome
    $stmt = $conn->prepare("SELECT * FROM pacientes WHERE idPaciente LIKE ? LIMIT 1");
    $likeNome = "%$nomePaciente%";
    $stmt->bind_param("s", $likeNome);
    $stmt->execute();
    $result = $stmt->get_result();
    $pacienteData = $result->fetch_assoc();

    // Verifica se o paciente foi encontrado
    if (!$pacienteData) {
        echo "<script>alert('Paciente não encontrado.');</script>";
        exit;
    }

    // Cria uma instância da classe Paciente com os dados obtidos
    $paciente = new Paciente(
        $pacienteData['idPaciente'],
        $pacienteData['nomeCompleto'],
        $pacienteData['dataNascimento'],
        $pacienteData['telefone'],
        $pacienteData['email'],
        $pacienteData['nomeMae'],
        $pacienteData['idade'],
        $pacienteData['nomeMedicamento'],
        $pacienteData['nomePatologia']
    );

    // Converte o texto do exame em uma string formatada
    $exames = array_map('trim', explode(',', $exameTexto));
    $exameTextoFormatado = implode(', ', $exames);

    // Cria uma instância da classe Exame e salva no banco de dados
    $exame = new Exame($paciente, $laboratorio, $exameTextoFormatado);
    $exame->salvar($conn);

    // Exibe uma mensagem de sucesso usando SweetAlert2 e redireciona para a página inicial
    echo "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Sucesso!',
                text: 'Exames cadastrados com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '../telas/home.php';
            });
        </script>
    </body>
    </html>
    ";
}
