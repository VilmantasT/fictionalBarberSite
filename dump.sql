-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019 m. Vas 19 d. 20:07
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kirpykla`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `kirpejos`
--

CREATE TABLE `kirpejos` (
  `id` int(3) NOT NULL,
  `worker_name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `kirpejos`
--

INSERT INTO `kirpejos` (`id`, `worker_name`) VALUES
(8, 'Worker1'),
(9, 'Worker2'),
(13, 'Worker3');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `klientai`
--

CREATE TABLE `klientai` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `client_surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `visits` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `klientai`
--

INSERT INTO `klientai` (`id`, `client_name`, `client_surname`, `visits`) VALUES
(35, 'John1', 'Doe1', 1),
(36, 'John2', 'Doe2', 2),
(37, 'John3', 'Doe3', 4),
(38, 'John4', 'Doe4', 4),
(39, 'John5', 'Doe5', 6),
(40, 'John6', 'Doe6', 9),
(41, 'John7', 'Doe7', 10),
(42, 'John8', 'Doe8', 15),
(43, 'John9', 'Doe9', 12),
(44, 'John10', 'Doe10', 8),
(45, 'John11', 'Doe11', 6),
(46, 'John12', 'Doe12', 15),
(47, 'John13', 'Doe13', 18),
(48, 'John14', 'Doe14', 4),
(49, 'John15', 'Doe15', 7),
(50, 'John16', 'Doe16', 3),
(51, 'John17', 'Doe17', 2),
(52, 'John18', 'Doe18', 3),
(53, 'John19', 'Doe19', 4),
(54, 'John20', 'Doe20', 7),
(55, 'John21', 'Doe21', 9),
(56, 'John22', 'Doe22', 21),
(57, 'John23', 'Doe23', 25),
(58, 'John24', 'Doe24', 35),
(59, 'John25', 'Doe25', 10),
(60, 'John26', 'Doe26', 2),
(61, 'John27', 'Doe27', 5),
(62, 'John28', 'Doe28', 15),
(63, 'John29', 'Doe29', 18),
(64, 'John30', 'Doe30', 6),
(65, 'John31', 'Doe31', 3),
(66, 'John32', 'Doe32', 32),
(67, 'John33', 'Doe33', 9),
(68, 'John34', 'Doe34', 10),
(69, 'John35', 'Doe35', 5),
(70, 'John36', 'Doe36', 5),
(71, 'John37', 'Doe37', 8),
(72, 'John38', 'Doe38', 8),
(73, 'John39', 'Doe39', 8),
(74, 'John40', 'Doe40', 4),
(75, 'John41', 'Doe41', 28),
(76, 'John42', 'Doe42', 7),
(77, 'John43', 'Doe43', 5),
(78, 'John44', 'Doe44', 18),
(79, 'John45', 'Doe45', 7),
(80, 'John46', 'Doe46', 34),
(81, 'John47', 'Doe47', 13),
(82, 'John48', 'Doe48', 9),
(83, 'John49', 'Doe49', 8),
(84, 'John50', 'Doe50', 7),
(85, 'John51', 'Doe51', 16);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `registracijos`
--

CREATE TABLE `registracijos` (
  `id` int(3) NOT NULL,
  `visits` int(3) NOT NULL,
  `client_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `client_surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `res_date` date NOT NULL,
  `res_time` varchar(11) NOT NULL,
  `worker` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `registracijos`
--

INSERT INTO `registracijos` (`id`, `visits`, `client_name`, `client_surname`, `res_date`, `res_time`, `worker`) VALUES
(35, 1, 'John1', 'Doe1', '2019-02-21', '13.45', 'Worker1'),
(36, 2, 'John2', 'Doe2', '2019-02-21', '11.45', 'Worker2'),
(38, 4, 'John3', 'Doe3', '2019-02-22', '17.15', 'Worker1'),
(39, 6, 'John5', 'Doe5', '2019-02-22', '15.00', 'Worker2'),
(40, 9, 'John6', 'Doe6', '2019-03-01', '12.45', 'Worker3'),
(41, 10, 'John7', 'Doe7', '2019-02-27', '18.15', 'Worker3'),
(42, 15, 'John8', 'Doe8', '2019-02-22', '16.00', 'Worker3'),
(43, 12, 'John9', 'Doe9', '2019-03-02', '18.30', 'Worker1'),
(44, 8, 'John10', 'Doe10', '2019-03-02', '17.15', 'Worker3'),
(45, 6, 'John11', 'Doe11', '2019-02-25', '19.45', 'Worker3'),
(46, 15, 'John12', 'Doe12', '2019-02-26', '16.30', 'Worker3'),
(47, 18, 'John13', 'Doe13', '2019-02-28', '10.00', 'Worker1'),
(48, 4, 'John14', 'Doe14', '2019-02-25', '19.30', 'Worker3'),
(49, 7, 'John15', 'Doe15', '2019-03-01', '13.30', 'Worker1'),
(50, 3, 'John16', 'Doe16', '2019-02-26', '11.15', 'Worker1'),
(51, 2, 'John17', 'Doe17', '2019-03-05', '18.30', 'Worker3'),
(52, 3, 'John18', 'Doe18', '2019-03-07', '10.30', 'Worker1'),
(53, 7, 'John20', 'Doe20', '2019-02-25', '17.45', 'Worker2'),
(54, 9, 'John21', 'Doe21', '2019-02-28', '17.30', 'Worker2'),
(55, 21, 'John22', 'Doe22', '2019-03-09', '11.45', 'Worker3'),
(56, 25, 'John23', 'Doe23', '2019-03-07', '10.15', 'Worker3'),
(57, 35, 'John24', 'Doe24', '2019-03-05', '18.30', 'Worker1'),
(58, 10, 'John25', 'Doe25', '2019-03-05', '17.15', 'Worker3'),
(59, 2, 'John26', 'Doe26', '2019-02-27', '17.45', 'Worker1'),
(60, 5, 'John27', 'Doe27', '2019-03-04', '16.30', 'Worker1'),
(62, 15, 'John28', 'Doe28', '2019-02-21', '12.00', 'Worker3'),
(63, 18, 'John29', 'Doe29', '2019-02-27', '10.00', 'Worker2'),
(64, 6, 'John30', 'Doe30', '2019-02-28', '17.30', 'Worker3'),
(65, 3, 'John31', 'Doe31', '2019-03-01', '10.45', 'Worker3'),
(66, 32, 'John32', 'Doe32', '2019-02-23', '16.15', 'Worker3'),
(67, 9, 'John33', 'Doe33', '2019-03-02', '16.30', 'Worker2'),
(68, 10, 'John34', 'Doe34', '2019-02-25', '10.00', 'Worker2'),
(69, 5, 'John35', 'Doe35', '2019-03-08', '10.45', 'Worker2'),
(70, 5, 'John36', 'Doe36', '2019-02-22', '11.15', 'Worker2'),
(71, 8, 'John37', 'Doe37', '2019-02-27', '18.15', 'Worker2'),
(72, 8, 'John38', 'Doe38', '2019-02-22', '14.15', 'Worker3'),
(73, 8, 'John39', 'Doe39', '2019-03-05', '10.45', 'Worker3'),
(74, 4, 'John40', 'Doe40', '2019-02-26', '18.30', 'Worker3'),
(75, 28, 'John41', 'Doe41', '2019-02-28', '11.00', 'Worker2'),
(76, 7, 'John42', 'Doe42', '2019-02-26', '17.30', 'Worker2'),
(77, 5, 'John43', 'Doe43', '2019-03-09', '17.45', 'Worker2'),
(78, 18, 'John44', 'Doe44', '2019-03-09', '13.45', 'Worker3'),
(79, 7, 'John45', 'Doe45', '2019-03-05', '10.30', 'Worker1'),
(80, 34, 'John46', 'Doe46', '2019-03-07', '18.30', 'Worker2'),
(81, 13, 'John47', 'Doe47', '2019-02-25', '13.15', 'Worker2'),
(82, 9, 'John48', 'Doe48', '2019-03-04', '14.00', 'Worker3'),
(83, 8, 'John49', 'Doe49', '2019-02-25', '14.15', 'Worker2'),
(84, 7, 'John50', 'Doe50', '2019-02-22', '13.00', 'Worker2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kirpejos`
--
ALTER TABLE `kirpejos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klientai`
--
ALTER TABLE `klientai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registracijos`
--
ALTER TABLE `registracijos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kirpejos`
--
ALTER TABLE `kirpejos`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `klientai`
--
ALTER TABLE `klientai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `registracijos`
--
ALTER TABLE `registracijos`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
