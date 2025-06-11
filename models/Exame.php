<?php

require_once 'Paciente.php';

class Exame {
    private $idExame;
    private $paciente; // Objeto Paciente
    private $laboratorio;
    private $exameTexto;
    private $dataExame;
    private $resultado;

    public function __construct(Paciente $paciente, $laboratorio, $exameTexto, $idExame = null, $dataExame = null, $resultado = null) {
        $this->paciente = $paciente;
        $this->laboratorio = $laboratorio;
        $this->exameTexto = $exameTexto;
        $this->idExame = $idExame;
    }

    // Getters e Setters
    public function getIdExame() {
        return $this->idExame;
    }

    public function setIdExame($idExame) {
        $this->idExame = $idExame;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function setPaciente(Paciente $paciente) {
        $this->paciente = $paciente;
    }

    public function getLaboratorio() {
        return $this->laboratorio;
    }

    public function setLaboratorio($laboratorio) {
        $this->laboratorio = $laboratorio;
    }

    public function getExameTexto() {
        return $this->exameTexto;
    }

    public function setExameTexto($exameTexto) {
        $this->exameTexto = $exameTexto;
    }

    public function getDataExame() {
        return $this->dataExame;
    }

    public function setDataExame($dataExame) {
        $this->dataExame = $dataExame;
    }

    public function getResultado() {
        return $this->resultado;
    }

    public function setResultado($resultado) {
        $this->resultado = $resultado;
    }

    // Método salvar usando conexão (pode ser usado ou substituído pelo DAO)
    public function salvar($conn) {
        $sql = "INSERT INTO exames (idPaciente, laboratorio, exameTexto) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $conn->error);
        }

        $idPaciente = $this->paciente->getIdPaciente();

        $stmt->bind_param("sss", $idPaciente, $this->laboratorio, $this->exameTexto);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao salvar exame: " . $stmt->error);
        }

        $this->idExame = $stmt->insert_id; // Pega o ID gerado no banco

        $stmt->close();
    }
}
