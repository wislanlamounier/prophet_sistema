-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Jul-2016 às 07:47
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `prophet_testes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda_evento`
--

CREATE TABLE `agenda_evento` (
  `cdnEvento` int(10) UNSIGNED NOT NULL,
  `cdnTipoEvento` int(11) NOT NULL,
  `cdnUsuario` int(10) UNSIGNED DEFAULT NULL,
  `desEvento` text,
  `datInicio` datetime NOT NULL,
  `datFim` datetime NOT NULL,
  `indAllDay` tinyint(1) DEFAULT NULL,
  `indAviso` tinyint(1) DEFAULT '0',
  `numDiasAviso` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda_tipoevento`
--

CREATE TABLE `agenda_tipoevento` (
  `cdnTipoEvento` int(10) UNSIGNED NOT NULL,
  `cdnUsuario` int(10) UNSIGNED NOT NULL,
  `codCor` varchar(6) NOT NULL,
  `nomTipoEvento` text NOT NULL,
  `indDesvinculado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `anamnese_campo`
--

CREATE TABLE `anamnese_campo` (
  `cdnCampo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `anamnese_campo`
--

INSERT INTO `anamnese_campo` (`cdnCampo`) VALUES
(5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `areaatuacao`
--

CREATE TABLE `areaatuacao` (
  `cdnAreaAtuacao` int(10) UNSIGNED NOT NULL,
  `nomAreaAtuacao` text NOT NULL,
  `desAreaAtuacao` text,
  `indDesvinculada` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `areaatuacao`
--

INSERT INTO `areaatuacao` (`cdnAreaAtuacao`, `nomAreaAtuacao`, `desAreaAtuacao`, `indDesvinculada`) VALUES
(1, 'Endodontia', NULL, 0),
(2, 'Endodontia', NULL, 1),
(3, 'Endodontiofhghgf', NULL, 1),
(4, 'Outra área', NULL, 0),
(5, 'Mais uma área de atuação', NULL, 0),
(6, 'Periodontia', NULL, 0),
(7, 'Prótese', 'atualizar\r\n\r\n\r\n\r\nasdfasfsafd', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clinicaradiologica`
--

CREATE TABLE `clinicaradiologica` (
  `cdnClinicaRadiologica` int(10) UNSIGNED NOT NULL,
  `nomClinicaRadiologica` varchar(300) NOT NULL,
  `numWhatsapp` varchar(20) DEFAULT NULL,
  `numTelefone1` varchar(20) DEFAULT NULL,
  `numTelefone2` varchar(20) DEFAULT NULL,
  `strEndereco` varchar(300) DEFAULT NULL,
  `nomCidade` varchar(300) DEFAULT NULL,
  `strEmail` varchar(255) DEFAULT NULL,
  `strSite` varchar(300) DEFAULT NULL,
  `desClinicaRadiologica` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaborador`
--

CREATE TABLE `colaborador` (
  `cdnUsuario` int(10) UNSIGNED NOT NULL,
  `codCpf` varchar(20) DEFAULT NULL,
  `strEndereco` varchar(300) DEFAULT NULL,
  `nomCidade` varchar(150) DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `codCep` varchar(10) DEFAULT NULL,
  `numTelefone1` varchar(20) DEFAULT NULL,
  `numTelefone2` varchar(20) DEFAULT NULL,
  `datNascimento` date DEFAULT NULL,
  `datAdmissao` date DEFAULT NULL,
  `indPorcentagem` tinyint(1) DEFAULT '0',
  `valRemuneracao` decimal(10,2) DEFAULT NULL,
  `desColaborador` text,
  `indDesativado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `colaborador`
--

INSERT INTO `colaborador` (`cdnUsuario`, `codCpf`, `strEndereco`, `nomCidade`, `codUf`, `codCep`, `numTelefone1`, `numTelefone2`, `datNascimento`, `datAdmissao`, `indPorcentagem`, `valRemuneracao`, `desColaborador`, `indDesativado`) VALUES
(22, '038.420.230-65', 'fdafsdfsdfsd', 'fsdfsdfasfsdafsadfsd', 'mg', '32423-423', 'de53523423r', '32esr2334es', '1989-08-24', '2015-08-20', 1, '1500.00', 'Observações do fulano poderão entrar aqui.\r\n\r\nteste', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `consulta`
--

CREATE TABLE `consulta` (
  `cdnConsulta` int(10) UNSIGNED NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `cdnAreaAtuacao` int(10) UNSIGNED NOT NULL,
  `cdnConsultorio` int(10) UNSIGNED NOT NULL,
  `cdnProcedimento` int(10) UNSIGNED DEFAULT NULL,
  `cdnSecao` int(10) UNSIGNED DEFAULT NULL,
  `cdnDentista` int(11) NOT NULL,
  `datConsulta` date NOT NULL,
  `numHorarios` int(11) DEFAULT NULL,
  `horaConsulta` time NOT NULL,
  `horaFinalizada` time DEFAULT NULL,
  `desConsulta` text,
  `indEncaixe` tinyint(1) NOT NULL DEFAULT '0',
  `indFinalizada` tinyint(1) NOT NULL DEFAULT '0',
  `indBloquear` tinyint(1) NOT NULL DEFAULT '0',
  `cdnOrcamento` int(10) UNSIGNED DEFAULT NULL,
  `numSegAntecedencia` int(11) DEFAULT NULL,
  `datRemarque` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `consulta`
--

INSERT INTO `consulta` (`cdnConsulta`, `cdnPaciente`, `cdnAreaAtuacao`, `cdnConsultorio`, `cdnProcedimento`, `cdnSecao`, `cdnDentista`, `datConsulta`, `numHorarios`, `horaConsulta`, `horaFinalizada`, `desConsulta`, `indEncaixe`, `indFinalizada`, `indBloquear`, `cdnOrcamento`, `numSegAntecedencia`, `datRemarque`) VALUES
(3, 1, 1, 2, NULL, NULL, 34, '2016-04-11', 2, '10:30:00', '12:30:00', NULL, 0, 0, 0, NULL, 3600, NULL),
(4, 1, 1, 2, NULL, NULL, 35, '2016-04-11', 2, '10:30:00', '12:30:00', NULL, 0, 0, 0, NULL, 3600, NULL),
(11, 1, 1, 2, NULL, NULL, 34, '2016-04-27', 1, '10:30:00', '11:30:00', NULL, 0, 0, 0, NULL, 3600, NULL),
(12, 1, 5, 3, NULL, NULL, 35, '2016-04-28', 2, '12:35:00', '14:35:00', NULL, 1, 0, 1, NULL, 10800, NULL),
(13, 1, 1, 2, NULL, NULL, 34, '2016-04-28', 2, '15:30:00', '16:00:00', NULL, 0, 0, 0, NULL, 3600, NULL),
(14, 1, 1, 2, NULL, NULL, 34, '2016-04-28', 2, '13:30:00', '15:30:00', NULL, 0, 0, 0, NULL, 3600, NULL),
(15, 1, 1, 2, NULL, NULL, 34, '2016-05-10', 2, '07:30:00', '09:30:00', NULL, 0, 0, 0, NULL, 172800, NULL),
(16, 1, 1, 2, NULL, NULL, 34, '2016-05-27', 1, '13:30:00', '14:30:00', NULL, 0, 0, 0, NULL, NULL, NULL),
(17, 1, 5, 3, NULL, NULL, 35, '2016-05-18', 2, '11:30:00', '13:30:00', NULL, 0, 0, 0, NULL, NULL, NULL),
(18, 1, 1, 2, NULL, NULL, 34, '2016-05-18', 2, '15:30:00', '16:00:00', NULL, 0, 0, 0, NULL, NULL, NULL),
(19, 1, 1, 2, NULL, NULL, 34, '2016-05-25', 1, '09:30:00', '10:30:00', NULL, 0, 0, 0, NULL, NULL, NULL),
(20, 1, 1, 2, NULL, NULL, 34, '2016-08-25', 1, '07:30:00', '08:30:00', NULL, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultorio`
--

CREATE TABLE `consultorio` (
  `cdnConsultorio` int(10) UNSIGNED NOT NULL,
  `numConsultorio` varchar(30) NOT NULL,
  `indDesvinculado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `consultorio`
--

INSERT INTO `consultorio` (`cdnConsultorio`, `numConsultorio`, `indDesvinculado`) VALUES
(1, 'CONS013434343', 1),
(2, '01', 0),
(3, '02', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronometro`
--

CREATE TABLE `cronometro` (
  `cdnCronometro` int(10) UNSIGNED NOT NULL,
  `cdnConsulta` int(10) UNSIGNED DEFAULT NULL,
  `datCronometro` date NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `horaChegada` datetime NOT NULL,
  `horaEntrada` datetime DEFAULT NULL,
  `horaSaida` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cronometro`
--

INSERT INTO `cronometro` (`cdnCronometro`, `cdnConsulta`, `datCronometro`, `cdnPaciente`, `horaChegada`, `horaEntrada`, `horaSaida`) VALUES
(2, NULL, '2015-09-11', 6, '2015-09-11 17:25:37', '2015-09-11 17:53:27', '2015-09-11 18:06:00'),
(3, 14, '2015-10-06', 5, '2015-10-06 17:07:58', '2015-10-06 17:11:01', '2015-10-06 17:16:05'),
(4, NULL, '2015-11-16', 10, '2015-11-16 20:09:25', '2015-11-16 20:09:53', '2015-11-16 20:10:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista`
--

CREATE TABLE `dentista` (
  `cdnUsuario` int(10) UNSIGNED NOT NULL,
  `codCro` varchar(10) DEFAULT NULL,
  `codCpf` varchar(20) DEFAULT NULL,
  `strEndereco` varchar(300) DEFAULT NULL,
  `nomCidade` varchar(150) DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `codCep` varchar(10) DEFAULT NULL,
  `numTelefone1` varchar(20) DEFAULT NULL,
  `numTelefone2` varchar(20) DEFAULT NULL,
  `numTempoConsulta` varchar(10) DEFAULT NULL,
  `strContaBancaria` text,
  `strOutrosTrabalhos` text,
  `desDentista` text,
  `datNascimento` date DEFAULT NULL,
  `datAdmissao` date DEFAULT NULL,
  `indDesativado` tinyint(1) NOT NULL DEFAULT '0',
  `cdnConsultorio` int(10) UNSIGNED DEFAULT NULL,
  `numNotaSatisfacao` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `dentista`
--

INSERT INTO `dentista` (`cdnUsuario`, `codCro`, `codCpf`, `strEndereco`, `nomCidade`, `codUf`, `codCep`, `numTelefone1`, `numTelefone2`, `numTempoConsulta`, `strContaBancaria`, `strOutrosTrabalhos`, `desDentista`, `datNascimento`, `datAdmissao`, `indDesativado`, `cdnConsultorio`, `numNotaSatisfacao`) VALUES
(34, NULL, NULL, '', '', 'ac', '', '', '', '01:00', 'ytfvbnm,.', '', '', NULL, NULL, 0, 2, 8),
(35, '', NULL, '', '', 'ac', '', '', '', '01:00', '', '', '', NULL, NULL, 0, 3, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista_aberto`
--

CREATE TABLE `dentista_aberto` (
  `cdnAberto` int(10) UNSIGNED NOT NULL,
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `horaManha` varchar(20) DEFAULT NULL,
  `horaTarde` varchar(20) DEFAULT NULL,
  `datAberto` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista_areaatuacao`
--

CREATE TABLE `dentista_areaatuacao` (
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `cdnAreaAtuacao` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `dentista_areaatuacao`
--

INSERT INTO `dentista_areaatuacao` (`cdnDentista`, `cdnAreaAtuacao`) VALUES
(34, 1),
(35, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista_dias`
--

CREATE TABLE `dentista_dias` (
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `indDomingo` tinyint(1) DEFAULT '0',
  `indSegunda` tinyint(1) DEFAULT '0',
  `indTerca` tinyint(1) DEFAULT '0',
  `indQuarta` tinyint(1) DEFAULT '0',
  `indQuinta` tinyint(1) DEFAULT '0',
  `indSexta` tinyint(1) DEFAULT '0',
  `indSabado` tinyint(1) DEFAULT '0',
  `horaDomingoManha` varchar(15) DEFAULT NULL,
  `horaSegundaManha` varchar(15) DEFAULT NULL,
  `horaTercaManha` varchar(15) DEFAULT NULL,
  `horaQuartaManha` varchar(15) DEFAULT NULL,
  `horaQuintaManha` varchar(15) DEFAULT NULL,
  `horaSextaManha` varchar(15) DEFAULT NULL,
  `horaSabadoManha` varchar(15) DEFAULT NULL,
  `horaDomingoTarde` varchar(15) DEFAULT NULL,
  `horaSegundaTarde` varchar(15) DEFAULT NULL,
  `horaTercaTarde` varchar(15) DEFAULT NULL,
  `horaQuartaTarde` varchar(15) DEFAULT NULL,
  `horaQuintaTarde` varchar(15) DEFAULT NULL,
  `horaSextaTarde` varchar(15) DEFAULT NULL,
  `horaSabadoTarde` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `dentista_dias`
--

INSERT INTO `dentista_dias` (`cdnDentista`, `indDomingo`, `indSegunda`, `indTerca`, `indQuarta`, `indQuinta`, `indSexta`, `indSabado`, `horaDomingoManha`, `horaSegundaManha`, `horaTercaManha`, `horaQuartaManha`, `horaQuintaManha`, `horaSextaManha`, `horaSabadoManha`, `horaDomingoTarde`, `horaSegundaTarde`, `horaTercaTarde`, `horaQuartaTarde`, `horaQuintaTarde`, `horaSextaTarde`, `horaSabadoTarde`) VALUES
(34, 0, 1, 1, 1, 1, 1, 0, NULL, '07:30 - 12:30', '07:30 - 12:30', '07:30 - 12:30', '07:30 - 12:30', '07:30 - 12:30', NULL, NULL, '13:30 - 19:30', '13:30 - 19:30', '13:30 - 19:30', '13:30 - 19:30', '13:30 - 19:30', NULL),
(35, 0, 1, 0, 1, 0, 1, 0, NULL, '07:30 - 12:30', NULL, '07:30 - 12:30', NULL, '07:30 - 12:30', NULL, NULL, '14:00 - 17:30', NULL, '14:00 - 17:30', NULL, '14:00 - 17:30', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista_fechado`
--

CREATE TABLE `dentista_fechado` (
  `cdnFechado` int(11) NOT NULL,
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `datFechado` date NOT NULL,
  `desFechado` text,
  `indAllDay` tinyint(1) NOT NULL DEFAULT '1',
  `horaInicio` time DEFAULT NULL,
  `horaFinal` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista_formapagamento`
--

CREATE TABLE `dentista_formapagamento` (
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `indTipo` int(11) NOT NULL COMMENT '1 - Por hora, 2 - Por dia, 3 - Por área, 4 - Fechado.',
  `indCompartilhaCompra` tinyint(1) NOT NULL,
  `indDependePaciente` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista_intervalo`
--

CREATE TABLE `dentista_intervalo` (
  `cdnIntervalo` int(10) UNSIGNED NOT NULL,
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `horaInicio` time NOT NULL,
  `horaFinal` time NOT NULL,
  `indPermanente` tinyint(1) DEFAULT NULL,
  `datIntervalo` date DEFAULT NULL,
  `indDomingo` tinyint(1) DEFAULT NULL,
  `indSegunda` tinyint(1) DEFAULT NULL,
  `indTerca` tinyint(1) DEFAULT NULL,
  `indQuarta` tinyint(1) DEFAULT NULL,
  `indQuinta` tinyint(1) DEFAULT NULL,
  `indSexta` tinyint(1) DEFAULT NULL,
  `indSabado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `dentista_intervalo`
--

INSERT INTO `dentista_intervalo` (`cdnIntervalo`, `cdnDentista`, `horaInicio`, `horaFinal`, `indPermanente`, `datIntervalo`, `indDomingo`, `indSegunda`, `indTerca`, `indQuarta`, `indQuinta`, `indSexta`, `indSabado`) VALUES
(1, 34, '16:00:00', '17:00:00', 0, NULL, 0, 0, 0, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista_satisfacao`
--

CREATE TABLE `dentista_satisfacao` (
  `cdnSatisfacao` int(10) UNSIGNED NOT NULL,
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `datSatisfacao` date NOT NULL,
  `numNota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `dentista_satisfacao`
--

INSERT INTO `dentista_satisfacao` (`cdnSatisfacao`, `cdnDentista`, `cdnPaciente`, `datSatisfacao`, `numNota`) VALUES
(2, 34, 1, '2016-04-27', 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dependente`
--

CREATE TABLE `dependente` (
  `cdnDependente` int(10) UNSIGNED NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `cdnResponsavel` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `desmarque`
--

CREATE TABLE `desmarque` (
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `cdnConsulta` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `desmarque`
--

INSERT INTO `desmarque` (`cdnPaciente`, `cdnConsulta`) VALUES
(1, 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `erro`
--

CREATE TABLE `erro` (
  `cdnErro` int(11) NOT NULL,
  `strErro` text,
  `nomArquivo` text,
  `numLinha` text,
  `datErro` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `falta`
--

CREATE TABLE `falta` (
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `cdnConsulta` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `cdnFornecedor` int(10) UNSIGNED NOT NULL,
  `nomFornecedor` varchar(300) NOT NULL,
  `numTelefone1` varchar(20) DEFAULT NULL,
  `numTelefone2` varchar(20) DEFAULT NULL,
  `numWhatsapp` varchar(20) DEFAULT NULL,
  `nomFacebook` varchar(300) DEFAULT NULL,
  `strEndereco` varchar(300) DEFAULT NULL,
  `nomRepresentante` varchar(300) DEFAULT NULL,
  `numRepresentanteTelefone` varchar(20) DEFAULT NULL,
  `strRepresentanteEmail` varchar(255) DEFAULT NULL,
  `desFornecedor` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`cdnFornecedor`, `nomFornecedor`, `numTelefone1`, `numTelefone2`, `numWhatsapp`, `nomFacebook`, `strEndereco`, `nomRepresentante`, `numRepresentanteTelefone`, `strRepresentanteEmail`, `desFornecedor`) VALUES
(2, 'Fornecedor 2', '', '', '', '', 'erterterfd', '', '', NULL, NULL),
(3, 'Representante Excel', '(54) 9999-9191', NULL, NULL, 'Facebook do cara', 'Um endereço preenchido aqui', NULL, NULL, NULL, 'Nenhuma');

-- --------------------------------------------------------

--
-- Estrutura da tabela `frase`
--

CREATE TABLE `frase` (
  `cdnFrase` int(10) UNSIGNED NOT NULL,
  `cdnUsuario` int(10) UNSIGNED NOT NULL,
  `strFrase` text NOT NULL,
  `indAtiva` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `frase`
--

INSERT INTO `frase` (`cdnFrase`, `cdnUsuario`, `strFrase`, `indAtiva`) VALUES
(2, 1, 'Tudo muda, menos bermuda.', 1),
(4, 1, 'Tudo tem um fim, menos a salsicha que tem dois.', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `cdnLog` int(11) NOT NULL,
  `strInformacao` text,
  `datLog` datetime DEFAULT NULL,
  `strTipo` text,
  `strOperacao` text,
  `cdnUsuario` text,
  `nomModulo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `log`
--

INSERT INTO `log` (`cdnLog`, `strInformacao`, `datLog`, `strTipo`, `strOperacao`, `cdnUsuario`, `nomModulo`) VALUES
(1, 'SISTEMA', '2016-02-19 15:50:51', 'SUCESSO', 'CADASTRO', '34', 'DENTISTA_FECHADO'),
(2, '34', '2016-02-19 15:56:09', 'SUCESSO', 'ATUALIZACAO', '34', 'DENTISTA'),
(3, '34', '2016-02-19 15:57:02', 'SUCESSO', 'ATUALIZACAO', '34', 'DENTISTA'),
(4, 'paciente - 6', '2016-02-19 15:58:14', 'ERRO', 'CADASTRO', '34', 'CONSULTA'),
(5, '34', '2016-02-23 20:00:20', 'SUCESSO', 'ATUALIZACAO', '1', 'DENTISTA'),
(6, '1', '2016-02-23 20:00:41', 'SUCESSO', 'CADASTRO', '1', 'INTERVALO'),
(7, '2', '2016-02-23 20:00:47', 'SUCESSO', 'CADASTRO', '1', 'INTERVALO'),
(8, '34', '2016-02-23 20:01:23', 'SUCESSO', 'ATUALIZACAO', '1', 'DENTISTA'),
(9, '34', '2016-02-23 20:02:26', 'SUCESSO', 'ATUALIZACAO', '1', 'DENTISTA'),
(10, '34', '2016-02-25 00:03:24', 'ERRO', 'CADASTRO', '34', 'DENTISTA_ABERTO'),
(11, '34', '2016-02-25 00:04:05', 'ERRO', 'CADASTRO', '34', 'DENTISTA_ABERTO'),
(12, '34', '2016-02-25 00:32:00', 'SUCESSO', 'CADASTRO', '1', 'DENTISTA_ABERTO'),
(13, '17', '2016-02-25 00:32:48', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(14, '35', '2016-02-26 10:38:50', 'SUCESSO', 'CADASTRO', '1', 'DENTISTA_ABERTO'),
(15, '35', '2016-02-26 10:39:06', 'SUCESSO', 'ATUALIZACAO', '1', 'DENTISTA'),
(16, '35', '2016-02-26 10:40:58', 'SUCESSO', 'ATUALIZACAO', '1', 'DENTISTA'),
(17, '34', '2016-04-06 00:53:02', 'SUCESSO', 'ATUALIZACAO', '1', 'DENTISTA'),
(18, '1', '2016-04-06 00:53:26', 'SUCESSO', 'CADASTRO', '1', 'INTERVALO'),
(19, '35', '2016-04-06 00:54:38', 'SUCESSO', 'ATUALIZACAO', '1', 'DENTISTA'),
(20, '1', '2016-04-06 00:55:32', 'SUCESSO', 'CADASTRO', '1', 'PACIENTE'),
(21, 'paciente - 1', '2016-04-06 00:56:58', 'ERRO', 'CADASTRO', '1', 'CONSULTA'),
(22, 'paciente - 1', '2016-04-06 00:57:43', 'ERRO', 'CADASTRO', '1', 'CONSULTA'),
(23, 'paciente - 1', '2016-04-06 01:00:26', 'ERRO', 'CADASTRO', '1', 'CONSULTA'),
(24, 'paciente - 1', '2016-04-06 01:01:36', 'ERRO', 'CADASTRO', '1', 'CONSULTA'),
(25, 'paciente - 1', '2016-04-08 14:25:23', 'ERRO', 'CADASTRO', '1', 'CONSULTA'),
(26, 'paciente - 1', '2016-04-08 14:27:31', 'ERRO', 'CADASTRO', '1', 'CONSULTA'),
(27, '3', '2016-04-08 14:28:13', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(28, '4', '2016-04-08 14:29:37', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(29, '4', '2016-04-08 14:29:52', 'SUCESSO', 'CADASTRO', '1', 'DESMARQUE'),
(30, '4', '2016-04-08 14:29:58', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(31, 'dentista2@final1.com.br', '2016-04-26 11:13:24', 'ERRO', 'CADASTRO', '1', 'DENTISTA'),
(32, 'SISTEMA', '2016-04-27 09:57:36', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(33, '11', '2016-04-27 10:06:50', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(34, '12', '2016-04-28 09:29:03', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(35, '12', '2016-04-28 09:29:20', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(36, '14', '2016-04-28 21:41:53', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(37, '14', '2016-04-28 21:43:22', 'SUCESSO', 'CADASTRO', '1', 'DESMARQUE'),
(38, '14', '2016-04-28 21:43:38', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(39, '14', '2016-04-28 21:50:25', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(40, '14', '2016-04-28 21:50:33', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(41, '14', '2016-04-28 21:51:00', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(42, '14', '2016-04-28 21:52:22', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(43, '14', '2016-04-28 21:52:37', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(44, '14', '2016-04-28 21:53:10', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(45, '14', '2016-04-28 21:53:23', 'SUCESSO', 'CADASTRO', '1', 'DESMARQUE'),
(46, '14', '2016-04-28 21:53:37', 'SUCESSO', 'DESFAZER', '1', 'DESMARQUE'),
(47, '14', '2016-04-28 21:53:46', 'SUCESSO', 'CADASTRO', '1', 'FALTA'),
(48, '14', '2016-04-28 21:57:10', 'SUCESSO', 'CADASTRO', '1', 'DESMARQUE'),
(49, '13', '2016-04-28 21:57:39', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(50, 'SISTEMA', '2016-04-28 21:58:12', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(51, '13', '2016-04-28 22:03:04', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(52, '13', '2016-04-28 22:03:26', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(53, '13', '2016-04-28 22:03:58', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(54, '13', '2016-04-28 22:04:12', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(55, '13', '2016-04-28 22:04:40', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(56, '13', '2016-04-28 22:04:59', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(57, '13', '2016-04-28 22:06:30', 'SUCESSO', 'REMARCAR', '1', 'CONSULTA'),
(58, 'SISTEMA', '2016-04-30 22:20:04', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(59, 'SISTEMA', '2016-04-30 22:20:08', 'ERRO', 'CONFIGURACOES', '1', 'SMS'),
(60, 'SISTEMA', '2016-04-30 22:20:12', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(61, 'SISTEMA', '2016-04-30 22:20:15', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(62, 'SISTEMA', '2016-04-30 22:20:48', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(63, 'SISTEMA', '2016-04-30 22:20:50', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(64, 'SISTEMA', '2016-04-30 22:20:56', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(65, 'SISTEMA', '2016-05-01 19:41:35', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(66, 'SISTEMA', '2016-05-01 19:41:47', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(67, 'SISTEMA', '2016-05-01 19:41:53', 'SUCESSO', 'CONFIGURACOES', '1', 'SMS'),
(68, '15', '2016-05-06 09:51:19', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(69, '16', '2016-05-09 14:12:46', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(70, '17', '2016-05-13 11:10:49', 'SUCESSO', 'CADASTRO', '35', 'CONSULTA'),
(71, '18', '2016-05-13 11:11:25', 'SUCESSO', 'CADASTRO', '35', 'CONSULTA'),
(72, '34', '2016-05-13 11:23:03', 'SUCESSO', 'DELECAO', '35', 'DENTISTA'),
(73, '34', '2016-05-13 11:24:19', 'SUCESSO', 'DELECAO', '35', 'DENTISTA'),
(74, '34', '2016-05-13 11:24:36', 'SUCESSO', 'DELECAO', '35', 'DENTISTA'),
(75, '34', '2016-05-13 11:24:55', 'SUCESSO', 'DELECAO', '35', 'DENTISTA'),
(76, '34', '2016-05-13 11:25:19', 'SUCESSO', 'DELECAO', '35', 'DENTISTA'),
(77, '34', '2016-05-13 11:28:37', 'SUCESSO', 'DELECAO', '35', 'DENTISTA'),
(78, 'SISTEMA', '2016-05-19 15:19:17', 'SUCESSO', 'IMPRESSAO', '35', 'AGENDA-DENTISTA'),
(79, '19', '2016-05-24 14:20:16', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(80, '20', '2016-05-24 15:16:43', 'SUCESSO', 'CADASTRO', '1', 'CONSULTA'),
(81, '1', '2016-05-24 21:45:24', 'SUCESSO', 'CADASTRO', '1', 'PARCERIA'),
(82, '1', '2016-05-24 21:46:00', 'SUCESSO', 'ATUALIZACAO', '1', 'PACIENTE'),
(83, '1', '2016-05-24 21:52:48', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(84, '1', '2016-05-24 22:47:41', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(85, '1', '2016-05-24 22:58:38', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(86, '1', '2016-05-24 22:59:25', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(87, '1', '2016-05-24 22:59:44', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(88, '1', '2016-05-24 22:59:48', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(89, '1', '2016-05-24 23:00:06', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(90, '1', '2016-05-24 23:01:08', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(91, '1', '2016-05-24 23:02:12', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(92, '1', '2016-05-24 23:02:15', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(93, '1', '2016-05-24 23:03:30', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(94, '1', '2016-05-24 23:03:52', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(95, '1', '2016-05-24 23:04:27', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(96, '1', '2016-05-24 23:11:49', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(97, '1', '2016-05-24 23:11:58', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(98, '1', '2016-05-24 23:12:52', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(99, '1', '2016-05-24 23:13:04', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(100, '1', '2016-05-24 23:13:18', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(101, '1', '2016-05-24 23:15:10', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(102, '1', '2016-05-24 23:15:37', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(103, '1', '2016-05-24 23:16:10', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(104, '1', '2016-05-24 23:17:01', 'ERRO', 'PRECO', '1', 'PARCERIA'),
(105, '1', '2016-05-24 23:17:42', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(106, '1', '2016-05-24 23:17:46', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(107, '1', '2016-05-24 23:18:02', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(108, '1', '2016-05-29 13:22:50', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(109, '1', '2016-05-29 13:23:37', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(110, '1', '2016-05-29 13:24:01', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(111, '1', '2016-05-29 13:24:32', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(112, '1', '2016-05-29 13:25:47', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(113, '1', '2016-05-29 13:26:04', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(114, '1', '2016-05-29 13:27:43', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(115, '1', '2016-05-29 13:27:50', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(116, '1', '2016-05-29 13:29:07', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(117, '1', '2016-05-29 13:31:18', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(118, '1', '2016-05-29 13:33:02', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(119, '1', '2016-05-29 13:34:40', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(120, '1', '2016-05-29 13:34:45', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(121, '1', '2016-05-29 13:35:02', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(122, '1', '2016-05-29 13:35:08', 'SUCESSO', 'PRECO', '1', 'PARCERIA'),
(123, '1', '2016-05-29 13:36:01', 'SUCESSO', 'CADASTRO', '1', 'TABELAPRECO'),
(124, '1', '2016-05-29 13:36:07', 'SUCESSO', 'EDITAR', '1', 'TABELAPRECO'),
(125, 'SISTEMA', '2016-05-31 00:55:12', 'ERRO', 'CADASTRO', '1', 'ORCAMENTO'),
(126, 'SISTEMA', '2016-05-31 00:57:41', 'ERRO', 'CADASTRO', '1', 'ORCAMENTO'),
(127, '2', '2016-05-31 00:58:56', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(128, '3', '2016-05-31 01:19:48', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(129, '3', '2016-05-31 05:22:51', 'ERRO', 'APROVACAO', '1', 'ORCAMENTO'),
(130, '3', '2016-05-31 05:23:27', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(131, '3', '2016-05-31 05:31:31', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(132, '3', '2016-05-31 05:34:30', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(133, '3', '2016-05-31 05:37:11', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(134, '3', '2016-05-31 05:38:21', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(135, '3', '2016-05-31 05:41:53', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(136, '3', '2016-05-31 05:42:13', 'ERRO', 'APROVACAO', '1', 'ORCAMENTO'),
(137, '4', '2016-05-31 06:06:23', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(138, '4', '2016-05-31 06:09:06', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(139, '4-1', '2016-05-31 06:09:32', 'SUCESSO', 'ATUALIZAR', '1', 'PARCELA'),
(140, '1 - orcamento_parcela', '2016-05-31 06:09:40', 'SUCESSO', 'GERACAO', '1', 'BOLETO'),
(141, '5', '2016-05-31 16:04:20', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(142, '5', '2016-05-31 16:07:43', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(143, '6', '2016-06-05 19:56:34', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(144, '6', '2016-06-05 19:57:12', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(145, '7', '2016-06-05 20:02:09', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(146, '7', '2016-06-05 20:02:29', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(147, 'SISTEMA', '2016-06-05 20:09:45', 'ERRO', 'CADASTRO', '1', 'ORCAMENTO'),
(148, '9', '2016-06-05 20:10:12', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(149, '10', '2016-06-05 20:27:43', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(150, '9', '2016-06-05 20:31:25', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(151, '10', '2016-06-05 21:29:32', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO'),
(152, '11', '2016-06-10 16:13:14', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(153, '12', '2016-06-10 16:14:31', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(154, 'SISTEMA', '2016-06-11 09:32:37', 'ERRO', 'CADASTRO', '1', 'ORCAMENTO'),
(155, '13', '2016-06-11 09:37:05', 'SUCESSO', 'CADASTRO', '1', 'ORCAMENTO'),
(156, '13', '2016-06-11 09:41:42', 'SUCESSO', 'APROVACAO', '1', 'ORCAMENTO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `cdnOrcamento` int(10) UNSIGNED NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `datOrcamento` date DEFAULT NULL,
  `datValidade` date DEFAULT NULL,
  `valOrcamento` decimal(10,2) NOT NULL,
  `valEntrada` decimal(10,2) DEFAULT NULL,
  `indAprovado` tinyint(1) DEFAULT NULL,
  `indFinalizado` tinyint(1) NOT NULL DEFAULT '0',
  `desOrcamento` text,
  `indTipoDesconto` varchar(3) DEFAULT NULL,
  `valDesconto` varchar(15) DEFAULT NULL,
  `valFinal` decimal(10,2) DEFAULT NULL,
  `cdnUsuarioAprovou` int(10) UNSIGNED DEFAULT NULL,
  `datAprovacao` datetime DEFAULT NULL,
  `cdnTabelaPreco` varchar(20) NOT NULL,
  `indCobrarJuros` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `orcamento`
--

INSERT INTO `orcamento` (`cdnOrcamento`, `cdnPaciente`, `datOrcamento`, `datValidade`, `valOrcamento`, `valEntrada`, `indAprovado`, `indFinalizado`, `desOrcamento`, `indTipoDesconto`, `valDesconto`, `valFinal`, `cdnUsuarioAprovou`, `datAprovacao`, `cdnTabelaPreco`, `indCobrarJuros`) VALUES
(3, 1, '2016-05-31', '2016-07-01', '250.00', NULL, 1, 0, NULL, '', '', '255.08', 1, '2016-05-31 05:41:53', 'parceria1', 1),
(4, 1, '2016-06-15', '2016-07-15', '950.01', NULL, 1, 0, NULL, NULL, NULL, '950.00', 1, '2016-05-31 06:09:06', '1', 0),
(5, 1, '2016-05-31', '2016-07-01', '650.00', NULL, 1, 0, NULL, 'qtd', '0.00', '669.89', 1, '2016-05-31 16:07:43', '1', 1),
(6, 1, '2016-06-05', '2016-07-05', '150.00', NULL, 1, 0, NULL, 'qtd', '53.05', '100.00', 1, '2016-06-05 19:57:11', 'parceria1', 1),
(7, 1, '2016-06-05', '2016-07-05', '150.00', NULL, 1, 0, NULL, 'qtd', '0.00', '159.32', 1, '2016-06-05 20:02:27', 'parceria1', 1),
(9, 1, '2016-06-05', '2016-07-05', '250.00', NULL, 1, 0, NULL, 'qtd', '', '265.54', 1, '2016-06-05 20:31:24', '1', 1),
(10, 1, '2016-06-05', '2016-07-05', '250.00', NULL, 0, 0, NULL, 'qtd', '', '250.00', 1, '2016-06-05 21:29:32', '1', 1),
(11, 1, '2016-06-10', '2016-07-10', '150.00', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'parceria1', 1),
(12, 1, '2016-06-10', '2016-07-10', '150.00', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'parceria1', 1),
(13, 1, '2016-06-11', '2016-07-11', '300.00', NULL, 1, 0, NULL, 'qtd', '', '300.00', 1, '2016-06-11 09:41:41', 'parceria1', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_aprovacao`
--

CREATE TABLE `orcamento_aprovacao` (
  `cdnOrcamento` int(11) NOT NULL,
  `cdnDentista` int(11) NOT NULL,
  `indAprovado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_formapagamento`
--

CREATE TABLE `orcamento_formapagamento` (
  `cdnOrcamento` int(10) UNSIGNED NOT NULL,
  `indForma` text NOT NULL,
  `indVia` text NOT NULL,
  `numVezes` int(11) DEFAULT NULL,
  `numPorcentagem` float DEFAULT NULL,
  `numDiaVencimento` int(11) DEFAULT NULL,
  `datInicioPagamento` date DEFAULT NULL,
  `datVencimento` date DEFAULT NULL,
  `valFinalTaxas` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `orcamento_formapagamento`
--

INSERT INTO `orcamento_formapagamento` (`cdnOrcamento`, `indForma`, `indVia`, `numVezes`, `numPorcentagem`, `numDiaVencimento`, `datInicioPagamento`, `datVencimento`, `valFinalTaxas`) VALUES
(3, 'parcelado', 'boleto', 2, 1.01, 10, '2016-07-10', NULL, NULL),
(4, 'parcelado', 'boleto', 2, 0, 10, '2016-07-10', NULL, NULL),
(5, 'parcelado', 'nota', 3, 1.01, 10, '2016-07-10', NULL, NULL),
(6, 'parcelado', 'autorizacaoDesc', 2, 1.01, 10, '2016-07-10', NULL, NULL),
(7, 'parcelado', 'carne', 6, 1.01, 10, '2016-07-10', NULL, NULL),
(9, 'parcelado', 'carne', 6, 1.01, 10, '2016-07-10', NULL, NULL),
(10, 'aVista', 'boleto', 1, 1.01, NULL, '2016-07-10', '2016-07-10', NULL),
(13, 'aVista', 'nota', 1, 1.01, NULL, '2016-07-10', '2016-07-10', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_parcela`
--

CREATE TABLE `orcamento_parcela` (
  `cdnOrcamento` int(10) UNSIGNED NOT NULL,
  `numParcela` int(11) NOT NULL,
  `valParcela` decimal(10,2) NOT NULL,
  `datVencimento` date DEFAULT NULL,
  `indPaga` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `orcamento_parcela`
--

INSERT INTO `orcamento_parcela` (`cdnOrcamento`, `numParcela`, `valParcela`, `datVencimento`, `indPaga`) VALUES
(3, 1, '127.54', '2016-07-10', 0),
(3, 2, '127.54', '2016-08-10', 0),
(4, 1, '475.00', '2016-07-15', 0),
(4, 2, '475.00', '2016-08-10', 0),
(5, 1, '223.30', '2016-07-10', 0),
(5, 2, '223.30', '2016-08-10', 0),
(5, 3, '223.29', '2016-09-10', 0),
(6, 1, '50.00', '2016-07-10', 0),
(6, 2, '50.00', '2016-08-10', 0),
(7, 1, '26.55', '2016-07-10', 0),
(7, 2, '26.55', '2016-08-10', 0),
(7, 3, '26.55', '2016-09-10', 0),
(7, 4, '26.55', '2016-10-10', 0),
(7, 5, '26.55', '2016-11-10', 0),
(7, 6, '26.57', '2016-12-10', 0),
(9, 1, '44.26', '2016-07-10', 0),
(9, 2, '44.26', '2016-08-10', 0),
(9, 3, '44.26', '2016-09-10', 0),
(9, 4, '44.26', '2016-10-10', 0),
(9, 5, '44.26', '2016-11-10', 0),
(9, 6, '44.24', '2016-12-10', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_procedimento`
--

CREATE TABLE `orcamento_procedimento` (
  `cdnOrcamento` int(10) UNSIGNED NOT NULL,
  `cdnAreaAtuacao` int(10) UNSIGNED NOT NULL,
  `cdnProcedimento` int(10) UNSIGNED NOT NULL,
  `cdnDentista` int(10) UNSIGNED NOT NULL,
  `numQuantidade` int(11) NOT NULL,
  `numQuantidadeRealizado` int(11) DEFAULT '0',
  `valUnitario` decimal(10,2) NOT NULL,
  `numDente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `orcamento_procedimento`
--

INSERT INTO `orcamento_procedimento` (`cdnOrcamento`, `cdnAreaAtuacao`, `cdnProcedimento`, `cdnDentista`, `numQuantidade`, `numQuantidadeRealizado`, `valUnitario`, `numDente`) VALUES
(3, 1, 21, 34, 1, 0, '100.00', '54'),
(3, 1, 22, 34, 1, 0, '150.00', '55'),
(4, 1, 22, 34, 1, 0, '250.01', '88'),
(4, 1, 27, 34, 2, 0, '350.00', '75'),
(5, 1, 21, 34, 2, 0, '200.00', ''),
(5, 1, 22, 34, 1, 0, '250.00', ''),
(6, 1, 22, 34, 1, 0, '150.00', '44'),
(7, 1, 22, 34, 1, 0, '150.00', ''),
(9, 1, 22, 34, 1, 0, '250.00', ''),
(10, 1, 22, 34, 1, 0, '250.00', '33'),
(11, 1, 22, 34, 1, 0, '150.00', '55'),
(12, 1, 22, 34, 1, 0, '150.00', '55'),
(13, 1, 22, 34, 2, 0, '150.00', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `paciente`
--

CREATE TABLE `paciente` (
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `nomPaciente` varchar(300) NOT NULL,
  `nomSobrenome` varchar(300) DEFAULT NULL,
  `codCpf` varchar(20) DEFAULT NULL,
  `datNascimento` date DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `fileFoto` text,
  `cdnParceria` int(10) UNSIGNED DEFAULT NULL,
  `indDesvinculado` tinyint(1) NOT NULL DEFAULT '0',
  `numDiasAntecedenciaSms` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `paciente`
--

INSERT INTO `paciente` (`cdnPaciente`, `nomPaciente`, `nomSobrenome`, `codCpf`, `datNascimento`, `codUf`, `fileFoto`, `cdnParceria`, `indDesvinculado`, `numDiasAntecedenciaSms`) VALUES
(1, 'Fulano', 'de Tal', '038.420.230-65', '1995-06-21', 'rs', '', 1, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `paciente_responsavel`
--

CREATE TABLE `paciente_responsavel` (
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `cdnPacienteResponsavel` int(10) UNSIGNED DEFAULT NULL,
  `nomResponsavel` varchar(300) DEFAULT NULL,
  `strEndereco` text,
  `codCep` varchar(20) DEFAULT NULL,
  `nomCidade` varchar(300) DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `numTelefones` varchar(200) DEFAULT NULL,
  `codCpf` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `cdnPagamento` int(10) UNSIGNED NOT NULL,
  `cdnOrcamento` int(10) UNSIGNED NOT NULL,
  `numParcela` int(11) DEFAULT NULL,
  `valPagamento` decimal(10,2) NOT NULL,
  `numNotaFiscal` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parceria`
--

CREATE TABLE `parceria` (
  `cdnParceria` int(10) UNSIGNED NOT NULL,
  `cdnIndicacao` int(10) UNSIGNED DEFAULT NULL,
  `indPaciente` tinyint(1) DEFAULT '1',
  `nomParceria` varchar(300) NOT NULL,
  `strEndereco` varchar(300) DEFAULT NULL,
  `nomCidade` varchar(300) DEFAULT NULL,
  `codCep` varchar(10) DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `indFisica` tinyint(1) DEFAULT NULL,
  `codCpfCnpj` varchar(30) DEFAULT NULL,
  `codIe` int(11) DEFAULT NULL,
  `numTelefone1` varchar(20) DEFAULT NULL,
  `numTelefone2` varchar(20) DEFAULT NULL,
  `strEmail` varchar(255) DEFAULT NULL,
  `nomRepresentante` varchar(300) DEFAULT NULL,
  `numRepresentanteTelefone` varchar(20) DEFAULT NULL,
  `strRepresentanteEmail` varchar(255) DEFAULT NULL,
  `datContrato` date DEFAULT NULL,
  `numContrato` varchar(100) DEFAULT NULL,
  `indDesvinculada` tinyint(1) NOT NULL DEFAULT '0',
  `desParceria` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `parceria`
--

INSERT INTO `parceria` (`cdnParceria`, `cdnIndicacao`, `indPaciente`, `nomParceria`, `strEndereco`, `nomCidade`, `codCep`, `codUf`, `indFisica`, `codCpfCnpj`, `codIe`, `numTelefone1`, `numTelefone2`, `strEmail`, `nomRepresentante`, `numRepresentanteTelefone`, `strRepresentanteEmail`, `datContrato`, `numContrato`, `indDesvinculada`, `desParceria`) VALUES
(1, NULL, 0, 'Primeira parceria', NULL, NULL, NULL, 'ac', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `parceria_preco`
--

CREATE TABLE `parceria_preco` (
  `cdnPreco` int(10) UNSIGNED NOT NULL,
  `cdnParceria` int(10) UNSIGNED NOT NULL,
  `cdnProcedimento` int(10) UNSIGNED NOT NULL,
  `valPreco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `parceria_preco`
--

INSERT INTO `parceria_preco` (`cdnPreco`, `cdnParceria`, `cdnProcedimento`, `valPreco`) VALUES
(415, 1, 21, '100.00'),
(416, 1, 22, '150.00'),
(417, 1, 23, '200.00'),
(418, 1, 27, '250.00'),
(419, 1, 24, '300.00'),
(420, 1, 25, '350.00'),
(421, 1, 26, '400.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parceria_tipo`
--

CREATE TABLE `parceria_tipo` (
  `cdnParceriaTipo` int(10) UNSIGNED NOT NULL,
  `nomParceriaTipo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pergunta`
--

CREATE TABLE `pergunta` (
  `cdnPergunta` int(10) UNSIGNED NOT NULL,
  `strPergunta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pergunta`
--

INSERT INTO `pergunta` (`cdnPergunta`, `strPergunta`) VALUES
(1, 'Quando foi seu último exame dentário completo?'),
(2, 'Você está sob cuidado médico? Por que?'),
(3, 'É alérgico a algum medicamento ou substância?'),
(4, 'Qual?'),
(5, 'Se você é mulher, está grávida ou crê que possa estar?'),
(6, 'Tem pressão alta ou baixa?'),
(7, 'Tem alteração no sangue como Anemia, Leucemia, Hemorragia, etc?'),
(8, 'Tem algum problema Estomacal?'),
(9, 'Você é diabético ou cardíaco?lksdja flkasdjdsak dsafjsdalkf jsdalkf jsdalkfsd jalfkasd jlfkasd jflksdaj flksad jfdslakf jadslkf jsdalkf jsad'),
(10, 'Quais as vacinas que já fez?'),
(11, 'Quando?'),
(12, 'Está tomando algum medicamento?'),
(13, 'Já fez ou está fazendo Raioterapia/Quimioterapia?'),
(14, 'Já fez transfusão de sangue?'),
(15, 'Usou ou usa hormônios por tempo prolongado?klfjsdkf jdslkfs djlfksd jflksd jflksd jflskd jfsdl fjdslf jsdlkfj sdlkf jsdlfkds jlfsd jflsdk jfsdalkfasdkfhsd'),
(16, 'Fez alguma cirurgia nos últimos 5 anos?'),
(17, 'Já teve alguma destas doenças?'),
(18, 'vvzvvzvzvxvzxcvs fds fsd fsdf asdf asdf sad');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pergunta_opcao`
--

CREATE TABLE `pergunta_opcao` (
  `cdnOpcao` int(10) UNSIGNED NOT NULL,
  `cdnPergunta` int(10) UNSIGNED NOT NULL,
  `strOpcao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pergunta_opcao`
--

INSERT INTO `pergunta_opcao` (`cdnOpcao`, `cdnPergunta`, `strOpcao`) VALUES
(1, 17, 'Tuberculose'),
(2, 17, 'Sífilis'),
(3, 17, 'Tumor'),
(4, 17, 'HIV'),
(5, 17, 'Doença Renal'),
(6, 17, 'Febre Reumática'),
(7, 17, 'Discrasias Sanguíneas'),
(8, 17, 'Epilepsia  / convulsão '),
(11, 19, 'Trombose');

-- --------------------------------------------------------

--
-- Estrutura da tabela `procedimento`
--

CREATE TABLE `procedimento` (
  `cdnProcedimento` int(10) UNSIGNED NOT NULL,
  `cdnAreaAtuacao` int(10) UNSIGNED NOT NULL,
  `nomProcedimento` varchar(300) NOT NULL,
  `desProcedimento` text,
  `indAviso` tinyint(1) NOT NULL DEFAULT '0',
  `indDesvinculado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `procedimento`
--

INSERT INTO `procedimento` (`cdnProcedimento`, `cdnAreaAtuacao`, `nomProcedimento`, `desProcedimento`, `indAviso`, `indDesvinculado`) VALUES
(20, 1, 'Primeiro procedimento', NULL, 0, 1),
(21, 1, 'Segundo procedimento', NULL, 0, 0),
(22, 1, 'Novo procedimento', NULL, 0, 0),
(23, 1, 'tal', NULL, 0, 0),
(24, 6, 'Prevenção', NULL, 0, 0),
(25, 6, 'Raspagem supra-gengival', NULL, 0, 0),
(26, 7, 'Prótese coroa metal cerâmica', NULL, 0, 0),
(27, 1, 'teste', NULL, 0, 0),
(28, 5, 'dfg', 'dfgdf', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prontuario_anexo`
--

CREATE TABLE `prontuario_anexo` (
  `cdnProntuarioAnexo` int(11) NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `strDiretorio` text NOT NULL,
  `desProntuarioAnexo` text,
  `valTamanho` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prontuario_historico`
--

CREATE TABLE `prontuario_historico` (
  `cdnProntuarioHistorico` int(10) UNSIGNED NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `datInicio` date NOT NULL,
  `datFim` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prontuario_tratamento`
--

CREATE TABLE `prontuario_tratamento` (
  `cdnProntuarioTratamento` int(10) UNSIGNED NOT NULL,
  `datProntuarioTratamento` date DEFAULT NULL,
  `desProntuarioTratamento` text,
  `numDente` varchar(30) DEFAULT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `cdnDentista` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta`
--

CREATE TABLE `resposta` (
  `cdnResposta` bigint(10) UNSIGNED NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `cdnPergunta` int(10) UNSIGNED NOT NULL,
  `cdnOpcao` int(10) UNSIGNED DEFAULT NULL,
  `strResposta` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `retorno`
--

CREATE TABLE `retorno` (
  `cdnConsultaRetorno` int(10) UNSIGNED NOT NULL,
  `cdnConsultaOriginal` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `retorno`
--

INSERT INTO `retorno` (`cdnConsultaRetorno`, `cdnConsultaOriginal`) VALUES
(19, 16),
(20, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `schema_campo`
--

CREATE TABLE `schema_campo` (
  `cdnCampo` int(11) NOT NULL,
  `cdnPai` int(11) NOT NULL DEFAULT '0',
  `codSequencial` int(11) NOT NULL,
  `nomTabela` varchar(100) NOT NULL,
  `nomCampo` varchar(100) NOT NULL,
  `indTipo` varchar(100) NOT NULL,
  `desLabel` text NOT NULL,
  `indMostrar` tinyint(1) NOT NULL DEFAULT '1',
  `indRequired` tinyint(1) NOT NULL DEFAULT '0',
  `numLimite` int(11) DEFAULT '0',
  `strValidacoes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `schema_campo`
--

INSERT INTO `schema_campo` (`cdnCampo`, `cdnPai`, `codSequencial`, `nomTabela`, `nomCampo`, `indTipo`, `desLabel`, `indMostrar`, `indRequired`, `numLimite`, `strValidacoes`) VALUES
(1, 0, 1, 'paciente', 'cdnPaciente', 'number', 'Código numérico', 0, 0, NULL, 'numero'),
(2, 0, 2, 'paciente', 'nomPaciente', 'text', 'Nome', 1, 1, 300, 'vazio'),
(3, 0, 6, 'paciente', 'codCpf', 'cpf', 'CPF', 1, 0, 20, 'cpf'),
(4, 0, 4, 'paciente', 'datNascimento', 'date', 'Data de nascimento', 1, 0, NULL, 'data'),
(5, 0, 5, 'paciente', 'codUf', 'select', 'Estado', 1, 0, 0, 'uf'),
(6, 5, 1, 'paciente', 'rs', 'option', 'Rio Grande do Sul', 1, 0, 0, ''),
(7, 5, 2, 'paciente', 'rj', 'option', 'Rio de Janeiro', 1, 0, 0, ''),
(8, 0, 0, 'paciente', 'indDesvinculado', 'boolean', 'Desvinculado?', 0, 0, 0, ''),
(9, 0, 7, 'paciente', 'fileFoto', 'file', 'Foto', 1, 0, 0, 'imagem'),
(10, 0, 3, 'paciente', 'nomSobrenome', 'text', 'Sobrenome', 1, 1, 300, 'vazio'),
(11, 0, 99, 'paciente', 'cdnParceria', 'integer', 'Parceria', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `secao`
--

CREATE TABLE `secao` (
  `cdnSecao` int(10) UNSIGNED NOT NULL,
  `cdnProcedimento` int(10) UNSIGNED NOT NULL,
  `nomSecao` varchar(300) NOT NULL,
  `desSecao` text,
  `indAviso` tinyint(1) NOT NULL DEFAULT '0',
  `indDesvinculada` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `secao`
--

INSERT INTO `secao` (`cdnSecao`, `cdnProcedimento`, `nomSecao`, `desSecao`, `indAviso`, `indDesvinculada`) VALUES
(1, 22, 'Primeira seção', 'Seção que irá conter uma descrição', 0, 0),
(2, 20, 'Seção maneira', 'agora vai ter descrição', 0, 0),
(3, 21, 'Primeira seção do segundo procedimento', 'hu3', 0, 1),
(4, 21, 'Segunda seção do segundo procedimento', 'brbr', 1, 0),
(5, 23, 'seção do tal', 'descrição do tal', 0, 0),
(6, 23, 'ghfghh', 'hhdfhgf', 0, 0),
(7, 26, 'Prova do casquete', '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sms`
--

CREATE TABLE `sms` (
  `cdnSms` bigint(20) UNSIGNED NOT NULL,
  `datEnvio` datetime NOT NULL,
  `cdnUsuario` int(10) UNSIGNED NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `strTexto` text NOT NULL,
  `numTelefone` varchar(20) NOT NULL,
  `numIdZenvia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sms`
--

INSERT INTO `sms` (`cdnSms`, `datEnvio`, `cdnUsuario`, `cdnPaciente`, `strTexto`, `numTelefone`, `numIdZenvia`) VALUES
(1, '2016-04-26 10:54:42', 0, 1, 'Algum texto.', '555499031426', '328794654789451'),
(2, '2016-04-20 10:54:42', 0, 1, 'Algum texto.', '555499031426', '328794654789451'),
(3, '2016-04-27 10:16:29', 0, 1, 'Ola, Fulano! Voce tem uma consulta marcada para as 10:30:00 do dia 27/04/2016 na clinica Clinica de Testes. Responda "Confirmar" ou "Cancelar".', '555499031426', '280505720bbadc73e9'),
(4, '2016-04-27 10:46:16', 0, 1, 'Ola, Fulano! Avalie o atendimento do profissional Ciclano com uma nota de "0" ate "10".', '555499031426', '63495720c2a8e6cab'),
(5, '2016-04-28 09:35:26', 0, 1, 'Ola, Fulano! Voce tem uma consulta marcada para as 12:35:00 do dia 28/04/2016 na clinica Clinica de Testes. Responda "Confirmar" ou "Cancelar".', '555499031426', '15815722038edb703');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sms_aviso_consulta`
--

CREATE TABLE `sms_aviso_consulta` (
  `cdnConsulta` int(10) UNSIGNED NOT NULL,
  `cdnSms` int(11) DEFAULT NULL,
  `datAviso` datetime NOT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `indModificou` tinyint(1) NOT NULL DEFAULT '0',
  `numTelefone` varchar(12) NOT NULL,
  `codErro` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sms_aviso_consulta`
--

INSERT INTO `sms_aviso_consulta` (`cdnConsulta`, `cdnSms`, `datAviso`, `cdnPaciente`, `indModificou`, `numTelefone`, `codErro`) VALUES
(3, 1, '2016-04-11 00:00:00', 1, 0, '555499031426', NULL),
(11, 3, '2016-04-27 10:15:00', 1, 0, '555499031426', NULL),
(12, 5, '2016-04-28 09:35:00', 1, 0, '555499031426', NULL),
(13, NULL, '2016-04-28 14:30:00', 1, 0, '555499031426', NULL),
(15, NULL, '2016-05-08 07:30:00', 1, 0, '555499031426', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sms_aviso_consulta_resposta`
--

CREATE TABLE `sms_aviso_consulta_resposta` (
  `cdnResposta` int(11) NOT NULL,
  `cdnConsulta` int(10) UNSIGNED NOT NULL,
  `indVisualizado` tinyint(1) NOT NULL DEFAULT '0',
  `datResposta` datetime NOT NULL,
  `strResposta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sms_aviso_consulta_resposta`
--

INSERT INTO `sms_aviso_consulta_resposta` (`cdnResposta`, `cdnConsulta`, `indVisualizado`, `datResposta`, `strResposta`) VALUES
(1, 11, 1, '2016-04-27 10:41:02', 'Confirmar'),
(4, 12, 1, '2016-04-28 09:36:08', 'Confirmar'),
(5, 3, 1, '2016-04-27 10:49:35', '8');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sms_contagem_paciente`
--

CREATE TABLE `sms_contagem_paciente` (
  `cdnPaciente` int(10) UNSIGNED NOT NULL,
  `numEnvios` int(11) DEFAULT NULL,
  `numRecebimentos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sms_contagem_paciente`
--

INSERT INTO `sms_contagem_paciente` (`cdnPaciente`, `numEnvios`, `numRecebimentos`) VALUES
(1, 0, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sms_satisfacao`
--

CREATE TABLE `sms_satisfacao` (
  `cdnSatisfacao` int(10) UNSIGNED NOT NULL,
  `cdnSms` int(10) UNSIGNED DEFAULT NULL,
  `datSatisfacao` datetime NOT NULL,
  `cdnConsulta` int(10) UNSIGNED NOT NULL,
  `numTelefone` varchar(20) NOT NULL,
  `codErro` varchar(10) DEFAULT NULL,
  `cdnPaciente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sms_satisfacao`
--

INSERT INTO `sms_satisfacao` (`cdnSatisfacao`, `cdnSms`, `datSatisfacao`, `cdnConsulta`, `numTelefone`, `codErro`, `cdnPaciente`) VALUES
(1, 2, '2016-04-26 11:02:35', 4, '555499031426', NULL, 1),
(2, 4, '2016-04-27 10:44:00', 11, '555499031426', NULL, 1),
(3, NULL, '2016-05-10 09:30:00', 15, '555499031426', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabelapreco`
--

CREATE TABLE `tabelapreco` (
  `cdnTabelaPreco` int(10) UNSIGNED NOT NULL,
  `nomTabelaPreco` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabelapreco`
--

INSERT INTO `tabelapreco` (`cdnTabelaPreco`, `nomTabelaPreco`) VALUES
(1, 'Tabela A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabelapreco_procedimento`
--

CREATE TABLE `tabelapreco_procedimento` (
  `cdnTabelaPreco` int(10) UNSIGNED NOT NULL,
  `cdnProcedimento` int(10) UNSIGNED NOT NULL,
  `valPreco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabelapreco_procedimento`
--

INSERT INTO `tabelapreco_procedimento` (`cdnTabelaPreco`, `cdnProcedimento`, `valPreco`) VALUES
(1, 21, '200.00'),
(1, 22, '250.01'),
(1, 23, '300.00'),
(1, 24, '400.00'),
(1, 25, '450.00'),
(1, 26, '500.00'),
(1, 27, '350.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_master`
--

CREATE TABLE `usuario_master` (
  `cdnUsuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario_master`
--

INSERT INTO `usuario_master` (`cdnUsuario`) VALUES
(1),
(35),
(37),
(41);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda_evento`
--
ALTER TABLE `agenda_evento`
  ADD PRIMARY KEY (`cdnEvento`),
  ADD KEY `evento_cliente` (`cdnUsuario`);

--
-- Indexes for table `agenda_tipoevento`
--
ALTER TABLE `agenda_tipoevento`
  ADD PRIMARY KEY (`cdnTipoEvento`);

--
-- Indexes for table `areaatuacao`
--
ALTER TABLE `areaatuacao`
  ADD PRIMARY KEY (`cdnAreaAtuacao`);

--
-- Indexes for table `clinicaradiologica`
--
ALTER TABLE `clinicaradiologica`
  ADD PRIMARY KEY (`cdnClinicaRadiologica`);

--
-- Indexes for table `colaborador`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`cdnUsuario`),
  ADD UNIQUE KEY `codCpf` (`codCpf`);

--
-- Indexes for table `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`cdnConsulta`);

--
-- Indexes for table `consultorio`
--
ALTER TABLE `consultorio`
  ADD PRIMARY KEY (`cdnConsultorio`);

--
-- Indexes for table `cronometro`
--
ALTER TABLE `cronometro`
  ADD PRIMARY KEY (`cdnCronometro`);

--
-- Indexes for table `dentista`
--
ALTER TABLE `dentista`
  ADD PRIMARY KEY (`cdnUsuario`),
  ADD UNIQUE KEY `codCpf` (`codCpf`);

--
-- Indexes for table `dentista_aberto`
--
ALTER TABLE `dentista_aberto`
  ADD PRIMARY KEY (`cdnAberto`);

--
-- Indexes for table `dentista_areaatuacao`
--
ALTER TABLE `dentista_areaatuacao`
  ADD PRIMARY KEY (`cdnDentista`,`cdnAreaAtuacao`);

--
-- Indexes for table `dentista_dias`
--
ALTER TABLE `dentista_dias`
  ADD PRIMARY KEY (`cdnDentista`),
  ADD KEY `cdnDentista` (`cdnDentista`);

--
-- Indexes for table `dentista_fechado`
--
ALTER TABLE `dentista_fechado`
  ADD PRIMARY KEY (`cdnFechado`);

--
-- Indexes for table `dentista_formapagamento`
--
ALTER TABLE `dentista_formapagamento`
  ADD PRIMARY KEY (`cdnDentista`);

--
-- Indexes for table `dentista_intervalo`
--
ALTER TABLE `dentista_intervalo`
  ADD PRIMARY KEY (`cdnIntervalo`);

--
-- Indexes for table `dentista_satisfacao`
--
ALTER TABLE `dentista_satisfacao`
  ADD PRIMARY KEY (`cdnSatisfacao`,`cdnDentista`) USING BTREE;

--
-- Indexes for table `dependente`
--
ALTER TABLE `dependente`
  ADD PRIMARY KEY (`cdnDependente`),
  ADD UNIQUE KEY `cdnPaciente` (`cdnPaciente`,`cdnResponsavel`);

--
-- Indexes for table `desmarque`
--
ALTER TABLE `desmarque`
  ADD PRIMARY KEY (`cdnConsulta`);

--
-- Indexes for table `erro`
--
ALTER TABLE `erro`
  ADD PRIMARY KEY (`cdnErro`);

--
-- Indexes for table `falta`
--
ALTER TABLE `falta`
  ADD PRIMARY KEY (`cdnConsulta`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`cdnFornecedor`);

--
-- Indexes for table `frase`
--
ALTER TABLE `frase`
  ADD PRIMARY KEY (`cdnFrase`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`cdnLog`);

--
-- Indexes for table `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`cdnOrcamento`);

--
-- Indexes for table `orcamento_aprovacao`
--
ALTER TABLE `orcamento_aprovacao`
  ADD PRIMARY KEY (`cdnOrcamento`,`cdnDentista`);

--
-- Indexes for table `orcamento_formapagamento`
--
ALTER TABLE `orcamento_formapagamento`
  ADD PRIMARY KEY (`cdnOrcamento`);

--
-- Indexes for table `orcamento_parcela`
--
ALTER TABLE `orcamento_parcela`
  ADD PRIMARY KEY (`cdnOrcamento`,`numParcela`);

--
-- Indexes for table `orcamento_procedimento`
--
ALTER TABLE `orcamento_procedimento`
  ADD PRIMARY KEY (`cdnOrcamento`,`cdnAreaAtuacao`,`cdnProcedimento`,`cdnDentista`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`cdnPaciente`);

--
-- Indexes for table `paciente_responsavel`
--
ALTER TABLE `paciente_responsavel`
  ADD PRIMARY KEY (`cdnPaciente`);

--
-- Indexes for table `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`cdnPagamento`);

--
-- Indexes for table `parceria`
--
ALTER TABLE `parceria`
  ADD PRIMARY KEY (`cdnParceria`);

--
-- Indexes for table `parceria_preco`
--
ALTER TABLE `parceria_preco`
  ADD PRIMARY KEY (`cdnPreco`);

--
-- Indexes for table `parceria_tipo`
--
ALTER TABLE `parceria_tipo`
  ADD PRIMARY KEY (`cdnParceriaTipo`);

--
-- Indexes for table `pergunta`
--
ALTER TABLE `pergunta`
  ADD PRIMARY KEY (`cdnPergunta`);

--
-- Indexes for table `pergunta_opcao`
--
ALTER TABLE `pergunta_opcao`
  ADD PRIMARY KEY (`cdnOpcao`);

--
-- Indexes for table `procedimento`
--
ALTER TABLE `procedimento`
  ADD PRIMARY KEY (`cdnProcedimento`);

--
-- Indexes for table `prontuario_anexo`
--
ALTER TABLE `prontuario_anexo`
  ADD PRIMARY KEY (`cdnProntuarioAnexo`);

--
-- Indexes for table `prontuario_historico`
--
ALTER TABLE `prontuario_historico`
  ADD PRIMARY KEY (`cdnProntuarioHistorico`);

--
-- Indexes for table `prontuario_tratamento`
--
ALTER TABLE `prontuario_tratamento`
  ADD PRIMARY KEY (`cdnProntuarioTratamento`);

--
-- Indexes for table `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`cdnResposta`);

--
-- Indexes for table `retorno`
--
ALTER TABLE `retorno`
  ADD PRIMARY KEY (`cdnConsultaRetorno`,`cdnConsultaOriginal`);

--
-- Indexes for table `schema_campo`
--
ALTER TABLE `schema_campo`
  ADD PRIMARY KEY (`cdnCampo`);

--
-- Indexes for table `secao`
--
ALTER TABLE `secao`
  ADD PRIMARY KEY (`cdnSecao`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`cdnSms`);

--
-- Indexes for table `sms_aviso_consulta`
--
ALTER TABLE `sms_aviso_consulta`
  ADD PRIMARY KEY (`cdnConsulta`) USING BTREE;

--
-- Indexes for table `sms_aviso_consulta_resposta`
--
ALTER TABLE `sms_aviso_consulta_resposta`
  ADD PRIMARY KEY (`cdnResposta`),
  ADD UNIQUE KEY `cdnConsulta` (`cdnConsulta`),
  ADD UNIQUE KEY `cdnConsulta_2` (`cdnConsulta`),
  ADD UNIQUE KEY `cdnConsulta_3` (`cdnConsulta`),
  ADD UNIQUE KEY `cdnConsulta_4` (`cdnConsulta`);

--
-- Indexes for table `sms_contagem_paciente`
--
ALTER TABLE `sms_contagem_paciente`
  ADD PRIMARY KEY (`cdnPaciente`);

--
-- Indexes for table `sms_satisfacao`
--
ALTER TABLE `sms_satisfacao`
  ADD PRIMARY KEY (`cdnSatisfacao`),
  ADD UNIQUE KEY `cdnConsulta` (`cdnConsulta`),
  ADD UNIQUE KEY `cdnConsulta_2` (`cdnConsulta`),
  ADD UNIQUE KEY `cdnConsulta_3` (`cdnConsulta`),
  ADD UNIQUE KEY `cdnConsulta_4` (`cdnConsulta`),
  ADD UNIQUE KEY `cdnConsulta_5` (`cdnConsulta`);

--
-- Indexes for table `tabelapreco`
--
ALTER TABLE `tabelapreco`
  ADD PRIMARY KEY (`cdnTabelaPreco`);

--
-- Indexes for table `tabelapreco_procedimento`
--
ALTER TABLE `tabelapreco_procedimento`
  ADD PRIMARY KEY (`cdnTabelaPreco`,`cdnProcedimento`);

--
-- Indexes for table `usuario_master`
--
ALTER TABLE `usuario_master`
  ADD PRIMARY KEY (`cdnUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda_evento`
--
ALTER TABLE `agenda_evento`
  MODIFY `cdnEvento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agenda_tipoevento`
--
ALTER TABLE `agenda_tipoevento`
  MODIFY `cdnTipoEvento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `areaatuacao`
--
ALTER TABLE `areaatuacao`
  MODIFY `cdnAreaAtuacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `clinicaradiologica`
--
ALTER TABLE `clinicaradiologica`
  MODIFY `cdnClinicaRadiologica` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consulta`
--
ALTER TABLE `consulta`
  MODIFY `cdnConsulta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `consultorio`
--
ALTER TABLE `consultorio`
  MODIFY `cdnConsultorio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cronometro`
--
ALTER TABLE `cronometro`
  MODIFY `cdnCronometro` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dentista_aberto`
--
ALTER TABLE `dentista_aberto`
  MODIFY `cdnAberto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dentista_fechado`
--
ALTER TABLE `dentista_fechado`
  MODIFY `cdnFechado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dentista_intervalo`
--
ALTER TABLE `dentista_intervalo`
  MODIFY `cdnIntervalo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dentista_satisfacao`
--
ALTER TABLE `dentista_satisfacao`
  MODIFY `cdnSatisfacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dependente`
--
ALTER TABLE `dependente`
  MODIFY `cdnDependente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `erro`
--
ALTER TABLE `erro`
  MODIFY `cdnErro` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `cdnFornecedor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `frase`
--
ALTER TABLE `frase`
  MODIFY `cdnFrase` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `cdnLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;
--
-- AUTO_INCREMENT for table `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `cdnOrcamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `cdnPaciente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `paciente_responsavel`
--
ALTER TABLE `paciente_responsavel`
  MODIFY `cdnPaciente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `cdnPagamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parceria`
--
ALTER TABLE `parceria`
  MODIFY `cdnParceria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `parceria_preco`
--
ALTER TABLE `parceria_preco`
  MODIFY `cdnPreco` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;
--
-- AUTO_INCREMENT for table `parceria_tipo`
--
ALTER TABLE `parceria_tipo`
  MODIFY `cdnParceriaTipo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pergunta`
--
ALTER TABLE `pergunta`
  MODIFY `cdnPergunta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `pergunta_opcao`
--
ALTER TABLE `pergunta_opcao`
  MODIFY `cdnOpcao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `procedimento`
--
ALTER TABLE `procedimento`
  MODIFY `cdnProcedimento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `prontuario_anexo`
--
ALTER TABLE `prontuario_anexo`
  MODIFY `cdnProntuarioAnexo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prontuario_historico`
--
ALTER TABLE `prontuario_historico`
  MODIFY `cdnProntuarioHistorico` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prontuario_tratamento`
--
ALTER TABLE `prontuario_tratamento`
  MODIFY `cdnProntuarioTratamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resposta`
--
ALTER TABLE `resposta`
  MODIFY `cdnResposta` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schema_campo`
--
ALTER TABLE `schema_campo`
  MODIFY `cdnCampo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `secao`
--
ALTER TABLE `secao`
  MODIFY `cdnSecao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `cdnSms` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sms_aviso_consulta_resposta`
--
ALTER TABLE `sms_aviso_consulta_resposta`
  MODIFY `cdnResposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sms_satisfacao`
--
ALTER TABLE `sms_satisfacao`
  MODIFY `cdnSatisfacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tabelapreco`
--
ALTER TABLE `tabelapreco`
  MODIFY `cdnTabelaPreco` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;