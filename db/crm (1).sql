-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2018 at 02:15 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `callingreport`
--

CREATE TABLE `callingreport` (
  `callingReportId` int(11) NOT NULL,
  `report` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(45) NOT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `comments` varchar(100) DEFAULT NULL,
  `leadId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countryId` int(11) NOT NULL,
  `countryName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `designationId` int(11) NOT NULL,
  `designationName` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `followup`
--

CREATE TABLE `followup` (
  `followId` int(11) NOT NULL,
  `leadId` int(11) NOT NULL,
  `followUpDate` datetime NOT NULL,
  `comment` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leadassigned`
--

CREATE TABLE `leadassigned` (
  `assignId` int(11) NOT NULL,
  `assignBy` int(11) NOT NULL,
  `assignTo` int(11) DEFAULT NULL,
  `leadId` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `leadId` int(11) NOT NULL,
  `statusId` int(11) NOT NULL,
  `possibiliyId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `companyName` varchar(500) DEFAULT NULL,
  `personName` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contactNumber` varchar(45) DEFAULT NULL,
  `countryId` varchar(45) DEFAULT NULL,
  `comments` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `minedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leadstatus`
--

CREATE TABLE `leadstatus` (
  `statusId` int(11) NOT NULL,
  `statusName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `leaveId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `cause` varchar(1000) NOT NULL,
  `startDate` varchar(45) NOT NULL,
  `endDate` varchar(45) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `noticeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `possibilities`
--

CREATE TABLE `possibilities` (
  `possibilityId` int(11) NOT NULL,
  `possibilityName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `possibilitychanges`
--

CREATE TABLE `possibilitychanges` (
  `changeId` int(11) NOT NULL,
  `leadId` int(11) DEFAULT NULL,
  `oldPossibilityId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `possibilityId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `userType` int(11) NOT NULL,
  `userEmail` varchar(45) NOT NULL,
  `password` varchar(60) NOT NULL,
  `rfID` int(11) DEFAULT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `designationId` int(11) DEFAULT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `picture` varchar(45) DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` char(1) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE `usertypes` (
  `typeId` int(11) NOT NULL,
  `typeName` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workprogress`
--

CREATE TABLE `workprogress` (
  `progressId` int(11) NOT NULL,
  `callingType` varchar(50) DEFAULT NULL,
  `response` varchar(45) DEFAULT NULL,
  `leadId` int(11) DEFAULT NULL,
  `progress` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `callingreport`
--
ALTER TABLE `callingreport`
  ADD PRIMARY KEY (`callingReportId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`),
  ADD UNIQUE KEY `category_name_UNIQUE` (`categoryName`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `fk_lead_id_idx` (`leadId`),
  ADD KEY `fk_user_id_idx` (`userId`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryId`),
  ADD UNIQUE KEY `category_name_UNIQUE` (`countryName`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`designationId`);

--
-- Indexes for table `followup`
--
ALTER TABLE `followup`
  ADD PRIMARY KEY (`followId`),
  ADD KEY `fk_lead_id_idx` (`leadId`),
  ADD KEY `fk_user_id_followup_idx` (`userId`);

--
-- Indexes for table `leadassigned`
--
ALTER TABLE `leadassigned`
  ADD PRIMARY KEY (`assignId`),
  ADD KEY `fk_lead_id_idx` (`leadId`),
  ADD KEY `fk_assignBy_idx` (`assignBy`),
  ADD KEY `fk_assignTo_idx` (`assignTo`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`leadId`),
  ADD KEY `fk_leads_possibilitys1_idx` (`possibiliyId`),
  ADD KEY `fk_leads_categories1_idx` (`categoryId`),
  ADD KEY `fk_status_id_idx` (`statusId`),
  ADD KEY `fk_country_id_idx` (`countryId`),
  ADD KEY `fk_mined_by_idx` (`minedBy`);

--
-- Indexes for table `leadstatus`
--
ALTER TABLE `leadstatus`
  ADD PRIMARY KEY (`statusId`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`leaveId`),
  ADD KEY `fk_leaves_users_idx` (`userId`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`noticeId`),
  ADD KEY `fk_notices_Users1_idx` (`userId`),
  ADD KEY `fh_category_id_idx` (`categoryId`);

--
-- Indexes for table `possibilities`
--
ALTER TABLE `possibilities`
  ADD PRIMARY KEY (`possibilityId`),
  ADD UNIQUE KEY `possibility_name_UNIQUE` (`possibilityName`);

--
-- Indexes for table `possibilitychanges`
--
ALTER TABLE `possibilitychanges`
  ADD PRIMARY KEY (`changeId`),
  ADD KEY `fk_lead_possibility_idx` (`leadId`),
  ADD KEY `fk_user_pos_changr_idx` (`userId`),
  ADD KEY `fk_possibilityChanges_possibilities1_idx` (`possibilityId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `user_email_UNIQUE` (`userEmail`),
  ADD UNIQUE KEY `userId_UNIQUE` (`userId`),
  ADD KEY `fk_user_type_idx` (`userType`),
  ADD KEY `fk_designation_id_idx` (`designationId`);

--
-- Indexes for table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`typeId`),
  ADD UNIQUE KEY `type_name_UNIQUE` (`typeName`);

--
-- Indexes for table `workprogress`
--
ALTER TABLE `workprogress`
  ADD PRIMARY KEY (`progressId`),
  ADD KEY `fk_lead_id_idx` (`leadId`),
  ADD KEY `fk_user_id_work_idx` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `callingreport`
--
ALTER TABLE `callingreport`
  MODIFY `callingReportId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `countryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `designationId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `followup`
--
ALTER TABLE `followup`
  MODIFY `followId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leadstatus`
--
ALTER TABLE `leadstatus`
  MODIFY `statusId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `leaveId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `noticeId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `possibilities`
--
ALTER TABLE `possibilities`
  MODIFY `possibilityId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `possibilitychanges`
--
ALTER TABLE `possibilitychanges`
  MODIFY `changeId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workprogress`
--
ALTER TABLE `workprogress`
  MODIFY `progressId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_lead_comments` FOREIGN KEY (`leadId`) REFERENCES `leads` (`leadId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_comments` FOREIGN KEY (`userId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `followup`
--
ALTER TABLE `followup`
  ADD CONSTRAINT `fk_lead_id_followup` FOREIGN KEY (`leadId`) REFERENCES `leads` (`leadId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id_followup` FOREIGN KEY (`userId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leadassigned`
--
ALTER TABLE `leadassigned`
  ADD CONSTRAINT `fk_assignBy` FOREIGN KEY (`assignBy`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_assignTo` FOREIGN KEY (`assignTo`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lead_id` FOREIGN KEY (`leadId`) REFERENCES `leads` (`leadId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_country_id` FOREIGN KEY (`countryId`) REFERENCES `countries` (`countryName`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_leadStatus_id` FOREIGN KEY (`statusId`) REFERENCES `leadstatus` (`statusId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mined_by` FOREIGN KEY (`minedBy`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_possibility_id` FOREIGN KEY (`possibiliyId`) REFERENCES `possibilities` (`possibilityId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `fk_leaves_users` FOREIGN KEY (`userId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `fh_category_id` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `possibilitychanges`
--
ALTER TABLE `possibilitychanges`
  ADD CONSTRAINT `fk_lead_possibility` FOREIGN KEY (`leadId`) REFERENCES `leads` (`leadId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_possibilityChanges_possibilities1` FOREIGN KEY (`possibilityId`) REFERENCES `possibilities` (`possibilityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_pos_change` FOREIGN KEY (`userId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_designation_id` FOREIGN KEY (`designationId`) REFERENCES `designations` (`designationId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_type` FOREIGN KEY (`userType`) REFERENCES `usertypes` (`typeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workprogress`
--
ALTER TABLE `workprogress`
  ADD CONSTRAINT `fk_lead_id_work` FOREIGN KEY (`leadId`) REFERENCES `leads` (`leadId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id_work` FOREIGN KEY (`userId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
