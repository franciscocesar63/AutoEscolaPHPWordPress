CREATE DATABASE projetobd1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE projetobd1;

CREATE TABLE endereco (
id INT NOT NULL AUTO_INCREMENT,
logradouro VARCHAR(100) NOT NULL,
numero_casa VARCHAR(10) DEFAULT "S/Nº",
bairro VARCHAR(100) NOT NULL,
complemento VARCHAR(100) DEFAULT NULL,
cidade VARCHAR(100) NOT NULL,
cep VARCHAR(9) NOT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0, 
CONSTRAINT pk_endereco PRIMARY KEY(id)
)ENGINE=InnoDB;

CREATE TABLE pessoa (
id INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(80) NOT NULL,
sexo ENUM('masculino', 'feminino') NOT NULL,
cpf varchar(11) NOT NULL, 
rg varchar(11) DEFAULT NULL,
email varchar(80) DEFAULT NULL,
id_endereco INT DEFAULT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0, 
CONSTRAINT pk_pessoa PRIMARY KEY(id),
CONSTRAINT fk_endereco_pessoa FOREIGN KEY(id_endereco) REFERENCES endereco(id),
CONSTRAINT uk_pessoa UNIQUE KEY(cpf)
)ENGINE=InnoDB;

CREATE TABLE telefone (
id INT NOT NULL AUTO_INCREMENT,
id_pessoa INT NOT NULL,
numero_telefone VARCHAR(18) NOT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0, 
CONSTRAINT pk_telefone PRIMARY KEY(id),
CONSTRAINT fk_pessoa_telefone_id_pessoa FOREIGN KEY(id_pessoa) REFERENCES pessoa(id)
)ENGINE=InnoDB;

CREATE TABLE funcionario (
id INT NOT NULL,
cargo ENUM('gerente', 'instrutor', 'secretaria') NOT NULL,
salario DECIMAL NOT NULL,
data_admissao DATE NOT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0,
CONSTRAINT pk_funcionario PRIMARY KEY(id),
CONSTRAINT fk_pessoa_funcionario_id FOREIGN KEY(id) REFERENCES pessoa(id)
)ENGINE=InnoDB;

CREATE TABLE usuario (
id INT NOT NULL,
login VARCHAR(30), 
senha VARCHAR(255),
excluido BOOLEAN NOT NULL DEFAULT 0,
CONSTRAINT pk_usuario PRIMARY KEY(id),
CONSTRAINT fk_funcionario_usuario_id FOREIGN KEY(id) REFERENCES funcionario(id),
CONSTRAINT uk_usuario UNIQUE(login)   
)ENGINE=InnoDB;  

CREATE TABLE veiculo (
id INT NOT NULL AUTO_INCREMENT,
modelo VARCHAR(30) NOT NULL,
marca VARCHAR(30) NOT NULL,
placa VARCHAR(30) NOT NULL,
chassi VARCHAR(50) NOT NULl,
tipo Enum('carro', 'moto', 'onibus', 'caminhão') NOT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0, 
CONSTRAINT pk_veiculo_id PRIMARY KEY(id),
CONSTRAINT uk_veiculo_placa UNIQUE KEY(placa),
CONSTRAINT uk_veiculo_chassi UNIQUE KEY(chassi)
)ENGINE=InnoDB;

CREATE TABLE aluno (
id INT NOT NULL,
matricula VARCHAR(10) NOT NULL,
data_ingresso DATE, 
excluido BOOLEAN NOT NULL DEFAULT 0,
CONSTRAINT pk_aluno PRIMARY KEY(id),
CONSTRAINT fk_pessoa_aluno_id FOREIGN KEY(id) REFERENCES pessoa(id),
CONSTRAINT uk_aluno UNIQUE KEY(matricula)
)ENGINE=InnoDB;

CREATE TABLE instrutor (
id INT NOT NULL,
numero_cnh VARCHAR(30),
excluido BOOLEAN NOT NULL DEFAULT 0,
CONSTRAINT pk_instrutor_id PRIMARY KEY(id),
CONSTRAINT fk_funcionario_instrutor_id FOREIGN KEY(id) REFERENCES funcionario(id),
CONSTRAINT uk_instrutor UNIQUE KEY(numero_cnh)
)ENGINE=InnoDB;

CREATE TABLE aula (
id INT NOT NULL AUTO_INCREMENT,
tipo ENUM('pratica', 'teorica') NOT NULL,
quantidade ENUM('1', '2', '3') NOT NULL,
id_instrutor INT DEFAULT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0, 
CONSTRAINT pk_aula PRIMARY KEY(id), 
CONSTRAINT fk_instrutor_aula FOREIGN KEY(id_instrutor) REFERENCES instrutor(id)
)ENGINE=InnoDB;

