<?php
class PacienteDAO {

    public function inserir(Paciente $paciente) {
        $url = "http://localhost:3000/pacientes";
        $dados = [
            //"id" => $fab->getId(),
            "nome" => $paciente->getNome(),
            "dataNascimento" => $paciente->getDataNascimento(),
            "telefone" => $paciente->getTelefone(),
            "email" => $paciente->getEmail(),
            "nomeMae" => $paciente->getNomeMae(),
            "idade" => $paciente->getIdade(),
            "nomeMedicamento" => $paciente->getNomeMedicamento(),
            "nomePatologia" => $paciente->getNomePatologia()
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
        $paciente = new Paciente();
        $paciente->setId(htmlspecialchars($row['id']));
        $paciente->setNome(htmlspecialchars($row['nome']));
        $paciente->setDataNascimento(htmlspecialchars($row['dataNascimento']));
        $paciente->setTelefone(htmlspecialchars($row['telefone']));
        $paciente->setEmail(htmlspecialchars($row['email']));
        $paciente->setNomeMae(htmlspecialchars($row['nomeMae']));
        $paciente->setIdade(htmlspecialchars($row['idade']));
        $paciente->setNomeMedicamento(htmlspecialchars($row['nomeMedicamento']));
        $paciente->setNomePatologia(htmlspecialchars($row['nomePatologia']));
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
            "nomeMedicamento" => $paciente->getNomeMedicamento(),
            "nomePatologia" => $paciente->getNomePatologia()
            
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

    public function buscarPorId($id){
        $url = "http://localhost:3000/pacientes/" . urlencode($id);
        try {
            // @file_get_contents() para evitar warnings automáticos.
            $response = @file_get_contents($url);
            if ($response === FALSE) {
                return null; // ID não encontrado ou erro na requisição
            }
            $data = json_decode($response, true);
            if ($data) {
                return $this->listaFabricante($data);
            }
            return null;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar fabricante por ID: </p> <p>{$e->getMessage()}</p>";
            return null;
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
