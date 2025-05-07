<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_faculdade";
$port = 3307;

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

/* BANCO DE DADOS USADO NOS TESTES


CREATE DATABASE IF NOT EXISTS lab_faculdade;
USE lab_faculdade;

CREATE TABLE pacientes (
    idPaciente VARCHAR(8) PRIMARY KEY,
    dataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nomeCompleto VARCHAR(100) NOT NULL,
    dataNascimento DATE NOT NULL,
    idade INT NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    nomeMae VARCHAR(100),
    nomeMedicamento VARCHAR(100),
    nomePatologia VARCHAR(100)
);

CREATE TABLE exames (
    idExame INT AUTO_INCREMENT PRIMARY KEY,
    idPaciente VARCHAR(8),
    laboratorio VARCHAR(100) NOT NULL,
    exameTexto TEXT NOT NULL,
    dataExame TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idPaciente) REFERENCES pacientes(idPaciente),
    resultado TEXT
); 

ALTER TABLE exames
DROP FOREIGN KEY exames_ibfk_1;

ALTER TABLE exames
ADD CONSTRAINT exames_ibfk_1
FOREIGN KEY (idPaciente) REFERENCES pacientes(idPaciente)
ON DELETE CASCADE;

*/

