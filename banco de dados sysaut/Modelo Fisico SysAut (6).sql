CREATE DATABASE projetobd1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE projetobd1;

CREATE TABLE endereco (
idEndereco INT NOT NULL AUTO_INCREMENT,
logradouro VARCHAR(30) NOT NULL,
numero VARCHAR(10) DEFAULT "s/nº",
bairro VARCHAR(30) NOT NULL,
complemento VARCHAR(30) DEFAULT NULL,
cep VARCHAR(15) NOT NULL,
cidade VARCHAR(30) NOT NULL,
CONSTRAINT pk_idEndereco PRIMARY KEY(idEndereco) 
)ENGINE=InnoDB;

CREATE TABLE pessoa (
idPessoa INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(30) NOT NULL,
sexo ENUM('masculino', 'feminino') NOT NULL,
cpf varchar(11) NOT NULL, 
rg varchar(11) DEFAULT NULL,
email varchar(30) DEFAULT NULL,
idEndereco INT DEFAULT NULL,
CONSTRAINT pk_idPessoa PRIMARY KEY(idPessoa), 
CONSTRAINT fk_pessoa_endereco FOREIGN KEY(idEndereco) REFERENCES endereco(idEndereco),
CONSTRAINT uk_cpf UNIQUE KEY(cpf) 
)ENGINE=InnoDB;

