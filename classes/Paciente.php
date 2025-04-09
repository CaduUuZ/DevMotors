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


    public function getId()
    {
        return $this->id;
    }
    public function salvar($conn)
    {
        //verifica se o e-mail já existe
        if (!empty($this->email)) {
            $verificaEmail = "SELECT COUNT(*) as total FROM pacientes WHERE email = ?";
            $stmt = $conn->prepare($verificaEmail);
            $stmt->bind_param("s", $this->email);
            $stmt->execute();
            $result = $stmt->get_result();
            $dados = $result->fetch_assoc();

            if ($dados['total'] > 0) {
                throw new Exception("Este e-mail já está cadastrado no sistema.");
            }
        }

        $sql = "INSERT INTO pacientes (
            idPaciente, nomeCompleto, dataNascimento, idade, telefone, email, nomeMae, nomeMedicamento, nomePatologia
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        $medicamento = $this->medicamento ?? '';
        $patologia = $this->patologia ?? '';
        
        $stmt->bind_param("sssisssss", 
            $this->id, 
            $this->nome, 
            $this->dataNascimento, 
            $this->idade,
            $this->telefone, 
            $this->email, 
            $this->nomeMae, 
            $medicamento, 
            $patologia
        );
        
        $stmt->execute();
        
    }
}
