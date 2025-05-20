<?php
// classes/Paciente.php

// Definição da classe Paciente
class Paciente
{
    // Declaração de propriedades privadas da classe
    private $id, $nome, $dataNascimento, $telefone, $email, $nomeMae, $idade, $medicamento, $patologia;

    // Construtor da classe para inicializar as propriedades
    public function __construct($id, $nome, $dataNascimento, $telefone, $email, $nomeMae, $idade, $medicamento, $patologia)
    {
        $this->id = $id; // ID do paciente
        $this->nome = $nome; // Nome completo do paciente
        $this->dataNascimento = $dataNascimento; // Data de nascimento do paciente
        $this->telefone = $telefone; // Telefone do paciente
        $this->email = $email; // E-mail do paciente
        $this->nomeMae = $nomeMae; // Nome da mãe do paciente
        $this->idade = $idade; // Idade do paciente
        $this->medicamento = $medicamento; // Medicamento associado ao paciente
        $this->patologia = $patologia; // Patologia associada ao paciente
    }

    // Método para obter o ID do paciente
    public function getId()
    {
        return $this->id;
    }

    // Método para salvar os dados do paciente no banco de dados
    public function salvar($conn)
    {
        // Verifica se o e-mail já existe no banco de dados
        if (!empty($this->email)) {
            $verificaEmail = "SELECT COUNT(*) as total FROM pacientes WHERE email = ?"; // Consulta SQL para verificar duplicidade de e-mail
            $stmt = $conn->prepare($verificaEmail); // Prepara a consulta
            $stmt->bind_param("s", $this->email); // Substitui o placeholder pelo e-mail do paciente
            $stmt->execute(); // Executa a consulta
            $result = $stmt->get_result(); // Obtém o resultado da consulta
            $dados = $result->fetch_assoc(); // Extrai os dados do resultado

            // Se o e-mail já estiver cadastrado, lança uma exceção
            if ($dados['total'] > 0) {
                throw new Exception("Este e-mail já está cadastrado no sistema.");
            }
        }

        // Consulta SQL para inserir os dados do paciente no banco de dados
        $sql = "INSERT INTO pacientes (
            idPaciente, nomeCompleto, dataNascimento, idade, telefone, email, nomeMae, nomeMedicamento, nomePatologia
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql); // Prepara a consulta SQL para inserção
        
        // Define valores padrão para medicamento e patologia caso estejam nulos
        $medicamento = $this->medicamento ?? '';
        $patologia = $this->patologia ?? '';
        
        // Substitui os placeholders pelos valores das propriedades do objeto
        $stmt->bind_param("sssisssss", 
            $this->id, // ID do paciente
            $this->nome, // Nome completo do paciente
            $this->dataNascimento, // Data de nascimento do paciente
            $this->idade, // Idade do paciente
            $this->telefone, // Telefone do paciente
            $this->email, // E-mail do paciente
            $this->nomeMae, // Nome da mãe do paciente
            $medicamento, // Medicamento associado ao paciente
            $patologia // Patologia associada ao paciente
        );
        
        $stmt->execute(); // Executa a consulta para salvar os dados no banco de dados
    }
}