CREATE TABLE teorica (
id INT NOT NULL,
assunto VARCHAR(40) NOT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0,
CONSTRAINT pk_teorica PRIMARY KEY(id),
CONSTRAINT fk_aula_teorica FOREIGN KEY(id) REFERENCES aula(id)
)ENGINE=InnoDB;

CREATE TABLE pratica (
id INT NOT NULL,
id_veiculo INT DEFAULT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0,
CONSTRAINT pk_pratica PRIMARY KEY(id),
CONSTRAINT fk_aula_pratica FOREIGN KEY(id) REFERENCES aula(id)
)ENGINE=InnoDB;

CREATE TABLE aluno_aula (
id INT NOT NULL AUTO_INCREMENT,
id_aluno INT NOT NULL,
id_aula INT NOT NULL,
`data` DATE NOT NULL,
inicio TIME NOT NULL,
fim TIME NOT NULL,
excluido BOOLEAN NOT NULL DEFAULT 0,
CONSTRAINT pk_aluno_aula PRIMARY KEY(id),
CONSTRAINT fk_aluno FOREIGN KEY(id_aluno) REFERENCES aluno(id),
CONSTRAINT fk_aula FOREIGN KEY(id_aula) REFERENCES aula(id)
)ENGINE=InnoDB;

DELIMITER $$ 
 
CREATE TRIGGER trg_pessoa_verifica_excluido BEFORE UPDATE ON pessoa FOR EACH ROW
	BEGIN
		SET SQL_SAFE_UPDATES = 0;
		UPDATE aluno INNER JOIN pessoa SET aluno.excluido = pessoa.excluido WHERE aluno.id = pessoa.id AND aluno.excluido != pessoa.excluido;
		UPDATE endereco INNER JOIN pessoa SET endereco.excluido = pessoa.excluido WHERE endereco.id = pessoa.id_endereco AND endereco.excluido != pessoa.excluido;
		UPDATE funcionario INNER JOIN pessoa SET funcionario.excluido = pessoa.excluido WHERE funcionario.id = pessoa.id AND funcionario.excluido != pessoa.excluido; 
		UPDATE instrutor INNER JOIN pessoa SET  instrutor.excluido = pessoa.excluido WHERE instrutor.id = pessoa.id AND instrutor.excluido != pessoa.excluido;
		UPDATE telefone INNER JOIN pessoa SET telefone.excluido = pessoa.excluido WHERE telefone.id_pessoa = pessoa.id AND telefone.excluido != pessoa.excluido;
		UPDATE usuario INNER JOIN pessoa SET usuario.excluido = pessoa.excluido WHERE usuario.id = pessoa.id AND usuario.excluido != pessoa.excluido;
        SET SQL_SAFE_UPDATES = 1;
    END $$
 
CREATE TRIGGER trg_aula_verifica_excluido BEFORE UPDATE ON aula FOR EACH ROW
	BEGIN
		SET SQL_SAFE_UPDATES = 0;
		UPDATE pratica INNER JOIN aula SET pratica.excluido = aula.excluido WHERE aula.id = pratica.id;
		UPDATE teoria INNER JOIN aula SET teoria.excluido = aula.excluido WHERE teorica.id = aula.id;
        SET SQL_SAFE_UPDATES = 1;
    END $$
    
CREATE TRIGGER trg_instrutor_aula_verifica_excluido BEFORE UPDATE ON instrutor FOR EACH ROW    
    BEGIN
		SET SQL_SAFE_UPDATES = 0;
		UPDATE aula INNER JOIN instrutor SET aula.id_instrutor = NULL  WHERE aula.id_instrutor = instrutor.id AND instrutor.excluido = 1;
        SET SQL_SAFE_UPDATES = 1;
    END $$

CREATE TRIGGER trg_veiculo_verfica_excluido BEFORE UPDATE ON veiculo FOR EACH ROW
    BEGIN
		SET SQL_SAFE_UPDATES = 0;
		UPDATE pratica INNER JOIN veiculo SET pratica.id_veiculo = NULL WHERE pratica.id_veiculo = veiculo.id AND veiculo.excluido = 1;
        SET SQL_SAFE_UPDATES = 1;
    END $$
    
-- CREATE TRIGGER trg_funcionario_vefirica_salario AFTER UPDATE ON funcionario FOR EACH ROW
-- BEGIN
		 
-- END $$
    
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

CREATE FUNCTION retorna_id_cpf(param_cpf VARCHAR(11)) RETURNS INT  
	BEGIN
		RETURN (SELECT pessoa.id FROM pessoa WHERE pessoa.cpf = param_cpf);
    END $$

CREATE FUNCTION retorna_id_cep(param_cep VARCHAR(9)) RETURNS INT  
	BEGIN
		RETURN (SELECT endereco.id FROM endereco WHERE endereco.cep = param_cep);
    END $$

