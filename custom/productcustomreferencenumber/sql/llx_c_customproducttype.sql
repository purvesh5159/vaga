-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 19, 2024 at 03:42 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dolibarr_me`
--

-- --------------------------------------------------------

--
-- Table structure for table `llx_c_customproducttype`
--

DROP TABLE IF EXISTS `vg_c_customproducttype`;
CREATE TABLE IF NOT EXISTS `vg_c_customproducttype` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) DEFAULT NULL,
  `use_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `active` int(11) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `llx_c_customproducttype`
--

INSERT INTO `vg_c_customproducttype` (`rowid`, `entity`, `code`, `label`, `position`, `use_default`, `active`) VALUES
(1, 1, 'RM', 'Raw Materials', NULL, '1', 1),
(2, 1, 'TI', 'Trading Items', NULL, '1', 1),
(3, 1, 'FG', 'Finished Goods', NULL, '1', 1),
(4, 1, 'BM', 'Bill of Materials', NULL, '1', 1),
(5, 1, 'PD', 'Product', NULL, '1', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
