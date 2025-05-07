<?php
require_once('../config/db.php');

if (!isset($_GET['id'])) {
    echo "<script>
        alert('ID do paciente não informado.');
        window.history.back();
    </script>";
    exit;
}

$idPaciente = $conn->real_escape_string($_GET['id']);

// Obter os dados do paciente
$sql = "SELECT * FROM pacientes WHERE idPaciente = '$idPaciente'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "<script>
        alert('Paciente não encontrado.');
        window.history.back();
    </script>";
    exit;
}

$paciente = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="css/cadastroPaciente.css">
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h1>Editar Paciente</h1>
        </div>
        <form action="../processamento/editarPacienteDados.php" method="POST">
            <input type="hidden" name="idPaciente" value="<?= $paciente['idPaciente'] ?>">
            <div class="form-group">
                <label for="nome-completo">Nome Completo:</label>
                <input type="text" id="nome-completo" name="nome-completo" value="<?= htmlspecialchars($paciente['nomeCompleto']) ?>" required>
            </div>
            <div class="form-group">
                <label for="dataNascimento">Data de Nascimento:</label>
                <input type="date" id="dataNascimento" name="dataNascimento" value="<?= $paciente['dataNascimento'] ?>" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($paciente['telefone']) ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($paciente['email']) ?>">
            </div>
            <div class="buttons">
                <button type="submit" class="btn-primary">Salvar</button>
                <a href="pesquisaPaciente.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>