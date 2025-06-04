package java;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

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

    public void salvar(Connection conn) throws SQLException {
        // Verifica se o e-mail já existe no banco
        if (email != null && !email.isEmpty()) {
            String verificaEmail = "SELECT COUNT(*) AS total FROM pacientes WHERE email = ?";
            try (PreparedStatement stmt = conn.prepareStatement(verificaEmail)) {
                stmt.setString(1, email);
                try (ResultSet rs = stmt.executeQuery()) {
                    if (rs.next() && rs.getInt("total") > 0) {
                        throw new SQLException("Este e-mail já está cadastrado no sistema.");
                    }
                }
            }
        }

        // Insere os dados do paciente
        String sql = "INSERT INTO pacientes (idPaciente, nomeCompleto, dataNascimento, idade, telefone, email, nomeMae, nomeMedicamento, nomePatologia) " +
                     "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, id);
            stmt.setString(2, nome);
            stmt.setString(3, dataNascimento);
            stmt.setInt(4, idade);
            stmt.setString(5, telefone);
            stmt.setString(6, email);
            stmt.setString(7, nomeMae);
            stmt.setString(8, medicamento != null ? medicamento : "");
            stmt.setString(9, patologia != null ? patologia : "");

            stmt.executeUpdate();
        }
    }

    public static void listar(Connection conn) {
        // TODO Auto-generated method stub
        throw new UnsupportedOperationException("Unimplemented method 'listar'");
    }

    public static Paciente buscarPorId(Connection conn, String idPaciente) {
        // TODO Auto-generated method stub
        throw new UnsupportedOperationException("Unimplemented method 'buscarPorId'");
    }
}
