<?php
// classes/Exame.php
require_once 'Paciente.php'; // Inclui a classe Paciente para uso na classe Exame

class Exame {
    public $paciente; // Objeto Paciente associado ao exame
    public $laboratorio; // Nome do laboratório responsável pelo exame
    public $exameTexto; // Descrição ou detalhes do exame

    public function __construct(Paciente $paciente, $laboratorio, $exameTexto) {
        // Inicializa os atributos da classe com os valores fornecidos
        $this->paciente = $paciente; // Define o paciente associado ao exame
        $this->laboratorio = $laboratorio; // Define o laboratório responsável
        $this->exameTexto = $exameTexto; // Define os detalhes do exame
    }

    public function salvar($conn) {
        // Prepara a consulta SQL para inserir os dados do exame na tabela 'exames'
        $sql = "INSERT INTO exames (idPaciente, laboratorio, exameTexto) 
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql); // Prepara a consulta para execução

        // Variável auxiliar para o ID do paciente
        $pacienteId = $this->paciente->getId(); // Obtém o ID do paciente associado

        // Associa os valores aos parâmetros da consulta
        $stmt->bind_param("sss", $pacienteId, $this->laboratorio, $this->exameTexto);

        // Executa a consulta e verifica se houve erro
        if (!$stmt->execute()) {
            // Lança uma exceção em caso de erro na execução
            throw new Exception("Erro ao salvar exame: " . $stmt->error);
        }
    }
}
