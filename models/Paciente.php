<?php
// classes/Paciente.php
class Paciente
{
    private $id, $nome, $dataNascimento, $telefone, $email, $nomeMae, $idade, $medicamento, $patologia;

    public function __construct($id, $nome, $dataNascimento, $telefone, $email, $nomeMae, $idade, $medicamento, $patologia)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->nomeMae = $nomeMae;
        $this->idade = $idade;
        $this->medicamento = $medicamento;
        $this->patologia = $patologia;
    }

    // Getters
    public function getIdPaciente() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getDataNascimento() { return $this->dataNascimento; }
    public function getTelefone() { return $this->telefone; }
    public function getEmail() { return $this->email; }
    public function getNomeMae() { return $this->nomeMae; }
    public function getIdade() { return $this->idade; }
    public function getMedicamento() { return $this->medicamento; }
    public function getPatologia() { return $this->patologia; }


    // Setters 
    public function setId($id) { $this->id = $id; }
    public function setNome($nome) { $this->nome = $nome; }
    public function setDataNascimento($dataNascimento) { $this->dataNascimento = $dataNascimento; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }
    public function setEmail($email) { $this->email = $email; }
    public function setNomeMae($nomeMae) { $this->nomeMae = $nomeMae; }
    public function setIdade($idade) { $this->idade = $idade; }
    public function setMedicamento($medicamento) { $this->medicamento = $medicamento; }
    public function setPatologia($patologia) { $this->patologia = $patologia; }

}

