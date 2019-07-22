-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2018 at 09:09 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daily_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily`
--

CREATE TABLE `daily` (
  `id` int(11) NOT NULL,
  `weekly_id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `activity` text NOT NULL,
  `milestone` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily`
--

INSERT INTO `daily` (`id`, `weekly_id`, `day`, `activity`, `milestone`, `date_created`) VALUES
(1, 1, 0, 'hey today is sunday', 'right', '2018-08-12 10:51:38'),
(2, 2, 2, 'hi', 'hey', '2018-08-14 00:04:24'),
(3, 3, 0, 'hi', 'hello', '2018-08-26 23:42:52'),
(4, 4, 3, 'Today is the defense day!', 'I have compile my reports already.', '2018-08-29 03:31:33'),
(5, 5, 3, 'wertyui', 'asdfghj', '2018-08-29 18:09:53'),
(6, 5, 4, '234rtyuio', 'asdfghjkl', '2018-08-30 21:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'IT'),
(2, 'Administration'),
(3, 'Marketing'),
(4, 'Accounting'),
(5, 'Logistics'),
(6, 'Human resources'),
(7, 'Office Administration');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date_created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `department_id`, `name`, `description`, `date_created`, `created_by`, `deleted`) VALUES
(1, 1, 'Android Developer', 'Develop android applications', '2018-08-12 11:40:50', 1, 0),
(2, 1, 'Corp Member', 'NYSC intern', '2018-08-12 12:07:00', 1, 0),
(3, 1, 'Network engineer', 'In charge of setting up, administering,and maintaining and upgrading local network for the organisation', '2018-08-12 12:10:00', 1, 0),
(4, 2, 'Managing Director', 'Direct and control the Company\'s operation', '2018-08-12 09:11:11', 1, 0),
(5, 1, 'Web developer', 'Responsible for building websites and infrastructures behind them', '2018-08-12 12:19:19', 1, 0),
(6, 2, 'Chief executive officer', 'Responsible for setting strategy and direction, modeling and setting the company\'s culture, value, behavior, building and leading the senior executive team.', '2018-08-12 10:25:00', 1, 0),
(7, 3, 'Marketing Director', 'Responsible for the organisations and marketing activities such as development and implementation of  the branding strategy, developing the marketing strategy  for new and existing products ', '2018-08-12 12:24:00', 1, 0),
(8, 3, 'Marketing officer', 'Responsible for preparing, planning and project managing the publication of all public material to maximize brand promotion and supporting marketing director in day to day activities marketing activities.', '2018-08-12 12:33:26', 1, 0),
(9, 4, 'Accounting manager', 'Responsible for the company accounting activities that include maintaining and reporting on both the cost and financial sets of accounts. ', '2018-08-12 12:33:35', 1, 0),
(10, 4, 'Accountant', 'Responsible for measurement and interpretation of financial information', '2018-08-12 12:49:51', 1, 0),
(11, 4, 'Bookkeeper', 'Provides the day to day efforts need to record and assess basic accounting data', '2018-08-12 13:28:00', 1, 0),
(12, 4, 'Chief Financial officer', 'Oversees the financial strategy, health of the business, and manage the rest of the financial department', '2018-08-12 13:26:00', 1, 0),
(13, 5, 'Logistic manager', 'Responsible for planning and managing logistics, warehouse, transportation and customer services and also liaising and negotiating with suppliers, manufacturers, retailers and consumers. ', '2018-08-12 13:22:11', 1, 0),
(14, 7, 'Receptionist', 'Responsible for arranging and greeting the clients, suppliers and visitors directly via emails, phone calls or direct mail.', '2018-08-12 12:24:19', 1, 0),
(15, 7, 'Personal assistant/ Secretary', 'Help maintain  the efficiency of office manager\'s day-to-day work.', '2018-08-12 14:42:42', 1, 0),
(16, 7, 'Cleaner', 'Responsible for cleaning, stocking and supplying designated facility areas (cleaning, sweeping, mopping, cleaning ceiling vents, restroom cleaning).', '2018-08-12 14:17:29', 1, 0),
(17, 5, 'Company driver', 'Responsible for conveying material, equipment, and staff of the organisation to areas where they are required.', '2018-08-12 12:26:26', 1, 0),
(18, 6, 'Human resource manager', 'Oversees the recruiting, interviewing, and hiring of the new staff, consult with top executives on strategic planning; and serve as a link between an organisation\'s management and its employees.', '2018-08-12 13:28:24', 1, 0),
(19, 6, 'Assistant general manager', 'Promotes customer service by ensuring associates are greeting and assisting customers; responds to customer inquiries and complaint in the organisation', '2018-08-12 14:32:32', 1, 0),
(20, 6, 'General manager', 'Oversees daily operations of the organisation and ensure the creation and implementation of a strategy designed to grow the business. ', '2018-08-12 14:17:27', 1, 0),
(21, 2, 'Member of the board of directors', 'Determines the company\'s vision and mission to guide and set the pace for its current operation and development.', '2018-08-12 15:33:29', 1, 0),
(22, 0, 'System Admin', 'Manages the System', '2018-08-29 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE `errors` (
  `id` int(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `method` varchar(20) NOT NULL,
  `stack_message` text,
  `user` int(11) NOT NULL,
  `error_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `filename` varchar(50) NOT NULL DEFAULT '',
  `extention` varchar(20) NOT NULL,
  `date_uploaded` datetime NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteb_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade`) VALUES
(1, 'Grade I'),
(2, 'Grade II'),
(3, 'Grade III'),
(4, 'Grade IV'),
(5, 'Grade V');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`) VALUES
(1, 'Manage Users'),
(2, 'Manage Reports'),
(3, 'Manage Roles'),
(4, 'Supervision Privilege');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `filename` varchar(50) NOT NULL DEFAULT '',
  `caption` varchar(100) NOT NULL,
  `author_id` int(11) NOT NULL,
  `date_uploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `rate` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `rate`, `title`) VALUES
(1, '0.5', 'Sucks'),
(2, '1', ''),
(3, '1.5', ''),
(4, '2', ''),
(5, '2.5', 'Bad rating!'),
(6, '3', 'Not bad!'),
(7, '3.5', 'Fair enough!'),
(8, '4', 'Good job!'),
(9, '4.5', 'Great work!'),
(10, '5', 'Awesome job!');

-- --------------------------------------------------------

--
-- Table structure for table `report_summary`
--

CREATE TABLE `report_summary` (
  `id` int(11) NOT NULL,
  `weekly_id` int(11) NOT NULL,
  `key_challenges` text NOT NULL,
  `recommendations` text NOT NULL,
  `rating_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `date_submitted` datetime NOT NULL,
  `date_reviewed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report_summary`
