<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../dao/PacienteDAO.php';
require_once __DIR__ . '/../dao/ExameDAO.php';
require_once __DIR__ . '/../models/Exame.php';
require_once __DIR__ . '/../models/Paciente.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = $_POST['procurarPaciente'] ?? '';
    $laboratorio = $_POST['laboratorio'] ?? '';
    $exameTexto = $_POST['exameTexto'] ?? '';

    if (empty($idPaciente) || empty($laboratorio) || empty($exameTexto)) {
        echo "<script>alert('Todos os campos são obrigatórios.');</script>";
        exit;
    }

    try {
        $pacienteDAO = new PacienteDAO($conn);
        $exameDAO = new ExameDAO($conn);

        // Busca paciente pelo ID
        $paciente = $pacienteDAO->buscarPorId($idPaciente);

        if (!$paciente) {
            throw new Exception("Paciente não encontrado.");
        }

        // Formata o texto dos exames (remove espaços extras)
        $exames = array_map('trim', explode(',', $exameTexto));
        $exameTextoFormatado = implode(', ', $exames);

        // Cria objeto Exame
        $exame = new Exame($paciente, $laboratorio, $exameTextoFormatado);

        // Salva o exame
        $exameDAO->salvar($exame);

        // Mensagem de sucesso com SweetAlert2
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
                    window.location.href = '../views/home.php';
                });
            </script>
        </body>
        </html>
        ";
    } catch (Exception $e) {
        echo "<script>alert('Erro: " . addslashes($e->getMessage()) . "');</script>";
        exit;
    }
}
