<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=delete" />
    <title>Pacientes</title>
    <style>
        :root {
            --primary-color: #123458;
            --primary-dark: #030303;
            --gray-light: #F1EFEC;
            --gray-medium: #D4C9BE;
            --error-color: #dc3545;
            --success-color: #28a745;
        }


        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }


        body {
            background-color: var(--gray-light);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        .container {
            width: 100%;
            max-width: 1200px;
            margin: 10px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid var(--gray-medium);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }


        .controls-container {
            margin-bottom: 20px;
        }


        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.25px;
        }


        .buttons {
            display: center;
            gap: 10px;
        }


        .search-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }


        .search-container input {
            width: 250px;
            padding: 0.5rem;
            border: 1px solid var(--gray-medium);
            border-radius: 5px;
            background-color: var(--gray-light);
        }


        #procura {
            padding: 0.5rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.2s;
        }


        #procura:hover {
            background-color: #90B8F8;
        }


        button {
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }


        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }


        .btn-primary:hover {
            background-color: #90B8F8;
        }


        .form-group {
            margin-bottom: 1rem;
        }


        .form-group h2 {
            margin-bottom: 15px;
            color: var(--primary-dark);
            border-bottom: 2px solid var(--gray-medium);
            padding-bottom: 10px;
        }


        #Lista {
            height: 70vh;
            overflow-y: auto;
        }


        .pacientes {
            list-style: none;
            padding: 0;
        }


        .pacientes li {
            padding: 15px;
            border-bottom: 1px solid var(--gray-medium);
            transition: background-color 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        .pacientes li:hover {
            background-color: var(--gray-light);
        }


        .pacientes li:last-child {
            border-bottom: none;
        }


        .pacientes h3 {
            color: var(--primary-dark);
            font-size: 1.1rem;
        }


        .lixo {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }


        .lixo:hover {
            background-color: #c82333;
        }


        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                align-items: stretch;
            }


            .buttons {
                width: 100%;
            }


            .search-container {
                width: 100%;
            }
           
            #Lista {
                height: 60vh;
            }
        }
    </style>
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