CREATE FUNCTION retorna_id_matricula(param_matricula VARCHAR(10)) RETURNS INT  
	BEGIN
		RETURN (SELECT aluno.id FROM aluno WHERE aluno.matricula = param_matricula);
    END $$
    
CREATE PROCEDURE stp_inserir_pessoa(param_nome VARCHAR(80), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(80), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(100), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(100), param_complemento VARCHAR(100), param_cidade VARCHAR(10), param_cep VARCHAR(9))
	BEGIN
		
		INSERT INTO pessoa(nome, sexo, cpf, rg, email) 
        VALUES(param_nome, param_sexo, param_cpf, param_rg, param_email);
        INSERT INTO telefone(id_pessoa, numero_telefone) VALUE(retorna_id_cpf(param_cpf), param_numero_telefone);
        INSERT INTO endereco(logradouro, numero_casa, bairro, complemento, cidade, cep) 
        VALUES(param_logradouro, param_numero_casa, param_bairro, param_complemento, param_cidade, param_cep);
        SET SQL_SAFE_UPDATES = 0;
        UPDATE pessoa SET pessoa.id_endereco = retorna_id_cep(param_cep) WHERE pessoa.id = retorna_id_cep(param_cep);
        SET SQL_SAFE_UPDATES = 1;
	END $$

CREATE PROCEDURE stp_atualiza_pessoa_endereco(param_id INT, param_nome VARCHAR(80), param_sexo ENUM('masculino', 'feminino'), param_email VARCHAR(80), 
					param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(100), param_numero_casa VARCHAR(10), param_bairro VARCHAR(30), 
                    param_complemento VARCHAR(100), param_cidade VARCHAR(100), param_cep VARCHAR(9))
	BEGIN
		UPDATE endereco SET logradouro = param_logradouro, numero_casa = param_numero_casa, bairro = param_bairro, complemento = param_complemento, 
        cidade = param_cidade, cep = param_cep WHERE endereco.id = param_id;
		UPDATE pessoa SET nome = param_nome, sexo = param_sexo, email = param_email WHERE pessoa.id = param_id;
		UPDATE telefone SET numero_telefone = param_numero_telefone WHERE telefone.id = param_id AND telefone.id_pessoa = param_id;
	END $$

CREATE PROCEDURE stp_deleta_pessoa(param_cpf VARCHAR(11))
	BEGIN
        UPDATE pessoa SET pessoa.excluido = 1 WHERE pessoa.cpf = param_cpf;
	END $$
    
CREATE PROCEDURE stp_inserir_aluno(param_nome VARCHAR(80), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(80), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(100), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(100), param_complemento VARCHAR(100), param_cidade VARCHAR(100), param_cep VARCHAR(9))
	BEGIN 
		CALL stp_inserir_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cidade, param_cep);
        INSERT INTO aluno(id, matricula, data_ingresso) VALUES(retorna_id_cpf(param_cpf), gera_matricula(year(now()), retorna_id_cpf(param_cpf)), utc_date());
	END $$

CREATE PROCEDURE stp_inserir_funcionario(param_nome VARCHAR(80), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(80), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(100), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(100), param_complemento VARCHAR(100), param_cidade VARCHAR(100), param_cep VARCHAR(15), 
                    param_cargo ENUM('gerente', 'instrutor', 'secretaria'), param_salario DECIMAL, param_login VARCHAR(30), param_senha VARCHAR(255))
		BEGIN
			CALL stp_inserir_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
				param_bairro, param_complemento, param_cidade, param_cep);
			INSERT INTO funcionario(id, cargo, salario, data_admissao) VALUES(retorna_id_cpf(param_cpf), param_cargo, param_salario, utc_date());
            INSERT INTO usuario(id, login, senha) VALUES(retorna_id_cpf(param_cpf), param_login, param_senha);
        END $$

CREATE PROCEDURE stp_inserir_instrutor(param_nome VARCHAR(80), param_sexo ENUM('masculino', 'feminino'), param_cpf VARCHAR(11), param_rg VARCHAR(11), 
					param_email VARCHAR(80), param_numero_telefone VARCHAR(18), param_logradouro VARCHAR(100), param_numero_casa VARCHAR(10), 
                    param_bairro VARCHAR(100), param_complemento VARCHAR(100), param_cidade VARCHAR(100), param_cep VARCHAR(9),
                    cargo ENUM('gerente', 'instrutor', 'secretaria'), param_salario DECIMAL, param_numero_cnh VARCHAR(30))
	BEGIN
		CALL stp_inserir_pessoa(param_nome, param_sexo, param_cpf, param_rg, param_email, param_numero_telefone, param_logradouro, param_numero_casa, 
							param_bairro, param_complemento, param_cidade, param_cep);
        INSERT INTO funcionario(id, cargo, salario, data_admissao) VALUES(retorna_id_cpf(param_cpf), 'instrutor', param_salario, utc_date());
        INSERT INTO instrutor(id, numero_cnh) VALUES (retorna_id_cpf(param_cpf), param_numero_cnh); 
    END $$
    
