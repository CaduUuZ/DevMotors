const express = require('express');
const mysql = require('mysql2/promise');
const app = express();

app.use(express.json());

// Configuração do banco de dados
const db = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'devmotors'
});

// Rotas para Exames
app.get('/exames', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM exames ORDER BY dataExame DESC');
    res.json(rows);
  } catch (error) {
    res.status(500).json({ error: 'Erro ao buscar exames' });
  }
});

app.post('/exames', async (req, res) => {
  const { idPaciente, laboratorio, exameTexto } = req.body;
  try {
    const sql = `INSERT INTO exames (idPaciente, laboratorio, exameTexto) VALUES (?, ?, ?)`;
    await db.query(sql, [idPaciente, laboratorio, exameTexto]);
    res.status(201).json({ message: 'Exame salvo com sucesso' });
  } catch (error) {
    res.status(500).json({ error: 'Erro ao salvar exame' });
  }
});

// Inicialização do servidor
app.listen(3000, () => {
  console.log('API rodando na porta 3000');
});