package lab;

import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        int opcao;

        do {
            System.out.println("\n=== Menu Principal ===");
            System.out.println("1. Cadastrar Usuário");
            System.out.println("2. Cadastrar Paciente");
            System.out.println("3. Cadastrar Exame");
            System.out.println("4. Sair");
            System.out.print("Escolha uma opção: ");
            opcao = sc.nextInt();
            sc.nextLine(); // Limpa o buffer

            switch (opcao) {
                case 1:
                    System.out.print("ID: ");
                    int id = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Email: ");
                    String email = sc.nextLine();
                    System.out.print("Senha: ");
                    String senha = sc.nextLine();

                    User usuario = new User(id, email, senha);
                    usuario.salvar();
                    break;

                case 2:
                    System.out.print("ID: ");
                    String idPaciente = sc.nextLine();
                    System.out.print("Nome: ");
                    String nome = sc.nextLine();
                    System.out.print("Data de Nascimento: ");
                    String dataNascimento = sc.nextLine();
                    System.out.print("Telefone: ");
                    String telefone = sc.nextLine();
                    System.out.print("Email: ");
                    String emailPaciente = sc.nextLine();
                    System.out.print("Nome da Mãe: ");
                    String nomeMae = sc.nextLine();
                    System.out.print("Idade: ");
                    int idade = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Medicamento: ");
                    String medicamento = sc.nextLine();
                    System.out.print("Patologia: ");
                    String patologia = sc.nextLine();

                    Paciente paciente = new Paciente(idPaciente, nome, dataNascimento, telefone, emailPaciente, nomeMae, idade, medicamento, patologia);
                    paciente.salvar();
                    break;

                case 3:
                    System.out.print("ID do Paciente: ");
                    String idP = sc.nextLine();
                    System.out.print("Laboratório: ");
                    String laboratorio = sc.nextLine();
                    System.out.print("Descrição do Exame: ");
                    String exameTexto = sc.nextLine();

                    Paciente pac = new Paciente(idP, "", "", "", "", "", 0, "", "");
                    Exame exame = new Exame(pac, laboratorio, exameTexto);
                    exame.salvar();
                    break;

                case 4:
                    System.out.println("Saindo...");
                    break;

                default:
                    System.out.println("Opção inválida.");
            }
        } while (opcao != 4);

        sc.close();
    }
}
