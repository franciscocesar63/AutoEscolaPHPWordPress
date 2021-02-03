CREATE DATABASE projetobd1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE projetobd1;

CREATE TABLE endereco (
id INT NOT NULL AUTO_INCREMENT,
logradouro VARCHAR(30) NOT NULL,
numero VARCHAR(10) DEFAULT "s/nº",
bairro VARCHAR(30) NOT NULL,
complemento VARCHAR(30) DEFAULT NULL,
cidade VARCHAR(30) NOT NULL,
cep VARCHAR(30) NOT NULL,
CONSTRAINT pk_endereco PRIMARY KEY(id)
)ENGINE=InnoDB;

CREATE TABLE pessoa (
id INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(30) NOT NULL,
sexo ENUM('masculino', 'feminino') NOT NULL,
cpf varchar(11) NOT NULL, 
rg varchar(11) DEFAULT NULL,
email varchar(30) DEFAULT NULL,
id_endereco INT DEFAULT NULL,
CONSTRAINT pk_pessoa PRIMARY KEY(id),
CONSTRAINT fk_endereco_pessoa FOREIGN KEY(id_endereco) REFERENCES endereco(id),
CONSTRAINT uk_cpf UNIQUE KEY(cpf)
)ENGINE=InnoDB;

CREATE TABLE telefone (
id INT NOT NULL AUTO_INCREMENT,
id_pessoa INT NOT NULL,
numero VARCHAR(18) NOT NULL,
CONSTRAINT pk_telefone PRIMARY KEY(id),
CONSTRAINT fk_pessoa_telefone FOREIGN KEY(id_pessoa) REFERENCES pessoa(id) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE funcionario (
id INT NOT NULL,
cargo ENUM('gerente', 'instrutor', 'secretaria') NOT NULL,
salario DECIMAL NOT NULL,
data_admissao DATE NOT NULL,
login VARCHAR(30) NOT NULL,
senha VARCHAR(30) NOT NULL,
CONSTRAINT pk_funcionario PRIMARY KEY(id),
CONSTRAINT fk_pessaoa_usuario FOREIGN KEY(id) REFERENCES pessoa(id) ON DELETE CASCADE,
CONSTRAINT uk_login UNIQUE KEY(login) 
)ENGINE=InnoDB;

CREATE TABLE veiculo (
id INT NOT NULL AUTO_INCREMENT,
modelo VARCHAR(30) NOT NULL,
marca VARCHAR(30) NOT NULL,
placa VARCHAR(30) NOT NULL,
chassi VARCHAR(50) NOT NULl,
tipo Enum('carro', 'moto', 'onibus', 'caminhão') NOT NULL,
CONSTRAINT pk_veiculo PRIMARY KEY(id),
CONSTRAINT uk_placa UNIQUE KEY(placa),
CONSTRAINT uk_chassi UNIQUE KEY(chassi)
)ENGINE=InnoDB;

CREATE TABLE aluno (
id INT NOT NULL,
matricula VARCHAR(10) NOT NULL,
data_ingresso DATE,
CONSTRAINT pk_aluno PRIMARY KEY(id),
CONSTRAINT fk_pessoa_aluno FOREIGN KEY(id) REFERENCES pessoa(id) ON DELETE CASCADE,
CONSTRAINT uk_matricula UNIQUE KEY(matricula)
)ENGINE=InnoDB;

CREATE TABLE instrutor (
id INT NOT NULL,
numero_cnh VARCHAR(30),
CONSTRAINT pk_instrutor PRIMARY KEY(id),
CONSTRAINT fk_instrutor_pessoa FOREIGN KEY(id) REFERENCES funcionario(id) ON DELETE CASCADE,
CONSTRAINT uk_numero_cnh UNIQUE KEY(numero_cnh)
)ENGINE=InnoDB;

CREATE TABLE secretaria (
id INT NOT NULL,
CONSTRAINT pk_secretaria PRIMARY KEY(id),
CONSTRAINT fk_pessoa_secretaria FOREIGN KEY(id) REFERENCES funcionario(id) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE gerente (
id INT NOT NULL,
CONSTRAINT pk_gerente PRIMARY KEY(id),
CONSTRAINT fk_gerente_pessoa FOREIGN KEY(id) REFERENCES funcionario(id) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE aula (
id INT NOT NULL,
tipo VARCHAR(7) NOT NULL,
dia DATE NOT NULL,
hora TIME NOT NULL,
duracao TIME NOT NULL,
quantidade INT NOT NULL,
id_instrutor INT DEFAULT NULL,
CONSTRAINT pk_aula PRIMARY KEY(id), 
CONSTRAINT fk_instrutor_aula FOREIGN KEY(id_instrutor) REFERENCES instrutor(id)
)ENGINE=InnoDB;

CREATE TABLE teorica (
id INT NOT NULL,
assunto VARCHAR(30) NOT NULL,
CONSTRAINT pk_teorica PRIMARY KEY(id),
CONSTRAINT fk_aula_teorica FOREIGN KEY(id) REFERENCES aula(id) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE pratica (
id_pratica INT NOT NULL,
id_veiculo INT DEFAULT NULL,
CONSTRAINT pk_pratica PRIMARY KEY(id_pratica),
CONSTRAINT fk_aula_pratica FOREIGN KEY(id_pratica) REFERENCES aula(id),
CONSTRAINT fk_veiculo_pratica FOREIGN KEY(id_veiculo) REFERENCES veiculo(id)
)ENGINE=InnoDB;

CREATE TABLE aluno_aula (
id_aluno INT NOT NULL,
id_aula INT NOT NULL,
assistidas INT DEFAULT 0,
CONSTRAINT pk_aluno_aula PRIMARY KEY(id_aluno, id_aula),
CONSTRAINT fk_aluno FOREIGN KEY(id_aluno) REFERENCES aluno(id) ON DELETE CASCADE,
CONSTRAINT fk_aula FOREIGN KEY(id_aula) REFERENCES aula(id) ON DELETE CASCADE
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

CREATE PROCEDURE stp_inserir_pessoa(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cidade VARCHAR(30), param_cep VARCHAR(30))
	BEGIN
	
		INSERT INTO endereco(logradouro, numero, bairro, complemento, cidade, cep) 
        VALUES(param_logradouro, param_numero_casa, param_bairro, param_complemento, param_cidade, param_cep);
		INSERT INTO pessoa(nome, sexo, cpf, rg, email, id_endereco) 
        VALUES(param_nome, param_sexo, param_cpf, param_rg, param_email, last_insert_id());
        INSERT INTO telefone(id_pessoa, numero) VALUE(last_insert_id(), param_numero_telefone);
         
	END $$

CREATE PROCEDURE stp_atualiza_pessoa_endereco(param_id INT, param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cidade VARCHAR(30), param_cep VARCHAR(30))
	BEGIN
		
		UPDATE endereco SET logradouro = param_logradouro, numero = param_numero_casa, bairro = param_bairro, complemento = param_complemento, 
        cidade = param_cidade, cep = param_cep WHERE endereco.id = param_id;
		UPDATE pessoa SET nome = param_nome, sexo = param_sexo, cpf = param_cpf, rg = param_rg, email = param_email WHERE pessoa.id = param_id;
		UPDATE telefone SET numero = param_numero_telefone WHERE telefone.id = param_id AND telefone.id_pessoa = param_id;
         
	END $$

CREATE PROCEDURE stp_deleta_pessoa_endereco(param_cpf VARCHAR(11))
	BEGIN
		DELETE FROM pessoa, endereco USING pessoa, endereco 
        WHERE pessoa.id = endereco.id AND pessoa.cpf = param_cpf; 
    END $$	
 
CREATE PROCEDURE stp_inserir_aluno(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30))
	BEGIN 
		CALL stp_inserir_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO aluno(id, matricula, data_ingresso) VALUES(last_insert_id(), gera_matricula(year(now()), last_insert_id()), utc_date());
	END $$

CREATE PROCEDURE stp_deleta_aluno(param_matricula VARCHAR(10))
	BEGIN
		CALL stp_deleta_pessoa_endereco((SELECT pessoa.cpf FROM pessoa WHERE pessoa.id 
        IN(SELECT aluno.id FROM aluno WHERE aluno.matricula = param_matricula)));
    END$$

CREATE PROCEDURE stp_inserir_instrutor(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30), 
                    param_salario DECIMAL, param_numero_cnh VARCHAR(30), param_login VARCHAR(30), param_senha VARCHAR(30))
	BEGIN
		CALL stp_inserir_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO funcionario(id, cargo, salario, data_admissao, login, senha) 
        VALUES(last_insert_id(), 'instrutor', param_salario, utc_date(), param_login, param_senha);
        INSERT INTO instrutor(id, numero_cnh) VALUES (last_insert_id(), param_numero_cnh); 
    END $$

CREATE PROCEDURE stp_inserir_secretaria(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30), 
					param_salario DECIMAL, param_login VARCHAR(30), param_senha VARCHAR(30))
	BEGIN 
		CALL stp_inserir_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO funcionario(id, cargo, salario, data_admissao, login, senha) 
        VALUES(last_insert_id() ,'secretaria', param_salario, utc_date(), param_login, param_senha);
        INSERT INTO secretaria(id) VALUES (last_insert_id()); 
    END $$

 CREATE PROCEDURE stp_inserir_gerente(param_nome VARCHAR(30), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(30), param__numero_telefone VARCHAR(18), param_logradouro VARCHAR(30), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(30), param_complemento VARCHAR(30), param_cep VARCHAR(15), param_cidade VARCHAR(30), 
					param_salario DECIMAL, param_login VARCHAR(30), param_senha VARCHAR(30))
	BEGIN
		CALL stp_inserir_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
				param_bairro, param_complemento, param_cep, param_cidade);
        INSERT INTO funcionario(id, cargo, salario, data_admissao, login, senha) 
        VALUES(last_insert_id(), 'gerente', param_salario, utc_date(), param_login, param_senha);
        INSERT INTO gerente(id) VALUES (last_insert_id()); 
    END $$

CREATE PROCEDURE stp_atualiza_cargo(param_login VARCHAR(30), param_cargo ENUM('gerente', 'instrutor', 'secretaria'))
	BEGIN
		UPDATE funcionario SET cargo = param_cargo WHERE funcionario.login = param_login; 
    END $$

CREATE PROCEDURE stp_atualiza_salario(param_login VARCHAR(30), param_salario DECIMAL)
	BEGIN
		UPDATE funcionario SET salario = param_salario WHERE funcionario.login = param_login; 
	END $$

CREATE PROCEDURE stp_atualiza_senha(param_login VARCHAR(30), param_senha VARCHAR(30))
	BEGIN
		UPDATE funcionario SET senha = param_senha WHERE funcionario.login = param_login;
	END $$

CREATE PROCEDURE stp_inserir_aula_teorica(param_tipo_aula VARCHAR(7), param_dia DATE, param_hora TIME, param_duracao TIME, param_quantidade INT, 
						param_id_instrutor INT, param_assunto VARCHAR(30))
	BEGIN
		INSERT INTO aula(tipo, dia, hora, duracao, quantidade, id_instrutor) 
        VALUES(param_tipo_aula, param_dia, para_hora, param_duracao, param_quantidade, param_id_instrutor);
        INSERT INTO teorica(id ,assunto) VALUES(last_insert_id(), param_Assunto); 
    END $$

CREATE PROCEDURE stp_atualiza_aula_teorica(param_id INT, param_tipo_aula VARCHAR(7), param_dia DATE, param_hora TIME, param_duracao TIME, param_quantidade INT, 
						param_id_instrutor INT, param_assunto VARCHAR(30)) 
	BEGIN
		UPDATE aula SET tipo = param_tipo_aula, dia = param_dia, hora = param_hora, duracao = param_duracao, 
						quantidade = param_quantidade, id_instrutor = param_id_instrutor WHERE aula.id = param_id;
		UPDATE teoria SET assunto = param_assunto WHERE teorica.id = param_id; 
    END $$

CREATE PROCEDURE stp_inserir_aula_pratica(param_tipo_aula VARCHAR(7), param_dia DATE, param_hora TIME, param_duracao TIME, param_quantidade INT, 
						param_id_instrutor INT, param_id_veiculo INT)
	BEGIN
		INSERT INTO aula(tipo, dia, hora, duracao, quantidade, id_instrutor) 
        VALUES(param_tipo_aula, param_dia, para_hora, param_duracao, param_quantidade, param_id_instrutor);
        INSERT INTO pratica(id ,id_veiculo) VALUES(last_insert_id(), param_id_veiculo); 
    END $$

CREATE PROCEDURE stp_atualiza_aula_pratica(param_id INT, param_tipo_aula VARCHAR(7), param_dia DATE, param_hora TIME, param_duracao TIME, param_quantidade INT, 
						param_id_instrutor INT, param_id_veiculo INT) 
	BEGIN
		UPDATE aula SET tipo = param_tipo_aula, dia = param_dia, hora = param_hora, duracao = param_duracao, 
						quantidade = param_quantidade, id_instrutor = param_id_instrutor WHERE aula.id = param_id;
		UPDATE pratica SET id_veiculo = param_id_veiculo WHERE partica.id = param_id; 
    END $$
    
CREATE PROCEDURE stp_deleta_aula(param_id INT) 
	BEGIN
		DELETE FROM aula WHERE aula.id = param_id;
	END $$    
    
CREATE PROCEDURE stp_cadastra_aluno_aula(param_id_aluno INT, param_id_aula INT)
		BEGIN
			INSERT INTO aluno_aula(id_aluno, id_aula) VALUES(param_id_aluno, param_id_aula); 
		END $$
        
CREATE PROCEDURE stp_inserir_veiculo(param_modelo VARCHAR(30), param_marca VARCHAR(30), param_placa VARCHAR(30), param_chassi VARCHAR(30), 
		param_tipo_veiculo Enum('carro', 'moto', 'onibus', 'caminhão'))
	BEGIN
		INSERT INTO veiculo(modelo, marca, ano, placa, chassi, tipoVeiculo) VALUES(param_modelo, param_marca, param_ano, param_placa, param_chassi, param_tipo_veiculo);
	END $$

CREATE PROCEDURE stp_autaliza_veiculo(param_id INT, param_modelo VARCHAR(30), param_marca VARCHAR(30), param_placa VARCHAR(30), param_chassi VARCHAR(30), 
		param_tipo_veiculo Enum('carro', 'moto', 'onibus', 'caminhão'))
	BEGIN 
		UPDATE veiculo SET modelo = param_modelo, marca = param_marca, placa = param_placa, 
        chassi = param_chassi, tipo = param_tipo WHERE veiculo.id = param_id;
	END $$
CREATE PROCEDURE stp_deleta_veiculo(param_placa VARCHAR(30))
	BEGIN
		DELETE FROM veiculo WHERE veiculo.chassi 
        IN(SELECT veiculo.chassi FROM veiculo WHERE veiculo.placa = param_placa); 
    END $$
    
DELIMITER ;