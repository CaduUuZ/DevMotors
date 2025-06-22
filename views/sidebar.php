
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
</head>
<body>

    <!-- Estrutura da barra lateral -->
    <div class="sidebar">
        <!-- Botão para alternar a visibilidade da barra lateral -->
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <!-- Lista de links da barra lateral -->
        <ul>
            <!-- Link para a página inicial -->
            <li><a href="home.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <!-- Link para a página de cadastro de pacientes -->
            <li><a href="cadastroPaciente.php"><i class="fa-solid fa-pen-to-square"></i> Cadastro de Pacientes</a></li>
            <!-- Link para a página de lista de pacientes -->
            <li><a href="pesquisaPaciente.php"><i class="fa-solid fa-list"></i> Lista de Pacientes</a></li>
            <!-- Link para a página de solicitação de exames -->
            <li><a href="solicitarExame.php"><i class="fa-solid fa-file-pen"></i> Solicitar Exame</a></li>
            <!-- Link para a página de lista de exames -->
            <li><a href="listaExames.php"><i class="fa-solid fa-list"></i> Lista de Exames</a></li>
            <!-- Link para logout -->
            <li><a href="../controllers/logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            <!-- Link para a página de perfil do usuário -->
            <li><a href="perfil.php"><i class="fa-solid fa-user"></i> Perfil </a></li>
        </ul>
    </div>

    <!-- Importa o arquivo JavaScript para funcionalidades da barra lateral -->
    <script src="./js/sidebar.js"></script>
</body>
</html>
