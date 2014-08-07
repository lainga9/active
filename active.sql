-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 07, 2014 at 05:59 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `active`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `places` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `street_address` text COLLATE utf8_unicode_ci NOT NULL,
  `town` text COLLATE utf8_unicode_ci NOT NULL,
  `postcode` text COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost` float(8,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_until` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `places`, `description`, `street_address`, `town`, `postcode`, `date`, `cost`, `user_id`, `level_id`, `created_at`, `updated_at`, `time_from`, `time_until`, `cancelled`) VALUES
(3, 'Sample Activity', 27, 'Description for activity', '45 Meadowhill', 'Newton Mearns', 'G77 6SZ', '2014-08-22', 25.00, 2, 1, '2014-06-30 13:49:26', '2014-08-07 13:43:17', '16:30', '17:30', 1),
(4, 'Another Activity', 49, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe impedit iste dolor, soluta expedita, temporibus minima facere eum facilis repudiandae perferendis voluptatem quam ex et enim in culpa repellendus doloribus neque, modi ut architecto dolores! Odio laudantium ducimus distinctio, nihil necessitatibus quo incidunt voluptatibus, accusantium vel beatae ad eveniet dolores!', '70 Craigton Drive', 'Newton Mearns', 'G77 6TD', '13-08-2014', 20.00, 2, 0, '2014-07-01 07:49:22', '2014-07-03 14:35:51', '', '', 0),
(5, 'Third Activity', 9, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe impedit iste dolor, soluta expedita, temporibus minima facere eum facilis repudiandae perferendis voluptatem quam ex et enim in culpa repellendus doloribus neque, modi ut architecto dolores!', '18 Fruin Avenue', 'Newton Mearns', 'G77 6HA', '23-07-2014', 40.00, 2, 0, '2014-07-01 07:51:44', '2014-07-15 15:02:06', '', '', 0),
(6, 'Working Date', 9, 'Activity with date in the correct format', '45 Meadowhill', 'Newton Mearns', 'G77 6SZ', '15-08-2014', 10.00, 2, 0, '2014-07-01 13:40:09', '2014-07-28 14:37:43', '', '', 0),
(7, 'Corrected Time', 9, 'sdfsdf', '45 Meadowhill', 'Newton Mearns', 'G77 6SZ', '30-07-2014', 20.00, 2, 0, '2014-07-01 13:49:28', '2014-07-04 12:38:10', '', '', 0),
(8, '', -2, '', '', '', '', '05-07-2014', 0.00, 2, 0, '2014-07-04 13:24:21', '2014-07-29 11:31:21', '', '', 0),
(9, 'Updated time fields', 25, 'Updated the time fields to include a from and an until', '17 Heron Court', 'Clydebank', 'G81 6BB', '2014-07-16', 15.00, 2, 0, '2014-07-04 13:46:32', '2014-07-04 13:46:32', '13:00', '13:30', 0),
(10, 'New Date Format: Y-m-d', 19, 'Activity with new date format.', '45 Meadowhill', 'Newton Mearns', 'G77 6SZ', '2014-07-09', 10.00, 2, 0, '2014-07-07 09:13:56', '2014-07-07 10:22:03', '10:30', '11:00', 0),
(11, 'bnm', 20, 'bnm', 'hjk', 'hg', 'hj', '2014-07-11', 2.00, 2, 0, '2014-07-10 11:19:24', '2014-07-10 11:19:24', '13:00', '13:30', 0),
(12, 'Testing credit reduction', 19, 'Testing to see if the instructors credits are reduced when adding an activity', '3 South Trinity Road', 'Edinburgh', 'EH5', '2014-10-11', 10.00, 2, 0, '2014-07-10 11:59:45', '2014-07-15 15:13:31', '14:30', '15:30', 0),
(13, 'Testing credit reduction', 20, 'Testing to see if the instructors credits are reduced when adding an activity', '3 South Trinity Road', 'Edinburgh', 'EH5', '2014-10-11', 10.00, 2, 0, '2014-07-10 12:00:00', '2014-07-10 12:00:00', '14:30', '15:30', 0),
(14, 'Testing credit reduction', 20, 'Testing to see if the instructors credits are reduced when adding an activity', '3 South Trinity Road', 'Edinburgh', 'EH5', '2014-10-11', 10.00, 2, 0, '2014-07-10 12:00:19', '2014-07-10 12:00:19', '14:30', '15:30', 0),
(15, 'Testing again', 20, 'Testing again', '3 South Trinity Road', 'Edinburgh', 'EH5', '2014-11-07', 30.00, 2, 0, '2014-07-10 12:01:58', '2014-07-10 12:01:58', '14:00', '14:30', 0),
(16, 'hjkh', 10, 'jkhkj', 'hj', 'hj', 'hj', '2014-07-26', 1.00, 2, 0, '2014-07-10 12:15:23', '2014-07-10 12:15:23', '14:30', '15:00', 0),
(17, 'Class Types', 10, 'huhjajhk', '18 Fruin Avenue', 'Newton Mearns', 'G77 6HA', '2014-07-31', 10.00, 2, 0, '2014-07-11 09:28:19', '2014-07-11 09:28:19', '12:30', '13:00', 0),
(18, 'Class Types', 10, 'huhjajhk', '18 Fruin Avenue', 'Newton Mearns', 'G77 6HA', '2014-07-31', 10.00, 2, 0, '2014-07-11 09:28:51', '2014-07-11 09:28:51', '12:30', '13:00', 0),
(19, 'Testing Pro Plan', 0, 'Testing listing activity with 0 credits and pro plan.', '45 Meadowhill', 'Newton Mearns', 'Alex Test', '2014-08-08', 10.00, 2, 3, '2014-08-07 11:01:38', '2014-08-07 11:01:38', '12:30', '13:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `activity_class_type`
--

CREATE TABLE `activity_class_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `class_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `activity_class_type`
--

INSERT INTO `activity_class_type` (`id`, `activity_id`, `class_type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 3, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 3, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 4, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 5, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 5, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 6, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 7, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 7, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 7, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 9, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 9, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 9, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 10, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 12, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 13, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 14, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 15, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 16, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 17, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 17, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 17, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 18, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 18, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 18, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 19, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 19, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 19, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `activity_favourite`
--

CREATE TABLE `activity_favourite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `activity_favourite`
--

INSERT INTO `activity_favourite` (`id`, `activity_id`, `user_id`, `created_at`, `updated_at`) VALUES
(20, 3, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 4, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 5, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 19, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `activity_user`
--

CREATE TABLE `activity_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `activity_user`
--

INSERT INTO `activity_user` (`id`, `activity_id`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 3, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 4, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 7, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 10, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 3, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 5, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 12, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 6, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 8, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 8, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `class_types`
--

CREATE TABLE `class_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `class_types`
--

INSERT INTO `class_types` (`id`, `name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Wellness', 0, '2014-06-30 13:33:01', '2014-06-30 13:33:01'),
(2, 'Fitness', 0, '2014-06-30 13:33:01', '2014-06-30 13:33:01'),
(3, 'Body Conditioning', 0, '2014-06-30 13:33:01', '2014-06-30 13:33:01'),
(4, 'Dance', 0, '2014-06-30 13:33:01', '2014-06-30 13:33:01'),
(5, 'Yoga', 1, '2014-06-30 13:36:07', '2014-06-30 13:36:07'),
(6, 'Weightlifting', 3, '2014-06-30 13:36:16', '2014-06-30 13:36:16'),
(7, 'Metafit', 2, '2014-06-30 13:36:27', '2014-06-30 13:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instructor_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stripe_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchased` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `credits`
--

INSERT INTO `credits` (`id`, `instructor_id`, `activity_id`, `created_at`, `updated_at`, `stripe_token`, `purchased`) VALUES
(1, 1, 16, '2014-07-10 12:15:23', '2014-07-10 12:15:23', '', ''),
(2, 2, 18, '2014-07-11 09:28:51', '2014-07-11 09:28:51', '', ''),
(3, 2, 0, '2014-07-18 13:36:09', '2014-07-18 13:36:09', 'ch_14HbWv4w3O4gy7glRh9jNhfX', '1'),
(4, 2, 0, '2014-07-18 13:38:42', '2014-07-18 13:38:42', 'ch_14HbZO4w3O4gy7glf4UGQnJ3', '1'),
(5, 2, 0, '2014-07-18 13:41:21', '2014-07-18 13:41:21', 'ch_14Hbbx4w3O4gy7gl4W3mIPXH', '1'),
(6, 2, 0, '2014-07-18 14:13:23', '2014-07-18 14:13:23', 'ch_14Hc6x4w3O4gy7glTpv12VQv', '1'),
(7, 2, 19, '2014-08-07 11:01:38', '2014-08-07 11:01:38', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instructor_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `instructor_id`, `client_id`, `activity_id`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 4, '2014-07-08 13:34:11', '2014-07-08 13:34:11'),
(2, 2, 3, 3, '2014-07-11 09:31:48', '2014-07-11 09:31:48'),
(3, 2, 2, 3, '2014-07-28 14:59:51', '2014-07-28 14:59:51'),
(4, 2, 3, 3, '2014-07-29 08:37:03', '2014-07-29 08:37:03'),
(5, 2, 3, 7, '2014-08-05 14:34:35', '2014-08-05 14:34:35'),
(9, 2, 3, 5, '2014-08-05 14:38:26', '2014-08-05 14:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_items`
--

CREATE TABLE `feedback_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `feedback_items`
--

INSERT INTO `feedback_items` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Enthusiasm and motivation', '2014-07-08 11:58:43', '2014-07-08 11:58:43'),
(2, 'Instruction and technique', '2014-07-08 11:58:43', '2014-07-08 11:58:43'),
(3, 'Was the class taught to the level as advertised?', '2014-07-08 11:58:43', '2014-07-08 11:58:43'),
(4, 'Overall Satisfaction', '2014-07-08 11:58:43', '2014-07-08 11:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_values`
--

CREATE TABLE `feedback_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feedback_id` int(11) NOT NULL,
  `feedback_item_id` int(11) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `feedback_values`
--

INSERT INTO `feedback_values` (`id`, `feedback_id`, `feedback_item_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2014-07-08 13:34:11', '2014-07-08 13:34:11'),
(2, 1, 2, 3, '2014-07-08 13:34:11', '2014-07-08 13:34:11'),
(3, 1, 3, 5, '2014-07-08 13:34:11', '2014-07-08 13:34:11'),
(4, 1, 4, 4, '2014-07-08 13:34:11', '2014-07-08 13:34:11'),
(5, 2, 1, 2, '2014-07-11 09:31:48', '2014-07-11 09:31:48'),
(6, 2, 2, 2, '2014-07-11 09:31:48', '2014-07-11 09:31:48'),
(7, 2, 3, 2, '2014-07-11 09:31:48', '2014-07-11 09:31:48'),
(8, 2, 4, 2, '2014-07-11 09:31:48', '2014-07-11 09:31:48'),
(9, 3, 1, 1, '2014-07-28 14:59:51', '2014-07-28 14:59:51'),
(10, 3, 2, 3, '2014-07-28 14:59:51', '2014-07-28 14:59:51'),
(11, 3, 3, 3, '2014-07-28 14:59:51', '2014-07-28 14:59:51'),
(12, 3, 4, 1, '2014-07-28 14:59:51', '2014-07-28 14:59:51'),
(14, 4, 1, 1, '2014-07-29 08:37:03', '2014-07-29 08:37:03'),
(15, 4, 2, 3, '2014-07-29 08:37:03', '2014-07-29 08:37:03'),
(16, 4, 3, 3, '2014-07-29 08:37:03', '2014-07-29 08:37:03'),
(17, 4, 4, 3, '2014-07-29 08:37:03', '2014-07-29 08:37:03'),
(19, 5, 1, 2, '2014-08-05 14:34:35', '2014-08-05 14:34:35'),
(20, 5, 2, 3, '2014-08-05 14:34:35', '2014-08-05 14:34:35'),
(21, 5, 3, 2, '2014-08-05 14:34:35', '2014-08-05 14:34:35'),
(22, 5, 4, 5, '2014-08-05 14:34:35', '2014-08-05 14:34:35'),
(23, 9, 1, 3, '2014-08-05 14:38:26', '2014-08-05 14:38:26'),
(24, 9, 2, 3, '2014-08-05 14:38:26', '2014-08-05 14:38:26'),
(25, 9, 3, 3, '2014-08-05 14:38:26', '2014-08-05 14:38:26'),
(26, 9, 4, 2, '2014-08-05 14:38:26', '2014-08-05 14:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Beginner', '2014-07-29 09:55:35', '2014-07-29 09:55:35'),
(2, 'Intermediate', '2014-07-29 09:55:35', '2014-07-29 09:55:35'),
(3, 'Advanced', '2014-07-29 09:55:35', '2014-07-29 09:55:35'),
(4, 'Expert', '2014-07-29 09:55:35', '2014-07-29 09:55:35'),
(5, 'All Levels', '2014-07-29 09:55:35', '2014-07-29 09:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL DEFAULT '0',
  `deleted_by_sender` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_by_recipient` tinyint(1) NOT NULL DEFAULT '0',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `subject`, `content`, `sender_id`, `recipient_id`, `thread_id`, `deleted_by_sender`, `deleted_by_recipient`, `read`, `created_at`, `updated_at`) VALUES
(28, '', 'Message from Client User to Alex Laing about Sample Activity.', 3, 2, 0, 0, 0, 0, '2014-07-08 10:39:06', '2014-07-08 10:39:06'),
(29, '', 'Reply to message', 2, 3, 28, 0, 0, 0, '2014-07-08 10:39:43', '2014-07-08 10:39:43'),
(30, '', 'Email to Alex Laing from Client User regarding Sample Activity.', 3, 2, 0, 0, 0, 0, '2014-07-08 10:40:43', '2014-07-08 10:40:43'),
(31, '', 'Message from Will regarding an activity.', 4, 2, 0, 0, 0, 0, '2014-07-08 10:48:13', '2014-07-08 10:48:13'),
(32, '', 'hiya will', 2, 4, 31, 0, 0, 0, '2014-07-08 10:48:42', '2014-07-08 10:48:42'),
(33, '', 'sdf', 4, 4, 31, 0, 0, 0, '2014-07-08 10:53:41', '2014-07-08 10:53:41'),
(34, '', 'sfd', 4, 2, 31, 0, 0, 0, '2014-07-08 11:14:43', '2014-07-08 11:14:43'),
(35, '', 'sdf', 4, 2, 31, 0, 0, 0, '2014-07-08 11:23:12', '2014-07-08 11:23:12'),
(36, '', 'd', 4, 2, 31, 0, 0, 0, '2014-07-08 11:23:50', '2014-07-08 11:23:50'),
(37, '', 'sdfsdf', 4, 2, 31, 0, 0, 0, '2014-07-08 11:25:46', '2014-07-08 11:25:46'),
(38, '', 'sdfsdf', 4, 2, 31, 0, 0, 0, '2014-07-08 11:26:58', '2014-07-08 11:26:58'),
(39, '', 'gdfg', 2, 3, 28, 0, 0, 0, '2014-07-08 11:29:06', '2014-07-08 11:29:06'),
(40, '', 'dfgdf', 2, 3, 28, 0, 0, 0, '2014-07-08 11:29:07', '2014-07-08 11:29:07'),
(41, '', 'Testing angular response system', 4, 2, 31, 0, 0, 0, '2014-07-08 14:31:13', '2014-07-08 14:31:13'),
(42, '', 'Message from Will regarding Sample Activity', 4, 2, 0, 0, 0, 0, '2014-07-29 11:56:04', '2014-07-29 11:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_06_26_115032_create_users_table', 1),
('2014_06_30_100312_create_users_instructors_table', 1),
('2014_06_30_105704_create_users_clients_table', 1),
('2014_06_30_110939_create_roles_table', 1),
('2014_06_30_112541_create_users_admins_table', 1),
('2014_06_30_124851_create_ClassTypes_table', 1),
('2014_06_30_125931_create_activities_table', 1),
('2014_06_30_132331_create_activity_class_type_table', 1),
('2014_06_30_132401_create_password_reminders_table', 2),
('2014_06_30_150241_add_rememeber_token_to_users_table', 3),
('2014_06_30_151250_create_activity_user_table', 4),
('2014_07_01_090620_create_activity_favourite_table', 5),
('2014_07_04_141108_update_time_columns_on_activities_table', 6),
('2014_07_07_143616_create_messages_table', 7),
('2014_07_08_124947_create_feedback_items_table', 8),
('2014_07_08_130028_create_feedback_values_table', 9),
('2014_07_08_130220_create_feedback_table', 9),
('2014_07_10_114427_create_credits_table', 10),
('2014_07_10_115133_add_credits_column_to_instructors_table', 10),
('2014_07_18_134556_add_stripe_token_and_purchased_columns_to_credits_table', 11),
('2014_07_21_143914_add_cashier_columns', 12),
('2014_07_29_105221_create_levels_table', 13),
('2014_08_07_143739_add_cancelled_column_to_activities', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_reminders`
--

CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Client', '2014-06-30 13:33:01', '2014-06-30 13:33:01'),
(2, 'Instructor', '2014-06-30 13:33:01', '2014-06-30 13:33:01'),
(3, 'Admin', '2014-06-30 13:33:01', '2014-06-30 13:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob_day` int(11) NOT NULL,
  `dob_month` int(11) NOT NULL,
  `dob_year` int(11) NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `userable_id` int(11) NOT NULL,
  `userable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `dob_day`, `dob_month`, `dob_year`, `gender`, `avatar`, `role_id`, `userable_id`, `userable_type`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, '', '', 'glasgoweb@gmail.com', '$2y$10$iuNGzGX6G9.IEMeHYg502eKLClg8wksGZ33hk.CDQE77boOwI045i', 0, 0, 0, '', '', 3, 1, 'Admin', '2014-06-30 13:33:01', '2014-06-30 13:33:01', ''),
(2, 'Alexander', 'Laing', 'alex@glasgoweb.co.uk', '$2y$10$nMUh.tLOINCuMI0sTH1Sme34gIyxj8R7K1DWsDRWfsAQ9VGv.Y5Vu', 9, 0, 0, 'male', '', 2, 1, 'Instructor', '2014-06-30 13:46:58', '2014-08-07 15:38:37', 'jXH9s4kwt6b8j5tb0Zm5rwF9TmIIxLhrqdEVwbvhHdBPqkflDzaxRZm1jFlN'),
(3, 'Client', 'User', 'client@client.com', '$2y$10$1qyQO1289axJSgD5PLGxWuG9cZpDrgoKf9skDWpSZOIfX/nZ5P7.a', 1, 1, 1987, 'male', '', 1, 1, 'Client', '2014-06-30 14:40:31', '2014-08-07 13:34:34', 'v9dYQheo4Fh7Dwet959df2ZmH5kgSoRdqEvayhh9h2xs8DMhZuJKIhFA1A2C'),
(4, 'Will', 'Craig', 'willcraig@glasgoweb.co.uk', '$2y$10$RvLT4nCFS1qZRS8apqm0Ee37ER9gbfiqihNW4urLNJepSi5M6C2ui', 1, 1, 1987, 'male', '', 1, 2, 'Client', '2014-07-08 10:45:08', '2014-07-29 11:59:17', 'ozgY5A469wokN21W6SuPGyz4MoG0gFgfYiCfvMEEYxlaLJUJ5KjAPR5pr4E7'),
(5, 'Instructor', 'User', 'instructor@instructor.com', '$2y$10$tCMOwHz8MdFedQ9nuzxzE.tNoVjslMmxZaahE.tyVepkIykqF1vWS', 1, 1, 1987, 'male', '', 2, 2, 'Instructor', '2014-08-07 11:02:20', '2014-08-07 15:26:16', 'LGCGpIzMA8rKsc8zT4mKkit3nRxhs7064LDsrvY3Y4FVIiR6prWW8Czx4WJD'),
(6, 'Ross', 'Dempsey', 'ross@glasgoweb.co.uk', '$2y$10$DJyDyFNMIY3x8rQiG.mN7OMdg7tGKppk1kDsYPQeGdAdzZI74hhB6', 1, 1, 1987, 'male', '', 2, 3, 'Instructor', '2014-08-07 11:48:33', '2014-08-07 12:04:07', 'E1tElAg6RCtEbgnCu3SVeNyj6DpGl3IsiZqGupoqbJz9cOSAJjhHWWF0vSr1');

-- --------------------------------------------------------

--
-- Table structure for table `users_admins`
--

CREATE TABLE `users_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users_admins`
--

INSERT INTO `users_admins` (`id`, `created_at`, `updated_at`) VALUES
(1, '2014-06-30 13:33:01', '2014-06-30 13:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `users_clients`
--

CREATE TABLE `users_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_clients`
--

INSERT INTO `users_clients` (`id`, `created_at`, `updated_at`) VALUES
(1, '2014-06-30 14:40:30', '2014-06-30 14:40:30'),
(2, '2014-07-08 10:45:08', '2014-07-08 10:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `users_instructors`
--

CREATE TABLE `users_instructors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bio` text COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `google` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `credits` int(11) NOT NULL DEFAULT '3',
  `stripe_active` tinyint(4) NOT NULL DEFAULT '0',
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_subscription` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_plan` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_four` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users_instructors`
--

INSERT INTO `users_instructors` (`id`, `phone`, `mobile`, `postcode`, `bio`, `website`, `facebook`, `twitter`, `youtube`, `google`, `created_at`, `updated_at`, `credits`, `stripe_active`, `stripe_id`, `stripe_subscription`, `stripe_plan`, `last_four`, `trial_ends_at`, `subscription_ends_at`) VALUES
(1, '01224 224368', '07816271864', 'G77 6SZ', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex dolores animi, quisquam assumenda harum! Id quam odit adipisci, omnis, facilis inventore dolores! Eligendi fugiat eos natus quod possimus cumque asperiores, minima alias inventore quas debitis fuga delectus illum sint quibusdam ex, quidem voluptatem laudantium doloribus neque optio sit odit provident. Officia nihil nemo dolore, eaque beatae fugit. Ducimus, ipsam, enim.', 'http://codeispoetry.co.uk', 'http://facebook.com', 'http://twitter.com', 'http://youtube.com', '', '2014-06-30 13:46:58', '2014-08-07 11:01:38', -1, 1, 'cus_4RbHZzpWqYcLJ2', 'sub_4RbHnlQOlRNhT1', 'pro', '4242', NULL, NULL),
(2, '7987987', '789789797', 'G77 6SZ', 'Here is my bio.', 'website', 'facebook', 'twitter', 'youtube', '', '2014-08-07 11:02:19', '2014-08-07 12:04:45', 3, 1, 'cus_4XuwnqMeLHVfvq', 'sub_4Xuwz9dHPhbPiS', 'pro', '4242', NULL, NULL),
(3, '', '', '', '', '', '', '', '', '', '2014-08-07 11:48:33', '2014-08-07 11:48:33', 3, 0, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
