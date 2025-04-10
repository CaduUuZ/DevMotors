<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=delete" />
    <link rel="stylesheet" href="css/pesquisaPaciente.css">
    <title>Pacientes</title>
</head>
<body>
    <?php include 'sidebar.php'; ?> 
    <!-- Controls Container -->
    <div class="container controls-container">
        <div class="form-row">
            <div class="buttons">
                <button class="btn-primary">Enviar Exames</button>
                <button class="btn-primary">Novo Paciente</button>
            </div>
            <div class="search-container">
                <input type="text" name="search" placeholder="Digite o codigo:">
                <button id="procura">Procurar</button>
            </div>
        </div>
    </div>


    <!-- Patient List Container -->
    <div class="container" id="Lista">
        <div class="form-group">
            <h2>Lista de Pacientes</h2>
            <ul class="pacientes">
                <li><h3>Paciente 001 - João da Silva</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button>
                </li>
                <li><h3>Paciente 002 - Maria Oliveira</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button>
            </li>
                <li><h3>Paciente 003 - Carlos Santos</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button>
                </li>
                <li><h3>Paciente 004 - Ana Pereira</h3><button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 005 - Roberto Almeida</h3><button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 006 - Juliana Costa</h3><button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 007 - Fernando Gomes</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 008 - Patricia Lima</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 009 - Marcelo Souza</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 010 - Luciana Ferreira</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 011 - Gabriel Martins</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 012 - Camila Rodrigues</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 013 - Rafael Teixeira</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 014 - Bianca Carvalho</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
                <li><h3>Paciente 015 - Eduardo Mendes</h3>
                    <button class="lixo">
                        <span class="material-symbols-outlined">
                        delete
                        </span>
                    </button></li>
            </ul>
        </div>
    </div>
</body>
</html>
