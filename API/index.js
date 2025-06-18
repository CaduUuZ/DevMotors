const express = require('express');
const app = express();

// Middleware para interpretar JSON
app.use(express.json());

// Importando as rotas
const pacienteRoutes = require('./routes/paciente');
const exameRoutes = require('./routes/exame');

// Usando as rotas com prefixos
app.use('/pacientes', pacienteRoutes);
app.use('/exames', exameRoutes);

// Rota raiz (opcional)
app.get('/', (req, res) => {
  res.send('API DevMotors rodando!');
});

// Iniciando o servidor
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`API rodando na porta ${PORT}`);
});
