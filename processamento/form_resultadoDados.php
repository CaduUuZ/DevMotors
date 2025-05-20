<?php

// Verifica se o método da requisição é POST (envio de formulário)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idExame = $_POST['idExame']; // Obtém o ID do exame enviado pelo formulário
    $resultado = $_POST['resultado']; // Obtém o resultado enviado pelo formulário

    // Prepara a query para atualizar o resultado do exame no banco de dados
    $sqlUpdate = "UPDATE exames SET resultado = ? WHERE idExame = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $resultado, $idExame);

    // Executa a query e redireciona em caso de sucesso
    if ($stmtUpdate->execute()) {
        header("Location: ../telas/listaExames.php?status=success");
        exit;
    } else {
        // Exibe mensagem de erro em caso de falha
        echo "Erro ao salvar resultado: " . $conn->error;
    }
}

// Verifica se o ID do exame foi informado na URL
if (!isset($_GET['idExame'])) {
    echo "ID do exame não informado."; // Exibe mensagem de erro se o ID não for informado
    exit;
}

$idExame = $_GET['idExame']; // Obtém o ID do exame da URL

// Prepara a query para buscar os dados do exame e do paciente associado
$sql = "SELECT e.idExame, e.exameTexto, e.idPaciente, e.dataExame,
               p.nomeCompleto, p.idade
        FROM exames e
        JOIN pacientes p ON e.idPaciente = p.idPaciente
        WHERE e.idExame = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idExame); // Vincula o ID do exame à query
$stmt->execute();
$result = $stmt->get_result(); // Obtém o resultado da query

// Verifica se o exame foi encontrado
if ($result->num_rows === 0) {
    echo "Exame não encontrado."; // Exibe mensagem de erro se o exame não for encontrado
    exit;
}

$exame = $result->fetch_assoc(); // Obtém os dados do exame
?>
