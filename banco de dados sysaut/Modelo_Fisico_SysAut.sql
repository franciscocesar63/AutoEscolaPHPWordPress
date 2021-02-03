CREATE DATABASE projetobd1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE projetobd1;

CREATE TABLE cidade ( 
id_cidade INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(50),
CONSTRAINT pk_id_cidade PRIMARY KEY(id_cidade) 
)ENGINE=InnoDB;

CREATE TABLE bairro (
id_bairro INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(50),
id_cidade INT,
CONSTRAINT pk_id_bairro PRIMARY KEY(id_bairro),
CONSTRAINT fk_id_cidade FOREIGN KEY(id_bairro) REFERENCES cidade(id_cidade) 
) ENGINE=InnoDB;

CREATE TABLE endereco (
id_endereco INT NOT NULL AUTO_INCREMENT,
logradouro VARCHAR(30) NOT NULL,
numero VARCHAR(10) DEFAULT "s/nº",
complemento VARCHAR(30) DEFAULT NULL,
cep VARCHAR(15) NOT NULL,
id_bairro INT NOT NULL,
CONSTRAINT pk_id_endereco PRIMARY KEY(id_endereco),
CONSTRAINT fk_id_bairro FOREIGN KEY(id_bairro) REFERENCES bairro(id_bairro)
)ENGINE=InnoDB;

CREATE TABLE pessoa (
id_pessoa INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(30) NOT NULL,
sexo ENUM('masculino', 'feminino') NOT NULL,
cpf varchar(11) NOT NULL, 
rg varchar(11) DEFAULT NULL,
email varchar(30) DEFAULT NULL,
CONSTRAINT pk_id_pessoa PRIMARY KEY(id_pessoa), 
CONSTRAINT uk_cpf UNIQUE KEY(cpf) 
)ENGINE=InnoDB;

