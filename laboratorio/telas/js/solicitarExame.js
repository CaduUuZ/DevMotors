function exameoptions() {
    let lab = document.getElementById('lab').value;
    let exameDiv = document.getElementById('exame');
    let exameTexto = document.getElementById('exameTexto');


    exameDiv.innerHTML = "";

    if (!lab) {
        return;
    }

    let exames = {
        microbiologia: `
            <label for="exameSelect">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="micro1">Urocultura com antibiograma</option>
                <option value="micro2">Swab ocular</option>
                <option value="micro3">Escarro para exame de Micobacterium tuberculosis</option>
            </select>
        `,
        parasitologia: `
            <label for="exameSelect">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="para1">Exame parasitológico de fezes</option>
                <option value="para2">Sangue oculto</option>
            </select>
        `,
        hematologia: `
            <label for="exameSelect">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="hemato1">Hemograma completo</option>
                <option value="hemato2">Outros exames de hematologia</option>
            </select>
        `,
        bioquímica: `
            <label for="exameSelect">Escolha o exame:</label>
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
        `,
        urinálise: `
            <label for="exameSelect">Escolha o exame:</label>
            <select id="exameSelect" name="exame" required>
                <option value="">Selecione...</option>
                <option value="urina">Urina 1</option>
            </select>
        `
    };

    exameDiv.innerHTML = exames[lab] || "";

    setTimeout(() => {
        let exameSelect = document.getElementById('exameSelect');
        if (exameSelect) {
            exameSelect.addEventListener('change', function () {
                let selectedOption = this.options[this.selectedIndex];
                exameTexto.value = selectedOption.text;
            });
        }
    }, 100);
}

document.addEventListener('DOMContentLoaded', function () {
    const labSelect = document.getElementById('lab');
    if (labSelect) {
        labSelect.addEventListener('change', exameoptions);
    }

    const form = document.getElementById('exameForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            console.log('Formulário enviado!');
        });
    }
});
