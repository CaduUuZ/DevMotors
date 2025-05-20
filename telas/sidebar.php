<!DOCTYPE html>
<html lang="pt">
<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <!-- Importa a biblioteca FontAwesome para ícones -->
    <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
    <!-- Importa o arquivo CSS para estilização da barra lateral -->
    <link rel="stylesheet" href="./css/sidebar.css">
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
            <!-- Menu suspenso para categorias de laudos -->
            <li class="dropdown">
                <a href="#" class="dropbtn"><i class="fa-solid fa-file"></i>  Laudos   <i class="fa-solid fa-caret-down"></i></a>
                <ul class="dropdown-content">
                    <!-- Links para diferentes categorias de laudos -->
                    <li><a href="#">Bioquímica</a></li>
                    <li><a href="#">Hematologia</a></li>
                    <li><a href="#">Microbiologia</a></li>
                    <li><a href="#">Parasitologia</a></li>
                    <li><a href="#">Urinálise</a></li>
                </ul>
            </li>
            <!-- Link para logout -->
            <li><a href="index.html" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Importa o arquivo JavaScript para funcionalidades da barra lateral -->
    <script src="./js/sidebar.js"></script>
</body>
</html>
