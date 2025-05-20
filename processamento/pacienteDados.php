<?php
// Inclui as classes necessárias
require_once '../classes/Paciente.php';
require_once '../classes/Exame.php';
require_once '../config/db.php';

/**
 * Função para calcular a idade com base na data de nascimento
 * $dataNascimento Data de nascimento no formato 'Y-m-d'
 *  Idade calculada
 */
function calcularIdade($dataNascimento) {
    $nascimento = new DateTime($dataNascimento); // Cria um objeto DateTime com a data de nascimento
    $hoje = new DateTime(); // Obtém a data atual
    return $hoje->diff($nascimento)->y; // Calcula a diferença em anos
}

/**
 * Gera um ID aleatório de 8 caracteres (números e letras maiúsculas)
 * $tamanho Tamanho do ID gerado (padrão: 8)
 * ID gerado
 */
function gerar_id_aleatorio($tamanho = 8) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Conjunto de caracteres permitidos
    $idPaciente = '';
    
    // Gera o ID aleatório
    for ($i = 0; $i < $tamanho; $i++) {
        $idPaciente .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    
    return $idPaciente;
}

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtém os dados do formulário
        $idPaciente = gerar_id_aleatorio(8); // Gera um ID único para o paciente
        $nomeCompleto = $_POST['nome-completo']; // Nome completo do paciente
        $dataNascimento = $_POST['dataNascimento']; // Data de nascimento
        $telefone = $_POST['telefone']; // Telefone
        $email = $_POST['email']; // Email
        $nomeMae = $_POST['nome-mae'] ?? null; // Nome da mãe (opcional)

        // Calcula a idade com base na data de nascimento
        $idade = calcularIdade($dataNascimento);

        // Insere os dados do paciente no banco de dados
        $query = "INSERT INTO pacientes (idPaciente, nomeCompleto, dataNascimento, idade, telefone, email, nomeMae) 
                  VALUES ('$idPaciente', '$nomeCompleto', '$dataNascimento', '$idade', '$telefone', '$email', '$nomeMae')";

        // Verifica se a inserção foi bem-sucedida
        if (mysqli_query($conn, $query)) {
            // Exibe mensagem de sucesso com SweetAlert2
            echo "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Paciente cadastrado com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '../telas/home.php'; // Redireciona para a página inicial
                    });
                </script>
            </body>
            </html>
            ";
        } else {
            // Captura e exibe o erro do banco de dados
            $mensagemErro = json_encode(mysqli_error($conn));
        
            echo "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: 'Erro!',
                        text: $mensagemErro,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.history.back(); // Retorna à página anterior
                    });
                </script>
            </body>
            </html>
            ";
        }
    } catch (Exception $e) {
        // Captura e exibe exceções
        $mensagemErro = json_encode($e->getMessage());
    
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: 'Erro!',
                    text: $mensagemErro,
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.back(); // Retorna à página anterior
                });
            </script>
        </body>
        </html>
        ";
    }
}
?>
