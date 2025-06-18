class Paciente {
    constructor(id, nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia) {
      this.id = id;
      this.nome = nome;
      this.dataNascimento = dataNascimento;
      this.telefone = telefone;
      this.email = email;
      this.nomeMae = nomeMae;
      this.idade = idade;
      this.medicamento = medicamento;
      this.patologia = patologia;
    }
  }
  
  module.exports = Paciente;
  