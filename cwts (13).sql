-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2026 at 07:58 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cwts`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements_tbl`
--

CREATE TABLE `announcements_tbl` (
  `announcement_id` int(11) NOT NULL,
  `subject_announcement` text NOT NULL,
  `announcement` text NOT NULL,
  `date_created` text NOT NULL,
  `announcement_status` text NOT NULL,
  `college_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcements_tbl`
--

INSERT INTO `announcements_tbl` (`announcement_id`, `subject_announcement`, `announcement`, `date_created`, `announcement_status`, `college_id`) VALUES
(2, 'Meeting', 'What: General Assembly\r\nWhere: School\r\nWhen: Dec 12 asd asd\r\n\r\nasdasd sad', '2026-02-16', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `am_in` time DEFAULT NULL,
  `am_out` time DEFAULT NULL,
  `pm_in` time DEFAULT NULL,
  `pm_out` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `college_id` int(11) NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `college_abbreviation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`college_id`, `college_name`, `college_abbreviation`) VALUES
(3, 'College of Information Computing Studies', 'CICS');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_abbreviation` varchar(50) NOT NULL,
  `college_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_abbreviation`, `college_id`) VALUES
(2, 'Bachelor of Information Technology', 'BSIT', 3),
(3, 'Bachelor of Computer Science', 'BSCS', 3);

-- --------------------------------------------------------

--
-- Table structure for table `devices_tbl`
--

CREATE TABLE `devices_tbl` (
  `device_id` varchar(50) NOT NULL,
  `com_port` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fingerprints`
--

CREATE TABLE `fingerprints` (
  `id` int(10) NOT NULL,
  `created_at` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fingerprints`
--

INSERT INTO `fingerprints` (`id`, `created_at`) VALUES
(1, '2025-10-23 20:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts_tbl`
--

CREATE TABLE `login_attempts_tbl` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempt_count` int(11) NOT NULL DEFAULT '0',
  `locked_until` datetime DEFAULT NULL,
  `last_attempt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts_tbl`
--

INSERT INTO `login_attempts_tbl` (`id`, `username`, `ip_address`, `attempt_count`, `locked_until`, `last_attempt`) VALUES
(1, 'admin', '::1', 0, NULL, '2026-02-17 02:58:19'),
(2, 'roden', '::1', 3, '2026-02-17 03:03:11', '2026-02-17 02:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `logs_tbl`
--

CREATE TABLE `logs_tbl` (
  `log_id` int(10) NOT NULL,
  `log_user` text NOT NULL,
  `log_description` text NOT NULL,
  `log_action` text NOT NULL,
  `log_date` text NOT NULL,
  `log_time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members_tbl`
--

CREATE TABLE `members_tbl` (
  `member_id` int(10) NOT NULL,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL,
  `contact_number` text NOT NULL,
  `guardian_name` text NOT NULL,
  `guardian_contact_number` text NOT NULL,
  `college_id` text NOT NULL,
  `course_id` text NOT NULL,
  `dob` text NOT NULL,
  `address` text NOT NULL,
  `school_year` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `text_p` text NOT NULL,
  `profile_image` text NOT NULL,
  `code` text NOT NULL,
  `account_status` int(10) NOT NULL,
  `member_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members_tbl`
--

INSERT INTO `members_tbl` (`member_id`, `fname`, `mname`, `lname`, `email`, `contact_number`, `guardian_name`, `guardian_contact_number`, `college_id`, `course_id`, `dob`, `address`, `school_year`, `username`, `password`, `text_p`, `profile_image`, `code`, `account_status`, `member_type`) VALUES
(1, 'RODEN JR.', 'BALBOA', 'PELEGRINO', 'rbpelegrinojr@capsu.edu.ph', '+639381608058', 'Roden', '+639124156567', '3', '2', '2026-02-02', 'asdas das d', '2024-2025', '', '', '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `requirements_tbl`
--

CREATE TABLE `requirements_tbl` (
  `requirements_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `reservation_type_id` int(3) NOT NULL,
  `req_file` text NOT NULL,
  `req_filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedules_tbl`
--

CREATE TABLE `schedules_tbl` (
  `schedule_id` int(11) NOT NULL,
  `coordinator_id` int(11) NOT NULL,
  `college_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('active','inactive','archived','cancelled') NOT NULL DEFAULT 'active',
  `device_id` varchar(100) NOT NULL,
  `schedule_type` enum('morning','afternoon','both') NOT NULL DEFAULT 'both',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules_tbl`
--

INSERT INTO `schedules_tbl` (`schedule_id`, `coordinator_id`, `college_id`, `schedule_date`, `start_time`, `end_time`, `status`, `device_id`, `schedule_type`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2026-02-16', '04:56:00', '03:51:00', 'archived', 'COM9', 'afternoon', '2026-02-16 17:48:56', '2026-02-16 18:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `school_year_id` int(11) NOT NULL,
  `school_year` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`school_year_id`, `school_year`, `is_active`, `created_at`) VALUES
(1, '2024-2025', 1, '2026-02-17 01:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `settings_tbl`
--

CREATE TABLE `settings_tbl` (
  `setting_id` int(10) NOT NULL,
  `system_title` text NOT NULL,
  `system_logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings_tbl`
--

INSERT INTO `settings_tbl` (`setting_id`, `system_title`, `system_logo`) VALUES
(1, 'Event Manager using Biometrics with SMS Notification', 'http://localhost/cwts/system_images/gg.png');

-- --------------------------------------------------------

--
-- Table structure for table `sms_tbl`
--

CREATE TABLE `sms_tbl` (
  `sms_id` int(10) NOT NULL,
  `contact_number` text NOT NULL,
  `sms_content` text NOT NULL,
  `date_sent` text NOT NULL,
  `sms_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `user_id` int(10) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL,
  `email_password` text NOT NULL,
  `contact_number` text NOT NULL,
  `college_id` int(10) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `profile_image` text NOT NULL,
  `code` text NOT NULL,
  `user_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`user_id`, `fname`, `lname`, `email`, `email_password`, `contact_number`, `college_id`, `username`, `password`, `profile_image`, `code`, `user_type`) VALUES
(1, 'Admin', 'Admin', 'christjanberndequito.cbd@gmail.com', '', '09381608058', 0, 'admin', 'admin', 'http://localhost/cwts/profile_images/IMG_1180.JPEG', '659598', 1),
(2, 'RODEN JR.', 'PELEGRINO', 'rbpelegrinojr@capsu.edu.ph', '', '09308242900', 3, 'roden', 'roden', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements_tbl`
--
ALTER TABLE `announcements_tbl`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `idx_announcements_college` (`college_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_attendance_schedule` (`schedule_id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`college_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `college_id` (`college_id`);

--
-- Indexes for table `devices_tbl`
--
ALTER TABLE `devices_tbl`
  ADD PRIMARY KEY (`device_id`);

--
-- Indexes for table `login_attempts_tbl`
--
ALTER TABLE `login_attempts_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_ip` (`username`,`ip_address`);

--
-- Indexes for table `logs_tbl`
--
ALTER TABLE `logs_tbl`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `members_tbl`
--
ALTER TABLE `members_tbl`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `requirements_tbl`
--
ALTER TABLE `requirements_tbl`
  ADD PRIMARY KEY (`requirements_id`);

--
-- Indexes for table `schedules_tbl`
--
ALTER TABLE `schedules_tbl`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `idx_schedules_status_date` (`coordinator_id`,`status`,`schedule_date`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`school_year_id`),
  ADD UNIQUE KEY `uq_school_year` (`school_year`);

--
-- Indexes for table `settings_tbl`
--
ALTER TABLE `settings_tbl`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `sms_tbl`
--
ALTER TABLE `sms_tbl`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements_tbl`
--
ALTER TABLE `announcements_tbl`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts_tbl`
--
ALTER TABLE `login_attempts_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs_tbl`
--
ALTER TABLE `logs_tbl`
  MODIFY `log_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members_tbl`
--
ALTER TABLE `members_tbl`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `requirements_tbl`
--
ALTER TABLE `requirements_tbl`
  MODIFY `requirements_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules_tbl`
--
ALTER TABLE `schedules_tbl`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_tbl`
--
ALTER TABLE `settings_tbl`
  MODIFY `setting_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_tbl`
--
ALTER TABLE `sms_tbl`
  MODIFY `sms_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedules_tbl` (`schedule_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`college_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
