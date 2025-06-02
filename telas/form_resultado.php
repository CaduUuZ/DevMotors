<?php
// Inclui o arquivo de configuração do banco de dados
require_once('../config/db.php');

// Verifica se o ID do exame foi informado
if (!isset($_GET['idExame'])) {
    echo "ID do exame não informado.";
    exit;
}

// Obtém o ID do exame da URL
$idExame = $_GET['idExame'];

// Consulta SQL para buscar os dados do exame e do paciente
$sql = "SELECT e.idExame, e.exameTexto, e.resultado, e.dataExame,
               p.nomeCompleto, p.idade, p.idPaciente
        FROM exames e
        JOIN pacientes p ON e.idPaciente = p.idPaciente
        WHERE e.idExame = ?";

// Prepara e executa a consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $idExame);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o exame foi encontrado
if ($result->num_rows === 0) {
    echo "Exame não encontrado.";
    exit;
}

// Obtém os dados do exame
$exame = $result->fetch_assoc();

// Função para processar salvamento dos dados adicionais
if ($_POST && isset($_POST['salvar_informacoes'])) {
    $informacoesAdicionais = json_encode($_POST['campos']);
    
    $updateSql = "UPDATE exames SET informacoesAdicionais = ? WHERE idExame = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $informacoesAdicionais, $idExame);
    
    if ($updateStmt->execute()) {
        $mensagemSucesso = "Informações salvas com sucesso!";
    } else {
        $mensagemErro = "Erro ao salvar informações.";
    }
}

// Buscar informações adicionais já salvas
$infoSql = "SELECT informacoesAdicionais FROM exames WHERE idExame = ?";
$infoStmt = $conn->prepare($infoSql);
$infoStmt->bind_param("i", $idExame);
$infoStmt->execute();
$infoResult = $infoStmt->get_result();
$infoData = $infoResult->fetch_assoc();
$informacoesSalvas = $infoData['informacoesAdicionais'] ? json_decode($infoData['informacoesAdicionais'], true) : [];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Laudo do Exame</title>
    <link rel="stylesheet" href="css/solicitarExame.css">
    <link rel="stylesheet" href="css/form_resultado.css">
