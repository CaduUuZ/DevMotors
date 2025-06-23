package lab;

import java.io.FileWriter;
import java.io.IOException;

public class User {
    private int id;
    private String email;
    private String senha;

    public User(int id, String email, String senha) {
        this.id = id;
        this.email = email;
        this.senha = senha;
    }

    public void salvar() {
        String insert = String.format("INSERT INTO usuarios (id, email, senha) VALUES (%d, '%s', '%s');\n", id, email, senha);
        try (FileWriter writer = new FileWriter("usuarios_inserts.sql", true)) {
            writer.write(insert);
        } catch (IOException e) {
            System.out.println("Erro ao salvar usuário em arquivo: " + e.getMessage());
        }
    }
}
 