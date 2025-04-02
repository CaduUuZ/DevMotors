<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="css/cadastropaciente.css">
</head>

<body>
    <div class="container">
        <div class="form-header">
            <h1>Cadastro de Paciente</h1>
        </div>
        <?php include 'sidebar.php'; ?> 
        <form id="pacienteForm" action="../processamento/pacienteDados.php" method="post">
            <div class="form-row">
                <div class="form-control">
                    <label for="dataCadastro">Data</label>
                    <input type="date" id="dataCadastro" name="dataCadastro" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-control">
                    <label for="nome-completo">Nome Completo</label>
                    <input type="text" id="nome-completo" name="nome-completo" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-control">
                    <label for="dataNascimento">Data de Nascimento</label>
                    <input type="date" id="dataNascimento" name="dataNascimento" required>
                </div>

                <div class="form-control">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" required pattern="^\(\d{2}\) \d{5}-\d{4}$"
                        placeholder="(00) 00000-0000">
                    <span class="help-text">Formato: (00) 00000-0000</span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-control">
                    <label for="nome-mae">Nome da Mãe</label>
                    <input type="text" id="nome-mae" name="nome-mae">
                </div>
            </div>        
            <div class="form-row">
                <div class="form-control" id="exame"></div>
            </div>
            <div class="form-row">
                <div class="form-control">
                    <label for="medicamento">Toma algum medicamento contínuo?</label>
                    <select id="remedio" name="remedio" required onchange="remedioOptions()">
                        <option value="">Selecione...</option>
                        <option value="medicamento-sim">Sim</option>
                        <option value="medicamento-nao">Não</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-control" id="remedio_nome"></div>
            </div>

            <div class="form-row">
                <div class="form-control" id="exame"></div>
            </div>
            <div class="form-row">
                <div class="form-control">
                    <label for="patologia">Paciente tem alguma patologia que trata?</label>
                    <select id="patologia" name="patologia" required onchange="patologiaOptions()">
                        <option value="">Selecione...</option>
                        <option value="patologia-sim">Sim</option>
                        <option value="patologia-nao">Não</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-control" id="patologia_nome"></div>
            </div>
            
            <input type="hidden" id="exameTexto" name="exameTexto">


            <div class="buttons">
                <button type="submit" class="btn-primary">Cadastrar Paciente</button>
            </div>
        </form>
    </div>
    <script src="./js/cadastropaciente.js"></script>
</body>

</html>

