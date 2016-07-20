-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: prophet_testes
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_evento`
--

LOCK TABLES `agenda_evento` WRITE;
/*!40000 ALTER TABLE `agenda_evento` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_tipoevento`
--

LOCK TABLES `agenda_tipoevento` WRITE;
/*!40000 ALTER TABLE `agenda_tipoevento` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areaatuacao`
--

LOCK TABLES `areaatuacao` WRITE;
/*!40000 ALTER TABLE `areaatuacao` DISABLE KEYS */;
INSERT INTO `areaatuacao` VALUES (1,'Endodontia',NULL,0),(2,'Endodontia',NULL,1),(3,'Endodontiofhghgf',NULL,1),(4,'Outra área',NULL,0),(5,'Mais uma área de atuação',NULL,0),(6,'Periodontia',NULL,0),(7,'Prótese','atualizar\r\n\r\n\r\n\r\nasdfasfsafd',0);
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
INSERT INTO `colaborador` VALUES (22,'038.420.230-65','fdafsdfsdfsd','fsdfsdfasfsdafsadfsd','mg','32423-423','de53523423r','32esr2334es','1989-08-24','2015-08-20',1,1500.00,'Observações do fulano poderão entrar aqui.\r\n\r\nteste',0);
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
  `datRemarque` date DEFAULT NULL,
  PRIMARY KEY (`cdnConsulta`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta`
--

LOCK TABLES `consulta` WRITE;
/*!40000 ALTER TABLE `consulta` DISABLE KEYS */;
INSERT INTO `consulta` VALUES (3,1,1,2,NULL,NULL,34,'2016-04-11',2,'10:30:00','12:30:00',NULL,0,0,0,NULL,3600,NULL),(4,1,1,2,NULL,NULL,35,'2016-04-11',2,'10:30:00','12:30:00',NULL,0,0,0,NULL,3600,NULL),(11,1,1,2,NULL,NULL,34,'2016-04-27',1,'10:30:00','11:30:00',NULL,0,0,0,NULL,3600,NULL),(12,1,5,3,NULL,NULL,35,'2016-04-28',2,'12:35:00','14:35:00',NULL,1,0,1,NULL,10800,NULL),(13,1,1,2,NULL,NULL,34,'2016-04-28',2,'15:30:00','16:00:00',NULL,0,0,0,NULL,3600,NULL),(14,1,1,2,NULL,NULL,34,'2016-04-28',2,'13:30:00','15:30:00',NULL,0,0,0,NULL,3600,NULL),(15,1,1,2,NULL,NULL,34,'2016-05-10',2,'07:30:00','09:30:00',NULL,0,0,0,NULL,172800,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultorio`
--

LOCK TABLES `consultorio` WRITE;
/*!40000 ALTER TABLE `consultorio` DISABLE KEYS */;
INSERT INTO `consultorio` VALUES (1,'CONS013434343',1),(2,'01',0),(3,'02',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cronometro`
--

LOCK TABLES `cronometro` WRITE;
/*!40000 ALTER TABLE `cronometro` DISABLE KEYS */;
INSERT INTO `cronometro` VALUES (2,NULL,'2015-09-11',6,'2015-09-11 17:25:37','2015-09-11 17:53:27','2015-09-11 18:06:00'),(3,14,'2015-10-06',5,'2015-10-06 17:07:58','2015-10-06 17:11:01','2015-10-06 17:16:05'),(4,NULL,'2015-11-16',10,'2015-11-16 20:09:25','2015-11-16 20:09:53','2015-11-16 20:10:03');
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
INSERT INTO `dentista` VALUES (34,'789654123',NULL,'','','ac','','','','01:00','ytfvbnm,.','','',NULL,NULL,0,2,8),(35,'',NULL,'','','ac','','','','01:00','','','',NULL,NULL,0,3,NULL);
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_aberto`
--

LOCK TABLES `dentista_aberto` WRITE;
/*!40000 ALTER TABLE `dentista_aberto` DISABLE KEYS */;
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
INSERT INTO `dentista_areaatuacao` VALUES (34,1),(35,5);
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
INSERT INTO `dentista_dias` VALUES (34,0,1,1,1,1,1,0,NULL,'07:30 - 12:30','07:30 - 12:30','07:30 - 12:30','07:30 - 12:30','07:30 - 12:30',NULL,NULL,'13:30 - 19:30','13:30 - 19:30','13:30 - 19:30','13:30 - 19:30','13:30 - 19:30',NULL),(35,0,1,0,1,0,1,0,NULL,'07:30 - 12:30',NULL,'07:30 - 12:30',NULL,'07:30 - 12:30',NULL,NULL,'14:00 - 17:30',NULL,'14:00 - 17:30',NULL,'14:00 - 17:30',NULL);
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
INSERT INTO `dentista_intervalo` VALUES (1,34,'16:00:00','17:00:00',0,NULL,0,0,0,1,1,0,0);
/*!40000 ALTER TABLE `dentista_intervalo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentista_satisfacao`
--

DROP TABLE IF EXISTS `dentista_satisfacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentista_satisfacao` (
  `cdnSatisfacao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdnDentista` int(10) unsigned NOT NULL,
  `cdnPaciente` int(10) unsigned NOT NULL,
  `datSatisfacao` date NOT NULL,
  `numNota` int(11) NOT NULL,
  PRIMARY KEY (`cdnSatisfacao`,`cdnDentista`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentista_satisfacao`
--

LOCK TABLES `dentista_satisfacao` WRITE;
/*!40000 ALTER TABLE `dentista_satisfacao` DISABLE KEYS */;
INSERT INTO `dentista_satisfacao` VALUES (2,34,1,'2016-04-27',8);
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
INSERT INTO `desmarque` VALUES (1,14);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
INSERT INTO `fornecedor` VALUES (2,'Fornecedor 2','','','','','erterterfd','','',NULL,NULL),(3,'Representante Excel','(54) 9999-9191',NULL,NULL,'Facebook do cara','Um endereço preenchido aqui',NULL,NULL,NULL,'Nenhuma');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frase`
--

LOCK TABLES `frase` WRITE;
/*!40000 ALTER TABLE `frase` DISABLE KEYS */;
INSERT INTO `frase` VALUES (2,1,'Tudo muda, menos bermuda.',1),(4,1,'Tudo tem um fim, menos a salsicha que tem dois.',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,'SISTEMA','2016-02-19 15:50:51','SUCESSO','CADASTRO','34','DENTISTA_FECHADO'),(2,'34','2016-02-19 15:56:09','SUCESSO','ATUALIZACAO','34','DENTISTA'),(3,'34','2016-02-19 15:57:02','SUCESSO','ATUALIZACAO','34','DENTISTA'),(4,'paciente - 6','2016-02-19 15:58:14','ERRO','CADASTRO','34','CONSULTA'),(5,'34','2016-02-23 20:00:20','SUCESSO','ATUALIZACAO','1','DENTISTA'),(6,'1','2016-02-23 20:00:41','SUCESSO','CADASTRO','1','INTERVALO'),(7,'2','2016-02-23 20:00:47','SUCESSO','CADASTRO','1','INTERVALO'),(8,'34','2016-02-23 20:01:23','SUCESSO','ATUALIZACAO','1','DENTISTA'),(9,'34','2016-02-23 20:02:26','SUCESSO','ATUALIZACAO','1','DENTISTA'),(10,'34','2016-02-25 00:03:24','ERRO','CADASTRO','34','DENTISTA_ABERTO'),(11,'34','2016-02-25 00:04:05','ERRO','CADASTRO','34','DENTISTA_ABERTO'),(12,'34','2016-02-25 00:32:00','SUCESSO','CADASTRO','1','DENTISTA_ABERTO'),(13,'17','2016-02-25 00:32:48','SUCESSO','CADASTRO','1','CONSULTA'),(14,'35','2016-02-26 10:38:50','SUCESSO','CADASTRO','1','DENTISTA_ABERTO'),(15,'35','2016-02-26 10:39:06','SUCESSO','ATUALIZACAO','1','DENTISTA'),(16,'35','2016-02-26 10:40:58','SUCESSO','ATUALIZACAO','1','DENTISTA'),(17,'34','2016-04-06 00:53:02','SUCESSO','ATUALIZACAO','1','DENTISTA'),(18,'1','2016-04-06 00:53:26','SUCESSO','CADASTRO','1','INTERVALO'),(19,'35','2016-04-06 00:54:38','SUCESSO','ATUALIZACAO','1','DENTISTA'),(20,'1','2016-04-06 00:55:32','SUCESSO','CADASTRO','1','PACIENTE'),(21,'paciente - 1','2016-04-06 00:56:58','ERRO','CADASTRO','1','CONSULTA'),(22,'paciente - 1','2016-04-06 00:57:43','ERRO','CADASTRO','1','CONSULTA'),(23,'paciente - 1','2016-04-06 01:00:26','ERRO','CADASTRO','1','CONSULTA'),(24,'paciente - 1','2016-04-06 01:01:36','ERRO','CADASTRO','1','CONSULTA'),(25,'paciente - 1','2016-04-08 14:25:23','ERRO','CADASTRO','1','CONSULTA'),(26,'paciente - 1','2016-04-08 14:27:31','ERRO','CADASTRO','1','CONSULTA'),(27,'3','2016-04-08 14:28:13','SUCESSO','CADASTRO','1','CONSULTA'),(28,'4','2016-04-08 14:29:37','SUCESSO','CADASTRO','1','CONSULTA'),(29,'4','2016-04-08 14:29:52','SUCESSO','CADASTRO','1','DESMARQUE'),(30,'4','2016-04-08 14:29:58','SUCESSO','DESFAZER','1','DESMARQUE'),(31,'dentista2@final1.com.br','2016-04-26 11:13:24','ERRO','CADASTRO','1','DENTISTA'),(32,'SISTEMA','2016-04-27 09:57:36','SUCESSO','CONFIGURACOES','1','SMS'),(33,'11','2016-04-27 10:06:50','SUCESSO','CADASTRO','1','CONSULTA'),(34,'12','2016-04-28 09:29:03','SUCESSO','CADASTRO','1','CONSULTA'),(35,'12','2016-04-28 09:29:20','SUCESSO','REMARCAR','1','CONSULTA'),(36,'14','2016-04-28 21:41:53','SUCESSO','CADASTRO','1','CONSULTA'),(37,'14','2016-04-28 21:43:22','SUCESSO','CADASTRO','1','DESMARQUE'),(38,'14','2016-04-28 21:43:38','SUCESSO','DESFAZER','1','DESMARQUE'),(39,'14','2016-04-28 21:50:25','SUCESSO','DESFAZER','1','DESMARQUE'),(40,'14','2016-04-28 21:50:33','SUCESSO','DESFAZER','1','DESMARQUE'),(41,'14','2016-04-28 21:51:00','SUCESSO','DESFAZER','1','DESMARQUE'),(42,'14','2016-04-28 21:52:22','SUCESSO','DESFAZER','1','DESMARQUE'),(43,'14','2016-04-28 21:52:37','SUCESSO','DESFAZER','1','DESMARQUE'),(44,'14','2016-04-28 21:53:10','SUCESSO','DESFAZER','1','DESMARQUE'),(45,'14','2016-04-28 21:53:23','SUCESSO','CADASTRO','1','DESMARQUE'),(46,'14','2016-04-28 21:53:37','SUCESSO','DESFAZER','1','DESMARQUE'),(47,'14','2016-04-28 21:53:46','SUCESSO','CADASTRO','1','FALTA'),(48,'14','2016-04-28 21:57:10','SUCESSO','CADASTRO','1','DESMARQUE'),(49,'13','2016-04-28 21:57:39','SUCESSO','REMARCAR','1','CONSULTA'),(50,'SISTEMA','2016-04-28 21:58:12','SUCESSO','CONFIGURACOES','1','SMS'),(51,'13','2016-04-28 22:03:04','SUCESSO','REMARCAR','1','CONSULTA'),(52,'13','2016-04-28 22:03:26','SUCESSO','REMARCAR','1','CONSULTA'),(53,'13','2016-04-28 22:03:58','SUCESSO','REMARCAR','1','CONSULTA'),(54,'13','2016-04-28 22:04:12','SUCESSO','REMARCAR','1','CONSULTA'),(55,'13','2016-04-28 22:04:40','SUCESSO','REMARCAR','1','CONSULTA'),(56,'13','2016-04-28 22:04:59','SUCESSO','REMARCAR','1','CONSULTA'),(57,'13','2016-04-28 22:06:30','SUCESSO','REMARCAR','1','CONSULTA'),(58,'SISTEMA','2016-04-30 22:20:04','SUCESSO','CONFIGURACOES','1','SMS'),(59,'SISTEMA','2016-04-30 22:20:08','ERRO','CONFIGURACOES','1','SMS'),(60,'SISTEMA','2016-04-30 22:20:12','SUCESSO','CONFIGURACOES','1','SMS'),(61,'SISTEMA','2016-04-30 22:20:15','SUCESSO','CONFIGURACOES','1','SMS'),(62,'SISTEMA','2016-04-30 22:20:48','SUCESSO','CONFIGURACOES','1','SMS'),(63,'SISTEMA','2016-04-30 22:20:50','SUCESSO','CONFIGURACOES','1','SMS'),(64,'SISTEMA','2016-04-30 22:20:56','SUCESSO','CONFIGURACOES','1','SMS'),(65,'SISTEMA','2016-05-01 19:41:35','SUCESSO','CONFIGURACOES','1','SMS'),(66,'SISTEMA','2016-05-01 19:41:47','SUCESSO','CONFIGURACOES','1','SMS'),(67,'SISTEMA','2016-05-01 19:41:53','SUCESSO','CONFIGURACOES','1','SMS'),(68,'15','2016-05-06 09:51:19','SUCESSO','CADASTRO','1','CONSULTA');
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
  `nomSobrenome` varchar(300) DEFAULT NULL,
  `codCpf` varchar(20) DEFAULT NULL,
  `datNascimento` date DEFAULT NULL,
  `codUf` varchar(2) DEFAULT NULL,
  `fileFoto` text,
  `cdnParceria` int(10) unsigned DEFAULT NULL,
  `indDesvinculado` tinyint(1) NOT NULL DEFAULT '0',
  `numDiasAntecedenciaSms` int(11) DEFAULT '1',
  PRIMARY KEY (`cdnPaciente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (1,'Fulano','de Tal','038.420.230-65','1995-06-21','rs','',0,0,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parceria`
--

LOCK TABLES `parceria` WRITE;
/*!40000 ALTER TABLE `parceria` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pergunta`
--

LOCK TABLES `pergunta` WRITE;
/*!40000 ALTER TABLE `pergunta` DISABLE KEYS */;
INSERT INTO `pergunta` VALUES (1,'Quando foi seu último exame dentário completo?'),(2,'Você está sob cuidado médico? Por que?'),(3,'É alérgico a algum medicamento ou substância?'),(4,'Qual?'),(5,'Se você é mulher, está grávida ou crê que possa estar?'),(6,'Tem pressão alta ou baixa?'),(7,'Tem alteração no sangue como Anemia, Leucemia, Hemorragia, etc?'),(8,'Tem algum problema Estomacal?'),(9,'Você é diabético ou cardíaco?lksdja flkasdjdsak dsafjsdalkf jsdalkf jsdalkfsd jalfkasd jlfkasd jflksdaj flksad jfdslakf jadslkf jsdalkf jsad'),(10,'Quais as vacinas que já fez?'),(11,'Quando?'),(12,'Está tomando algum medicamento?'),(13,'Já fez ou está fazendo Raioterapia/Quimioterapia?'),(14,'Já fez transfusão de sangue?'),(15,'Usou ou usa hormônios por tempo prolongado?klfjsdkf jdslkfs djlfksd jflksd jflksd jflskd jfsdl fjdslf jsdlkfj sdlkf jsdlfkds jlfsd jflsdk jfsdalkfasdkfhsd'),(16,'Fez alguma cirurgia nos últimos 5 anos?'),(17,'Já teve alguma destas doenças?'),(18,'vvzvvzvzvxvzxcvs fds fsd fsdf asdf asdf sad');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pergunta_opcao`
--

LOCK TABLES `pergunta_opcao` WRITE;
/*!40000 ALTER TABLE `pergunta_opcao` DISABLE KEYS */;
INSERT INTO `pergunta_opcao` VALUES (1,17,'Tuberculose'),(2,17,'Sífilis'),(3,17,'Tumor'),(4,17,'HIV'),(5,17,'Doença Renal'),(6,17,'Febre Reumática'),(7,17,'Discrasias Sanguíneas'),(8,17,'Epilepsia  / convulsão '),(11,19,'Trombose');
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procedimento`
--

LOCK TABLES `procedimento` WRITE;
/*!40000 ALTER TABLE `procedimento` DISABLE KEYS */;
INSERT INTO `procedimento` VALUES (20,1,'Primeiro procedimento',NULL,0,1),(21,1,'Segundo procedimento',NULL,0,0),(22,1,'Novo procedimento',NULL,0,0),(23,1,'tal',NULL,0,0),(24,6,'Prevenção',NULL,0,0),(25,6,'Raspagem supra-gengival',NULL,0,0),(26,7,'Prótese coroa metal cerâmica',NULL,0,0),(27,1,'teste',NULL,0,0),(28,5,'dfg','dfgdf',0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schema_campo`
--

LOCK TABLES `schema_campo` WRITE;
/*!40000 ALTER TABLE `schema_campo` DISABLE KEYS */;
INSERT INTO `schema_campo` VALUES (1,0,1,'paciente','cdnPaciente','number','Código numérico',0,0,NULL,'numero'),(2,0,2,'paciente','nomPaciente','text','Nome',1,1,300,'vazio'),(3,0,6,'paciente','codCpf','cpf','CPF',1,0,20,'cpf'),(4,0,4,'paciente','datNascimento','date','Data de nascimento',1,0,NULL,'data'),(5,0,5,'paciente','codUf','select','Estado',1,0,0,'uf'),(6,5,1,'paciente','rs','option','Rio Grande do Sul',1,0,0,''),(7,5,2,'paciente','rj','option','Rio de Janeiro',1,0,0,''),(8,0,0,'paciente','indDesvinculado','boolean','Desvinculado?',0,0,0,''),(9,0,7,'paciente','fileFoto','file','Foto',1,0,0,'imagem'),(10,0,3,'paciente','nomSobrenome','text','Sobrenome',1,1,300,'vazio'),(11,0,99,'paciente','cdnParceria','integer','Parceria',0,0,0,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secao`
--

LOCK TABLES `secao` WRITE;
/*!40000 ALTER TABLE `secao` DISABLE KEYS */;
INSERT INTO `secao` VALUES (1,22,'Primeira seção','Seção que irá conter uma descrição',0,0),(2,20,'Seção maneira','agora vai ter descrição',0,0),(3,21,'Primeira seção do segundo procedimento','hu3',0,1),(4,21,'Segunda seção do segundo procedimento','brbr',1,0),(5,23,'seção do tal','descrição do tal',0,0),(6,23,'ghfghh','hhdfhgf',0,0),(7,26,'Prova do casquete','',0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms`
--

LOCK TABLES `sms` WRITE;
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
INSERT INTO `sms` VALUES (1,'2016-04-26 10:54:42',0,1,'Algum texto.','555499031426','328794654789451'),(2,'2016-04-20 10:54:42',0,1,'Algum texto.','555499031426','328794654789451'),(3,'2016-04-27 10:16:29',0,1,'Ola, Fulano! Voce tem uma consulta marcada para as 10:30:00 do dia 27/04/2016 na clinica Clinica de Testes. Responda \"Confirmar\" ou \"Cancelar\".','555499031426','280505720bbadc73e9'),(4,'2016-04-27 10:46:16',0,1,'Ola, Fulano! Avalie o atendimento do profissional Ciclano com uma nota de \"0\" ate \"10\".','555499031426','63495720c2a8e6cab'),(5,'2016-04-28 09:35:26',0,1,'Ola, Fulano! Voce tem uma consulta marcada para as 12:35:00 do dia 28/04/2016 na clinica Clinica de Testes. Responda \"Confirmar\" ou \"Cancelar\".','555499031426','15815722038edb703');
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
INSERT INTO `sms_aviso_consulta` VALUES (3,1,'2016-04-11 00:00:00',1,0,'555499031426',NULL),(11,3,'2016-04-27 10:15:00',1,0,'555499031426',NULL),(12,5,'2016-04-28 09:35:00',1,0,'555499031426',NULL),(13,NULL,'2016-04-28 14:30:00',1,0,'555499031426',NULL),(15,NULL,'2016-05-08 07:30:00',1,0,'555499031426',NULL);
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
  `strResposta` text NOT NULL,
  PRIMARY KEY (`cdnResposta`),
  UNIQUE KEY `cdnConsulta` (`cdnConsulta`),
  UNIQUE KEY `cdnConsulta_2` (`cdnConsulta`),
  UNIQUE KEY `cdnConsulta_3` (`cdnConsulta`),
  UNIQUE KEY `cdnConsulta_4` (`cdnConsulta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_aviso_consulta_resposta`
--

LOCK TABLES `sms_aviso_consulta_resposta` WRITE;
/*!40000 ALTER TABLE `sms_aviso_consulta_resposta` DISABLE KEYS */;
INSERT INTO `sms_aviso_consulta_resposta` VALUES (1,11,1,'2016-04-27 10:41:02','Confirmar'),(4,12,1,'2016-04-28 09:36:08','Confirmar');
/*!40000 ALTER TABLE `sms_aviso_consulta_resposta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_contagem_paciente`
--

DROP TABLE IF EXISTS `sms_contagem_paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_contagem_paciente` (
  `cdnPaciente` int(10) unsigned NOT NULL,
  `numEnvios` int(11) DEFAULT NULL,
  `numRecebimento` int(11) DEFAULT NULL,
  PRIMARY KEY (`cdnPaciente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_contagem_paciente`
--

LOCK TABLES `sms_contagem_paciente` WRITE;
/*!40000 ALTER TABLE `sms_contagem_paciente` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_contagem_paciente` ENABLE KEYS */;
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
  PRIMARY KEY (`cdnSatisfacao`),
  UNIQUE KEY `cdnConsulta` (`cdnConsulta`),
  UNIQUE KEY `cdnConsulta_2` (`cdnConsulta`),
  UNIQUE KEY `cdnConsulta_3` (`cdnConsulta`),
  UNIQUE KEY `cdnConsulta_4` (`cdnConsulta`),
  UNIQUE KEY `cdnConsulta_5` (`cdnConsulta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_satisfacao`
--

LOCK TABLES `sms_satisfacao` WRITE;
/*!40000 ALTER TABLE `sms_satisfacao` DISABLE KEYS */;
INSERT INTO `sms_satisfacao` VALUES (1,2,'2016-04-26 11:02:35',4,'555499031426',NULL,1),(2,4,'2016-04-27 10:44:00',11,'555499031426',NULL,1),(3,NULL,'2016-05-10 09:30:00',15,'555499031426',NULL,1);
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
INSERT INTO `usuario_master` VALUES (1),(35),(37),(41);
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

-- Dump completed on 2016-05-07 13:52:39
