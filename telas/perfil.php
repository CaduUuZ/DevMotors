<?php
session_start();
if (!isset($_SESSION['usuarioLogado'])) {
    header("Location: index.html");
    exit;
}
$usuarioLogado = $_SESSION['usuarioLogado'];

require_once('../config/db.php'); // Inclui a configuração do banco de dados
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="./css/perfil.css">
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Inclui a barra lateral -->

    <div class="perfil-container">
        <h1>Perfil do Usuário</h1>
        <p><strong>Nome Completo:</strong> <?= htmlspecialchars($usuarioLogado['nomeCompleto']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($usuarioLogado['email']) ?></p>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($usuarioLogado['telefone']) ?></p>
        <p><strong>Cargo:</strong> <?= htmlspecialchars($usuarioLogado['cargo']) ?></p>
        <p><strong>RGM:</strong> <?= htmlspecialchars($usuarioLogado['rgm']) ?></p>
        <p><strong>Permissão:</strong> <?= htmlspecialchars($usuarioLogado['permissao'] === 'admin' ? 'Administrador' : 'Usuário') ?></p>

        <h2>Opções</h2>
        <?php if ($usuarioLogado['permissao'] === 'admin'): ?>
            <button onclick="window.location.href='gerenciarUsuarios.php'">Gerenciar Usuários</button>
            <button onclick="window.location.href='relatorios.php'">Visualizar Relatórios</button>
        <?php else: ?>
            <button onclick="window.location.href='consultarDados.php'">Consultar Dados</button>
        <?php endif; ?>
    </div>
</body>
</html>