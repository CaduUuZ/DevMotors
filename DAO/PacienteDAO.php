<?php

require_once __DIR__ . '/../models/Paciente.php';
class PacienteDAO {

    public function salvar(Paciente $paciente) {
        $url = "http://localhost:3000/pacientes";
        $dados = [
            "id" => $paciente->getIdPaciente(),
            "nome" => $paciente->getNome(),
            "dataNascimento" => $paciente->getDataNascimento(),
            "telefone" => $paciente->getTelefone(),
            "email" => $paciente->getEmail(),
            "nomeMae" => $paciente->getNomeMae(),
            "idade" => $paciente->getIdade(),
            "nomeMedicamento" => $paciente->getMedicamento(),
            "nomePatologia" => $paciente->getPatologia()
        ];

        $options = [
            "http" => [
                "header"  => "Content-Type: application/json\r\n",
                "method"  => "POST",
                "content" => json_encode($dados)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result ? json_decode($result, true) : false;
    }

    // Executa SELECT * FROM no banco
    public function read(){
        $url = "http://localhost:3000/fabricantes";
        $result = file_get_contents($url);
        $pacienteList = array();
        $lista = json_decode($result, true);
        foreach ($lista as $pacienteList):
            $pacienteList[] = $this->listaPaciente($pacienteList);
        endforeach;
        return $pacienteList;
    }

    // Converter uma linha em obj
    public function listaPaciente($row){
        $paciente = new Paciente(
            htmlspecialchars($row['idPaciente']),
            htmlspecialchars($row['nome']),
            htmlspecialchars($row['dataNascimento']),
            htmlspecialchars($row['telefone']),
            htmlspecialchars($row['email']),
            htmlspecialchars($row['nomeMae']),
            htmlspecialchars($row['idade']),
            htmlspecialchars(isset($row['Medicamento']) ? $row['Medicamento'] : ''),
            htmlspecialchars(isset($row['Patologia']) ? $row['Patologia'] : '')
        );
        return $paciente;
    }

    public function editar(Paciente $paciente){
        $url = "http://localhost:3000/pacientes/".$paciente->getId();
        $dados = [
            "nome" => $paciente->getNome(),
            "dataNascimento" => $paciente->getDataNascimento(),
            "telefone" => $paciente->getTelefone(),
            "email" => $paciente->getEmail(),
            "nomeMae" => $paciente->getNomeMae(),
            "idade" => $paciente->getIdade(),
            "nomeMedicamento" => $paciente->getMedicamento(),
            "nomePatologia" => $paciente->getPatologia()
            
        ];

        $options = [
            "http" => [
                "header"  => "Content-Type: application/json\r\n",
                "method"  => "PUT",
                "content" => json_encode($dados)
                //,"ignore_errors" => true
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        if ($result === FALSE) {
            return ["erro" => "Falha na requisição PATCH"];
        }

        return json_decode($result, true);
    }

    public function buscarPorId($idPaciente){
        $url = "http://localhost:3000/pacientes/" . urlencode($idPaciente);
        try {
            // @file_get_contents() para evitar warnings automáticos.
            $response = @file_get_contents($url);
            if ($response === FALSE) {
                return null; // ID não encontrado ou erro na requisição
            }
            $data = json_decode($response, true);
            if ($data) {
                return $this->listaPaciente($data);
            }
            return null;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar fabricante por ID: </p> <p>{$e->getMessage()}</p>";
            return null;
        }
    }

    public function buscarPorNome($nome){
        $url = "http://localhost:3000/pacientes?nome=" . urlencode($nome);
        try {
            $response = @file_get_contents($url);
            if ($response === FALSE) {
                return []; // Retorna um array vazio se não encontrar nenhum paciente
            }
            $data = json_decode($response, true);
            $pacientes = [];
            foreach ($data as $row) {
                $pacientes[] = $this->listaPaciente($row);
            }
            return $pacientes;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar pacientes por nome: </p> <p>{$e->getMessage()}</p>";
            return [];
        }
    }

    public function buscarTodos(){
        $url = "http://localhost:3000/pacientes";
        try {
            $response = @file_get_contents($url);
            if ($response === FALSE) {
                return []; // Retorna um array vazio se não encontrar nenhum paciente
            }
            $data = json_decode($response, true);
            $pacientes = [];
            foreach ($data as $row) {
                $pacientes[] = $this->listaPaciente($row);
            }
            return $pacientes;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar pacientes: </p> <p>{$e->getMessage()}</p>";
            return [];
        }
    }

} // Fecha a classe Dao
?>
