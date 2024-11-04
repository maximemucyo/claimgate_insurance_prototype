-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2024 at 11:13 AM
-- Server version: 8.2.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `claimgatedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

DROP TABLE IF EXISTS `claims`;
CREATE TABLE IF NOT EXISTS `claims` (
  `id` int NOT NULL AUTO_INCREMENT,
  `policyholder_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `incident_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `insurance_certificate` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `driving_license` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `log_book` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `police_report` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `damage_estimate` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `third_party_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `third_party_info` text COLLATE utf8mb4_general_ci,
  `claim_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Submitted',
  `date_submitted` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`id`, `policyholder_name`, `incident_type`, `description`, `insurance_certificate`, `driving_license`, `log_book`, `police_report`, `damage_estimate`, `third_party_name`, `third_party_info`, `claim_file`, `status`, `date_submitted`, `user_id`) VALUES
(1, 'Maxime Mucyo', 'Crash', 'Crashed with a moto, this time 12:00 PM in Kicukiro district', '../assets/uploads/09B-1User-512.webp', '../assets/uploads/CANE CRAFT WINERY.jpg', '../assets/uploads/rULWuutDcN5NvtiZi4FRPzRYWSh.jpg', '../assets/uploads/ishushocom logo.png', NULL, 'Eric Rukundo', '078123497976', '../assets/uploads/10ad1931-5b86-4aad-b775-cbe70d8394a6.jpg', 'Submitted', '2024-10-23 12:04:54', 0),
(2, 'Maxime Mucyo', 'Crash', 'Accident Happened on 12:00 PM date: 09/10/2024', '../assets/uploads/09B-1User-512.webp', '../assets/uploads/Image 2.jpg', '../assets/uploads/My_city_kigali.jpg', '../assets/uploads/ishushocom logo.png', NULL, 'Eric Rukundo', '07836876788', '../assets/uploads/impanuka_2-15.jpg', 'Submitted', '2024-10-23 12:20:35', 0),
(3, 'Maxime Mucyo2', 'Crash', 'Crash with bike', '../assets/uploads/proof-automobile-insurance-card-that-600nw-2362192535.webp', '../assets/uploads/proof-automobile-insurance-card-that-600nw-2362192535.webp', '../assets/uploads/proof-automobile-insurance-card-that-600nw-2362192535.webp', '../assets/uploads/proof-automobile-insurance-card-that-600nw-2362192535.webp', NULL, 'Eric Rukundo', 'none', '../assets/uploads/impanuka_2-15.jpg', 'Submitted', '2024-10-23 12:37:22', 1),
(4, 'Customet Test1', 'Collision with another car', 'Accident happened on Wednesday, 23/10/2024 Another car violated red light and crashed into my car', '../assets/uploads/671a5e1c3678b-proof-automobile-insurance-card-that-600nw-2362192535.webp', '../assets/uploads/671a5e1c36aa7-09B-1User-512.webp', '../assets/uploads/671a5e1c36c96-Image 1.jpg', '../assets/uploads/671a5e1c36f1d-Sequence_Diagram.png', NULL, 'Kwizera Deo', 'He lives in Kabeza, Kicukiro', '../assets/uploads/671a5e1c37190-Image 1.jpg', 'In Review', '2024-10-24 16:47:56', 2),
(5, 'Customet Test3', 'Fallen from a cliff', 'Accident Happened on 11:00 PM date: 19/10/2024', '../assets/uploads/mmucyo-InsuranceCertificate-20241025_092635.webp', '../assets/uploads/mmucyo-DrivingLicense-20241025_092635.jpg', '../assets/uploads/mmucyo-Logbook-20241025_092635.jpg', '../assets/uploads/mmucyo-PoliceReport-20241025_092635.webp', '../assets/uploads/mmucyo-DamageEstimate-20241025_092635.png', 'Third Party Test2', '07836876788', '../assets/uploads/mmucyo-ClaimSupportingFile-20241025_092635.jpg', 'Submitted', '2024-10-25 09:26:35', 1),
(6, 'Millie', 'Accident', 'An accident occured', '../assets/uploads/Millie-InsuranceCertificate-20241028_202437.pdf', '../assets/uploads/Millie-DrivingLicense-20241028_202437.docx', '../assets/uploads/Millie-Logbook-20241028_202437.docx', '../assets/uploads/Millie-PoliceReport-20241028_202437.docx', '../assets/uploads/Millie-DamageEstimate-20241028_202437.docx', NULL, NULL, '../assets/uploads/Millie-ClaimSupportingFile-20241028_202437.docx', 'Submitted', '2024-10-28 23:24:37', 3);

-- --------------------------------------------------------

--
-- Table structure for table `claim_timeline`
--

DROP TABLE IF EXISTS `claim_timeline`;
CREATE TABLE IF NOT EXISTS `claim_timeline` (
  `id` int NOT NULL AUTO_INCREMENT,
  `claim_id` int NOT NULL,
  `date` datetime NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `completed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claim_timeline`
--

INSERT INTO `claim_timeline` (`id`, `claim_id`, `date`, `description`, `completed`) VALUES
(1, 4, '2024-10-24 16:47:56', 'Claim submitted', 0),
(2, 5, '2024-10-25 09:26:35', 'Claim submitted', 1),
(3, 6, '2024-10-28 20:24:37', 'Claim submitted', 1);

-- --------------------------------------------------------

--
-- Table structure for table `garages`
--

DROP TABLE IF EXISTS `garages`;
CREATE TABLE IF NOT EXISTS `garages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `approved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `garages`
--

INSERT INTO `garages` (`id`, `name`, `address`, `approved`) VALUES
(1, 'Garage A', '123 Main St', 1),
(2, 'Garage B', '456 Oak Ave', 1),
(3, 'Garage C', '789 Pine Ln', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'driver',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'mmucyo', 'maximemucyo1@gmail.com', '$2y$10$Z85tReGYAiO.n/oWrLHYV.fDHc1tN9FScbiB7isgcyXfOBnn3X76q', '2024-10-23 12:15:27', 'driver'),
(2, 'ribkagetu', 'usertest3@email.com', '$2y$10$onI6JPrqHEvWCoDm/S9TouD1F1XNzOQ8FFHYz6TURhm77ciOiQyV6', '2024-10-23 15:57:37', 'assessor'),
(4, 'driver', 'driver@gmail.com', '$2y$10$/cot4xL/ZTBKG//o.GXbtujTfN0OLVa1lPRd6p3UVETEvFIhk08Ke', '2024-10-29 00:01:57', 'driver'),
(6, 'garage', 'garage@gmail.com', '$2y$10$MMCBVwRlVrTmDyCyZsIxVeh/56XpZ4F6YbI11a8iml.bSfJC07opC', '2024-10-29 13:36:39', 'garage'),
(7, 'assessor', 'assessor@gmail.com', '$2y$10$ozxZ0oclGCKgn4IaRyLhyOoB5wyahcu41AP68kU99rVNwwzlYrtL.', '2024-10-29 13:50:04', 'assessor'),
(8, 'admin', 'admin@gmail.com', '$2y$10$tqOCcokqGWKCkyyUT5BdFOUNNo.d6lriieyVuOHoUMEhDlrGgZnkK', '2024-10-29 13:50:49', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