CREATE TABLE telefone (
idTelefone INT NOT NULL AUTO_INCREMENT,
idPessoa INT NOT NULL,
numero VARCHAR(18) NOT NULL,
CONSTRAINT pk_idTelefone PRIMARY KEY(idTelefone),
CONSTRAINT fk_pessoa_telefone FOREIGN KEY(idPessoa) REFERENCES pessoa(idPessoa) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE usuario (
idUsuario INT NOT NULL,
login VARCHAR(30) NOT NULL,
senha VARCHAR(30) NOT NULL,
permissao ENUM('1','2','3') NOT NULL,
CONSTRAINT pk_idUsuario PRIMARY KEY(idUsuario),
CONSTRAINT fk_pessoa_usuario FOREIGN KEY(idUsuario) REFERENCES Pessoa(idPessoa) ON DELETE CASCADE,
CONSTRAINT uk_login UNIQUE KEY(login)
)ENGINE=InnoDB;

CREATE TABLE funcionario (
idFuncionario INT NOT NULL,
cargo ENUM('gerente', 'instrutor', 'secretaria') NOT NULL,
salario DECIMAL NOT NULL,
dataAdmissao DATE NOT NULL,
dataSaida DATE DEFAULT NULL,
CONSTRAINT pk_idFuncionario PRIMARY KEY(idFuncionario),
CONSTRAINT fk_pessaoa_usuario FOREIGN KEY(idFuncionario) REFERENCES Usuario(idUsuario) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE veiculo (
idVeiculo INT NOT NULL AUTO_INCREMENT,
modelo VARCHAR(30) NOT NULL,
marca VARCHAR(30) NOT NULL,
ano YEAR NOT NULL,
placa VARCHAR(30) NOT NULL,
chassi VARCHAR(30) NOT NULl,
tipoVeiculo Enum('carro', 'moto') NOT NULL,
CONSTRAINT pk_idVeiculo PRIMARY KEY(idVeiculo),
CONSTRAINT uk_chassi UNIQUE KEY(chassi)
)ENGINE=InnoDB;

CREATE TABLE aluno (
idAluno INT NOT NULL,
matricula VARCHAR(10) NOT NULL,
dataIngresso DATE,
CONSTRAINT pk_idAluno PRIMARY KEY(idAluno),
CONSTRAINT fk_aluno_pessoa FOREIGN KEY(idAluno) REFERENCES Pessoa (idPessoa) ON DELETE CASCADE,
CONSTRAINT uk_matricula UNIQUE KEY(matricula)
)ENGINE=InnoDB;

CREATE TABLE instrutor (
idInstrutor INT NOT NULL,
numeroCNH VARCHAR(15),
CONSTRAINT pk_idInstrutor PRIMARY KEY(idInstrutor),
CONSTRAINT fk_instrutor_pessoa FOREIGN KEY(idInstrutor) REFERENCES Funcionario (idFuncionario) ON DELETE CASCADE,
CONSTRAINT uk_numeroCNH UNIQUE KEY(numeroCNH)
)ENGINE=InnoDB;

CREATE TABLE secretaria (
idSecretaria INT NOT NULL,
CONSTRAINT pk_idSecretaria PRIMARY KEY(idSecretaria),
CONSTRAINT fk_pessoa_secretaria FOREIGN KEY(idSecretaria) REFERENCES Funcionario (idFuncionario) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE gerente (
idGerente INT NOT NULL,
CONSTRAINT pk_idGerente PRIMARY KEY(idGerente),
CONSTRAINT fk_gerente_pessoa FOREIGN KEY(idGerente) REFERENCES Funcionario (idFuncionario) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE aula (
idAula INT NOT NULL AUTO_INCREMENT,
tipoAula VARCHAR(7) NOT NULL,
dataAula DATE NOT NULL,
inicio TIME NOT NULL,
duracao TIME NOT NULL,
quantidade INT NOT NULL,
idInstrutor INT NOT NULL,
CONSTRAINT pk_idAula PRIMARY KEY(idAula), 
CONSTRAINT fk_aula_instrutor FOREIGN KEY(idInstrutor) REFERENCES Instrutor (idInstrutor)
)ENGINE=InnoDB;

CREATE TABLE teorica (
idTeorica INT NOT NULL,
assunto VARCHAR(30) NOT NULL,
CONSTRAINT pk_idTeorica PRIMARY KEY(idTeorica),
CONSTRAINT fk_aula_teorica FOREIGN KEY(idTeorica) REFERENCES Aula (idAula) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE pratica (
idPratica INT NOT NULL,
idVeiculo INT DEFAULT NULL,
CONSTRAINT pk_idPratica PRIMARY KEY(idPratica),
CONSTRAINT fk_aula_pratica FOREIGN KEY(idPratica) REFERENCES Aula (idAula),
CONSTRAINT fk_prativa_veiculo FOREIGN KEY(idVeiculo) REFERENCES Veiculo (idVeiculo) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE aluno_aula (
idAluno INT NOT NULL,
idAula INT NOT NULL,
assistidas INT NOT NULL,
CONSTRAINT pk_idAluno_idAula PRIMARY KEY(idAluno,idAula),
CONSTRAINT fk_idAluno FOREIGN KEY(idAluno) REFERENCES Aluno (idAluno) ON DELETE CASCADE,
CONSTRAINT fk_idAula FOREIGN KEY(idAula) REFERENCES Aula (idAula) ON DELETE CASCADE
)ENGINE=InnoDB;

DELIMITER $$

CREATE FUNCTION gera_matricula(ano YEAR, lastId INT) RETURNS VARCHAR(10)
	BEGIN
		IF lastId < 10 THEN
			RETURN concat(ano, '000',lastId); 
        ELSEIF lastId >= 10 AND lastId <= 99 THEN
			RETURN concat(ano, '00' , lastId);
		ELSEIF lastId > 99 AND lastId <= 999 THEN
			RETURN concat(ano, '0' , lastId);
		ELSE RETURN concat(ano, lastId);
        END IF;
	END $$
	
CREATE PROCEDURE insert_pessoa(iNome VARCHAR(30), iSexo ENUM('masculino', 'feminino'),iCpf VARCHAR(11), iRg VARCHAR(11), iEmail VARCHAR(30), 
					iTelefone VARCHAR(18), iLogradouro VARCHAR(30), iNumeroCasa VARCHAR(10), iBairro VARCHAR(30), iComplemento VARCHAR(30), 
                    iCep VARCHAR(15), iCidade VARCHAR(30))
	BEGIN
		INSERT INTO endereco(logradouro, numero, bairro, complemento, cep, cidade) 
        VALUES(iLogradouro, iNumeroCasa, iBairro, iComplemento, iCep, iCidade);
        INSERT INTO pessoa(nome, sexo, cpf, rg, email, idEndereco) 
        VALUES(iNome, iSexo, iCpf, iRg, iEmail, last_insert_id());
        INSERT INTO telefone(idPessoa, numero) VALUE(last_insert_id(), iTelefone);
	END $$
    
CREATE PROCEDURE insert_aluno(iNome VARCHAR(30), iSexo ENUM('masculino', 'feminino'), iCpf VARCHAR(11), iRg VARCHAR(11), iEmail VARCHAR(30), 
					iTelefone VARCHAR(18), iLogradouro VARCHAR(30), iNumeroCasa VARCHAR(10), iBairro VARCHAR(30), iComplemento VARCHAR(30), 
                    iCep VARCHAR(15), iCidade VARCHAR(30))
	BEGIN 
		CALL insert_pessoa(iNome, iSexo, iCpf, iRg, iEmail, iTelefone, iLogradouro, iNumeroCasa, iBairro, iComplemento, iCep, iCidade);
        INSERT INTO aluno(idAluno, matricula,dataIngresso) VALUES(last_insert_id(), gera_matricula(year(now()), last_insert_id()), utc_date());
	END $$
 

CREATE PROCEDURE insert_instrutor(iNome VARCHAR(30), iSexo ENUM('masculino', 'feminino'),iCpf VARCHAR(11), iRg VARCHAR(11), iEmail VARCHAR(30), 
					iTelefone VARCHAR(18), iLogradouro VARCHAR(30), iNumeroCasa VARCHAR(10), iBairro VARCHAR(30), iComplemento VARCHAR(30), 
                    iCep VARCHAR(15), iCidade VARCHAR(30), iLogin VARCHAR(30), iSenha VARCHAR(30), iPermissao ENUM('1','2','3'), 
                    iCargo ENUM('gerente', 'instrutor', 'secretaria'), iSalario DECIMAL, iNumeroCNH VARCHAR(30))
	BEGIN
		CALL insert_pessoa(iNome, iSexo, iCpf, iRg, iEmail, iTelefone, iLogradouro, iNumeroCasa, iBairro, iComplemento, iCep, iCidade);
        INSERT INTO usuario(idUsuario, login, senha, permissao) VALUES(last_insert_id(), iLogin, iSenha, iPermissao);
        INSERT INTO funcionario(idFuncionario, cargo, salario, dataAdmissao) VALUES(last_insert_id(), iCargo, iSalario, utc_date());
        INSERT INTO instrutor(idInstrutor, numeroCNH) VALUES (last_insert_id(), iNumeroCNH); 
    END $$

CREATE PROCEDURE insert_secretaria(iNome VARCHAR(30), iSexo ENUM('masculino', 'feminino'),iCpf VARCHAR(11), iRg VARCHAR(11), iEmail VARCHAR(30), 
					iTelefone VARCHAR(18), iLogradouro VARCHAR(30), iNumeroCasa VARCHAR(10), iBairro VARCHAR(30), iComplemento VARCHAR(30), 
                    iCep VARCHAR(15), iCidade VARCHAR(30), iLogin VARCHAR(30), iSenha VARCHAR(30), iPermissao ENUM('1','2','3'), 
                    iCargo ENUM('gerente', 'instrutor', 'secretaria'), iSalario DECIMAL)
	BEGIN
		CALL insert_pessoa(iNome, iSexo, iCpf, iRg, iEmail, iTelefone, iLogradouro, iNumeroCasa, iBairro, iComplemento, iCep, iCidade);
        INSERT INTO usuario(idUsuario, login, senha, permissao) VALUES(last_insert_id(), iLogin, iSenha, iPermissao);
        INSERT INTO funcionario(idFuncionario, cargo, salario, dataAdmissao) VALUES(last_insert_id(), iCargo, iSalario, utc_date());
        INSERT INTO secretaria(idSecretaria) VALUES (last_insert_id()); 
    END $$

 CREATE PROCEDURE insert_gerente(iNome VARCHAR(30), iSexo ENUM('masculino', 'feminino'),iCpf VARCHAR(11), iRg VARCHAR(11), iEmail VARCHAR(30), 
					iTelefone VARCHAR(18), iLogradouro VARCHAR(30), iNumeroCasa VARCHAR(10), iBairro VARCHAR(30), iComplemento VARCHAR(30), 
                    iCep VARCHAR(15), iCidade VARCHAR(30), iLogin VARCHAR(30), iSenha VARCHAR(30), iPermissao ENUM('1','2','3'), 
                    iCargo ENUM('gerente', 'instrutor', 'secretaria'), iSalario DECIMAL)
	BEGIN
		CALL insert_pessoa(iNome, iSexo, iCpf, iRg, iEmail, iTelefone, iLogradouro, iNumeroCasa, iBairro, iComplemento, iCep, iCidade);
        INSERT INTO usuario(idUsuario, login, senha, permissao) VALUES(last_insert_id(), iLogin, iSenha, iPermissao);
        INSERT INTO funcionario(idFuncionario, cargo, salario, dataAdmissao) VALUES(last_insert_id(), iCargo, iSalario, utc_date());
        INSERT INTO gerente(idGerente) VALUES (last_insert_id()); 
    END $$
 
CREATE PROCEDURE insert_aula_teorica(iTipoAula VARCHAR(7), iDataAula DATE, iInicio TIME, iDuracao TIME, iQuantidade INT, iIdInstrutor INT, 
					iAssunto VARCHAR(30))
	BEGIN
		INSERT INTO aula(tipoAula, dataAula, inicio, duracao, quantidade, idInstrutor) 
        VALUES(iTipoAula, iDataAula, iInicio, iDuracao, iQuantidade, iIdInstrutor);
        INSERT INTO teorica(idTeoria, assunto) VALUES(last_insert_id(), iAssunto); 
    END $$
 
 CREATE PROCEDURE insert_aula_pratica(iTipoAula VARCHAR(7), iDataAula DATE, iInicio TIME, iDuracao TIME, iQuantidade INT, iIdInstrutor INT, 
					iIdVeiculo INT)
	BEGIN
		INSERT INTO aula(tipoAula, dataAula, inicio, duracao, quantidade, idInstrutor) 
        VALUES(iTipoAula, iDataAula, iInicio, iDuracao, iQuantidade, iIdInstrutor);
        INSERT INTO sysaut.pratica(idPratica, idVeiculo) VALUES(last_insert_id(), iIdVeiculo); 
    END $$

CREATE PROCEDURE insert_veiculo(iModelo VARCHAR(30), iMarca VARCHAR(30), iAno YEAR, iPlaca VARCHAR(30), iChassi VARCHAR(30), 
		iTipoVeiculo Enum('carro', 'moto'))
	BEGIN
		INSERT INTO veiculo(modelo, marca, ano, placa, chassi, tipoVeiculo) VALUES(iModelo, iMarca, iAno, iPlaca, iChassi, iTipoVeiculo);
	END $$

    
DELIMITER ;