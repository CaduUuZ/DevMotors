package lab;

import java.io.FileWriter;
import java.io.IOException;

public class Paciente {
    private String id;
    private String nome;
    private String dataNascimento;
    private String telefone;
    private String email;
    private String nomeMae;
    private int idade;
    private String medicamento;
    private String patologia;

    public Paciente(String id, String nome, String dataNascimento, String telefone,
                    String email, String nomeMae, int idade, String medicamento, String patologia) {
        this.id = id;
        this.nome = nome;
        this.dataNascimento = dataNascimento;
        this.telefone = telefone;
        this.email = email;
        this.nomeMae = nomeMae;
        this.idade = idade;
        this.medicamento = medicamento;
        this.patologia = patologia;
    }

    public String getId() {
        return id;
    }

    public void salvar() {
        String insert = String.format(
                "INSERT INTO pacientes (idPaciente, nomeCompleto, dataNascimento, idade, telefone, email, nomeMae, nomeMedicamento, nomePatologia) " +
                "VALUES ('%s', '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s');\n",
                id, nome, dataNascimento, idade, telefone, email, nomeMae, medicamento, patologia);

        try (FileWriter writer = new FileWriter("pacientes_inserts.sql", true)) {
            writer.write(insert);
        } catch (IOException e) {
            System.out.println("Erro ao salvar paciente em arquivo: " + e.getMessage());
        }
    }
}
