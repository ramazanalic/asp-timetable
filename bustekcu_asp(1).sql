-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 29, 2011 at 10:20 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bustekcu_asp`
--

-- --------------------------------------------------------

--
-- Table structure for table `danipolaska`
--

CREATE TABLE IF NOT EXISTS `danipolaska` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dan` varchar(45) DEFAULT NULL,
  `polazak_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`polazak_id`),
  KEY `fk_danipolaska_polazak1` (`polazak_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `danipolaska`
--


-- --------------------------------------------------------

--
-- Table structure for table `polazak`
--

CREATE TABLE IF NOT EXISTS `polazak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vrijemepolaska` int(11) DEFAULT NULL,
  `vrijemedolaska` int(11) DEFAULT NULL,
  `pocetnastanica` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `zadnjastanica` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `vikendom` tinyint(1) DEFAULT NULL,
  `sezonski` tinyint(1) DEFAULT NULL,
  `prevoznik_id` int(11) NOT NULL,
  `prvipolazak` int(11) DEFAULT NULL,
  `zadnjipolazak` int(11) DEFAULT NULL,
  `peron` int(2) DEFAULT NULL,
  `tippolaska` varchar(1) DEFAULT NULL,
  `dnevni` tinyint(1) DEFAULT NULL,
  `periodicni` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`,`prevoznik_id`),
  KEY `fk_polazak_prevoznik1` (`prevoznik_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `polazak`
--


-- --------------------------------------------------------

--
-- Table structure for table `prevoznik`
--

CREATE TABLE IF NOT EXISTS `prevoznik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(255) DEFAULT NULL,
  `grad` varchar(255) DEFAULT NULL,
  `opis` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `prevoznik`
--


-- --------------------------------------------------------

--
-- Table structure for table `stanica`
--

CREATE TABLE IF NOT EXISTS `stanica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `stanica`
--


-- --------------------------------------------------------

--
-- Table structure for table `stopstanica`
--

CREATE TABLE IF NOT EXISTS `stopstanica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stanica_id` int(11) NOT NULL,
  `vrijemepolaska` int(11) DEFAULT NULL,
  `vrijemedolaska` int(11) DEFAULT NULL,
  `km` int(11) DEFAULT NULL,
  `polazak_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`stanica_id`,`polazak_id`),
  KEY `fk_stopstanica_stanica1` (`stanica_id`),
  KEY `fk_stopstanica_polazak1` (`polazak_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `stopstanica`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `danipolaska`
--
ALTER TABLE `danipolaska`
  ADD CONSTRAINT `fk_danipolaska_polazak1` FOREIGN KEY (`polazak_id`) REFERENCES `polazak` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `polazak`
--
ALTER TABLE `polazak`
  ADD CONSTRAINT `fk_polazak_prevoznik1` FOREIGN KEY (`prevoznik_id`) REFERENCES `prevoznik` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `stopstanica`
--
ALTER TABLE `stopstanica`
  ADD CONSTRAINT `fk_stopstanica_stanica1` FOREIGN KEY (`stanica_id`) REFERENCES `stanica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_stopstanica_polazak1` FOREIGN KEY (`polazak_id`) REFERENCES `polazak` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
