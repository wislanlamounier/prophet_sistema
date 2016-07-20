-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: prophet_final1
-- ------------------------------------------------------
-- Server version	10.1.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agenda_evento`
--

DROP TABLE IF EXISTS `agenda_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda_evento` (
  `cdnEvento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnTipoEvento` int(11) NOT NULL,
  `cdnUsuario` int(10) unsigned DEFAULT NULL,
  `desEvento` text,
  `datInicio` datetime NOT NULL,
  `datFim` datetime NOT NULL,
  `indAllDay` tinyint(1) DEFAULT NULL,
  `indAviso` tinyint(1) DEFAULT '0',
  `numDiasAviso` int(11) DEFAULT '0',
  PRIMARY KEY (`cdnEvento`),
  KEY `evento_cliente` (`cdnUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_evento`
--

LOCK TABLES `agenda_evento` WRITE;
/*!40000 ALTER TABLE `agenda_evento` DISABLE KEYS */;
INSERT INTO `agenda_evento` VALUES (1,1,60,'','2016-04-20 15:00:00','2016-04-21 18:00:00',0,1,1);
/*!40000 ALTER TABLE `agenda_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda_tipoevento`
--

DROP TABLE IF EXISTS `agenda_tipoevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda_tipoevento` (
  `cdnTipoEvento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnUsuario` int(10) unsigned NOT NULL,
  `codCor` varchar(6) NOT NULL,
  `nomTipoEvento` text NOT NULL,
  `indDesvinculado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cdnTipoEvento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_tipoevento`
--

LOCK TABLES `agenda_tipoevento` WRITE;
/*!40000 ALTER TABLE `agenda_tipoevento` DISABLE KEYS */;
INSERT INTO `agenda_tipoevento` VALUES (1,60,'red','Reunião',0);
/*!40000 ALTER TABLE `agenda_tipoevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anamnese_campo`
--

DROP TABLE IF EXISTS `anamnese_campo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anamnese_campo` (
  `cdnCampo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anamnese_campo`
--

LOCK TABLES `anamnese_campo` WRITE;
/*!40000 ALTER TABLE `anamnese_campo` DISABLE KEYS */;
/*!40000 ALTER TABLE `anamnese_campo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areaatuacao`
--

DROP TABLE IF EXISTS `areaatuacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areaatuacao` (
  `cdnAreaAtuacao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomAreaAtuacao` text NOT NULL,
  `desAreaAtuacao` text,
  `indDesvinculada` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cdnAreaAtuacao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areaatuacao`
--

