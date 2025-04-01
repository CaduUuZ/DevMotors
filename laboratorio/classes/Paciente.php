<?php
class Paciente {
    public $registro;
    public $data;
    public $periodo;
    public $nomeCompleto;
    public $dataNascimento;
    public $telefone;
    public $email;
    public $nomeMae;
    public $exameSolicitado;
    public $medicamento;
    public $patologia;

    public function __construct($registro, $data, $periodo, $nomeCompleto, $dataNascimento, $telefone, $email, $nomeMae, $exameSolicitado, $medicamento, $patologia) {
        $this->registro = $registro;
        $this->data = $data;
        $this->periodo = $periodo;
        $this->nomeCompleto = $nomeCompleto;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->nomeMae = $nomeMae;
        $this->exameSolicitado = $exameSolicitado;
        $this->medicamento = $medicamento;
        $this->patologia = $patologia;
    }

    public function exibirInformacoes() {
        return [
            'Registro' => $this->registro,
            'Data' => $this->data,
            'Período' => $this->periodo,
            'Nome Completo' => $this->nomeCompleto,
            'Data de Nascimento' => $this->dataNascimento,
            'Telefone' => $this->telefone,
            'Email' => $this->email,
            'Nome da Mãe' => $this->nomeMae,
            'Exame Solicitado' => $this->exameSolicitado,
            'Medicamento' => $this->medicamento,
            'Patologia' => $this->patologia
        ];
    }
}
?>
