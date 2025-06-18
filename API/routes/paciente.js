const express = require('express');
const router = express.Router();
const Paciente = require('../models/Paciente');

let pacientes = [];
let nextId = 1;
let rota = '/paciente';

// Listar todos
router.get(rota, (req, res) => {
  res.json(paciente);
});

// Buscar por ID
router.get('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const paciente = pacientes.find(f => f.id === id);
  if (!paciente) return res.status(404).json({ message: 'Paciente não encontrado' });
  res.json(paciente);
});

// Inserir
router.post('/', (req, res) => {
  const { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia } = req.body;
  const paciente = new Paciente(nextId++,nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia);
  pacientes.push(paciente);
  res.status(201).json(paciente);
});

// Editar
router.put('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const paciente = pacientes.find(f => f.id === id);
  if (!paciente) return res.status(404).json({ message: 'Paciente não encontrado' });

  const { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia } = req.body;
  paciente.nome = nome ?? paciente.nome;
  paciente.dataNascimento = dataNascimento ?? paciente.dataNascimento;
  paciente.telefone = telefone ?? paciente.telefone;
  paciente.email = email ?? paciente.email;
  paciente.nomeMae = nomeMae ?? paciente.nomeMae;
  paciente.idade = idade ?? paciente.idade;
  paciente.medicamento = medicamento ?? paciente.medicamento;
  paciente.patologia = patologia ?? paciente.patologia;
  

  res.json(paciente);
});

// Excluir
router.delete('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const index = pacientes.findIndex(f => f.id === id);
  if (index === -1) return res.status(404).json({ message: 'Paciente não encontrado' });

  pacientes.splice(index, 1);
  res.status(204).send();
});

module.exports = router;
