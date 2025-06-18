class Exame {
    constructor({ idExame = null, paciente, laboratorio, exameTexto, dataExame = null, resultado = null }) {
      this.idExame = idExame;
      this.paciente = paciente; // objeto Paciente
      this.laboratorio = laboratorio;
      this.exameTexto = exameTexto;
      this.dataExame = dataExame;
      this.resultado = resultado;
    }
  }
  
  module.exports = Exame;
  