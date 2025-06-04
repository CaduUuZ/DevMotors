package java;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        // Configuração do banco de dados
        String url = "jdbc:mysql://localhost:3307/lab_faculdade";
        String user = "root";
        String password = "";

        try (Connection conn = DriverManager.getConnection(url, user, password)) {
            int opcao;

            do {
                System.out.println("\n=== Menu Principal ===");
                System.out.println("1. Cadastrar Usuário");
                System.out.println("2. Listar Usuários");
                System.out.println("3. Editar Usuário");
                System.out.println("4. Cadastrar Paciente");
                System.out.println("5. Listar Pacientes");
                System.out.println("6. Cadastrar Exame");
                System.out.println("7. Listar Exames");
                System.out.println("8. Sair");
                System.out.print("Escolha uma opção: ");
                opcao = sc.nextInt();
                sc.nextLine(); // Limpa o buffer

                switch (opcao) {
                    case 1:
                        cadastrarUsuario(sc, conn);
                        break;
                    case 2:
                        listarUsuarios(conn);
                        break;
                    case 3:
                        editarUsuario(sc, conn);
                        break;
                    case 4:
                        cadastrarPaciente(sc, conn);
                        break;
                    case 5:
                        listarPacientes(conn);
                        break;
                    case 6:
                        cadastrarExame(sc, conn);
                        break;
                    case 7:
                        listarExames(conn);
                        break;
                    case 8:
                        System.out.println("Saindo do sistema...");
                        break;
                    default:
                        System.out.println("Opção inválida. Tente novamente.");
                }
            } while (opcao != 8);

        } catch (SQLException e) {
            System.out.println("Erro ao conectar ao banco de dados: " + e.getMessage());
        }

        sc.close();
    }

    private static void cadastrarUsuario(Scanner scanner, Connection conn) {
        System.out.println("\n=== Cadastrar Usuário ===");
        System.out.print("ID: ");
        int id = scanner.nextInt();
        scanner.nextLine(); // Limpa o buffer
        System.out.print("Email: ");
        String email = scanner.nextLine();
        System.out.print("Senha: ");
        String senha = scanner.nextLine();

        User usuario = new User(id, email, senha);
        try {
            usuario.salvar(conn);
            System.out.println("Usuário cadastrado com sucesso!");
        } catch (SQLException e) {
            System.out.println("Erro ao cadastrar usuário: " + e.getMessage());
        }
    }

    private static void listarUsuarios(Connection conn) {
        System.out.println("\n=== Lista de Usuários ===");
        try {
            User.listar(conn);
        } catch (SQLException e) {
            System.out.println("Erro ao listar usuários: " + e.getMessage());
        }
    }

    private static void editarUsuario(Scanner scanner, Connection conn) {
        System.out.println("\n=== Editar Usuário ===");
        System.out.print("Informe o ID do usuário: ");
        int id = scanner.nextInt();
        scanner.nextLine(); // Limpa o buffer
        System.out.print("Novo Email: ");
        String novoEmail = scanner.nextLine();
        System.out.print("Nova Senha: ");
        String novaSenha = scanner.nextLine();

        try {
            User.editar(conn, id, novoEmail, novaSenha);
            System.out.println("Usuário atualizado com sucesso!");
        } catch (SQLException e) {
            System.out.println("Erro ao editar usuário: " + e.getMessage());
        }
    }

    private static void cadastrarPaciente(Scanner scanner, Connection conn) {
        System.out.println("\n=== Cadastrar Paciente ===");
        System.out.print("ID: ");
        String id = scanner.nextLine();
        System.out.print("Nome: ");
        String nome = scanner.nextLine();
        System.out.print("Data de Nascimento: ");
        String dataNascimento = scanner.nextLine();
        System.out.print("Telefone: ");
        String telefone = scanner.nextLine();
        System.out.print("Email: ");
        String email = scanner.nextLine();
        System.out.print("Nome da Mãe: ");
        String nomeMae = scanner.nextLine();
        System.out.print("Idade: ");
        int idade = scanner.nextInt();
        scanner.nextLine(); // Limpa o buffer
        System.out.print("Medicamento: ");
        String medicamento = scanner.nextLine();
        System.out.print("Patologia: ");
        String patologia = scanner.nextLine();

        Paciente paciente = new Paciente(id, nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia);
        try {
            paciente.salvar(conn);
            System.out.println("Paciente cadastrado com sucesso!");
        } catch (SQLException e) {
            System.out.println("Erro ao cadastrar paciente: " + e.getMessage());
        }
    }

    private static void listarPacientes(Connection conn) throws SQLException {
        System.out.println("\n=== Lista de Pacientes ===");
        Paciente.listar(conn);
    }

    private static void cadastrarExame(Scanner scanner, Connection conn) {
        System.out.println("\n=== Cadastrar Exame ===");
        System.out.print("ID do Paciente: ");
        String idPaciente = scanner.nextLine();
        System.out.print("Laboratório: ");
        String laboratorio = scanner.nextLine();
        System.out.print("Descrição do Exame: ");
        String exameTexto = scanner.nextLine();

        try {
            Paciente paciente = Paciente.buscarPorId(conn, idPaciente);
            if (paciente == null) {
                System.out.println("Paciente não encontrado. Cadastre o paciente primeiro.");
                return;
            }

            Exame exame = new Exame(paciente, laboratorio, exameTexto);
            exame.salvar(conn);
            System.out.println("Exame cadastrado com sucesso!");
        } catch (SQLException e) {
            System.out.println("Erro ao cadastrar exame: " + e.getMessage());
        }
    }

    private static void listarExames(Connection conn) throws SQLException {
        System.out.println("\n=== Lista de Exames ===");
        Exame.listar(conn);
    }
}