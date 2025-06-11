<?php
// Função para pesquisar pacientes no banco de dados
function pesquisar($conn, $busca = null) {
    // Verifica se há um parâmetro de busca
    if ($busca) {
        // Prepara uma consulta SQL para buscar um paciente específico pelo ID
        $stmt = $conn->prepare("SELECT idPaciente, nomeCompleto FROM pacientes WHERE idPaciente = ?");
        $stmt->bind_param("i", $busca); // Substitui o placeholder pelo valor do ID
        $stmt->execute(); // Executa a consulta
        $result = $stmt->get_result(); // Obtém o resultado da consulta
    } else {
        // Consulta SQL para buscar todos os pacientes, ordenados pelo ID
        $sql = "SELECT idPaciente, nomeCompleto FROM pacientes ORDER BY idPaciente ASC";
        $result = $conn->query($sql); // Executa a consulta
    }

    // Verifica se há resultados na consulta
    if ($result && $result->num_rows > 0) {
        // Itera sobre os resultados e exibe cada paciente em uma linha da tabela
        while ($paciente = $result->fetch_assoc()) {
            echo '
            <tr>
                <td>' . htmlspecialchars($paciente['idPaciente']) . '</td> <!-- Exibe o ID do paciente -->
                <td>' . htmlspecialchars($paciente['nomeCompleto']) . '</td> <!-- Exibe o nome completo do paciente -->
                <td class="text-end">
                    <!-- Link para visualizar os detalhes do paciente -->
                    <a href="visualizarPaciente.php?id=' . $paciente['idPaciente'] . '" class="table-link">
                        <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <!-- Link para editar os dados do paciente -->
                    <a href="editarPaciente.php?id=' . $paciente['idPaciente'] . '" class="table-link">
                        <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <!-- Link para deletar o paciente, com confirmação -->
                    <a href="deletarPaciente.php?id=' . $paciente['idPaciente'] . '" class="table-link danger" onclick="return confirm(\'Deseja realmente excluir este paciente?\')">
                        <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </td>
            </tr>';
        }
    } else {
        // Exibe uma mensagem caso nenhum paciente seja encontrado
        echo '<tr><td colspan="3"><strong>Nenhum paciente encontrado.</strong></td></tr>';
    }
}
?>
