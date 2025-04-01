<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <script src="https://kit.fontawesome.com/b2dffd92bb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/sidebar.css">
</head>
<body>

    <div class="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <ul>
            <li><a href="index.html"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="cadastro.html"><i class="fa-solid fa-pen-to-square"></i> Cadastro de Pacientes</a></li>
            <li><a href="lista.html"><i class="fa-solid fa-list"></i> Lista de Pacientes</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn"><i class="fa-solid fa-file"></i>  Laudos   <i class="fa-solid fa-caret-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="#">Bioquímica</a></li>
                    <li><a href="#">Hematologia</a></li>
                    <li><a href="#">Microbiologia</a></li>
                    <li><a href="#">Parasitologia</a></li>
                    <li><a href="#">Urinálise</a></li>
                </ul>
            </li>
            <li><a href="login.html" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <script src="./js/sidebar.js"></script>
</body>
</html>
