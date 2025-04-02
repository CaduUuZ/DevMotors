<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Exame</title>
    <link rel="stylesheet" href="css/solicitarExame.css">
</head>

<body>
    <div class="container">
        <div class="form-header">
            <h1>Solicitar Exame</h1>
        </div>
        <?php include 'sidebar.php'; ?> 
        <form id="exameForm" action="#" method="post">
            <div class="form-row">
                <div class="form-control">
                    <label for="procurarPaciente">Procurar Paciente  <i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="search" name="procurarPaciente" id="procurarPaciente">
                </div>
            </div>
            <div class="form-row">
                <div class="form-control">
                    <label for="lab">Laboratório</label>
                    <select id="lab" name="lab" required onchange="exameoptions()">
                        <option value="">Selecione um Exame</option>
                        <option value="microbiologia">Microbiologia</option>
                        <option value="parasitologia">Parasitologia</option>
                        <option value="hematologia">Hematologia</option>
                        <option value="bioquímica">Bioquímica</option>
                        <option value="urinálise">Urinálise</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-control" id="exame"></div>
            </div>

            <input type="hidden" id="exameTexto" name="exameTexto">


            <div class="buttons">
                <button type="submit" class="btn-primary">Cadastrar Paciente</button>
            </div>
        </form>
    </div>
    <script src="js/solicitarExame.js"></script>
</body>

</html>

