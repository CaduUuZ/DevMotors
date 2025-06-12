<?php
require_once '../models/Exame.php';
require_once '../models/Paciente.php';
require_once '../config/config.php';

define('API_URL', 'http://localhost:3000'); // URL base da API

class ExameDAO {
    private $apiUrl;

    public function __construct($apiUrl) {
        $this->apiUrl = $apiUrl;
    }

    // Salvar novo exame
    public function salvar(Exame $exame) {
        $url = $this->apiUrl . '/exames';
        $data = [
            'idPaciente' => $exame->getPaciente()->getIdPaciente(),
            'laboratorio' => $exame->getLaboratorio(),
            'exameTexto' => $exame->getExameTexto()
        ];

        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new Exception("Erro ao salvar exame na API.");
        }
    }

    // Buscar todos os exames
    public function buscarTodos() {
        $url = $this->apiUrl . '/exames';
        $response = file_get_contents($url);
        $exames = json_decode($response, true);

        return $exames;
    }
}

// Exemplo de uso
$exameDAO = new ExameDAO('http://localhost:3000');
$exames = $exameDAO->buscarTodos();
