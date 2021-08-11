-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2021 at 12:49 PM
-- Server version: 10.3.31-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpm836475_tmForum`
--

-- --------------------------------------------------------

--
-- Table structure for table `kayttajat`
--

CREATE TABLE `kayttajat` (
  `KayttajaID` int(11) NOT NULL,
  `Kayttajanimi` varchar(255) NOT NULL,
  `Salasana` varchar(255) NOT NULL,
  `Kuva` varchar(255) NOT NULL DEFAULT 'https://img.ilcdn.fi/W3NZqtFn2x5avcK1p5wUuTDMS7M=/full-fit-in/612x0/img-s3.ilcdn.fi/4553c0d5b295cd783ea2f7498ea41dcee06fc3212cff54ab2ac292df2497e2a2.jpg',
  `Rooli` varchar(50) NOT NULL,
  `Sposti` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `langanviestit`
--

CREATE TABLE `langanviestit` (
  `ViestiID` int(11) NOT NULL,
  `Lanka` int(11) NOT NULL,
  `Viesti` varchar(1000) NOT NULL,
  `Kirjoittaja` int(11) NOT NULL,
  `PVM` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `langat`
--

CREATE TABLE `langat` (
  `LankaID` int(11) NOT NULL,
  `Nimi` varchar(255) NOT NULL,
  `Luonut` int(11) NOT NULL,
  `PVM` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `KayttajaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `langanviestit`
--
ALTER TABLE `langanviestit`
  MODIFY `ViestiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `langat`
--
ALTER TABLE `langat`
  MODIFY `LankaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `langanviestit`
--
ALTER TABLE `langanviestit`
  ADD CONSTRAINT `Kirjoittaja` FOREIGN KEY (`Kirjoittaja`) REFERENCES `kayttajat` (`KayttajaID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `Lanka` FOREIGN KEY (`Lanka`) REFERENCES `langat` (`LankaID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `langat`
--
ALTER TABLE `langat`
  ADD CONSTRAINT `Luoja` FOREIGN KEY (`Luonut`) REFERENCES `kayttajat` (`KayttajaID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
