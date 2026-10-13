-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.33 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for lion_cinema_db
CREATE DATABASE IF NOT EXISTS `lion_cinema_db` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `lion_cinema_db`;

-- Dumping structure for table lion_cinema_db.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `registered_date` datetime DEFAULT NULL,
  `vcode` varchar(20) DEFAULT NULL,
  `status_status_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_admin_status1_idx` (`status_status_id`),
  CONSTRAINT `fk_admin_status1` FOREIGN KEY (`status_status_id`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.admin: ~4 rows (approximately)
INSERT INTO `admin` (`fname`, `lname`, `email`, `password`, `mobile`, `registered_date`, `vcode`, `status_status_id`) VALUES
	('Ishan', 'Tharuka', 'ishan@gmail.com', 'ishan123', '0778123533', '2024-05-30 09:52:12', NULL, 1),
	('Malinda', 'Dasanayaka', 'malindadasanayaka@gmail.com', 'LionCinema@2026', '0771234567', '2024-05-25 13:15:34', '666162b6ac87c', 1),
	('Sahan', 'Perera', 'sahan@gmail.com', 'sahan123', '0778185778', '2024-05-25 13:27:36', NULL, 2),
	('Dilan', 'Ravindu', 'tytydilan8@gmail.com', 'Dilan1234', '0778185779', '2024-05-25 13:21:12', '6651e78246bbb', 1);

-- Dumping structure for table lion_cinema_db.admin_profile_img
CREATE TABLE IF NOT EXISTS `admin_profile_img` (
  `admin_path` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  PRIMARY KEY (`admin_path`),
  KEY `fk_admin_profile_img_admin1_idx` (`admin_email`),
  CONSTRAINT `fk_admin_profile_img_admin1` FOREIGN KEY (`admin_email`) REFERENCES `admin` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.admin_profile_img: ~1 rows (approximately)
INSERT INTO `admin_profile_img` (`admin_path`, `admin_email`) VALUES
	('resource//profile_images//6661670a59a1f.png', 'malindadasanayaka@gmail.com');

-- Dumping structure for table lion_cinema_db.availability
CREATE TABLE IF NOT EXISTS `availability` (
  `availability_id` int NOT NULL AUTO_INCREMENT,
  `availability` varchar(20) NOT NULL,
  PRIMARY KEY (`availability_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.availability: ~2 rows (approximately)
INSERT INTO `availability` (`availability_id`, `availability`) VALUES
	(1, 'Released'),
	(2, 'Coming Soon');

-- Dumping structure for table lion_cinema_db.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `cart_qty` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `fk_cart_product1_idx` (`product_id`),
  KEY `fk_cart_user1_idx` (`user_email`),
  CONSTRAINT `fk_cart_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.cart: ~2 rows (approximately)
INSERT INTO `cart` (`cart_id`, `cart_qty`, `product_id`, `user_email`) VALUES
	(75, 1, 11, 'akalanka@gmail.com');

-- Dumping structure for table lion_cinema_db.category
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.category: ~10 rows (approximately)
INSERT INTO `category` (`category_id`, `category_name`) VALUES
	(1, 'Action'),
	(2, 'Comedy'),
	(3, 'Drama'),
	(4, 'Adventure'),
	(5, 'Sci-Fi'),
	(6, 'Fantasy'),
	(7, 'Thriller'),
	(8, 'Horror'),
	(9, 'Romance'),
	(10, 'Animation');

-- Dumping structure for table lion_cinema_db.delivery_status
CREATE TABLE IF NOT EXISTS `delivery_status` (
  `d_id` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) NOT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.delivery_status: ~6 rows (approximately)
INSERT INTO `delivery_status` (`d_id`, `status_name`) VALUES
	(1, 'Waiting to Accept'),
	(2, 'Accepted'),
	(3, 'Waiting for Delivery'),
	(4, 'Delivered'),
	(5, 'Cancelled'),
	(6, 'Denied');

-- Dumping structure for table lion_cinema_db.district
CREATE TABLE IF NOT EXISTS `district` (
  `district_id` int NOT NULL AUTO_INCREMENT,
  `district_name` varchar(45) NOT NULL,
  `delivery_cost` double DEFAULT NULL,
  `province_province_id` int NOT NULL,
  PRIMARY KEY (`district_id`),
  KEY `fk_district_province1_idx` (`province_province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_province_id`) REFERENCES `province` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.district: ~25 rows (approximately)
INSERT INTO `district` (`district_id`, `district_name`, `delivery_cost`, `province_province_id`) VALUES
	(1, 'Colombo', 250, 1),
	(2, 'Gampaha', 250, 1),
	(3, 'Kalutara', 300, 1),
	(4, 'Galle', 350, 2),
	(5, 'Matara', 350, 2),
	(6, 'Hambantota', 350, 2),
	(7, 'Kandy', 250, 3),
	(8, 'Matale', 250, 3),
	(9, 'Nuwara Eliya', 300, 3),
	(10, 'Kurunegala', 200, 4),
	(11, 'Puttalam', 250, 4),
	(12, 'Anuradhapura', 300, 5),
	(13, 'Polonnaruwa', 300, 5),
	(14, 'Kegalle', 250, 6),
	(15, 'Ratnapura', 300, 6),
	(16, 'Badulla', 300, 7),
	(17, 'Monaragala', 350, 7),
	(18, 'Trincomalee', 300, 8),
	(19, 'Batticaloa', 350, 8),
	(20, 'Ampara', 300, 8),
	(21, 'Jaffna', 400, 9),
	(22, 'Kilinochchi', 350, 9),
	(23, 'Mannar', 300, 9),
	(24, 'Mullaitivu', 300, 9),
	(25, 'Vavuniya', 300, 9);

-- Dumping structure for table lion_cinema_db.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `feed_id` int NOT NULL AUTO_INCREMENT,
  `type` int DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `feed` varchar(250) DEFAULT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`feed_id`),
  KEY `fk_feedback_product1_idx` (`product_id`),
  KEY `fk_feedback_user1_idx` (`user_email`),
  CONSTRAINT `fk_feedback_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_feedback_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.feedback: ~8 rows (approximately)
INSERT INTO `feedback` (`feed_id`, `type`, `date`, `feed`, `product_id`, `user_email`) VALUES
	(16, 1, '2024-05-30 17:02:40', 'Good Movie', 11, 'malindadasanayaka@gmail.com'),
	(17, 1, '2024-05-30 17:02:58', 'Superb movie', 15, 'malindadasanayaka@gmail.com'),
	(18, 2, '2024-05-30 17:03:44', 'Its OK', 11, 'malindadasanayaka@gmail.com'),
	(19, 1, '2024-05-30 17:05:45', 'Supiri', 15, 'malindadasanayaka@gmail.com'),
	(28, 3, '2024-05-30 18:19:52', 'DVD is currupted', 11, 'malindadasanayaka@gmail.com'),
	(29, 2, '2024-05-30 18:20:45', 'Its OK', 15, 'malindadasanayaka@gmail.com'),
	(30, 3, '2024-05-30 18:24:55', 'DVD eka wada na', 12, 'malindadasanayaka@gmail.com'),
	(31, 3, '2024-05-30 18:25:14', 'Hithapu tharam set na', 12, 'malindadasanayaka@gmail.com'),
	(32, 2, '2024-05-30 18:25:27', 'Hodai', 12, 'malindadasanayaka@gmail.com'),
	(33, 1, '2024-05-31 11:44:40', 'Good', 21, 'malindadasanayaka@gmail.com'),
	(34, 1, '2024-06-05 15:12:56', 'Supiri', 11, 'malindadasanayaka@gmail.com'),
	(35, 1, '2024-06-06 10:20:01', 'Supiri', 16, 'malindadasanayaka@gmail.com'),
	(36, 1, '2024-06-06 10:25:47', 'Maru', 11, 'malindadasanayaka@gmail.com'),
	(37, 1, '2024-06-06 10:27:13', 'CORA', 11, 'malindadasanayaka@gmail.com'),
	(38, 1, '2024-06-06 11:49:52', 'Supiri', 14, 'malindadasanayaka@gmail.com'),
	(39, 1, '2024-06-06 11:50:26', 'Supiri', 14, 'malindadasanayaka@gmail.com');

-- Dumping structure for table lion_cinema_db.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `gender_id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) NOT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.gender: ~2 rows (approximately)
INSERT INTO `gender` (`gender_id`, `gender_name`) VALUES
	(1, 'Male'),
	(2, 'Female');

-- Dumping structure for table lion_cinema_db.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int NOT NULL AUTO_INCREMENT,
  `qty` int DEFAULT NULL,
  `order_oid` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `fk_invoice_product1_idx` (`product_id`),
  KEY `fk_invoice_order1_idx` (`order_oid`),
  CONSTRAINT `fk_invoice_order1` FOREIGN KEY (`order_oid`) REFERENCES `order` (`oid`),
  CONSTRAINT `fk_invoice_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.invoice: ~52 rows (approximately)
INSERT INTO `invoice` (`invoice_id`, `qty`, `order_oid`, `product_id`) VALUES
	(23, 2, 1, 11),
	(24, 3, 1, 26),
	(25, 2, 1, 18),
	(26, 1, 2, 11),
	(27, 1, 3, 11),
	(28, 1, 4, 11),
	(29, 1, 5, 11),
	(30, 1, 6, 11),
	(31, 2, 7, 13),
	(32, 1, 8, 13),
	(33, 1, 9, 11),
	(34, 1, 9, 26),
	(35, 2, 9, 12),
	(36, 2, 9, 19),
	(37, 1, 10, 11),
	(38, 1, 10, 15),
	(39, 1, 10, 28),
	(40, 1, 11, 19),
	(41, 1, 11, 18),
	(42, 1, 11, 11),
	(43, 1, 11, 24),
	(44, 1, 11, 13),
	(45, 1, 11, 29),
	(46, 1, 12, 22),
	(47, 1, 13, 11),
	(48, 3, 14, 24),
	(49, 7, 15, 19),
	(50, 1, 16, 32),
	(51, 6, 17, 32),
	(52, 1, 18, 32),
	(53, 1, 19, 32),
	(54, 1, 19, 11),
	(55, 1, 19, 15),
	(56, 1, 20, 19),
	(57, 1, 20, 13),
	(58, 1, 20, 22),
	(59, 1, 20, 20),
	(60, 1, 20, 12),
	(61, 1, 20, 26),
	(62, 2, 21, 11),
	(63, 2, 21, 26),
	(64, 2, 21, 12),
	(65, 1, 22, 32),
	(66, 1, 22, 16),
	(67, 1, 22, 14),
	(68, 1, 23, 32),
	(69, 1, 23, 11),
	(70, 1, 23, 15),
	(71, 2, 24, 11),
	(72, 1, 24, 32),
	(73, 1, 24, 15),
	(74, 1, 24, 19),
	(75, 6, 25, 22);

-- Dumping structure for table lion_cinema_db.language
CREATE TABLE IF NOT EXISTS `language` (
  `language_id` int NOT NULL AUTO_INCREMENT,
  `language_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.language: ~0 rows (approximately)
INSERT INTO `language` (`language_id`, `language_name`) VALUES
	(1, 'English'),
	(2, 'Sinhala');

-- Dumping structure for table lion_cinema_db.order
CREATE TABLE IF NOT EXISTS `order` (
  `oid` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(45) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `history_status` int DEFAULT NULL,
  `delivery_status_d_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `fk_order_delivery_status1_idx` (`delivery_status_d_id`),
  KEY `fk_order_user1_idx` (`user_email`),
  CONSTRAINT `fk_order_delivery_status1` FOREIGN KEY (`delivery_status_d_id`) REFERENCES `delivery_status` (`d_id`),
  CONSTRAINT `fk_order_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.order: ~23 rows (approximately)
INSERT INTO `order` (`oid`, `order_id`, `order_date`, `amount`, `history_status`, `delivery_status_d_id`, `user_email`) VALUES
	(1, '665fd99497f48', '2024-06-01 08:51:41', 3500, 1, 5, 'malindadasanayaka@gmail.com'),
	(2, '665fdaf209073', '2024-06-01 08:57:04', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(3, '665fdc5ad03e1', '2024-06-01 09:03:12', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(4, '665fdcd34dd6d', '2024-06-01 09:05:06', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(5, '665fe879d739d', '2024-06-02 09:54:54', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(6, '665fe8e113fa1', '2024-06-02 09:56:34', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(7, '665fe9677d6a3', '2024-06-02 09:58:43', 1200, 0, 1, 'malindadasanayaka@gmail.com'),
	(8, '665ff0c4b39ab', '2024-06-02 10:30:16', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(9, '665ff4564c544', '2024-06-03 10:45:31', 3000, 0, 1, 'malindadasanayaka@gmail.com'),
	(10, '665ffb047f605', '2024-06-03 11:14:02', 1900, 0, 1, 'malindadasanayaka@gmail.com'),
	(11, '665ffc1d975f2', '2024-06-03 11:18:33', 3200, 0, 1, 'malindadasanayaka@gmail.com'),
	(12, '665ffc850837f', '2024-06-03 11:20:18', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(13, '66600028a56c0', '2024-06-04 11:35:58', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(14, '6660005b7cdcc', '2024-06-04 11:36:40', 1700, 0, 1, 'malindadasanayaka@gmail.com'),
	(15, '66600081d2387', '2024-06-04 11:37:36', 3500, 0, 5, 'malindadasanayaka@gmail.com'),
	(16, '6660038b83c9e', '2024-06-04 11:50:21', 700, 0, 1, 'malindadasanayaka@gmail.com'),
	(17, '666003d8e1420', '2024-06-05 11:51:32', 3000, 0, 1, 'malindadasanayaka@gmail.com'),
	(18, '6660040926212', '2024-06-05 11:52:22', 700, 0, 3, 'malindadasanayaka@gmail.com'),
	(19, '66600435a4586', '2024-06-05 11:53:04', 1700, 0, 4, 'malindadasanayaka@gmail.com'),
	(20, '666004a00a158', '2024-06-05 11:54:54', 3000, 0, 1, 'malindadasanayaka@gmail.com'),
	(21, '666004dc2e635', '2024-06-05 11:55:58', 3000, 0, 4, 'malindadasanayaka@gmail.com'),
	(22, '6660050bdccc4', '2024-06-05 11:56:43', 1700, 0, 4, 'malindadasanayaka@gmail.com'),
	(23, '666007898f280', '2024-06-05 12:07:31', 1700, 0, 5, 'malindadasanayaka@gmail.com'),
	(24, '666170189c20a', '2024-06-06 13:46:06', 2700, 1, 1, 'malindadasanayaka@gmail.com'),
	(25, '66617089f09a9', '2024-06-06 13:47:35', 3000, 1, 1, 'malindadasanayaka@gmail.com');

-- Dumping structure for table lion_cinema_db.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `imdb_rating` double DEFAULT NULL,
  `qty_available` int DEFAULT NULL,
  `qty_sold` int DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount_percentage` int DEFAULT NULL,
  `datetime_added` datetime DEFAULT NULL,
  `released_date` date DEFAULT NULL,
  `runtime` varchar(45) DEFAULT NULL,
  `type_type_id` int NOT NULL,
  `category_category_id` int NOT NULL,
  `language_language_id` int NOT NULL,
  `availability_availability_id` int NOT NULL,
  `status_status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_type1_idx` (`type_type_id`),
  KEY `fk_product_category1_idx` (`category_category_id`),
  KEY `fk_product_availability1_idx` (`availability_availability_id`),
  KEY `fk_product_language1_idx` (`language_language_id`),
  KEY `fk_product_status1_idx` (`status_status_id`),
  CONSTRAINT `fk_product_availability1` FOREIGN KEY (`availability_availability_id`) REFERENCES `availability` (`availability_id`),
  CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_category_id`) REFERENCES `category` (`category_id`),
  CONSTRAINT `fk_product_language1` FOREIGN KEY (`language_language_id`) REFERENCES `language` (`language_id`),
  CONSTRAINT `fk_product_status1` FOREIGN KEY (`status_status_id`) REFERENCES `status` (`status_id`),
  CONSTRAINT `fk_product_type1` FOREIGN KEY (`type_type_id`) REFERENCES `type` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.product: ~21 rows (approximately)
INSERT INTO `product` (`id`, `title`, `description`, `imdb_rating`, `qty_available`, `qty_sold`, `price`, `discount_percentage`, `datetime_added`, `released_date`, `runtime`, `type_type_id`, `category_category_id`, `language_language_id`, `availability_availability_id`, `status_status_id`) VALUES
	(11, 'Avengers - Endgame', 'After the devastating events of Avengers: Infinity War, the universe is in ruins due to the efforts of the Mad Titan, Thanos. With the help of remaining allies, the Avengers must assemble once more in order to undo Thanos actions and restore order to the universe once and for all, no matter what consequences may be in store.', 8.4, 9985, 15, 500, 10, '2024-05-26 18:40:06', '2019-04-26', '3h 1m', 1, 1, 1, 1, 1),
	(12, 'Mad Max - Fury Road', 'An apocalyptic story set in the furthest reaches of our planet, in a stark desert landscape where humanity is broken, and most everyone is crazed fighting for the necessities of life. Within this world exist two rebels on the run who just might be able to restore order.', 8.1, 9973, 27, 500, 10, '2024-05-26 18:51:16', '2015-05-14', '2h 1m', 1, 1, 1, 1, 1),
	(13, 'The Dark Knight', 'Batman raises the stakes in his war on crime. With the help of Lt. Jim Gordon and District Attorney Harvey Dent, Batman sets out to dismantle the remaining criminal organizations that plague the streets. The partnership proves to be effective, but they soon find themselves prey to a reign of chaos unleashed by a rising criminal mastermind known to the terrified citizens of Gotham as the Joker.', 9, 10000, 0, 500, 10, '2024-05-26 18:55:52', '2008-07-18', '2h 32m', 1, 1, 1, 1, 1),
	(14, 'The Terminator', 'In the post-apocalyptic future, reigning tyrannical supercomputers teleport a cyborg assassin known as the "Terminator" back to 1984 to kill Sarah Connor, whose unborn son is destined to lead insurgents against 21st century mechanical hegemony. Meanwhile, the human-resistance movement dispatches a lone warrior to safeguard Sarah. Can he stop the virtually indestructible killing machine?', 8.1, 9998, 3, 500, 10, '2024-05-26 19:01:08', '2024-01-01', 'TBA', 1, 1, 1, 2, 1),
	(15, 'John Wick', 'Ex-hitman John Wick comes out of retirement to track down the gangsters that took everything from him.', 7.4, 9999, 1, 500, 10, '2024-05-26 19:04:18', '2014-10-24', '1h 41m', 1, 1, 1, 1, 1),
	(16, 'The Hangover', 'When three friends finally come to after a raucous night of bachelor-party revelry, they find a baby in the closet and a tiger in the bathroom. But they cant seem to locate their best friend, Doug – whos supposed to be tying the knot. Launching a frantic search for Doug, the trio perseveres through a nasty hangover to try to make it to the church on time.', 7.7, 10000, 1, 500, 10, '2024-05-26 19:10:03', '2009-06-05', '1h 40m', 1, 2, 1, 2, 1),
	(17, 'Superbad', 'Two co-dependent high school seniors are forced to deal with separation anxiety after their plan to stage a booze-soaked party goes awry.', 7.6, 0, 100, 500, 10, '2024-05-26 19:13:52', '2007-08-17', '1h 53m', 1, 2, 1, 1, 1),
	(18, 'Titanic', '101-year-old Rose DeWitt Bukater tells the story of her life aboard the Titanic, 84 years later. A young Rose boards the ship with her mother and fiancé. Meanwhile, Jack Dawson and Fabrizio De Rossi win third-class tickets aboard the ship. Rose tells the whole story from Titanics departure through to its death—on its first and last voyage—on April 15, 1912.', 7.9, 9800, 200, 500, 10, '2024-05-26 19:17:52', '1997-12-19', '3h 14m', 1, 3, 1, 1, 1),
	(19, 'The Godfather', 'Spanning the years 1945 to 1955, a chronicle of the fictional Italian-American Corleone crime family. When organized crime family patriarch, Vito Corleone barely survives an attempt on his life, his youngest son, Michael steps in to take care of the would-be killers, launching a campaign of bloody revenge.', 9.2, 9998, 302, 500, 10, '2024-05-26 19:20:52', '1972-03-24', '2h 55m', 1, 3, 1, 1, 1),
	(20, 'Pirates of the Caribbean', 'Jack Sparrow, a freewheeling 18th-century pirate, quarrels with a rival pirate bent on pillaging Port Royal. When the governors daughter is kidnapped, Sparrow decides to help the girls love save her.', 8.1, 9992, 8, 500, 10, '2024-05-26 19:25:28', '2003-07-03', '2h 23m', 1, 4, 1, 1, 1),
	(21, 'Jurassic Park', 'A wealthy entrepreneur secretly creates a theme park featuring living dinosaurs drawn from prehistoric DNA. Before opening day, he invites a team of experts and his two eager grandchildren to experience the park and help calm anxious investors. However, the park is anything but amusing as the security systems go off-line and the dinosaurs escape.', 8.2, 100, 4, 500, 10, '2024-05-26 19:28:40', '1994-04-15', '2h 7m', 1, 4, 1, 1, 1),
	(22, 'The Matrix', 'Set in the 22nd century, The Matrix tells the story of a computer hacker who joins a group of underground insurgents fighting the vast and powerful computers who now rule the earth.', 8.7, 9990, 10, 500, 10, '2024-05-26 19:31:57', '1999-03-31', '2h 16m', 1, 5, 1, 1, 1),
	(23, 'Harry Potter', 'Harry Potter has lived under the stairs at his aunt and uncles house his whole life. But on his 11th birthday, he learns hes a powerful wizard—with a place waiting for him at the Hogwarts School of Witchcraft and Wizardry. As he learns to harness his newfound powers with the help of the schools kindly headmaster, Harry uncovers the truth about his parents deaths—and about the villain whos to blame.', 7.6, 10000, 0, 500, 10, '2024-05-26 19:40:22', '2001-11-16', '2h 32m', 1, 6, 1, 1, 1),
	(24, 'Gone Girl', 'With his wifes disappearance having become the focus of an intense media circus, a man sees the spotlight turned on him when its suspected that he may not be innocent.', 8.1, 9987, 13, 500, 10, '2024-05-26 19:44:27', '2014-10-03', '2h 29m', 1, 7, 1, 1, 1),
	(25, 'Scream', 'After a series of mysterious deaths befalls their small town, an offbeat group of friends led by Sidney Prescott become the target of a masked killer.', 7.4, 10000, 0, 500, 10, '2024-05-26 19:47:41', '1996-12-20', '1h 52m', 1, 8, 1, 1, 1),
	(26, 'La La Land', 'Mia, an aspiring actress, serves lattes to movie stars in between auditions and Sebastian, a jazz musician, scrapes by playing cocktail party gigs in dingy bars, but as success mounts they are faced with decisions that begin to fray the fragile fabric of their love affair, and the dreams they worked so hard to maintain in each other threaten to rip them apart.', 8, 9975, 25, 500, 10, '2024-05-26 19:51:01', '2016-12-09', '2h 9m', 1, 9, 1, 1, 1),
	(27, 'Shrek', 'It aint easy bein green -- especially if youre a likable (albeit smelly) ogre named Shrek. On a mission to retrieve a gorgeous princess from the clutches of a fire-breathing dragon, Shrek teams up with an unlikely compatriot -- a wisecracking donkey.', 7.9, 10000, 0, 500, 10, '2024-05-26 19:55:09', '2001-05-18', '1h 30m', 1, 10, 1, 1, 1),
	(28, 'Arrow - Season 01', 'Spoiled billionaire playboy Oliver Queen is missing and presumed dead when his yacht is lost at sea. He returns five years later a changed man, determined to clean up the city as a hooded vigilante armed with a bow.', 7.5, 10001, -1, 700, 10, '2024-05-26 20:02:54', '2012-01-01', 'About 42 min per Episode', 2, 1, 1, 1, 1),
	(29, 'Breaking Bad - Season 01', 'Walter White, a New Mexico chemistry teacher, is diagnosed with Stage III cancer and given a prognosis of only two years left to live. He becomes filled with a sense of fearlessness and an unrelenting desire to secure his familys financial future at any cost as he enters the dangerous world of drugs and crime.', 9.5, 9999, 1, 700, 10, '2024-05-26 20:07:42', '2008-01-01', 'About 48 min per Episode', 2, 3, 1, 1, 1),
	(30, 'Game of Thrones - Season 01', 'Seven noble families fight for control of the mythical land of Westeros. Friction between the houses leads to full-scale war. All while a very ancient evil awakens in the farthest north. Amidst the war, a neglected military order of misfits, the Nights Watch, is all that stands between the realms of men and icy horrors beyond.', 9.2, 9998, 2, 700, 10, '2024-05-26 21:03:40', '2011-01-01', 'About 59 min Per Episode', 2, 3, 1, 1, 1),
	(32, 'Deadpool & Wolverine', 'A listless Wade Wilson toils away in civilian life with his days as the morally flexible mercenary, Deadpool, behind him. But when his homeworld faces an existential threat, Wade must reluctantly suit-up again with an even more reluctant Wolverine.', 0, 10000, 13, 500, 10, '2024-05-30 13:54:59', '2024-01-01', 'TBA', 1, 2, 1, 2, 1);

-- Dumping structure for table lion_cinema_db.product_img
CREATE TABLE IF NOT EXISTS `product_img` (
  `img_path` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`img_path`),
  KEY `fk_product_img_product1_idx` (`product_id`),
  CONSTRAINT `fk_product_img_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.product_img: ~63 rows (approximately)
INSERT INTO `product_img` (`img_path`, `product_id`) VALUES
	('resource//product_images//Avengers - Endgame_0_665400ad145f8.jpeg', 11),
	('resource//product_images//Avengers - Endgame_1_665400ad14c58.jpeg', 11),
	('resource//product_images//Avengers - Endgame_2_665400ad1522e.jpeg', 11),
	('resource//product_images//Mad Max - Fury Road_0_6653ff4f8f09b.jpeg', 12),
	('resource//product_images//Mad Max - Fury Road_1_6653ff4f8f832.jpeg', 12),
	('resource//product_images//Mad Max - Fury Road_2_6653ff4f9008b.jpeg', 12),
	('resource//product_images//The Dark Knight_0_6653386055269.jpeg', 13),
	('resource//product_images//The Dark Knight_1_6653386055b6d.jpeg', 13),
	('resource//product_images//The Dark Knight_2_6653386056272.jpeg', 13),
	('resource//product_images//The Terminator_0_6653399c16516.jpeg', 14),
	('resource//product_images//The Terminator_1_6653399c16efb.jpeg', 14),
	('resource//product_images//The Terminator_2_6653399c177f6.jpeg', 14),
	('resource//product_images//John Wick_0_66533a5b053ef.jpeg', 15),
	('resource//product_images//John Wick_1_66533a5b0615b.jpeg', 15),
	('resource//product_images//John Wick_2_66533a5b06e2e.jpeg', 15),
	('resource//product_images//The Hangover_0_66533bb3e93f6.jpeg', 16),
	('resource//product_images//The Hangover_1_66533bb3e9eb8.jpeg', 16),
	('resource//product_images//The Hangover_2_66533bb3ea86f.jpeg', 16),
	('resource//product_images//Superbad_0_66533c98acaad.jpeg', 17),
	('resource//product_images//Superbad_1_66533c98ad402.jpeg', 17),
	('resource//product_images//Superbad_2_66533c98add04.jpeg', 17),
	('resource//product_images//Titanic_0_66533d885c0f4.jpeg', 18),
	('resource//product_images//Titanic_1_66533d885cb02.jpeg', 18),
	('resource//product_images//Titanic_2_66533d885d4c7.jpeg', 18),
	('resource//product_images//The Godfather_0_66533e3cc988e.jpeg', 19),
	('resource//product_images//The Godfather_1_66533e3cca292.jpeg', 19),
	('resource//product_images//The Godfather_2_66533e3ccacbe.jpeg', 19),
	('resource//product_images//Pirates of the Caribbean_0_665400e1a48a3.jpeg', 20),
	('resource//product_images//Pirates of the Caribbean_1_665400e1a5244.jpeg', 20),
	('resource//product_images//Pirates of the Caribbean_2_665400e1a598c.jpeg', 20),
	('resource//product_images//Jurassic Park_0_66534010cc91f.jpeg', 21),
	('resource//product_images//Jurassic Park_1_66534010cd1ed.jpeg', 21),
	('resource//product_images//Jurassic Park_2_66534010cd9a3.jpeg', 21),
	('resource//product_images//The Matrix_0_665340d5d0d07.jpeg', 22),
	('resource//product_images//The Matrix_1_665340d5d16f8.jpeg', 22),
	('resource//product_images//The Matrix_2_665340d5d21e0.jpeg', 22),
	('resource//product_images//Harry Potter and the Sorcerer s Stone_0_665342ceb6b32.jpeg', 23),
	('resource//product_images//Harry Potter and the Sorcerer s Stone_1_665342ceb7584.jpeg', 23),
	('resource//product_images//Harry Potter and the Sorcerer s Stone_2_665342ceb7edf.jpeg', 23),
	('resource//product_images//Gone Girl_0_665343c38d135.jpeg', 24),
	('resource//product_images//Gone Girl_1_665343c38dc8e.jpeg', 24),
	('resource//product_images//Gone Girl_2_665343c38e62c.jpeg', 24),
	('resource//product_images//Scream_0_6653448556dfa.jpeg', 25),
	('resource//product_images//Scream_1_6653448557710.jpeg', 25),
	('resource//product_images//Scream_2_6653448558032.jpeg', 25),
	('resource//product_images//La La Land_0_6653454d90eb6.jpeg', 26),
	('resource//product_images//La La Land_1_6653454d918b4.jpeg', 26),
	('resource//product_images//La La Land_2_6653454d921db.jpeg', 26),
	('resource//product_images//Shrek_0_665346459c0ff.jpeg', 27),
	('resource//product_images//Shrek_1_665346459d359.jpeg', 27),
	('resource//product_images//Shrek_2_665346459db46.jpeg', 27),
	('resource//product_images//Arrow - Season 01_0_6653ffb7cc8d5.jpeg', 28),
	('resource//product_images//Arrow - Season 01_1_6653ffb7cd0d0.jpeg', 28),
	('resource//product_images//Arrow - Season 01_2_6653ffb7cd7da.jpeg', 28),
	('resource//product_images//Breaking Bad - Season 01_0_6653ffcdf242b.jpeg', 29),
	('resource//product_images//Breaking Bad - Season 01_1_6653ffcdf3560.jpeg', 29),
	('resource//product_images//Breaking Bad - Season 01_2_6653ffcdf3dcb.jpeg', 29),
	('resource//product_images//Game of Thrones - Season 01_0_665356543f81e.jpeg', 30),
	('resource//product_images//Game of Thrones - Season 01_1_665356544017a.jpeg', 30),
	('resource//product_images//Game of Thrones - Season 01_2_6653565441303.jpeg', 30),
	('resource//product_images//Deadpool & Wolverine_0_665837dbe6f10.jpeg', 32),
	('resource//product_images//Deadpool & Wolverine_1_665837dbe7a3e.jpeg', 32),
	('resource//product_images//Deadpool & Wolverine_2_665837dbe844a.jpeg', 32);

-- Dumping structure for table lion_cinema_db.profile_img
CREATE TABLE IF NOT EXISTS `profile_img` (
  `path` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_profile_img_user1_idx` (`user_email`),
  CONSTRAINT `fk_profile_img_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.profile_img: ~1 rows (approximately)
INSERT INTO `profile_img` (`path`, `user_email`) VALUES
	('resource//profile_images//666155e0d1ee1.png', 'malindadasanayaka@gmail.com');

-- Dumping structure for table lion_cinema_db.province
CREATE TABLE IF NOT EXISTS `province` (
  `province_id` int NOT NULL AUTO_INCREMENT,
  `province_name` varchar(45) NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.province: ~8 rows (approximately)
INSERT INTO `province` (`province_id`, `province_name`) VALUES
	(1, 'Western Province'),
	(2, 'Southern Province'),
	(3, 'Central Province'),
	(4, 'North Western Province'),
	(5, 'North Central Province'),
	(6, 'Sabaragamuwa Province'),
	(7, 'Uva Province'),
	(8, 'Eastern Province'),
	(9, 'Northern Province');

-- Dumping structure for table lion_cinema_db.status
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.status: ~2 rows (approximately)
INSERT INTO `status` (`status_id`, `status`) VALUES
	(1, 'Active'),
	(2, 'Inactive');

-- Dumping structure for table lion_cinema_db.super_admin
CREATE TABLE IF NOT EXISTS `super_admin` (
  `fname` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `vcode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.super_admin: ~0 rows (approximately)
INSERT INTO `super_admin` (`fname`, `email`, `vcode`) VALUES
	('Malinda', 'malindadasanayaka@gmail.com', '66616bcfc5cfa');

-- Dumping structure for table lion_cinema_db.trailer
CREATE TABLE IF NOT EXISTS `trailer` (
  `trailer_link` varchar(500) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`trailer_link`),
  KEY `fk_trailer_product1_idx` (`product_id`),
  CONSTRAINT `fk_trailer_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.trailer: ~1 rows (approximately)
INSERT INTO `trailer` (`trailer_link`, `product_id`) VALUES
	('TcMBFSGVi1c?si=Tt255AUKcL9cjZY6', 11);

-- Dumping structure for table lion_cinema_db.type
CREATE TABLE IF NOT EXISTS `type` (
  `type_id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.type: ~4 rows (approximately)
INSERT INTO `type` (`type_id`, `type`) VALUES
	(1, 'Movie'),
	(2, 'TV Series'),
	(3, 'Bundle (Movies)'),
	(4, 'Bundle (TV Series)');

-- Dumping structure for table lion_cinema_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `joined_date` datetime NOT NULL,
  `verification_code` varchar(20) DEFAULT NULL,
  `gender_gender_id` int NOT NULL,
  `status_status_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_user_gender_idx` (`gender_gender_id`),
  KEY `fk_user_status1_idx` (`status_status_id`),
  CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender_gender_id`) REFERENCES `gender` (`gender_id`),
  CONSTRAINT `fk_user_status1` FOREIGN KEY (`status_status_id`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.user: ~11 rows (approximately)
INSERT INTO `user` (`fname`, `lname`, `email`, `password`, `mobile`, `joined_date`, `verification_code`, `gender_gender_id`, `status_status_id`) VALUES
	('Thaveesha', 'Akalanka', 'akalanka@gmail.com', 'ak47@thavee', '0725183549', '2024-05-30 09:33:06', NULL, 1, 1),
	('Chethana', 'Lakshani', 'chethana@gmail.com', 'chetha123', '0778152488', '2024-05-25 10:28:15', NULL, 2, 1),
	('Dinuja', 'Heshan', 'dinuja@gmail.com', 'dinuja123', '0761122345', '2024-05-30 09:36:49', NULL, 1, 1),
	('Janith', 'Silva', 'janith@gmail.com', 'janith123', '0789255276', '2024-06-01 10:15:32', NULL, 1, 1),
	('Malinda', 'Maduhansa', 'malinda@gmail.com', 'malinda1234', '0753348652', '2024-05-30 09:33:51', NULL, 1, 1),
	('Nimsara', 'Yuwanga', 'nimsara@gmail.com', 'nimsara1234', '0765419824', '2024-05-30 09:36:05', NULL, 1, 1),
	('Pasan', 'Piyumika', 'pasan@gmail.com', 'pasan123', '0789255624', '2024-06-01 18:00:56', NULL, 1, 1),
	('Ravindu', 'Dilshan', 'ravid@2345gmail.com', 'fdyutyu477', '0778172481', '2024-05-25 10:24:58', NULL, 1, 1),
	('Malinda', 'Dasanayaka', 'malindadasanayaka@gmail.com', 'LionCinema@2026', '0771234567', '2024-05-25 10:21:04', '6661612abf653', 1, 1),
	('Sahan', 'Gunasekara', 'sahan@gmail.com', 'sahan123', '0778822564', '2024-05-30 09:31:22', NULL, 1, 1),
	('Savindu', 'Dilan', 'savindudilan126@gmail.com', '111111111', '0777181999', '2024-05-25 10:27:26', NULL, 1, 1),
	('Ravindu', 'Dilan', 'tytydilan8@gmail.com', 'Ravid@2357', '0778176455', '2024-05-25 10:22:59', NULL, 1, 1),
	('Yasiru', 'Samuditha', 'yasiru@gmail.com', 'yasiru123', '0712547956', '2024-05-30 09:32:08', NULL, 1, 2);

-- Dumping structure for table lion_cinema_db.user_has_address
CREATE TABLE IF NOT EXISTS `user_has_address` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `line1` text,
  `line2` text,
  `city` varchar(50) NOT NULL,
  `postal_code` int NOT NULL,
  `district_district_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `fk_user_has_address_district1_idx` (`district_district_id`),
  KEY `fk_user_has_address_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_has_address_district1` FOREIGN KEY (`district_district_id`) REFERENCES `district` (`district_id`),
  CONSTRAINT `fk_user_has_address_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.user_has_address: ~0 rows (approximately)
INSERT INTO `user_has_address` (`address_id`, `line1`, `line2`, `city`, `postal_code`, `district_district_id`, `user_email`) VALUES
	(1, 'No 147, 2nd Lane', 'Green Valley State', 'Horombawa', 60181, 10, 'malindadasanayaka@gmail.com');

-- Dumping structure for table lion_cinema_db.watchlist
CREATE TABLE IF NOT EXISTS `watchlist` (
  `watchlist_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`watchlist_id`),
  KEY `fk_watchlist_product1_idx` (`product_id`),
  KEY `fk_watchlist_user1_idx` (`user_email`),
  CONSTRAINT `fk_watchlist_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_watchlist_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table lion_cinema_db.watchlist: ~4 rows (approximately)
INSERT INTO `watchlist` (`watchlist_id`, `product_id`, `user_email`) VALUES
	(56, 32, 'malindadasanayaka@gmail.com'),
	(57, 11, 'malindadasanayaka@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
