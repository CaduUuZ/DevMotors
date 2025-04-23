<?php
function pesquisar($conn, $busca = null) {
    if ($busca) {
        $stmt = $conn->prepare("SELECT idPaciente, nomeCompleto FROM pacientes WHERE idPaciente = ?");
        $stmt->bind_param("i", $busca);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql = "SELECT idPaciente, nomeCompleto FROM pacientes ORDER BY idPaciente ASC";
        $result = $conn->query($sql);
    }

    if ($result && $result->num_rows > 0) {
        while ($paciente = $result->fetch_assoc()) {
            echo '
            <tr>
                <td>' . htmlspecialchars($paciente['idPaciente']) . '</td>
                <td>' . htmlspecialchars($paciente['nomeCompleto']) . '</td>
                <td class="text-end">
                    <a href="visualizarPaciente.php?id=' . $paciente['idPaciente'] . '" class="table-link">
                        <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="editarPaciente.php?id=' . $paciente['idPaciente'] . '" class="table-link">
                        <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
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
        echo '<tr><td colspan="3"><strong>Nenhum paciente encontrado.</strong></td></tr>';
    }
}
?>
