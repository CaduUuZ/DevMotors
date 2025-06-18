const express = require('express');
const router = express.Router();
const Exame = require('../models/Exame');

let emaxes = [];
let nextId = 1;

// Listar todos
router.get('/', (req, res) => {
  res.json(exames);
});

// Buscar por ID
router.get('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const exame = exames.find(f => f.id === id);
  if (!exame) return res.status(404).json({ message: 'Exame não encontrado' });
  res.json(exame);
});

// Inserir
router.post('/', (req, res) => {
  const { idExame, paciente, laboratorio, exameTexto, dataExame , resultado } = req.body;
  const exame = new Paciente(nextId++,paciente, laboratorio, exameTexto, dataExame , resultado);
  exames.push(exame);
  res.status(201).json(exame);
});

// Editar
router.put('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const exame = exames.find(f => f.id === id);
  if (!exame) return res.status(404).json({ message: 'Exame não encontrado' });

  const { idExame, paciente, laboratorio, exameTexto, dataExame , resultado } = req.body;
    exame.idExame = idExame ?? exame.idExame;
    exame.paciente = paciente ?? exame.paciente;
    exame.laboratorio = laboratorio ?? exame.laboratorio;
    exame.exameTexto = exameTexto ?? exame.exameTexto;
    exame.dataExame = dataExame ?? exame.dataExame;
    exame.resultado = resultado ?? exame.resultado;
  

  res.json(exame);
});

// Excluir
router.delete('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const index = exames.findIndex(f => f.id === id);
  if (index === -1) return res.status(404).json({ message: 'Exame não encontrado' });

  exames.splice(index, 1);
  res.status(204).send();
});

module.exports = router;
