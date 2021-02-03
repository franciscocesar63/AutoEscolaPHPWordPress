-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 08-Jun-2018 às 22:56
-- Versão do servidor: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetobd1`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `id` int(11) NOT NULL,
  `matricula` varchar(10) NOT NULL,
  `data_ingresso` date DEFAULT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_aluno` (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id`, `matricula`, `data_ingresso`, `excluido`) VALUES
(4, '20180004', '2018-06-08', 0),
(5, '20180005', '2018-06-08', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_aula`
--

DROP TABLE IF EXISTS `aluno_aula`;
CREATE TABLE IF NOT EXISTS `aluno_aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `data` date NOT NULL,
  `inicio` time NOT NULL,
  `fim` time NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_aluno` (`id_aluno`),
  KEY `fk_aula` (`id_aula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aula`
--

DROP TABLE IF EXISTS `aula`;
CREATE TABLE IF NOT EXISTS `aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('pratica','teorica') NOT NULL,
  `duracao` time NOT NULL,
  `id_instrutor` int(11) DEFAULT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_instrutor_aula` (`id_instrutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

DROP TABLE IF EXISTS `endereco`;
CREATE TABLE IF NOT EXISTS `endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(100) NOT NULL,
  `numero_casa` varchar(10) DEFAULT 'S/Nº',
  `bairro` varchar(100) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id`, `logradouro`, `numero_casa`, `bairro`, `complemento`, `cidade`, `cep`, `excluido`) VALUES
(1, 'Deocleciano', '37', 'Dr Zezé', '123', 'Sousa', '', 0),
(2, 'Rua Nestor Jose Sarmento', '37', 'Doutor ZezÃ©', '1', 'Sousa', '58804695', 0),
(3, 'Rua Nestor Jose Sarmento', '37', 'Doutor ZezÃ©', '1', 'Sousa', '58804-260', 0),
(4, 'asd', '37', 'Doutor ZezÃ©', '1', '58804695', 'Sousa', 0),
(5, '9595', '9595', '95959', '5959', '595', '5959', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` int(11) NOT NULL,
  `cargo` enum('gerente','instrutor','secretaria') NOT NULL,
  `salario` decimal(10,0) NOT NULL,
  `data_admissao` date NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `cargo`, `salario`, `data_admissao`, `excluido`) VALUES
(1, 'gerente', '454', '2018-06-08', 0),
(2, 'secretaria', '565', '2018-06-08', 0),
(3, 'instrutor', '8000', '2018-06-08', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `instrutor`
--

DROP TABLE IF EXISTS `instrutor`;
CREATE TABLE IF NOT EXISTS `instrutor` (
  `id` int(11) NOT NULL,
  `numero_cnh` varchar(30) DEFAULT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_instrutor` (`numero_cnh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `instrutor`
--

INSERT INTO `instrutor` (`id`, `numero_cnh`, `excluido`) VALUES
(3, '156465', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `sexo` enum('masculino','feminino') NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `rg` varchar(11) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pessoa` (`cpf`),
  KEY `fk_endereco_pessoa` (`id_endereco`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `nome`, `sexo`, `cpf`, `rg`, `email`, `id_endereco`, `excluido`) VALUES
(1, 'Francisco', 'masculino', '08504140911', '123', 'franciscocesar888@gmail.com', 1, 0),
(2, 'Ana Karoline Abrantes da Silva', 'masculino', '0850414', '66565', 'franciscocesar888@gmail.com', 2, 0),
(3, 'Chico', 'masculino', '8320', '1397557045', 'franciscocesar888@gmail.com', 3, 0),
(4, 'Aluno', 'masculino', '0850414066', '66565', 'franciscocesar888@gmail.com', 4, 0),
(5, 'Feminino', 'feminino', '595886', '6481', '5484@gmail.com', 5, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pratica`
--

DROP TABLE IF EXISTS `pratica`;
CREATE TABLE IF NOT EXISTS `pratica` (
  `id` int(11) NOT NULL,
  `id_veiculo` int(11) DEFAULT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

DROP TABLE IF EXISTS `telefone`;
CREATE TABLE IF NOT EXISTS `telefone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) NOT NULL,
  `numero_telefone` varchar(18) NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_telefone_id_pessoa` (`id_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `telefone`
--

INSERT INTO `telefone` (`id`, `id_pessoa`, `numero_telefone`, `excluido`) VALUES
(1, 1, '+5583994062713', 0),
(2, 2, '+5583994062713', 0),
(3, 3, '+5583994062713', 0),
(4, 4, '+5583994062713', 0),
(5, 5, '9595', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `teorica`
--

DROP TABLE IF EXISTS `teorica`;
CREATE TABLE IF NOT EXISTS `teorica` (
  `id` int(11) NOT NULL,
  `assunto` varchar(40) NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `login` varchar(30) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuario` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `excluido`) VALUES
(1, 'cesar', 'd9b1d7db4cd6e70935368a1efb10e377', 0),
(2, 'cesinha', 'd9b1d7db4cd6e70935368a1efb10e377', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculo`
--

DROP TABLE IF EXISTS `veiculo`;
CREATE TABLE IF NOT EXISTS `veiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `placa` varchar(30) NOT NULL,
  `chassi` varchar(50) NOT NULL,
  `tipo` enum('carro','moto','onibus','caminhão') NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_veiculo_placa` (`placa`),
  UNIQUE KEY `uk_veiculo_chassi` (`chassi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_pessoa_aluno_id` FOREIGN KEY (`id`) REFERENCES `pessoa` (`id`);

--
-- Limitadores para a tabela `aluno_aula`
--
ALTER TABLE `aluno_aula`
  ADD CONSTRAINT `fk_aluno` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `fk_aula` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`);

--
-- Limitadores para a tabela `aula`
--
ALTER TABLE `aula`
  ADD CONSTRAINT `fk_instrutor_aula` FOREIGN KEY (`id_instrutor`) REFERENCES `instrutor` (`id`);

--
-- Limitadores para a tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_pessoa_funcionario_id` FOREIGN KEY (`id`) REFERENCES `pessoa` (`id`);

--
-- Limitadores para a tabela `instrutor`
--
ALTER TABLE `instrutor`
  ADD CONSTRAINT `fk_funcionario_instrutor_id` FOREIGN KEY (`id`) REFERENCES `funcionario` (`id`);

--
-- Limitadores para a tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `fk_endereco_pessoa` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id`);

--
-- Limitadores para a tabela `pratica`
--
ALTER TABLE `pratica`
  ADD CONSTRAINT `fk_aula_pratica` FOREIGN KEY (`id`) REFERENCES `aula` (`id`);

--
-- Limitadores para a tabela `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `fk_pessoa_telefone_id_pessoa` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`);

--
-- Limitadores para a tabela `teorica`
--
ALTER TABLE `teorica`
  ADD CONSTRAINT `fk_aula_teorica` FOREIGN KEY (`id`) REFERENCES `aula` (`id`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_funcionario_usuario_id` FOREIGN KEY (`id`) REFERENCES `funcionario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
