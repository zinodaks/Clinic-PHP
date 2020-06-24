-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2020 at 08:57 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `patientUser` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `symptomsDescription` tinytext NOT NULL,
  `isFirstVisit` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `consultationID` int(11) NOT NULL,
  `patientUsername` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `payment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`username`, `password`) VALUES
('doctorName', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicineID` int(11) NOT NULL,
  `medicineName` varchar(60) NOT NULL,
  `composition` text NOT NULL,
  `usedFor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicineID`, `medicineName`, `composition`, `usedFor`) VALUES
(1, 'Panadol', 'Paracetemol', 'headache , stomachache , fever'),
(2, 'Ibuprofen', 'Ibuprofen', 'menstrual periods, migraines, and rheumatoid arthritis'),
(3, 'Augmentin', 'Amoxicillin', 'sinusitis, pneumonia, ear infections, bronchitis, urinary tract infections, and infections of the skin'),
(4, 'Toplexil', 'Oxomemazine/guaifenesin', 'coughs without phlegm'),
(5, 'Vermox', 'Mebendazole', 'pinworm disease, hookworm infections, guinea worm infections, hydatid disease, and giardia'),
(6, 'Flixonase', 'Fluticasone propionate', 'hay fever and nasal polyps'),
(7, 'Profinal', 'Ibuprofen', ' fever and relieve pain'),
(8, 'Flagyl', 'Metronidazole', 'pelvic inflammatory disease, endocarditis, and bacterial vaginosis'),
(9, 'Malarone', 'Atovaquone/Proguanil', 'malaria, including chloroquine-resistant malaria'),
(10, 'Visine', 'Tetryzoline', ' eye drops and nasal sprays'),
(11, ' Lioresal', 'Baclofen', 'muscle spasticity such as from a spinal cord injury or multiple sclerosis');

-- --------------------------------------------------------

--
-- Table structure for table `patientinfo`
--

CREATE TABLE `patientinfo` (
  `patientUser` varchar(30) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `SSN` int(9) NOT NULL,
  `phoneNumber` int(20) NOT NULL,
  `bloodgroup` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patientinfo`
--

INSERT INTO `patientinfo` (`patientUser`, `firstName`, `lastName`, `dateOfBirth`, `SSN`, `phoneNumber`, `bloodgroup`) VALUES
('user', 'John', 'Doe', '0000-00-00', 123456789, 81000000, 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `patientlogin`
--

CREATE TABLE `patientlogin` (
  `patientUser` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patientlogin`
--

INSERT INTO `patientlogin` (`patientUser`, `password`) VALUES
('user', 'User12345');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `prescriptionID` int(11) NOT NULL,
  `consultationID` int(11) NOT NULL,
  `medicineID` int(11) NOT NULL,
  `usageDesc` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`patientUser`,`date`),
  ADD KEY `patientUser` (`patientUser`,`date`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`consultationID`,`patientUsername`,`date`),
  ADD KEY `patientUsername` (`patientUsername`,`date`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicineID`);

--
-- Indexes for table `patientinfo`
--
ALTER TABLE `patientinfo`
  ADD PRIMARY KEY (`patientUser`);

--
-- Indexes for table `patientlogin`
--
ALTER TABLE `patientlogin`
  ADD PRIMARY KEY (`patientUser`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`prescriptionID`),
  ADD KEY `consultationID` (`consultationID`,`medicineID`),
  ADD KEY `medicineID` (`medicineID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `consultationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `prescriptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patientUser`) REFERENCES `patientlogin` (`patientUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patientinfo`
--
ALTER TABLE `patientinfo`
  ADD CONSTRAINT `patientinfo_ibfk_1` FOREIGN KEY (`patientUser`) REFERENCES `patientlogin` (`patientUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`medicineID`) REFERENCES `medicine` (`medicineID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prescription_ibfk_2` FOREIGN KEY (`consultationID`) REFERENCES `consultations` (`consultationID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