CREATE PROCEDURE stp_atualiza_salario(param_id INT, param_salario DECIMAL)
	BEGIN
		UPDATE funcionario SET funcionario.salario = param_salario WHERE funcionario.id = param_id;
	END $$

CREATE PROCEDURE stp_atualiza_senha(param_login VARCHAR(30), param_senha VARCHAR(255))
	BEGIN
		UPDATE usuario SET senha = param_senha WHERE usuario.login = param_login;
	END $$

CREATE PROCEDURE stp_inserir_aula_teorica(param_quantidade ENUM('1', '2', '3'), param_id_instrutor INT, param_assunto VARCHAR(30))
	BEGIN
		INSERT INTO aula(tipo, quantidade, id_instrutor) VALUES('teorica', param_quantidade, param_id_instrutor);
        INSERT INTO teorica(id ,assunto) VALUES(last_insert_id(), param_Assunto); 
    END $$

CREATE PROCEDURE stp_atualiza_aula_teorica(param_id INT, param_quantidade ENUM('1', '2', '3'), param_id_instrutor INT, param_assunto VARCHAR(30)) 
	BEGIN
		UPDATE aula SET quantidade = param_quantidade, id_instrutor = param_id_instrutor WHERE aula.id = param_id;
		UPDATE teoria SET assunto = param_assunto WHERE teorica.id = param_id; 
    END $$

CREATE PROCEDURE stp_inserir_aula_pratica(param_quantidade ENUM('1', '2', '3'), param_id_instrutor INT, param_id_veiculo INT)
	BEGIN
		INSERT INTO aula(tipo, quantidade, id_instrutor) VALUES('pratica', param_quantidade, param_id_instrutor);
        INSERT INTO pratica(id ,id_veiculo) VALUES(last_insert_id(), param_id_veiculo); 
    END $$

CREATE PROCEDURE stp_atualiza_aula_pratica(param_id INT, param_quantidade ENUM('1', '2', '3'), param_id_instrutor INT, param_id_veiculo INT) 
	BEGIN
		UPDATE aula SET quantidade = param_quantidade, id_instrutor = param_id_instrutor WHERE aula.id = param_id;
		UPDATE pratica SET id_veiculo = param_id_veiculo WHERE partica.id = param_id; 
    END $$
    
CREATE PROCEDURE stp_deleta_aula(param_id_aula INT) 
	BEGIN
		 UPDATE aula SET aula.exluido = 1 WHERE aula.id = param_id;
	END $$    
    
CREATE PROCEDURE stp_inserir_aluno_aula(param_id_aluno INT, param_id_aula INT, param_data DATE, param_inicio TIME, param_fim TIME)
	BEGIN
        INSERT INTO aluno_aula(id_aluno, id_aula, `data`, inicio, fim) VALUES(param_id_aluno, param_id_aula, param_data, param_inicio, param_fim);
	END $$
    
CREATE PROCEDURE stp_atualiza_aluno_aula(param_id_aluno INT, param_id_aula INT, `data` DATE, param_inicio TIME, param_fim TIME)
	BEGIN
		UPDATE aluno_aula SET `data` = param_data, inicio = param_inicio, fim = param_fim;    
	END $$
    
CREATE PROCEDURE stp_inserir_veiculo(param_modelo VARCHAR(30), param_marca VARCHAR(30), param_placa VARCHAR(30), param_chassi VARCHAR(50), 
		param_tipo_veiculo Enum('carro', 'moto', 'onibus', 'caminhão'))
	BEGIN
		INSERT INTO veiculo(modelo, marca, placa, chassi, tipo) VALUES(param_modelo, param_marca, param_placa, param_chassi, param_tipo_veiculo);
	END $$

CREATE PROCEDURE stp_autaliza_veiculo(param_id INT, param_modelo VARCHAR(30), param_marca VARCHAR(30), param_placa VARCHAR(30), param_chassi VARCHAR(30), 
		param_tipo_veiculo Enum('carro', 'moto', 'onibus', 'caminhão'))
	BEGIN 
		UPDATE veiculo SET modelo = param_modelo, marca = param_marca, placa = param_placa, 
        chassi = param_chassi, tipo = param_tipo WHERE veiculo.id = param_id;
	END $$
    
CREATE PROCEDURE stp_deleta_veiculo(param_placa VARCHAR(30))
	BEGIN
		UPDATE veiculo SET veiculo.excluido = 1 WHERE veiculo.placa = param_placa;
    END $$
    
DELIMITER ;