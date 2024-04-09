-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 08:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `carrentalmanagementsys`
--
CREATE DATABASE IF NOT EXISTS `carrentalmanagementsys` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `carrentalmanagementsys`;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `CID` int(11) NOT NULL,
  `Firstname` varchar(30) NOT NULL,
  `Lastname` varchar(30) NOT NULL,
  `Address` varchar(35) NOT NULL,
  `Email_Address` varchar(25) NOT NULL,
  `Phone_Number` int(11) NOT NULL,
  `Driver_License_Number` int(11) NOT NULL,
  `Province_Of_Issue` varchar(20) NOT NULL,
  `License_Expiration_Date` date NOT NULL,
  `Card_Number` int(16) NOT NULL,
  `Billing_Address` varchar(35) NOT NULL,
  `Card_Expiration_Date` date NOT NULL,
  `Vehicle_Make` varchar(25) DEFAULT NULL,
  `Rental_Duration` int(3) DEFAULT NULL,
  `Pick_Up_Location` varchar(20) DEFAULT NULL,
  `Drop_Off_Location` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `EmpID` int(11) NOT NULL,
  `Firstname` varchar(30) NOT NULL,
  `Lastname` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(61) NOT NULL,
  `Access_Level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmpID`, `Firstname`, `Lastname`, `username`, `password`, `Access_Level`) VALUES
(1, 'System', 'Administrator', 'admin', '$2y$10$kbWN6weyDOz2kWlIVBpj4OZPVYlTWGyiMZlXEiUWZtyGPKvOeVew6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rentalsandreturns`
--

DROP TABLE IF EXISTS `rentalsandreturns`;
CREATE TABLE `rentalsandreturns` (
  `RID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `VID` varchar(17) NOT NULL,
  `Rental_Period_Start` date NOT NULL,
  `Rental_Period_End` date NOT NULL,
  `Rate` decimal(15,2) NOT NULL,
  `Additional_Fees` decimal(15,2) NOT NULL,
  `Status` varchar(25) NOT NULL,
  `Condition` varchar(25) NOT NULL,
  `Card_Type` varchar(25) NOT NULL,
  `Amount_Paid` decimal(15,2) NOT NULL,
  `Amount_Owed` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `Rolename` varchar(25) NOT NULL,
  `Access_Level` int(11) NOT NULL,
  `Description` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Rolename`, `Access_Level`, `Description`) VALUES
('Administrator', 1, 'Full access to all sections'),
('Manager', 2, 'Manage employees\r\nBan/remove customers\r\nRemove vehicles from fleet, etc\r\n'),
('Accounts Agent', 3, 'Register new vehicles to fleet\r\nUpdate vehicle data\r\nGenerate reports'),
('Rental Agent', 4, 'Manage Customers\r\nManage Rentals\r\nGenerate Invoices\r\nReceive Payments');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE `vehicles` (
  `Make` varchar(25) NOT NULL,
  `Model` varchar(25) NOT NULL,
  `VID` varchar(17) NOT NULL,
  `Color` varchar(15) NOT NULL,
  `License_Plate` varchar(10) NOT NULL,
  `Odometer_Reading` int(7) NOT NULL,
  `Availability` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmpID`),
  ADD KEY `Access_Level` (`Access_Level`);

--
-- Indexes for table `rentalsandreturns`
--
ALTER TABLE `rentalsandreturns`
  ADD PRIMARY KEY (`RID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `VID` (`VID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Access_Level`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`VID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rentalsandreturns`
--
ALTER TABLE `rentalsandreturns`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Access_Level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `FK_Access_Level` FOREIGN KEY (`Access_Level`) REFERENCES `roles` (`Access_Level`);

--
-- Constraints for table `rentalsandreturns`
--
ALTER TABLE `rentalsandreturns`
  ADD CONSTRAINT `FK_CID` FOREIGN KEY (`CID`) REFERENCES `customers` (`CID`),
  ADD CONSTRAINT `FK_VID` FOREIGN KEY (`VID`) REFERENCES `vehicles` (`VID`);
COMMIT;