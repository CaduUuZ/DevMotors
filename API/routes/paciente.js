const express = require('express');
const fs = require('fs');
const path = require('path');
const router = express.Router();

const pacientesFilePath = path.join(__dirname, '../paciente.json');

// Função para ler o arquivo JSON
const readPacientes = () => {
  const data = fs.readFileSync(pacientesFilePath, 'utf-8');
  return JSON.parse(data);
};

// Função para salvar no arquivo JSON
const writePacientes = (pacientes) => {
  fs.writeFileSync(pacientesFilePath, JSON.stringify(pacientes, null, 2), 'utf-8');
};

// Listar todos os pacientes
router.get('/', (req, res) => {
  const pacientes = readPacientes();
  res.json(pacientes);
});

// Buscar paciente por ID
router.get('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const pacientes = readPacientes();
  const paciente = pacientes.find((p, index) => index === id);
  if (!paciente) return res.status(404).json({ message: 'Paciente não encontrado' });
  res.json(paciente);
});

// Inserir novo paciente
router.post('/', (req, res) => {
  const { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia } = req.body;
  const pacientes = readPacientes();
  const novoPaciente = { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia };
  pacientes.push(novoPaciente);
  writePacientes(pacientes);
  res.status(201).json(novoPaciente);
});

// Editar paciente
router.put('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia } = req.body;
  const pacientes = readPacientes();
  if (id < 0 || id >= pacientes.length) return res.status(404).json({ message: 'Paciente não encontrado' });
  pacientes[id] = { nome, dataNascimento, telefone, email, nomeMae, idade, medicamento, patologia };
  writePacientes(pacientes);
  res.json(pacientes[id]);
});

// Excluir paciente
router.delete('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const pacientes = readPacientes();
  if (id < 0 || id >= pacientes.length) return res.status(404).json({ message: 'Paciente não encontrado' });
  pacientes.splice(id, 1);
  writePacientes(pacientes);
  res.status(204).send();
});

module.exports = router;
