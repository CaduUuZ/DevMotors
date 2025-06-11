package lab;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class User {
    private int id;
    private String email;
    private String senha;

    public User(int id, String email, String senha) {
        this.id = id;
        this.email = email;
        this.senha = senha;
    }

    // Getters e Setters
    public int getId() {
        return id;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getSenha() {
        return senha;
    }

    public void setSenha(String senha) {
        this.senha = senha;
    }

    // Método para salvar um usuário no banco de dados
    public void salvar(Connection conn) throws SQLException {
        String sql = "INSERT INTO usuarios (id, email, senha) VALUES (?, ?, ?)";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, this.id);
            stmt.setString(2, this.email);
            stmt.setString(3, this.senha);
            stmt.executeUpdate();
        }
    }

    // Método para listar todos os usuários
    public static void listar(Connection conn) throws SQLException {
        String sql = "SELECT id, email FROM usuarios";
        try (PreparedStatement stmt = conn.prepareStatement(sql);
             ResultSet rs = stmt.executeQuery()) {
            System.out.println("=== Lista de Usuários ===");
            while (rs.next()) {
                int id = rs.getInt("id");
                String email = rs.getString("email");
                System.out.println("ID: " + id + ", Email: " + email);
            }
        }
    }

    // Método para editar um usuário
    public static void editar(Connection conn, int id, String novoEmail, String novaSenha) throws SQLException {
        String sql = "UPDATE usuarios SET email = ?, senha = ? WHERE id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, novoEmail);
            stmt.setString(2, novaSenha);
            stmt.setInt(3, id);
            int rowsUpdated = stmt.executeUpdate();
            if (rowsUpdated == 0) {
                throw new SQLException("Usuário com ID " + id + " não encontrado.");
            }
        }
    }
}