LOCK TABLES `areaatuacao` WRITE;
/*!40000 ALTER TABLE `areaatuacao` DISABLE KEYS */;
INSERT INTO `areaatuacao` VALUES (1,'Cirurgia Buco-maxilo','',0),(2,'adsf','sadf',1);
/*!40000 ALTER TABLE `areaatuacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinicaradiologica`
--

DROP TABLE IF EXISTS `clinicaradiologica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clinicaradiologica` (
  `cdnClinicaRadiologica` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomClinicaRadiologica` varchar(300) NOT NULL,
  `numWhatsapp` varchar(20) DEFAULT NULL,
  `numTelefone1` varchar(20) DEFAULT NULL,
  `numTelefone2` varchar(20) DEFAULT NULL,
  `strEndereco` varchar(300) DEFAULT NULL,
  `nomCidade` varchar(300) DEFAULT NULL,
  `strEmail` varchar(255) DEFAULT NULL,
  `strSite` varchar(300) DEFAULT NULL,
  `desClinicaRadiologica` text,
  PRIMARY KEY (`cdnClinicaRadiologica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinicaradiologica`
--

LOCK TABLES `clinicaradiologica` WRITE;
/*!40000 ALTER TABLE `clinicaradiologica` DISABLE KEYS */;
/*!40000 ALTER TABLE `clinicaradiologica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colaborador`
--

DROP TABLE IF EXISTS `colaborador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colaborador` (
  `cdnUsuario` int(10) unsigned NOT NULL,
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
  `indDesativado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cdnUsuario`),
  UNIQUE KEY `codCpf` (`codCpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaborador`
--

LOCK TABLES `colaborador` WRITE;
/*!40000 ALTER TABLE `colaborador` DISABLE KEYS */;
INSERT INTO `colaborador` VALUES (64,NULL,NULL,NULL,'ac',NULL,NULL,NULL,NULL,NULL,0,0.00,NULL,0);
/*!40000 ALTER TABLE `colaborador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta`
--

DROP TABLE IF EXISTS `consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta` (
  `cdnConsulta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `cdnAreaAtuacao` int(10) unsigned NOT NULL,
  `cdnConsultorio` int(10) unsigned NOT NULL,
  `cdnProcedimento` int(10) unsigned DEFAULT NULL,
  `cdnSecao` int(10) unsigned DEFAULT NULL,
  `cdnDentista` int(11) NOT NULL,
  `datConsulta` date NOT NULL,
  `numHorarios` int(11) DEFAULT NULL,
  `horaConsulta` time NOT NULL,
  `horaFinalizada` time DEFAULT NULL,
  `desConsulta` text,
  `indEncaixe` tinyint(1) NOT NULL DEFAULT '0',
  `indFinalizada` tinyint(1) NOT NULL DEFAULT '0',
  `indBloquear` tinyint(1) NOT NULL DEFAULT '0',
  `cdnOrcamento` int(10) unsigned DEFAULT NULL,
  `numSegAntecedencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`cdnConsulta`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta`
--

LOCK TABLES `consulta` WRITE;
/*!40000 ALTER TABLE `consulta` DISABLE KEYS */;
INSERT INTO `consulta` VALUES (1,1,1,1,NULL,NULL,65,'2016-04-08',1,'10:50:00','11:40:00',NULL,0,0,1,NULL,NULL),(2,1,1,1,NULL,NULL,65,'2016-04-11',2,'07:30:00','09:10:00',NULL,0,0,0,NULL,NULL),(3,1,1,1,NULL,NULL,65,'2016-04-11',1,'09:10:00','10:00:00',NULL,0,0,0,NULL,NULL),(4,1,1,1,NULL,NULL,65,'2016-04-13',NULL,'13:30:00',NULL,NULL,0,0,0,NULL,NULL),(5,1,1,1,NULL,NULL,65,'2016-04-13',2,'07:30:00','09:30:00',NULL,0,0,0,NULL,NULL),(10,1,1,1,NULL,NULL,65,'2016-04-13',1,'07:30:00','08:30:00',NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultorio`
--

DROP TABLE IF EXISTS `consultorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultorio` (
  `cdnConsultorio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numConsultorio` varchar(30) NOT NULL,
  `indDesvinculado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cdnConsultorio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultorio`
--

LOCK TABLES `consultorio` WRITE;
/*!40000 ALTER TABLE `consultorio` DISABLE KEYS */;
INSERT INTO `consultorio` VALUES (1,'01',0),(2,'deletar',1);
/*!40000 ALTER TABLE `consultorio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cronometro`
--

DROP TABLE IF EXISTS `cronometro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cronometro` (
  `cdnCronometro` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnConsulta` int(10) unsigned DEFAULT NULL,
  `datCronometro` date NOT NULL,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `horaChegada` datetime NOT NULL,
  `horaEntrada` datetime DEFAULT NULL,
  `horaSaida` datetime DEFAULT NULL,
  PRIMARY KEY (`cdnCronometro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cronometro`
--

LOCK TABLES `cronometro` WRITE;
/*!40000 ALTER TABLE `cronometro` DISABLE KEYS */;
/*!40000 ALTER TABLE `cronometro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista`
--

DROP TABLE IF EXISTS `dentista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista` (
  `cdnUsuario` int(10) unsigned NOT NULL,
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
  `cdnConsultorio` int(10) unsigned DEFAULT NULL,
  `numNotaSatisfacao` float DEFAULT NULL,
  PRIMARY KEY (`cdnUsuario`),
  UNIQUE KEY `codCpf` (`codCpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista`
--

LOCK TABLES `dentista` WRITE;
/*!40000 ALTER TABLE `dentista` DISABLE KEYS */;
INSERT INTO `dentista` VALUES (65,'',NULL,'','','ac','','','','01:00','','','',NULL,NULL,0,1,NULL);
/*!40000 ALTER TABLE `dentista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_aberto`
--

DROP TABLE IF EXISTS `dentista_aberto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_aberto` (
  `cdnAberto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnDentista` int(10) unsigned NOT NULL,
  `horaManha` varchar(20) DEFAULT NULL,
  `horaTarde` varchar(20) DEFAULT NULL,
  `datAberto` date NOT NULL,
  PRIMARY KEY (`cdnAberto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_aberto`
--

LOCK TABLES `dentista_aberto` WRITE;
/*!40000 ALTER TABLE `dentista_aberto` DISABLE KEYS */;
INSERT INTO `dentista_aberto` VALUES (1,65,'09:00 - 12:00',NULL,'2016-04-16');
/*!40000 ALTER TABLE `dentista_aberto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_areaatuacao`
--

DROP TABLE IF EXISTS `dentista_areaatuacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_areaatuacao` (
  `cdnDentista` int(10) unsigned NOT NULL,
  `cdnAreaAtuacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnDentista`,`cdnAreaAtuacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_areaatuacao`
--

LOCK TABLES `dentista_areaatuacao` WRITE;
/*!40000 ALTER TABLE `dentista_areaatuacao` DISABLE KEYS */;
INSERT INTO `dentista_areaatuacao` VALUES (65,1);
/*!40000 ALTER TABLE `dentista_areaatuacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_dias`
--

DROP TABLE IF EXISTS `dentista_dias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_dias` (
  `cdnDentista` int(10) unsigned NOT NULL,
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
  `horaSabadoTarde` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`cdnDentista`),
  KEY `cdnDentista` (`cdnDentista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_dias`
--

LOCK TABLES `dentista_dias` WRITE;
/*!40000 ALTER TABLE `dentista_dias` DISABLE KEYS */;
INSERT INTO `dentista_dias` VALUES (65,0,1,0,1,0,1,0,NULL,'07:30 - 11:30',NULL,'07:30 - 11:30','__:__ - __:__','07:30 - 11:30',NULL,NULL,'13:30 - 19:00',NULL,'13:30 - 19:00',NULL,'13:30 - 19:00',NULL);
/*!40000 ALTER TABLE `dentista_dias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_fechado`
--

DROP TABLE IF EXISTS `dentista_fechado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_fechado` (
  `cdnFechado` int(11) NOT NULL AUTO_INCREMENT,
  `cdnDentista` int(10) unsigned NOT NULL,
  `datFechado` date NOT NULL,
  `desFechado` text,
  `indAllDay` tinyint(1) NOT NULL DEFAULT '1',
  `horaInicio` time DEFAULT NULL,
  `horaFinal` time DEFAULT NULL,
  PRIMARY KEY (`cdnFechado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_fechado`
--

LOCK TABLES `dentista_fechado` WRITE;
/*!40000 ALTER TABLE `dentista_fechado` DISABLE KEYS */;
/*!40000 ALTER TABLE `dentista_fechado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_formapagamento`
--

DROP TABLE IF EXISTS `dentista_formapagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_formapagamento` (
  `cdnDentista` int(10) unsigned NOT NULL,
  `indTipo` int(11) NOT NULL COMMENT '1 - Por hora, 2 - Por dia, 3 - Por área, 4 - Fechado.',
  `indCompartilhaCompra` tinyint(1) NOT NULL,
  `indDependePaciente` tinyint(1) NOT NULL,
  PRIMARY KEY (`cdnDentista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_formapagamento`
--

LOCK TABLES `dentista_formapagamento` WRITE;
/*!40000 ALTER TABLE `dentista_formapagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `dentista_formapagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_intervalo`
--

DROP TABLE IF EXISTS `dentista_intervalo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_intervalo` (
  `cdnIntervalo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnDentista` int(10) unsigned NOT NULL,
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
  `indSabado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`cdnIntervalo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_intervalo`
--

LOCK TABLES `dentista_intervalo` WRITE;
/*!40000 ALTER TABLE `dentista_intervalo` DISABLE KEYS */;
INSERT INTO `dentista_intervalo` VALUES (1,65,'16:00:00','17:00:00',1,NULL,1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `dentista_intervalo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_satisfacao`
--

DROP TABLE IF EXISTS `dentista_satisfacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_satisfacao` (
  `cdnSatisfacao` int(10) unsigned NOT NULL,
  `cdnDentista` int(10) unsigned NOT NULL,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `datSatisfacao` date NOT NULL,
  `numNota` int(11) NOT NULL,
  PRIMARY KEY (`cdnDentista`,`cdnSatisfacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_satisfacao`
--

LOCK TABLES `dentista_satisfacao` WRITE;
/*!40000 ALTER TABLE `dentista_satisfacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `dentista_satisfacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dependente`
--

DROP TABLE IF EXISTS `dependente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dependente` (
  `cdnDependente` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `cdnResponsavel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnDependente`),
  UNIQUE KEY `cdnPaciente` (`cdnPaciente`,`cdnResponsavel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dependente`
--

LOCK TABLES `dependente` WRITE;
/*!40000 ALTER TABLE `dependente` DISABLE KEYS */;
/*!40000 ALTER TABLE `dependente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `desmarque`
--

DROP TABLE IF EXISTS `desmarque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desmarque` (
  `cdnPaciente` int(10) unsigned NOT NULL,
  `cdnConsulta` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnConsulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desmarque`
--

LOCK TABLES `desmarque` WRITE;
/*!40000 ALTER TABLE `desmarque` DISABLE KEYS */;
INSERT INTO `desmarque` VALUES (1,4),(1,5);
/*!40000 ALTER TABLE `desmarque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `erro`
--

DROP TABLE IF EXISTS `erro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `erro` (
  `cdnErro` int(11) NOT NULL AUTO_INCREMENT,
  `strErro` text,
  `nomArquivo` text,
  `numLinha` text,
  `datErro` text,
  PRIMARY KEY (`cdnErro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `erro`
--

LOCK TABLES `erro` WRITE;
/*!40000 ALTER TABLE `erro` DISABLE KEYS */;
/*!40000 ALTER TABLE `erro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `falta`
--

DROP TABLE IF EXISTS `falta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `falta` (
  `cdnPaciente` int(10) unsigned NOT NULL,
  `cdnConsulta` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnConsulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `falta`
--

LOCK TABLES `falta` WRITE;
/*!40000 ALTER TABLE `falta` DISABLE KEYS */;
/*!40000 ALTER TABLE `falta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fornecedor` (
  `cdnFornecedor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomFornecedor` varchar(300) NOT NULL,
  `numTelefone1` varchar(20) DEFAULT NULL,
  `numTelefone2` varchar(20) DEFAULT NULL,
  `numWhatsapp` varchar(20) DEFAULT NULL,
  `nomFacebook` varchar(300) DEFAULT NULL,
  `strEndereco` varchar(300) DEFAULT NULL,
  `nomRepresentante` varchar(300) DEFAULT NULL,
  `numRepresentanteTelefone` varchar(20) DEFAULT NULL,
  `strRepresentanteEmail` varchar(255) DEFAULT NULL,
  `desFornecedor` text,
  PRIMARY KEY (`cdnFornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frase`
--

DROP TABLE IF EXISTS `frase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `frase` (
  `cdnFrase` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnUsuario` int(10) unsigned NOT NULL,
  `strFrase` text NOT NULL,
  `indAtiva` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cdnFrase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frase`
--

LOCK TABLES `frase` WRITE;
/*!40000 ALTER TABLE `frase` DISABLE KEYS */;
/*!40000 ALTER TABLE `frase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `cdnLog` int(11) NOT NULL AUTO_INCREMENT,
  `strInformacao` text,
  `datLog` datetime DEFAULT NULL,
  `strTipo` text,
  `strOperacao` text,
  `cdnUsuario` text,
  `nomModulo` text,
  PRIMARY KEY (`cdnLog`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,'3','2016-04-08 14:47:03','SUCESSO','ATUALIZACAO','60','CLINICA'),(2,'master@final1.com','2016-04-08 15:18:34','SUCESSO','CADASTRO','60','USUARIO'),(3,'61','2016-04-08 15:19:39','SUCESSO','ATUALIZACAO','60','USUARIO'),(4,'master@final1.com.br','2016-04-08 15:22:29','SUCESSO','CADASTRO','60','USUARIO'),(5,'62','2016-04-08 15:22:40','SUCESSO','ATUALIZACAO','60','USUARIO'),(6,'62','2016-04-08 15:22:45','SUCESSO','ATUALIZACAO','60','USUARIO'),(7,'colaborador1@final1.com.br','2016-04-08 15:26:39','SUCESSO','CADASTRO','60','COLABORADOR'),(8,'colaborador1@final1.com.br','2016-04-08 15:29:29','SUCESSO','CADASTRO','60','COLABORADOR'),(9,'64','2016-04-08 15:34:21','SUCESSO','ATUALIZACAO','60','COLABORADOR'),(10,'64','2016-04-08 15:34:35','SUCESSO','ATUALIZACAO','60','COLABORADOR'),(11,'dentista1@final1.com.br','2016-04-08 15:36:19','SUCESSO','CADASTRO','60','DENTISTA'),(12,'65','2016-04-08 15:37:09','SUCESSO','ATUALIZACAO','60','DENTISTA'),(13,'65','2016-04-08 15:37:31','SUCESSO','ATUALIZACAO','60','DENTISTA'),(14,'65','2016-04-08 15:39:09','SUCESSO','ATUALIZACAO','60','DENTISTA'),(15,'65','2016-04-08 15:39:21','SUCESSO','ATUALIZACAO','60','DENTISTA'),(16,'65','2016-04-08 15:39:28','SUCESSO','ATUALIZACAO','60','DENTISTA'),(17,'65','2016-04-08 15:39:35','SUCESSO','ATUALIZACAO','60','DENTISTA'),(18,'65','2016-04-08 15:39:41','SUCESSO','ATUALIZACAO','60','DENTISTA'),(19,'65','2016-04-08 15:39:53','SUCESSO','ATUALIZACAO','60','DENTISTA'),(20,'65','2016-04-08 15:39:57','SUCESSO','ATUALIZACAO','60','DENTISTA'),(21,'65','2016-04-08 15:40:01','SUCESSO','ATUALIZACAO','60','DENTISTA'),(22,'65','2016-04-08 15:40:12','SUCESSO','ATUALIZACAO','60','DENTISTA'),(23,'1','2016-04-08 15:40:27','SUCESSO','CADASTRO','60','INTERVALO'),(24,'sadafds@fdjskfds.com','2016-04-08 15:41:23','ERRO','CADASTRO','60','DENTISTA'),(25,'sadafds@fdjskfds.com','2016-04-08 15:43:29','SUCESSO','CADASTRO','60','DENTISTA'),(26,'65','2016-04-08 15:45:34','SUCESSO','CADASTRO','60','DENTISTA_ABERTO'),(27,'65','2016-04-08 15:46:06','SUCESSO','CADASTRO','60','DENTISTA_FECHADO'),(28,'65','2016-04-08 15:47:21','SUCESSO','CADASTRO','60','DENTISTA_FECHADO'),(29,'65','2016-04-08 15:49:06','SUCESSO','CADASTRO','60','DENTISTA_FECHADO'),(30,'65','2016-04-08 15:51:12','SUCESSO','CADASTRO','60','DENTISTA_FECHADO'),(31,'65','2016-04-08 15:52:05','SUCESSO','CADASTRO','60','DENTISTA_FECHADO'),(32,'65','2016-04-08 15:55:23','SUCESSO','CADASTRO','60','DENTISTA_FECHADO'),(33,'1','2016-04-08 16:00:10','SUCESSO','CADASTRO','60','CONSULTORIO'),(34,'2','2016-04-08 16:00:17','SUCESSO','CADASTRO','60','CONSULTORIO'),(35,'65','2016-04-08 16:00:55','SUCESSO','ATUALIZACAO','60','DENTISTA'),(36,'2','2016-04-08 16:04:10','SUCESSO','ATUALIZACAO','60','CONSULTORIO'),(37,'1','2016-04-08 16:07:11','SUCESSO','CADASTRO','60','AREAATUACAO'),(38,'1','2016-04-08 16:07:21','SUCESSO','CADASTRO','60','PROCEDIMENTO'),(39,'2','2016-04-08 16:07:30','SUCESSO','CADASTRO','60','PROCEDIMENTO'),(40,'3','2016-04-08 16:07:39','SUCESSO','CADASTRO','60','PROCEDIMENTO'),(41,'4','2016-04-08 16:07:50','SUCESSO','CADASTRO','60','PROCEDIMENTO'),(42,'5','2016-04-08 16:08:01','SUCESSO','CADASTRO','60','PROCEDIMENTO'),(43,'1','2016-04-08 16:08:29','SUCESSO','ATUALIZACAO','60','AREAATUACAO'),(44,'1','2016-04-08 16:08:33','SUCESSO','ATUALIZACAO','60','AREAATUACAO'),(45,'1','2016-04-08 16:08:39','SUCESSO','ATUALIZACAO','60','AREAATUACAO'),(46,'1','2016-04-08 16:09:49','SUCESSO','ATUALIZACAO','60','AREAATUACAO'),(47,'1','2016-04-08 16:09:53','SUCESSO','ATUALIZACAO','60','AREAATUACAO'),(48,'2','2016-04-08 16:10:01','SUCESSO','CADASTRO','60','AREAATUACAO'),(49,'6','2016-04-08 16:10:16','SUCESSO','CADASTRO','60','PROCEDIMENTO'),(50,'6','2016-04-08 16:10:19','SUCESSO','ATUALIZACAO','60','PROCEDIMENTO'),(51,'1','2016-04-08 16:10:31','SUCESSO','CADASTRO','60','SECAO'),(52,'1','2016-04-08 16:10:38','SUCESSO','ATUALIZACAO','60','SECAO'),(53,'1','2016-04-08 16:10:58','SUCESSO','CADASTRO','60','CLINICARADIOLOGICA'),(54,'1','2016-04-08 16:11:02','SUCESSO','ATUALIZACAO','60','CLINICARADIOLOGICA'),(55,'1','2016-04-08 16:11:12','SUCESSO','CADASTRO','60','FORNECEDOR'),(56,'1','2016-04-08 16:11:16','SUCESSO','ATUALIZACAO','60','FORNECEDOR'),(57,'1','2016-04-08 16:13:48','SUCESSO','CADASTRO','60','PACIENTE'),(58,'1','2016-04-08 16:14:07','SUCESSO','ATUALIZACAO','60','PACIENTE'),(59,'2','2016-04-08 16:14:15','SUCESSO','CADASTRO','60','PACIENTE'),(60,'1','2016-04-08 16:15:27','SUCESSO','CADASTRO','60','PARCERIA'),(61,'1','2016-04-08 16:15:38','SUCESSO','ATUALIZACAO','60','PARCERIA'),(62,'1','2016-04-08 16:15:41','SUCESSO','ATUALIZACAO','60','PARCERIA'),(63,'2','2016-04-08 16:15:45','SUCESSO','CADASTRO','60','PARCERIA'),(64,'2','2016-04-08 16:15:50','SUCESSO','DELETAR','60','PARCERIA'),(65,'65','2016-04-08 16:16:22','SUCESSO','ATUALIZACAO','60','DENTISTA'),(66,'1','2016-04-08 16:17:51','SUCESSO','CADASTRO','60','CONSULTA'),(67,'1','2016-04-08 16:18:40','SUCESSO','REMARCAR','60','CONSULTA'),(68,'1','2016-04-08 16:18:57','SUCESSO','CADASTRO','60','DESMARQUE'),(69,'1','2016-04-08 16:18:59','SUCESSO','DESFAZER','60','DESMARQUE'),(70,'1','2016-04-08 16:19:48','SUCESSO','DESFAZER','60','DESMARQUE'),(71,'1','2016-04-08 16:20:03','SUCESSO','CADASTRO','60','FALTA'),(72,'1','2016-04-08 16:20:21','SUCESSO','CADASTRO','60','FALTA'),(73,'1','2016-04-08 16:29:54','SUCESSO','DISPONIBILIDADE','65','PRONTUARIO'),(74,'0','2016-04-08 16:29:56','SUCESSO','DISPONIBILIDADE','65','PRONTUARIO'),(75,'1','2016-04-08 16:30:02','SUCESSO','DISPONIBILIDADE','65','PRONTUARIO'),(76,'Adalberto Barros Serra','2016-04-08 16:31:56','SUCESSO','CONSULTAR','65','PRONTUARIO'),(77,'2','2016-04-08 16:32:30','SUCESSO','CADASTRO','65','CONSULTA'),(78,'3','2016-04-08 16:32:56','SUCESSO','CADASTRO','65','CONSULTA'),(79,'SISTEMA','2016-04-11 23:22:49','ERRO','CONFIGURACOES','60','SMS'),(80,'SISTEMA','2016-04-11 23:22:54','ERRO','CONFIGURACOES','60','SMS'),(81,'SISTEMA','2016-04-11 23:23:30','ERRO','CONFIGURACOES','60','SMS'),(82,'SISTEMA','2016-04-11 23:30:40','SUCESSO','CONFIGURACOES','60','SMS'),(83,'SISTEMA','2016-04-11 23:30:45','SUCESSO','CONFIGURACOES','60','SMS'),(84,'SISTEMA','2016-04-11 23:30:49','SUCESSO','CONFIGURACOES','60','SMS'),(85,'SISTEMA','2016-04-11 23:30:53','ERRO','CONFIGURACOES','60','SMS'),(86,'SISTEMA','2016-04-11 23:30:59','SUCESSO','CONFIGURACOES','60','SMS'),(87,'SISTEMA','2016-04-11 23:31:05','SUCESSO','CONFIGURACOES','60','SMS'),(88,'SISTEMA','2016-04-11 23:32:12','ERRO','CONFIGURACOES','60','SMS'),(89,'SISTEMA','2016-04-11 23:32:24','ERRO','CONFIGURACOES','60','SMS'),(90,'SISTEMA','2016-04-11 23:33:42','SUCESSO','CONFIGURACOES','60','SMS'),(91,'SISTEMA','2016-04-11 23:33:46','ERRO','CONFIGURACOES','60','SMS'),(92,'SISTEMA','2016-04-11 23:35:33','SUCESSO','CONFIGURACOES','60','SMS'),(93,'SISTEMA','2016-04-12 08:55:49','SUCESSO','CONFIGURACOES','60','SMS'),(94,'SISTEMA','2016-04-12 08:55:54','SUCESSO','CONFIGURACOES','60','SMS'),(95,'SISTEMA','2016-04-12 08:55:58','SUCESSO','CONFIGURACOES','60','SMS'),(96,'65','2016-04-12 23:38:31','SUCESSO','CADASTRO','60','DENTISTA_FECHADO'),(97,'65','2016-04-12 23:40:39','SUCESSO','DELETAR','60','DENTISTA_FECHADO'),(98,'Adalberto Barros Serra','2016-04-12 23:41:56','SUCESSO','CONSULTAR','60','PRONTUARIO'),(99,'Adalberto Barros Serra','2016-04-12 23:42:13','SUCESSO','CONSULTAR','60','PRONTUARIO'),(100,'Adalberto Barros Serra','2016-04-12 23:42:19','SUCESSO','CONSULTAR','60','PRONTUARIO'),(101,'65','2016-04-13 09:26:56','SUCESSO','ATUALIZACAO','60','DENTISTA'),(102,'65','2016-04-13 09:27:09','SUCESSO','ATUALIZACAO','60','DENTISTA'),(103,'1','2016-04-13 09:37:50','SUCESSO','ATUALIZACAO','60','PACIENTE'),(104,'SISTEMA','2016-04-13 09:43:33','SUCESSO','CONFIGURACOES','60','SMS'),(105,'SISTEMA','2016-04-13 09:43:36','SUCESSO','CONFIGURACOES','60','SMS'),(106,'4','2016-04-13 09:44:36','SUCESSO','CADASTRO','60','CONSULTA'),(107,'4','2016-04-13 09:46:12','SUCESSO','CADASTRO','60','DESMARQUE'),(108,'SISTEMA','2016-04-13 09:46:30','SUCESSO','CONFIGURACOES','60','SMS'),(109,'5','2016-04-13 09:47:15','SUCESSO','CADASTRO','60','CONSULTA'),(110,'5','2016-04-13 09:48:39','SUCESSO','CADASTRO','60','DESMARQUE'),(111,'10','2016-04-13 09:51:44','SUCESSO','CADASTRO','60','CONSULTA'),(112,'65','2016-04-15 21:07:16','SUCESSO','ATUALIZACAO','60','DENTISTA'),(113,'SISTEMA','2016-04-15 21:44:07','SUCESSO','CONFIGURACOES','60','SMS'),(114,'1','2016-04-20 10:20:35','SUCESSO','CADASTRO','60','AGENDA_TIPOEVENTO'),(115,'SISTEMA','2016-04-20 10:20:50','SUCESSO','CADASTRO','60','EVENTO - 1'),(116,'SISTEMA','2016-04-20 10:28:34','SUCESSO','ATUALIZACAO','60','EVENTO - 1');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orcamento`
--

DROP TABLE IF EXISTS `orcamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orcamento` (
  `cdnOrcamento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `cdnTitular` int(10) unsigned DEFAULT NULL,
  `datOrcamento` date DEFAULT NULL,
  `datValidade` date DEFAULT NULL,
  `valOrcamento` decimal(10,2) NOT NULL,
  `valEntrada` decimal(10,2) DEFAULT NULL,
  `indAprovado` tinyint(1) NOT NULL DEFAULT '0',
  `indFinalizado` tinyint(1) NOT NULL DEFAULT '0',
  `desOrcamento` text,
  `indTipoDesconto` varchar(3) DEFAULT NULL,
  `valDesconto` varchar(15) DEFAULT NULL,
  `valFinal` decimal(10,2) NOT NULL,
  `cdnUsuarioAprovou` int(10) unsigned DEFAULT NULL,
  `datAprovacao` datetime DEFAULT NULL,
  PRIMARY KEY (`cdnOrcamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orcamento`
--

LOCK TABLES `orcamento` WRITE;
/*!40000 ALTER TABLE `orcamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orcamento_aprovacao`
--

DROP TABLE IF EXISTS `orcamento_aprovacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orcamento_aprovacao` (
  `cdnOrcamento` int(11) NOT NULL,
  `cdnDentista` int(11) NOT NULL,
  `indAprovado` int(11) NOT NULL,
  PRIMARY KEY (`cdnOrcamento`,`cdnDentista`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orcamento_aprovacao`
--

LOCK TABLES `orcamento_aprovacao` WRITE;
/*!40000 ALTER TABLE `orcamento_aprovacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamento_aprovacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orcamento_formapagamento`
--

DROP TABLE IF EXISTS `orcamento_formapagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orcamento_formapagamento` (
  `cdnOrcamento` int(10) unsigned NOT NULL,
  `indForma` text NOT NULL,
  `indVia` text NOT NULL,
  `numVezes` int(11) DEFAULT NULL,
  `numPorcentagem` float DEFAULT NULL,
  `numDiaVencimento` int(11) DEFAULT NULL,
  `datInicioPagamento` date DEFAULT NULL,
  `datVencimento` date DEFAULT NULL,
  `datVencimentoCartao` varchar(50) DEFAULT NULL,
  `cdnTabelaPreco` varchar(20) DEFAULT NULL,
  `numVezesEscolhido` int(11) DEFAULT NULL,
  `valFinalTaxas` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cdnOrcamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orcamento_formapagamento`
--

LOCK TABLES `orcamento_formapagamento` WRITE;
/*!40000 ALTER TABLE `orcamento_formapagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamento_formapagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orcamento_parcela`
--

DROP TABLE IF EXISTS `orcamento_parcela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orcamento_parcela` (
  `cdnOrcamento` int(10) unsigned NOT NULL,
  `numParcela` int(11) NOT NULL,
  `valParcela` decimal(10,2) NOT NULL,
  `datVencimento` date DEFAULT NULL,
  `indPaga` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cdnOrcamento`,`numParcela`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orcamento_parcela`
--

LOCK TABLES `orcamento_parcela` WRITE;
/*!40000 ALTER TABLE `orcamento_parcela` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamento_parcela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orcamento_procedimento`
--

DROP TABLE IF EXISTS `orcamento_procedimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orcamento_procedimento` (
  `cdnOrcamento` int(10) unsigned NOT NULL,
  `cdnAreaAtuacao` int(10) unsigned NOT NULL,
  `cdnProcedimento` int(10) unsigned NOT NULL,
  `cdnDentista` int(10) unsigned NOT NULL,
  `numQuantidade` int(11) NOT NULL,
  `numQuantidadeRealizado` int(11) DEFAULT '0',
  `valUnitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orcamento_procedimento`
--

LOCK TABLES `orcamento_procedimento` WRITE;
/*!40000 ALTER TABLE `orcamento_procedimento` DISABLE KEYS */;
/*!40000 ALTER TABLE `orcamento_procedimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente` (
  `cdnPaciente` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomPaciente` varchar(300) NOT NULL,
  `nomSobrenome` varchar(300) NOT NULL,
  `strEndereco` varchar(400) DEFAULT NULL,
  `numRua` varchar(50) DEFAULT NULL,
  `numCasa` varchar(30) DEFAULT NULL,
  `nomBairro` varchar(200) DEFAULT NULL,
  `nomCidade` varchar(300) DEFAULT NULL,
  `codCep` varchar(15) DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `codCpf` varchar(20) DEFAULT NULL,
  `codRg` varchar(20) DEFAULT NULL,
  `datNascimento` date DEFAULT NULL,
  `strEstadoCivil` varchar(150) DEFAULT NULL,
  `numTelefone1` varchar(100) DEFAULT NULL,
  `numDiasAntecedenciaSms` int(11) DEFAULT '1',
  `indReceberSms` tinyint(1) NOT NULL DEFAULT '1',
  `numTelefone2` varchar(100) DEFAULT NULL,
  `strProfissao` varchar(250) DEFAULT NULL,
  `nomEmpresa` varchar(150) DEFAULT NULL,
  `strContatoEmpresa` varchar(100) DEFAULT NULL,
  `nomPai` varchar(300) DEFAULT NULL,
  `nomMae` varchar(300) DEFAULT NULL,
  `strEmail` varchar(255) DEFAULT NULL,
  `nomFacebook` varchar(300) DEFAULT NULL,
  `numWhatsapp` varchar(100) DEFAULT NULL,
  `desMusicas` text,
  `desFilmes` text,
  `desLeitura` text,
  `indDesvinculado` tinyint(1) NOT NULL DEFAULT '0',
  `numProntuarioAntigo` text,
  `desTelefone` text,
  `cdnParceria` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cdnPaciente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (1,'Adalberto','Barros Serra',NULL,NULL,NULL,NULL,NULL,NULL,'ac',NULL,NULL,NULL,NULL,'99031426',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(2,'Adsf','Adsf',NULL,NULL,NULL,NULL,NULL,NULL,'ac',NULL,NULL,NULL,NULL,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,0);
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente_responsavel`
--

DROP TABLE IF EXISTS `paciente_responsavel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente_responsavel` (
  `cdnPaciente` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnPacienteResponsavel` int(10) unsigned DEFAULT NULL,
  `nomResponsavel` varchar(300) DEFAULT NULL,
  `strEndereco` text,
  `codCep` varchar(20) DEFAULT NULL,
  `nomCidade` varchar(300) DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `numTelefones` varchar(200) DEFAULT NULL,
  `codCpf` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cdnPaciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente_responsavel`
--

LOCK TABLES `paciente_responsavel` WRITE;
/*!40000 ALTER TABLE `paciente_responsavel` DISABLE KEYS */;
/*!40000 ALTER TABLE `paciente_responsavel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parceria`
--

DROP TABLE IF EXISTS `parceria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parceria` (
  `cdnParceria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnIndicacao` int(10) unsigned DEFAULT NULL,
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
  `desParceria` text,
  PRIMARY KEY (`cdnParceria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parceria`
--

LOCK TABLES `parceria` WRITE;
/*!40000 ALTER TABLE `parceria` DISABLE KEYS */;
INSERT INTO `parceria` VALUES (1,NULL,0,'Tacchimed',NULL,NULL,NULL,'ac',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(2,1,1,'asdf',NULL,NULL,NULL,'ac',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL);
/*!40000 ALTER TABLE `parceria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parceria_preco`
--

DROP TABLE IF EXISTS `parceria_preco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parceria_preco` (
  `cdnPreco` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnParceria` int(10) unsigned NOT NULL,
  `cdnProcedimento` int(10) unsigned NOT NULL,
  `valPreco` int(11) NOT NULL,
  PRIMARY KEY (`cdnPreco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parceria_preco`
--

LOCK TABLES `parceria_preco` WRITE;
/*!40000 ALTER TABLE `parceria_preco` DISABLE KEYS */;
/*!40000 ALTER TABLE `parceria_preco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parceria_tipo`
--

DROP TABLE IF EXISTS `parceria_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parceria_tipo` (
  `cdnParceriaTipo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomParceriaTipo` varchar(300) NOT NULL,
  PRIMARY KEY (`cdnParceriaTipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parceria_tipo`
--

LOCK TABLES `parceria_tipo` WRITE;
/*!40000 ALTER TABLE `parceria_tipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `parceria_tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pergunta`
--

DROP TABLE IF EXISTS `pergunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pergunta` (
  `cdnPergunta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `strPergunta` text NOT NULL,
  PRIMARY KEY (`cdnPergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pergunta`
--

LOCK TABLES `pergunta` WRITE;
/*!40000 ALTER TABLE `pergunta` DISABLE KEYS */;
/*!40000 ALTER TABLE `pergunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pergunta_opcao`
--

DROP TABLE IF EXISTS `pergunta_opcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pergunta_opcao` (
  `cdnOpcao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnPergunta` int(10) unsigned NOT NULL,
  `strOpcao` text NOT NULL,
  PRIMARY KEY (`cdnOpcao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pergunta_opcao`
--

LOCK TABLES `pergunta_opcao` WRITE;
/*!40000 ALTER TABLE `pergunta_opcao` DISABLE KEYS */;
/*!40000 ALTER TABLE `pergunta_opcao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procedimento`
--

DROP TABLE IF EXISTS `procedimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procedimento` (
  `cdnProcedimento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnAreaAtuacao` int(10) unsigned NOT NULL,
  `nomProcedimento` varchar(300) NOT NULL,
  `desProcedimento` text,
  `indAviso` tinyint(1) NOT NULL DEFAULT '0',
  `indDesvinculado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cdnProcedimento`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procedimento`
--

LOCK TABLES `procedimento` WRITE;
/*!40000 ALTER TABLE `procedimento` DISABLE KEYS */;
INSERT INTO `procedimento` VALUES (1,1,'Exodontia de Ciso',NULL,0,0),(2,1,'Exodontia Intermediária',NULL,0,0),(3,1,'Exodontia Simples',NULL,0,0),(4,1,'Exodontia Decíduo',NULL,0,0),(5,1,'Exodontia Supranumerário',NULL,0,0),(6,1,'sadfsadfeee',NULL,0,1);
/*!40000 ALTER TABLE `procedimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prontuario_anexo`
--

DROP TABLE IF EXISTS `prontuario_anexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prontuario_anexo` (
  `cdnProntuarioAnexo` int(11) NOT NULL AUTO_INCREMENT,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `strDiretorio` text NOT NULL,
  `desProntuarioAnexo` text,
  `valTamanho` varchar(30) NOT NULL,
  PRIMARY KEY (`cdnProntuarioAnexo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prontuario_anexo`
--

LOCK TABLES `prontuario_anexo` WRITE;
/*!40000 ALTER TABLE `prontuario_anexo` DISABLE KEYS */;
/*!40000 ALTER TABLE `prontuario_anexo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prontuario_historico`
--

DROP TABLE IF EXISTS `prontuario_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prontuario_historico` (
  `cdnProntuarioHistorico` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `datInicio` date NOT NULL,
  `datFim` date NOT NULL,
  PRIMARY KEY (`cdnProntuarioHistorico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prontuario_historico`
--

LOCK TABLES `prontuario_historico` WRITE;
/*!40000 ALTER TABLE `prontuario_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `prontuario_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prontuario_tratamento`
--

DROP TABLE IF EXISTS `prontuario_tratamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prontuario_tratamento` (
  `cdnProntuarioTratamento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datProntuarioTratamento` date DEFAULT NULL,
  `desProntuarioTratamento` text,
  `numDente` varchar(30) DEFAULT NULL,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `cdnDentista` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnProntuarioTratamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prontuario_tratamento`
--

LOCK TABLES `prontuario_tratamento` WRITE;
/*!40000 ALTER TABLE `prontuario_tratamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `prontuario_tratamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resposta`
--

DROP TABLE IF EXISTS `resposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resposta` (
  `cdnResposta` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `cdnPergunta` int(10) unsigned NOT NULL,
  `cdnOpcao` int(10) unsigned DEFAULT NULL,
  `strResposta` text,
  PRIMARY KEY (`cdnResposta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resposta`
--

LOCK TABLES `resposta` WRITE;
/*!40000 ALTER TABLE `resposta` DISABLE KEYS */;
/*!40000 ALTER TABLE `resposta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retorno`
--

DROP TABLE IF EXISTS `retorno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retorno` (
  `cdnConsultaRetorno` int(10) unsigned NOT NULL,
  `cdnConsultaOriginal` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnConsultaRetorno`,`cdnConsultaOriginal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retorno`
--

LOCK TABLES `retorno` WRITE;
/*!40000 ALTER TABLE `retorno` DISABLE KEYS */;
/*!40000 ALTER TABLE `retorno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schema_campo`
--

DROP TABLE IF EXISTS `schema_campo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_campo` (
  `cdnCampo` int(11) NOT NULL AUTO_INCREMENT,
  `cdnPai` int(11) NOT NULL DEFAULT '0',
  `codSequencial` int(11) NOT NULL,
  `nomTabela` varchar(100) NOT NULL,
  `nomCampo` varchar(100) NOT NULL,
  `indTipo` varchar(100) NOT NULL,
  `desLabel` text NOT NULL,
  `indMostrar` tinyint(1) NOT NULL DEFAULT '1',
  `indRequired` tinyint(1) NOT NULL DEFAULT '0',
  `numLimite` int(11) DEFAULT '0',
  `strValidacoes` text,
  PRIMARY KEY (`cdnCampo`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schema_campo`
--

LOCK TABLES `schema_campo` WRITE;
/*!40000 ALTER TABLE `schema_campo` DISABLE KEYS */;
INSERT INTO `schema_campo` VALUES (1,0,2,'paciente','nomPaciente','text','Nome',1,1,300,'vazio'),(2,0,3,'paciente','nomSobrenome','text','Sobrenome',1,1,300,'vazio'),(3,0,4,'paciente','strEndereco','text','Rua/Avenida',1,0,400,NULL),(4,0,7,'paciente','nomBairro','text','Bairro',1,0,200,NULL),(5,0,8,'paciente','nomCidade','text','Cidade',1,0,300,NULL),(6,0,9,'paciente','codCep','cep','CEP',1,0,15,NULL),(7,0,10,'paciente','codUf','select','Estado',1,0,NULL,'uf'),(8,0,12,'paciente','codCpf','cpf','CPF',1,0,0,'cpf'),(9,0,11,'paciente','codRg','text','RG',1,0,20,NULL),(11,0,13,'paciente','datNascimento','date','Data de nascimento',1,0,0,'data'),(16,0,14,'paciente','strEstadoCivil','text','Estado civil',1,0,150,NULL),(18,0,15,'paciente','numTelefone1','text','Telefone 1',1,0,100,NULL),(19,0,16,'paciente','numTelefone2','text','Telefone 2',1,0,100,NULL),(20,0,19,'paciente','strProfissao','text','Profissão',1,0,250,NULL),(21,0,18,'paciente','nomEmpresa','text','Empresa',1,0,150,NULL),(22,0,20,'paciente','strContatoEmpresa','text','Telefone empresa',1,0,100,NULL),(23,0,21,'paciente','nomPai','text','Nome do pai',1,0,300,NULL),(24,0,22,'paciente','nomMae','text','Nome da mãe',1,0,300,NULL),(25,0,23,'paciente','strEmail','email','E-mail',1,0,255,NULL),(26,0,24,'paciente','nomFacebook','text','Facebook',1,0,300,NULL),(27,0,25,'paciente','numWhatsapp','text','Whatsapp',1,0,100,NULL),(28,0,26,'paciente','desMusicas','textarea','Estilo musical',1,0,0,NULL),(29,0,27,'paciente','desFilmes','textarea','Gosto cinematográfico',1,0,0,NULL),(30,0,28,'paciente','desLeitura','textarea','Gosto literário',1,0,0,NULL),(31,0,0,'paciente','cdnPaciente','number','Código Numérico',0,0,0,NULL),(32,0,0,'paciente','indDesvinculado','checkbox','Desvinculado?',0,0,0,NULL),(33,7,1,'paciente','ac','option','Acre',0,0,NULL,''),(34,7,2,'paciente','al','option','Alagoas',0,0,NULL,''),(35,7,3,'paciente','am','option','Amazonas',0,0,NULL,''),(36,7,4,'paciente','ap','option','Amapá',0,0,NULL,''),(37,7,5,'paciente','ba','option','Bahia',0,0,NULL,''),(38,7,6,'paciente','ce','option','Ceará',0,0,NULL,''),(39,7,7,'paciente','df','option','Distrito Federal',0,0,NULL,''),(40,7,8,'paciente','es','option','Espírito Santo',0,0,NULL,''),(41,7,9,'paciente','go','option','Goiás',0,0,NULL,''),(42,7,10,'paciente','ma','option','Maranhão',0,0,NULL,''),(43,7,11,'paciente','mt','option','Mato Grosso',0,0,NULL,''),(44,7,12,'paciente','ms','option','Mato Grosso do Sul',0,0,NULL,''),(45,7,13,'paciente','mg','option','Minas Gerais',0,0,NULL,''),(46,7,14,'paciente','pa','option','Pará',0,0,NULL,''),(47,7,15,'paciente','pb','option','Paraíba',0,0,NULL,''),(48,7,16,'paciente','pr','option','Paraná',0,0,NULL,''),(49,7,17,'paciente','pe','option','Pernambuco',0,0,NULL,''),(50,7,18,'paciente','pi','option','Piauí',0,0,NULL,''),(51,7,19,'paciente','rj','option','Rio de Janeiro',0,0,NULL,''),(52,7,20,'paciente','rn','option','Rio Grande do Norte',0,0,NULL,''),(53,7,22,'paciente','ro','option','Rondônia',0,0,NULL,''),(54,7,21,'paciente','rs','option','Rio Grande do Sul',0,0,NULL,''),(55,7,23,'paciente','rr','option','Roraima',0,0,NULL,''),(56,7,24,'paciente','sc','option','Santa Catarina',0,0,NULL,''),(57,7,26,'paciente','se','option','Sergipe',0,0,NULL,''),(58,7,25,'paciente','sp','option','São Paulo',0,0,NULL,''),(59,7,27,'paciente','to','option','Tocantins',0,0,NULL,''),(60,0,5,'paciente','numCasa','text','Número',1,0,30,NULL),(61,0,6,'paciente','numRua','text','Complemento',1,0,50,NULL),(62,0,29,'paciente','numProntuarioAntigo','text','Prontuário Antigo',1,0,0,NULL),(63,0,17,'paciente','desTelefone','text','Observações Telefones',1,0,0,NULL),(64,0,99,'paciente','cdnParceria','integer','Parceria',0,0,0,NULL);
/*!40000 ALTER TABLE `schema_campo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secao`
--

DROP TABLE IF EXISTS `secao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secao` (
  `cdnSecao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnProcedimento` int(10) unsigned NOT NULL,
  `nomSecao` varchar(300) NOT NULL,
  `desSecao` text,
  `indAviso` tinyint(1) NOT NULL DEFAULT '0',
  `indDesvinculada` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cdnSecao`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secao`
--

LOCK TABLES `secao` WRITE;
/*!40000 ALTER TABLE `secao` DISABLE KEYS */;
INSERT INTO `secao` VALUES (1,1,'asdfeeee',NULL,0,1);
/*!40000 ALTER TABLE `secao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms`
--

DROP TABLE IF EXISTS `sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms` (
  `cdnSms` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datEnvio` datetime NOT NULL,
  `cdnUsuario` int(10) unsigned NOT NULL,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `strTexto` text NOT NULL,
  `numTelefone` varchar(20) NOT NULL,
  `numIdZenvia` varchar(30) NOT NULL,
  PRIMARY KEY (`cdnSms`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms`
--

LOCK TABLES `sms` WRITE;
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_aviso_consulta`
--

DROP TABLE IF EXISTS `sms_aviso_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_aviso_consulta` (
  `cdnConsulta` int(10) unsigned NOT NULL,
  `cdnSms` int(11) DEFAULT NULL,
  `datAviso` datetime NOT NULL,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `indModificou` tinyint(1) NOT NULL DEFAULT '0',
  `numTelefone` varchar(12) NOT NULL,
  `codErro` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cdnConsulta`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_aviso_consulta`
--

LOCK TABLES `sms_aviso_consulta` WRITE;
/*!40000 ALTER TABLE `sms_aviso_consulta` DISABLE KEYS */;
INSERT INTO `sms_aviso_consulta` VALUES (10,1,'2016-04-13 10:22:00',1,0,'555499031426','900');
/*!40000 ALTER TABLE `sms_aviso_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_aviso_consulta_resposta`
--

DROP TABLE IF EXISTS `sms_aviso_consulta_resposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_aviso_consulta_resposta` (
  `cdnResposta` int(11) NOT NULL AUTO_INCREMENT,
  `cdnConsulta` int(10) unsigned NOT NULL,
  `indVisualizado` tinyint(1) NOT NULL DEFAULT '0',
  `datResposta` datetime NOT NULL,
  PRIMARY KEY (`cdnResposta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_aviso_consulta_resposta`
--

LOCK TABLES `sms_aviso_consulta_resposta` WRITE;
/*!40000 ALTER TABLE `sms_aviso_consulta_resposta` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_aviso_consulta_resposta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_satisfacao`
--

DROP TABLE IF EXISTS `sms_satisfacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_satisfacao` (
  `cdnSatisfacao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnSms` int(10) unsigned DEFAULT NULL,
  `datSatisfacao` datetime NOT NULL,
  `cdnConsulta` int(10) unsigned NOT NULL,
  `numTelefone` varchar(20) NOT NULL,
  `codErro` varchar(10) DEFAULT NULL,
  `cdnPaciente` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnSatisfacao`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_satisfacao`
--

LOCK TABLES `sms_satisfacao` WRITE;
/*!40000 ALTER TABLE `sms_satisfacao` DISABLE KEYS */;
INSERT INTO `sms_satisfacao` VALUES (1,NULL,'2016-04-13 08:30:00',10,'555499031426',NULL,1);
/*!40000 ALTER TABLE `sms_satisfacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabelapreco`
--

DROP TABLE IF EXISTS `tabelapreco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabelapreco` (
  `cdnTabelaPreco` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomTabelaPreco` varchar(300) NOT NULL,
  PRIMARY KEY (`cdnTabelaPreco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabelapreco`
--

LOCK TABLES `tabelapreco` WRITE;
/*!40000 ALTER TABLE `tabelapreco` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabelapreco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabelapreco_procedimento`
--

DROP TABLE IF EXISTS `tabelapreco_procedimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabelapreco_procedimento` (
  `cdnTabelaPreco` int(10) unsigned NOT NULL,
  `cdnProcedimento` int(10) unsigned NOT NULL,
  `valPreco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`cdnTabelaPreco`,`cdnProcedimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabelapreco_procedimento`
--

LOCK TABLES `tabelapreco_procedimento` WRITE;
/*!40000 ALTER TABLE `tabelapreco_procedimento` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabelapreco_procedimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_master`
--

DROP TABLE IF EXISTS `usuario_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_master` (
  `cdnUsuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cdnUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_master`
--

LOCK TABLES `usuario_master` WRITE;
/*!40000 ALTER TABLE `usuario_master` DISABLE KEYS */;
INSERT INTO `usuario_master` VALUES (60),(62);
/*!40000 ALTER TABLE `usuario_master` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-20 10:34:50
