<?php
require_once __DIR__ . '/../models/Exame.php';
require_once __DIR__ . '/../models/Paciente.php';

class ExameDAO {

    public function inserir(Exame $exame) {
        $url = "http://localhost:3000/exames";
        $dados = [
            "idExame" => $exame->getIdExame(),
            "idPaciente" => $exame->getPaciente()->getIdPaciente(),
            "laboratorio" => $exame->getLaboratorio(),
            "exameTexto" => $exame->getExameTexto()
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
        $url = "http://localhost:3000/exames";
        $result = file_get_contents($url);
        $exameList = array();
        $lista = json_decode($result, true);
        foreach ($lista as $exameList):
            $exameList[] = $this->listaExame($exameList);
        endforeach;
        return $exameList;
    }

    // Converter uma linha em obj
    public function listaPaciente($row){
        $paciente = new Paciente(
            htmlspecialchars($row['idPaciente']),
            htmlspecialchars($row['nomeCompleto']),
            htmlspecialchars($row['dataNascimento']),
            htmlspecialchars($row['telefone']),
            htmlspecialchars($row['email']),
            htmlspecialchars($row['nomeMae']),
            htmlspecialchars($row['idade']),
            htmlspecialchars($row['Medicamento']),
            htmlspecialchars($row['Patologia'])
        );
        $exame = new Exame(
            $paciente,
            htmlspecialchars($row['laboratorio']),
            htmlspecialchars($row['exameTexto']),
            htmlspecialchars($row['idExame']),
            htmlspecialchars($row['dataExame']),
            htmlspecialchars($row['resultado'])
        );
        return $exame;
    }

    // Método para converter array em objeto Exame
    public function listaExame($row) {
        $paciente = new Paciente(
            $row['idPaciente'],
            $row['nome'],
            $row['dataNascimento'],
            $row['telefone'],
            $row['email'],
            $row['nomeMae'],
            $row['idade'],
            $row['medicamento'],
            $row['patologia']
        );
        $exame = new Exame(
            $paciente,
            $row['laboratorio'],
            $row['exameTexto'],
            $row['idExame'],
            $row['dataExame'],
            $row['resultado']
        );
        return $exame;
    }

    public function editar(Exame $exame){
        $url = "http://localhost:3000/exames/".$exame->getIdExame();
        $dados = [
            "idExame" => $exame->getIdExame(),
            "idPaciente" => $exame->getPaciente()->getIdPaciente(),
            "laboratorio" => $exame->getLaboratorio(),
            "exameTexto" => $exame->getExameTexto()
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
        $url = "http://localhost:3000/exames/" . urlencode($id);
        try {
            // @file_get_contents() para evitar warnings automáticos.
            $response = @file_get_contents($url);
            if ($response === FALSE) {
                return null; // ID não encontrado ou erro na requisição
            }
            $data = json_decode($response, true);
            if ($data) {
                return $this->listaExame($data);
            }
            return null;
        } catch (Exception $e) {
            echo "<p>Erro ao buscar fabricante por ID: </p> <p>{$e->getMessage()}</p>";
            return null;
        }
    }

    public function buscarTodos(){
        $url = "http://localhost:3000/exames";
        try {
            $response = @file_get_contents($url);
            if ($response === FALSE) {
                return null; // Erro na requisição
            }
            $data = json_decode($response, true);
            if ($data) {
                $exames = [];
                foreach ($data as $item) {
                    $exames[] = $this->listaExame($item);
                }
                return $exames;
            }
            return null;
        } catch (Exception $e) {
            echo "<p>Erro ao listar exames: </p> <p>{$e->getMessage()}</p>";
            return null;
        }
    }

    public function salvar(Exame $exame) {
        $url = "http://localhost:3000/exames";
        $dados = [
            "idExame" => $exame->getIdExame(),
            "idPaciente" => $exame->getPaciente()->getIdPaciente(),
            "laboratorio" => $exame->getLaboratorio(),
            "exameTexto" => $exame->getExameTexto(),
            "dataExame" => $exame->getDataExame(),
            "resultado" => $exame->getResultado()
        ];

        $options = [
            "http" => [
                "header"  => "Content-type: application/json",
                "method"  => "POST",
                "content" => json_encode($dados)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result ? json_decode($result, true) : false;
    }

    public function buscarPorPaciente($idPaciente) {
        $url = "http://localhost:3000/exames?paciente=" . urlencode($idPaciente);
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            return [];
        }
        $data = json_decode($response, true);
        if ($data) {
            $exames = [];
            foreach ($data as $item) {
                $exames[] = $this->listaExame($item);
            }
            return $exames;
        }
        return [];
    }

    public function excluir($idExame) {
        $url = "http://localhost:3000/exames/" . urlencode($idExame);

        $options = [
            "http" => [
                "method" => "DELETE"
            ]
        ];
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        // Retorna true se não houve erro
        return $result !== false;
    }

} // Fecha a classe Dao
?>
