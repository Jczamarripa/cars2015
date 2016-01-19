-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-10-2015 a las 08:39:00
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cars2015`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `car_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id_model` varchar(5) NOT NULL,
  `car_year` int(11) NOT NULL,
  `car_price` double NOT NULL,
  `car_color` varchar(20) NOT NULL,
  `car_image` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`car_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Volcar la base de datos para la tabla `cars`
--

INSERT INTO `cars` (`car_id`, `car_id_model`, `car_year`, `car_price`, `car_color`, `car_image`) VALUES
(1, '2001', 1999, 2400, 'White', '1.jpg'),
(2, '2001', 2002, 2500, 'Metallic Green', '2.jpg'),
(3, '2001', 1996, 3100, 'Gray', '3.jpg'),
(4, '2001', 2004, 3995, 'Red', '4.jpg'),
(5, '2001', 2002, 3999, 'Red', '5.jpg'),
(6, '2001', 2002, 4200, 'Black', '6.jpg'),
(7, '2001', 2007, 4400, 'Oxford White', '7.jpg'),
(8, '2001', 2003, 4977, 'Silver', '8.jpg'),
(9, '2001', 2009, 15999, 'Black', '10.jpg'),
(10, '2001', 2011, 16922, 'Kona Blue Metallic', '11.jpg'),
(11, '2001', 2011, 18250, 'Silver', '12.jpg'),
(12, '2002', 1999, 1750, 'White', '13.jpg'),
(13, '2002', 2002, 2500, 'Red', '14.jpg'),
(14, '2002', 2010, 5800, 'Silver', '15.jpg'),
(15, '2002', 2008, 5995, 'Gold', '16.jpg'),
(16, '2002', 2012, 6500, 'Gray', '17.jpg'),
(17, '2002', 2012, 6750, 'Black', '18.jpg'),
(18, '2002', 2014, 7200, 'White', '19.jpg'),
(19, '2002', 2014, 7250, 'White', '20.jpg'),
(20, '2002', 2015, 8900, 'Gray', '21.jpg'),
(21, '2002', 2015, 9100, 'Metallic Gray', '22.jpg'),
(22, '2002', 2013, 9200, 'Red', '23.jpg'),
(23, '2002', 2015, 10250, 'White', '24.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `makes`
--

CREATE TABLE IF NOT EXISTS `makes` (
  `mak_id` varchar(5) NOT NULL,
  `mak_name` varchar(50) NOT NULL,
  PRIMARY KEY (`mak_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `makes`
--

INSERT INTO `makes` (`mak_id`, `mak_name`) VALUES
('1001', 'Ford'),
('1002', 'Honda'),
('1003', 'Nissan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `models`
--

CREATE TABLE IF NOT EXISTS `models` (
  `mod_id` varchar(5) NOT NULL,
  `mod_name` varchar(50) NOT NULL,
  `mod_id_make` varchar(5) NOT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `models`
--

INSERT INTO `models` (`mod_id`, `mod_name`, `mod_id_make`) VALUES
('2001', 'Explorer', '1001'),
('2002', 'Focus', '1001'),
('2003', 'Mustang', '1001'),
('2004', 'Accord', '1002'),
('2005', 'Civic', '1002'),
('2006', 'CR-V', '1002'),
('2007', 'Altima', '1003'),
('2008', 'Maxima', '1003'),
('2009', 'Sentra', '1003');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `usr_id` varchar(20) NOT NULL,
  `usr_name` varchar(50) NOT NULL,
  `usr_password` varchar(50) NOT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`usr_id`, `usr_name`, `usr_password`) VALUES
('jsmith', 'Joe Smith', '8c6df410d7e8989e98bd620983a1b1891143d1e9'),
('mjones', 'Mary Jones', 'd6a948600db12302bb2cd66c1e90b295459d8951'),
('sroberts', 'Steve Roberts', '52b52a9fd226125f6f4ae9f09a6bf1b38b8f3d9f');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
