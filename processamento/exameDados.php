<?php

require_once '../config/db.php';
require_once '../classes/Paciente.php';
require_once '../classes/Exame.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomePaciente = $_POST['procurarPaciente'] ?? '';
    $laboratorio = $_POST['laboratorio'] ?? '';
    $exameTexto = $_POST['exameTexto'] ?? '';

    if (empty($nomePaciente) || empty($laboratorio) || empty($exameTexto)) {
        echo "<script>alert('Todos os campos são obrigatórios.');</script>";
        exit;
    }

    // Buscar paciente por id
    $stmt = $conn->prepare("SELECT * FROM pacientes WHERE idPaciente LIKE ? LIMIT 1");
    $likeNome = "%$nomePaciente%";
    $stmt->bind_param("s", $likeNome);
    $stmt->execute();
    $result = $stmt->get_result();
    $pacienteData = $result->fetch_assoc();

    if (!$pacienteData) {
        echo "<script>alert('Paciente não encontrado.');</script>";
        exit;
    }

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

    // Converter texto do exame para string formatada
    $exames = array_map('trim', explode(',', $exameTexto));
    $exameTextoFormatado = implode(', ', $exames);

    // Criar e salvar exame
    $exame = new Exame($paciente, $laboratorio, $exameTextoFormatado);
    $exame->salvar($conn);

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
