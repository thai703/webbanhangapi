-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for my_store
CREATE DATABASE IF NOT EXISTS `my_store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `my_store`;

-- Dumping structure for table my_store.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.account: ~3 rows (approximately)
INSERT INTO `account` (`id`, `username`, `fullname`, `password`, `role`) VALUES
	(1, 'user1', 'user2', '$2y$12$q0Q99/NqkPG9pWiDa9TQHu7DoTIuPuf2Ubnwa0O9pC0eYWLj7Qg66', 'user'),
	(2, '11', '1111', '$2y$12$5fLRRD0iTQVejgtno8Nw/.7Bx72PlVauF4saPEd/ZjTbqRGJLIFFu', 'user'),
	(3, 'user10', 'thai', '$2y$10$LRqFiOHJYgxPswg.ozx6dOqqv9LdNqVdSMxdGbue/c.htv43G1noW', 'admin');

-- Dumping structure for table my_store.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.category: ~21 rows (approximately)
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(1, 'Điện thoại', 'Danh mục các loại điện thoại'),
	(2, 'Laptop', 'Danh mục các loại laptop'),
	(3, 'Máy tính bảng', 'Danh mục các loại máy tính bảng'),
	(4, 'Phụ kiện', 'Danh mục phụ kiện điện tử'),
	(5, 'Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro'),
	(7, 'máy tính bàn', 'máy tính để bàn'),
	(9, 'Điện thoại', 'Danh mục các loại điện thoại'),
	(10, 'Laptop', 'Danh mục các loại laptop'),
	(11, 'Máy tính bảng', 'Danh mục các loại máy tính bảng'),
	(12, 'Phụ kiện', 'Danh mục phụ kiện điện tử'),
	(13, 'Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro'),
	(14, 'Điện thoại', 'Danh mục các loại điện thoại'),
	(15, 'Laptop', 'Danh mục các loại laptop'),
	(16, 'Máy tính bảng', 'Danh mục các loại máy tính bảng'),
	(17, 'Phụ kiện', 'Danh mục phụ kiện điện tử'),
	(18, 'Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro'),
	(19, 'Điện thoại', 'Danh mục các loại điện thoại'),
	(20, 'Laptop', 'Danh mục các loại laptop'),
	(21, 'Máy tính bảng', 'Danh mục các loại máy tính bảng'),
	(22, 'Phụ kiện', 'Danh mục phụ kiện điện tử'),
	(23, 'Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro');

-- Dumping structure for table my_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.orders: ~10 rows (approximately)
INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
	(1, 'Vinh Ngu', '0123123123', 'Gầm cầu sài gòn', '2025-03-10 08:29:40'),
	(2, 'Vinh Ngu', '0123123123', 'Vô gia cư', '2025-03-10 08:31:21'),
	(3, 'knkjnkjnkjnk', '6165165', ',l,;,;,;l,;l,;', '2025-03-10 08:52:37'),
	(4, 'sdasdas', 'ádasdas', 'đâsdas', '2025-03-10 09:12:26'),
	(5, 'asdas', '222222', 'asdasd', '2025-03-17 07:31:54'),
	(6, 'noname', '123456789', 'tphcm', '2025-03-17 09:07:47'),
	(7, 'thai', '1111', '12345', '2025-03-18 01:19:34'),
	(8, 'thainguyen', '1232123', 'qưqqqqqqq', '2025-03-18 01:22:24'),
	(9, 'quocthai', '123', '123', '2025-03-18 01:28:49'),
	(10, 'NGUYEN HUU QUOC THAI', '0981214062', 'TO 21 LOC TIEN-XA MY LOC-HUYEN CAN GIUOC-TINH LONG AN-VIET NAM', '2025-03-18 04:10:08');

-- Dumping structure for table my_store.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.order_details: ~12 rows (approximately)
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
	(1, 1, 1, 2, 99999.00),
	(2, 2, 1, 2, 99999.00),
	(3, 3, 1, 2, 99999.00),
	(4, 4, 1, 1, 99999.00),
	(5, 4, 2, 1, 35000000.00),
	(6, 5, 1, 2, 25000000.00),
	(7, 6, 1, 2, 25000000.00),
	(8, 7, 1, 18, 25000000.00),
	(9, 8, 4, 4, 20000000.00),
	(10, 9, 1, 3, 25000000.00),
	(11, 10, 4, 17, 20000000.00),
	(12, 10, 11, 1, 10000000.00);

-- Dumping structure for table my_store.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.product: ~2 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
	(4, 'Laptop Dell', 'Laptop Dell', 20000000.00, 'uploads/asus-vivobook-go-15-e1504fa-r5-nj776w-140225-100949-251-600x600.jpg', 2),
	(11, 'Xiaomi', 'Điện thoại Xiaomi Redmi Note 14 Pro 5G 8GB/256GB', 10000000.00, 'uploads/xiaomi-redmi-note-14-pro-5g-xanh-thumbai-600x600.jpg', 1);

-- Dumping structure for table my_store.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
