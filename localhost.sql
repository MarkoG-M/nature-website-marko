-- Adminer 5.3.0 MySQL 8.4.3 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `nature_calls` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `nature_calls`;

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `flight_id` int NOT NULL,
  `booking_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `flight_id` (`flight_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `bookings` (`id`, `user_id`, `flight_id`, `booking_date`) VALUES
(1,	2,	1,	'2026-06-08 21:38:08'),
(2,	2,	3,	'2026-06-08 21:49:01'),
(3,	2,	2,	'2026-06-08 21:49:19'),
(4,	2,	3,	'2026-06-08 21:49:28'),
(5,	2,	4,	'2026-06-08 21:49:36'),
(6,	2,	5,	'2026-06-08 22:16:35'),
(7,	7,	6,	'2026-06-09 14:15:07'),
(8,	2,	7,	'2026-06-09 14:44:41');

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `flight_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `flight_id` (`flight_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `countries` (`id`, `name`) VALUES
(2,	'japan'),
(3,	'schweiz'),
(4,	'italien');

DROP TABLE IF EXISTS `flights`;
CREATE TABLE `flights` (
  `id` int NOT NULL AUTO_INCREMENT,
  `country_id` int NOT NULL,
  `arrival_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `departure_date` timestamp NOT NULL,
  `return_date` date DEFAULT NULL,
  `departure_city` varchar(255) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `flights_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `flights` (`id`, `country_id`, `arrival_city`, `departure_date`, `return_date`, `departure_city`, `price`) VALUES
(1,	2,	'HND',	'2026-06-11 22:00:00',	'2026-06-24',	'HAM',	1637.72),
(2,	3,	'ZRH',	'2026-06-08 22:00:00',	'2026-06-23',	'CGN',	219),
(3,	3,	'ZRH',	'2026-06-08 22:00:00',	'2026-06-23',	'CGN',	309.74),
(4,	3,	'ZRH',	'2026-06-08 22:00:00',	'2026-06-23',	'CGN',	424.63),
(5,	3,	'ZRH',	'2026-06-08 22:00:00',	'2026-06-16',	'MUC',	225.98),
(6,	4,	'FCO',	'2026-06-16 22:00:00',	'2026-06-25',	'FRA',	143.51),
(7,	2,	'HND',	'2026-06-10 22:00:00',	'2026-06-18',	'FRA',	1222.89);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(2,	'Bla',	'Bla@gmail.com',	'$2y$10$jl8s69/DbVsCnKLo34j5qefSD84ykzI5yM52wVF8dfAYOe3kp1qge'),
(3,	'suzi',	'suzi@gmail.com',	'$2y$10$Kruxg/cntbEDXQnJKmi1u.Xefujt7ISfmhQO5PcSGX65/stHnP0n6'),
(6,	'andi',	'anidostfront@gmail.com',	'$2y$10$UV.cqAw7lb.YYhY/slao3OlJ593dLfocKUq5uhxUmYXLJpD8KO2.W'),
(7,	'androsch',	'androsch@gmail.com',	'$2y$10$ZjqdBuCu9dxONSNpKZWGwubDFoILFRJwxs7G2EVxLUJc/Dm3Gkyw2');

-- 2026-06-10 05:44:38 UTC
