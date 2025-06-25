const express = require('express');
const fs = require('fs');
const path = require('path');
const router = express.Router();

const examesFilePath = path.join(__dirname, '../exame.json');

// Função para ler o arquivo JSON
const readExames = () => {
  const data = fs.readFileSync(examesFilePath, 'utf-8');
  return JSON.parse(data || '[]'); // Retorna um array vazio se o arquivo estiver vazio
};

// Função para salvar no arquivo JSON
const writeExames = (exames) => {
  fs.writeFileSync(examesFilePath, JSON.stringify(exames, null, 2), 'utf-8');
};

// Listar todos os exames
router.get('/', (req, res) => {
  const exames = readExames();
  res.json(exames);
});

// Buscar exame por ID
router.get('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const exames = readExames();
  const exame = exames.find((e, index) => index === id);
  if (!exame) return res.status(404).json({ message: 'Exame não encontrado' });
  res.json(exame);
});

// Inserir novo exame
router.post('/', (req, res) => {
  const { idPaciente, laboratorio, exameTexto, dataExame, resultado, informacoesAdicionais } = req.body;
  const exames = readExames();
  const novoExame = { idPaciente, laboratorio, exameTexto, dataExame, resultado, informacoesAdicionais };
  exames.push(novoExame);
  writeExames(exames);
  res.status(201).json(novoExame);
});

// Editar exame
router.put('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const { idPaciente, laboratorio, exameTexto, dataExame, resultado, informacoesAdicionais } = req.body;
  const exames = readExames();
  if (id < 0 || id >= exames.length) return res.status(404).json({ message: 'Exame não encontrado' });
  exames[id] = { idPaciente, laboratorio, exameTexto, dataExame, resultado, informacoesAdicionais };
  writeExames(exames);
  res.json(exames[id]);
});

// Excluir exame
router.delete('/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const exames = readExames();
  if (id < 0 || id >= exames.length) return res.status(404).json({ message: 'Exame não encontrado' });
  exames.splice(id, 1);
  writeExames(exames);
  res.status(204).send();
});

module.exports = router;
