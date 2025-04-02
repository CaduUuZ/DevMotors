<?php
class Paciente {
    private $idPaciente;
    public $dataCadastro;
    public $nomeCompleto;
    public $dataNascimento;
    public $telefone;
    public $email;
    public $nomeMae;
    public $idadePaciente;


    public function __construct($idPaciente, $dataCadastro, $nomeCompleto, $dataNascimento, $telefone, $email, $nomeMae, $idadePaciente) {
        $this->idPaciente = $idPaciente;
        $this->dataCadastro = $dataCadastro;
        $this->nomeCompleto = $nomeCompleto;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->nomeMae = $nomeMae;
        $this->idadePaciente = $idadePaciente;
    }
}
?>
