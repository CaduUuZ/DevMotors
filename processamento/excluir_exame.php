<?php
// Inclui o arquivo de configuração do banco de dados
require_once('../config/db.php');

// Verifica se o ID do exame foi passado via GET
if (isset($_GET['idExame'])) {
    // Escapa o ID do exame para evitar injeção de SQL
    $idExame = $conn->real_escape_string($_GET['idExame']);

    // Monta a query para deletar o exame com o ID especificado
    $sql = "DELETE FROM exames WHERE idExame = '$idExame'";
    
    // Executa a query e verifica se foi bem-sucedida
    if ($conn->query($sql)) {
        // Redireciona para a lista de exames com uma mensagem de sucesso
        header("Location: ../telas/listaExames.php?success=1");
        exit;
    } else {
        // Redireciona para a lista de exames com uma mensagem de erro
        header("Location: ../telas/listaExames.php?success=0&error=" . urlencode("Erro ao excluir exame: " . $conn->error));
        exit;
    }
} else {
    // Redireciona para a lista de exames com uma mensagem de erro caso o ID não tenha sido informado
    header("Location: ../telas/listaExames.php?success=0&error=" . urlencode("ID do exame não informado."));
    exit;
}
?>
