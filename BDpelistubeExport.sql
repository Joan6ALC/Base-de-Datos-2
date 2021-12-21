-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-12-2021 a las 20:47:40
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pelistube`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `nuevaFactura` ()  BEGIN
DECLARE hihaerror BOOL;
DECLARE locDataInici DATE;
DECLARE locDataFin DATE;
DECLARE locImport INTEGER;
DECLARE locIdContracte INTEGER;
DECLARE locNomTarifa VARCHAR(15);
DECLARE locPeriodicitat INTEGER;
DECLARE pagaHoy CURSOR FOR SELECT dataFinal, import, IdContracte FROM factura WHERE dataFinal = CURRENT_DATE;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET hihaerror=true;
  OPEN pagaHoy;
  etiq: LOOP
	FETCH pagaHoy INTO locDataInici, locImport, locIdContracte;
    IF hihaerror THEN
    	LEAVE etiq;
    END IF;
    SELECT periodicitat INTO locPeriodicitat FROM contracte JOIN tarifa ON contracte.IdContracte = locIdContracte AND contracte.nomTarifa = tarifa.nomTarifa;
    INSERT INTO factura(dataInici,dataFinal,import,IdContracte, dataPagament) VALUES (locDataInici,date_add(now(),INTERVAL locPeriodicitat DAY ),locImport,locIdContracte, null);
	END LOOP;
    CLOSE pagaHoy;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procGeneraMissatges` (IN `IdContingut` INT, IN `nomCat` VARCHAR(20))  BEGIN
DECLARE locusername VARCHAR(15);
DECLARE hihaerror BOOLEAN;
DECLARE usuarisMissatge CURSOR FOR  SELECT persona.username FROM (categoriafavorits JOIN contracte ON contracte.IdContracte=categoriafavorits.IdContracte AND categoriafavorits.nomCat=nomCat) JOIN persona ON contracte.username=persona.username; # Seleccionam els contractes que tenen la categoria de la pel·lícula inserida com a favorita i després lusuari al que pertany el contracte
DECLARE CONTINUE HANDLER FOR NOT FOUND SET hihaerror=true;
  
  OPEN usuarisMissatge;
  etiq: LOOP
	FETCH usuarisMissatge INTO locusername;
    IF hihaerror THEN
    	LEAVE etiq;
    END IF;
    
	INSERT INTO missatge(data,assumpte,descripcio, estatMissatge, username, IdContingut) VALUES (CURRENT_DATE,"Nueva película en el catálogo", "Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ", false, locusername, IdContingut);

	END LOOP;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `nomCat` varchar(20) NOT NULL,
  `visible` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`nomCat`, `visible`) VALUES