CREATE TABLE telefone (
id_telefone INT NOT NULL AUTO_INCREMENT,
id_pessoa INT NOT NULL,
numero VARCHAR(18) NOT NULL,
CONSTRAINT pk_id_telefone PRIMARY KEY(id_telefone),
CONSTRAINT fk_pessoa_telefone FOREIGN KEY(id_pessoa) REFERENCES pessoa(id_pessoa) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE pessoa_endereco (
id_pessoa INT NOT NULL,
id_endereco INT NOT NULL,
CONSTRAINT pk_ids_pessoa_endereco PRIMARY KEY(id_pessoa, id_endereco),
CONSTRAINT fk_id_pessoa FOREIGN KEY(id_pessoa) REFERENCES pessoa(id_pessoa) ON DELETE CASCADE,
CONSTRAINT fk_id_endereco FOREIGN KEY(id_endereco) REFERENCES endereco(id_endereco) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE usuario (
id_usuario INT NOT NULL,
login VARCHAR(30) NOT NULL,
senha VARCHAR(30) NOT NULL,
permissao ENUM('1','2','3') NOT NULL,
CONSTRAINT pk_id_usuario PRIMARY KEY(id_usuario),
CONSTRAINT fk_pessoa_usuario FOREIGN KEY(id_usuario) REFERENCES Pessoa(id_pessoa) ON DELETE CASCADE,
CONSTRAINT uk_login UNIQUE KEY(login)
)ENGINE=InnoDB;

CREATE TABLE funcionario (
id_funcionario INT NOT NULL,
cargo ENUM('gerente', 'instrutor', 'secretaria') NOT NULL,
salario DECIMAL NOT NULL,
data_admissao DATE NOT NULL,
data_saida DATE DEFAULT NULL,
CONSTRAINT pk_id_funcionario PRIMARY KEY(id_funcionario),
CONSTRAINT fk_pessaoa_usuario FOREIGN KEY(id_funcionario) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE veiculo (
id_veiculo INT NOT NULL AUTO_INCREMENT,
modelo VARCHAR(30) NOT NULL,
marca VARCHAR(30) NOT NULL,
ano VARCHAR(4) NOT NULL,
placa VARCHAR(30) NOT NULL,
chassi VARCHAR(30) NOT NULl,
tipo Enum('carro', 'moto', 'onibus', 'caminhão') NOT NULL,
CONSTRAINT pk_id_veiculo PRIMARY KEY(id_veiculo),
CONSTRAINT uk_chassi UNIQUE KEY(chassi)
)ENGINE=InnoDB;

CREATE TABLE aluno (
id_aluno INT NOT NULL,
matricula VARCHAR(10) NOT NULL,
data_ingresso DATE,
CONSTRAINT pk_idAluno PRIMARY KEY(id_aluno),
CONSTRAINT fk_aluno_pessoa FOREIGN KEY(id_aluno) REFERENCES Pessoa (id_pessoa) ON DELETE CASCADE,
CONSTRAINT uk_matricula UNIQUE KEY(matricula)
)ENGINE=InnoDB;

CREATE TABLE instrutor (
id_instrutor INT NOT NULL,
numero_cnh VARCHAR(15),
CONSTRAINT pk_id_instrutor PRIMARY KEY(id_instrutor),
CONSTRAINT fk_instrutor_pessoa FOREIGN KEY(id_instrutor) REFERENCES Funcionario (id_funcionario) ON DELETE CASCADE,
CONSTRAINT uk_numero_CNH UNIQUE KEY(numero_CNH)
)ENGINE=InnoDB;

CREATE TABLE secretaria (
id_secretaria INT NOT NULL,
CONSTRAINT pk_id_secretaria PRIMARY KEY(id_secretaria),
CONSTRAINT fk_pessoa_secretaria FOREIGN KEY(id_secretaria) REFERENCES Funcionario (id_funcionario) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE gerente (
id_gerente INT NOT NULL,
CONSTRAINT pk_id_gerente PRIMARY KEY(id_gerente),
CONSTRAINT fk_gerente_pessoa FOREIGN KEY(id_gerente) REFERENCES Funcionario (id_funcionario) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE aula (
id_aula INT NOT NULL AUTO_INCREMENT,
tipo VARCHAR(7) NOT NULL,
dia DATE NOT NULL,
hora TIME NOT NULL,
duracao TIME NOT NULL,
quantidade INT NOT NULL,
id_instrutor INT NOT NULL,
CONSTRAINT pk_id_Aula PRIMARY KEY(id_aula), 
CONSTRAINT fk_aula_instrutor FOREIGN KEY(id_instrutor) REFERENCES Instrutor (id_instrutor)
)ENGINE=InnoDB;

CREATE TABLE teorica (
id_teorica INT NOT NULL,
assunto VARCHAR(30) NOT NULL,
CONSTRAINT pk_id_teorica PRIMARY KEY(id_teorica),
CONSTRAINT fk_aula_teorica FOREIGN KEY(id_teorica) REFERENCES Aula (id_aula) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE pratica (
id_pratica INT NOT NULL,
id_veiculo INT DEFAULT NULL,
CONSTRAINT pk_id_pratica PRIMARY KEY(id_pratica),
CONSTRAINT fk_aula_pratica FOREIGN KEY(id_pratica) REFERENCES Aula (id_aula),
CONSTRAINT fk_prativa_veiculo FOREIGN KEY(id_veiculo) REFERENCES Veiculo (id_veiculo) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE aluno_aula (
id_aluno INT NOT NULL,
id_aula INT NOT NULL,
assistidas INT NOT NULL,
CONSTRAINT pk_ids_aluno_aula PRIMARY KEY(id_aluno, id_aula),
CONSTRAINT fk_id_aluno FOREIGN KEY(id_aluno) REFERENCES aluno (id_aluno) ON DELETE CASCADE,
CONSTRAINT fk_id_aula FOREIGN KEY(id_aula) REFERENCES aula (id_aula) ON DELETE CASCADE
)ENGINE=InnoDB;

DELIMITER $$

CREATE FUNCTION gera_matricula(ano YEAR, last_id INT) RETURNS VARCHAR(10)
	BEGIN
		IF last_id < 10 THEN
			RETURN concat(ano, '000',last_id); 
        ELSEIF last_id >= 10 AND lastId <= 99 THEN
			RETURN concat(ano, '00' , last_id);
		ELSEIF last_id > 99 AND lastId <= 999 THEN
			RETURN concat(ano, '0' , last_id);
		ELSE RETURN concat(ano, last_id);
        END IF;
	END $$
  
CREATE PROCEDURE insert_endereco(param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), param_bairro VARCHAR(30), param_complemento VARCHAR(30), 
					param_cep VARCHAR(15), param_cidade VARCHAR(30))   
	BEGIN
		INSERT INTO cidade(nome) VALUE (param_cidade);
        INSERT INTO bairro(nome, id_cidade) VALUES(param_bairro, last_insert_id());
        INSERT INTO endereco(logradouro, numero, complemento, cep, id_bairro) 
        VALUES(param_logradouro, param_numero_casa, param_complemento, param_cep, last_insert_id());
    END $$
CREATE PROCEDURE insert_pessoa(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30))
	BEGIN
	
		CALL insert_endereco(param_logradouro, param_numero_casa, param_bairro, param_complemento, param_cep, param_cidade);
		INSERT INTO pessoa(nome, sexo, cpf, rg, email) 
        VALUES(param_nome, param_sexo, param_cpf, param_rg, param_email);
        INSERT INTO telefone(id_pessoa, numero) VALUE(last_insert_id(), param_numero_telefone);
	END $$
    
CREATE PROCEDURE insert_aluno(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30))
	BEGIN 
		CALL insert_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO aluno(id_aluno, matricula, data_ingresso) VALUES(last_insert_id() , gera_matricula(year(now()), last_insert_id()), utc_date());
	END $$

CREATE PROCEDURE insert_instrutor(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30), 
                    param_login VARCHAR(30), param_senha VARCHAR(30), param_permissao ENUM('1','2','3'), 
                    param_cargo ENUM('gerente', 'instrutor', 'secretaria'),param_salario DECIMAL, param_numero_cnh VARCHAR(30))
	BEGIN
		CALL insert_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO usuario(id_usuario, login, senha, permissao) VALUES(last_insert_id(), param_login, param_Senha, param_permissao);
        INSERT INTO funcionario(id_funcionario, cargo, salario, data_admissao) VALUES(last_insert_id(), param_cargo, param_salario, utc_date());
        INSERT INTO instrutor(id_instrutor, numero_cnh) VALUES (last_insert_id(), param_numero_cnh); 
    END $$

CREATE PROCEDURE insert_secretaria(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30), 
                    param_login VARCHAR(30), param_senha VARCHAR(30), param_permissao ENUM('1','2','3'), 
                    param_cargo ENUM('gerente', 'instrutor', 'secretaria'),param_salario DECIMAL)
	BEGIN
		CALL insert_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO usuario(id_usuario, login, senha, permissao) VALUES(last_insert_id(), param_login, param_Senha, param_permissao);
        INSERT INTO funcionario(id_funcionario, cargo, salario, data_admissao) VALUES(last_insert_id(), param_cargo, param_salario, utc_date());
        INSERT INTO secretaria(idSecretaria) VALUES (last_insert_id()); 
    END $$

 CREATE PROCEDURE insert_gerente(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param__numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30), 
                    param_login VARCHAR(30), param_senha VARCHAR(30), param_permissao ENUM('1','2','3'), 
                    param_cargo ENUM('gerente', 'instrutor', 'secretaria'),param_salario DECIMAL)
	BEGIN
		CALL insert_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
				param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO usuario(id_usuario, login, senha, permissao) VALUES(last_insert_id(), param_login, param_Senha, param_permissao);
        INSERT INTO funcionario(id_funcionario, cargo, salario, data_admissao) VALUES(last_insert_id(), param_cargo, param_salario, utc_date());
        INSERT INTO gerente(id_gerente) VALUES (last_insert_id()); 
    END $$
 
CREATE PROCEDURE insert_aula_teorica(param_tipo_aula VARCHAR(7), param_dia DATE, param_hora TIME, param_duracao TIME, param_quantidade INT, 
						param_id_instrutor INT, param_assunto VARCHAR(30))
	BEGIN
		INSERT INTO aula(tipo, dia, hora, duracao, quantidade, id_instrutor) 
        VALUES(param_tipo_aula, param_dia, para_hora, param_duracao, param_quantidade, param_id_instrutor);
        INSERT INTO teorica(id_teoria, assunto) VALUES(last_insert_id(), param_Assunto); 
    END $$
 
 CREATE PROCEDURE insert_aula_pratica(param_tipo_aula VARCHAR(7), param_dia DATE, param_hora TIME, param_duracao TIME, param_quantidade INT, 
						param_id_instrutor INT, param_id_veiculo INT)
	BEGIN
		INSERT INTO aula(tipo, dia, hora, duracao, quantidade, id_instrutor) 
        VALUES(param_tipo_aula, param_dia, para_hora, param_duracao, param_quantidade, param_id_instrutor);
        INSERT INTO sysaut.pratica(id_pratica, id_veiculo) VALUES(last_insert_id(), param_id_veiculo); 
    END $$

CREATE PROCEDURE insert_veiculo(param_modelo VARCHAR(30), param_marca VARCHAR(30),param_ano VARCHAR(4), param_placa VARCHAR(30), param_chassi VARCHAR(30), 
		param_tipo_veiculo Enum('carro', 'moto', 'onibus', 'caminhão'))
	BEGIN
		INSERT INTO veiculo(modelo, marca, ano, placa, chassi, tipoVeiculo) VALUES(param_modelo, param_marca, param_ano, param_placa, param_chassi, param_tipo_veiculo);
	END $$

DELIMITER ;