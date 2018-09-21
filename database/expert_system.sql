-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.2.14-MariaDB-10.2.14+maria~jessie - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for expert_system
CREATE DATABASE IF NOT EXISTS `expert_system` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `expert_system`;


-- Dumping structure for table expert_system.diagnosis
CREATE TABLE IF NOT EXISTS `diagnosis` (
  `id` int(11) NOT NULL,
  `fk_diagnosis_group` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  KEY `Index 1` (`id`),
  KEY `FK__diagnosis_group` (`fk_diagnosis_group`),
  CONSTRAINT `FK__diagnosis_group` FOREIGN KEY (`fk_diagnosis_group`) REFERENCES `diagnosis_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table expert_system.diagnosis_group
CREATE TABLE IF NOT EXISTS `diagnosis_group` (
  `id` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `parent_diagnosis` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table expert_system.display_symptoms
CREATE TABLE IF NOT EXISTS `display_symptoms` (
  `id` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `symptoms_group` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table expert_system.symptoms
CREATE TABLE IF NOT EXISTS `symptoms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
