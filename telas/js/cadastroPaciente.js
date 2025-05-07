// Máscara para o telefone
document.getElementById('telefone').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
        value = value.replace(/(\d)(\d{4})$/, '$1-$2');
        e.target.value = value;
    }
});


function medicamento(show) {
document.getElementById("medicamentoNome").style.display = show ? "block" : "none";
}

function validateForm(event) {
return true;
}

function remedioOptions() {
let medicamentoValue = document.getElementById('remedio').value;
let remedioNomeDiv = document.getElementById('remedio_nome');

remedioNomeDiv.innerHTML = "";

if (medicamentoValue === "medicamento-sim") {
remedioNomeDiv.innerHTML = `
    <label for="nome_medicamento">Nome Medicamento:</label>
    <input type="text" id="nome_medicamento" name="nome_medicamento" required>
`;
}
}

function patologiaOptions() {
let patologiaValue = document.getElementById('patologia').value;
let patologiaNomeDiv = document.getElementById('patologia_nome');

patologiaNomeDiv.innerHTML = "";

if (patologiaValue === "patologia-sim") {
patologiaNomeDiv.innerHTML = `
    <label for="patologia_nome">Nome Patologia:</label>
    <input type="text" id="patologia_nome" name="patologia_nome" required>
`;
}
}

// Atualiza o campo oculto com o texto do exame selecionado
function updateExameTexto() {
    let exameTexto = getTextoExameSelecionado();
    document.getElementById('exameTexto').value = exameTexto;
}

// Chama a função quando o exame for alterado
document.getElementById('exameSelect').addEventListener('change', updateExameTexto);

