const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');

const pacientesRouter = require('./routes/pacientes');
const examesRouter = require('./routes/exame');

const app = express();
app.use('/paciente', pacientesRouter);
app.use('/exame', examesRouter);

const DATA_FILE = path.join(__dirname, 'fabricantes.json');

app.use(bodyParser.json());

function lerFabricantes() {
  if (!fs.existsSync(DATA_FILE)) return [];
  const data = fs.readFileSync(DATA_FILE, 'utf-8');
  return JSON.parse(data);
}

function salvarFabricantes(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2));
}

function getNextId(fabricantes) {
  return fabricantes.length > 0 ? Math.max(...fabricantes.map(f => f.id)) + 1 : 1;
}

// Listar todos os fabricantes


// Buscar fabricante por ID
app.get('/fabricantes/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const fabricantes = lerFabricantes();
  const fabricante = fabricantes.find(f => f.id === id);
  if (!fabricante) return res.status(404).json({ message: 'Fabricante não encontrado' });
  res.json(fabricante);
});

// Inserir novo fabricante
app.post('/fabricantes', (req, res) => {
  const { nome, endereco, documento } = req.body;
  const fabricantes = lerFabricantes();
  const novoFabricante = { id: getNextId(fabricantes), nome, endereco, documento };
  fabricantes.push(novoFabricante);
  salvarFabricantes(fabricantes);
  res.status(201).json(novoFabricante);
});

// Editar fabricante existente
app.put('/fabricantes/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const fabricantes = lerFabricantes();
  const fabricante = fabricantes.find(f => f.id === id);
  if (!fabricante) return res.status(404).json({ message: 'Fabricante não encontrado' });

  const { nome, endereco, documento } = req.body;
  fabricante.nome = nome ?? fabricante.nome;
  fabricante.endereco = endereco ?? fabricante.endereco;
  fabricante.documento = documento ?? fabricante.documento;

  salvarFabricantes(fabricantes);
  res.json(fabricante);
});

// Excluir fabricante
app.delete('/fabricantes/:id', (req, res) => {
  const id = parseInt(req.params.id);
  let fabricantes = lerFabricantes();
  const index = fabricantes.findIndex(f => f.id === id);
  if (index === -1) return res.status(404).json({ message: 'Fabricante não encontrado' });

  fabricantes.splice(index, 1);
  salvarFabricantes(fabricantes);
  res.status(204).send();
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`API rodando na porta ${PORT}`);
});
