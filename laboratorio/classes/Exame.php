<?php 

require_once 'Paciente.php';
require_once '../processamento/pacienteDados';

class Exame{
    //private $idExame;
    public $paciente;
    public $laboratorio;
    public $exameTexto;

    public function __construct(/*$idExame,*/ Paciente $paciente, $laboratorio,$exameTexto) {
        //$this->idExame = $idExame;
        $this->paciente = $paciente;
        $this->laboratorio = $laboratorio;
        $this->exameTexto = $exameTexto;
    }
    
}





?>