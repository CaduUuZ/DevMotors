<?php
require_once '../models/Exame.php';
require_once '../models/Paciente.php';

class ExameDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Salvar novo exame
    public function salvar(Exame $exame) {
        $sql = "INSERT INTO exames (idPaciente, laboratorio, exameTexto) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $this->conn->error);
        }

        $idPaciente = $exame->getPaciente()->getIdPaciente();
        $laboratorio = $exame->getLaboratorio();
        $exameTexto = $exame->getExameTexto();

        $stmt->bind_param("sss", $idPaciente, $laboratorio, $exameTexto);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao salvar exame: " . $stmt->error);
        }

        $exame->setIdExame($stmt->insert_id);
        $stmt->close();
    }

    // Buscar exame por ID
    public function buscarPorId($idExame) {
        $sql = "SELECT e.*, 
                       p.idPaciente, p.nome, p.dataNascimento, p.idade, 
                       p.telefone, p.email, p.nomeMae, p.Medicamento, p.Patologia
                FROM exames e
                JOIN pacientes p ON e.idPaciente = p.idPaciente
                WHERE e.idExame = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idExame);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao buscar exame: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) return null;

        $paciente = new Paciente(
            $row['idPaciente'],
            $row['nome'],
            $row['dataNascimento'],
            $row['telefone'],
            $row['email'],
            $row['nomeMae'],
            $row['idade'],
            $row['Medicamento'],
            $row['Patologia']
        );

        $exame = new Exame($paciente, $row['laboratorio'], $row['exameTexto'], $row['idExame']);
        $exame->setDataExame($row['dataExame']);
        $exame->setResultado($row['resultado']);

        return $exame;
    }

    // Buscar todos os exames
    public function buscarTodos() {
        $sql = "SELECT e.idExame, e.exameTexto, e.dataExame, e.resultado, e.laboratorio,
                       p.idPaciente, p.nome, p.dataNascimento, p.idade, 
                       p.telefone, p.email, p.nomeMae, p.Medicamento, p.Patologia
                FROM exames e
                JOIN pacientes p ON e.idPaciente = p.idPaciente
                ORDER BY e.dataExame DESC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao buscar exames: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $exames = [];

        while ($row = $result->fetch_assoc()) {
            $paciente = new Paciente(
                $row['idPaciente'],
                $row['nomeCompleto'],
                $row['dataNascimento'],
                $row['telefone'],
                $row['email'],
                $row['nomeMae'],
                $row['idade'],
                $row['Medicamento'],
                $row['Patologia']
            );

            $exame = new Exame($paciente, $row['laboratorio'], $row['exameTexto'], $row['idExame']);
            $exame->setDataExame($row['dataExame']);
            $exame->setResultado($row['resultado']);

            $exames[] = $exame;
        }

        return $exames;
    }

    // Excluir exame por ID
    public function excluir($idExame) {
        $sql = "DELETE FROM exames WHERE idExame = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idExame);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao excluir exame: " . $stmt->error);
        }

        return true;
    }

    // Atualizar resultado do exame
    public function atualizarResultado($idExame, $resultado) {
        $sql = "UPDATE exames SET resultado = ? WHERE idExame = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $resultado, $idExame);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar resultado: " . $stmt->error);
        }

        return true;
    }

    // Buscar exames por ID de paciente
    public function buscarPorPacienteId($idPaciente) {
        $sql = "SELECT e.idExame, e.exameTexto, e.dataExame, e.resultado, e.laboratorio,
                       p.idPaciente, p.nome, p.dataNascimento, p.idade, 
                       p.telefone, p.email, p.nomeMae, p.Medicamento, p.Patologia
                FROM exames e
                JOIN pacientes p ON e.idPaciente = p.idPaciente
                WHERE p.idPaciente LIKE ?
                ORDER BY e.dataExame DESC";

        $stmt = $this->conn->prepare($sql);
        $like = "%" . $idPaciente . "%";
        $stmt->bind_param("s", $like);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao buscar exames por paciente: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $exames = [];

        while ($row = $result->fetch_assoc()) {
            $paciente = new Paciente(
                $row['idPaciente'],
                $row['nome'],
                $row['dataNascimento'],
                $row['telefone'],
                $row['email'],
                $row['nomeMae'],
                $row['idade'],
                $row['Medicamento'],
                $row['Patologia']
            );

            $exame = new Exame($paciente, $row['laboratorio'], $row['exameTexto'], $row['idExame']);
            $exame->setDataExame($row['dataExame']);
            $exame->setResultado($row['resultado']);

            $exames[] = $exame;
        }

        return $exames;
    }

    // Buscar exames por paciente (usando ID)
    public function buscarPorPaciente($idPaciente)
{
    $sql = "SELECT e.idExame, e.exameTexto, e.dataExame, e.resultado, 
                   p.idPaciente, p.nome, p.idade
            FROM exames e
            JOIN pacientes p ON e.idPaciente = p.idPaciente
            WHERE p.idPaciente = ?
            ORDER BY e.dataExame DESC";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $this->conn->error);
    }

    $stmt->bind_param("s", $idPaciente);

    if (!$stmt->execute()) {
        throw new Exception("Erro ao buscar exames por paciente: " . $stmt->error);
    }

    $result = $stmt->get_result();

    $exames = [];
    while ($row = $result->fetch_assoc()) {
        $paciente = new Paciente(
            $row['idPaciente'],
            $row['nome'],
            null, null, null, null,
            $row['idade'],
            null, null
        );

        $exame = new Exame($paciente, null, $row['exameTexto']);
        $exame->setIdExame($row['idExame']);
        $exame->setDataExame($row['dataExame']);
        $exame->setResultado($row['resultado']);

        $exames[] = $exame;
    }

    return $exames;
}

}
