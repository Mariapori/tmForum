-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11.05.2021 klo 00:34
-- Palvelimen versio: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tmforum`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `kayttajat`
--

CREATE TABLE `kayttajat` (
  `KayttajaID` int(11) NOT NULL,
  `Kayttajanimi` varchar(255) NOT NULL,
  `Salasana` varchar(255) NOT NULL,
  `Kuva` varchar(255) NOT NULL,
  `Rooli` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Rakenne taululle `langanviestit`
--

CREATE TABLE `langanviestit` (
  `ViestiID` int(11) NOT NULL,
  `Lanka` int(11) NOT NULL,
  `Viesti` varchar(1000) NOT NULL,
  `Kirjoittaja` int(11) NOT NULL,
  `PVM` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Rakenne taululle `langat`
--

CREATE TABLE `langat` (
  `LankaID` int(11) NOT NULL,
  `Nimi` varchar(255) NOT NULL,
  `Luonut` int(11) NOT NULL,
  `PVM` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `kayttajat`
--
ALTER TABLE `kayttajat`
  ADD PRIMARY KEY (`KayttajaID`);

--
-- Indexes for table `langanviestit`
--
ALTER TABLE `langanviestit`
  ADD PRIMARY KEY (`ViestiID`),
  ADD KEY `Kirjoittaja` (`Kirjoittaja`),
  ADD KEY `Lanka` (`Lanka`);

--
-- Indexes for table `langat`
--
ALTER TABLE `langat`
  ADD PRIMARY KEY (`LankaID`),
  ADD KEY `Luoja` (`Luonut`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kayttajat`
--
ALTER TABLE `kayttajat`
  MODIFY `KayttajaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `langanviestit`
--
ALTER TABLE `langanviestit`
  MODIFY `ViestiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `langat`
--
ALTER TABLE `langat`
  MODIFY `LankaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `langanviestit`
--
ALTER TABLE `langanviestit`
  ADD CONSTRAINT `Kirjoittaja` FOREIGN KEY (`Kirjoittaja`) REFERENCES `kayttajat` (`KayttajaID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `Lanka` FOREIGN KEY (`Lanka`) REFERENCES `langat` (`LankaID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Rajoitteet taululle `langat`
--
ALTER TABLE `langat`
  ADD CONSTRAINT `Luoja` FOREIGN KEY (`Luonut`) REFERENCES `kayttajat` (`KayttajaID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
