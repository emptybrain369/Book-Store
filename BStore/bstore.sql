-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 16, 2024 at 09:34 AM
-- Server version: 8.3.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `aname`, `email`, `password`, `status`) VALUES
(8, 'Zahid Hasan', 'zahidkabir181220@gmail.com', '$2y$10$lZRaRfLx8y/tJXBi4c02nuFd7DJoUQbxRNgnS5VmBmbKb6bENIGBi', 2);

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `auth_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `auth_name`) VALUES
(1, 'Kazi Nazrul Islam'),
(2, 'Rokeya Sakhawat Hossain'),
(3, 'Muhammed Zafar Iqbal'),
(4, 'Samaresh Majumdar'),
(5, 'Syed Mujtaba Ali'),
(6, ' Abdullah Abu Sayeed'),
(7, 'Mir Mosharraf Hossain'),
(8, 'Obayed Haq'),
(9, 'Zahir Raihan'),
(10, 'Manik Bandopadhyay'),
(11, 'Shirshendu Mukhopadhyay'),
(12, 'Bibhutibhushan Bandyopadhyay'),
(13, 'Rabindranath Tagore'),
(14, 'Humayun Ahmed'),
(16, 'Faridul');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `auth_id` smallint NOT NULL,
  `pub_id` smallint NOT NULL,
  `price` smallint NOT NULL,
  `status` tinyint NOT NULL,
  `img` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `bname`, `auth_id`, `pub_id`, `price`, `status`, `img`, `date`) VALUES
(2, 'Chakrabak', 1, 2, 350, 1, 'KNI-1.jpeg', '2024-11-16 09:38:00'),
(5, 'Sultana\'s Dream', 2, 3, 245, 1, 'rs-1.jpg', '2024-11-14 10:40:00'),
(7, 'Samyabadi', 1, 7, 260, 1, 'Samyabadi.jpeg', '2024-11-15 17:40:00'),
(8, 'Sanchita', 1, 2, 150, 1, 'Sanchita.jpeg', '2024-11-15 18:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
CREATE TABLE IF NOT EXISTS `publications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pub_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `auth_id` smallint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publications`
--

INSERT INTO `publications` (`id`, `pub_name`, `auth_id`) VALUES
(5, 'Sheba Prokashoni', 16),
(2, 'Sheba Prokashoni', 1),
(3, 'Onno Prokash', 2),
(6, 'Panjeri', 13),
(7, 'Onno Prokash', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
