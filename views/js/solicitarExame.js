// Função para atualizar as opções de exames com base no laboratório selecionado
function exameoptions() {
    // Obtém o valor selecionado no campo de laboratório
    let laboratorio = document.getElementById('laboratorio').value;

    // Obtém o elemento onde as opções de exames serão inseridas
    let labDiv = document.getElementById('lab');

    // Obtém o campo de texto onde será exibido o nome do exame selecionado
    let exameTexto = document.getElementById('exameTexto');

    // Limpa o conteúdo atual do elemento de opções de exames
    labDiv.innerHTML = "";

    // Verifica qual laboratório foi selecionado e insere as opções correspondentes
    if (laboratorio === "microbiologia") {
        labDiv.innerHTML = `
            <label for="lab">Escolha o exame:</label>
            <select id="exameSelect" name="lab" required>
                <option value="">Selecione...</option>
                <option value="micro1">Urocultura com antibiograma</option>
                <option value="micro2">Swab ocular</option>
                <option value="micro3">Escarro para exame de Micobacterium tuberculosis</option>
            </select>
        `;
    } else if (laboratorio === "parasitologia") {
        labDiv.innerHTML = `
            <label for="lab">Escolha o exame:</label>
            <select id="exameSelect" name="lab" required>
                <option value="">Selecione...</option>
                <option value="para1">Exame parasitológico de fezes</option>
                <option value="para2">Sangue oculto</option>
            </select>
        `;
    } else if (laboratorio === "hematologia") {
        labDiv.innerHTML = `
            <label for="lab">Escolha o exame:</label>
            <select id="exameSelect" name="lab" required>
                <option value="">Selecione...</option>
                <option value="hemato1">Hemograma completo</option>
                <option value="hemato2">Outros exames de hematologia</option>
            </select>
        `;
    } else if (laboratorio === "bioquímica") {
        labDiv.innerHTML = `
            <label for="lab">Escolha o exame:</label>
            <select id="exameSelect" name="lab" required>
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
    } else if (laboratorio === "urinálise") {
        labDiv.innerHTML = `
            <label for="lab">Escolha o exame:</label>
            <select id="exameSelect" name="lab" required>
                <option value="">Selecione...</option>
                <option value="urina">Urina 1</option>
            </select>
        `;
    }

    // Adiciona um evento para capturar o texto da opção selecionada
    document.getElementById('exameSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        exameTexto.value = selectedOption.text;
    });
}

