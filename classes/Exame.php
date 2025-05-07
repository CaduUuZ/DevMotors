<?php
// classes/Exame.php
require_once 'Paciente.php';

class Exame {
    public $paciente;
    public $laboratorio;
    public $exameTexto;

    public function __construct(Paciente $paciente, $laboratorio, $exameTexto) {
        $this->paciente = $paciente;
        $this->laboratorio = $laboratorio;
        $this->exameTexto = $exameTexto;
    }

    public function salvar($conn) {
        // Inserir exame na tabela com os nomes corretos de coluna
        $sql = "INSERT INTO exames (idPaciente, laboratorio, exameTexto) 
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        // Variável auxiliar para o ID do paciente
        $pacienteId = $this->paciente->getId();

        // Associar os valores
        $stmt->bind_param("sss", $pacienteId, $this->laboratorio, $this->exameTexto);

        // Executar
        if (!$stmt->execute()) {
            throw new Exception("Erro ao salvar exame: " . $stmt->error);
        }
    }
}
