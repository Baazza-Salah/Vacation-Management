-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 31, 2024 at 12:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GestionConge`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminPPR` int(11) NOT NULL,
  `cnie` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminPPR`, `cnie`, `username`, `password`, `nom`, `prenom`, `email`) VALUES
(0, 'zg10001', 'admin', 'admin', 'admin', 'admin', 'admin@admin.ma'),
(1, 'ha098123', 'user', 'user', 'user', 'user', 'user@user.ma');

-- --------------------------------------------------------

--
-- Table structure for table `DemandeConge`
--

CREATE TABLE `DemandeConge` (
  `idDemande` int(11) NOT NULL,
  `Duree` int(11) DEFAULT NULL,
  `DateDebut` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL,
  `Description` longtext DEFAULT NULL,
  `Etat` varchar(255) DEFAULT NULL,
  `NumPPR` int(11) DEFAULT NULL,
  `idConge` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `DemandeConge`
--

INSERT INTO `DemandeConge` (`idDemande`, `Duree`, `DateDebut`, `DateFin`, `Description`, `Etat`, `NumPPR`, `idConge`) VALUES
(2, 7, '2024-07-10', '2024-07-11', 'Medical appointment', 'Rejected', 2000, 2),
(3, 12, '2024-08-01', '2024-08-15', 'Extended vacation', 'Rejected', 2001, 1),
(4, 4, '2024-09-01', '2024-09-10', 'Paternity leave for the birth of my child', 'Pending', 2003, 2),
(12, 5, '2024-07-01', '2024-07-05', 'Annual leave for summer vacation', 'Rejected', 2002, 1),
(22, 7, '2024-07-10', '2024-07-11', 'Medical appointment', 'Rejected', 2000, 2),
(32, 12, '2024-08-01', '2024-08-15', 'Extended vacation', 'Rejected', 2001, 1),
(42, 4, '2024-09-01', '2024-09-10', 'Paternity leave for the birth of my child', 'Pending', 2003, 2),
(431, 5, '2024-07-01', '2024-07-05', 'Annual leave for summer vacation', 'Pending', 2002, 1),
(432, 7, '2024-07-10', '2024-07-11', 'Medical appointment', 'Rejected', 2000, 2),
(435, 12, '2024-08-01', '2024-08-15', 'Extended vacation', 'Rejected', 2001, 1),
(440, 4, '2024-09-01', '2024-09-10', 'Paternity leave for the birth of my child', 'Rejected', 2003, 2),
(523, 7, '2024-08-01', '2024-08-08', 'Family vacation', 'Approved', 2004, 1),
(1001, 5, '2024-07-01', '2024-07-05', 'Annual leave', 'Approved', 2000, 1),
(1002, 7, '2024-07-10', '2024-07-17', 'Medical leave', 'Rejected', 2001, 2),
(1003, 10, '2024-08-01', '2024-08-11', 'Vacation', 'Rejected', 2002, 1),
(1004, 15, '2024-08-15', '2024-08-30', 'Family visit', 'Rejected', 2003, 2),
(1005, 8, '2024-09-01', '2024-09-09', 'Conference', 'Approved', 2004, 1),
(1006, 3, '2024-09-10', '2024-09-13', 'Short break', 'Approved', 2005, 2),
(1007, 6, '2024-09-15', '2024-09-21', 'Personal leave', 'Approved', 2006, 1),
(1008, 4, '2024-10-01', '2024-10-05', 'Health leave', 'Rejected', 2007, 2),
(1009, 12, '2024-10-10', '2024-10-22', 'Family emergency', 'Rejected', 2008, 1),
(1010, 14, '2024-10-23', '2024-11-06', 'Travel', 'Rejected', 2009, 2),
(1011, 5, '2024-11-07', '2024-11-12', 'Annual leave', 'Approved', 2010, 1),
(1012, 9, '2024-11-13', '2024-11-22', 'Study leave', 'Rejected', 2011, 2),
(1013, 11, '2024-11-23', '2024-12-04', 'Project work', 'Approved', 2012, 1),
(1014, 7, '2024-12-05', '2024-12-12', 'Holiday', 'Pending', 2013, 2),
(1015, 10, '2024-12-13', '2024-12-23', 'Vacation', 'Approved', 2014, 1),
(1016, 5, '2025-01-01', '2025-01-06', 'Annual leave', 'Approved', 2015, 2),
(1017, 6, '2025-01-07', '2025-01-13', 'Medical leave', 'Approved', 2016, 1),
(1018, 8, '2025-01-14', '2025-01-22', 'Family visit', 'Pending', 2017, 2),
(1019, 7, '2025-01-23', '2025-01-30', 'Conference', 'Pending', 2018, 1),
(1020, 5, '2025-02-01', '2025-02-06', 'Short break', 'Pending', 2019, 2),
(1021, 10, '2025-02-07', '2025-02-17', 'Personal leave', 'Pending', 2020, 1),
(1022, 6, '2025-02-18', '2025-02-24', 'Health leave', 'Pending', 2021, 2),
(1023, 9, '2025-02-25', '2025-03-05', 'Family emergency', 'Pending', 2022, 1),
(1024, 8, '2025-03-06', '2025-03-14', 'Travel', 'Pending', 2023, 2),
(1025, 12, '2025-03-15', '2025-03-27', 'Project work', 'Pending', 2024, 1),
(1026, 7, '2025-03-28', '2025-04-04', 'Holiday', 'Approved', 2025, 2),
(1027, 11, '2025-04-05', '2025-04-16', 'Study leave', 'Pending', 2026, 1),
(1028, 5, '2025-04-17', '2025-04-22', 'Annual leave', 'Approved', 2027, 2),
(1029, 8, '2025-04-23', '2025-05-01', 'Medical leave', 'Pending', 2028, 1),
(1030, 6, '2025-05-02', '2025-05-08', 'Family visit', 'Pending', 2029, 2),
(1032, 10, '2025-05-17', '2025-05-27', 'Short break', 'Rejected', 2000, 2),
(1033, 5, '2025-05-28', '2025-06-02', 'Personal leave', 'Approved', 2001, 1),
(1034, 9, '2025-06-03', '2025-06-12', 'Health leave', 'Approved', 2002, 2),
(1035, 6, '2025-06-13', '2025-06-19', 'Family emergency', 'Approved', 2003, 1),
(1036, 8, '2025-06-20', '2025-06-28', 'Travel', 'Rejected', 2004, 2),
(1037, 12, '2025-06-29', '2025-07-11', 'Project work', 'Approved', 2005, 1),
(1038, 7, '2025-07-12', '2025-07-19', 'Holiday', 'Approved', 2006, 2),
(1039, 11, '2025-07-20', '2025-07-31', 'Study leave', 'Rejected', 2007, 1),
(1040, 10, '2025-08-01', '2025-08-11', 'Vacation', 'Rejected', 2008, 2),
(1041, 6, '2025-08-12', '2025-08-18', 'Medical leave', 'Approved', 2009, 1),
(1042, 9, '2025-08-19', '2025-08-28', 'Family visit', 'Approved', 2010, 2),
(1043, 7, '2025-08-29', '2025-09-05', 'Conference', 'Rejected', 2011, 1),
(1044, 8, '2025-09-06', '2025-09-14', 'Short break', 'Rejected', 2012, 2),
(1045, 10, '2025-09-15', '2025-09-25', 'Personal leave', 'Approved', 2013, 1),
(1046, 5, '2025-09-26', '2025-10-01', 'Health leave', 'Approved', 2014, 2),
(5000, 5, '2024-07-02', '2024-07-09', 'hahaha', 'Approved', 2000, 1),
(5003, 5, '2024-07-01', '2024-07-05', 'QWERTYUIOPASDFGHJKL;ZXCVBNM', 'Rejected', 2000, 1),
(5006, 4, '2024-07-04', '2024-07-31', 'hahaha', 'Approved', 2024, 2),
(5008, 10, '2002-10-10', '2002-12-10', 'jjj', 'Rejected', 2000, 1),
(5009, 12, '1222-12-12', '2221-12-12', '21212\r\n', 'Pending', 33737373, 1),
(5010, 6, '2024-02-20', '2024-01-22', 'h', 'Approved', 33737373, 1),
(5011, 5, '2024-10-10', '2024-10-15', 'ha', 'Approved', 2024, 2);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `InfoEmployee`
--

CREATE TABLE `InfoEmployee` (
  `numPPR` int(11) NOT NULL,
  `cnie` varchar(255) DEFAULT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `Prenom` varchar(255) DEFAULT NULL,
  `DateNaissance` date DEFAULT NULL,
  `DateEffet` date DEFAULT NULL,
  `Grade` varchar(255) DEFAULT NULL,
  `affectation` varchar(255) DEFAULT NULL,
  `fonction` varchar(255) DEFAULT NULL,
  `situationFamiliale` varchar(255) DEFAULT NULL,
  `echelon` int(11) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `jourRestant` int(11) DEFAULT 22,
  `gender` varchar(50) DEFAULT NULL,
  `jourRestantExcep` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `InfoEmployee`
--

INSERT INTO `InfoEmployee` (`numPPR`, `cnie`, `Nom`, `Prenom`, `DateNaissance`, `DateEffet`, `Grade`, `affectation`, `fonction`, `situationFamiliale`, `echelon`, `adresse`, `jourRestant`, `gender`, `jourRestantExcep`) VALUES
(2000, 'AB123456', 'b', 'Salah', '1990-01-15', '2020-05-01', 'Comptable', 'IT Department', 'Software Developer', 'Single', 3, '123 Main St, Cityville', 7, 'male', 3),
(2001, 'EF345678', 'Brown', 'Charlie', '1978-11-30', '2015-11-05', 'Manager', 'HR Department', 'HR Manager', 'Married', 7, '789 Pine St, Villagetown', 5, 'male', 3),
(2002, 'CD789012', 'Smith', 'Jane', '1985-07-22', '2018-03-15', 'Senior Engineer', 'R&D Department', 'Team Lead', 'Married', 5, '456 Oak St, Townsville', 2, 'female', 1),
(2003, 'GH901234', 'Johnson', 'Alice', '1992-04-10', '2021-08-20', 'Technician', 'Maintenance Department', 'Field Technician', 'Single', 2, '101 Maple St, Hamletburg', 16, 'female', 2),
(2004, 'IJ234567', 'White', 'James', '1980-02-12', '2019-01-10', 'Assistant', 'Finance Department', 'Accountant', 'Married', 4, '234 Elm St, Metropolis', 0, 'Male', 5),
(2005, 'KL345678', 'Green', 'Emily', '1991-05-23', '2017-06-21', 'Analyst', 'Marketing Department', 'Marketing Analyst', 'Single', 3, '567 Birch St, Cityplace', 6, 'Female', 4),
(2006, 'MN456789', 'Black', 'Michael', '1982-09-17', '2016-02-14', 'Coordinator', 'Sales Department', 'Sales Coordinator', 'Married', 6, '890 Cedar St, Townburg', 4, 'Male', 3),
(2007, 'OP567890', 'Brown', 'Sarah', '1985-10-30', '2015-08-25', 'Consultant', 'Consulting Department', 'Business Consultant', 'Married', 5, '123 Ash St, Bigcity', 12, 'Female', 3),
(2008, 'QR678901', 'Jones', 'Chris', '1993-03-05', '2021-12-01', 'Developer', 'IT Department', 'Web Developer', 'Single', 4, '456 Spruce St, Smalltown', 20, 'Male', 6),
(2009, 'ST789012', 'Wilson', 'Patricia', '1987-07-14', '2018-05-30', 'Designer', 'Design Department', 'Graphic Designer', 'Single', 2, '789 Willow St, Midtown', 16, 'Female', 8),
(2010, 'UV890123', 'Taylor', 'Mark', '1990-06-17', '2016-11-10', 'Engineer', 'Engineering Department', 'Civil Engineer', 'Married', 7, '321 Poplar St, Downtown', 9, 'Male', 1),
(2011, 'WX901234', 'Martinez', 'Nancy', '1992-09-22', '2020-04-04', 'Technician', 'Technical Department', 'Lab Technician', 'Single', 6, '654 Fir St, Uptown', 19, 'Female', 7),
(2012, 'YZ012345', 'Anderson', 'Steven', '1984-11-19', '2019-02-20', 'Supervisor', 'Operations Department', 'Operations Supervisor', 'Married', 8, '987 Redwood St, Suburbia', 5, 'Male', 9),
(2013, 'AB123456', 'Thomas', 'Linda', '1991-08-11', '2017-07-15', 'Clerk', 'Administration Department', 'Office Clerk', 'Single', 5, '543 Cedar St, Citycenter', 3, 'Female', 4),
(2014, 'CD234567', 'Harris', 'Robert', '1983-05-08', '2018-09-29', 'Manager', 'Management Department', 'Project Manager', 'Married', 4, '876 Oak St, Ruralville', 7, 'Male', 1),
(2015, 'EF345678', 'Clark', 'Elizabeth', '1994-10-25', '2019-11-12', 'Analyst', 'Data Department', 'Data Analyst', 'Single', 6, '210 Pine St, Hilltown', 20, 'Female', 3),
(2016, 'GH456789', 'Lewis', 'James', '1988-01-02', '2015-01-14', 'Engineer', 'Construction Department', 'Mechanical Engineer', 'Married', 7, '123 Maple St, Valleytown', 9, 'Male', 10),
(2017, 'IJ567890', 'Robinson', 'Barbara', '1986-02-27', '2017-03-20', 'Specialist', 'Quality Department', 'Quality Specialist', 'Single', 3, '456 Elm St, Lakecity', 22, 'Female', 5),
(2018, 'KL678901', 'Walker', 'John', '1995-04-16', '2020-06-06', 'Coordinator', 'Logistics Department', 'Logistics Coordinator', 'Single', 4, '789 Birch St, Riverdale', 14, 'Male', 7),
(2019, 'MN789012', 'Hall', 'Karen', '1981-11-23', '2016-08-11', 'Assistant', 'Support Department', 'Administrative Assistant', 'Married', 5, '321 Spruce St, Greentown', 18, 'Female', 9),
(2020, 'OP890123', 'Allen', 'David', '1990-03-12', '2019-04-05', 'Technician', 'Maintenance Department', 'Field Technician', 'Single', 6, '654 Ash St, Bluetown', 20, 'Male', 10),
(2021, 'QR901234', 'Young', 'Rebecca', '1992-06-09', '2018-07-27', 'Consultant', 'Advisory Department', 'Financial Consultant', 'Single', 3, '987 Willow St, Orangetown', 13, 'Female', 6),
(2022, 'ST012345', 'King', 'Daniel', '1985-09-18', '2017-10-22', 'Developer', 'Software Department', 'Software Developer', 'Married', 7, '543 Poplar St, Graytown', 15, 'Male', 9),
(2023, 'UV123456', 'Wright', 'Patricia', '1983-12-15', '2020-05-19', 'Designer', 'Creative Department', 'UI/UX Designer', 'Single', 5, '876 Fir St, Blacktown', 18, 'Female', 8),
(2024, 'WX234567', 'Lopez', 'Steven', '1991-03-01', '2018-01-11', 'Manager', 'Operations Department', 'Operations Manager', 'Married', 4, '210 Redwood St, Silvertown', 22, 'Male', 5),
(2025, 'YZ345678', 'Scott', 'Nancy', '1987-08-20', '2015-02-25', 'Supervisor', 'Supervision Department', 'Shift Supervisor', 'Single', 6, '123 Oak St, Goldtown', 10, 'Female', 3),
(2026, 'AB456789', 'Hill', 'Robert', '1994-07-05', '2019-09-16', 'Engineer', 'Industrial Department', 'Industrial Engineer', 'Married', 7, '456 Pine St, Whitetown', 14, 'Male', 5),
(2027, 'CD567890', 'Adams', 'Emily', '1989-01-26', '2016-03-08', 'Specialist', 'Health Department', 'Health Specialist', 'Single', 3, '789 Maple St, Redtown', 17, 'Female', 3),
(2028, 'EF678901', 'Baker', 'James', '1995-10-02', '2021-11-21', 'Clerk', 'Clerical Department', 'Office Clerk', 'Single', 4, '321 Elm St, Greentown', 20, 'Male', 6),
(2029, 'GH789012', 'Gonzalez', 'Linda', '1984-06-14', '2017-05-14', 'Analyst', 'Research Department', 'Research Analyst', 'Married', 5, '654 Birch St, Bluetown', 22, 'Female', 7),
(200210, 'ZG11111', 'Baazza', 'Salaheddine', '2002-10-01', '2021-08-20', 'SOC', 'IT Department', 'Field Engineer', 'Single', 12, 'Guercif', 22, 'male', 10),
(301910, 'LM301910', 'Messi', 'Leonel andress', '1985-07-01', '2002-07-01', 'GOAT', '2002-07-01', 'Football Player', 'Married', 99, 'mirikan', 22, 'Male', 10),
(987654, 'qw123445', 'userrrrr', 'user', '2000-10-01', '2024-10-10', 'it depart', '2024-10-10', 'it support', 'Married', 9, 'who knows', 22, 'Female', 10),
(33737373, 'zh4567', 'testH', 'test', '2024-07-09', '2024-06-30', 'test', '2024-06-30', 'test', 'Single', 5, 'guercif 35000', 16, 'Male', 22),
(1239876577, 'ha101010', 'hahaha', 'hahaha', '2024-07-10', '2024-07-31', 'hahaha', '2024-07-31', 'hahahaha', 'Single', 7, '1234wertyuiop', 22, 'Male', 10);

-- --------------------------------------------------------

--
-- Table structure for table `TypeConge`
--

CREATE TABLE `TypeConge` (
  `idConge` int(11) NOT NULL,
  `intitule` varchar(255) DEFAULT NULL,
  `NombreJours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `TypeConge`
--

INSERT INTO `TypeConge` (`idConge`, `intitule`, `NombreJours`) VALUES
(1, 'Administrative', 22),
(2, 'Exceptionel', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminPPR`);

--
-- Indexes for table `DemandeConge`
--
ALTER TABLE `DemandeConge`
  ADD PRIMARY KEY (`idDemande`),
  ADD KEY `NumPPR` (`NumPPR`),
  ADD KEY `idConge` (`idConge`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `InfoEmployee`
--
ALTER TABLE `InfoEmployee`
  ADD PRIMARY KEY (`numPPR`);

--
-- Indexes for table `TypeConge`
--
ALTER TABLE `TypeConge`
  ADD PRIMARY KEY (`idConge`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DemandeConge`
--
ALTER TABLE `DemandeConge`
  MODIFY `idDemande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5012;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `DemandeConge`
--
ALTER TABLE `DemandeConge`
  ADD CONSTRAINT `DemandeConge_ibfk_1` FOREIGN KEY (`NumPPR`) REFERENCES `InfoEmployee` (`numPPR`),
  ADD CONSTRAINT `DemandeConge_ibfk_2` FOREIGN KEY (`idConge`) REFERENCES `TypeConge` (`idConge`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
