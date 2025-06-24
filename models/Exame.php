<?php

require_once __DIR__ . '/Paciente.php';

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
        $this->dataExame = $dataExame;
        $this->resultado = $resultado;
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

}
