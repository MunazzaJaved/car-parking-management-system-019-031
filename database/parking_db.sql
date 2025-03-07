-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2025 at 04:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `parking_slots`
--

CREATE TABLE `parking_slots` (
  `slot_id` int(10) NOT NULL,
  `slot_number` varchar(50) NOT NULL,
  `status` enum('available','reserved') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_slots`
--

INSERT INTO `parking_slots` (`slot_id`, `slot_number`, `status`) VALUES
(1, 'P1', 'reserved'),
(2, 'P2', 'reserved'),
(3, 'P3', 'reserved'),
(4, 'P4', 'reserved'),
(5, 'P5', 'available'),
(6, 'P6', 'reserved'),
(7, 'p7', 'reserved'),
(8, 'P8', 'available'),
(9, 'P9', 'available'),
(10, 'P10', 'available'),
(11, 'P11', 'available'),
(13, 'P13', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `entry_time` datetime NOT NULL,
  `exit_time` datetime DEFAULT NULL,
  `status` enum('active','completed','cancelled') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `slot_id`, `vehicle_number`, `vehicle_type`, `entry_time`, `exit_time`, `status`) VALUES
(10, 4, 1, '098', 'Bike', '2025-02-13 01:57:00', '2025-03-04 01:57:00', 'completed'),
(11, 4, 3, '123', 'Truck', '2025-02-22 02:01:00', '2025-02-10 06:01:00', 'completed'),
(13, 17, 7, '098', 'Bike', '2025-02-10 03:35:00', '2025-03-01 03:30:00', 'active'),
(14, 2, 2, '67', 'Rickshaw', '2025-03-06 12:27:00', '2025-03-13 12:27:00', 'active'),
(16, 2, 6, '788', 'Truck', '2025-03-05 12:34:00', '2025-03-05 12:34:00', 'active'),
(17, 2, 4, '788', 'Car', '2025-03-03 11:15:00', '2025-03-02 11:16:00', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `contact`, `role`, `status`, `created_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$PraTYHgNwJjmkQydGajOFeY62WMtSKlWTY8G9SXCo5o8bUgLxVw6O', '03455356931', 'admin', 'enabled', '2025-03-03 07:23:28'),
(2, 'user', 'user@example.com', '$2y$10$dfczEA4insLtg1EZCEihB.QEDA6pTgWl4H/K6SCEykK/.g.5NBXH2', '03480881372', 'user', 'enabled', '2025-03-03 07:26:31'),
(3, 'mnza', 'mnzajaved@gmail.com', '$2y$10$q31CPUJWM4qJ/AxjChkb8O2tuWnB1SVRbYN7pEB7Bg6De9qNzBYgm', '03021692243', 'user', 'enabled', '2025-03-07 04:42:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parking_slots`
--
ALTER TABLE `parking_slots`
  ADD PRIMARY KEY (`slot_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parking_slots`
--
ALTER TABLE `parking_slots`
  MODIFY `slot_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `parking_slots` (`slot_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
