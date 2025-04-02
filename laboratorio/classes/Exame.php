<?php 

require_once 'Paciente.php';

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