// Máscara para o telefone
document.getElementById('telefone').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
        value = value.replace(/(\d)(\d{4})$/, '$1-$2');
        e.target.value = value;
    }
});

function exameoptions() {
    let examesolicitado = document.getElementById('examesolicitado').value;
    let exameDiv = document.getElementById('exame');
    let exameTexto = document.getElementById('exameTexto'); // Campo oculto onde vamos salvar o texto do exame

    exameDiv.innerHTML = "";

    if (examesolicitado === "microbiologia") {
        exameDiv.innerHTML = `
            <label for="exame">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="micro1">Urocultura com antibiograma</option>
                <option value="micro2">Swab ocular</option>
                <option value="micro3">Escarro para exame de Micobacterium tuberculosis</option>
            </select>
        `;
    } else if (examesolicitado === "parasitologia") {
        exameDiv.innerHTML = `
            <label for="exame">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="para1">Exame parasitológico de fezes</option>
                <option value="para2">Sangue oculto</option>
            </select>
        `;
    } else if (examesolicitado === "hematologia") {
        exameDiv.innerHTML = `
            <label for="exame">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="hemato1">Hemograma completo</option>
                <option value="hemato2">Outros exames de hematologia</option>
            </select>
        `;
    } else if (examesolicitado === "bioquímica") {
        exameDiv.innerHTML = `
            <label for="exame">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="bio1">Ácido úrico</option>
                <option value="bio2">Alfa amilase</option>
                <option value="bio3">Bilirrubina Total</option>
                <option value="bio4">Bilirrubina Direta</option>
                <option value="bio5">Cálcio</option>
                <option value="bio6">Colesterol</option>
                <option value="bio7">HDL</option>
                <option value="bio8">Creatinina</option>
                <option value="bio9">Ferro Ferene</option>
                <option value="bio10">Fosfatase Alcalina</option>
                <option value="bio11">Fosfato</option>
                <option value="bio12">Gama GT</option>
                <option value="bio13">Glicose</option>
                <option value="bio14">GOT (AST)</option>
                <option value="bio15">GTP (ALT)</option>
                <option value="bio16">Magnésio</option>
                <option value="bio17">Proteína total</option>
                <option value="bio18">Triglicerídeos</option>
                <option value="bio19">Uréia</option>
            </select>
        `;
    } else if (examesolicitado === "urinálise") {
        exameDiv.innerHTML = `
            <label for="exame">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="urina">Urina 1</option>
            </select>
        `;
    }

    // Adiciona um evento para capturar o texto da opção selecionada
    document.getElementById('exameSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        exameTexto.value = selectedOption.text; // Atualiza o campo oculto com o texto selecionado
    });
}



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

