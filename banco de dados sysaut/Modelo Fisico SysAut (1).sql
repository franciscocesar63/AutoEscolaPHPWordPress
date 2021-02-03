CREATE DATABASE sysaut DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE sysaut;

CREATE TABLE endereco (
idEndereco INT AUTO_INCREMENT,
logradouro VARCHAR(30) NOT NULL,
numero VARCHAR(10) DEFAULT "s/nº",
bairro VARCHAR(30) NOT NULL,
complemento VARCHAR(30),
CEP VARCHAR(15) NOT NULL,
cidade VARCHAR(30) NOT NULL,
CONSTRAINT pk_idEndereco PRIMARY KEY(idEndereco) 
)ENGINE=InnoDB;

CREATE TABLE pessoa (
idPessoa INT AUTO_INCREMENT,
nome VARCHAR(30) NOT NULL,
CPF varchar(11) UNIQUE NOT NULL, 
RG varchar(11) DEFAULT NULL,
email varchar(30) DEFAULT NULL,
idEndereco int NOT NULL,
CONSTRAINT pk_idPessoa PRIMARY KEY(idPessoa), 
CONSTRAINT fk_pessoa_endereco FOREIGN KEY(idEndereco) REFERENCES endereco(idEndereco)
)ENGINE=InnoDB;

CREATE TABLE telefone (
idTelefone INT AUTO_INCREMENT,
idPessoa INT NOT NULL,
numero VARCHAR(18) NOT NULL,
tipo VARCHAR(15) NOT NULL,
CONSTRAINT pk_idTelefone PRIMARY KEY(idTelefone),
CONSTRAINT fk_pessoa_telefone FOREIGN KEY(idPessoa) REFERENCES pessoa(idPessoa)
)ENGINE=InnoDB;

CREATE TABLE usuario (
idUsuario INT,
login VARCHAR(30) UNIQUE NOT NULL,
senha VARCHAR(30) NOT NULL,
privilegio INT NOT NULL,
CONSTRAINT pk_idUsuario PRIMARY KEY(idUsuario),
CONSTRAINT fk_pessoa_usuario FOREIGN KEY(idUsuario) REFERENCES Pessoa(idPessoa)
)ENGINE=InnoDB;

CREATE TABLE funcionario (
idFuncionario INT,
cargo VARCHAR(30) NOT NULL,
salario DOUBLE NOT NULL,
dataAdmissão DATE NOT NULL,
dataSaida DATE NOT NULL,
CONSTRAINT pk_idFuncionario PRIMARY KEY(idFuncionario),
CONSTRAINT fk_pessaoa_usuario FOREIGN KEY(idFuncionario) REFERENCES Usuario(idUsuario)
)ENGINE=InnoDB;

CREATE TABLE veiculo (
idVeiculo INT AUTO_INCREMENT,
modelo VARCHAR(30),
marca VARCHAR(30),
placa VARCHAR(30),
chassi VARCHAR(30),
tipo VARCHAR(4),
CONSTRAINT pk_idVeiculo PRIMARY KEY(idVeiculo)
)ENGINE=InnoDB;

CREATE TABLE aluno (
idAluno INT,
dataIngresso DATE,
CONSTRAINT pk_idAluno PRIMARY KEY(idAluno),
CONSTRAINT fk_aluno_pessoa FOREIGN KEY(idAluno) REFERENCES Pessoa (idPessoa)
)ENGINE=InnoDB;

CREATE TABLE instrutor (
idInstrutor INT,
numeroCFC VARCHAR(30),
nomeCFC VARCHAR(30),
CONSTRAINT pk_idInstrutor PRIMARY KEY(idInstrutor),
CONSTRAINT fk_instrutor_pessoa FOREIGN KEY(idInstrutor) REFERENCES Funcionario (idFuncionario)
)ENGINE=InnoDB;

CREATE TABLE secretaria (
idSecretaria INT,
CONSTRAINT pk_idSecretaria PRIMARY KEY(idSecretaria),
CONSTRAINT fk_pessoa_secretaria FOREIGN KEY(idSecretaria) REFERENCES Funcionario (idFuncionario)
)ENGINE=InnoDB;

CREATE TABLE gerente (
idGerente INT,
CONSTRAINT pk_idGerente PRIMARY KEY(idAGerente),
CONSTRAINT fk_gerente_pessoa FOREIGN KEY(idGerente) REFERENCES Funcionario (idFuncionario)
)ENGINE=InnoDB;

CREATE TABLE aula (
idAula INT AUTO_INCREMENT,
tipo VARCHAR(7) NOT NULL,
inicio TIME NOT NULL,
termino TIME NOT NULL,
dataAula DATE NOT NULL,
numAulas INT NOT NULL,
cargaHoraria INT NOT NULL,
idInstrutor INT NOT NULL,
CONSTRAINT pk_idAula PRIMARY KEY(idAula), 
CONSTRAINT fk_aula_instrutor FOREIGN KEY(idInstrutor) REFERENCES Instrutor (idInstrutor)
)ENGINE=InnoDB;

CREATE TABLE teorica (
idTeorica INT,
assunto VARCHAR(30) NOT NULL,
CONSTRAINT pk_idTeorica PRIMARY KEY(idTeorica),
CONSTRAINT fk_aula_teorica FOREIGN KEY(idTeorica) REFERENCES Aula (idAula)
)ENGINE=InnoDB;

CREATE TABLE pratica (
idPratica INT,
idVeiculo INT NOT NULL,
CONSTRAINT pk_idPratica PRIMARY KEY(idPratica),
CONSTRAINT fk_aula_pratica FOREIGN KEY(idPratica) REFERENCES Aula (idAula),
CONSTRAINT fk_prativa_veiculo FOREIGN KEY(idVeiculo) REFERENCES Veiculo (idVeiculo)
)ENGINE=InnoDB;

CREATE TABLE aluno_aula (
idAluno INT NOT NULL,
idAula INT NOT NULL,
horasCursadas DATE NOT NULL,
quantidade DATE NOT NULL,
PRIMARY KEY(idAluno,idAula),
FOREIGN KEY(idAluno) REFERENCES Aluno (idAluno),
FOREIGN KEY(idAula) REFERENCES Aula (idAula)
)ENGINE=InnoDB;


