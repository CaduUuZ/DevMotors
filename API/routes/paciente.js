const express = require('express');
const router = express.Router();
const db = require('../db');

// Listar todos os pacientes
router.get('/', (req, res) => {
  db.query('SELECT * FROM pacientes', (err, results) => {
    if (err) return res.status(500).json({ error: err.message });
    res.json(results);
  });
});

// Buscar paciente por ID
router.get('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  db.query('SELECT * FROM pacientes WHERE idPaciente = ?', [id], (err, results) => {
    if (err) return res.status(500).json({ error: err.message });
    if (results.length === 0) return res.status(404).json({ message: 'Paciente não encontrado' });
    // Retorne o resultado como está, pois o campo já é idPaciente
    res.json(results[0]);
  });
});

// Inserir novo paciente
router.post('/', (req, res) => {
  const { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia } = req.body;
  db.query(
    'INSERT INTO pacientes (nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
    [nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia],
    (err, result) => {
      if (err) return res.status(500).json({ error: err.message });
      res.status(201).json({ id: result.insertId, nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia });
    }
  );
});

// Editar paciente
router.put('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia } = req.body;
  db.query(
    'UPDATE pacientes SET nome=?, dataNascimento=?, telefone=?, email=?, nomeMae=?, idade=?, medicamento=?, patologia=? WHERE idPaciente=?',
    [nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia, id],
    (err, result) => {
      if (err) return res.status(500).json({ error: err.message });
      if (result.affectedRows === 0) return res.status(404).json({ message: 'Paciente não encontrado' });
      res.json({ id, nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia });
    }
  );
});

// Excluir paciente
router.delete('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  db.query('DELETE FROM pacientes WHERE idPaciente = ?', [id], (err, result) => {
    if (err) return res.status(500).json({ error: err.message });
    if (result.affectedRows === 0) return res.status(404).json({ message: 'Paciente não encontrado' });
    res.status(204).send();
  });
});

module.exports = router;
