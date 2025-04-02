<?php 

require_once 'Paciente.php';
require_once '../processamento/pacienteDados';

class Exame{
    //private $idExame;
    public $paciente;
    public $laboratorio;
    public $medicamento;
    public $patologia;
    public $exameTexto;

    public function __construct(/*$idExame,*/ Paciente $paciente, $laboratorio, $medicamento, $patologia, $exameTexto) {
        //$this->idExame = $idExame;
        $this->paciente = $paciente;
        $this->laboratorio = $laboratorio;
        $this->medicamento = $medicamento;
        $this->patologia = $patologia;
        $this->exameTexto = $exameTexto;
    }
    
}





?>