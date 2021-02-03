CREATE DATABASE sysaut DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE sysaut;

CREATE TABLE endereco (
idEndereco INT NOT NULL AUTO_INCREMENT,
logradouro VARCHAR(30) NOT NULL,
numero VARCHAR(10) DEFAULT "s/nº",
bairro VARCHAR(30) NOT NULL,
complemento VARCHAR(30),
CEP VARCHAR(15) NOT NULL,
cidade VARCHAR(30) NOT NULL,
CONSTRAINT pk_idEndereco PRIMARY KEY(idEndereco) 
)ENGINE=InnoDB;

CREATE TABLE pessoa (
idPessoa INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(30) NOT NULL,
cpf varchar(11) UNIQUE NOT NULL, 
rg varchar(11) DEFAULT NULL,
email varchar(30) DEFAULT NULL,
idEndereco INT DEFAULT NULL,
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
idUsuario INT NOT NULL,
login VARCHAR(30) UNIQUE NOT NULL,
senha VARCHAR(30) NOT NULL,
privilegio INT NOT NULL,
CONSTRAINT pk_idUsuario PRIMARY KEY(idUsuario),
CONSTRAINT fk_pessoa_usuario FOREIGN KEY(idUsuario) REFERENCES Pessoa(idPessoa)
)ENGINE=InnoDB;

CREATE TABLE funcionario (
idFuncionario INT NOT NULL,
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
idAluno INT NOT NULL,
dataIngresso DATE,
CONSTRAINT pk_idAluno PRIMARY KEY(idAluno),
CONSTRAINT fk_aluno_pessoa FOREIGN KEY(idAluno) REFERENCES Pessoa (idPessoa)
)ENGINE=InnoDB;

CREATE TABLE instrutor (
idInstrutor INT NOT NULL,
numeroCFC VARCHAR(30),
nomeCFC VARCHAR(30),
CONSTRAINT pk_idInstrutor PRIMARY KEY(idInstrutor),
CONSTRAINT fk_instrutor_pessoa FOREIGN KEY(idInstrutor) REFERENCES Funcionario (idFuncionario)
)ENGINE=InnoDB;

CREATE TABLE secretaria (
idSecretaria INT NOT NULL,
CONSTRAINT pk_idSecretaria PRIMARY KEY(idSecretaria),
CONSTRAINT fk_pessoa_secretaria FOREIGN KEY(idSecretaria) REFERENCES Funcionario (idFuncionario)
)ENGINE=InnoDB;

CREATE TABLE gerente (
idGerente INT NOT NULL,
CONSTRAINT pk_idGerente PRIMARY KEY(idGerente),
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
idTeorica INT NOT NULL,
assunto VARCHAR(30) NOT NULL,
CONSTRAINT pk_idTeorica PRIMARY KEY(idTeorica),
CONSTRAINT fk_aula_teorica FOREIGN KEY(idTeorica) REFERENCES Aula (idAula)
)ENGINE=InnoDB;

CREATE TABLE pratica (
idPratica INT NOT NULL,
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
CONSTRAINT pk_idAluno_idAula PRIMARY KEY(idAluno,idAula),
CONSTRAINT fk_idAluno FOREIGN KEY(idAluno) REFERENCES Aluno (idAluno),
CONSTRAINT fk_idAula FOREIGN KEY(idAula) REFERENCES Aula (idAula)
)ENGINE=InnoDB;

DELIMITER $$
CREATE PROCEDURE insert_aluno(iNome VARCHAR(30), iDataIngresso DATE, iCpf VARCHAR(11), iRg VARCHAR(11), iEmail VARCHAR(30), iIdEndereco INT)
	BEGIN 
		INSERT INTO sysaut.pessoa(nome, cpf, rg, email, idEndereco) VALUES(iNome, iCpf, iRg, iEmail, iIdEndereco);
        INSERT INTO sysaut.aluno(idAluno, dataIngresso) VALUES(last_insert_id(), iDataIngresso);
	END $$
 
CREATE PROCEDURE insert_usuario(iLogin VARCHAR(30), iSenha VARCHAR(30), iPrivilegio INT, iNome VARCHAR(30), iCpf VARCHAR(11), iRg VARCHAR(11), iEmail VARCHAR(30), iIdEndereco INT)
	BEGIN 
		INSERT INTO sysaut.pessoa(nome, cpf, rg, email, idEndereco) VALUES(newNome, newCpf, newRg, newEmail, newIdEndereco);
        INSERT INTO sysaut.usuario(idUsuario, login, senha, privilegio) VALUES(last_insert_id(), newlogin, newSenha, newPrivilegio);
	END $$

CREATE PROCEDURE insert_funcionario(iCargo VARCHAR(30), iSalario DOUBLE, newLogin VARCHAR(30), newSenha VARCHAR(30), newPrivilegio INT, newNome VARCHAR(30), newCpf VARCHAR(11), newRg VARCHAR(11), newEmail VARCHAR(30), newIdEndereco INT)
	BEGIN 
		CALL sysaut.insert_usuario(newLogin, newSenha, newPrivilegio, newNome, newCpf, newRg, newEmail, newIdEndereco);
        INSERT INTO sysaut.funcionario(idUsuario, login, senha, privilegio) VALUES(last_insert_id(), newlogin, newSenha, newPrivilegio);
	END $$
 
DELIMITER ;

ALTER TABLE pessoa AUTO_INCREMENT = 1;
 
CALL insert_aluno('Anderson', NOW(), '08401220475', '3264355', 'andersonf100@gmail.com', NULL);

CALL insert_usuario('A123', '12345', 1, 'bbb', '123344433', '122456', 'aasas@sass', NULL);

CALL insert_aluno('Aaaaaaa', NOW(), '08401223434', '3264343445', 'andersonf100@gmail.com', NULL);

DROP PROCEDURE insert_aluno;

