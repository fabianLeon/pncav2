CREATE DATABASE  IF NOT EXISTS `protasingenieria` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `protasingenieria`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: protasingenieria
-- ------------------------------------------------------
-- Server version	5.5.24

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
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `presentacion` varchar(45) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `valorCompra` int(11) NOT NULL,
  `porcentajeGanancia` decimal(10,0) DEFAULT NULL,
  `IVA` int(11) NOT NULL,
  `Empresa_NIT` varchar(15) NOT NULL,
  PRIMARY KEY (`codigo`,`Empresa_NIT`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  KEY `fk_Producto_Empresa` (`Empresa_NIT`),
  CONSTRAINT `fk_Producto_Empresa` FOREIGN KEY (`Empresa_NIT`) REFERENCES `empresa` (`NIT`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipoempresa`
--

DROP TABLE IF EXISTS `tipoempresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoempresa` (
  `idTipoEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `detalle` varchar(30) NOT NULL,
  PRIMARY KEY (`idTipoEmpresa`),
  UNIQUE KEY `idTipoEmpresa_UNIQUE` (`idTipoEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoempresa`
--

LOCK TABLES `tipoempresa` WRITE;
/*!40000 ALTER TABLE `tipoempresa` DISABLE KEYS */;
INSERT INTO `tipoempresa` VALUES (1,'Cliente'),(2,'Proveedor');
/*!40000 ALTER TABLE `tipoempresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `NIT` varchar(15) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(7) NOT NULL,
  `contacto` varchar(30) DEFAULT NULL,
  `celularContacto` varchar(10) DEFAULT NULL,
  `TipoEmpresa_idTipoEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`NIT`,`TipoEmpresa_idTipoEmpresa`),
  KEY `fk_Empresa_TipoEmpresa1` (`TipoEmpresa_idTipoEmpresa`),
  CONSTRAINT `fk_Empresa_TipoEmpresa1` FOREIGN KEY (`TipoEmpresa_idTipoEmpresa`) REFERENCES `tipoempresa` (`idTipoEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

DROP FUNCTION IF EXISTS valorVenta;

DELIMITER //

CREATE FUNCTION valorVenta(valorCompra INT, porcentajeGanancia INT) RETURNS INT
  BEGIN
    DECLARE decenas INT;
    DECLARE resto INT;
    DECLARE valorVenta INT;
    SET valorVenta = ROUND(valorCompra*(1 + porcentajeGanancia/100), 0);
    SET decenas = SUBSTRING(valorVenta, LENGTH(valorVenta) - 1,LENGTH(valorVenta));
    SET resto = SUBSTRING(valorVenta, 1, LENGTH(valorVenta) - 2);
    IF decenas >= 25 AND decenas < 75 THEN 
        SET decenas = 50;
        RETURN CONCAT(resto, decenas);
    ELSE
        RETURN ROUND(valorVenta, -2);
    END IF;
  END //

DELIMITER ;

-- Dump completed on 2013-08-14 18:53:23
