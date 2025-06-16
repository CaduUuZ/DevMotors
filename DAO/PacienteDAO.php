<?php

require_once '../models/Paciente.php';
require_once '../config/db.php';

class PacienteDAO
{
    private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // ADICIONAR/SALVAR PACIENTE
    public function salvar(Paciente $paciente)
    {
        // Verifica duplicidade de e-mail
        if (!empty($paciente->getEmail())) {
            $verificaEmail = "SELECT COUNT(*) as total FROM pacientes WHERE email = ?";
            $stmt = $this->conn->prepare($verificaEmail);
            $emailCheck = $paciente->getEmail();
            $stmt->bind_param("s", $emailCheck);
            $stmt->execute();
            $result = $stmt->get_result();
            $dados = $result->fetch_assoc();

            if ($dados['total'] > 0) {
                throw new Exception("Este e-mail já está cadastrado no sistema.");
            }
        }

        // Variáveis para bind_param
        $idPaciente = $paciente->getIdPaciente();
        $nome = $paciente->getNome();
        $dataNascimento = $paciente->getDataNascimento();
        $idade = $paciente->getIdade();
        $telefone = $paciente->getTelefone();
        $email = $paciente->getEmail();
        $nomeMae = $paciente->getNomeMae();
        $medicamento = $paciente->getMedicamento() ?? '';
        $patologia = $paciente->getPatologia() ?? '';

        $sql = "INSERT INTO pacientes (
            idPaciente, nomeCompleto, dataNascimento, idade, telefone, email, nomeMae, nomeMedicamento, nomePatologia
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssisssss",
            $idPaciente,
            $nome,
            $dataNascimento,
            $idade,
            $telefone,
            $email,
            $nomeMae,
            $medicamento,
            $patologia
        );

        $stmt->execute();
    }

    // BUSCA PACIENTE POR ID
    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM pacientes WHERE idPaciente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $dados = $result->fetch_assoc();
            return new Paciente(
                $dados['idPaciente'],
                $dados['nomeCompleto'],
                $dados['dataNascimento'],
                $dados['telefone'],
                $dados['email'],
                $dados['nomeMae'],
                $dados['idade'],
                $dados['nomeMedicamento'],
                $dados['nomePatologia']
            );
        }

        return null; // Retorna null se não encontrar o paciente
    }

    // EXCLUIR PACIENTE
    public function excluir($id)
    {
        if (empty($id) || !is_string($id)) {
            throw new Exception("ID inválido para exclusão.");
        }
    
        $sql = "DELETE FROM pacientes WHERE idPaciente = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $this->conn->error);
        }
    
        $stmt->bind_param("s", $id);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao excluir paciente: " . $stmt->error);
        }
    }
    

    // ATUALIZAR PACIENTE
    public function atualizar(Paciente $paciente)
    {
        // Variáveis para bind_param
        $nome = $paciente->getNome();
        $dataNascimento = $paciente->getDataNascimento();
        $idade = $paciente->getIdade();
        $telefone = $paciente->getTelefone();
        $email = $paciente->getEmail();
        $nomeMae = $paciente->getNomeMae();
        $medicamento = $paciente->getMedicamento() ?? '';
        $patologia = $paciente->getPatologia() ?? '';
        $idPaciente = $paciente->getIdPaciente();

        $sql = "UPDATE pacientes SET 
            nomeCompleto = ?, 
            dataNascimento = ?, 
            idade = ?, 
            telefone = ?, 
            email = ?, 
            nomeMae = ?, 
            nomeMedicamento = ?, 
            nomePatologia = ? 
        WHERE idPaciente = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssisssssi",
            $nome,
            $dataNascimento,
            $idade,
            $telefone,
            $email,
            $nomeMae,
            $medicamento,
            $patologia,
            $idPaciente
        );

        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar paciente: " . $stmt->error);
        }
    }

    // BUSCAR PACIENTE POR NOME
    public function buscarPorNome($nome)
    {
        $sql = "SELECT * FROM pacientes WHERE nomeCompleto LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $nomeBusca = '%' . $nome . '%';
        $stmt->bind_param("s", $nomeBusca);
        $stmt->execute();
        $result = $stmt->get_result();
        $pacientes = [];

        while ($dados = $result->fetch_assoc()) {
            $pacientes[] = new Paciente(
                $dados['idPaciente'],
                $dados['nomeCompleto'],
                $dados['dataNascimento'],
                $dados['telefone'],
                $dados['email'],
                $dados['nomeMae'],
                $dados['idade'],
                $dados['nomeMedicamento'],
                $dados['nomePatologia']
            );
        }

        return $pacientes;
    }

    // BUSCAR TODOS PACIENTES
    public function buscarTodos()
    {
        $sql = "SELECT * FROM pacientes ORDER BY nomeCompleto ASC";
        $result = $this->conn->query($sql);

        $pacientes = [];

        while ($dados = $result->fetch_assoc()) {
            $pacientes[] = new Paciente(
                $dados['idPaciente'],
                $dados['nomeCompleto'],
                $dados['dataNascimento'],
                $dados['telefone'],
                $dados['email'],
                $dados['nomeMae'],
                $dados['idade'],
                $dados['nomeMedicamento'],
                $dados['nomePatologia']
            );
        }

        return $pacientes;
    }
}
