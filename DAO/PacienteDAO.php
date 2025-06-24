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
            isset($row['idPaciente']) ? htmlspecialchars($row['idPaciente']) : '',
            isset($row['nome']) ? htmlspecialchars($row['nome']) : '',
            isset($row['dataNascimento']) ? htmlspecialchars($row['dataNascimento']) : '',
            isset($row['telefone']) ? htmlspecialchars($row['telefone']) : '',
            isset($row['email']) ? htmlspecialchars($row['email']) : '',
            isset($row['nomeMae']) ? htmlspecialchars($row['nomeMae']) : '',
            isset($row['idade']) ? htmlspecialchars($row['idade']) : '',
            isset($row['Medicamento']) ? htmlspecialchars($row['Medicamento']) : '',
            isset($row['Patologia']) ? htmlspecialchars($row['Patologia']) : ''
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

    public function excluir($idPaciente) {
        $url = "http://localhost:3000/pacientes/" . urlencode($idPaciente);
        $options = [
            "http" => [
                "header"  => "Content-Type: application/json\r\n",
                "method"  => "DELETE"
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result ? json_decode($result, true) : false;
    }

} // Fecha a classe Dao
?>
