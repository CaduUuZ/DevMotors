<?php 

require_once 'Paciente.php';
require_once '../processamento/pacienteDados';

class Exame{
    //private $idExame;
    public $paciente;
    public $exameSolicitado;
    public $medicamento;
    public $patologia;
    public $exameTexto;

    public function __construct(/*$idExame,*/ Paciente $paciente, $exameSolicitado, $medicamento, $patologia, $exameTexto) {
        //$this->idExame = $idExame;
        $this->paciente = $paciente;
        $this->exameSolicitado = $exameSolicitado;
        $this->medicamento = $medicamento;
        $this->patologia = $patologia;
        $this->exameTexto = $exameTexto;
    }
    
}





?>