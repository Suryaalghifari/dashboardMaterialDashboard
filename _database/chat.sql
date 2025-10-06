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


-- Dumping database structure for chat
CREATE DATABASE IF NOT EXISTS `chat` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `chat`;

-- Dumping structure for table chat.chat_messages
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `session_id` bigint NOT NULL,
  `role` enum('user','assistant') NOT NULL,
  `content` text NOT NULL,
  `rewritten_question` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table chat.chat_messages: ~123 rows (approximately)
INSERT INTO `chat_messages` (`id`, `session_id`, `role`, `content`, `rewritten_question`, `created_at`) VALUES
	(1, 1, 'user', 'Halo', 'User greeting', '2025-10-04 03:10:38'),
	(2, 1, 'assistant', 'Pertanyaan ini adalah sapaan dan tidak dapat dianalisis sebagai permintaan data atau diterjemahkan ke dalam kueri SQL.', 'User greeting', '2025-10-04 03:10:40'),
	(3, 1, 'user', 'Kapan akun ini di buat', 'Retrieve the creation date for a specific account.', '2025-10-04 03:10:55'),
	(4, 1, 'assistant', 'Tidak dapat menentukan tanggal pembuatan akun karena ID akun tidak disediakan. Harap berikan ID akun yang spesifik.', 'Retrieve the creation date for a specific account.', '2025-10-04 03:11:01'),
	(5, 1, 'user', '9', 'Retrieve the creation date for the account with ID 9.', '2025-10-04 03:11:31'),
	(6, 1, 'assistant', 'Successfully retrieved the creation date for account ID 9.', 'Retrieve the creation date for the account with ID 9.', '2025-10-04 03:11:35'),
	(7, 1, 'user', 'jadi kapan akun ini dibuat', NULL, '2025-10-04 03:11:49'),
	(8, 1, 'assistant', 'Akun Anda dibuat pada: 02 Oct 2025 08:53', NULL, '2025-10-04 03:11:49'),
	(9, 1, 'user', 'siapa nama dari akun ini', 'Retrieve the name of a specific account.', '2025-10-04 03:12:19'),
	(10, 1, 'assistant', 'Untuk mengambil nama akun, saya memerlukan ID akun yang spesifik. Pertanyaan Anda tidak menyertakan ID akun, jadi saya tidak dapat membuat kueri SQL yang dapat dieksekusi. Harap berikan ID akun.', 'Retrieve the name of a specific account.', '2025-10-04 03:12:24'),
	(11, 1, 'user', 'email nya apa pada akun ini', 'Retrieve the email address for a specific account.', '2025-10-04 03:14:24'),
	(12, 1, 'assistant', 'Please provide the account ID to retrieve its email address.', 'Retrieve the email address for a specific account.', '2025-10-04 03:14:28'),
	(13, 2, 'user', 'Halo', NULL, '2025-10-04 03:18:27'),
	(14, 2, 'assistant', 'Halo Admin! Ada yang bisa saya bantu?', NULL, '2025-10-04 03:18:27'),
	(15, 2, 'user', 'apa nama akun ini yang di pake saat login', NULL, '2025-10-04 03:18:52'),
	(16, 2, 'assistant', 'Nama Anda: Admin', NULL, '2025-10-04 03:18:52'),
	(17, 2, 'user', 'email nya apa sih yang digunakan oleh admin ini', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:19:08'),
	(18, 2, 'assistant', 'Query untuk mengambil email admin telah dibuat, namun tidak dapat dieksekusi karena tidak ada koneksi database. Anda perlu menjalankan query ini pada database Anda.', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:19:12'),
	(19, 2, 'user', 'kapan akun ini dibuat', NULL, '2025-10-04 03:20:05'),
	(20, 2, 'assistant', 'Akun Anda dibuat pada: 03 Oct 2025 16:21', NULL, '2025-10-04 03:20:05'),
	(21, 2, 'user', 'email yang digunakan oleh admin , apa nama emailnya', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:20:20'),
	(22, 2, 'assistant', 'Successfully retrieved the email address for the user with the \'admin\' role.', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:20:23'),
	(23, 2, 'user', 'email apa yang digunakan oleh admin', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:20:49'),
	(24, 2, 'assistant', 'The query retrieves the email address of users who have the \'admin\' role from the \'users\' table.', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:20:51'),
	(25, 2, 'user', 'email', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:20:55'),
	(26, 2, 'assistant', 'Tidak dapat mengeksekusi query karena tidak terhubung ke database. Query SQL untuk mengambil alamat email pengguna dengan peran \'admin\' telah dibuat.', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:21:00'),
	(27, 2, 'user', 'bukan dari nama admin dia menggunakan email apa', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:21:15'),
	(28, 2, 'assistant', 'I cannot execute the SQL query as I do not have access to a live database. The query is designed to retrieve the email address from the \'users\' table for any user whose role is \'admin\'.', 'Retrieve the email address for the user with the role \'admin\'.', '2025-10-04 03:21:19'),
	(29, 2, 'user', 'kapan terakhir akun ini di update', 'Retrieve the last update timestamp for a specific account.', '2025-10-04 03:21:34'),
	(30, 2, 'assistant', 'Untuk mendapatkan waktu update terakhir dari akun ini, Anda perlu menyediakan ID akun yang spesifik. Query di atas adalah template yang membutuhkan ID akun untuk mengidentifikasi akun yang dimaksud.', 'Retrieve the last update timestamp for a specific account.', '2025-10-04 03:21:45'),
	(31, 2, 'user', 'okeey deh saya perbaiki dulu', 'The user indicates they will make corrections, which is not a data retrieval request.', '2025-10-04 03:23:11'),
	(32, 2, 'assistant', 'Pertanyaan yang diberikan bukan merupakan permintaan untuk mengambil data atau melakukan analisis. Ini adalah pernyataan bahwa pengguna akan melakukan perbaikan.', 'The user indicates they will make corrections, which is not a data retrieval request.', '2025-10-04 03:23:14'),
	(33, 2, 'user', 'berapa jumlah traffic CDN pada bulan lalu?', 'Retrieve the total CDN traffic volume for the previous calendar month.', '2025-10-04 03:25:57'),
	(34, 2, 'assistant', 'The query calculates the sum of \'traffic_amount\' from the \'cdn_traffic\' table for all records where the \'timestamp\' falls within the last complete calendar month. It assumes a \'cdn_traffic\' table with \'timestamp\' and \'traffic_amount\' columns.', 'Retrieve the total CDN traffic volume for the previous calendar month.', '2025-10-04 03:26:03'),
	(35, 3, 'user', 'halo', NULL, '2025-10-04 09:15:43'),
	(36, 3, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 09:15:43'),
	(37, 3, 'user', 'kapan aku ini terdaftar', 'Kapan pengguna saat ini terdaftar?', '2025-10-04 09:15:59'),
	(38, 3, 'assistant', 'Pengguna terdaftar pada 2 Oktober 2025 pukul 08:53:58 UTC.', 'Kapan pengguna saat ini terdaftar?', '2025-10-04 09:16:03'),
	(39, 3, 'user', 'siapa nama akun yang terdaftar saat ini , dan apa ada informasi umurnya', NULL, '2025-10-04 09:16:36'),
	(40, 3, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 09:16:36'),
	(41, 3, 'user', 'berapa umurnya', 'Berapa umur pengguna saat ini berdasarkan informasi yang tersedia?', '2025-10-04 09:16:51'),
	(42, 3, 'assistant', 'Informasi mengenai tanggal lahir pengguna tidak tersedia dalam konteks yang diberikan, sehingga tidak memungkinkan untuk menghitung umur pengguna saat ini.', 'Berapa umur pengguna saat ini berdasarkan informasi yang tersedia?', '2025-10-04 09:16:53'),
	(43, 3, 'user', 'apa ada informasi email terhadap akun ini', 'Retrieve the email address for the current user.', '2025-10-04 09:17:44'),
	(44, 3, 'assistant', 'Informasi email untuk pengguna saat ini adalah suryaaalghifari@gmail.com.', 'Retrieve the email address for the current user.', '2025-10-04 09:17:49'),
	(45, 3, 'user', 'btw siapa nama kamu', NULL, '2025-10-04 09:19:21'),
	(46, 3, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 09:19:21'),
	(47, 3, 'user', 'bukan nama pemilik akun ini tetapi nama chatbot ini', 'Apa nama chatbot ini?', '2025-10-04 09:19:39'),
	(48, 3, 'assistant', 'Pertanyaan ini menanyakan nama chatbot, bukan informasi tentang pengguna. Informasi nama chatbot tidak tersedia dalam konteks yang diberikan.', 'Apa nama chatbot ini?', '2025-10-04 09:19:42'),
	(49, 3, 'user', 'okee deh kalo gitu', 'Pertanyaan ini tidak dapat diinterpretasikan sebagai permintaan data atau analisis.', '2025-10-04 09:20:31'),
	(50, 3, 'assistant', 'Pertanyaan yang diajukan bersifat percakapan dan tidak dapat diterjemahkan menjadi kueri data atau analisis. Mohon ajukan pertanyaan terkait data yang spesifik.', 'Pertanyaan ini tidak dapat diinterpretasikan sebagai permintaan data atau analisis.', '2025-10-04 09:20:34'),
	(51, 3, 'user', 'halo', NULL, '2025-10-04 09:31:15'),
	(52, 3, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 09:31:15'),
	(53, 3, 'user', 'siapa nama akun ini', NULL, '2025-10-04 09:31:30'),
	(54, 3, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 09:31:30'),
	(55, 3, 'user', 'apa nama email akun ini', NULL, '2025-10-04 09:34:41'),
	(56, 3, 'assistant', 'Email Anda: suryaaalghifari@gmail.com', NULL, '2025-10-04 09:34:41'),
	(57, 3, 'user', 'halo', NULL, '2025-10-04 09:39:11'),
	(58, 3, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 09:39:11'),
	(59, 3, 'user', 'halo', NULL, '2025-10-04 09:39:32'),
	(60, 3, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 09:39:32'),
	(61, 4, 'user', 'siapa nama kamu', NULL, '2025-10-04 09:43:15'),
	(62, 4, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 09:43:15'),
	(63, 4, 'user', 'Halo', NULL, '2025-10-04 09:48:33'),
	(64, 4, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 09:48:33'),
	(65, 4, 'user', 'apa yang kamu tau tentang website ini', 'Informasi apa yang Anda miliki tentang website ini?', '2025-10-04 09:48:50'),
	(66, 4, 'assistant', 'Sebagai asisten analitik, saya tidak memiliki kemampuan untuk menjelajahi atau mengakses informasi tentang website eksternal. Pertanyaan saya terbatas pada data yang tersedia dalam database atau konteks yang diberikan.', 'Informasi apa yang Anda miliki tentang website ini?', '2025-10-04 09:48:54'),
	(67, 4, 'user', 'oh baik deh jika gitu, email apa yang digunakan sekarang pada yang login', 'What is the email address of the currently logged-in user?', '2025-10-04 09:49:24'),
	(68, 4, 'assistant', 'Email yang digunakan oleh pengguna yang sedang login adalah suryaaalghifari@gmail.com.', 'What is the email address of the currently logged-in user?', '2025-10-04 09:49:28'),
	(69, 4, 'user', 'kapan akun ini di buat', NULL, '2025-10-04 09:49:42'),
	(70, 4, 'assistant', 'Akun Anda dibuat pada: 02 Oct 2025 08:53', NULL, '2025-10-04 09:49:42'),
	(71, 4, 'user', 'kapan terakhir update yang di lakukan oleh akun ini', 'Kapan terakhir kali akun ini login?', '2025-10-04 09:49:59'),
	(72, 4, 'assistant', 'Akun ini terakhir login pada 2025-10-04T09:43:06+00:00.', 'Kapan terakhir kali akun ini login?', '2025-10-04 09:50:03'),
	(73, 4, 'user', 'halo', NULL, '2025-10-04 09:58:48'),
	(74, 4, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 09:58:48'),
	(75, 4, 'user', 'saya mau tau, berapa nomer telpon website ini yang bisa di hubungi', 'Berapa nomor telepon website ini yang bisa dihubungi?', '2025-10-04 09:59:10'),
	(76, 4, 'assistant', 'Informasi mengenai nomor telepon website tidak tersedia dalam konteks yang diberikan.', 'Berapa nomor telepon website ini yang bisa dihubungi?', '2025-10-04 09:59:14'),
	(77, 4, 'user', 'Halo', NULL, '2025-10-04 09:59:32'),
	(78, 4, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 09:59:32'),
	(79, 5, 'user', 'halo', NULL, '2025-10-04 10:00:00'),
	(80, 5, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 10:00:00'),
	(81, 5, 'user', 'halo', NULL, '2025-10-04 17:31:42'),
	(82, 5, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 17:31:42'),
	(83, 6, 'user', 'siapa nama user yang login saat ini', NULL, '2025-10-04 17:33:31'),
	(84, 6, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 17:33:31'),
	(85, 6, 'user', 'halo', NULL, '2025-10-04 17:33:47'),
	(86, 6, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 17:33:47'),
	(87, 6, 'user', 'email apa yang terdaftar disini', 'Retrieve the email address of the currently logged-in user.', '2025-10-04 17:34:53'),
	(88, 6, 'assistant', 'Email pengguna yang terdaftar adalah suryaaalghifari@gmail.com.', 'Retrieve the email address of the currently logged-in user.', '2025-10-04 17:34:57'),
	(89, 6, 'user', 'haloo', 'Retrieve the email address of the currently logged-in user.', '2025-10-04 17:37:14'),
	(90, 6, 'assistant', 'The email address of the currently logged-in user is suryaaalghifari@gmail.com.', 'Retrieve the email address of the currently logged-in user.', '2025-10-04 17:37:18'),
	(91, 6, 'user', 'halo', NULL, '2025-10-04 17:37:35'),
	(92, 6, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 17:37:35'),
	(93, 6, 'user', 'halo', NULL, '2025-10-04 17:55:59'),
	(94, 6, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 17:55:59'),
	(95, 6, 'user', 'email apa yang diguanakn oleh akun ini', 'Retrieve the email address of the currently logged-in user.', '2025-10-04 17:59:49'),
	(96, 6, 'assistant', 'Email yang digunakan oleh akun yang sedang login (suryaaalghfari) adalah suryaaalghifari@gmail.com.', 'Retrieve the email address of the currently logged-in user.', '2025-10-04 17:59:56'),
	(97, 7, 'user', 'Halo', NULL, '2025-10-04 18:16:45'),
	(98, 7, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 18:16:45'),
	(99, 7, 'user', 'Siapa nama user yang sedang login', NULL, '2025-10-04 18:16:59'),
	(100, 7, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 18:16:59'),
	(101, 7, 'user', 'halo', NULL, '2025-10-04 19:40:33'),
	(102, 7, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 19:40:33'),
	(103, 7, 'user', 'apa nama emailnya', NULL, '2025-10-04 19:40:48'),
	(104, 7, 'assistant', 'Maaf, sistem sedang sibuk. Coba lagi sebentar lagi.', NULL, '2025-10-04 19:40:48'),
	(105, 7, 'user', 'apa nama emailnya', NULL, '2025-10-04 19:40:58'),
	(106, 7, 'assistant', 'Maaf, sistem sedang sibuk. Coba lagi sebentar lagi.', NULL, '2025-10-04 19:40:58'),
	(107, 7, 'user', 'halo', NULL, '2025-10-04 19:41:57'),
	(108, 7, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 19:41:57'),
	(109, 7, 'user', 'apa nama emaillnya', 'What is the user\'s email address?', '2025-10-04 19:42:02'),
	(110, 7, 'assistant', 'The user\'s email address is suryaaalghifari@gmail.com.', 'What is the user\'s email address?', '2025-10-04 19:42:05'),
	(111, 7, 'user', 'apa nama email dari pemilik akun ini', 'What is the email address of this account owner?', '2025-10-04 19:42:23'),
	(112, 7, 'assistant', 'The email address for the account owner (suryaaalghfari) is suryaaalghifari@gmail.com.', 'What is the email address of this account owner?', '2025-10-04 19:42:27'),
	(113, 7, 'user', 'kapan akun ini di buat', NULL, '2025-10-04 19:42:35'),
	(114, 7, 'assistant', 'Akun Anda dibuat pada: 02 Oct 2025 08:53', NULL, '2025-10-04 19:42:35'),
	(115, 7, 'user', 'okeee', 'What is the email address of the current user?', '2025-10-04 19:56:17'),
	(116, 7, 'assistant', 'The email address for the user \'suryaaalghfari\' (ID: 9) is suryaaalghifari@gmail.com.', 'What is the email address of the current user?', '2025-10-04 19:56:23'),
	(117, 7, 'user', 'baik terimakasih atas informasinya', 'User expresses gratitude for the information.', '2025-10-04 19:56:43'),
	(118, 7, 'assistant', 'Pertanyaan asli adalah ucapan terima kasih dan bukan permintaan data yang dapat dianalisis atau dijawab dengan query SQL.', 'User expresses gratitude for the information.', '2025-10-04 19:56:47'),
	(119, 7, 'user', 'siapa nama kamu', NULL, '2025-10-04 20:15:48'),
	(120, 7, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 20:15:48'),
	(121, 7, 'user', 'terimakasih', NULL, '2025-10-04 20:15:55'),
	(122, 7, 'assistant', 'Sama-sama, senang bisa membantu ????', NULL, '2025-10-04 20:15:55'),
	(123, 7, 'user', 'kapan akun ini dibuat', NULL, '2025-10-04 20:16:03'),
	(124, 7, 'assistant', 'Akun Anda dibuat pada: 02 Okt 2025 08.53 WIB', NULL, '2025-10-04 20:16:03'),
	(125, 7, 'user', 'siapa nama pemilik akun ini', NULL, '2025-10-04 20:18:06'),
	(126, 7, 'assistant', 'Nama Anda: suryaaalghfari', NULL, '2025-10-04 20:18:06'),
	(127, 7, 'user', 'apa nama email yang digunakan oleh surya', 'Apa alamat email yang digunakan oleh pengguna bernama Surya?', '2025-10-04 20:21:32'),
	(128, 7, 'assistant', 'Alamat email pengguna Surya adalah suryaaalghifari@gmail.com.', 'Apa alamat email yang digunakan oleh pengguna bernama Surya?', '2025-10-04 20:21:41'),
	(129, 7, 'user', 'siapa nama bot ini', NULL, '2025-10-04 20:23:58'),
	(130, 7, 'assistant', 'Nama saya: Telkom Assistant', NULL, '2025-10-04 20:23:59'),
	(131, 7, 'user', 'siapa kamu', 'Siapa Anda?', '2025-10-04 20:24:08'),
	(132, 7, 'assistant', 'Saya adalah asisten analitik yang dirancang untuk membantu Anda dengan pertanyaan data.', 'Siapa Anda?', '2025-10-04 20:24:14'),
	(133, 7, 'user', 'halo', NULL, '2025-10-04 20:27:22'),
	(134, 7, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 20:27:22'),
	(135, 7, 'user', 'hai', NULL, '2025-10-04 20:38:28'),
	(136, 7, 'assistant', 'Halo suryaaalghfari! Ada yang bisa saya bantu?', NULL, '2025-10-04 20:38:28');

-- Dumping structure for table chat.chat_sessions
CREATE TABLE IF NOT EXISTS `chat_sessions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `started_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_active` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table chat.chat_sessions: ~6 rows (approximately)
INSERT INTO `chat_sessions` (`id`, `user_id`, `started_at`, `last_active`) VALUES
	(1, 9, '2025-10-04 03:10:38', '2025-10-04 03:10:38'),
	(2, 10, '2025-10-04 03:18:27', '2025-10-04 03:18:27'),
	(3, 9, '2025-10-04 09:06:48', '2025-10-04 09:39:07'),
	(4, 9, '2025-10-04 09:43:10', '2025-10-04 09:59:30'),
	(5, 9, '2025-10-04 09:59:58', '2025-10-04 17:31:51'),
	(6, 9, '2025-10-04 17:33:17', '2025-10-04 18:00:12'),
	(7, 9, '2025-10-04 18:00:40', '2025-10-04 21:04:05');

-- Dumping structure for table chat.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table chat.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
	(9, 'suryaaalghfari', 'suryaaalghifari@gmail.com', '$2y$10$R9YYpQgc9RyTLEAcdniCWeMdc8heKut8PsTU7wUSeXGO10DpNMDeW', 1, '2025-10-04 18:00:36', '2025-10-02 08:53:58', '2025-10-04 18:00:36'),
	(10, 'Admin', 'admin@test.com', '$2y$10$Aoei9fMzJmJ4PjB/KTOhmOIjAmbd4nbyWzvYXT6HTWADbnlFPV7L.', 1, '2025-10-04 03:18:14', '2025-10-03 16:21:24', '2025-10-04 03:18:14');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
