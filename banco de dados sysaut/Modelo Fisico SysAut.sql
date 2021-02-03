-- Geração de Modelo físico
-- Sql ANSI 2003 - brModelo.



CREATE DATABASE teste;

CREATE TABLE endereco (
idEndereco int PRIMARY KEY,
logradouro varchar(30),
numero int,
bairro varchar(30),
complemento varchar(30),
CEP varchar(15),
cidade varchar(30)
);

CREATE TABLE pessoa (
idPessoa int PRIMARY KEY,
nome varchar(30),
CPF varchar(11) UNIQUE,
RG varchar(11),
email varchar(30),
idEndereco int,
FOREIGN KEY(idEndereco) REFERENCES Endereco (idEndereco)
);

CREATE TABLE telefone (
idPessoa int,
numero varchar(18),
tipo varchar(15),
PRIMARY KEY(idPessoa,numero),
FOREIGN KEY(idPessoa) REFERENCES Pessoa (idPessoa)
);

CREATE TABLE usuario (
idUsuario int PRIMARY KEY,
login varchar(30) UNIQUE,
senha varchar(30),
privilegio int,
FOREIGN KEY(idUsuario) REFERENCES Pessoa (idPessoa)
);

CREATE TABLE Funcionario (
idFuncionario int PRIMARY KEY,
cargo varchar(30),
salario double,
dataAdmissão date,
dataSaida date,
FOREIGN KEY(idFuncionario) REFERENCES Usuario (idUsuario)
);

CREATE TABLE Veiculo (
idVeiculo int PRIMARY KEY,
modelo varchar(30),
marca varchar(30),
placa varchar(30),
chassi varchar(30),
tipo varchar(4)
);

CREATE TABLE Aluno (
idAluno int PRIMARY KEY,
dataIngresso date,
FOREIGN KEY(idAluno) REFERENCES Pessoa (idPessoa)
);

CREATE TABLE Instrutor (
idInstrutor int PRIMARY KEY,
numeroCFC varchar(30),
nomeCFC varchar(30),
FOREIGN KEY(idInstrutor) REFERENCES Funcionario (idFuncionario)
);

CREATE TABLE Secretaria (
idSecretaria int PRIMARY KEY,
FOREIGN KEY(idSecretaria) REFERENCES Funcionario (idFuncionario)
);

CREATE TABLE Gerente (
idGerente int PRIMARY KEY,
FOREIGN KEY(idGerente) REFERENCES Funcionario (idFuncionario)
);

CREATE TABLE Aula (
idAula int PRIMARY KEY,
tipo varchar(7),
inicio time,
termino time,
data date,
numAulas int,
cargaHoraria int,
idInstrutor int,
FOREIGN KEY(idInstrutor) REFERENCES Instrutor (idInstrutor)
);

CREATE TABLE Teorica (
idTeorica int PRIMARY KEY,
assunto varchar(30),
FOREIGN KEY(idTeorica) REFERENCES Aula (idAula)
);

CREATE TABLE Pratica (
idPratica int PRIMARY KEY,
idVeiculo int,
FOREIGN KEY(idPratica) REFERENCES Aula (idAula),
FOREIGN KEY(idVeiculo) REFERENCES Veiculo (idVeiculo)
);

CREATE TABLE aluno_aula (
idAluno int,
idAula int,
horasCursadas date,
quantidade date,
PRIMARY KEY(idAluno,idAula),
FOREIGN KEY(idAluno) REFERENCES Aluno (idAluno),
FOREIGN KEY(idAula) REFERENCES Aula (idAula)
);