</head>
<body>
    <div class="laudo-box">
        <?php if (isset($mensagemSucesso)): ?>
            <div class="mensagem mensagem-sucesso"><?= $mensagemSucesso ?></div>
        <?php endif; ?>
        
        <?php if (isset($mensagemErro)): ?>
            <div class="mensagem mensagem-erro"><?= $mensagemErro ?></div>
        <?php endif; ?>

        <div class="laudo-header">
            <h2>Laudo Laboratorial</h2>
            <p>Emitido em: <?= date('d/m/Y H:i', strtotime($exame['dataExame'])) ?></p>
        </div>

        <div class="laudo-section">
            <strong>Paciente:</strong> <?= $exame['nomeCompleto'] ?> <br>
            <strong>ID Paciente:</strong> <?= $exame['idPaciente'] ?> <br>
            <strong>Idade:</strong> <?= $exame['idade'] ?> anos
        </div>

        <div class="laudo-section">
            <strong>Exame:</strong> <?= $exame['exameTexto'] ?>
        </div>

        <div class="laudo-section">
            <strong>Resultado:</strong>
            <div class="resultado-box"><?= nl2br($exame['resultado']) ?></div>
        </div>

        <div class="laudo-section">
            <strong>Informações Específicas do Exame:</strong>
            
            <div class="progresso">
                <div class="barra-progresso">
                    <div class="progresso-fill" id="barraProgresso" style="width: 0%"></div>
                </div>
                <div class="contador-campos" id="contadorCampos">0 de 0 campos preenchidos</div>
            </div>

            <form method="POST" id="formInformacoes">
                <div class="campos-especificos" id="camposEspecificos">
                    <!-- Campos específicos serão inseridos aqui pelo JavaScript -->
                </div>
                
                <div class="buttons">
                    <button type="submit" name="salvar_informacoes" class="btn-success">Salvar Informações</button>
                    <a href="../telas/ver_laudo.php?id=<?= $idExame ?>&print=1" target="_blank">Imprimir</a>
                    <button type="button" id="limparCampos" class="btn-secondary">Limpar Campos</button>
                </div>
            </form>
        </div>

        <div class="buttons">
            <a href="listaExames.php" class="btn-secondary">Voltar</a>
        </div>
    </div>

    <script>
        // Configuração dos campos específicos por tipo de exame
        const camposPorExame = {
            'urocultura com antibiograma': {
                'Meio de Cultura': [
                    { nome: 'agar_cled', label: 'ÁGAR CLED', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] }
                ],
                'Coloração': [
                    { nome: 'coloracao_gram', label: 'COLORAÇÃO DE GRAM', tipo: 'select', opcoes: ['Gram Positivo', 'Gram Negativo', 'Não realizado'] }
                ],
                'Testes para Gram Positivo': [
                    { nome: 'agar_manitol', label: 'ÁGAR MANITOL', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_catalase', label: 'TESTE DE CATALASE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_coagulase', label: 'TESTE DE COAGULASE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_novobiocina', label: 'TESTE DE NOVOBIOCINA', tipo: 'select', opcoes: ['Sensível', 'Resistente', 'Não realizado'] }
                ],
                'Testes para Gram Negativo': [
                    { nome: 'agar_macconkey', label: 'ÁGAR MACCONKEY', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'epm', label: 'EPM', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'mili', label: 'MILI', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'citrato', label: 'CITRATO', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] }
                ],
                'Resultado Final': [
                    { nome: 'resultado_gram_positivo', label: 'RESULTADO (Gram Positivo)', tipo: 'textarea', placeholder: 'Resultado da identificação para gram positivo' },
                    { nome: 'resultado_gram_negativo', label: 'RESULTADO (Gram Negativo)', tipo: 'textarea', placeholder: 'Resultado da identificação para gram negativo' }
                ]
            },
            'escarro para exame de micobacterium tuberculosis': {
                'Coloração Inicial': [
                    { nome: 'ziehl_nilsen', label: 'Coloração de Ziehl-Nilsen', tipo: 'select', opcoes: ['BAAR Positivo', 'BAAR Negativo', 'Não realizado'] }
                ],
                'Coloração de Gram': [
                    { nome: 'coloracao_gram', label: 'COLORAÇÃO DE GRAM', tipo: 'select', opcoes: ['BGN (Bacilo Gram Negativo)', 'BGP (Bacilo Gram Positivo)', 'Não realizado'] }
                ],
                'Testes para BGP (Bacilo Gram Positivo)': [
                    { nome: 'agar_manitol_bgp', label: 'ÁGAR MANITOL', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_catalase_bgp', label: 'TESTE DE CATALASE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_coagulase_bgp', label: 'TESTE DE COAGULASE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_novobiocina_bgp', label: 'TESTE DE NOVOBIOCINA', tipo: 'select', opcoes: ['Sensível', 'Resistente', 'Não realizado'] }
                ],
                'Testes para BGN (Bacilo Gram Negativo)': [
                    { nome: 'agar_macconkey_bgn', label: 'ÁGAR MACCONKEY', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'epm_bgn', label: 'EPM', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'mili_bgn', label: 'MILI', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'citrato_bgn', label: 'CITRATO', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] }
                ],
                'Resultado Final': [
                    { nome: 'resultado_bgp', label: 'RESULTADO (BGP)', tipo: 'textarea', placeholder: 'Resultado da identificação para BGP' },
                    { nome: 'resultado_bgn', label: 'RESULTADO (BGN)', tipo: 'textarea', placeholder: 'Resultado da identificação para BGN' }
                ]
            },
            'swab ocular': {
                'Meio de Cultura': [
                    { nome: 'agar_sangue', label: 'ÁGAR SANGUE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'agar_chocolate', label: 'ÁGAR CHOCOLATE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] }
                ],
                'Coloração': [
                    { nome: 'coloracao_gram', label: 'COLORAÇÃO DE GRAM', tipo: 'select', opcoes: ['Gram Positivo', 'Gram Negativo', 'Não realizado'] }
                ],
                'Testes para Gram Positivo': [
                    { nome: 'agar_manitol', label: 'ÁGAR MANITOL', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_catalase', label: 'TESTE DE CATALASE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_coagulase', label: 'TESTE DE COAGULASE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_novobiocina', label: 'TESTE DE NOVOBIOCINA', tipo: 'select', opcoes: ['Sensível', 'Resistente', 'Não realizado'] }
                ],
                'Testes para Gram Negativo': [
                    { nome: 'agar_macconkey', label: 'ÁGAR MACCONKEY', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'teste_oxidase', label: 'TESTE DE OXIDASE', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'epm', label: 'EPM', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] },
                    { nome: 'citrato', label: 'CITRATO', tipo: 'select', opcoes: ['Positivo', 'Negativo', 'Não realizado'] }
                ],
                'Resultado Final': [
                    { nome: 'resultado_gram_positivo', label: 'RESULTADO (Gram Positivo)', tipo: 'textarea', placeholder: 'Resultado da identificação para gram positivo' },
                    { nome: 'resultado_gram_negativo', label: 'RESULTADO (Gram Negativo)', tipo: 'textarea', placeholder: 'Resultado da identificação para gram negativo' }
                ]
            }
        };

        // Dados salvos do PHP
        const dadosSalvos = <?= json_encode($informacoesSalvas) ?>;
        
        // Tipo de exame atual
        const tipoExame = '<?= strtolower(trim($exame['exameTexto'])) ?>';

        function criarCamposEspecificos() {
            const container = document.getElementById('camposEspecificos');
            const campos = camposPorExame[tipoExame];

            if (!campos) {
                container.innerHTML = '<p>Tipo de exame não reconhecido ou sem campos específicos configurados.</p>';
                return;
            }

            container.innerHTML = '';

            Object.keys(campos).forEach(grupo => {
                const grupoDiv = document.createElement('div');
                grupoDiv.className = 'campo-grupo';
                
                const titulo = document.createElement('h4');
                titulo.textContent = grupo;
                grupoDiv.appendChild(titulo);

                campos[grupo].forEach(campo => {
                    const campoDiv = document.createElement('div');
                    campoDiv.className = 'campo-item';

                    const label = document.createElement('label');
                    label.textContent = campo.label;
                    campoDiv.appendChild(label);

                    let input;
                    const nomeCompleto = `campos[${campo.nome}]`;

                    switch (campo.tipo) {
                        case 'select':
                            input = document.createElement('select');
                            input.name = nomeCompleto;
                            
                            const optionVazia = document.createElement('option');
                            optionVazia.value = '';
                            optionVazia.textContent = 'Selecione...';
                            input.appendChild(optionVazia);

                            campo.opcoes.forEach(opcao => {
                                const option = document.createElement('option');
                                option.value = opcao;
                                option.textContent = opcao;
                                input.appendChild(option);
                            });
                            break;

                        case 'textarea':
                            input = document.createElement('textarea');
                            input.name = nomeCompleto;
                            input.placeholder = campo.placeholder || '';
                            input.rows = 3;
                            break;

                        case 'number':
                            input = document.createElement('input');
                            input.type = 'number';
                            input.name = nomeCompleto;
                            input.placeholder = campo.placeholder || '';
                            if (campo.step) input.step = campo.step;
                            break;

                        default:
                            input = document.createElement('input');
                            input.type = 'text';
                            input.name = nomeCompleto;
                            input.placeholder = campo.placeholder || '';
                    }

                    // Carrega dados salvos
                    if (dadosSalvos && dadosSalvos[campo.nome]) {
                        input.value = dadosSalvos[campo.nome];
                        campoDiv.classList.add('campo-preenchido');
                    }

                    // Adiciona listener para atualizar status
                    input.addEventListener('input', atualizarProgresso);
                    input.addEventListener('change', function() {
                        if (this.value.trim()) {
                            campoDiv.classList.add('campo-preenchido');
                        } else {
                            campoDiv.classList.remove('campo-preenchido');
                        }
                        atualizarProgresso();
                    });

                    campoDiv.appendChild(input);
                    grupoDiv.appendChild(campoDiv);
                });

                container.appendChild(grupoDiv);
            });

            atualizarProgresso();
        }

        function atualizarProgresso() {
            const todosInputs = document.querySelectorAll('#camposEspecificos input, #camposEspecificos select, #camposEspecificos textarea');
            const preenchidos = Array.from(todosInputs).filter(input => input.value.trim() !== '');
            
            const porcentagem = todosInputs.length > 0 ? (preenchidos.length / todosInputs.length) * 100 : 0;
            
            document.getElementById('barraProgresso').style.width = porcentagem + '%';
            document.getElementById('contadorCampos').textContent = 
                `${preenchidos.length} de ${todosInputs.length} campos preenchidos`;
        }

        function limparTodosCampos() {
            if (confirm('Tem certeza que deseja limpar todos os campos?')) {
                const todosInputs = document.querySelectorAll('#camposEspecificos input, #camposEspecificos select, #camposEspecificos textarea');
                todosInputs.forEach(input => {
                    input.value = '';
                    input.closest('.campo-item').classList.remove('campo-preenchido');
                });
                atualizarProgresso();
            }
        }

        // Inicialização
        document.addEventListener('DOMContentLoaded', function() {
            criarCamposEspecificos();
            
            document.getElementById('limparCampos').addEventListener('click', limparTodosCampos);
        });
    </script>
</body>
</html>