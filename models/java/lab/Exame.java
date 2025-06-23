package lab;

import java.io.FileWriter;
import java.io.IOException;

public class Exame {
    private Paciente paciente;
    private String laboratorio;
    private String exameTexto;

    public Exame(Paciente paciente, String laboratorio, String exameTexto) {
        this.paciente = paciente;
        this.laboratorio = laboratorio;
        this.exameTexto = exameTexto;
    }

    public void salvar() {
        String insert = String.format("INSERT INTO exames (idPaciente, laboratorio, exameTexto) VALUES ('%s', '%s', '%s');\n",
                paciente.getId(), laboratorio, exameTexto);

        try (FileWriter writer = new FileWriter("exames_inserts.sql", true)) {
            writer.write(insert);
        } catch (IOException e) {
            System.out.println("Erro ao salvar exame em arquivo: " + e.getMessage());
        }
    }
}
