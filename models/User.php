<?php 

class User {
    private $id,$email,$senha;

    public function __construct($id, $email, $senha) {
        $this->id = $id; // ID do usuário
        $this->email = $email; // E-mail do usuário
        $this->senha = $senha; // Senha do usuário
    }

    public function getId() {
        return $this->id; // Retorna o ID do usuário
    }

    public function salvar($conn) {
        // Verifica se o e-mail já existe no banco de dados
        if (!empty($this->email)) {
            $verificaEmail = "SELECT COUNT(*) as total FROM usuarios WHERE email = ?"; // Consulta SQL para verificar duplicidade de e-mail
            $stmt = $conn->prepare($verificaEmail); // Prepara a consulta
            $stmt->bind_param("s", $this->email); // Substitui o placeholder pelo e-mail do usuário
            $stmt->execute(); // Executa a consulta
            $result = $stmt->get_result(); // Obtém o resultado da consulta
            $dados = $result->fetch_assoc(); // Extrai os dados do resultado

            // Se o e-mail já estiver cadastrado, lança uma exceção
            if ($dados['total'] > 0) {
                throw new Exception("Este e-mail já está cadastrado no sistema.");
            }
        }

        // Consulta SQL para inserir os dados do usuário no banco de dados
        $sql = "INSERT INTO usuarios (id, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql); // Prepara a consulta SQL para inserção
        $stmt->bind_param("iss", $this->id, $this->email, password_hash($this->senha, PASSWORD_DEFAULT)); // Substitui os placeholders pelos valores das propriedades do objeto

        if (!$stmt->execute()) { // Executa a consulta e verifica se houve erro
            throw new Exception("Erro ao salvar usuário: " . $stmt->error);
        }
    }
}








?>