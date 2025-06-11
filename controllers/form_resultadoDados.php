<?php
require_once '../config/db.php';
require_once '../dao/ExameDAO.php';

$exameDAO = new ExameDAO($conn);

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idExame = $_POST['idExame'] ?? null;
    $resultado = $_POST['resultado'] ?? null;

    if ($idExame && $resultado !== null) {
        try {
            $exameDAO->atualizarResultado($idExame, $resultado);
            header("Location: ../telas/listaExames.php?status=success");
            exit;
        } catch (Exception $e) {
            $errorMsg = "Erro ao salvar resultado: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $errorMsg = "Dados incompletos para atualização.";
    }
}

// Verifica se o ID do exame foi informado na URL
if (!isset($_GET['idExame']) && !isset($idExame)) {
    echo "ID do exame não informado.";
    exit;
}

// Usa o ID do exame da GET ou do POST para carregar os dados
$idExameParaBuscar = $_GET['idExame'] ?? $idExame;

try {
    $exame = $exameDAO->buscarPorId($idExameParaBuscar);
    if (!$exame) {
        echo "Exame não encontrado.";
        exit;
    }
} catch (Exception $e) {
    echo "Erro ao buscar exame: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Resultado do Exame</title>
</head>
<body>
    <h1>Editar Resultado do Exame</h1>

    <?php if (!empty($errorMsg)): ?>
        <p style="color:red;"><?php echo $errorMsg; ?></p>
    <?php endif; ?>

    <p><strong>Paciente:</strong> <?php echo htmlspecialchars($exame->getPaciente()->getNome()); ?></p>
    <p><strong>Exame:</strong> <?php echo htmlspecialchars($exame->getExameTexto()); ?></p>
    <p><strong>Data do Exame:</strong> <?php echo htmlspecialchars($exame->getDataExame()); ?></p>

    <form action="" method="POST">
        <input type="hidden" name="idExame" value="<?php echo htmlspecialchars($exame->getIdExame()); ?>" />
        <label for="resultado">Resultado:</label><br />
        <textarea id="resultado" name="resultado" rows="6" cols="50"><?php echo htmlspecialchars($exame->getResultado()); ?></textarea><br /><br />
        <button type="submit">Salvar Resultado</button>
    </form>

    <p><a href="../views/listaExames.php">Voltar para lista de exames</a></p>
</body>
</html>
