import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class User {
    private int id;
    private String email;
    private String senha;

    public User(int id, String email, String senha) {
        this.id = id; // ID do usuário
        this.email = email; // E-mail do usuário
        this.senha = senha; // Senha do usuário
    }

    public int getId() {
        return id; // Retorna o ID do usuário
    }

    public void salvar(Connection conn) throws Exception {
        // Verifica se o e-mail já existe no banco de dados
        if (email != null && !email.isEmpty()) {
            String verificaEmail = "SELECT COUNT(*) as total FROM usuarios WHERE email = ?"; // Consulta SQL para verificar duplicidade de e-mail
            try (PreparedStatement stmt = conn.prepareStatement(verificaEmail)) {
                stmt.setString(1, email); // Substitui o placeholder pelo e-mail do usuário
                ResultSet result = stmt.executeQuery(); // Executa a consulta e obtém o resultado

                if (result.next() && result.getInt("total") > 0) {
                    throw new Exception("Este e-mail já está cadastrado no sistema."); // Lança exceção se o e-mail já estiver cadastrado
                }
            }
        }

        // Consulta SQL para inserir os dados do usuário no banco de dados
        String sql = "INSERT INTO usuarios (id, email, senha) VALUES (?, ?, ?)";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id); // Substitui o placeholder pelo ID do usuário
            stmt.setString(2, email); // Substitui o placeholder pelo e-mail do usuário
            stmt.setString(3, hashSenha(senha)); // Substitui o placeholder pela senha hashada

            if (stmt.executeUpdate() <= 0) { // Executa a consulta e verifica se houve erro
                throw new Exception("Erro ao salvar usuário.");
            }
        }
    }

    private String hashSenha(String senha) {
        // Implementação de hashing de senha (exemplo usando SHA-256)
        try {
            java.security.MessageDigest md = java.security.MessageDigest.getInstance("SHA-256");
            byte[] hash = md.digest(senha.getBytes(java.nio.charset.StandardCharsets.UTF_8));
            StringBuilder hexString = new StringBuilder();
            for (byte b : hash) {
                String hex = Integer.toHexString(0xff & b);
                if (hex.length() == 1) {
                    hexString.append('0');
                }
                hexString.append(hex);
            }
            return hexString.toString();
        } catch (Exception e) {
            throw new RuntimeException("Erro ao hashear a senha.", e);
        }
    }
}