<?php
require_once('../config/db.php'); // Inclui a configuração do banco de dados

// Simulação de autenticação (substitua por autenticação real)
$usuarioLogadoPermissao = 'admin'; // Permissão do usuário logado (substitua por sessão ou autenticação real)

// Verifica se o usuário tem permissão para acessar a página
if ($usuarioLogadoPermissao !== 'admin') {
    die("Acesso negado. Esta página é restrita aos administradores.");
}

// Consulta ao banco de dados para buscar contas de alunos e seus pacientes
$sql = "SELECT u.nomeCompleto AS aluno, u.email, u.rgm, p.nomeCompleto AS paciente, p.nomePatologia, p.nomeMedicamento 
        FROM usuarios u
        LEFT JOIN pacientes p ON u.rgm = p.rgm
        WHERE u.nivel = 'user'
        ORDER BY u.nomeCompleto ASC";

$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="./css/gerenciarUsuarios.css">
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Inclui a barra lateral -->

    <div class="container">
        <h1>Gerenciar Usuários</h1>
        <table>
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Email</th>
                    <th>RGM</th>
                    <th>Paciente</th>
                    <th>Patologia</th>
                    <th>Medicamento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['aluno']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['rgm']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['paciente'] ?? 'Sem paciente') . "</td>";
                        echo "<td>" . htmlspecialchars($row['nomePatologia'] ?? 'Sem patologia') . "</td>";
                        echo "<td>" . htmlspecialchars($row['nomeMedicamento'] ?? 'Sem medicamento') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum aluno encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>