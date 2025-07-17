-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 22 Μάη 2025 στις 10:58:42
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `air_ds`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `airports`
--

CREATE TABLE `airports` (
  `airport_name` varchar(80) NOT NULL,
  `airport_code` varchar(3) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `airport_tax` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `airports`
--

INSERT INTO `airports` (`airport_name`, `airport_code`, `latitude`, `longitude`, `airport_tax`) VALUES
('Athens International Airport \"Eleftherios Venizelos\"', 'ATH', '37.937225', '23.945238', 150),
('Paris Charles de Gaulle Airport ', 'CDG', '49.009724', '2.547778', 200),
('Leonardo da Vinci Rome Fiumicino Airport ', 'FCO', '41.81080', '12.25090', 150),
('Adolfo Suárez Madrid–Barajas Airport ', 'MAD', '40.4895', '3.5643', 250),
('Larnaka International Airport', 'LCA', '34.8715', '33.6077', 150),
('Brussels Airport', 'BRU', '50.9002', '4.4859', 200);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `reservations`
--

CREATE TABLE `reservations` (
  `departure_airport` varchar(70) NOT NULL,
  `arrival_airport` varchar(70) NOT NULL,
  `departure_date` date NOT NULL,
  `seats` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `taxes` int(5) NOT NULL,
  `seat_cost` float NOT NULL,
  `res_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `reservations`
--

INSERT INTO `reservations` (`departure_airport`, `arrival_airport`, `departure_date`, `seats`, `first_name`, `last_name`, `taxes`, `seat_cost`, `res_id`) VALUES
('Athens International Airport \"Eleftherios Venizelos\"', 'Adolfo Suárez Madrid–Barajas Airport ', '2025-05-24', '4D', 'Chris', 'Williams', 400, 10, 1),
('Larnaka International Airport', 'Athens International Airport \"Eleftherios Venizelos\"', '2025-06-08', '14A,14B', 'Chris', 'Williams', 300, 0, 2),
('Adolfo Suárez Madrid–Barajas Airport ', 'Athens International Airport \"Eleftherios Venizelos\"', '2025-05-29', '11D', 'Maria', 'Papadopoulou', 400, 20, 4),
('Paris Charles de Gaulle Airport ', 'Brussels Airport', '2025-06-19', '17F', 'Maria', 'Papadopoulou', 400, 0, 5),
('Larnaka International Airport', 'Athens International Airport \"Eleftherios Venizelos\"', '2025-06-08', '2F,2E', 'Chris', 'Williams', 300, 20, 6),
('Paris Charles de Gaulle Airport ', 'Brussels Airport', '2025-06-19', '12E', 'Chris', 'Williams', 400, 20, 8),
('Leonardo da Vinci Rome Fiumicino Airport ', 'Athens International Airport \"Eleftherios Venizelos\"', '2025-06-08', '11A,11B', 'Chris', 'Williams', 300, 40, 9),
('Paris Charles de Gaulle Airport ', 'Brussels Airport', '2025-06-19', '1A', 'Maria', 'Papadopoulou', 400, 20, 10),
('Athens International Airport \"Eleftherios Venizelos\"', 'Larnaka International Airport', '2025-07-26', '30E', 'Maria', 'Papadopoulou', 300, 0, 12);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`, `email`) VALUES
('Maria', 'Papadopoulou', 'maria1', 'maria123', 'maria123@gmail.com'),
('Chris', 'Williams', 'chris12', 'chris1234', 'chriswil@gmail.com'),
('Betty', 'Lorence', 'betty', 'betty12', 'betty@gmail.com');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `reservations`
--
ALTER TABLE `reservations`
  ADD UNIQUE KEY `res_id` (`res_id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
