-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: ian. 28, 2021 la 10:14 PM
-- Versiune server: 10.4.16-MariaDB
-- Versiune PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `licitatii`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `licitatie`
--

CREATE TABLE `licitatie` (
  `LicitatieID` int(11) NOT NULL,
  `TipLicitatie` varchar(50) NOT NULL,
  `DataLicitatie` datetime NOT NULL,
  `DurataLicitatie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `licitatie`
--

INSERT INTO `licitatie` (`LicitatieID`, `TipLicitatie`, `DataLicitatie`, `DurataLicitatie`) VALUES
(2, 'dinamica', '2021-02-04 15:31:00', 0),
(3, 'tinta', '2021-02-06 15:15:00', 0),
(6, 'must-buy', '2021-02-14 19:36:00', 0),
(8, 'must-buy', '2021-02-04 20:36:00', 0),
(11, 'dinamica', '2021-02-07 10:58:00', 20),
(12, 'tinta', '2021-02-05 12:25:00', 25),
(13, 'tinta', '2021-02-05 01:39:00', 45);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `participant`
--

CREATE TABLE `participant` (
  `ParticipantID` int(11) NOT NULL,
  `Nume` varchar(50) NOT NULL,
  `Prenume` varchar(50) NOT NULL,
  `CNP` char(13) NOT NULL,
  `NumarTelefon` char(10) NOT NULL,
  `NumeUtilizator` varchar(50) NOT NULL,
  `ParolaUtilizator` varchar(255) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `participant`
--

INSERT INTO `participant` (`ParticipantID`, `Nume`, `Prenume`, `CNP`, `NumarTelefon`, `NumeUtilizator`, `ParolaUtilizator`, `Email`) VALUES
(7, 'Matei', 'Petre', '1890623033356', '0754562988', 'petrematei', '$2y$10$DT20bM5pLGWiYwfFomXBkuZiP82.TqP/4Zlh41OTxu0vsMDWdCWhy', 'mateipetre@yahoo.com'),
(8, 'Matei', 'Alex', '1990625033357', '0751047566', 'alexmatei', '$2y$10$1wn6Yp1k0rWt1IEzB2.XqujifpyGgH4E5tUSowAmLpJ4UiGaFtAkS', 'petrealexandrumatei@gmail.com'),
(9, 'Popescu', 'Ioana', '1970503033356', '0754562978', 'ioana_popescu', '$2y$10$VbrRKX8Rafgb1dvl9.CQbOLZz5ssJF/6YjoqWv6NkDHAapnjC9FPS', 'ioana_popescu@yahoo.com'),
(10, 'admin', 'admin', '1111111111111', '1111111111', 'admin', '$2y$10$gYzoyAdF8ydJnXu9FGUrrOd8qZFLZkguaM1ITbzK5CUQJS256H1Mi', 'admin@admin.com');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `participare_licitatie_tel`
--

CREATE TABLE `participare_licitatie_tel` (
  `ParticipareLicitatieTelID` int(11) NOT NULL,
  `LicitatieID` int(11) NOT NULL,
  `ParticipantID` int(11) NOT NULL,
  `TelefonID` int(11) NOT NULL,
  `PretLicitat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `participare_licitatie_tel`
--

INSERT INTO `participare_licitatie_tel` (`ParticipareLicitatieTelID`, `LicitatieID`, `ParticipantID`, `TelefonID`, `PretLicitat`) VALUES
(1, 3, 7, 2, 650),
(2, 8, 9, 4, 110),
(3, 2, 7, 5, 120),
(4, 6, 9, 2, 620),
(5, 6, 7, 6, 430),
(6, 2, 8, 2, 640),
(7, 6, 9, 6, 400),
(8, 11, 8, 1, 1650),
(9, 12, 9, 6, 130),
(10, 13, 7, 5, 150),
(11, 11, 7, 7, 52),
(12, 12, 7, 7, 54),
(13, 2, 9, 11, 500);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `pret_start`
--

CREATE TABLE `pret_start` (
  `PretID` int(11) NOT NULL,
  `ValoarePret` float NOT NULL,
  `TipMoneda` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `pret_start`
--

INSERT INTO `pret_start` (`PretID`, `ValoarePret`, `TipMoneda`) VALUES
(1, 1500, 'lei'),
(2, 600, 'euro'),
(3, 300, 'lei'),
(4, 500, 'lei'),
(5, 100, 'euro'),
(6, 50, 'lire'),
(7, 400, 'euro'),
(8, 1000, 'lire'),
(9, 1200, 'lire'),
(10, 300, 'lire');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `producator`
--

CREATE TABLE `producator` (
  `ProducatorID` int(11) NOT NULL,
  `NumeProducator` varchar(50) NOT NULL,
  `TaraOrigine` varchar(50) NOT NULL,
  `AnInfiintare` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `producator`
--

INSERT INTO `producator` (`ProducatorID`, `NumeProducator`, `TaraOrigine`, `AnInfiintare`) VALUES
(1, 'Samsung', 'Coreea de Sud', 1938),
(2, 'Apple', 'SUA', 1976),
(3, 'Allview', 'Romania', 2002),
(4, 'Nokia', 'Finlanda', 1865),
(5, 'Motorola', 'SUA', 1928),
(6, 'HP', 'SUA', 1939),
(7, 'LG', 'Coreea de Sud', 1947),
(8, 'Lenovo', 'China', 1984),
(9, 'Xiaomi', 'China', 2010),
(10, 'Asus', 'Taiwan', 1989);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `telefon`
--

CREATE TABLE `telefon` (
  `TelefonID` int(11) NOT NULL,
  `NumeModel` varchar(50) NOT NULL,
  `Culoare` varchar(50) NOT NULL,
  `Procesor` varchar(50) NOT NULL,
  `MemorieExterna` int(11) NOT NULL,
  `MemorieRAM` float NOT NULL,
  `DimensiuneEcran` float DEFAULT NULL,
  `Greutate` int(11) DEFAULT NULL,
  `AnulProducerii` int(11) DEFAULT NULL,
  `ProducatorID` int(11) NOT NULL,
  `PretID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `telefon`
--

INSERT INTO `telefon` (`TelefonID`, `NumeModel`, `Culoare`, `Procesor`, `MemorieExterna`, `MemorieRAM`, `DimensiuneEcran`, `Greutate`, `AnulProducerii`, `ProducatorID`, `PretID`) VALUES
(1, 'Samsung A51', 'negru', 'Intel', 128, 4, 6.8, 148, 2018, 1, 1),
(2, 'Iphone 11', 'gri', 'iMac', 128, 3.5, 6.4, 153, 2019, 2, 2),
(4, 'Iphone 4', 'alb', 'iMac', 4, 0.5, 3.5, 200, 2010, 2, 5),
(5, 'Samsung A10', 'alb', 'Intel', 16, 2, 6.2, 178, 2017, 1, 3),
(6, 'Iphone 8', 'gri', 'iMac', 64, 4, 6.2, 154, 2017, 2, 7),
(7, 'Samsung J2', 'albastru', 'Intel', 1, 0.5, 3.8, 250, 2013, 1, 6),
(11, 'HP 7 Plus', 'gri', 'Intel', 16, 2, 6.3, 190, 2019, 6, 4);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `licitatie`
--
ALTER TABLE `licitatie`
  ADD PRIMARY KEY (`LicitatieID`);

--
-- Indexuri pentru tabele `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`ParticipantID`),
  ADD UNIQUE KEY `NumeUtilizator` (`NumeUtilizator`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `CNP` (`CNP`),
  ADD UNIQUE KEY `NumarTelefon` (`NumarTelefon`);

--
-- Indexuri pentru tabele `participare_licitatie_tel`
--
ALTER TABLE `participare_licitatie_tel`
  ADD PRIMARY KEY (`ParticipareLicitatieTelID`),
  ADD KEY `ParticipantID` (`ParticipantID`),
  ADD KEY `LicitatieID` (`LicitatieID`),
  ADD KEY `TelefonID` (`TelefonID`);

--
-- Indexuri pentru tabele `pret_start`
--
ALTER TABLE `pret_start`
  ADD PRIMARY KEY (`PretID`);

--
-- Indexuri pentru tabele `producator`
--
ALTER TABLE `producator`
  ADD PRIMARY KEY (`ProducatorID`),
  ADD UNIQUE KEY `NumeProducator` (`NumeProducator`);

--
-- Indexuri pentru tabele `telefon`
--
ALTER TABLE `telefon`
  ADD PRIMARY KEY (`TelefonID`),
  ADD UNIQUE KEY `NumeModel` (`NumeModel`),
  ADD KEY `PretID` (`PretID`),
  ADD KEY `ProducatorID` (`ProducatorID`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `licitatie`
--
ALTER TABLE `licitatie`
  MODIFY `LicitatieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pentru tabele `participant`
--
ALTER TABLE `participant`
  MODIFY `ParticipantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pentru tabele `participare_licitatie_tel`
--
ALTER TABLE `participare_licitatie_tel`
  MODIFY `ParticipareLicitatieTelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pentru tabele `pret_start`
--
ALTER TABLE `pret_start`
  MODIFY `PretID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pentru tabele `producator`
--
ALTER TABLE `producator`
  MODIFY `ProducatorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pentru tabele `telefon`
--
ALTER TABLE `telefon`
  MODIFY `TelefonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `participare_licitatie_tel`
--
ALTER TABLE `participare_licitatie_tel`
  ADD CONSTRAINT `participare_licitatie_tel_ibfk_4` FOREIGN KEY (`ParticipantID`) REFERENCES `participant` (`ParticipantID`),
  ADD CONSTRAINT `participare_licitatie_tel_ibfk_5` FOREIGN KEY (`LicitatieID`) REFERENCES `licitatie` (`LicitatieID`),
  ADD CONSTRAINT `participare_licitatie_tel_ibfk_6` FOREIGN KEY (`TelefonID`) REFERENCES `telefon` (`TelefonID`);

--
-- Constrângeri pentru tabele `telefon`
--
ALTER TABLE `telefon`
  ADD CONSTRAINT `telefon_ibfk_1` FOREIGN KEY (`PretID`) REFERENCES `pret_start` (`PretID`),
  ADD CONSTRAINT `telefon_ibfk_2` FOREIGN KEY (`ProducatorID`) REFERENCES `producator` (`ProducatorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
