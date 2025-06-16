package lab;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

public class Exame {
    private Paciente paciente;
    private String laboratorio;
    private String exameTexto;

    public Exame(Paciente paciente, String laboratorio, String exameTexto) {
        this.paciente = paciente;
        this.laboratorio = laboratorio;
        this.exameTexto = exameTexto;
    }

    public void salvar(Connection conn) throws SQLException {
        String sql = "INSERT INTO exames (idPaciente, laboratorio, exameTexto) VALUES (?, ?, ?)";

        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, paciente.getId());
            stmt.setString(2, laboratorio);
            stmt.setString(3, exameTexto);

            stmt.executeUpdate();
        } catch (SQLException e) {
            throw new SQLException("Erro ao salvar exame: " + e.getMessage(), e);
        }
    }

    public static void listar(Connection conn) {
        // TODO Auto-generated method stub
        throw new UnsupportedOperationException("Unimplemented method 'listar'");
    }
}
