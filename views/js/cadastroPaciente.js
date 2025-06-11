// Máscara para o telefone
document.getElementById('telefone').addEventListener('input', function (e) {
    // Remove todos os caracteres não numéricos
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        // Aplica a máscara para números de telefone no formato (XX) XXXXX-XXXX
        value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
        value = value.replace(/(\d)(\d{4})$/, '$1-$2');
        e.target.value = value;
    }
});

// Função para exibir ou ocultar o campo de medicamento
function medicamento(show) {
    document.getElementById("medicamentoNome").style.display = show ? "block" : "none";
}

// Função de validação do formulário (atualmente sempre retorna true)
function validateForm(event) {
    return true;
}

// Função para exibir opções de medicamento
function remedioOptions() {
    let medicamentoValue = document.getElementById('remedio').value;
    let remedioNomeDiv = document.getElementById('remedio_nome');

    // Limpa o conteúdo do div
    remedioNomeDiv.innerHTML = "";

    // Adiciona o campo de nome do medicamento se a opção "medicamento-sim" for selecionada
    if (medicamentoValue === "medicamento-sim") {
        remedioNomeDiv.innerHTML = `
            <label for="nome_medicamento">Nome Medicamento:</label>
            <input type="text" id="nome_medicamento" name="nome_medicamento" required>
        `;
    }
}

// Função para exibir opções de patologia
function patologiaOptions() {
    let patologiaValue = document.getElementById('patologia').value;
    let patologiaNomeDiv = document.getElementById('patologia_nome');

    // Limpa o conteúdo do div
    patologiaNomeDiv.innerHTML = "";

    // Adiciona o campo de nome da patologia se a opção "patologia-sim" for selecionada
    if (patologiaValue === "patologia-sim") {
        patologiaNomeDiv.innerHTML = `
            <label for="patologia_nome">Nome Patologia:</label>
            <input type="text" id="patologia_nome" name="patologia_nome" required>
        `;
    }
}

// Atualiza o campo oculto com o texto do exame selecionado
function updateExameTexto() {
    let exameTexto = getTextoExameSelecionado(); // Obtém o texto do exame selecionado
    document.getElementById('exameTexto').value = exameTexto; // Atualiza o valor do campo oculto
}

// Chama a função quando o exame for alterado
document.getElementById('exameSelect').addEventListener('change', updateExameTexto);