--

INSERT INTO `report_summary` (`id`, `weekly_id`, `key_challenges`, `recommendations`, `rating_id`, `remarks`, `reviewed_by`, `date_submitted`, `date_reviewed`) VALUES
(1, 1, '', '', 0, '', 0, '2018-08-14 00:05:38', '0000-00-00 00:00:00'),
(2, 3, '', '', 10, 'How are you doing', 1, '2018-08-26 23:43:41', '2018-08-26 23:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `description`, `created_by`, `date_created`, `deleted`) VALUES
(1, 'Admin', 'Manages everything on the app', 0, '2017-05-23 12:07:25', 0),
(2, 'Admin II', 'Manages reports and has supervision privilege', 0, '2017-05-23 12:08:07', 0),
(3, 'Admin III', 'Manages reports only', 0, '2017-05-23 12:08:25', 0),
(4, 'Admin IV', 'Manages all', 0, '2017-05-23 12:20:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_perm`
--

CREATE TABLE `role_perm` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_perm`
--

INSERT INTO `role_perm` (`id`, `role_id`, `perm_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 2, 2),
(6, 2, 4),
(7, 3, 2),
(8, 4, 1),
(9, 4, 2),
(10, 4, 3),
(11, 4, 4),
(12, 5, 1),
(13, 5, 3),
(14, 6, 1),
(15, 6, 3),
(16, 7, 1),
(17, 7, 2),
(18, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `subordinates`
--

CREATE TABLE `subordinates` (
  `id` int(11) NOT NULL,
  `subordinate_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `date_assigned` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subordinates`
--

INSERT INTO `subordinates` (`id`, `subordinate_id`, `supervisor_id`, `date_assigned`) VALUES
(1, 2, 0, '2018-08-29 02:57:06'),
(2, 3, 0, '2018-08-29 02:59:27'),
(3, 4, 0, '2018-08-29 03:01:27'),
(4, 5, 4, '2018-08-29 03:06:39'),
(5, 6, 2, '2018-08-29 03:09:07'),
(6, 7, 3, '2018-08-29 03:12:41'),
(7, 8, 2, '2018-08-29 03:15:58'),
(8, 9, 3, '2018-08-29 03:19:39'),
(9, 10, 2, '2018-08-29 03:24:55'),
(10, 11, 1, '2018-08-29 03:28:47'),
(11, 12, 0, '2018-08-29 04:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `priority` varchar(20) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `author`, `title`, `description`, `start_date`, `due_date`, `priority`, `date_created`, `status`) VALUES
(1, 11, 'Edit this page please', 'Please help me edit this page. There are lots of bugs trying to eat me up!.', '2018-08-29', '2018-08-29', 'Medium', '2018-08-29 03:34:23', 1),
(2, 1, 'Reminder', 'Your defense is today. Make sure you&#39;re there early', '2018-08-29', '2018-08-29', 'High', '2018-08-29 03:37:43', 0),
(3, 1, 'Reminder', 'Do remember to go for your project defense on Wednesday', '2018-08-29', '2018-08-29', 'Medium', '2018-08-29 03:40:31', 0),
(4, 1, 'Testing', 'I&#39;m only trying to assign task', '2018-08-29', '2018-08-29', 'Low', '2018-08-29 03:48:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task_participant`
--

CREATE TABLE `task_participant` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` text NOT NULL,
  `date_updated` datetime NOT NULL,
  `author_rating` varchar(20) NOT NULL,
  `author_remarks` text NOT NULL,
  `date_reviewed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_participant`
--

INSERT INTO `task_participant` (`id`, `task_id`, `participant_id`, `status`, `remarks`, `date_updated`, `author_rating`, `author_remarks`, `date_reviewed`) VALUES
(1, 1, 1, 1, 'ok', '2018-08-30 21:55:18', '', '', '0000-00-00 00:00:00'),
(2, 2, 7, 0, '', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00'),
(3, 3, 8, 0, '', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00'),
(4, 4, 9, 0, '', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `staffid` varchar(10) NOT NULL,
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `password_changed_on` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staffid`, `firstname`, `lastname`, `email`, `phone`, `password`, `designation_id`, `grade_id`, `author_id`, `last_login`, `password_changed_on`, `date_created`, `status`, `deleted`) VALUES
(1, 'ST000', 'Aisha', 'Abdulkadir', 'aishaidir94@gmail.com', '08142445807', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 5, 5, 0, '2018-09-08 09:44:01', '0000-00-00 00:00:00', '2018-08-12 12:33:35', 0, 0),
(2, 'ST001', 'Aliyu', 'Musa', 'aliyumusa123@gmail.com', '08063726152', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 6, 5, 1, '2018-08-29 17:48:56', '0000-00-00 00:00:00', '2018-08-29 02:57:06', 0, 0),
(3, 'ST002', 'Aminu', 'Abdullahi', 'aminuabdullahi@gmail.com', '08054213639', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 4, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 02:59:27', 0, 0),
(4, 'ST003', 'James', 'Adams', 'james.adam@gmail.com', '09030485715', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 21, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 03:01:27', 0, 0),
(5, 'ST004', 'Isiaka', 'Ismaila', 'isiaka.ismail@gmail.com', '08035856731', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 5, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 03:06:39', 0, 0),
(6, 'ST005', 'Muhammad', 'Sani', 'muhammadsani@gmail.com', '07036895256', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 1, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 03:09:07', 0, 0),
(7, 'ST006', 'Amina', 'Musa', 'armeenerhtwoo@gmail.com', '08061300414', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 18, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 03:12:41', 0, 0),
(8, 'ST007', 'Zainab', 'Zakari', 'zeezakz66@gmail.com', '09026134125', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 15, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 03:15:58', 0, 0),
(9, 'ST008', 'Habiba', 'Musa', 'habibamusa@gmail.com', '08077133177', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 7, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 03:19:39', 0, 0),
(10, 'ST009', 'Fati', 'Abbas', 'fatiabbas@gmail.com', '07061115544', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 13, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-08-29 03:24:55', 0, 0),
(11, 'ST010', 'Joseph', 'Josh', 'joseph.josh@gmail.com', '07089107902', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 3, 4, 1, '2018-08-30 22:19:48', '0000-00-00 00:00:00', '2018-08-29 03:28:47', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 3, 3),
(4, 4, 2),
(5, 5, 1),
(6, 6, 2),
(7, 7, 4),
(8, 8, 3),
(9, 7, 4),
(10, 8, 4),
(11, 2, 3),
(12, 3, 3),
(13, 4, 1),
(14, 5, 1),
(15, 6, 2),
(16, 2, 3),
(17, 3, 3),
(18, 2, 1),
(19, 3, 3),
(20, 4, 1),
(21, 5, 2),
(22, 6, 2),
(23, 7, 1),
(24, 8, 3),
(25, 9, 3),
(26, 10, 1),
(27, 11, 2),
(28, 2, 4),
(29, 3, 3),
(30, 4, 2),
(31, 5, 4),
(32, 6, 2),
(33, 7, 4),
(34, 8, 3),
(35, 9, 3),
(36, 10, 3),
(37, 11, 3),
(38, 12, 4),
(39, 13, 4),
(40, 14, 4),
(41, 2, 4),
(42, 3, 4),
(43, 4, 4),
(44, 5, 2),
(45, 6, 2),
(46, 7, 2),
(47, 8, 3),
(48, 9, 2),
(49, 10, 2),
(50, 11, 2),
(51, 12, 5);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view report summary`
-- (See below for the actual view)
--
CREATE TABLE `view report summary` (
`weekly_id` int(11)
,`remarks` text
,`date_reviewed` datetime
,`rating` varchar(50)
,`id` int(11)
,`firstname` varchar(50)
,`lastname` varchar(50)
,`reviewed_by` varchar(101)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view subordinates`
-- (See below for the actual view)
--
CREATE TABLE `view subordinates` (
`id` int(11)
,`name` varchar(101)
,`email` varchar(50)
,`designation` varchar(50)
,`supervisor_id` int(11)
,`date_assigned` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view users`
-- (See below for the actual view)
--
CREATE TABLE `view users` (
`id` int(11)
,`staffid` varchar(10)
,`name` varchar(101)
,`email` varchar(50)
,`designation` varchar(50)
,`date_created` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `weekly`
--

CREATE TABLE `weekly` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `month` varchar(15) NOT NULL DEFAULT '',
  `week` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `submitted` tinyint(1) NOT NULL DEFAULT '0',
  `date_submitted` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weekly`
--

INSERT INTO `weekly` (`id`, `user_id`, `year`, `month`, `week`, `date_created`, `submitted`, `date_submitted`, `deleted`) VALUES
(1, 1, 2018, 'Aug', 32, '2018-08-12 10:51:38', 1, '2018-08-14 00:05:38', 0),
(2, 1, 2018, 'Aug', 33, '2018-08-14 00:04:24', 0, '0000-00-00 00:00:00', 0),
(3, 8, 2018, 'Aug', 34, '2018-08-26 23:42:52', 1, '2018-08-26 23:43:41', 0),
(4, 11, 2018, 'Aug', 35, '2018-08-29 03:31:33', 0, '0000-00-00 00:00:00', 0),
(5, 1, 2018, 'Aug', 35, '2018-08-29 18:09:53', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure for view `view report summary`
--
DROP TABLE IF EXISTS `view report summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view report summary`  AS  select `t1`.`weekly_id` AS `weekly_id`,`t1`.`remarks` AS `remarks`,`t1`.`date_reviewed` AS `date_reviewed`,`t2`.`title` AS `rating`,`t3`.`id` AS `id`,`t3`.`firstname` AS `firstname`,`t3`.`lastname` AS `lastname`,concat(`t3`.`firstname`,' ',`t3`.`lastname`) AS `reviewed_by` from ((`report_summary` `t1` join `rating` `t2` on((`t1`.`rating_id` = `t2`.`id`))) join `users` `t3` on((`t1`.`reviewed_by` = `t3`.`id`))) where (`t1`.`rating_id` <> 0) ;

-- --------------------------------------------------------

--
-- Structure for view `view subordinates`
--
DROP TABLE IF EXISTS `view subordinates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view subordinates`  AS  select `t1`.`id` AS `id`,concat(`t1`.`firstname`,' ',`t1`.`lastname`) AS `name`,`t1`.`email` AS `email`,`t3`.`name` AS `designation`,`t2`.`supervisor_id` AS `supervisor_id`,`t2`.`date_assigned` AS `date_assigned` from ((`users` `t1` join `subordinates` `t2` on((`t1`.`id` = `t2`.`subordinate_id`))) join `designations` `t3` on((`t1`.`designation_id` = `t3`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view users`
--
DROP TABLE IF EXISTS `view users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view users`  AS  select `t1`.`id` AS `id`,`t1`.`staffid` AS `staffid`,concat(`t1`.`firstname`,' ',`t1`.`lastname`) AS `name`,`t1`.`email` AS `email`,`t2`.`name` AS `designation`,`t1`.`date_created` AS `date_created` from (`users` `t1` join `designations` `t2` on((`t1`.`designation_id` = `t2`.`id`))) where (`t2`.`deleted` <> 1) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily`
--
ALTER TABLE `daily`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_summary`
--
ALTER TABLE `report_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_perm`
--
ALTER TABLE `role_perm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subordinates`
--
ALTER TABLE `subordinates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_participant`
--
ALTER TABLE `task_participant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekly`
--
ALTER TABLE `weekly`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily`
--
ALTER TABLE `daily`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `errors`
--
ALTER TABLE `errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `report_summary`
--
ALTER TABLE `report_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_perm`
--
ALTER TABLE `role_perm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subordinates`
--
ALTER TABLE `subordinates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task_participant`
--
ALTER TABLE `task_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `weekly`
--
ALTER TABLE `weekly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
