<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Exame</title>
    <!-- Importa o arquivo CSS para estilização -->
    <link rel="stylesheet" href="css/solicitarExame.css">
</head>

<body>
    <div class="container">
        <!-- Cabeçalho do formulário -->
        <div class="form-header">
            <h1>Solicitar Exame</h1>
        </div>
        <!-- Inclui o arquivo da barra lateral -->
        <?php include 'sidebar.php'; ?>
        <!-- Formulário para solicitação de exame -->
        <form id="exameForm" action="../controllers/exameDados.php" method="post">
            <!-- Campo para procurar paciente pelo ID -->
            <div class="form-row">
                <div class="form-control">
                    <label for="procurarPaciente">Procurar Paciente (ID)</label>
                    <input type="search" name="procurarPaciente" id="procurarPaciente" list="listaPacientes" autocomplete="off" required>
                </div>
            </div>
            <!-- Campo para selecionar o laboratório -->
            <div class="form-row">
                <div class="form-control">
                    <label for="laboratorio">Laboratórios</label>
                    <select id="laboratorio" name="laboratorio" required onchange="exameoptions()">
                        <option value="">Selecione um Laboratório</option>
                        <option value="microbiologia">Microbiologia</option>
                        <option value="parasitologia">Parasitologia</option>
                        <option value="hematologia">Hematologia</option>
                        <option value="bioquímica">Bioquímica</option>
                        <option value="urinálise">Urinálise</option>
                    </select>
                </div>
            </div>
            <!-- Div para exibir as opções de exames com base no laboratório selecionado -->
            <div class="form-row">
                <div class="form-control" id="lab"></div>
            </div>

            <!-- Campo oculto para armazenar o texto do exame selecionado -->
            <input type="hidden" id="exameTexto" name="exameTexto">

            <!-- Botão para enviar o formulário -->
            <div class="buttons">
                <button type="submit" class="btn-primary">Cadastrar Exame</button>
            </div>
        </form>
    </div>
    <!-- Importa o arquivo JavaScript para funcionalidades adicionais -->
    <script src="./js/solicitarExame.js"></script>
</body>

</html>