-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2024 at 03:32 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mlm`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `First_name` varchar(50) DEFAULT NULL,
  `Last_name` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`Id`, `First_name`, `Last_name`, `Email`, `Position`, `Password`) VALUES
(1, 'test', 'test', 'test@test.test', 'test', '$argon2i$v=19$m=65536,t=4,p=1$clk3QlpEOGs5OXNFMGF6VQ$lXo6LmeN+j7DBK7X2SdBjLy5Dg5oiBcYXfV8rxqJ8a0'),
(2, 'reda', 'duieb', 'test.test@test.test', 'test1', '$argon2i$v=19$m=65536,t=4,p=1$N0wuQlc0aGVuUmwvNnZrWQ$ibifVARD4QwWwssxR+1wRKlCfRnw/b1gg0nQfN4NrMQ');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `Item_id` int NOT NULL AUTO_INCREMENT,
  `User_id_created` int DEFAULT NULL,
  `User_id_updated` int DEFAULT NULL,
  `Item_Type` varchar(255) DEFAULT NULL,
  `Item_Description` text,
  `Origin` varchar(255) DEFAULT NULL,
  `Item_Code` varchar(50) DEFAULT NULL,
  `Uom` varchar(20) DEFAULT NULL,
  `Quantity` int DEFAULT NULL,
  `Item_Received` date DEFAULT NULL,
  `Date_Of_Delivery` date DEFAULT NULL,
  `Expiry_Date` date DEFAULT NULL,
  PRIMARY KEY (`Item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_id`, `User_id_created`, `User_id_updated`, `Item_Type`, `Item_Description`, `Origin`, `Item_Code`, `Uom`, `Quantity`, `Item_Received`, `Date_Of_Delivery`, `Expiry_Date`) VALUES
(12, 1, NULL, 'Liofilehem Items', 'b', 'b', 'b', 'b', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(13, 1, NULL, 'Laboratory', 'b', 'b', 'b', 'b', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(14, 1, NULL, 'Cold Items', 'b', 'b', 'b', 'b', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(6, 1, NULL, 'Cold Items', 'a', 'a', 'a', 'a', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(7, 1, NULL, 'Chemicals Items', 'a', 'a', 'a', 'a', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(8, 1, NULL, 'Chemicals / Stains', 'a', 'a', 'a', 'a', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(9, 1, NULL, 'Disposable Gown & Couerall shoe Cover', 'a', 'a', 'a', 'a', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(10, 1, 2, 'Laboratory', 'a', 'a', 'a', 'a', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(11, 1, NULL, 'Liofilehem Items', 'a', 'a', 'a', 'a', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(15, 1, NULL, 'Chemicals Items', 'b', 'b', 'b', 'b', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(16, 1, NULL, 'Chemicals / Stains', 'b', 'b', 'b', 'b', 1, '2024-03-20', '2024-03-06', '2024-06-12'),
(25, 2, NULL, 'Disposable Gown & Couerall shoe Cover', 'b', 'b', 'b', 'b', 1, '2024-03-11', '2024-03-22', '2024-06-12');

--
-- Triggers `items`
--
DROP TRIGGER IF EXISTS `set_expiry_date`;
DELIMITER $$
CREATE TRIGGER `set_expiry_date` BEFORE INSERT ON `items` FOR EACH ROW BEGIN
    SET NEW.Expiry_Date = IFNULL(NEW.Expiry_Date, DATE_ADD(CURRENT_DATE, INTERVAL 3 MONTH));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

DROP TABLE IF EXISTS `user_notifications`;
CREATE TABLE IF NOT EXISTS `user_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT NULL,
  `alertType` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `message`, `created_at`, `is_read`, `alertType`) VALUES
(1, 1, 'info message', '2023-10-01 19:42:08', 1, 'info'),
(2, 1, 'success message', '2023-10-26 20:11:48', 1, 'success'),
(3, 1, 'warning message', '2023-10-26 20:11:48', 1, 'warning'),
(4, 1, 'danger message', '2023-10-26 20:11:48', 1, 'danger'),
(5, 1, 'primary message', '2023-10-26 20:13:40', 1, 'primary'),
(6, 1, 'secondary message', '2023-10-26 20:13:40', 1, 'secondary'),
(7, 1, 'light message', '2023-10-26 20:13:40', 1, 'light'),
(8, 1, 'dark message', '2023-10-26 20:13:40', 1, 'dark');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