('Acción', 1),
('Animación', 1),
('Aventuras', 1),
('Bélica', 1),
('Ciencia ficción', 1),
('Comedia', 1),
('Crimen', 1),
('Documental', 1),
('Drama', 1),
('Fantasía', 1),
('Histórica', 1),
('Intriga', 1),
('Musical', 1),
('Policíaca', 1),
('Suspense', 1),
('Terror', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriafavorits`
--

CREATE TABLE `categoriafavorits` (
  `IdContracte` int(11) NOT NULL,
  `nomCat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoriafavorits`
--

INSERT INTO `categoriafavorits` (`IdContracte`, `nomCat`) VALUES
(1, 'Animación'),
(1, 'Aventuras'),
(1, 'Ciencia ficción'),
(4, 'Animación'),
(4, 'Aventuras'),
(4, 'Ciencia ficción'),
(4, 'Comedia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contingut`
--

CREATE TABLE `contingut` (
  `IdContingut` int(11) NOT NULL,
  `titol` varchar(20) NOT NULL,
  `link` varchar(250) NOT NULL,
  `camiFoto` varchar(250) NOT NULL,
  `nomCat` varchar(20) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contingut`
--

INSERT INTO `contingut` (`IdContingut`, `titol`, `link`, `camiFoto`, `nomCat`, `visible`) VALUES
(20, 'Interstellar', 'https://www.youtube.com/embed/UoSSbmD9vqc', '/img/carteles/interstellar.jpg', 'Ciencia ficción', 1),
(21, 'Venom', 'https://www.youtube.com/embed/nZ8FXOpcXSs', '/img/carteles/venom.jpg', 'Ciencia ficción', 1),
(22, 'Venom: Habrá Matanza', 'https://www.youtube.com/embed/UZggozsVz9M', '/img/carteles/venom2.jpg', 'Ciencia ficción', 0),
(23, 'Cars 3', 'https://www.youtube.com/embed/wtmW9rSRIzU', '/img/carteles/cars3.jpg', 'Animación', 1),
(24, 'Supersalidos', 'https://www.youtube.com/embed/b8ht6ObDlyQ', '/img/carteles/supersalidos.jpg', 'Comedia', 1),
(25, 'Dando la nota', 'https://www.youtube.com/embed/XtdBRvIIpf4', '/img/carteles/dandonota.jpg', 'Comedia', 1),
(27, 'Resacón en Las Vegas', 'https://www.youtube.com/embed/HsK23vU-65A', '/img/carteles/resacon.jpg', 'Comedia', 1),
(28, 'Marte', 'https://www.youtube.com/embed/YunRU1tE1X4', '/img/carteles/marte.jpg', 'Ciencia ficción', 1),
(29, 'Avatar', 'https://www.youtube.com/embed/5PSNL1qE6VY', '/img/carteles/1-Avatar.jpg', 'Ciencia ficción', 1),
(30, 'ZONE 414', 'https://www.youtube.com/embed/Zn5kZwZ-l2g', '/img/carteles/2-ZONE 414.jpg', 'Ciencia ficción', 1),
(31, 'DUNE', 'https://www.youtube.com/embed/1looWByWgW0', '/img/carteles/3-DUNE.jpg', 'Ciencia ficción', 1),
(32, 'Reminiscencia', 'https://www.youtube.com/embed/5MvFknvMabU', '/img/carteles/4-Reminiscencia.jpg', 'Ciencia ficción', 1),
(33, 'Chaos Walking', 'https://www.youtube.com/embed/KJOd3poTq_I', '/img/carteles/5-Chaos Walking.jpg', 'Ciencia ficción', 1),
(34, 'Ad Astra', 'https://www.youtube.com/embed/gaf-zgnlNLg', '/img/carteles/6-Ad Astra.jpg', 'Ciencia ficción', 1),
(35, 'Jumanji', 'https://www.youtube.com/embed/leIrosWRbYQ', '/img/carteles/7-Jumanji.jpg', 'Aventuras', 1),
(36, 'Jungle Cruise', 'https://www.youtube.com/embed/hIJUnZnvAzA', '/img/carteles/8-Jungle Cruise.jpg', 'Aventuras', 1),
(37, 'Animales fantásticos', 'https://www.youtube.com/embed/US2LnWrrCq4', '/img/carteles/14-Animales Fantásticos.jpg', 'Aventuras', 1),
(38, 'Los Simpson', 'https://www.youtube.com/embed/HRV6tMR-SSs', '/img/carteles/9-Los Simpson.png', 'Animación', 1),
(39, 'Soul', 'https://www.youtube.com/embed/85hY9bninqU', '/img/carteles/10-Soul.jpg', 'Animación', 1),
(40, 'Coco', 'https://www.youtube.com/embed/htwlR51npL4', '/img/carteles/11-Coco.jpg', 'Animación', 1),
(41, 'Del Revés', 'https://www.youtube.com/embed/RbfKs_syius', '/img/carteles/12-Del reves.jpg', 'Animación', 1),
(42, 'El Rey León', 'https://www.youtube.com/embed/mb79ctR-E-c', '/img/carteles/13-El Rey León.jpg', 'Animación', 1),
(43, 'Alerta Roja', 'https://www.youtube.com/embed/UUZ_DITqers', '/img/carteles/15-Alerta Roja.jpg', 'Acción', 1),
(44, '1917', 'https://www.youtube.com/embed/SBc69RKIqwg', '/img/carteles/16-1917.jpg', 'Bélica', 1),
(45, 'The Last Dance', 'https://www.youtube.com/embed/qQjYmZgB3QQ', '/img/carteles/17-The Last Dance.jpg', 'Documental', 1);

--
-- Disparadores `contingut`
--
DELIMITER $$
CREATE TRIGGER `GeneraMissatges` AFTER INSERT ON `contingut` FOR EACH ROW BEGIN
	call procGeneraMissatges(NEW.IdContingut, NEW.nomCat);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contingutfavorits`
--

CREATE TABLE `contingutfavorits` (
  `IdContracte` int(11) NOT NULL,
  `IdContingut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contracte`
--

CREATE TABLE `contracte` (
  `dataAlta` date DEFAULT NULL,
  `dataBaixa` date DEFAULT NULL,
  `estat` tinyint(1) DEFAULT NULL,
  `IdContracte` int(11) NOT NULL,
  `nomTarifa` varchar(15) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contracte`
--

INSERT INTO `contracte` (`dataAlta`, `dataBaixa`, `estat`, `IdContracte`, `nomTarifa`, `username`) VALUES
('2021-11-01', NULL, 1, 1, 'MENSUAL', 'user1'),
('2021-12-21', NULL, 1, 2, 'MENSUAL', 'mat99'),
('2021-12-17', NULL, 1, 3, 'MENSUAL', 'user3'),
('2021-12-21', NULL, 1, 4, 'TRIMESTRAL', 'user5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `import` int(11) NOT NULL,
  `dataInici` date DEFAULT NULL,
  `dataFinal` date DEFAULT NULL,
  `dataPagament` date DEFAULT NULL,
  `IdFactura` int(11) NOT NULL,
  `IdContracte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`import`, `dataInici`, `dataFinal`, `dataPagament`, `IdFactura`, `IdContracte`) VALUES
(10, '2021-09-01', '2021-10-01', NULL, 1, 1),
(10, '2021-10-01', '2021-11-01', NULL, 2, 1),
(10, '2021-11-01', '2021-12-01', NULL, 3, 1),
(10, '2021-12-01', '2022-01-20', NULL, 4, 2),
(10, '2022-01-01', '2022-02-01', NULL, 5, 2),
(25, '2022-02-01', '2022-03-01', NULL, 6, 2),
(10, '2021-09-01', '2021-10-01', NULL, 7, 3),
(25, '2021-12-21', '2022-03-21', NULL, 8, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `missatge`
--

CREATE TABLE `missatge` (
  `data` date DEFAULT NULL,
  `assumpte` varchar(50) DEFAULT NULL,
  `descripcio` varchar(280) DEFAULT NULL,
  `estatMissatge` tinyint(1) DEFAULT NULL,
  `IdMissatge` int(11) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `IdContingut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `missatge`
--

INSERT INTO `missatge` (`data`, `assumpte`, `descripcio`, `estatMissatge`, `IdMissatge`, `username`, `IdContingut`) VALUES
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 1, 'user1', 20),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 2, 'user5', 20),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 3, 'user1', 21),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 4, 'user5', 21),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 5, 'user1', 22),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 6, 'user5', 22),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 7, 'user1', 23),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 8, 'user5', 23),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 9, 'user5', 24),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 10, 'user5', 25),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 11, 'user5', 27),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 12, 'user1', 28),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 13, 'user5', 28),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 14, 'user1', 29),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 15, 'user5', 29),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 16, 'user1', 30),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 17, 'user5', 30),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 18, 'user1', 31),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 19, 'user5', 31),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 20, 'user1', 32),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 21, 'user5', 32),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 22, 'user1', 33),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 23, 'user5', 33),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 24, 'user1', 34),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 25, 'user5', 34),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 26, 'user1', 35),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 27, 'user5', 35),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 28, 'user1', 36),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 29, 'user5', 36),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 30, 'user1', 37),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 31, 'user5', 37),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 32, 'user1', 38),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 33, 'user5', 38),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 34, 'user1', 39),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 35, 'user5', 39),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 36, 'user1', 40),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 37, 'user5', 40),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 38, 'user1', 41),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 39, 'user5', 41),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 40, 'user1', 42),
('2021-12-21', 'Nueva película en el catálogo', 'Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ', 0, 41, 'user5', 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `dataAlta` date NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(45) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `llinatge1` varchar(20) NOT NULL,
  `llinatge2` varchar(20) DEFAULT NULL,
  `dataNaixament` date NOT NULL,
  `administrador` tinyint(1) DEFAULT NULL,
  `IdTipus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`dataAlta`, `username`, `password`, `nom`, `llinatge1`, `llinatge2`, `dataNaixament`, `administrador`, `IdTipus`) VALUES
('0000-00-00', 'admin', '$1$ciJ2Am3s$jy1CJ0uIm7q9CwmFw.hvS/', 'admin', 'admin', 'admin', '0000-00-00', 1, NULL),
('2021-12-21', 'mat99', '$1$ciJ2Am3s$jy1CJ0uIm7q9CwmFw.hvS/', 'Mateu', 'Vaquer', 'Gomila', '1997-09-12', 0, NULL),
('2021-09-01', 'user1', '$1$ciJ2Am3s$jy1CJ0uIm7q9CwmFw.hvS/', 'Juan Carlos', 'Bujosa', 'Herreros', '1996-08-31', 0, NULL),
('2021-12-17', 'user3', '$1$ciJ2Am3s$jy1CJ0uIm7q9CwmFw.hvS/', 'Zhuo Han', 'Yang', 'Yang', '2000-09-21', 0, NULL),
('2021-12-21', 'user5', '$1$ciJ2Am3s$jy1CJ0uIm7q9CwmFw.hvS/', 'Joan', 'Alcover', 'Lladó', '1999-11-29', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `r_tipus_contingut`
--

CREATE TABLE `r_tipus_contingut` (
  `IdTipus` int(11) NOT NULL,
  `IdContingut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `r_tipus_contingut`
--

INSERT INTO `r_tipus_contingut` (`IdTipus`, `IdContingut`) VALUES
(1, 23),
(1, 25),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 45),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36),
(2, 37),
(2, 38),
(2, 39),
(2, 40),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 27),
(3, 28),
(3, 29),
(3, 30),
(3, 31),
(3, 32),
(3, 33),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(3, 42),
(3, 43),
(3, 44),
(3, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa`
--

CREATE TABLE `tarifa` (
  `nomTarifa` varchar(15) NOT NULL,
  `preu` int(11) NOT NULL,
  `periodicitat` int(11) NOT NULL,
  `estatTarifa` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tarifa`
--

INSERT INTO `tarifa` (`nomTarifa`, `preu`, `periodicitat`, `estatTarifa`) VALUES
('MENSUAL', 10, 30, 0),
('TRIMESTRAL', 25, 90, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipus`
--

CREATE TABLE `tipus` (
  `IdTipus` int(11) NOT NULL,
  `edat` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipus`
--

INSERT INTO `tipus` (`IdTipus`, `edat`) VALUES
(1, '<9 años'),
(2, '9-18 años'),
(3, '+18 años');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`nomCat`);

--
-- Indices de la tabla `categoriafavorits`
--
ALTER TABLE `categoriafavorits`
  ADD PRIMARY KEY (`IdContracte`,`nomCat`),
  ADD KEY `nomCat` (`nomCat`);

--
-- Indices de la tabla `contingut`
--
ALTER TABLE `contingut`
  ADD PRIMARY KEY (`IdContingut`),
  ADD KEY `nomCat` (`nomCat`);

--
-- Indices de la tabla `contingutfavorits`
--
ALTER TABLE `contingutfavorits`
  ADD PRIMARY KEY (`IdContracte`,`IdContingut`),
  ADD KEY `IdContingut` (`IdContingut`);

--
-- Indices de la tabla `contracte`
--
ALTER TABLE `contracte`
  ADD PRIMARY KEY (`IdContracte`),
  ADD KEY `nomTarifa` (`nomTarifa`),
  ADD KEY `username` (`username`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`IdFactura`),
  ADD KEY `IdContracte` (`IdContracte`);

--
-- Indices de la tabla `missatge`
--
ALTER TABLE `missatge`
  ADD PRIMARY KEY (`IdMissatge`),
  ADD KEY `username` (`username`),
  ADD KEY `IdContingut` (`IdContingut`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`username`),
  ADD KEY `IdTipus` (`IdTipus`);

--
-- Indices de la tabla `r_tipus_contingut`
--
ALTER TABLE `r_tipus_contingut`
  ADD PRIMARY KEY (`IdTipus`,`IdContingut`),
  ADD KEY `IdContingut` (`IdContingut`);

--
-- Indices de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD PRIMARY KEY (`nomTarifa`);

--
-- Indices de la tabla `tipus`
--
ALTER TABLE `tipus`
  ADD PRIMARY KEY (`IdTipus`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contingut`
--
ALTER TABLE `contingut`
  MODIFY `IdContingut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `contracte`
--
ALTER TABLE `contracte`
  MODIFY `IdContracte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `IdFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `missatge`
--
ALTER TABLE `missatge`
  MODIFY `IdMissatge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tipus`
--
ALTER TABLE `tipus`
  MODIFY `IdTipus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoriafavorits`
--
ALTER TABLE `categoriafavorits`
  ADD CONSTRAINT `categoriafavorits_ibfk_1` FOREIGN KEY (`IdContracte`) REFERENCES `contracte` (`IdContracte`),
  ADD CONSTRAINT `categoriafavorits_ibfk_2` FOREIGN KEY (`nomCat`) REFERENCES `categoria` (`nomCat`);

--
-- Filtros para la tabla `contingut`
--
ALTER TABLE `contingut`
  ADD CONSTRAINT `contingut_ibfk_1` FOREIGN KEY (`nomCat`) REFERENCES `categoria` (`nomCat`);

--
-- Filtros para la tabla `contingutfavorits`
--
ALTER TABLE `contingutfavorits`
  ADD CONSTRAINT `contingutfavorits_ibfk_1` FOREIGN KEY (`IdContracte`) REFERENCES `contracte` (`IdContracte`),
  ADD CONSTRAINT `contingutfavorits_ibfk_2` FOREIGN KEY (`IdContingut`) REFERENCES `contingut` (`IdContingut`);

--
-- Filtros para la tabla `contracte`
--
ALTER TABLE `contracte`
  ADD CONSTRAINT `contracte_ibfk_1` FOREIGN KEY (`nomTarifa`) REFERENCES `tarifa` (`nomTarifa`),
  ADD CONSTRAINT `contracte_ibfk_2` FOREIGN KEY (`username`) REFERENCES `persona` (`username`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`IdContracte`) REFERENCES `contracte` (`IdContracte`);

--
-- Filtros para la tabla `missatge`
--
ALTER TABLE `missatge`
  ADD CONSTRAINT `missatge_ibfk_1` FOREIGN KEY (`username`) REFERENCES `persona` (`username`),
  ADD CONSTRAINT `missatge_ibfk_2` FOREIGN KEY (`IdContingut`) REFERENCES `contingut` (`IdContingut`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`IdTipus`) REFERENCES `tipus` (`IdTipus`);

--
-- Filtros para la tabla `r_tipus_contingut`
--
ALTER TABLE `r_tipus_contingut`
  ADD CONSTRAINT `r_tipus_contingut_ibfk_1` FOREIGN KEY (`IdTipus`) REFERENCES `tipus` (`IdTipus`),
  ADD CONSTRAINT `r_tipus_contingut_ibfk_2` FOREIGN KEY (`IdContingut`) REFERENCES `contingut` (`IdContingut`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `facturacio` ON SCHEDULE EVERY 1 DAY STARTS '2021-12-19 03:00:00' ON COMPLETION PRESERVE ENABLE DO CALL nuevaFactura()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
