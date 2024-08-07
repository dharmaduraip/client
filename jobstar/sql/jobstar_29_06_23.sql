-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2023 at 04:50 PM
-- Server version: 5.7.41
-- PHP Version: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobstar`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `about_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about_sub_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `about_brand_logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/all-img/brand-1.png',
  `about_brand_logo1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/all-img/brand-2.png',
  `about_brand_logo2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/all-img/brand-3.png',
  `about_brand_logo3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/all-img/brand-1.png',
  `about_brand_logo4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/all-img/brand-2.png',
  `about_brand_logo5` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/all-img/brand-3.png',
  `about_banner_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/banner/about-banner-1.jpg',
  `about_banner_img1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/banner/about-banner-1.jpg',
  `about_banner_img2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/banner/about-banner-1.jpg',
  `about_banner_img3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/banner/about-banner-1.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend/image/default.png',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@abservetech.com', '2023-02-24 04:43:20', '$2y$10$kwN0Y6MivJyL8NlYL/gE/uh1BsEoJ/12XmQKeEj946ZihnhtD4Tbq', 'uploads/user/1678277003_6408798bf216c.jpg', 'Hyzez6c8mKkzzmJA5CJQ65spfz8hYbMqdUlJvCGjuyKyhgcwYnUkEvluotGl', '2023-02-24 04:43:20', '2023-03-08 06:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `admin_searches`
--

CREATE TABLE `admin_searches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_groups`
--

CREATE TABLE `application_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT '0',
  `is_deleteable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_groups`
--

INSERT INTO `application_groups` (`id`, `company_id`, `name`, `order`, `is_deleteable`, `created_at`, `updated_at`) VALUES
(1, 1, 'No Group', 1, 0, '2023-03-07 05:33:57', '2023-03-07 05:33:57'),
(2, 1, 'All Applications', 1, 1, '2023-03-07 05:33:57', '2023-03-07 05:33:57'),
(3, 1, 'Shortlisted', 2, 1, '2023-03-07 05:33:57', '2023-03-07 05:33:57'),
(4, 1, 'Interview', 3, 1, '2023-03-07 05:33:57', '2023-03-07 05:33:57'),
(5, 1, 'Rejected', 4, 1, '2023-03-07 05:33:57', '2023-03-07 05:33:57'),
(6, 2, 'No Group', 1, 0, '2023-03-07 05:41:21', '2023-03-07 05:41:21'),
(7, 2, 'All Applications', 1, 1, '2023-03-07 05:41:21', '2023-03-07 05:41:21'),
(8, 2, 'Shortlisted', 2, 1, '2023-03-07 05:41:21', '2023-03-07 05:41:21'),
(9, 2, 'Interview', 3, 1, '2023-03-07 05:41:21', '2023-03-07 05:41:21'),
(10, 2, 'Rejected', 4, 1, '2023-03-07 05:41:21', '2023-03-07 05:41:21'),
(11, 3, 'No Group', 1, 0, '2023-03-07 05:50:27', '2023-03-07 05:50:27'),
(12, 3, 'All Applications', 1, 1, '2023-03-07 05:50:27', '2023-03-07 05:50:27'),
(13, 3, 'Shortlisted', 2, 1, '2023-03-07 05:50:27', '2023-03-07 05:50:27'),
(14, 3, 'Interview', 3, 1, '2023-03-07 05:50:27', '2023-03-07 05:50:27'),
(15, 3, 'Rejected', 4, 1, '2023-03-07 05:50:27', '2023-03-07 05:50:27'),
(16, 4, 'No Group', 1, 0, '2023-03-07 07:42:34', '2023-03-07 07:42:34'),
(17, 4, 'All Applications', 1, 1, '2023-03-07 07:42:34', '2023-03-07 07:42:34'),
(18, 4, 'Shortlisted', 2, 1, '2023-03-07 07:42:34', '2023-03-07 07:42:34'),
(19, 4, 'Interview', 3, 1, '2023-03-07 07:42:34', '2023-03-07 07:42:34'),
(20, 4, 'Rejected', 4, 1, '2023-03-07 07:42:34', '2023-03-07 07:42:34'),
(31, 7, 'No Group', 1, 0, '2023-04-11 01:26:51', '2023-04-11 01:26:51'),
(32, 7, 'All Applications', 1, 1, '2023-04-11 01:26:51', '2023-04-11 01:26:51'),
(33, 7, 'Shortlisted', 2, 1, '2023-04-11 01:26:51', '2023-04-11 01:26:51'),
(34, 7, 'Interview', 3, 1, '2023-04-11 01:26:51', '2023-04-11 01:26:51'),
(35, 7, 'Rejected', 4, 1, '2023-04-11 01:26:51', '2023-04-11 01:26:51'),
(36, 8, 'No Group', 1, 0, '2023-05-31 05:16:45', '2023-05-31 05:16:45'),
(37, 8, 'All Applications', 1, 1, '2023-05-31 05:16:45', '2023-05-31 05:16:45'),
(38, 8, 'Shortlisted', 2, 1, '2023-05-31 05:16:45', '2023-05-31 05:16:45'),
(39, 8, 'Interview', 3, 1, '2023-05-31 05:16:45', '2023-05-31 05:16:45'),
(40, 8, 'Rejected', 4, 1, '2023-05-31 05:16:45', '2023-05-31 05:16:45'),
(41, 9, 'No Group', 1, 0, '2023-06-01 01:58:30', '2023-06-01 01:58:30'),
(42, 9, 'All Applications', 1, 1, '2023-06-01 01:58:30', '2023-06-01 01:58:30'),
(43, 9, 'Shortlisted', 2, 1, '2023-06-01 01:58:30', '2023-06-01 01:58:30'),
(44, 9, 'Interview', 3, 1, '2023-06-01 01:58:30', '2023-06-01 01:58:30'),
(45, 9, 'Rejected', 4, 1, '2023-06-01 01:58:30', '2023-06-01 01:58:30'),
(51, 11, 'No Group', 1, 0, '2023-06-01 02:30:50', '2023-06-01 02:30:50'),
(52, 11, 'All Applications', 1, 1, '2023-06-01 02:30:50', '2023-06-01 02:30:50'),
(53, 11, 'Shortlisted', 2, 1, '2023-06-01 02:30:50', '2023-06-01 02:30:50'),
(54, 11, 'Interview', 3, 1, '2023-06-01 02:30:50', '2023-06-01 02:30:50'),
(55, 11, 'Rejected', 4, 1, '2023-06-01 02:30:50', '2023-06-01 02:30:50'),
(56, 12, 'No Group', 1, 0, '2023-06-13 23:59:34', '2023-06-13 23:59:34'),
(57, 12, 'All Applications', 1, 1, '2023-06-13 23:59:34', '2023-06-13 23:59:34'),
(58, 12, 'Shortlisted', 2, 1, '2023-06-13 23:59:34', '2023-06-13 23:59:34'),
(59, 12, 'Interview', 3, 1, '2023-06-13 23:59:34', '2023-06-13 23:59:34'),
(60, 12, 'Rejected', 4, 1, '2023-06-13 23:59:34', '2023-06-13 23:59:34'),
(61, 13, 'No Group', 1, 0, '2023-06-14 00:33:30', '2023-06-14 00:33:30'),
(62, 13, 'All Applications', 1, 1, '2023-06-14 00:33:30', '2023-06-14 00:33:30'),
(63, 13, 'Shortlisted', 2, 1, '2023-06-14 00:33:30', '2023-06-14 00:33:30'),
(64, 13, 'Interview', 3, 1, '2023-06-14 00:33:30', '2023-06-14 00:33:30'),
(65, 27, 'No Group', 1, 0, '2023-06-22 23:55:40', '2023-06-22 23:55:40'),
(66, 27, 'All Applications', 1, 1, '2023-06-22 23:55:40', '2023-06-22 23:55:40'),
(67, 27, 'Shortlisted', 2, 1, '2023-06-22 23:55:40', '2023-06-22 23:55:40'),
(68, 27, 'Interview', 3, 1, '2023-06-22 23:55:40', '2023-06-22 23:55:40'),
(69, 27, 'Rejected', 4, 1, '2023-06-22 23:55:40', '2023-06-22 23:55:40'),
(70, 29, 'No Group', 1, 0, '2023-06-27 00:31:37', '2023-06-27 00:31:37'),
(71, 29, 'All Applications', 1, 1, '2023-06-27 00:31:37', '2023-06-27 00:31:37'),
(72, 29, 'Shortlisted', 2, 1, '2023-06-27 00:31:37', '2023-06-27 00:31:37'),
(73, 29, 'Interview', 3, 1, '2023-06-27 00:31:37', '2023-06-27 00:31:37'),
(74, 29, 'Rejected', 4, 1, '2023-06-27 00:31:38', '2023-06-27 00:31:38'),
(85, 32, 'No Group', 1, 0, '2023-06-27 00:45:49', '2023-06-27 00:45:49'),
(86, 32, 'All Applications', 1, 1, '2023-06-27 00:45:49', '2023-06-27 00:45:49'),
(87, 32, 'Shortlisted', 2, 1, '2023-06-27 00:45:49', '2023-06-27 00:45:49'),
(88, 32, 'Interview', 3, 1, '2023-06-27 00:45:49', '2023-06-27 00:45:49'),
(89, 32, 'Rejected', 4, 1, '2023-06-27 00:45:49', '2023-06-27 00:45:49'),
(90, 33, 'No Group', 1, 0, '2023-06-27 23:47:30', '2023-06-27 23:47:30'),
(91, 33, 'All Applications', 1, 1, '2023-06-27 23:47:30', '2023-06-27 23:47:30'),
(92, 33, 'Shortlisted', 2, 1, '2023-06-27 23:47:30', '2023-06-27 23:47:30'),
(93, 33, 'Interview', 3, 1, '2023-06-27 23:47:30', '2023-06-27 23:47:30'),
(94, 33, 'Rejected', 4, 1, '2023-06-27 23:47:30', '2023-06-27 23:47:30'),
(95, 34, 'No Group', 1, 0, '2023-06-28 01:13:38', '2023-06-28 01:13:38'),
(96, 34, 'All Applications', 1, 1, '2023-06-28 01:13:38', '2023-06-28 01:13:38'),
(97, 34, 'Shortlisted', 2, 1, '2023-06-28 01:13:38', '2023-06-28 01:13:38'),
(98, 34, 'Interview', 3, 1, '2023-06-28 01:13:38', '2023-06-28 01:13:38'),
(99, 34, 'Rejected', 4, 1, '2023-06-28 01:13:38', '2023-06-28 01:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `applied_jobs`
--

CREATE TABLE `applied_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `candidate_resume_id` bigint(20) UNSIGNED NOT NULL,
  `cover_letter` longtext COLLATE utf8mb4_unicode_ci,
  `application_group_id` bigint(20) UNSIGNED NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applied_jobs`
--

INSERT INTO `applied_jobs` (`id`, `candidate_id`, `job_id`, `created_at`, `updated_at`, `candidate_resume_id`, `cover_letter`, `application_group_id`, `order`) VALUES
(1, 23, 19, '2023-04-24 01:41:06', '2023-04-28 04:54:33', 21, 'Dear Mr./Ms./Mrs. (Manager’s name),\r\n\r\nI have been looking for a company that values quality over quantity and cares for employees’ growth and development. I am glad to have come across your company. I was drawn to the position of Wordpress Developer as I have experience in this field, under Oracle', 11, 1),
(2, 27, 18, '2023-05-01 23:36:48', '2023-06-01 01:03:01', 28, 'Vwbdn', 6, 1),
(8, 28, 18, '2023-06-01 00:45:45', '2023-06-01 01:03:01', 30, 'Hi,\r\nPlease review my resume. Don\'t hesitate to reach out if you have any question or need further clarification of my experience', 8, 1),
(10, 43, 26, '2023-06-21 06:35:01', '2023-06-21 06:35:01', 41, 'assd', 51, 0);

-- --------------------------------------------------------

--
-- Table structure for table `benefits`
--

CREATE TABLE `benefits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benefits`
--

INSERT INTO `benefits` (`id`, `created_at`, `updated_at`) VALUES
(2, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(3, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(4, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(5, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(6, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(7, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(8, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(9, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(10, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(11, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(12, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(13, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(16, '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(17, '2023-05-03 01:44:53', '2023-05-03 01:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `benefit_translations`
--

CREATE TABLE `benefit_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `benefit_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benefit_translations`
--

INSERT INTO `benefit_translations` (`id`, `benefit_id`, `name`, `locale`, `created_at`, `updated_at`) VALUES
(2, 2, 'Distribution team', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(3, 3, 'Async', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(4, 4, 'Vision insurance', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(5, 5, 'Health Club', 'en', '2023-02-24 04:43:21', '2023-05-24 02:00:10'),
(6, 6, 'Employee Discount', 'en', '2023-02-24 04:43:21', '2023-05-24 01:50:29'),
(7, 7, '5days working day per week', 'en', '2023-02-24 04:43:21', '2023-05-24 01:49:24'),
(8, 8, 'Paid Sick Leave', 'en', '2023-02-24 04:43:21', '2023-05-24 01:46:21'),
(9, 9, 'Paid Holiday', 'en', '2023-02-24 04:43:21', '2023-05-24 01:34:50'),
(10, 10, 'Casual Dress', 'en', '2023-02-24 04:43:21', '2023-05-24 01:32:50'),
(11, 11, 'Free gym membership', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(12, 12, 'Flexible Schedule', 'en', '2023-02-24 04:43:21', '2023-05-24 01:31:41'),
(13, 13, 'Life Insurance', 'en', '2023-02-24 04:43:21', '2023-05-24 01:30:37'),
(16, 16, 'Free Drinks', 'en', '2023-02-24 04:43:21', '2023-05-24 01:26:07'),
(17, 17, 'Travail à domicile', 'fr', '2023-05-03 01:44:53', '2023-05-24 01:24:23'),
(18, 17, 'Work From Home', 'en', '2023-05-03 01:44:53', '2023-05-24 01:24:23'),
(19, 16, 'Boissons gratuites', 'fr', '2023-05-24 01:26:07', '2023-05-24 01:26:07'),
(20, 13, 'Assurance-vie', 'fr', '2023-05-24 01:30:37', '2023-05-24 01:30:37'),
(21, 12, 'Horaire flexible', 'fr', '2023-05-24 01:31:41', '2023-05-24 01:31:41'),
(22, 10, 'tenue décontractée', 'fr', '2023-05-24 01:32:50', '2023-05-24 01:32:50'),
(23, 9, 'Congés payés', 'fr', '2023-05-24 01:34:50', '2023-05-24 01:34:50'),
(24, 8, 'Congé de maladie payé', 'fr', '2023-05-24 01:46:21', '2023-05-24 01:46:21'),
(25, 7, '5 jours ouvrés par semaine', 'fr', '2023-05-24 01:49:24', '2023-05-24 01:49:24'),
(26, 6, 'Rabais employé', 'fr', '2023-05-24 01:50:29', '2023-05-24 01:50:29'),
(27, 5, 'centre de remise en forme', 'fr', '2023-05-24 02:00:10', '2023-05-24 02:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_candidate_company`
--

CREATE TABLE `bookmark_candidate_company` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_candidate_job`
--

CREATE TABLE `bookmark_candidate_job` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookmark_candidate_job`
--

INSERT INTO `bookmark_candidate_job` (`id`, `candidate_id`, `job_id`, `created_at`, `updated_at`) VALUES
(35, 27, 19, NULL, NULL),
(37, 28, 19, NULL, NULL),
(39, 33, 16, NULL, NULL),
(40, 33, 19, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_company`
--

CREATE TABLE `bookmark_company` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookmark_company`
--

INSERT INTO `bookmark_company` (`id`, `company_id`, `candidate_id`, `category_id`, `created_at`, `updated_at`) VALUES
(5, 3, 21, 3, '2023-04-26 04:25:02', '2023-04-26 04:25:02'),
(8, 2, 28, 6, '2023-06-01 01:10:56', '2023-06-01 01:10:56'),
(21, 11, 40, 3, '2023-06-17 00:47:47', '2023-06-17 00:47:47'),
(22, 28, 46, 8, '2023-06-27 00:16:13', '2023-06-27 00:16:13'),
(23, 28, 45, 8, '2023-06-27 00:16:22', '2023-06-27 00:16:22'),
(24, 28, 42, 8, '2023-06-27 00:16:29', '2023-06-27 00:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_company_category`
--

CREATE TABLE `bookmark_company_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bookmark_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nationality_id` bigint(20) DEFAULT NULL,
  `profession_id` bigint(20) UNSIGNED DEFAULT NULL,
  `experience_id` bigint(20) UNSIGNED DEFAULT NULL,
  `education_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `cv_visibility` tinyint(1) NOT NULL DEFAULT '1',
  `received_job_alert` tinyint(1) NOT NULL DEFAULT '1',
  `profile_complete` int(11) NOT NULL DEFAULT '100',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` double DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `status` enum('available','not_available','available_in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `available_in` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `user_id`, `role_id`, `nationality_id`, `profession_id`, `experience_id`, `education_id`, `title`, `gender`, `website`, `photo`, `cv`, `bio`, `marital_status`, `birth_date`, `visibility`, `cv_visibility`, `received_job_alert`, `profile_complete`, `created_at`, `updated_at`, `address`, `neighborhood`, `locality`, `place`, `district`, `postcode`, `region`, `country`, `long`, `lat`, `status`, `available_in`) VALUES
(17, 23, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(18, 24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(19, 25, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(21, 11, 6, NULL, NULL, 1, 1, NULL, 'female', NULL, 'uploads/images/candidates/1682774255_644d18efa3635.jpg', NULL, NULL, 'Marital Status', '1970-01-01', 1, 1, 1, 100, '2023-04-14 05:33:58', '2023-04-29 07:47:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(22, 39, 3, 88, NULL, 1, 1, NULL, 'female', NULL, 'uploads/images/candidates/1682774116_644d1864337c0.jpg', NULL, NULL, 'single', '1970-01-01', 1, 1, 1, 100, '2023-04-15 00:56:49', '2023-04-29 07:45:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'not_available', NULL),
(23, 15, 2, NULL, NULL, 1, 1, NULL, 'male', NULL, 'uploads/images/candidates/1682773872_644d1770bac85.jpg', NULL, '<p>Lorem</p>', 'married', '1999-11-17', 1, 1, 1, 0, '2023-04-15 03:34:16', '2023-04-29 07:41:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '1970-01-01'),
(24, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/images/candidate/ash_1681549663_643a695f1f9de.png', NULL, NULL, NULL, NULL, 1, 1, 1, 100, '2023-04-15 03:37:43', '2023-04-15 03:37:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(25, 40, 5, 2, NULL, 6, 4, 'fuvuv', 'male', 'ufg', 'uploads/images/candidates/1682774435_644d19a3c4e9d.jpg', NULL, '<p>Helloo</p>', 'Marital Status', '2009-11-09', 1, 1, 1, 25, NULL, '2023-04-29 07:50:35', 'Villapuram Colony, Madurai, Tamil Nadu, India', NULL, NULL, NULL, NULL, NULL, 'Villapuram Colony, Madurai, Tamil Nadu, India', 'Villapuram Colony, Madurai, Tamil Nadu, India', 78.1179566, 9.9005671, 'not_available', NULL),
(27, 42, 5, 1, NULL, 2, 6, 'sdd', 'male', 'dgh', 'uploads/images/candidates/1683523252_645886b4e40ec.jpg', NULL, '<p>Vabdmf</p>', 'Marital Status', '2009-11-23', 1, 1, 1, 0, NULL, '2023-05-11 00:51:30', 'Annai Sathya Nagar, Tamil Nadu 625201, India', NULL, NULL, NULL, NULL, NULL, 'Annai Sathya Nagar, Tamil Nadu 625201, India', 'Annai Sathya Nagar, Tamil Nadu 625201, India', 78.19277869999999, 9.8956803, 'available', NULL),
(28, 43, NULL, 82, 4, 2, 6, NULL, 'male', NULL, 'uploads/images/candidates/1685944387_647d78432c89a.jpg', NULL, '<p>Hi, I am Vigneshwari<br><br><strong>Lorem ipsum&nbsp;</strong><br><br><i>testing process</i></p>', 'married', NULL, 1, 1, 1, 0, NULL, '2023-06-05 00:23:07', 'W496+M6P, Madurai, Tamil Nadu, India', NULL, NULL, NULL, NULL, NULL, 'W496+M6P, Madurai, Tamil Nadu, India', 'W496+M6P, Madurai, Tamil Nadu, India', 78.1105781, 9.9192125, 'available', '1970-01-01'),
(29, 4, 1, 82, 2, 1, 3, NULL, 'female', NULL, 'uploads/images/candidates/1683523352_64588718c1757.jpg', NULL, '<p>test</p>', 'single', '1970-01-01', 1, 1, 1, 0, '2023-05-02 12:17:53', '2023-05-23 01:25:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '1970-01-01'),
(30, 44, NULL, 82, 12, 7, 4, 'Software', 'male', 'www.abs.com', 'uploads/images/candidates/1683050251_64514f0b0e076.jpg', NULL, 'about Me', 'Single', '2009-08-03', 1, 1, 1, 50, NULL, '2023-05-02 12:28:43', 'Anaiyur, Tamil Nadu 625017, India', NULL, NULL, NULL, NULL, NULL, 'Anaiyur, Tamil Nadu 625017, India', 'Anaiyur, Tamil Nadu 625017, India', 78.1105963, 9.9609143, 'available', NULL),
(31, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(32, 46, NULL, NULL, NULL, 1, 3, 'IT', NULL, 'absera.com', 'uploads/images/candidates/1683532739_6458abc3cec31.jpg', NULL, NULL, NULL, '2023-10-14', 1, 1, 1, 50, NULL, '2023-05-08 02:28:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(33, 47, 2, 82, 2, 7, 4, 'Developer', 'male', 'no', NULL, NULL, NULL, 'Single', '2019-05-22', 1, 1, 1, 0, NULL, '2023-05-18 12:16:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(34, 48, NULL, 82, 12, 2, 3, 'null', 'male', 'https://google.com', NULL, NULL, NULL, 'Married', '2001-02-01', 1, 1, 1, 50, NULL, '2023-05-19 05:38:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(38, 53, 1, NULL, 1, 1, 1, NULL, NULL, NULL, 'uploads/images/candidate/Mahes_1685534354_64773692b9ba8.png', NULL, NULL, NULL, NULL, 1, 1, 1, 100, '2023-05-31 06:29:14', '2023-05-31 06:29:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(40, 57, 1, NULL, 1, 1, 1, NULL, NULL, NULL, 'uploads/images/candidate/mathavan_1685606383_64784fefa7adf.png', NULL, NULL, NULL, NULL, 1, 1, 1, 100, '2023-06-01 02:29:43', '2023-06-01 02:29:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(41, 59, 1, NULL, 1, 1, 1, NULL, 'male', NULL, 'uploads/images/candidate/Mithu_1686138268_64806d9c2d677.png', NULL, NULL, 'married', '2023-06-07', 1, 1, 1, 100, '2023-06-07 06:14:28', '2023-06-07 06:14:28', 'kerala-india', '', '', '', '', '', 'Kerala', 'India', 76.33729084374998, 9.937506474484438, 'available', NULL),
(42, 60, 6, NULL, 2, 1, 5, 'Engineer', 'male', NULL, 'uploads/images/candidates/1686573430_648711762949c.jpg', NULL, NULL, 'single', '1995-10-23', 1, 1, 1, 0, '2023-06-12 05:32:18', '2023-06-17 02:21:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '1970-01-01'),
(43, 66, 10, NULL, 2, 2, 5, NULL, 'male', NULL, 'uploads/images/candidate/Muthukumarabs_1687343838_6492d2deb57ae.png', NULL, NULL, 'single', '1995-10-23', 1, 1, 1, 0, '2023-06-21 05:07:18', '2023-06-21 05:34:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '1970-01-01'),
(44, 65, 10, NULL, 12, 2, 5, NULL, 'male', NULL, 'uploads/images/candidate/Muthukumar_1687432725_64942e1574bd0.png', NULL, '<p>good</p>', 'single', '1995-10-23', 1, 1, 1, 0, '2023-06-22 05:48:45', '2023-06-22 05:52:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '1970-01-01'),
(45, 89, 1, NULL, 2, 2, 5, NULL, 'male', NULL, 'uploads/images/candidate/Thanasekaran_1687757973_649924959092e.png', NULL, '<p>Searching job</p>', 'single', '1996-04-10', 1, 1, 1, 100, '2023-06-26 00:09:33', '2023-06-26 00:09:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL),
(46, 90, 1, NULL, 1, 1, 1, NULL, NULL, NULL, 'uploads/images/candidate/Saravanakumar_1687841867_649a6c4b7dfc6.png', NULL, NULL, NULL, NULL, 1, 1, 1, 100, '2023-06-26 23:27:47', '2023-06-26 23:27:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_cv_views`
--

CREATE TABLE `candidate_cv_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `view_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_cv_views`
--

INSERT INTO `candidate_cv_views` (`id`, `company_id`, `candidate_id`, `view_date`, `created_at`, `updated_at`) VALUES
(9, 8, 30, '2023-05-31 11:05:44', '2023-05-31 05:35:44', '2023-05-31 05:35:44'),
(10, 2, 28, '2023-06-01 06:37:11', '2023-06-01 01:07:11', '2023-06-01 01:07:11'),
(11, 11, 42, '2023-06-17 04:32:27', '2023-06-16 23:02:27', '2023-06-16 23:02:27'),
(12, 28, 46, '2023-06-27 05:42:43', '2023-06-27 00:12:43', '2023-06-27 00:12:43'),
(13, 28, 45, '2023-06-27 05:42:50', '2023-06-27 00:12:50', '2023-06-27 00:12:50'),
(14, 28, 44, '2023-06-27 05:42:56', '2023-06-27 00:12:56', '2023-06-27 00:12:56'),
(15, 28, 43, '2023-06-27 05:43:01', '2023-06-27 00:13:01', '2023-06-27 00:13:01'),
(16, 28, 42, '2023-06-27 05:44:09', '2023-06-27 00:14:09', '2023-06-27 00:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_education`
--

CREATE TABLE `candidate_education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_education`
--

INSERT INTO `candidate_education` (`id`, `candidate_id`, `level`, `degree`, `year`, `notes`, `created_at`, `updated_at`) VALUES
(1, 25, 'j', 'kjkj', 2028, 'hjhjhj', '2023-04-19 08:22:41', '2023-04-19 08:22:41'),
(2, 42, '3', 'engineer', 2018, NULL, '2023-06-17 02:06:30', '2023-06-17 02:06:30'),
(3, 43, '3', 'engineer', 2018, NULL, '2023-06-21 05:33:07', '2023-06-21 05:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_experiences`
--

CREATE TABLE `candidate_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `responsibilities` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currently_working` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_experiences`
--

INSERT INTO `candidate_experiences` (`id`, `candidate_id`, `company`, `department`, `designation`, `start`, `end`, `responsibilities`, `created_at`, `updated_at`, `currently_working`) VALUES
(1, 25, 'hfhf', 'hjjh', 'huh', '2023-04-25', '2023-04-24', NULL, '2023-04-19 08:22:26', '2023-04-19 08:22:26', 1),
(2, 42, 'amazon', 'php', 'backend developer', '2023-04-10', '2027-10-23', NULL, '2023-06-17 02:07:31', '2023-06-17 02:07:31', 1),
(3, 43, 'amazon', 'php', 'backend developer', '2023-04-10', NULL, 'backend support', '2023-06-21 05:32:54', '2023-06-21 05:32:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_language`
--

CREATE TABLE `candidate_language` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_language_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_language`
--

INSERT INTO `candidate_language` (`id`, `candidate_id`, `candidate_language_id`, `created_at`, `updated_at`) VALUES
(32, 22, 2, '2023-04-20 01:21:34', '2023-04-20 01:21:34'),
(33, 22, 1, '2023-04-20 01:30:57', '2023-04-20 01:30:57'),
(34, 22, 4, '2023-04-20 01:31:27', '2023-04-20 01:31:27'),
(35, 22, 3, '2023-04-20 01:31:28', '2023-04-20 01:31:28'),
(36, 22, 30, '2023-04-20 01:33:29', '2023-04-20 01:33:29'),
(43, 25, 129, '2023-04-20 05:47:31', '2023-04-20 05:47:31'),
(45, 25, 7, '2023-04-20 05:48:42', '2023-04-20 05:48:42'),
(46, 23, 153, NULL, NULL),
(48, 27, 182, '2023-05-01 23:28:47', '2023-05-01 23:28:47'),
(49, 30, 46, '2023-05-02 12:24:53', '2023-05-02 12:24:53'),
(50, 30, 153, '2023-05-02 12:25:11', '2023-05-02 12:25:11'),
(51, 28, 153, NULL, NULL),
(52, 29, 153, '2023-05-08 00:59:16', '2023-05-08 00:59:16'),
(53, 33, 30, '2023-05-18 12:17:07', '2023-05-18 12:17:07'),
(54, 33, 153, '2023-05-18 12:17:23', '2023-05-18 12:17:23'),
(55, 34, 31, '2023-05-19 05:40:11', '2023-05-19 05:40:11'),
(56, 42, 101, NULL, NULL),
(57, 42, 153, NULL, NULL),
(58, 43, 153, NULL, NULL),
(59, 44, 153, NULL, NULL),
(60, 45, 153, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_languages`
--

CREATE TABLE `candidate_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_languages`
--

INSERT INTO `candidate_languages` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Abkhaz', 'abkhaz', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'Afar', 'afar', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, 'Afrikaans', 'afrikaans', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'Akan', 'akan', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, 'Albanian', 'albanian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(6, 'Amharic', 'amharic', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, 'Arabic', 'arabic', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(8, 'Aragonese', 'aragonese', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(9, 'Armenian', 'armenian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(10, 'Assamese', 'assamese', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(11, 'Avaric', 'avaric', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(12, 'Avestan', 'avestan', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(13, 'Aymara', 'aymara', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(14, 'Azerbaijani', 'azerbaijani', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(15, 'Bambara', 'bambara', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(16, 'Bashkir', 'bashkir', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(17, 'Basque', 'basque', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(18, 'Belarusian', 'belarusian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(19, 'Bengali', 'bengali', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(20, 'Bihari', 'bihari', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(21, 'Bislama', 'bislama', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(22, 'Bosnian', 'bosnian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(23, 'Breton', 'breton', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(24, 'Bulgarian', 'bulgarian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(25, 'Burmese', 'burmese', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(26, 'Catalan; Valencian', 'catalan-valencian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(27, 'Chamorro', 'chamorro', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(28, 'Chechen', 'chechen', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(29, 'Chichewa; Chewa; Nyanja', 'chichewa-chewa-nyanja', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(30, 'Chinese', 'chinese', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(31, 'Chuvash', 'chuvash', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(32, 'Cornish', 'cornish', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(33, 'Corsican', 'corsican', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(34, 'Cree', 'cree', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(35, 'Croatian', 'croatian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(36, 'Czech', 'czech', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(37, 'Danish', 'danish', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(38, 'Divehi; Dhivehi; Maldivian;', 'divehi-dhivehi-maldivian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(39, 'Dutch', 'dutch', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(40, 'Esperanto', 'esperanto', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(41, 'Estonian', 'estonian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(42, 'Ewe', 'ewe', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(43, 'Faroese', 'faroese', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(44, 'Fijian', 'fijian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(45, 'Finnish', 'finnish', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(46, 'French', 'french', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(47, 'Fula; Fulah; Pulaar; Pular', 'fula-fulah-pulaar-pular', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(48, 'Galician', 'galician', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(49, 'Georgian', 'georgian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(50, 'German', 'german', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(51, 'Greek, Modern', 'greek-modern', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(52, 'Guaraní', 'guarani', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(53, 'Gujarati', 'gujarati', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(54, 'Haitian; Haitian Creole', 'haitian-haitian-creole', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(55, 'Hausa', 'hausa', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(56, 'Hebrew', 'hebrew', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(57, 'Hebrew', 'hebrew', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(58, 'Herero', 'herero', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(59, 'Hindi', 'hindi', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(60, 'Hiri Motu', 'hiri-motu', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(61, 'Hungarian', 'hungarian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(62, 'Interlingua', 'interlingua', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(63, 'Indonesian', 'indonesian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(64, 'Interlingue', 'interlingue', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(65, 'Irish', 'irish', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(66, 'Igbo', 'igbo', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(67, 'Inupiaq', 'inupiaq', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(68, 'Ido', 'ido', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(69, 'Icelandic', 'icelandic', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(70, 'Italian', 'italian', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(71, 'Inuktitut', 'inuktitut', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(72, 'Japanese', 'japanese', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(73, 'Javanese', 'javanese', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(74, 'Kalaallisut, Greenlandic', 'kalaallisut-greenlandic', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(75, 'Kannada', 'kannada', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(76, 'Kanuri', 'kanuri', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(77, 'Kashmiri', 'kashmiri', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(78, 'Kazakh', 'kazakh', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(79, 'Khmer', 'khmer', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(80, 'Kikuyu, Gikuyu', 'kikuyu-gikuyu', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(81, 'Kinyarwanda', 'kinyarwanda', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(82, 'Kirghiz, Kyrgyz', 'kirghiz-kyrgyz', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(83, 'Komi', 'komi', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(84, 'Kongo', 'kongo', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(85, 'Korean', 'korean', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(86, 'Kurdish', 'kurdish', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(87, 'Kwanyama, Kuanyama', 'kwanyama-kuanyama', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(88, 'Latin', 'latin', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(89, 'Luxembourgish, Letzeburgesch', 'luxembourgish-letzeburgesch', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(90, 'Luganda', 'luganda', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(91, 'Limburgish, Limburgan, Limburger', 'limburgish-limburgan-limburger', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(92, 'Lingala', 'lingala', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(93, 'Lao', 'lao', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(94, 'Lithuanian', 'lithuanian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(95, 'Luba-Katanga', 'luba-katanga', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(96, 'Latvian', 'latvian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(97, 'Manx', 'manx', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(98, 'Macedonian', 'macedonian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(99, 'Malagasy', 'malagasy', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(100, 'Malay', 'malay', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(101, 'Malayalam', 'malayalam', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(102, 'Maltese', 'maltese', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(103, 'Māori', 'maori', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(104, 'Marathi (Marāṭhī)', 'marathi-marathi', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(105, 'Marshallese', 'marshallese', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(106, 'Mongolian', 'mongolian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(107, 'Nauru', 'nauru', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(108, 'Navajo, Navaho', 'navajo-navaho', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(109, 'Norwegian Bokmål', 'norwegian-bokmal', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(110, 'North Ndebele', 'north-ndebele', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(111, 'Nepali', 'nepali', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(112, 'Ndonga', 'ndonga', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(113, 'Norwegian Nynorsk', 'norwegian-nynorsk', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(114, 'Norwegian', 'norwegian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(115, 'Nuosu', 'nuosu', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(116, 'South Ndebele', 'south-ndebele', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(117, 'Occitan', 'occitan', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(118, 'Ojibwe, Ojibwa', 'ojibwe-ojibwa', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(119, 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic', 'old-church-slavonic-church-slavic-church-slavonic-old-bulgarian-old-slavonic', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(120, 'Oromo', 'oromo', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(121, 'Oriya', 'oriya', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(122, 'Ossetian, Ossetic', 'ossetian-ossetic', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(123, 'Panjabi, Punjabi', 'panjabi-punjabi', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(124, 'Pāli', 'pali', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(125, 'Persian', 'persian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(126, 'Polish', 'polish', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(127, 'Pashto, Pushto', 'pashto-pushto', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(128, 'Portuguese', 'portuguese', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(129, 'Quechua', 'quechua', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(130, 'Romansh', 'romansh', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(131, 'Kirundi', 'kirundi', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(132, 'Romanian, Moldavian, Moldovan', 'romanian-moldavian-moldovan', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(133, 'Russian', 'russian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(134, 'Sanskrit (Saṁskṛta)', 'sanskrit-saskta', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(135, 'Sardinian', 'sardinian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(136, 'Sindhi', 'sindhi', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(137, 'Northern Sami', 'northern-sami', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(138, 'Samoan', 'samoan', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(139, 'Sango', 'sango', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(140, 'Serbian', 'serbian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(141, 'Scottish Gaelic; Gaelic', 'scottish-gaelic-gaelic', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(142, 'Shona', 'shona', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(143, 'Sinhala, Sinhalese', 'sinhala-sinhalese', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(144, 'Slovak', 'slovak', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(145, 'Slovene', 'slovene', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(146, 'Somali', 'somali', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(147, 'Southern Sotho', 'southern-sotho', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(148, 'Spanish; Castilian', 'spanish-castilian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(149, 'Sundanese', 'sundanese', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(150, 'Swahili', 'swahili', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(151, 'Swati', 'swati', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(152, 'Swedish', 'swedish', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(153, 'Tamil', 'tamil', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(154, 'Telugu', 'telugu', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(155, 'Tajik', 'tajik', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(156, 'Thai', 'thai', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(157, 'Tigrinya', 'tigrinya', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(158, 'Tibetan Standard, Tibetan, Central', 'tibetan-standard-tibetan-central', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(159, 'Turkmen', 'turkmen', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(160, 'Tagalog', 'tagalog', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(161, 'Tswana', 'tswana', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(162, 'Tonga (Tonga Islands)', 'tonga-tonga-islands', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(163, 'Turkish', 'turkish', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(164, 'Tsonga', 'tsonga', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(165, 'Tatar', 'tatar', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(166, 'Twi', 'twi', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(167, 'Tahitian', 'tahitian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(168, 'Uighur, Uyghur', 'uighur-uyghur', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(169, 'Ukrainian', 'ukrainian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(170, 'Urdu', 'urdu', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(171, 'Uzbek', 'uzbek', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(172, 'Venda', 'venda', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(173, 'Vietnamese', 'vietnamese', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(174, 'Volapük', 'volapuk', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(175, 'Walloon', 'walloon', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(176, 'Welsh', 'welsh', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(177, 'Wolof', 'wolof', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(178, 'Western Frisian', 'western-frisian', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(179, 'Xhosa', 'xhosa', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(180, 'Yiddish', 'yiddish', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(181, 'Yoruba', 'yoruba', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(182, 'Zhuang, Chuang', 'zhuang-chuang', '2023-02-24 04:43:21', '2023-02-24 04:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_resumes`
--

CREATE TABLE `candidate_resumes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_resumes`
--

INSERT INTO `candidate_resumes` (`id`, `candidate_id`, `name`, `file`, `created_at`, `updated_at`) VALUES
(20, 24, 'data_resume', 'uploads/file/candidates/GUUv5Jv7sjGSRxwcGFhASMwgmegp0GkroZVCIySK.pdf', NULL, NULL),
(21, 23, 'resume', 'uploads/file/candidates/ojl7YrxAZc3ekAZCMcJS7hDMbhMnZJhZEBTanp1S.pdf', NULL, NULL),
(22, 25, 'KG Talent Tap 2023.pdf', 'uploads/file/candidates/BboNx3LxDPTyjYJsluaI8D2CULMJ9NlWyvFk8MeP.pdf', NULL, NULL),
(23, 25, 'Letter to Parents for Fee Revision 2023-24.pdf', 'uploads/file/candidates/1XU28zGMsNQ6GlHgde8Nh6s7ZgYOfY6JgSCHuz0w.pdf', NULL, NULL),
(24, 22, 'vishnu', 'vishnu-1681823274-430.pdf', '2023-04-18 07:37:54', '2023-04-18 07:37:54'),
(25, 25, 'KG Talent Tap 2023.pdf', 'kg-talent-tap-2023pdf-1681891955-906.pdf', '2023-04-19 02:42:35', '2023-04-19 02:42:35'),
(26, 25, 'Funny Hat Day.pdf', 'funny-hat-daypdf-1681892429-514.pdf', '2023-04-19 02:50:29', '2023-04-19 02:50:29'),
(27, 25, 'Get_Started_With_Smallpdf.pdf', 'uploads/file/candidates/ruY7r72ffFC8SQ20kOqGjHJMgACZWCFmI5SqkSUu.pdf', NULL, NULL),
(28, 27, 'KG I Talent Tap Competition-Winners List 2022-2023.pdf', 'kg-i-talent-tap-competition-winners-list-2022-2023pdf-1683001879-991.pdf', '2023-05-01 23:01:19', '2023-05-01 23:01:19'),
(29, 28, 'Web_Developer_Resume_1 (1).pdf', 'uploads/file/candidates/Z12eaWQHZ4IwID13rCKmUeoSeK4kudJ21nuMnmda.pdf', NULL, NULL),
(30, 28, 'Web_Developer_Resume_1.pdf', 'uploads/file/candidates/fLfH8OP0BUhubpORvOW8o8R0FHBQ65frSfTUDeVB.pdf', NULL, NULL),
(32, 30, 'dummy.pdf', 'uploads/file/candidates/2lwdFrZvxSyclfay7cSOQMDagv4kJ3aciE1L2wme.pdf', NULL, NULL),
(33, 30, 'dummy.pdf', 'uploads/file/candidates/s161JLHZnMqugRgu5lJbIzX3QtVPvry8iI94xU8w.pdf', NULL, NULL),
(34, 30, 'dummy.pdf', 'dummypdf-1683050065-988.pdf', '2023-05-02 12:24:25', '2023-05-02 12:24:25'),
(35, 29, 'CustomerExport_2023-03-02 (1).pdf', 'customerexport-2023-03-02-1pdf-1683527100-870.pdf', '2023-05-08 00:55:00', '2023-05-08 00:55:00'),
(36, 29, 'CustomerExport_2023-03-02 (1).pdf', 'uploads/file/candidates/LWj9ys2IrlzFsIuzEHLACbrdPQUJy5GVi2nWQcZx.pdf', NULL, NULL),
(37, 33, 'dummy.pdf', 'uploads/file/candidates/KixJLIKGQgTu1xEpOfmqPeh1mmXu0PauY0haxEcW.pdf', NULL, NULL),
(38, 33, 'dummy.pdf', 'dummypdf-1684431982-897.pdf', '2023-05-18 12:16:22', '2023-05-18 12:16:22'),
(39, 29, 'test', 'uploads/file/candidates/Owms4WaPHhAkm1cTXDyTMRmnPhaaoA3WOuIfTArM.pdf', '2023-05-23 00:54:28', '2023-05-23 00:54:28'),
(40, 21, 'Testing', 'uploads/file/candidates/BG0XrVNuR2pZbG1xPo2iUrRWyT2FdML1meYjcaSB.pdf', '2023-06-12 02:00:17', '2023-06-12 02:00:17'),
(41, 43, 'muthukumar', 'uploads/file/candidates/460e4tr9qBMKNnm3rJUTOQEAflDMeAeMWa1un2Mz.pdf', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_skill`
--

CREATE TABLE `candidate_skill` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_skill`
--

INSERT INTO `candidate_skill` (`id`, `candidate_id`, `skill_id`, `created_at`, `updated_at`) VALUES
(35, 23, 2, NULL, NULL),
(36, 23, 4, NULL, NULL),
(37, 23, 12, NULL, NULL),
(38, 22, 1, NULL, NULL),
(39, 22, 2, NULL, NULL),
(40, 25, 4, NULL, NULL),
(41, 25, 12, NULL, NULL),
(42, 25, 13, NULL, NULL),
(46, 30, 4, '2023-05-02 12:25:25', '2023-05-02 12:25:25'),
(47, 30, 1, '2023-05-02 12:25:31', '2023-05-02 12:25:31'),
(48, 30, 13, '2023-05-02 12:26:06', '2023-05-02 12:26:06'),
(52, 28, 1, NULL, NULL),
(53, 28, 2, NULL, NULL),
(54, 28, 3, NULL, NULL),
(56, 27, 2, NULL, NULL),
(57, 27, 6, NULL, NULL),
(58, 27, 3, '2023-05-18 11:50:04', '2023-05-18 11:50:04'),
(59, 27, 5, '2023-05-18 11:50:19', '2023-05-18 11:50:19'),
(60, 33, 4, '2023-05-18 12:17:38', '2023-05-18 12:17:38'),
(61, 33, 5, '2023-05-18 12:17:48', '2023-05-18 12:17:48'),
(62, 34, 1, '2023-05-19 05:38:54', '2023-05-19 05:38:54'),
(63, 34, 2, '2023-05-19 05:39:13', '2023-05-19 05:39:13'),
(64, 29, 16, NULL, NULL),
(70, 42, 1, NULL, NULL),
(71, 42, 2, NULL, NULL),
(72, 42, 3, NULL, NULL),
(73, 42, 4, NULL, NULL),
(74, 42, 5, NULL, NULL),
(75, 42, 6, NULL, NULL),
(76, 43, 1, NULL, NULL),
(77, 43, 2, NULL, NULL),
(78, 43, 3, NULL, NULL),
(79, 43, 4, NULL, NULL),
(80, 43, 5, NULL, NULL),
(81, 43, 6, NULL, NULL),
(82, 44, 1, NULL, NULL),
(83, 44, 2, NULL, NULL),
(84, 44, 3, NULL, NULL),
(85, 44, 4, NULL, NULL),
(86, 45, 1, NULL, NULL),
(87, 45, 2, NULL, NULL),
(88, 45, 3, NULL, NULL),
(89, 45, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `about_brand_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_brand_logo1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_brand_logo2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_brand_logo3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_brand_logo4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_brand_logo5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_banner_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_banner_img1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_banner_img2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_banner_img3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `candidate_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employers_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_map` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_page_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_page_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_page_banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page403_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page404_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page500_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page503_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comingsoon_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_address` text COLLATE utf8mb4_unicode_ci,
  `footer_facebook_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_instagram_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_twitter_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privary_page` longtext COLLATE utf8mb4_unicode_ci,
  `terms_page` longtext COLLATE utf8mb4_unicode_ci,
  `refund_page` longtext COLLATE utf8mb4_unicode_ci,
  `maintenance_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `about_brand_logo`, `about_brand_logo1`, `about_brand_logo2`, `about_brand_logo3`, `about_brand_logo4`, `about_brand_logo5`, `about_banner_img`, `about_banner_img1`, `about_banner_img2`, `about_banner_img3`, `mission_image`, `candidate_image`, `employers_image`, `contact_map`, `register_page_image`, `login_page_image`, `home_page_banner_image`, `page403_image`, `page404_image`, `page500_image`, `page503_image`, `comingsoon_image`, `footer_phone_no`, `footer_address`, `footer_facebook_link`, `footer_instagram_link`, `footer_twitter_link`, `footer_youtube_link`, `privary_page`, `terms_page`, `refund_page`, `maintenance_image`, `created_at`, `updated_at`) VALUES
(1, 'uploads/about/1678282513_64088f1126421.png', 'uploads/about/1678282513_64088f1126a2a.png', 'uploads/about/1678282513_64088f1126aba.png', 'uploads/about/1678282590_64088f5e00139.png', 'uploads/about/1678282590_64088f5e00242.png', 'uploads/about/1678282590_64088f5e002b2.png', 'uploads/about/1678450740_640b2034c5aff.jpg', 'uploads/about/1678367113_6409d989ceb60.jpg', 'uploads/about/1678367113_6409d989ceca4.jpg', 'uploads/about/1678450719_640b201f89aed.jpg', 'uploads/ourmission/aD2wkD26gIvoeeuVOyQX4CGaG1cyRg159qynSasJ.jpg', 'uploads/candidate/1678367188_6409d9d4c822d.jpg', 'uploads/employes/1678367188_6409d9d4c83be.jpg', '33 Hodge Lane, Olanta,sc, 29114  United States', 'uploads/register/1679049611_6414438b746fd.png', 'uploads/login/1679049611_6414438b74187.png', 'uploads/home/1678255316_640824d4c2933.png', 'frontend/assets/images/banner/error-banner.png', 'frontend/assets/images/banner/error-banner.png', 'frontend/assets/images/banner/error-banner.png', 'frontend/assets/images/banner/error-banner.png', 'frontend/assets/images/all-img/coming-banner.png', '1234567890', '35 Hodge Lane, Olanta,sc, 29114  United States', 'https://www.facebook.com/', 'https://www.youtube.com/', 'https://twitter.com/', 'https://www.instagram.com/', '<h2>01. Privacy Policy</h2><p>Praesent placerat dictum elementum. Nam pulvinar urna vel lectus maximus, eget faucibus turpis hendrerit. Sed iaculis molestie arcu, et accumsan nisi. Quisque molestie velit vitae ligula luctus bibendum. Duis sit amet eros mollis, viverra ipsum sed, convallis sapien. Donec justo erat, pulvinar vitae dui ut, finibus euismod enim. Donec velit tortor, mollis eu tortor euismod, gravida lacinia arcu.</p><ul><li>In ac turpis mi. Donec quis semper neque. Nulla cursus gravida interdum.</li><li>Curabitur luctus sapien augue, mattis faucibus nisl vehicula nec. Mauris at scelerisque lorem. Nullam tempus felis ipsum, sagittis malesuada nulla vulputate et.</li><li>Aenean vel metus leo. Vivamus nec neque a libero sodales aliquam a et dolor.</li><li>Vestibulum rhoncus sagittis dolor vel finibus.</li><li>Integer feugiat lacus ut efficitur mattis. Sed quis molestie velit.</li></ul><h2>02. Limitations</h2><p>Praesent placerat dictum elementum. Nam pulvinar urna vel lectus maximus, eget faucibus turpis hendrerit. Sed iaculis molestie arcu, et accumsan nisi. Quisque molestie velit vitae ligula luctus bibendum. Duis sit amet eros mollis, viverra ipsum sed, convallis sapien. Donec justo erat, pulvinar vitae dui ut, finibus euismod enim. Donec velit tortor, mollis eu tortor euismod, gravida lacinia arcu.</p><ul><li>In ac turpis mi. Donec quis semper neque. Nulla cursus gravida interdum.</li><li>Curabitur luctus sapien augue.</li><li>mattis faucibus nisl vehicula nec, Mauris at scelerisque lorem.</li><li>Nullam tempus felis ipsum, sagittis malesuada nulla vulputate et. Aenean vel metus leo.</li><li>Vivamus nec neque a libero sodales aliquam a et dolor.</li></ul><h2>03. Security</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ex neque, elementum eu blandit in, ornare eu purus. Fusce eu rhoncus mi, quis ultrices lacus. Phasellus id pellentesque nulla. Cras erat nisi, mattis et efficitur et, iaculis a lacus. Fusce gravida augue quis leo facilisis.</p><h2>04. Privacy Policy</h2><p>Praesent non sem facilisis, hendrerit nisi vitae, volutpat quam. Aliquam metus mauris, semper eu eros vitae, blandit tristique metus. Vestibulum maximus nec justo sed maximus. Vivamus sit amet turpis sem. Integer vitae tortor ac ex scelerisque facilisis ac vitae urna. In hac habitasse platea dictumst. Maecenas imperdiet tortor arcu, nec tincidunt neque malesuada volutpat.</p><ul><li>In ac turpis mi. Donec quis semper neque. Nulla cursus gravida interdum.</li><li>Mauris at scelerisque lorem. Nullam tempus felis ipsum, sagittis malesuada nulla vulputate et.</li><li>Aenean vel metus leo.</li><li>Vestibulum rhoncus sagittis dolor vel finibus.</li><li>Integer feugiat lacus ut efficitur mattis. Sed quis molestie velit.</li></ul><p>Fusce rutrum mauris sit amet justo rutrum, ut sodales lorem ullamcorper. Aliquam vitae iaculis urna. Nulla vitae mi vel nisl viverra ullamcorper vel elementum est. Mauris vitae elit nec enim tincidunt aliquet. Donec ultrices nulla a enim pulvinar, quis pulvinar lacus consectetur. Donec dignissim, risus nec mollis efficitur, turpis erat blandit urna, eget elementum lacus lectus eget lorem.</p><p><br>&nbsp;</p>', '<h2>01. Terms &amp; Condition</h2><p>Praesent placerat dictum elementum. Nam pulvinar urna vel lectus maximus, eget faucibus turpis hendrerit. Sed iaculis molestie arcu, et accumsan nisi. Quisque molestie velit vitae ligula luctus bibendum. Duis sit amet eros mollis, viverra ipsum sed, convallis sapien. Donec justo erat, pulvinar vitae dui ut, finibus euismod enim. Donec velit tortor, mollis eu tortor euismod, gravida lacinia arcu.</p><ul><li>In ac turpis mi. Donec quis semper neque. Nulla cursus gravida interdum.</li><li>Curabitur luctus sapien augue, mattis faucibus nisl vehicula nec. Mauris at scelerisque lorem. Nullam tempus felis ipsum, sagittis malesuada nulla vulputate et.</li><li>Aenean vel metus leo. Vivamus nec neque a libero sodales aliquam a et dolor.</li><li>Vestibulum rhoncus sagittis dolor vel finibus.</li><li>Integer feugiat lacus ut efficitur mattis. Sed quis molestie velit.</li></ul><h2>02. Limitations</h2><p>Praesent placerat dictum elementum. Nam pulvinar urna vel lectus maximus, eget faucibus turpis hendrerit. Sed iaculis molestie arcu, et accumsan nisi. Quisque molestie velit vitae ligula luctus bibendum. Duis sit amet eros mollis, viverra ipsum sed, convallis sapien. Donec justo erat, pulvinar vitae dui ut, finibus euismod enim. Donec velit tortor, mollis eu tortor euismod, gravida lacinia arcu.</p><ul><li>In ac turpis mi. Donec quis semper neque. Nulla cursus gravida interdum.</li><li>Curabitur luctus sapien augue.</li><li>mattis faucibus nisl vehicula nec, Mauris at scelerisque lorem.</li><li>Nullam tempus felis ipsum, sagittis malesuada nulla vulputate et. Aenean vel metus leo.</li><li>Vivamus nec neque a libero sodales aliquam a et dolor.</li></ul><h2>03. Security</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ex neque, elementum eu blandit in, ornare eu purus. Fusce eu rhoncus mi, quis ultrices lacus. Phasellus id pellentesque nulla. Cras erat nisi, mattis et efficitur et, iaculis a lacus. Fusce gravida augue quis leo facilisis.</p><h2>04. Privacy Policy</h2><p>Praesent non sem facilisis, hendrerit nisi vitae, volutpat quam. Aliquam metus mauris, semper eu eros vitae, blandit tristique metus. Vestibulum maximus nec justo sed maximus. Vivamus sit amet turpis sem. Integer vitae tortor ac ex scelerisque facilisis ac vitae urna. In hac habitasse platea dictumst. Maecenas imperdiet tortor arcu, nec tincidunt neque malesuada volutpat.</p><ul><li>In ac turpis mi. Donec quis semper neque. Nulla cursus gravida interdum.</li><li>Mauris at scelerisque lorem. Nullam tempus felis ipsum, sagittis malesuada nulla vulputate et.</li><li>Aenean vel metus leo.</li><li>Vestibulum rhoncus sagittis dolor vel finibus.</li><li>Integer feugiat lacus ut efficitur mattis. Sed quis molestie velit.</li></ul><p>Fusce rutrum mauris sit amet justo rutrum, ut sodales lorem ullamcorper. Aliquam vitae iaculis urna. Nulla vitae mi vel nisl viverra ullamcorper vel elementum est. Mauris vitae elit nec enim tincidunt aliquet. Donec ultrices nulla a enim pulvinar, quis pulvinar lacus consectetur. Donec dignissim, risus nec mollis efficitur, turpis erat blandit urna, eget elementum lacus lectus eget lorem.</p><p><br>&nbsp;</p>', NULL, 'frontend/assets/images/all-img/coming-banner.png', '2023-02-24 04:43:20', '2023-03-17 05:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `cms_contents`
--

CREATE TABLE `cms_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `translation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_contents`
--

INSERT INTO `cms_contents` (`id`, `page_slug`, `translation_code`, `text`, `created_at`, `updated_at`) VALUES
(1, 'terms_condition_page', 'en', '<h2><strong>Terms and Conditions for Jobstar</strong></h2><h2><strong>Introduction</strong></h2><p>These Website Standard Terms and Conditions written on this webpage shall manage your use of our website, Jobstar accessible at jobstar.abservetechdemo.com.</p><p>These Terms will be applied fully and affect to your use of this Website. By using this Website, you agreed to accept all terms and conditions written in here. You must not use this Website if you disagree with any of these Website Standard Terms and Conditions.</p><p>Minors or people below 18 years old are not allowed to use this Website.</p><h2><strong>Intellectual Property Rights</strong></h2><p>Other than the content you own, under these Terms, Jobstar and/or its licensors own all the intellectual property rights and materials contained in this Website.</p><p>You are granted a limited license only for the purposes of viewing the material contained on this Website.</p><h2><strong>Restrictions</strong></h2><p>You are specifically restricted from all of the following:</p><ul><li>publishing any Website material in any other media;</li><li>selling, sublicensing, and/or otherwise commercializing any Website material;</li><li>publicly performing and showing any Website material;</li><li>using this Website in any way that is or may be damaging to this Website;</li><li>using this Website in any way that impacts user access to this Website;</li><li>using this Website contrary to applicable laws and regulations, or in any way may cause harm to the Website, or to any person or business entity;</li><li>engaging in any data mining, data harvesting, data extracting or any other similar activity in relation to this Website;</li><li>using this Website to engage in any advertising or marketing.</li></ul><p>Certain areas of this Website are restricted from being accessed by you and Jobstar may further restrict access by you to any areas of this Website, at any time, at absolute discretion. Any user ID and password you may have for this Website are confidential and must maintain confidentiality.</p>', '2023-02-24 04:43:20', '2023-03-09 00:44:38'),
(2, 'privacy_page', 'en', '<h2><strong>Privacy Policy for Jobstar</strong></h2><p>At Jobstar, accessible at jobstar.abservetechdemo.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Jobstar and how we use it.</p><p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us through email at support@abservetech.com</p><p>This privacy policy applies only to our online activities and is valid for visitors to our website with regard to the information that they shared and/or collect in Jobstar. This policy is not applicable to any information collected offline or via channels other than this website.</p><p><strong>Consent</strong></p><p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p><p><strong>Information we collect</strong></p><p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p><p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p><p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p><p><strong>How we use your information</strong></p><p>We use the information we collect in various ways, including to:</p><ul><li>Provide, operate, and maintain our website</li><li>Improve, personalize, and expand our website</li><li>Understand and analyze how you use our website</li><li>Develop new products, services, features, and functionality</li><li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li><li>Send you emails</li><li>Find and prevent fraud</li></ul><p><strong>Log Files</strong></p><p>Jobstar follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and are a part of hosting services\' analytics. The information collected by log files includes internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</p><h3><strong>Cookies and Web Beacons</strong></h3><p>Like any other website, Jobstar uses ‘cookies\'. These cookies are used to store information including visitors\' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users\' experience by customizing our web page content based on visitors browser type and/or other information.</p>', '2023-02-24 04:43:20', '2023-03-09 00:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `industry_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `organization_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `team_size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `establishment_date` date DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `profile_completion` tinyint(1) NOT NULL DEFAULT '0',
  `bio` text COLLATE utf8mb4_unicode_ci,
  `vision` text COLLATE utf8mb4_unicode_ci,
  `total_views` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` double DEFAULT NULL,
  `lat` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `industry_type_id`, `organization_type_id`, `team_size_id`, `logo`, `banner`, `establishment_date`, `website`, `visibility`, `profile_completion`, `bio`, `vision`, `total_views`, `created_at`, `updated_at`, `address`, `neighborhood`, `locality`, `place`, `district`, `postcode`, `region`, `country`, `long`, `lat`) VALUES
(1, 1, 15, 2, 5, 'uploads/company/qP2DCFe7nUJLiKlbjqoDUPa5MnxqI8jvIbqE3Mov.png', 'uploads/company/poySWBO95OchTzCeNuiaEsazWxSSyGLooVKBkRsK.png', '2024-03-13', 'https://abservetech.com//', 1, 0, '<h2><strong>Our Company</strong></h2><p>Changing the world through digital experiences is what Adobe’s all about. We give everyone—from emerging artists to global brands—everything they need to design and deliver exceptional digital experiences. We’re passionate about empowering people to craft beautiful and powerful images, videos, and apps, and transform how companies interact with customers across every screen.</p><p>&nbsp;</p><p>We’re on a mission to hire the very best and are committed to building exceptional employee experiences where everyone is respected and has access to equal opportunity. We realize that new insights can come from everywhere in the organization, and we know the next big idea could be yours!</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>The Opportunity</strong></h2><p>As a Senior Technical Support Engineer for AEM you will provide support for the global Adobe AEM customer base. Key elements of the role involve investigating and resolving our clients’ technical issues and ensuring our customers have a clear understanding of where things stand from the time the ticket is created thru issue resolution. You will field questions, work on high-priority issues, meet with Customers regularly, and handle partner concerns while working with the extended Adobe Support team (Support and Engineering) all within the time frame of our SLAs. The over-arching goal is to ensure that you provide our customers with an outstanding level of technical support, resulting in Customers being wildly successful in their use of AEM!</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>What </strong>You\'ll<strong> Do</strong></h2><ul><li>Respond to high-priority cases where the ability to apply your understanding of AEM to investigate, debug and ultimately resolve our customer’s technical issues is the core of your day to day</li><li>First point of contact for customer concerns relating to technical issues/questions</li><li>Advocate for, and represent our Client\'s needs with internal Product and Engineering teams</li><li>Provide response/update/resolution to technical inquiries within established Service Level Agreement guidelines</li><li>Ensure you have an understanding of the Customer’s priorities and how technical issues are impacting their business and customer base</li><li>Provides proactive Issue Status updates to required parties</li><li>Trouble-shoot/qualify cases before advancing into Engineering</li><li>Answer questions regarding product functionality and usage</li><li>Fix implementation problems</li><li>Product Content Creation (KB articles, whitepapers, forum participation)</li><li>Provide Knowledge Transfer sessions to help reduce customer concerns about Adobe</li><li>Continuously expand your AEM expertise thru individual and group enablement sessions, interactions with product/engineering teams and working side by side with other Technical Support Engineers on your team.</li></ul><p>&nbsp;</p><h2>What You Will Need to Succeed</h2><ul><li>BA/BS Degree in a related field or equivalent experience.</li><li>2+ years’ experience with Adobe AEM preferably on the backend as a developer or architect</li><li>Strong technical knowledge of J2EE applications, database concepts, and SSO (e.g. LDAP, SAML, OAuth).</li><li>Experience investigating and debugging multi-tier web applications</li><li>Performance tuning and optimization of web applications</li><li>Working experience with Java, JavaScript, HTML, CSS, and XML</li><li>Windows/Linux server knowledge</li><li>Experience in customer care/customer support or related field a plus</li><li>Experience in a wide range of computer operating systems and software with emphasis on installation, investigating, debugging, upgrading, integration and client/server operations is desired.</li><li>Advanced interpersonal skills.</li><li>Ability to multi-task and prioritize.</li></ul><p>&nbsp;</p><p>At Adobe, you will be immersed in an exceptional work environment that is recognized throughout the world on Best Companies lists. You will also be surrounded by colleagues who are committed to helping each other grow through our unique Check-In approach where ongoing feedback flows freely.</p><p>&nbsp;</p><p>If you’re looking to make an impact, Adobe\'s the place for you. Discover what our employees are saying about their career experiences on the Adobe Life blog and explore the meaningful benefits we offer.</p><p>Adobe is an equal opportunity employer. We welcome and encourage diversity in the workplace regardless of gender, race or color, ethnicity or national origin, age, disability, religion, sexual orientation, gender identity or expression, or veteran status.</p><p>&nbsp;</p><h3>&nbsp;</h3><p>&nbsp;</p><p>Our compensation reflects the cost of labor across several  U.S. geographic markets, and we pay differently based on those defined markets. The U.S. pay range for this position is $88,200 -- $166,000 annually. Pay within this range varies by work location and may also depend on job-related knowledge, skills, and experience. Your recruiter can share more about the specific salary range for the job location during the hiring process.</p><p>&nbsp;</p><p>At Adobe, for sales roles starting salaries are expressed as total target compensation (TTC = base + commission), and short-term incentives are in the form of sales commission plans.&nbsp; Non-sales roles starting salaries are expressed as base salary and short-term incentives are in the form of the Annual Incentive Plan (AIP).</p><p>&nbsp;</p><p>In addition, certain roles may be eligible for long-term incentives in the form of a new hire equity award.</p>', '<p>Adobe pioneered the paper-to-digital transformation with the invention of PDF. We created Adobe Document Cloud so people can scan, edit, share, and sign documents anytime, anywhere. Today, we’re revolutionizing the way people and businesses communicate, collaborate, and get work done.</p><p><br>&nbsp;</p>', 0, '2023-03-07 05:33:57', '2023-03-13 02:18:50', 'tamil-nadu-india', '', '', 'undefined', 'Ramanathapuram District', '', 'Tamil Nadu', 'India', 78.46847534179689, 9.328476228699701),
(2, 2, 22, 4, 4, 'uploads/images/company/Ericsson_1685600801_64783a21ac534.png', 'uploads/company/zHjWdLHoZ8K5e8BvUHDve1STbw6eY1oUc5r6behq.png', '2024-04-11', 'http://ericson.com', 1, 1, '<h4><a href=\"https://www.ericsson.com/en/networks\">Networks</a></h4><p>We develop, deliver and manage telecommunication networks by providing hardware, software, and services to enable the full value of connectivity. From 5G and IoT to virtualization, we are supporting digital transformation for the next generation of mobile services.</p><h4>Cloud Software and Services</h4><p>We provide industry leading solutions for <a href=\"https://www.ericsson.com/en/core-network\">Core Network and Automation</a>, <a href=\"https://www.ericsson.com/en/managed-services\">Managed Services</a>, <a href=\"https://www.ericsson.com/en/oss-bss/orchestration\">Services Orchestration</a> and <a href=\"https://www.ericsson.com/en/oss-bss\">Telecom BSS</a>. We help enable communications service providers to succeed in their transition to cloud native software and automated operations, as they prepare their networks for the future.</p><p>Emerging Business:</p><p>We accelerate new and sustainable businesses beyond Ericsson\'s traditional core business. Technologies like 5G, artificial intelligence, automation, VR/AR, and edge computing are opening up new, vast opportunities for our customers, partners and our company. Our current businesses are targeting high growth markets where our technology is relevant, e.g. Industry 4.0 and smart manufacturing, <a href=\"https://www.ericsson.com/en/internet-of-things\">IoT</a> connectivity, connected vehicles, security and <a href=\"https://www.ericsson.com/en/edge-computing\">edge computing</a>. Innovation is at our core, and <a href=\"https://www.ericsson.com/en/ericsson-one\">Ericsson ONE</a> is where new, game-changing ideas are brought to life.</p><p><br>Our customers are happy to speak for us.&nbsp;<a href=\"https://www.ericsson.com/en/cases\">Listen to some of their stories</a>&nbsp;to hear how we are helping them increase their efficiency, improve their digital experience and capture new revenue streams.</p><p>Research &amp; Development (R&amp;D) is at the heart of our business with approximately 26,000 employees. Ericsson engineers, researchers and scientists around the world are working on what’s <a href=\"https://www.ericsson.com/en/future-technologies\">next big thing with technology in focus</a>. With more than 60,000 granted <a href=\"https://www.ericsson.com/en/patents\">patents,</a>&nbsp;we have one of the strongest intellectual property rights portfolios in the industry.</p><p><br>Our history</p><p>Lars Magnus Ericsson founded Ericsson&nbsp;<a href=\"https://www.ericsson.com/en/about-us/history\">145 years ago</a>&nbsp;on the premise that access to communications is a basic human need. Since then we have continued to deliver ground-breaking solutions and innovate technology for good.</p><p>We have always put enormous time and effort into collaborating with others to set the open&nbsp;<a href=\"https://www.ericsson.com/en/standardization\">standards</a>&nbsp;that make global communications and connections possible. Here you will find some examples of our&nbsp;<a href=\"https://www.ericsson.com/en/about-us/company-facts/innovation-history\">innovations that have had significant impact</a>&nbsp;on people, business and society.</p><p>&nbsp;</p>', '<p>Ericsson is one of the leading providers of Information and Communication Technology (ICT) to service providers. We enable the full value of connectivity by creating game-changing technology and services that are easy to use, adopt, and scale, making our customers successful in a fully connected world.</p><p><br>&nbsp;</p>', 0, '2023-03-07 05:41:21', '2023-06-01 01:00:17', 'tamil-india', '', '', '', '', '', 'Tamil', 'India', 78.02428735155947, 9.856567211645736),
(3, 3, 15, 4, 5, 'uploads/company/VOb6lkB54Ll3p045OHjlTA2YSWm1paDVd9farf8M.png', 'uploads/company/fM18qOjfwlPgZDYlX9q6lx4rE9bweeMVOhcVb9TK.jpg', '2015-01-23', 'https://www.oracle.com/', 1, 1, '<h2>Oracle Analyst Reports</h2><p>Discover the latest reports, research, and news from top analyst firms such as Gartner, IDC, Forrester, and Omdia, helping you gain insights into Oracle products and services.</p><h2>Open Source at Oracle</h2><p>Oracle is the purveyor of the industry’s most widely adopted open source technologies, such as <a href=\"https://openjdk.java.net/\">Java</a> and <a href=\"https://www.mysql.com/\">MySQL</a>, and one of the founding members of the <a href=\"https://linuxfoundation.org/\">Linux Foundation</a>, the <a href=\"https://www.eclipse.org/\">Eclipse Foundation</a>, and the <a href=\"https://jcp.org/en/home/index\">Java Community Process</a>.</p><p>But what has guided us along the way?</p><p>Our mission is to empower developers and continue supporting open source technologies. Through Oracle Cloud Infrastructure and its 41 cloud regions, we’re providing more opportunities than ever to make open source technology available to everyone.<br>ORACLE CAREERS</p><h2>Create the future with us</h2><p>Want to make a difference? You’ve come to the right place. We’re using the technologies of tomorrow to tackle the real-world problems of today.</p><h2>Change lives doing what you love</h2><p>From advancing energy efficiency to reimagining online commerce, the work we do is not only transforming the world of business—it\'s protecting governments, powering non-profits, and giving billions of people the tools they need to outpace change. What future will you create?</p><p><br>&nbsp;</p>', '<h2>Our mission is to help people see data in new ways, discover insights, unlock endless possibilities.</h2>', 0, '2023-03-07 05:50:27', '2023-04-18 02:45:51', 'india', '', '', '', '', '', NULL, 'India', 80.49519002437592, 13.024451251179633),
(4, 7, 15, 4, 7, 'uploads/company/1678194754_6407384245188.jpeg', 'uploads/company/1678194754_6407384245663.jpeg', '2020-02-03', 'https://www.zoho.com/', 1, 0, '<p><strong>The Zoho Family,</strong></p><p>Zoho Office Suite is an Indian web-based online office suite keeping word processing, spreadsheets, presentations, databases, note-taking, wikis, web conferencing, customer relationship management (CRM), project management, invoicing, and applications.</p><p><br>What are the top skills needed to work as a Technical Support Engineer at Zoho? Application Support, Product Support, Technical Support, customer support, and Client Relationship are the popular skills required to work as a Technical Support Engineer at Zoho India.</p><p><strong>Essential Knowledge, Skills, and Experience</strong></p><p>The interview is to know all the possible content of the field you are applying. The skills looked for are programming languages like C, C++, C# &amp; Java.</p><p>1. You must have excellent communication skills.<br>2. Strong Analytical Skills.<br>3. Good working knowledge of Coding Level.<br>4. Must have good logical reasoning skills.</p><p>You should have completed B.E/ B.Tech or Any degree (Arts) and are eligible to attend this recruitment. Candidates who have completed their Graduation in 2021 or 2022 are eligible to attend this recruitment.</p><p>Both freshers, as well as experienced candidates, are eligible to attend this recruitment.</p><h2>A focus on what matters.</h2><p>Zoho is committed to spending your money wisely. <a href=\"https://www.zoho.com/perspectives/money.html\">We invest more in product development and customer support than in sales and marketing.</a> It always struck us as paradoxical to charge the customer extra for the privilege of marketing back to them. By keeping our cost of attracting customers low, we keep our prices affordable and pass the savings onto our users.</p><p>We’re gentle in our sales approach, so we don\'t push our people to push you. You won’t find us trying to endlessly upsell you, or buying your loyalty through multi-year contracts. And with growth that regularly outstrips our competitors, we know that this model works.</p><h2>A private company with a public vision.</h2><p><br>We’ve stayed private and we’ve never taken other people’s money. Neither will change. This keeps us independent and beholden to only the customer, permitting a long term view to naturally unfold. We are private, but far from small. With nearly 12,000 employees across the globe, our style of unconventional thinking seems to have paid off.</p><p><br>Our investment in people is a vital part of our R&amp;D edge. We have a comprehensive program to hire high school students and train them - <a href=\"https://www.zohoschools.com/\">a program we call Zoho Schools of Learning.</a> Over 15% of our engineers come from this program. Not only is the program good for our company, it is also good for the communities we live in.</p><h2>Free from prying eyes.</h2><p>The decision to value customer privacy isn\'t one you make after watching which way the wind blows. It must stem from prior belief, perhaps even dogma. This is exactly why we made the decision more than two decades ago that we weren\'t going to sell ads inside our products, not even within the free editions. <a href=\"https://www.zoho.com/perspectives/privacy.html\">We\'re not interested in tracking your clicks to feed the marketing monster. </a>We will make our money the traditional way—bringing you valuable software that you are happy to pay us for.</p><p>So why did we make this choice to put privacy first? Simple. We valued our privacy; we figured you would, too. And that\'s why we\'ve prided ourselves on being ahead of the curve when it comes to government regulations about privacy; we don\'t need to be told what good business should look like.</p><h2>A product to meetevery need.</h2><p>Over the years, we\'ve crafted dozens of products with equal fervor. Now they are even available under one single integrated suite, Zoho One, <a href=\"https://www.zoho.com/perspectives/zoho-one.html\">that can put a business completely on the cloud.</a> Unlike our competitors, who periodically wake up to discover gaping product holes that they must now fill urgently with acquisitions to reassure their shareholders, we craft our portfolio with patience and anticipation.</p><p>Our strategy is born from the realization that the vast majority of acquisitions fail, and it’s the customer that pays the price. Many of our products were developed to meet our own needs—for Zoho itself runs entirely on Zoho. This means our software often must fail us, before it can fail you.</p>', '<p><strong>Zoho – Vision and Mission</strong></p><p><br>Zoho\'s vision is to create superior software to solve all business problems. The company\'s investment is more in developing its products and customer support rather than focusing on sales and marketing.</p>', 0, '2023-03-07 07:42:34', '2023-04-18 00:28:11', 'andhra-pradesh-india', '', '', 'undefined', 'Chittoor', '', 'Andhra Pradesh', 'India', 78.39843750000001, 12.897489183755892),
(7, 26, 15, 4, 3, 'uploads/company/ldpoQHfHePdtdef8qpuVmZBdKCB2PKVjqnD9TMSF.jpg', 'uploads/company/7TEQi8BuQ9b0E1HaeOMQ5jxaTrhUCfkm5EEhstyk.jpg', '2019-01-15', 'https://www.infotech.com', 1, 1, '<p>OUR CULTURE</p><p>Two university professors founded this company while working out of a garage to build something innovative and inclusive. Four decades later, we’re still working hard to grow in a way that keeps people and relationships at the forefront of progress - we just have nicer offices.</p><p>OUR COMMUNITY</p><p><br>We are committed to giving back to the communities in which we live and work.</p><p><br>PEOPLE FIRST</p><p>We believe work is a part of life, not the opposite. Our benefits and initiatives allow you to prioritize the things most important to you</p><h2>Our history</h2><p>There are endless milestones that define who Infotech is today. And that’s not even the best part. Because this timeline isn’t just meant to show our history - it’s meant to show opportunity.<br>&nbsp;</p><p><br>Before It All Began</p><h2>1976</h2><p>Dr. Jim McClave works out of his garage as a legal consultant when he’s not teaching at the University of Florida. Meanwhile, at the University of Missouri, Dr. Tom Rothrock completes his Ph.D. thesis on the statistical analysis of sealed bid markets that would form the basis of our early techniques for detecting bid rigging.</p><h3>Out of the Garage</h3><h2>1980</h2><p>Jim takes time off from UF without pay to keep growing Infotech, renting two rooms in an accounting company’s office. Several employees join the company who are still part of the Infotech family today. Will and Jamie McClave, Infotech\'s future Presidents, are 8 and 6 years old respectively.</p><h3>New Decade, New Standards</h3><h2>1990</h2><p>Infotech rewrites all its software in the new IBM CICS and DEC VAX environments, creating a standardized enterprise application. This development allowed for scalability across multiple DOTs with a single code base on each platform.</p><h3>A Growing Profile</h3><h2>2002</h2><p>Infotech’s reputation grows in more ways than one. As the software business begins developing Appia® for construction administration and inspection, the Consulting business participates in a high-profile case involving an Anheuser-Busch distributorship founded by professional baseball player Roger Maris.</p><h3>Bid Express: The Sequel</h3><h2>2010</h2><p>Not wanting to leave out non-DOT markets, Infotech launches a secondary version of Bid Express® for vertical construction and general procurement as part of the growing ITI Products line.</p><h3>Innovation Built on Integrity</h3><h2>Tomorrow ‘til Infinity</h2><p>The core values present in 1977 - trust, innovation, transparency - continue to guide Infotech to this day. We’re still a family company. We still thrive on innovation. Our yearly hack-a-thons and Project: LAUNCH! continue to produce valuable new ideas that bolster our products and services. We still do right by our people. We continue to value our internal and external relationships. We give charitably, act responsibly, and trust each other without hesitation. We’re still driven by the same spirit that led two university professors with stable jobs to leave everything behind for a chance to build something of their own. Our past is on this page. Our future is in our people. Let’s keep building this road together.</p><h2>A state-of-the-art campus</h2><p>Our LEED-Gold certified building is located in the mixed-use community of Celebration Pointe. When they’re not relaxing on our roof terrace or playing a game of ping pong, our employees can be found exploring the green spaces, shops and restaurants that line the promenade of Celebration Pointe.</p><p><br>&nbsp;</p><p><br>&nbsp;</p>', '<h2>Treating People Right</h2><p>Our mission is to set the standard for how a company should treat people - including employees - and then continue to raise the bar. We celebrate diversity, creativity and individuality. At Infotech, difference is not only accepted, it is welcomed and celebrated. We believe in investing in people and pride ourselves on building long-lasting, authentic relationships and treating people right. Or TPR, as we like to call it.<br><br>Every day our people help us bridge innovation and integrity by developing cutting-edge digital solutions for the infrastructure construction industry and providing expert statistical and econometric consulting services across multiple industries</p>', 0, '2023-04-11 01:26:51', '2023-04-18 02:26:52', 'kerala-india', '', '', '', '', '', 'Kerala,', 'India', 76.32624398124823, 9.512176757594878),
(8, 52, 15, 4, 1, 'uploads/images/company/1685530040_647725b87c421.jpeg', 'uploads/images/company/1685530040_647725b87c5c7.jpeg', '2000-02-22', 'https://Abs.com', 1, 1, '<p>AAA</p>', '<p>aaa</p>', 0, '2023-05-31 05:16:45', '2023-05-31 06:59:47', 'tamil-nadu-india', '', '', '', '', '', 'Tamil Nadu', 'India', 78.00171955468748, 10.079169594676),
(9, 54, 6, 1, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, 0, '2023-06-01 01:58:30', '2023-06-01 01:58:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 58, 6, 1, 1, 'uploads/images/company/1685607986_647856327a08a.png', 'uploads/images/company/1685607986_647856327a305.jpg', '2023-06-01', NULL, 1, 1, 'Dummy data', '<p>Lorem&nbsp;</p>', 0, '2023-06-01 02:30:50', '2023-06-01 02:57:20', 'tamil-india', '', '', '', '', '', 'Tamil', 'India', 78.09588441725282, 9.930133336146053),
(12, 62, 15, 4, NULL, 'uploads/images/company/Kumaresh_1686720575_6489503f1a042.png', 'uploads/images/company/Kumaresh_1686720575_6489503f239c0.png', '2023-06-14', NULL, 1, 0, NULL, NULL, 0, '2023-06-13 23:59:34', '2023-06-13 23:59:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 63, 15, 4, NULL, 'uploads/images/company/Vishnu_1686722611_6489583304560.png', 'uploads/images/company/Vishnu_1686722611_6489583304e37.png', '2023-06-14', NULL, 1, 0, NULL, NULL, 0, '2023-06-14 00:33:30', '2023-06-14 00:33:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 64, 15, 4, 1, 'uploads/images/company/1687426472_649415a830f3d.png', 'uploads/images/company/1687426472_649415a830e9f.png', '2023-04-10', NULL, 1, 1, 'Laravel', '<p>Best developement company in india</p>', 0, '2023-06-17 04:38:22', '2023-06-22 04:04:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 86, 15, 4, 1, 'uploads/images/company/Vijay_1687497940_64952cd4eaa1f.png', 'uploads/images/company/Vijay_1687497941_64952cd50830f.png', '2023-04-10', NULL, 1, 0, '<p>Laravel</p>', '<p>Node Js</p>', 0, '2023-06-22 23:55:40', '2023-06-22 23:55:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 88, 15, 4, 1, 'uploads/images/company/1687842525_649a6eddae868.jpeg', 'uploads/images/company/1687842525_649a6eddae965.png', NULL, NULL, 1, 1, 'sss', '<p>Laravel</p>', 0, '2023-06-23 00:27:50', '2023-06-26 23:39:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 91, 15, 4, 1, 'uploads/images/company/1687845710_649a7b4eb2586.png', 'uploads/images/company/1687845710_649a7b4eb2674.png', NULL, NULL, 1, 1, 'sss', '<p>sds</p>', 0, '2023-06-27 00:31:37', '2023-06-27 00:32:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 94, 15, 4, 1, 'uploads/images/company/1687846651_649a7efb6652a.png', 'uploads/images/company/1687846651_649a7efb66643.png', '2000-10-23', NULL, 1, 1, 'Laravel', '<p>Laravel</p>', 0, '2023-06-27 00:45:49', '2023-06-27 01:29:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 95, 6, 1, 1, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, 0, '2023-06-27 23:47:30', '2023-06-27 23:47:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 96, 15, 4, 1, 'uploads/images/company/1687934638_649bd6ae5314e.jpeg', 'uploads/images/company/1687934638_649bd6ae53280.jpeg', '2023-06-15', NULL, 1, 1, 'dfd', '<p>sdsd</p>', 0, '2023-06-28 01:13:38', '2023-06-28 01:15:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_applied_job_rejected`
--

CREATE TABLE `company_applied_job_rejected` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `applied_job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_applied_job_shortlist`
--

CREATE TABLE `company_applied_job_shortlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `applied_job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_bookmark_categories`
--

CREATE TABLE `company_bookmark_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_bookmark_categories`
--

INSERT INTO `company_bookmark_categories` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 11, 'test', '2023-04-15 02:21:17', '2023-04-15 02:21:17'),
(2, 3, 'Bookmark candidate', '2023-04-24 01:53:22', '2023-04-24 01:53:22'),
(3, 3, 'Best candidate', '2023-04-26 02:17:39', '2023-04-26 02:17:39'),
(5, 3, 'latest candidate', '2023-04-26 04:55:26', '2023-04-26 07:14:30'),
(6, 2, 'Shortlisted', '2023-06-01 01:08:00', '2023-06-01 01:08:00'),
(8, 28, 'Candidate', '2023-06-27 00:15:50', '2023-06-27 00:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `company_messages`
--

CREATE TABLE `company_messages` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `seeker_id` int(11) DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `status` enum('viewed','unviewed') NOT NULL DEFAULT 'unviewed',
  `type` enum('message','reply') DEFAULT 'message',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_messages`
--

INSERT INTO `company_messages` (`id`, `company_id`, `seeker_id`, `message`, `status`, `type`, `created_at`, `updated_at`) VALUES
(19, 1, 43, 'new mgs', 'unviewed', 'message', '2023-05-04 05:46:07', '2023-05-04 05:46:07'),
(20, 64, 75, 'Required for Laravel Developer apply now', 'unviewed', 'reply', '2023-06-23 00:46:36', '2023-06-23 00:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_infos`
--

CREATE TABLE `contact_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_infos`
--

INSERT INTO `contact_infos` (`id`, `user_id`, `phone`, `secondary_phone`, `email`, `secondary_email`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, '7373737373', '', 'abs12@gmail.com', '', '', '2023-03-07 05:33:57', '2023-03-13 02:18:50'),
(2, 2, '7474747474', '', 'ericson@gmail.com', '', '', '2023-03-07 05:41:21', '2023-06-01 01:00:15'),
(3, 3, '9222479222', '', 'oracle@gmail.com', '', '', '2023-03-07 05:50:27', '2023-04-18 02:45:51'),
(4, 4, '', '', '', '', '', '2023-03-07 06:10:30', '2023-03-07 06:10:30'),
(6, 6, '9222389222', NULL, 'support@abservetech.com', NULL, '', '2023-03-07 06:48:07', '2023-03-07 06:59:21'),
(7, 7, '2587419630', '', 'zoho@mail.com', '', '', '2023-03-07 07:42:34', '2023-04-18 00:28:12'),
(8, 8, '', '', '', '', '', '2023-03-08 00:56:16', '2023-03-08 00:56:16'),
(9, 9, '', '', '', '', '', '2023-03-08 01:06:10', '2023-03-08 01:06:10'),
(10, 10, '', '', '', '', '', '2023-03-08 01:08:26', '2023-03-08 01:08:26'),
(11, 11, '', '', '', '', '', '2023-03-10 05:02:15', '2023-03-10 05:02:15'),
(12, 12, '', '', '', '', '', '2023-03-11 03:27:41', '2023-03-11 03:27:41'),
(15, 15, '99426 16658', NULL, 'vigneshwari.j@abserve.tech', NULL, '', '2023-03-18 00:32:26', '2023-03-18 00:51:26'),
(16, 16, '', '', '', '', '', '2023-03-30 01:13:00', '2023-03-30 01:13:00'),
(20, 21, '', '', '', '', '', '2023-04-05 01:43:08', '2023-04-05 01:43:08'),
(21, 22, '', '', '', '', '', '2023-04-05 02:22:56', '2023-04-05 02:22:56'),
(22, 26, '8098822579', '', 'infotech@gmail.com', '', '', '2023-04-11 01:26:51', '2023-04-18 02:26:52'),
(24, 39, '', '', '', '', '', '2023-04-15 00:56:49', '2023-04-15 00:56:49'),
(25, 40, '9497##7#7##78', '949495995989', 'babs', 'babdb', '', '2023-04-18 02:52:57', '2023-04-18 02:52:57'),
(26, 40, '9497##7#7##78', '8996', 'babs', 'had', '', '2023-04-18 23:51:10', '2023-04-18 23:51:10'),
(27, 42, '9876453120', '9875642210', 'avi@gmail.com', 'niva@gmail@com', '', '2023-05-01 23:35:15', '2023-05-01 23:35:15'),
(28, 43, NULL, NULL, NULL, NULL, '', '2023-05-02 07:54:08', '2023-05-02 07:54:08'),
(29, 4, '987654321', '9988776655', 'abstesting12@gmail.com', 'abservetechtesting23@gmail.com', '', '2023-05-08 00:41:42', '2023-05-08 00:41:42'),
(30, 47, '9842567828', '98765432100', 'jasonuk@gmail.com', 'jasonuk2@gmail.com', '', '2023-05-18 12:15:34', '2023-05-18 12:15:34'),
(33, 52, '1234567890', '', 'abservetech111.com@gmail.com', '', '', '2023-05-31 05:16:45', '2023-05-31 06:59:47'),
(34, 53, '', '', '', '', '', '2023-05-31 06:29:14', '2023-05-31 06:29:14'),
(35, 54, '', '', '', '', '', '2023-06-01 01:58:30', '2023-06-01 01:58:30'),
(38, 57, '', '', '', '', '', '2023-06-01 02:29:43', '2023-06-01 02:29:43'),
(39, 58, '9999999999', '', 'vigneshwari.j@abserve.tech', '', '', '2023-06-01 02:30:50', '2023-06-01 02:57:20'),
(40, 59, '', '', '', '', '', '2023-06-07 06:14:28', '2023-06-07 06:14:28'),
(41, 60, '9677570694', '6380094963', 'absmuthukumarasaravanan@gmail.com', NULL, '', '2023-06-12 05:32:18', '2023-06-17 02:02:10'),
(42, 62, '9677570692', '', 'Kumaresh123@gmail.com', '', '', '2023-06-13 23:59:35', '2023-06-13 23:59:35'),
(43, 63, '9677570694', '', 'vishnu123@gmail.com', '', '', '2023-06-14 00:33:30', '2023-06-14 00:33:31'),
(44, 66, '9677570698', NULL, 'absmuthukumarasaravanan123@gmail.com', NULL, '', '2023-06-21 05:07:18', '2023-06-21 05:34:05'),
(45, 64, '7200930694', NULL, 'muthukumarsaravanan.m@abserve.tech', NULL, 'Madurai, Tamil Nadu, India', '2023-06-17 04:38:22', '2023-06-22 01:02:18'),
(47, 65, '9677570622', NULL, 'absmuthukumarasaravanan@gmail.com', NULL, NULL, '2023-06-22 05:54:54', '2023-06-22 05:54:54'),
(48, 86, '9677570625', '', 'Vijay.m@abserve.tech', '', NULL, '2023-06-22 23:55:40', '2023-06-22 23:55:41'),
(49, 88, '6380094922', NULL, 'Josephvijay.s@abserve.tech', NULL, 'Madurai, Tamil Nadu, India', '2023-06-23 00:27:50', '2023-06-26 23:39:39'),
(50, 65, '9677570622', NULL, 'absmuthukumarasaravanan@gmail.com', NULL, NULL, '2023-06-23 00:55:18', '2023-06-23 00:55:18'),
(51, 89, '', '', '', '', NULL, '2023-06-26 00:09:33', '2023-06-26 00:09:33'),
(52, 90, '', '', '', '', NULL, '2023-06-26 23:27:47', '2023-06-26 23:27:47'),
(53, 91, '9677570612', '', 'basheer@abserve.tech', '', 'Madurai, Tamil Nadu, India', '2023-06-27 00:31:38', '2023-06-27 00:32:29'),
(56, 94, '9638009426', '', 'dharamadurai.p@abserve.tech', '', 'Madurai, Tamil Nadu, India', '2023-06-27 00:45:49', '2023-06-27 01:29:18'),
(57, 95, '', '', '', '', NULL, '2023-06-27 23:47:30', '2023-06-27 23:47:30'),
(58, 96, '9677570626', '', 'sdsd@gmail.com', '', 'Madurai, Tamil Nadu, India', '2023-06-28 01:13:38', '2023-06-28 01:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `cookies`
--

CREATE TABLE `cookies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allow_cookies` tinyint(1) NOT NULL DEFAULT '1',
  `cookie_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'gdpr_cookie',
  `cookie_expiration` tinyint(4) NOT NULL DEFAULT '30',
  `force_consent` tinyint(1) NOT NULL DEFAULT '0',
  `darkmode` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve_button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `decline_button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cookies`
--

INSERT INTO `cookies` (`id`, `allow_cookies`, `cookie_name`, `cookie_expiration`, `force_consent`, `darkmode`, `language`, `title`, `description`, `approve_button_text`, `decline_button_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'gdpr_cookie', 30, 0, 0, 'en', 'We use cookies!', 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <button type=\"button\" data-cc=\"c-settings\" class=\"cc-link\">Let me choose</button>', 'Allow all Cookies', 'Reject all Cookies', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sortname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `image`, `slug`, `icon`, `sortname`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Aruba', 'backend/image/flags/flag-of-Aruba.jpg', 'aruba', 'flag-icon-aw', 'AW', 12.5, -69.96666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'Afghanistan', 'backend/image/flags/flag-of-Afghanistan.jpg', 'afghanistan', 'flag-icon-af', 'AF', 33, 65, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, 'Angola', 'backend/image/flags/flag-of-Angola.jpg', 'angola', 'flag-icon-ao', 'AO', -12.5, 18.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'Anguilla', 'backend/image/flags/flag-of-Anguilla.jpg', 'anguilla', 'flag-icon-ai', 'AI', 18.25, -63.16666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, 'Åland Islands', 'backend/image/flags/flag-of-Åland-Islands.jpg', 'aland-islands', 'flag-icon-ax', 'AX', 60.116667, 19.9, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(6, 'Albania', 'backend/image/flags/flag-of-Albania.jpg', 'albania', 'flag-icon-al', 'AL', 41, 20, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, 'Andorra', 'backend/image/flags/flag-of-Andorra.jpg', 'andorra', 'flag-icon-ad', 'AD', 42.5, 1.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(8, 'United Arab Emirates', 'backend/image/flags/flag-of-United-Arab-Emirates.jpg', 'united-arab-emirates', 'flag-icon-ae', 'AE', 24, 54, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(9, 'Argentina', 'backend/image/flags/flag-of-Argentina.jpg', 'argentina', 'flag-icon-ar', 'AR', -34, -64, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(10, 'Armenia', 'backend/image/flags/flag-of-Armenia.jpg', 'armenia', 'flag-icon-am', 'AM', 40, 45, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(11, 'American Samoa', 'backend/image/flags/flag-of-American-Samoa.jpg', 'american-samoa', 'flag-icon-as', 'AS', -14.33333333, -170, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(12, 'Antarctica', 'backend/image/flags/flag-of-Antarctica.jpg', 'antarctica', 'flag-icon-aq', 'AQ', -90, 0, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(13, 'French Southern and Antarctic Lands', 'backend/image/flags/flag-of-French-Southern-and-Antarctic-Lands.jpg', 'french-southern-and-antarctic-lands', 'flag-icon-tf', 'TF', -49.25, 69.167, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(14, 'Antigua and Barbuda', 'backend/image/flags/flag-of-Antigua-and-Barbuda.jpg', 'antigua-and-barbuda', 'flag-icon-ag', 'AG', 17.05, -61.8, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(15, 'Australia', 'backend/image/flags/flag-of-Australia.jpg', 'australia', 'flag-icon-au', 'AU', -27, 133, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(16, 'Austria', 'backend/image/flags/flag-of-Austria.jpg', 'austria', 'flag-icon-at', 'AT', 47.33333333, 13.33333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(17, 'Azerbaijan', 'backend/image/flags/flag-of-Azerbaijan.jpg', 'azerbaijan', 'flag-icon-az', 'AZ', 40.5, 47.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(18, 'Burundi', 'backend/image/flags/flag-of-Burundi.jpg', 'burundi', 'flag-icon-bi', 'BI', -3.5, 30, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(19, 'Belgium', 'backend/image/flags/flag-of-Belgium.jpg', 'belgium', 'flag-icon-be', 'BE', 50.83333333, 4, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(20, 'Benin', 'backend/image/flags/flag-of-Benin.jpg', 'benin', 'flag-icon-bj', 'BJ', 9.5, 2.25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(21, 'Burkina Faso', 'backend/image/flags/flag-of-Burkina-Faso.jpg', 'burkina-faso', 'flag-icon-bf', 'BF', 13, -2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(22, 'Bangladesh', 'backend/image/flags/flag-of-Bangladesh.jpg', 'bangladesh', 'flag-icon-bd', 'BD', 24, 90, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(23, 'Bulgaria', 'backend/image/flags/flag-of-Bulgaria.jpg', 'bulgaria', 'flag-icon-bg', 'BG', 43, 25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(24, 'Bahrain', 'backend/image/flags/flag-of-Bahrain.jpg', 'bahrain', 'flag-icon-bh', 'BH', 26, 50.55, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(25, 'Bahamas', 'backend/image/flags/flag-of-Bahamas.jpg', 'bahamas', 'flag-icon-bs', 'BS', 24.25, -76, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(26, 'Bosnia and Herzegovina', 'backend/image/flags/flag-of-Bosnia-and-Herzegovina.jpg', 'bosnia-and-herzegovina', 'flag-icon-ba', 'BA', 44, 18, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(27, 'Saint Barthélemy', 'backend/image/flags/flag-of-Saint-Barthélemy.jpg', 'saint-barthelemy', 'flag-icon-bl', 'BL', 18.5, -63.41666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(28, 'Belarus', 'backend/image/flags/flag-of-Belarus.jpg', 'belarus', 'flag-icon-by', 'BY', 53, 28, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(29, 'Belize', 'backend/image/flags/flag-of-Belize.jpg', 'belize', 'flag-icon-bz', 'BZ', 17.25, -88.75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(30, 'Bermuda', 'backend/image/flags/flag-of-Bermuda.jpg', 'bermuda', 'flag-icon-bm', 'BM', 32.33333333, -64.75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(31, 'Bolivia', 'backend/image/flags/flag-of-Bolivia.jpg', 'bolivia', 'flag-icon-bo', 'BO', -17, -65, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(32, 'Brazil', 'backend/image/flags/flag-of-Brazil.jpg', 'brazil', 'flag-icon-br', 'BR', -10, -55, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(33, 'Barbados', 'backend/image/flags/flag-of-Barbados.jpg', 'barbados', 'flag-icon-bb', 'BB', 13.16666666, -59.53333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(34, 'Brunei', 'backend/image/flags/flag-of-Brunei.jpg', 'brunei', 'flag-icon-bn', 'BN', 4.5, 114.66666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(35, 'Bhutan', 'backend/image/flags/flag-of-Bhutan.jpg', 'bhutan', 'flag-icon-bt', 'BT', 27.5, 90.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(36, 'Bouvet Island', 'backend/image/flags/flag-of-Bouvet-Island.jpg', 'bouvet-island', 'flag-icon-bv', 'BV', -54.43333333, 3.4, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(37, 'Botswana', 'backend/image/flags/flag-of-Botswana.jpg', 'botswana', 'flag-icon-bw', 'BW', -22, 24, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(38, 'Central African Republic', 'backend/image/flags/flag-of-Central-African-Republic.jpg', 'central-african-republic', 'flag-icon-cf', 'CF', 7, 21, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(39, 'Canada', 'backend/image/flags/flag-of-Canada.jpg', 'canada', 'flag-icon-ca', 'CA', 60, -95, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(40, 'Cocos (Keeling) Islands', 'backend/image/flags/flag-of-Cocos-(Keeling)-Islands.jpg', 'cocos-keeling-islands', 'flag-icon-cc', 'CC', -12.5, 96.83333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(41, 'Switzerland', 'backend/image/flags/flag-of-Switzerland.jpg', 'switzerland', 'flag-icon-ch', 'CH', 47, 8, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(42, 'Chile', 'backend/image/flags/flag-of-Chile.jpg', 'chile', 'flag-icon-cl', 'CL', -30, -71, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(43, 'China', 'backend/image/flags/flag-of-China.jpg', 'china', 'flag-icon-cn', 'CN', 35, 105, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(44, 'Ivory Coast', 'backend/image/flags/flag-of-Ivory-Coast.jpg', 'ivory-coast', 'flag-icon-ci', 'CI', 8, -5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(45, 'Cameroon', 'backend/image/flags/flag-of-Cameroon.jpg', 'cameroon', 'flag-icon-cm', 'CM', 6, 12, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(46, 'DR Congo', 'backend/image/flags/flag-of-DR-Congo.jpg', 'dr-congo', 'flag-icon-cd', 'CD', 0, 25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(47, 'Republic of the Congo', 'backend/image/flags/flag-of-Republic-of-the-Congo.jpg', 'republic-of-the-congo', 'flag-icon-cg', 'CG', -1, 15, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(48, 'Cook Islands', 'backend/image/flags/flag-of-Cook-Islands.jpg', 'cook-islands', 'flag-icon-ck', 'CK', -21.23333333, -159.76666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(49, 'Colombia', 'backend/image/flags/flag-of-Colombia.jpg', 'colombia', 'flag-icon-co', 'CO', 4, -72, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(50, 'Comoros', 'backend/image/flags/flag-of-Comoros.jpg', 'comoros', 'flag-icon-km', 'KM', -12.16666666, 44.25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(51, 'Cape Verde', 'backend/image/flags/flag-of-Cape-Verde.jpg', 'cape-verde', 'flag-icon-cv', 'CV', 16, -24, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(52, 'Costa Rica', 'backend/image/flags/flag-of-Costa-Rica.jpg', 'costa-rica', 'flag-icon-cr', 'CR', 10, -84, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(53, 'Cuba', 'backend/image/flags/flag-of-Cuba.jpg', 'cuba', 'flag-icon-cu', 'CU', 21.5, -80, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(54, 'Curaçao', 'backend/image/flags/flag-of-Curaçao.jpg', 'curacao', 'flag-icon-cw', 'CW', 12.116667, -68.933333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(55, 'Christmas Island', 'backend/image/flags/flag-of-Christmas-Island.jpg', 'christmas-island', 'flag-icon-cx', 'CX', -10.5, 105.66666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(56, 'Cayman Islands', 'backend/image/flags/flag-of-Cayman-Islands.jpg', 'cayman-islands', 'flag-icon-ky', 'KY', 19.5, -80.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(57, 'Cyprus', 'backend/image/flags/flag-of-Cyprus.jpg', 'cyprus', 'flag-icon-cy', 'CY', 35, 33, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(58, 'Czech Republic', 'backend/image/flags/flag-of-Czech-Republic.jpg', 'czech-republic', 'flag-icon-cz', 'CZ', 49.75, 15.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(59, 'Germany', 'backend/image/flags/flag-of-Germany.jpg', 'germany', 'flag-icon-de', 'DE', 51, 9, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(60, 'Djibouti', 'backend/image/flags/flag-of-Djibouti.jpg', 'djibouti', 'flag-icon-dj', 'DJ', 11.5, 43, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(61, 'Dominica', 'backend/image/flags/flag-of-Dominica.jpg', 'dominica', 'flag-icon-dm', 'DM', 15.41666666, -61.33333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(62, 'Denmark', 'backend/image/flags/flag-of-Denmark.jpg', 'denmark', 'flag-icon-dk', 'DK', 56, 10, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(63, 'Dominican Republic', 'backend/image/flags/flag-of-Dominican-Republic.jpg', 'dominican-republic', 'flag-icon-do', 'DO', 19, -70.66666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(64, 'Algeria', 'backend/image/flags/flag-of-Algeria.jpg', 'algeria', 'flag-icon-dz', 'DZ', 28, 3, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(65, 'Ecuador', 'backend/image/flags/flag-of-Ecuador.jpg', 'ecuador', 'flag-icon-ec', 'EC', -2, -77.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(66, 'Egypt', 'backend/image/flags/flag-of-Egypt.jpg', 'egypt', 'flag-icon-eg', 'EG', 27, 30, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(67, 'Eritrea', 'backend/image/flags/flag-of-Eritrea.jpg', 'eritrea', 'flag-icon-er', 'ER', 15, 39, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(68, 'Western Sahara', 'backend/image/flags/flag-of-Western-Sahara.jpg', 'western-sahara', 'flag-icon-eh', 'EH', 24.5, -13, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(69, 'Spain', 'backend/image/flags/flag-of-Spain.jpg', 'spain', 'flag-icon-es', 'ES', 40, -4, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(70, 'Estonia', 'backend/image/flags/flag-of-Estonia.jpg', 'estonia', 'flag-icon-ee', 'EE', 59, 26, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(71, 'Ethiopia', 'backend/image/flags/flag-of-Ethiopia.jpg', 'ethiopia', 'flag-icon-et', 'ET', 8, 38, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(72, 'Finland', 'backend/image/flags/flag-of-Finland.jpg', 'finland', 'flag-icon-fi', 'FI', 64, 26, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(73, 'Fiji', 'backend/image/flags/flag-of-Fiji.jpg', 'fiji', 'flag-icon-fj', 'FJ', -18, 175, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(74, 'Falkland Islands', 'backend/image/flags/flag-of-Falkland-Islands.jpg', 'falkland-islands', 'flag-icon-fk', 'FK', -51.75, -59, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(75, 'France', 'backend/image/flags/flag-of-France.jpg', 'france', 'flag-icon-fr', 'FR', 46, 2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(76, 'Faroe Islands', 'backend/image/flags/flag-of-Faroe-Islands.jpg', 'faroe-islands', 'flag-icon-fo', 'FO', 62, -7, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(77, 'Micronesia', 'backend/image/flags/flag-of-Micronesia.jpg', 'micronesia', 'flag-icon-fm', 'FM', 6.91666666, 158.25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(78, 'Gabon', 'backend/image/flags/flag-of-Gabon.jpg', 'gabon', 'flag-icon-ga', 'GA', -1, 11.75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(79, 'United Kingdom', 'backend/image/flags/flag-of-United-Kingdom.jpg', 'united-kingdom', 'flag-icon-gb', 'GB', 54, -2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(80, 'Georgia', 'backend/image/flags/flag-of-Georgia.jpg', 'georgia', 'flag-icon-ge', 'GE', 42, 43.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(81, 'Guernsey', 'backend/image/flags/flag-of-Guernsey.jpg', 'guernsey', 'flag-icon-gg', 'GG', 49.46666666, -2.58333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(82, 'Ghana', 'backend/image/flags/flag-of-Ghana.jpg', 'ghana', 'flag-icon-gh', 'GH', 8, -2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(83, 'Gibraltar', 'backend/image/flags/flag-of-Gibraltar.jpg', 'gibraltar', 'flag-icon-gi', 'GI', 36.13333333, -5.35, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(84, 'Guinea', 'backend/image/flags/flag-of-Guinea.jpg', 'guinea', 'flag-icon-gn', 'GN', 11, -10, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(85, 'Guadeloupe', 'backend/image/flags/flag-of-Guadeloupe.jpg', 'guadeloupe', 'flag-icon-gp', 'GP', 16.25, -61.583333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(86, 'Gambia', 'backend/image/flags/flag-of-Gambia.jpg', 'gambia', 'flag-icon-gm', 'GM', 13.46666666, -16.56666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(87, 'Guinea-Bissau', 'backend/image/flags/flag-of-Guinea-Bissau.jpg', 'guinea-bissau', 'flag-icon-gw', 'GW', 12, -15, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(88, 'Equatorial Guinea', 'backend/image/flags/flag-of-Equatorial-Guinea.jpg', 'equatorial-guinea', 'flag-icon-gq', 'GQ', 2, 10, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(89, 'Greece', 'backend/image/flags/flag-of-Greece.jpg', 'greece', 'flag-icon-gr', 'GR', 39, 22, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(90, 'Grenada', 'backend/image/flags/flag-of-Grenada.jpg', 'grenada', 'flag-icon-gd', 'GD', 12.11666666, -61.66666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(91, 'Greenland', 'backend/image/flags/flag-of-Greenland.jpg', 'greenland', 'flag-icon-gl', 'GL', 72, -40, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(92, 'Guatemala', 'backend/image/flags/flag-of-Guatemala.jpg', 'guatemala', 'flag-icon-gt', 'GT', 15.5, -90.25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(93, 'French Guiana', 'backend/image/flags/flag-of-French-Guiana.jpg', 'french-guiana', 'flag-icon-gf', 'GF', 4, -53, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(94, 'Guam', 'backend/image/flags/flag-of-Guam.jpg', 'guam', 'flag-icon-gu', 'GU', 13.46666666, 144.78333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(95, 'Guyana', 'backend/image/flags/flag-of-Guyana.jpg', 'guyana', 'flag-icon-gy', 'GY', 5, -59, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(96, 'Hong Kong', 'backend/image/flags/flag-of-Hong-Kong.jpg', 'hong-kong', 'flag-icon-hk', 'HK', 22.267, 114.188, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(97, 'Honduras', 'backend/image/flags/flag-of-Honduras.jpg', 'honduras', 'flag-icon-hn', 'HN', 15, -86.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(98, 'Croatia', 'backend/image/flags/flag-of-Croatia.jpg', 'croatia', 'flag-icon-hr', 'HR', 45.16666666, 15.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(99, 'Haiti', 'backend/image/flags/flag-of-Haiti.jpg', 'haiti', 'flag-icon-ht', 'HT', 19, -72.41666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(100, 'Hungary', 'backend/image/flags/flag-of-Hungary.jpg', 'hungary', 'flag-icon-hu', 'HU', 47, 20, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(101, 'Indonesia', 'backend/image/flags/flag-of-Indonesia.jpg', 'indonesia', 'flag-icon-id', 'ID', -5, 120, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(102, 'Isle of Man', 'backend/image/flags/flag-of-Isle-of-Man.jpg', 'isle-of-man', 'flag-icon-im', 'IM', 54.25, -4.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(103, 'India', 'backend/image/flags/flag-of-India.jpg', 'india', 'flag-icon-in', 'IN', 20, 77, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(104, 'British Indian Ocean Territory', 'backend/image/flags/flag-of-British-Indian-Ocean-Territory.jpg', 'british-indian-ocean-territory', 'flag-icon-io', 'IO', -6, 71.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(105, 'Ireland', 'backend/image/flags/flag-of-Ireland.jpg', 'ireland', 'flag-icon-ie', 'IE', 53, -8, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(106, 'Iran', 'backend/image/flags/flag-of-Iran.jpg', 'iran', 'flag-icon-ir', 'IR', 32, 53, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(107, 'Iraq', 'backend/image/flags/flag-of-Iraq.jpg', 'iraq', 'flag-icon-iq', 'IQ', 33, 44, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(108, 'Iceland', 'backend/image/flags/flag-of-Iceland.jpg', 'iceland', 'flag-icon-is', 'IS', 65, -18, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(109, 'Israel', 'backend/image/flags/flag-of-Israel.jpg', 'israel', 'flag-icon-il', 'IL', 31.47, 35.13, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(110, 'Italy', 'backend/image/flags/flag-of-Italy.jpg', 'italy', 'flag-icon-it', 'IT', 42.83333333, 12.83333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(111, 'Jamaica', 'backend/image/flags/flag-of-Jamaica.jpg', 'jamaica', 'flag-icon-jm', 'JM', 18.25, -77.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(112, 'Jersey', 'backend/image/flags/flag-of-Jersey.jpg', 'jersey', 'flag-icon-je', 'JE', 49.25, -2.16666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(113, 'Jordan', 'backend/image/flags/flag-of-Jordan.jpg', 'jordan', 'flag-icon-jo', 'JO', 31, 36, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(114, 'Japan', 'backend/image/flags/flag-of-Japan.jpg', 'japan', 'flag-icon-jp', 'JP', 36, 138, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(115, 'Kazakhstan', 'backend/image/flags/flag-of-Kazakhstan.jpg', 'kazakhstan', 'flag-icon-kz', 'KZ', 48, 68, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(116, 'Kenya', 'backend/image/flags/flag-of-Kenya.jpg', 'kenya', 'flag-icon-ke', 'KE', 1, 38, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(117, 'Kyrgyzstan', 'backend/image/flags/flag-of-Kyrgyzstan.jpg', 'kyrgyzstan', 'flag-icon-kg', 'KG', 41, 75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(118, 'Cambodia', 'backend/image/flags/flag-of-Cambodia.jpg', 'cambodia', 'flag-icon-kh', 'KH', 13, 105, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(119, 'Kiribati', 'backend/image/flags/flag-of-Kiribati.jpg', 'kiribati', 'flag-icon-ki', 'KI', 1.41666666, 173, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(120, 'Saint Kitts and Nevis', 'backend/image/flags/flag-of-Saint-Kitts-and-Nevis.jpg', 'saint-kitts-and-nevis', 'flag-icon-kn', 'KN', 17.33333333, -62.75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(121, 'South Korea', 'backend/image/flags/flag-of-South-Korea.jpg', 'south-korea', 'flag-icon-kr', 'KR', 37, 127.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(122, 'Kosovo', 'backend/image/flags/flag-of-Kosovo.jpg', 'kosovo', 'flag-icon-xk', 'XK', 42.666667, 21.166667, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(123, 'Kuwait', 'backend/image/flags/flag-of-Kuwait.jpg', 'kuwait', 'flag-icon-kw', 'KW', 29.5, 45.75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(124, 'Laos', 'backend/image/flags/flag-of-Laos.jpg', 'laos', 'flag-icon-la', 'LA', 18, 105, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(125, 'Lebanon', 'backend/image/flags/flag-of-Lebanon.jpg', 'lebanon', 'flag-icon-lb', 'LB', 33.83333333, 35.83333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(126, 'Liberia', 'backend/image/flags/flag-of-Liberia.jpg', 'liberia', 'flag-icon-lr', 'LR', 6.5, -9.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(127, 'Libya', 'backend/image/flags/flag-of-Libya.jpg', 'libya', 'flag-icon-ly', 'LY', 25, 17, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(128, 'Saint Lucia', 'backend/image/flags/flag-of-Saint-Lucia.jpg', 'saint-lucia', 'flag-icon-lc', 'LC', 13.88333333, -60.96666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(129, 'Liechtenstein', 'backend/image/flags/flag-of-Liechtenstein.jpg', 'liechtenstein', 'flag-icon-li', 'LI', 47.26666666, 9.53333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(130, 'Sri Lanka', 'backend/image/flags/flag-of-Sri-Lanka.jpg', 'sri-lanka', 'flag-icon-lk', 'LK', 7, 81, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(131, 'Lesotho', 'backend/image/flags/flag-of-Lesotho.jpg', 'lesotho', 'flag-icon-ls', 'LS', -29.5, 28.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(132, 'Lithuania', 'backend/image/flags/flag-of-Lithuania.jpg', 'lithuania', 'flag-icon-lt', 'LT', 56, 24, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(133, 'Luxembourg', 'backend/image/flags/flag-of-Luxembourg.jpg', 'luxembourg', 'flag-icon-lu', 'LU', 49.75, 6.16666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(134, 'Latvia', 'backend/image/flags/flag-of-Latvia.jpg', 'latvia', 'flag-icon-lv', 'LV', 57, 25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(135, 'Macau', 'backend/image/flags/flag-of-Macau.jpg', 'macau', 'flag-icon-mo', 'MO', 22.16666666, 113.55, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(136, 'Saint Martin', 'backend/image/flags/flag-of-Saint-Martin.jpg', 'saint-martin', 'flag-icon-mf', 'MF', 18.08333333, -63.95, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(137, 'Morocco', 'backend/image/flags/flag-of-Morocco.jpg', 'morocco', 'flag-icon-ma', 'MA', 32, -5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(138, 'Monaco', 'backend/image/flags/flag-of-Monaco.jpg', 'monaco', 'flag-icon-mc', 'MC', 43.73333333, 7.4, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(139, 'Moldova', 'backend/image/flags/flag-of-Moldova.jpg', 'moldova', 'flag-icon-md', 'MD', 47, 29, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(140, 'Madagascar', 'backend/image/flags/flag-of-Madagascar.jpg', 'madagascar', 'flag-icon-mg', 'MG', -20, 47, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(141, 'Maldives', 'backend/image/flags/flag-of-Maldives.jpg', 'maldives', 'flag-icon-mv', 'MV', 3.25, 73, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(142, 'Mexico', 'backend/image/flags/flag-of-Mexico.jpg', 'mexico', 'flag-icon-mx', 'MX', 23, -102, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(143, 'Marshall Islands', 'backend/image/flags/flag-of-Marshall-Islands.jpg', 'marshall-islands', 'flag-icon-mh', 'MH', 9, 168, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(144, 'Macedonia', 'backend/image/flags/flag-of-Macedonia.jpg', 'macedonia', 'flag-icon-mk', 'MK', 41.83333333, 22, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(145, 'Mali', 'backend/image/flags/flag-of-Mali.jpg', 'mali', 'flag-icon-ml', 'ML', 17, -4, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(146, 'Malta', 'backend/image/flags/flag-of-Malta.jpg', 'malta', 'flag-icon-mt', 'MT', 35.83333333, 14.58333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(147, 'Myanmar', 'backend/image/flags/flag-of-Myanmar.jpg', 'myanmar', 'flag-icon-mm', 'MM', 22, 98, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(148, 'Montenegro', 'backend/image/flags/flag-of-Montenegro.jpg', 'montenegro', 'flag-icon-me', 'ME', 42.5, 19.3, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(149, 'Mongolia', 'backend/image/flags/flag-of-Mongolia.jpg', 'mongolia', 'flag-icon-mn', 'MN', 46, 105, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(150, 'Northern Mariana Islands', 'backend/image/flags/flag-of-Northern-Mariana-Islands.jpg', 'northern-mariana-islands', 'flag-icon-mp', 'MP', 15.2, 145.75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(151, 'Mozambique', 'backend/image/flags/flag-of-Mozambique.jpg', 'mozambique', 'flag-icon-mz', 'MZ', -18.25, 35, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(152, 'Mauritania', 'backend/image/flags/flag-of-Mauritania.jpg', 'mauritania', 'flag-icon-mr', 'MR', 20, -12, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(153, 'Montserrat', 'backend/image/flags/flag-of-Montserrat.jpg', 'montserrat', 'flag-icon-ms', 'MS', 16.75, -62.2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(154, 'Martinique', 'backend/image/flags/flag-of-Martinique.jpg', 'martinique', 'flag-icon-mq', 'MQ', 14.666667, -61, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(155, 'Mauritius', 'backend/image/flags/flag-of-Mauritius.jpg', 'mauritius', 'flag-icon-mu', 'MU', -20.28333333, 57.55, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(156, 'Malawi', 'backend/image/flags/flag-of-Malawi.jpg', 'malawi', 'flag-icon-mw', 'MW', -13.5, 34, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(157, 'Malaysia', 'backend/image/flags/flag-of-Malaysia.jpg', 'malaysia', 'flag-icon-my', 'MY', 2.5, 112.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(158, 'Mayotte', 'backend/image/flags/flag-of-Mayotte.jpg', 'mayotte', 'flag-icon-yt', 'YT', -12.83333333, 45.16666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(159, 'Namibia', 'backend/image/flags/flag-of-Namibia.jpg', 'namibia', 'flag-icon-na', 'NA', -22, 17, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(160, 'New Caledonia', 'backend/image/flags/flag-of-New-Caledonia.jpg', 'new-caledonia', 'flag-icon-nc', 'NC', -21.5, 165.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(161, 'Niger', 'backend/image/flags/flag-of-Niger.jpg', 'niger', 'flag-icon-ne', 'NE', 16, 8, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(162, 'Norfolk Island', 'backend/image/flags/flag-of-Norfolk-Island.jpg', 'norfolk-island', 'flag-icon-nf', 'NF', -29.03333333, 167.95, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(163, 'Nigeria', 'backend/image/flags/flag-of-Nigeria.jpg', 'nigeria', 'flag-icon-ng', 'NG', 10, 8, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(164, 'Nicaragua', 'backend/image/flags/flag-of-Nicaragua.jpg', 'nicaragua', 'flag-icon-ni', 'NI', 13, -85, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(165, 'Niue', 'backend/image/flags/flag-of-Niue.jpg', 'niue', 'flag-icon-nu', 'NU', -19.03333333, -169.86666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(166, 'Netherlands', 'backend/image/flags/flag-of-Netherlands.jpg', 'netherlands', 'flag-icon-nl', 'NL', 52.5, 5.75, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(167, 'Norway', 'backend/image/flags/flag-of-Norway.jpg', 'norway', 'flag-icon-no', 'NO', 62, 10, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(168, 'Nepal', 'backend/image/flags/flag-of-Nepal.jpg', 'nepal', 'flag-icon-np', 'NP', 28, 84, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(169, 'Nauru', 'backend/image/flags/flag-of-Nauru.jpg', 'nauru', 'flag-icon-nr', 'NR', -0.53333333, 166.91666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(170, 'New Zealand', 'backend/image/flags/flag-of-New-Zealand.jpg', 'new-zealand', 'flag-icon-nz', 'NZ', -41, 174, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(171, 'Oman', 'backend/image/flags/flag-of-Oman.jpg', 'oman', 'flag-icon-om', 'OM', 21, 57, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(172, 'Pakistan', 'backend/image/flags/flag-of-Pakistan.jpg', 'pakistan', 'flag-icon-pk', 'PK', 30, 70, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(173, 'Panama', 'backend/image/flags/flag-of-Panama.jpg', 'panama', 'flag-icon-pa', 'PA', 9, -80, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(174, 'Pitcairn Islands', 'backend/image/flags/flag-of-Pitcairn-Islands.jpg', 'pitcairn-islands', 'flag-icon-pn', 'PN', -25.06666666, -130.1, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(175, 'Peru', 'backend/image/flags/flag-of-Peru.jpg', 'peru', 'flag-icon-pe', 'PE', -10, -76, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(176, 'Philippines', 'backend/image/flags/flag-of-Philippines.jpg', 'philippines', 'flag-icon-ph', 'PH', 13, 122, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(177, 'Palau', 'backend/image/flags/flag-of-Palau.jpg', 'palau', 'flag-icon-pw', 'PW', 7.5, 134.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(178, 'Papua New Guinea', 'backend/image/flags/flag-of-Papua-New-Guinea.jpg', 'papua-new-guinea', 'flag-icon-pg', 'PG', -6, 147, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(179, 'Poland', 'backend/image/flags/flag-of-Poland.jpg', 'poland', 'flag-icon-pl', 'PL', 52, 20, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(180, 'Puerto Rico', 'backend/image/flags/flag-of-Puerto-Rico.jpg', 'puerto-rico', 'flag-icon-pr', 'PR', 18.25, -66.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(181, 'North Korea', 'backend/image/flags/flag-of-North-Korea.jpg', 'north-korea', 'flag-icon-kp', 'KP', 40, 127, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(182, 'Portugal', 'backend/image/flags/flag-of-Portugal.jpg', 'portugal', 'flag-icon-pt', 'PT', 39.5, -8, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(183, 'Paraguay', 'backend/image/flags/flag-of-Paraguay.jpg', 'paraguay', 'flag-icon-py', 'PY', -23, -58, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(184, 'Palestine', 'backend/image/flags/flag-of-Palestine.jpg', 'palestine', 'flag-icon-ps', 'PS', 31.9, 35.2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(185, 'French Polynesia', 'backend/image/flags/flag-of-French-Polynesia.jpg', 'french-polynesia', 'flag-icon-pf', 'PF', -15, -140, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(186, 'Qatar', 'backend/image/flags/flag-of-Qatar.jpg', 'qatar', 'flag-icon-qa', 'QA', 25.5, 51.25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(187, 'Réunion', 'backend/image/flags/flag-of-Réunion.jpg', 'reunion', 'flag-icon-re', 'RE', -21.15, 55.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(188, 'Romania', 'backend/image/flags/flag-of-Romania.jpg', 'romania', 'flag-icon-ro', 'RO', 46, 25, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(189, 'Russia', 'backend/image/flags/flag-of-Russia.jpg', 'russia', 'flag-icon-ru', 'RU', 60, 100, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(190, 'Rwanda', 'backend/image/flags/flag-of-Rwanda.jpg', 'rwanda', 'flag-icon-rw', 'RW', -2, 30, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(191, 'Saudi Arabia', 'backend/image/flags/flag-of-Saudi-Arabia.jpg', 'saudi-arabia', 'flag-icon-sa', 'SA', 25, 45, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(192, 'Sudan', 'backend/image/flags/flag-of-Sudan.jpg', 'sudan', 'flag-icon-sd', 'SD', 15, 30, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(193, 'Senegal', 'backend/image/flags/flag-of-Senegal.jpg', 'senegal', 'flag-icon-sn', 'SN', 14, -14, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(194, 'Singapore', 'backend/image/flags/flag-of-Singapore.jpg', 'singapore', 'flag-icon-sg', 'SG', 1.36666666, 103.8, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(195, 'South Georgia', 'backend/image/flags/flag-of-South-Georgia.jpg', 'south-georgia', 'flag-icon-gs', 'GS', -54.5, -37, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(196, 'Svalbard and Jan Mayen', 'backend/image/flags/flag-of-Svalbard-and-Jan-Mayen.jpg', 'svalbard-and-jan-mayen', 'flag-icon-sj', 'SJ', 78, 20, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(197, 'Solomon Islands', 'backend/image/flags/flag-of-Solomon-Islands.jpg', 'solomon-islands', 'flag-icon-sb', 'SB', -8, 159, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(198, 'Sierra Leone', 'backend/image/flags/flag-of-Sierra-Leone.jpg', 'sierra-leone', 'flag-icon-sl', 'SL', 8.5, -11.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(199, 'El Salvador', 'backend/image/flags/flag-of-El-Salvador.jpg', 'el-salvador', 'flag-icon-sv', 'SV', 13.83333333, -88.91666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(200, 'San Marino', 'backend/image/flags/flag-of-San-Marino.jpg', 'san-marino', 'flag-icon-sm', 'SM', 43.76666666, 12.41666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(201, 'Somalia', 'backend/image/flags/flag-of-Somalia.jpg', 'somalia', 'flag-icon-so', 'SO', 10, 49, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(202, 'Saint Pierre and Miquelon', 'backend/image/flags/flag-of-Saint-Pierre-and-Miquelon.jpg', 'saint-pierre-and-miquelon', 'flag-icon-pm', 'PM', 46.83333333, -56.33333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(203, 'Serbia', 'backend/image/flags/flag-of-Serbia.jpg', 'serbia', 'flag-icon-rs', 'RS', 44, 21, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(204, 'South Sudan', 'backend/image/flags/flag-of-South-Sudan.jpg', 'south-sudan', 'flag-icon-ss', 'SS', 7, 30, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(205, 'São Tomé and Príncipe', 'backend/image/flags/flag-of-São-Tomé-and-Príncipe.jpg', 'sao-tome-and-principe', 'flag-icon-st', 'ST', 1, 7, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(206, 'Suriname', 'backend/image/flags/flag-of-Suriname.jpg', 'suriname', 'flag-icon-sr', 'SR', 4, -56, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(207, 'Slovakia', 'backend/image/flags/flag-of-Slovakia.jpg', 'slovakia', 'flag-icon-sk', 'SK', 48.66666666, 19.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(208, 'Slovenia', 'backend/image/flags/flag-of-Slovenia.jpg', 'slovenia', 'flag-icon-si', 'SI', 46.11666666, 14.81666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(209, 'Sweden', 'backend/image/flags/flag-of-Sweden.jpg', 'sweden', 'flag-icon-se', 'SE', 62, 15, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(210, 'Swaziland', 'backend/image/flags/flag-of-Swaziland.jpg', 'swaziland', 'flag-icon-sz', 'SZ', -26.5, 31.5, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(211, 'Sint Maarten', 'backend/image/flags/flag-of-Sint-Maarten.jpg', 'sint-maarten', 'flag-icon-sx', 'SX', 18.033333, -63.05, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(212, 'Seychelles', 'backend/image/flags/flag-of-Seychelles.jpg', 'seychelles', 'flag-icon-sc', 'SC', -4.58333333, 55.66666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(213, 'Syria', 'backend/image/flags/flag-of-Syria.jpg', 'syria', 'flag-icon-sy', 'SY', 35, 38, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(214, 'Turks and Caicos Islands', 'backend/image/flags/flag-of-Turks-and-Caicos-Islands.jpg', 'turks-and-caicos-islands', 'flag-icon-tc', 'TC', 21.75, -71.58333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(215, 'Chad', 'backend/image/flags/flag-of-Chad.jpg', 'chad', 'flag-icon-td', 'TD', 15, 19, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(216, 'Togo', 'backend/image/flags/flag-of-Togo.jpg', 'togo', 'flag-icon-tg', 'TG', 8, 1.16666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(217, 'Thailand', 'backend/image/flags/flag-of-Thailand.jpg', 'thailand', 'flag-icon-th', 'TH', 15, 100, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(218, 'Tajikistan', 'backend/image/flags/flag-of-Tajikistan.jpg', 'tajikistan', 'flag-icon-tj', 'TJ', 39, 71, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(219, 'Tokelau', 'backend/image/flags/flag-of-Tokelau.jpg', 'tokelau', 'flag-icon-tk', 'TK', -9, -172, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(220, 'Turkmenistan', 'backend/image/flags/flag-of-Turkmenistan.jpg', 'turkmenistan', 'flag-icon-tm', 'TM', 40, 60, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(221, 'Timor-Leste', 'backend/image/flags/flag-of-Timor-Leste.jpg', 'timor-leste', 'flag-icon-tl', 'TL', -8.83333333, 125.91666666, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(222, 'Tonga', 'backend/image/flags/flag-of-Tonga.jpg', 'tonga', 'flag-icon-to', 'TO', -20, -175, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(223, 'Trinidad and Tobago', 'backend/image/flags/flag-of-Trinidad-and-Tobago.jpg', 'trinidad-and-tobago', 'flag-icon-tt', 'TT', 11, -61, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(224, 'Tunisia', 'backend/image/flags/flag-of-Tunisia.jpg', 'tunisia', 'flag-icon-tn', 'TN', 34, 9, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(225, 'Turkey', 'backend/image/flags/flag-of-Turkey.jpg', 'turkey', 'flag-icon-tr', 'TR', 39, 35, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(226, 'Tuvalu', 'backend/image/flags/flag-of-Tuvalu.jpg', 'tuvalu', 'flag-icon-tv', 'TV', -8, 178, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(227, 'Taiwan', 'backend/image/flags/flag-of-Taiwan.jpg', 'taiwan', 'flag-icon-tw', 'TW', 23.5, 121, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(228, 'Tanzania', 'backend/image/flags/flag-of-Tanzania.jpg', 'tanzania', 'flag-icon-tz', 'TZ', -6, 35, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(229, 'Uganda', 'backend/image/flags/flag-of-Uganda.jpg', 'uganda', 'flag-icon-ug', 'UG', 1, 32, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(230, 'Ukraine', 'backend/image/flags/flag-of-Ukraine.jpg', 'ukraine', 'flag-icon-ua', 'UA', 49, 32, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(231, 'United States Minor Outlying Islands', 'backend/image/flags/flag-of-United-States-Minor-Outlying-Islands.jpg', 'united-states-minor-outlying-islands', 'flag-icon-um', 'UM', 19.2911437, 166.618332, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(232, 'Uruguay', 'backend/image/flags/flag-of-Uruguay.jpg', 'uruguay', 'flag-icon-uy', 'UY', -33, -56, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(233, 'United States', 'backend/image/flags/flag-of-United-States.jpg', 'united-states', 'flag-icon-us', 'US', 38, -97, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(234, 'Uzbekistan', 'backend/image/flags/flag-of-Uzbekistan.jpg', 'uzbekistan', 'flag-icon-uz', 'UZ', 41, 64, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(235, 'Vatican City', 'backend/image/flags/flag-of-Vatican-City.jpg', 'vatican-city', 'flag-icon-va', 'VA', 41.9, 12.45, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(236, 'Saint Vincent and the Grenadines', 'backend/image/flags/flag-of-Saint-Vincent-and-the-Grenadines.jpg', 'saint-vincent-and-the-grenadines', 'flag-icon-vc', 'VC', 13.25, -61.2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(237, 'Venezuela', 'backend/image/flags/flag-of-Venezuela.jpg', 'venezuela', 'flag-icon-ve', 'VE', 8, -66, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(238, 'British Virgin Islands', 'backend/image/flags/flag-of-British-Virgin-Islands.jpg', 'british-virgin-islands', 'flag-icon-vg', 'VG', 18.431383, -64.62305, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(239, 'United States Virgin Islands', 'backend/image/flags/flag-of-United-States-Virgin-Islands.jpg', 'united-states-virgin-islands', 'flag-icon-vi', 'VI', 18.35, -64.933333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(240, 'Vietnam', 'backend/image/flags/flag-of-Vietnam.jpg', 'vietnam', 'flag-icon-vn', 'VN', 16.16666666, 107.83333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(241, 'Vanuatu', 'backend/image/flags/flag-of-Vanuatu.jpg', 'vanuatu', 'flag-icon-vu', 'VU', -16, 167, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(242, 'Wallis and Futuna', 'backend/image/flags/flag-of-Wallis-and-Futuna.jpg', 'wallis-and-futuna', 'flag-icon-wf', 'WF', -13.3, -176.2, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(243, 'Samoa', 'backend/image/flags/flag-of-Samoa.jpg', 'samoa', 'flag-icon-ws', 'WS', -13.58333333, -172.33333333, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(244, 'Yemen', 'backend/image/flags/flag-of-Yemen.jpg', 'yemen', 'flag-icon-ye', 'YE', 15, 48, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(245, 'South Africa', 'backend/image/flags/flag-of-South-Africa.jpg', 'south-africa', 'flag-icon-za', 'ZA', -29, 24, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(246, 'Zambia', 'backend/image/flags/flag-of-Zambia.jpg', 'zambia', 'flag-icon-zm', 'ZM', -15, 30, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(247, 'Zimbabwe', 'backend/image/flags/flag-of-Zimbabwe.jpg', 'zimbabwe', 'flag-icon-zw', 'ZW', -20, 30, 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `symbol_position`, `created_at`, `updated_at`) VALUES
(1, 'United State Dollar', 'USD', '$', 'left', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'Indian Rupee', 'INR', '₹', 'left', '2023-03-16 02:19:53', '2023-03-16 02:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_provider` enum('flutterwave','mollie','midtrans','paypal','paystack','razorpay','sslcommerz','stripe','instamojo','offline') COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usd_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manual_payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` enum('subscription_based','per_job_based') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'subscription_based'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`id`, `order_id`, `payment_provider`, `company_id`, `amount`, `currency_symbol`, `usd_amount`, `payment_status`, `created_at`, `updated_at`, `manual_payment_id`, `transaction_id`, `plan_id`, `payment_type`) VALUES
(1, '640727a1c6781', 'offline', 3, '0', '$', '0', 'paid', '2023-03-07 06:31:37', '2023-03-07 06:31:37', NULL, 'tr_640727a1c6783', 1, 'subscription_based'),
(4, '64351238bd989', 'offline', 7, '0', '$', '0', 'paid', '2023-04-11 02:24:32', '2023-04-11 02:24:32', NULL, 'tr_64351238bd98b', 1, 'subscription_based'),
(5, '453374260', 'razorpay', 3, '12318.1', '₹', '150', 'paid', '2023-04-21 05:38:31', '2023-04-21 05:38:31', NULL, 'pay_LgQ43kXnBH7iK8', NULL, 'per_job_based'),
(6, '498968458', 'razorpay', 3, '8169.4', '₹', '100', 'paid', '2023-04-28 00:15:40', '2023-04-28 00:15:40', NULL, 'pay_Lj6Iiy8tAl2YrD', 2, 'subscription_based'),
(7, '6477271d29c48', 'offline', 8, '0', '$', '0', 'paid', '2023-05-31 05:23:17', '2023-05-31 05:23:17', NULL, 'tr_6477271d29c49', 1, 'subscription_based'),
(8, '64783b47c7724', 'offline', 2, '0', '$', '0', 'paid', '2023-06-01 01:01:35', '2023-06-01 01:01:35', NULL, 'tr_64783b47c7725', 1, 'subscription_based'),
(11, '647855fde610b', 'offline', 11, '0', '$', '0', 'paid', '2023-06-01 02:55:33', '2023-06-01 02:55:33', NULL, 'tr_647855fde610c', 1, 'subscription_based'),
(12, '6493e5ac08cd8', 'offline', 14, '0', '$', '0', 'paid', '2023-06-22 00:39:48', '2023-06-22 00:39:48', NULL, 'tr_6493e5ac08cda', 1, 'subscription_based'),
(13, '649a6ecbb2f21', 'offline', 28, '0', '$', '0', 'paid', '2023-06-26 23:38:27', '2023-06-26 23:38:27', NULL, 'tr_649a6ecbb2f26', 1, 'subscription_based'),
(14, '649a7b7cf2d73', 'offline', 29, '0', '$', '0', 'paid', '2023-06-27 00:32:36', '2023-06-27 00:32:36', NULL, 'tr_649a7b7cf2d76', 1, 'subscription_based'),
(15, '649a7b91c5172', 'offline', 29, '1000', '$', '1000', 'unpaid', '2023-06-27 00:32:57', '2023-06-27 00:32:57', 1, 'tr_649a7b91c5174', 3, 'subscription_based'),
(16, '649c2cec017ca', 'offline', 32, '0', '$', '0', 'paid', '2023-06-28 07:21:56', '2023-06-28 07:21:56', NULL, 'tr_649c2cec017cd', 1, 'subscription_based');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'High School', 'high-school', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'Intermediate', 'intermediate', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, 'Bachelor Degree', 'bachelor-degree', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'Master Degree', 'master-degree', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, 'Graduated', 'graduated', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(6, 'PhD', 'phd', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, 'Any', 'any', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `type`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'New User', 'new_user', 'Welcome {user_name}', '<p>Hi {user_name},</p><p>Welcome to {company_name}. It\'s great to have you here!</p><p>Have a great time!</p><p>Regards,<br>{company_name} team</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(2, 'Edited Job', 'new_edited_job_available', 'New Edited Job Available For Approval!', '<p>Hello <strong>{admin_name}</strong>,<br>A new edited job available for approval!</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(3, 'New Job Available', 'new_job_available', 'New Job Available For Approval!', '<p>Hello {admin_name},<br>A new job available for approval!</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(4, 'New Plan Purchase', 'new_plan_purchase', '{user_name} Has Purchased The {plan_label} Plan!', '<p>{user_name} Has Purchased The {plan_label} Plan!</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(5, 'New User Registered', 'new_user_registered', 'New {user_role} Registered!', '<p>Hello {admin_name},<br>A {user_role} Registered Recently!</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(6, 'Plan Purchase', 'plan_purchase', 'Plan Purchased', '<p>Hello {user_name}!<br>You purchase of {plan_type} has been successfully completed!<br>Regards</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(7, 'New Pending Candidate', 'new_pending_candidate', 'Candidate Created', '<p>Hello {user_name},<br><br>Your candidate profile has been created and is waiting for admin approval.<br><br>Please login with your credentials below to check status -<br>Your Email : {user_email}<br>Your Password : {user_password}<br><br>Regards</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(8, 'New Candidate', 'new_candidate', 'Candidate Created', '<p>Hello {user_name},<br><br>Your candidate profile has been created.<br><br>Please login with your credentials below to check status -<br>Your Email : {user_email}<br>Your Password : {user_password}<br><br>Regards</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(9, 'New Company Pending', 'new_company_pending', 'Company created and waiting for admin approval', '<p>Hello {user_name},<br><br>Your company profile has been created and is waiting for admin approval.<br><br>Please check back your account with the login information below -<br>Your Email : {user_email}<br>Your Password : {user_password}<br><br>Regards</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(10, 'New Company', 'new_company', 'Company Created', '<p>Hello {user_name},<br><br>Your company profile has been created. Please login with below information.<br><br>Please check back your account with the login information below -<br>Your Email : {user_email}<br>Your Password : {user_password}<br><br>Regards</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(11, 'Update Company Password', 'update_company_pass', '{account_type} Updated', '<p>Hello {user_name},<br><br>Your {account_type} profile password updated.<br><br>Your Email : {user_email}<br>Your password : {password}<br><br>Regards</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(12, 'Verify Subscription Notification', 'verify_subscription_notification', 'Verify Your Subscription', '<p>Please verify your subscription by clicking below link.<br>Regards</p>', '2023-02-24 04:43:18', '2023-02-24 04:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Fresher', 'fresher', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, '1 Year', '1-year', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, '2 Years', '2-years', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, '3+ Years', '3-years', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, '5+ Years', '5-years', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(6, '8+ Years', '8-years', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, '10+ Years', '10-years', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(8, '15+ Years', '15-years', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(9, '2.5 Years', '25-years', '2023-04-26 07:10:03', '2023-04-26 07:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faq_category_id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `name`, `slug`, `icon`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Job', 'job', 'fas fa-briefcase', 0, '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `industry_types`
--

CREATE TABLE `industry_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industry_types`
--

INSERT INTO `industry_types` (`id`, `created_at`, `updated_at`) VALUES
(6, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(8, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(9, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(10, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(11, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(12, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(13, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(14, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(15, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(16, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(17, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(18, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(19, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(20, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(22, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(23, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(24, '2023-05-03 00:28:24', '2023-05-03 00:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `industry_type_translations`
--

CREATE TABLE `industry_type_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `industry_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industry_type_translations`
--

INSERT INTO `industry_type_translations` (`id`, `industry_type_id`, `name`, `locale`, `created_at`, `updated_at`) VALUES
(6, 6, 'Energy/Power/Fuel', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, 7, 'Garments/Textile', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(8, 8, 'Govt./Semi-Govt./Autonomous', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(9, 9, 'Pharmaceuticals', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(10, 10, 'Hospital/Diagnostic Center', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(11, 11, 'Airline/Travel/Tourism', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(12, 12, 'Manufacturing (Light Industry)', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(13, 13, 'Manufacturing (Heavy Industry)', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(14, 14, 'Hotel/Restaurant', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(15, 15, 'Web & Mobile App Development', 'en', '2023-02-24 04:43:20', '2023-03-08 06:09:29'),
(16, 16, 'Logistics/Transportation', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(17, 17, 'Entertainment/Recreation', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(18, 18, 'Media/Advertising/Event Mgt.', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(19, 19, 'NGO/Development', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(20, 20, 'Real Estate/Development', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(22, 22, 'Telecommunication', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(23, 23, 'Food & Beverage Industry', 'en', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(24, 24, 'Industrie alimentaire', 'fr', '2023-05-03 00:28:24', '2023-05-03 00:28:24'),
(25, 24, 'Food industry', 'en', '2023-05-03 00:28:24', '2023-05-03 00:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `experience_id` bigint(20) UNSIGNED NOT NULL,
  `education_id` bigint(20) UNSIGNED NOT NULL,
  `job_type_id` bigint(20) UNSIGNED NOT NULL,
  `salary_type_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vacancies` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_salary` int(11) DEFAULT '0',
  `max_salary` int(11) DEFAULT '0',
  `deadline` date DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','active','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `apply_on` enum('app','email','custom_url') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'app',
  `apply_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apply_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `featured_until` date DEFAULT NULL,
  `highlight` tinyint(1) NOT NULL DEFAULT '0',
  `highlight_until` date DEFAULT NULL,
  `is_remote` tinyint(1) NOT NULL DEFAULT '0',
  `total_views` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` double DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `parent_job_id` bigint(20) UNSIGNED DEFAULT NULL,
  `waiting_for_edit_approval` tinyint(1) NOT NULL DEFAULT '0',
  `salary_mode` enum('range','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'range',
  `custom_salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `company_id`, `category_id`, `role_id`, `experience_id`, `education_id`, `job_type_id`, `salary_type_id`, `title`, `slug`, `vacancies`, `min_salary`, `max_salary`, `deadline`, `description`, `status`, `apply_on`, `apply_email`, `apply_url`, `featured`, `featured_until`, `highlight`, `highlight_until`, `is_remote`, `total_views`, `created_at`, `updated_at`, `address`, `neighborhood`, `locality`, `place`, `district`, `postcode`, `region`, `country`, `long`, `lat`, `parent_job_id`, `waiting_for_edit_approval`, `salary_mode`, `custom_salary`) VALUES
(16, 4, 11, 1, 1, 1, 1, 1, 'Front Developer', 'front-developer-1681805690-643e517aa28c4', '1', 10, 120, '2023-04-26', '<h2>Job Description</h2><ul><li>Develop new components based on design specs.<br>&nbsp;</li><li>Work independently and write maintainable code.<br>&nbsp;</li><li>Understand existing code and suggest optimization in terms of functionality and performance.<br>&nbsp;</li><li>Work on client frameworks for caching and develop reusable components.<br>&nbsp;</li></ul><p>Please note that we have requirements for this role in Chennai, Salem, Coimbatore, Tirunelveli, and Madurai.</p>', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-04-14 05:43:10', '2023-06-15 01:47:39', 'tamil-india', '', '', '', '', '', 'Tamil', 'India', 77.82443043558078, 12.737944619879697, NULL, 0, 'range', NULL),
(18, 2, 11, 4, 1, 3, 3, 1, 'UI/UX Designer', 'uiux-designer-1685602111-64783f3f102dc', '1', 10, 120, '2025-04-18', '<h2>Design</h2><p>Working here at Ericsson means being part of shaping the future of technology; from future-proof software to innovative hardware solutions, your opportunity to make an impact is endless. Great design is essential in making our products and services user friendly and ensure high quality and fit for purpose. The design capabilities we are constantly in demand for span from industrial design to UX design, and everything in-between. Joining us you will have the possibility to work collaboratively with teams all over the world on projects of massive scale, while working to create solutions that have a measurable impact for our customers, and for society as a whole.</p><h4>Endless opportunities</h4><p>No matter what type of designer you are, there are an endless variety of challenges to solve here at Ericsson. We have strong designers across the business who take an active part in all hardware product development, from research and early concepts to implementation and production. you will work tightly with other design competencies, and have access to top-level facilities and the necessary tools to excel. Always keeping the user in focus, you will be creating a total experience through cutting-edge software or innovative hardware solutions.&nbsp;</p><h3>Some of our roles include:</h3><h4>Industrial designers</h4><p>As an Industrial designer at Ericsson you’ll be taking an active role in all hardware product development, from research and early concepts to realization and implementation. You’ll have great opportunities for initiatives and creativity in multiple workstreams, and will work collaboratively with other design competencies.</p><h4>Digital designers</h4><p>As a Digital designer at Ericsson, you create a total experience for the user through all our software products. You will put your excellent design skills to use, while solving complex UI challenges and clearly illustrate how interfaces should function to make products user-friendly.</p>', 'active', 'app', 'abservetechphp@gmail.com', NULL, 0, NULL, 1, NULL, 0, 0, '2023-04-15 02:34:42', '2023-06-01 01:18:31', 'maduraitamilnaduindia-india', NULL, NULL, NULL, NULL, NULL, 'madurai,tamilnadu,india', 'India', 78.08989843749998, 9.872413928288898, NULL, 0, 'range', NULL),
(19, 3, 11, 1, 1, 1, 2, 1, 'Wordpress Developer', 'wordpress-developer-1684820701-646c52dd67ea5', '1', 10, 120, '2023-11-14', '<p>testing processs</p>', 'active', 'app', NULL, NULL, 1, NULL, 0, NULL, 0, 0, '2023-04-17 00:36:41', '2023-05-23 00:15:01', 'tamil-nadu-india	', NULL, NULL, NULL, NULL, NULL, 'tamil-nadu', 'india', 78.0898984375, 9.8724139282889, NULL, 0, 'range', NULL),
(20, 3, 14, 1, 1, 1, 1, 1, 'Junior Front End Developer', 'junior-front-end-developer-1682075311-64426eaf42edd', '1', 50, 100, '2023-05-21', '<p>Front End Associate Developer will be responsible for maintaining daily marketing content and promotions, plus development of new functionality. This role will require working closely and collaborating with multiple departments to maintain different web properties, enhance current codebases, and develop future components.</p><p><br>Responsibilities:</p><p>Key Responsibilities</p><ul><li>Support development of our day-to-day content, design and styling for our websites</li><li>Collaborate with IT, designers and business partners to implement new site functionality and designs</li><li>Assist lead developers in execution of enhancements and projects</li><li>Implement event tagging for analytics and digital marketing campaigns</li><li>Troubleshoot and resolve IT tickets/site issues</li><li>Execute A/B testing in partnership with our business teams</li></ul>', 'pending', 'app', NULL, NULL, 0, NULL, 1, NULL, 0, 0, '2023-04-21 05:38:31', '2023-04-21 05:38:31', 'tamil-india', '', '', '', '', '', 'Tamil', 'India', 78.11149583386842, 9.920015367636667, NULL, 0, 'range', 'Competitive'),
(21, 3, 19, 6, 1, 7, 1, 1, 'Accountant', 'accountant-1686140222-6480753ecced7', '1', 10, 120, '2025-05-15', '<p>testing processs</p>', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-04-26 23:54:08', '2023-06-07 06:47:53', 'maduraitamilnaduindia-india', NULL, NULL, NULL, NULL, NULL, 'madurai,tamilnadu,india', 'india', 78.08989843749998, 9.872413928288898, NULL, 0, 'range', NULL),
(22, 11, 12, 3, 1, 1, 1, 1, 'Accountant', 'accountant-1686811500-648ab36c438b0', '5', 20, 150, '2023-07-30', 'Learvel developer', 'pending', 'app', NULL, NULL, 0, NULL, 1, NULL, 0, 0, '2023-05-31 05:33:00', '2023-06-15 01:15:00', 'tamilnadu-india', '', NULL, NULL, NULL, NULL, 'tamilnadu', 'india', 78.08989843749998, 9.87241392828889, NULL, 0, 'range', 'competitive'),
(24, 11, 11, 1, 1, 1, 1, 1, 'Laravel Developer', 'laravel-developer-1685608104-647856a87d743', '1', 50, 100, '2023-07-01', '<p>Laravel</p>', 'active', 'app', NULL, NULL, 0, NULL, 1, NULL, 0, 0, '2023-06-01 02:58:24', '2023-06-01 02:58:38', 'tamil-india', '', '', '', '', '', 'Tamil', 'India', 78.09561619635133, 9.929877720009507, NULL, 0, 'range', 'Competitive'),
(25, 11, 12, 3, 1, 1, 1, 1, 'Accountant', 'accountant-1686639298-648812c267189', '1', 10, 120, '2023-05-16', 'Learvel developer', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-06-13 01:24:58', '2023-06-13 01:24:58', 'tamilnadu-india', NULL, NULL, NULL, NULL, NULL, 'tamilnadu', 'india', 78.08989843749998, 9.87241392828889, NULL, 0, 'range', 'competitive'),
(26, 11, 12, 3, 1, 1, 1, 1, 'Accountant', 'accountant-1686823247-648ae14fbc3d3', '10', 10, 120, '2023-07-30', 'Learvel developer', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-06-15 04:30:47', '2023-06-23 06:20:42', 'tamilnadu-india', NULL, NULL, NULL, NULL, NULL, 'tamilnadu', 'india', 78.08989843749998, 9.87241392828889, NULL, 0, 'range', 'competitive'),
(27, 11, 11, 10, 2, 3, 1, 1, 'Node Js', 'node-js-1687521643-6495896bc9505', '10', 10, 150, '2023-07-24', '<p>Php</p>', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-06-23 06:30:43', '2023-06-23 06:30:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'range', 'Competitive'),
(40, 28, 11, 10, 2, 7, 1, 1, 'Laravel Developer', 'laravel-developer-1687761990-64993446ba2f0', '10', 10, 160, '2023-07-26', '<p>Good Knowledge for laravel framework</p>', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-06-26 01:16:30', '2023-06-27 00:11:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'range', 'Competitive'),
(43, 28, 11, 10, 1, 5, 1, 1, 'Node Js', 'node-js-1687762223-6499352f822bd', '8', 15, 300, '2023-07-15', '<p>sd</p>', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-06-26 01:20:23', '2023-06-27 00:11:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'range', 'Competitive'),
(44, 28, 11, 1, 2, 5, 1, 1, 'Laravel Developer', 'laravel-developer-1687779026-649976d2caac1', '10', 20, 200, '2023-07-29', '<p>Searching job</p>', 'active', 'app', NULL, NULL, 0, NULL, 0, NULL, 0, 0, '2023-06-26 06:00:26', '2023-06-27 00:11:01', 'tamil-india', '', '', '', '', '', 'Tamil', 'India', 78.11049699783325, 9.919246036532934, NULL, 0, 'range', 'Competitive'),
(45, 28, 11, 10, 1, 3, 1, 1, 'Laravel', 'laravel-1687844166-649a7546a7f8a', '1', 50, 100, '2023-07-27', '<p>Knowledge for laravel framework&nbsp;</p><p>knowledge for php mysql</p>', 'active', 'app', NULL, NULL, 1, NULL, 0, NULL, 0, 0, '2023-06-27 00:06:06', '2023-06-27 00:10:58', 'tamil-india', '', '', '', '', '', 'Tamil', 'India', 78.12179369734612, 9.913784093062057, NULL, 0, 'range', 'Competitive');

-- --------------------------------------------------------

--
-- Table structure for table `job_benefit`
--

CREATE TABLE `job_benefit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `benefit_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_benefit`
--

INSERT INTO `job_benefit` (`id`, `job_id`, `benefit_id`, `created_at`, `updated_at`) VALUES
(10, 20, 2, NULL, NULL),
(11, 20, 4, NULL, NULL),
(12, 21, 3, NULL, NULL),
(13, 21, 7, NULL, NULL),
(17, 22, 10, NULL, NULL),
(20, 45, 5, NULL, NULL),
(21, 45, 6, NULL, NULL),
(22, 45, 7, NULL, NULL),
(23, 45, 8, NULL, NULL),
(24, 45, 9, NULL, NULL),
(25, 45, 10, NULL, NULL),
(26, 45, 12, NULL, NULL),
(27, 45, 13, NULL, NULL),
(28, 45, 17, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

CREATE TABLE `job_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci,
  `icon` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `image`, `icon`, `created_at`, `updated_at`) VALUES
(11, 'uploads/images/jobCategory/bnOGenufDe4jQohQmuAXJGj7spkV9uw7GispTZjB.png', 'fas fa-desktop', '2023-03-08 00:27:07', '2023-03-08 00:27:07'),
(12, 'uploads/images/jobCategory/QABLCdEpDqUoJXXfmgPwNXd4FMhIbxdCBOGZTexr.jpg', 'fas fa-palette', '2023-03-08 00:38:57', '2023-03-08 00:38:57'),
(13, 'uploads/images/jobCategory/dWsciNiBcoQeqjMrgil2zcEOTxVSMI0vQIfukQKv.jpg', 'fas fa-search', '2023-03-08 00:40:09', '2023-03-08 00:45:56'),
(14, 'uploads/images/jobCategory/hW1J01L2c3NVgWPBMNmIbSvNVSkCHPMXaeVdZqcl.jpg', 'fas fa-desktop', '2023-03-08 00:48:24', '2023-03-08 00:48:24'),
(15, 'uploads/images/jobCategory/ko8upHSr93JLQFbgD6SNQFWRsQCAq6jVLYNXMqRg.jpg', 'fas fa-desktop', '2023-03-08 00:57:50', '2023-03-08 00:57:50'),
(19, NULL, NULL, '2023-04-26 05:34:44', '2023-04-26 05:34:44'),
(20, 'uploads/images/jobCategory/AXL7qec82QgqYTMkUREFMrJfhZ6GGiqeYlbcPzOk.jpg', 'fas fa-font', '2023-04-26 07:07:00', '2023-05-03 00:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `job_category_translations`
--

CREATE TABLE `job_category_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_category_translations`
--

INSERT INTO `job_category_translations` (`id`, `job_category_id`, `name`, `locale`, `created_at`, `updated_at`) VALUES
(11, 11, 'Full Stack Engineer', 'en', '2023-03-08 00:27:07', '2023-03-08 00:27:07'),
(12, 12, 'UI/UX Designer', 'en', '2023-03-08 00:38:57', '2023-03-08 00:38:57'),
(13, 13, 'Quality Analyst', 'en', '2023-03-08 00:40:09', '2023-03-08 00:40:09'),
(14, 14, 'Web Developer', 'en', '2023-03-08 00:48:24', '2023-03-08 00:48:24'),
(15, 15, 'Senior Web Developer', 'en', '2023-03-08 00:57:50', '2023-03-08 00:57:50'),
(19, 19, 'Accounting', 'en', '2023-04-26 05:34:44', '2023-04-26 05:34:44'),
(20, 19, 'Accounting', 'fr', '2023-04-26 05:34:44', '2023-04-26 05:34:44'),
(21, 20, 'Administrator', 'en', '2023-04-26 07:07:00', '2023-04-26 07:07:00'),
(22, 20, 'Administrateur', 'fr', '2023-04-26 07:07:00', '2023-05-03 00:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `job_roles`
--

CREATE TABLE `job_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_roles`
--

INSERT INTO `job_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Team Leader', 'team-leader', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(2, 'Manager', 'manager', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(3, 'Assistant Manager', 'assistant-manager', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(4, 'Executive', 'executive', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(5, 'Director', 'director', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(6, 'Administrator', 'administrator', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(7, 'Quality Analyst', 'quality-analyst', '2023-01-01 23:11:40', '2023-01-01 23:11:40'),
(8, 'Project manager', 'project-manager', '2023-04-26 07:03:27', '2023-04-26 07:03:27'),
(9, 'Designing', 'designing', '2023-05-03 01:38:41', '2023-05-03 01:38:41'),
(10, 'BDE', 'bde', '2023-05-16 06:52:51', '2023-05-16 06:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `job_role_translations`
--

CREATE TABLE `job_role_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_role_translations`
--

INSERT INTO `job_role_translations` (`id`, `job_role_id`, `name`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Team Leader', 'en', '2023-02-23 17:43:20', '2023-02-23 17:43:20'),
(2, 2, 'Manager', 'en', '2023-02-23 17:43:20', '2023-02-23 17:43:20'),
(3, 3, 'Assistant Manager', 'en', '2023-02-23 17:43:20', '2023-02-23 17:43:20'),
(4, 4, 'Executive', 'en', '2023-02-23 17:43:20', '2023-02-23 17:43:20'),
(5, 5, 'Director', 'en', '2023-02-23 17:43:20', '2023-02-23 17:43:20'),
(6, 6, 'Administrator', 'en', '2023-02-23 17:43:20', '2023-02-23 17:43:20'),
(7, 7, 'Manual Testing', 'en', '2023-03-06 18:53:48', '2023-03-06 18:53:48'),
(8, 8, 'Project manager', 'en', '2023-04-26 07:03:27', '2023-04-26 07:03:27'),
(9, 8, 'Chef de projet', 'fr', '2023-04-26 07:03:27', '2023-05-03 00:18:06'),
(10, 9, 'Conception', 'fr', '2023-05-03 01:38:41', '2023-05-03 01:38:41'),
(11, 9, 'Designing', 'en', '2023-05-03 01:38:41', '2023-05-03 01:38:41'),
(12, 10, 'BDE', 'fr', '2023-05-16 06:52:51', '2023-05-16 06:52:51'),
(13, 10, 'BDE', 'en', '2023-05-16 06:52:51', '2023-05-16 06:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `job_tag`
--

CREATE TABLE `job_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_tag`
--

INSERT INTO `job_tag` (`id`, `job_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(18, 18, 2, NULL, NULL),
(19, 18, 19, NULL, NULL),
(21, 20, 28, NULL, NULL),
(22, 20, 29, NULL, NULL),
(23, 20, 30, NULL, NULL),
(24, 20, 31, NULL, NULL),
(25, 21, 2, NULL, NULL),
(30, 24, 1, NULL, NULL),
(31, 24, 2, NULL, NULL),
(32, 24, 3, NULL, NULL),
(33, 25, 2, NULL, NULL),
(34, 22, 2, NULL, NULL),
(36, 27, 3, NULL, NULL),
(37, 27, 6, NULL, NULL),
(62, 40, 1, NULL, NULL),
(65, 43, 1, NULL, NULL),
(66, 44, 1, NULL, NULL),
(67, 44, 2, NULL, NULL),
(68, 44, 3, NULL, NULL),
(69, 45, 1, NULL, NULL),
(70, 45, 2, NULL, NULL),
(71, 45, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

CREATE TABLE `job_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Full Time', 'full-time', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'Part Time', 'part-time', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, 'Contractual', 'contractual', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'Intern', 'intern', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, 'Freelance', 'freelance', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ltr',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `direction`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'flag-icon-gb', 'ltr', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'French', 'fr', 'flag-icon-gp', 'ltr', '2023-03-16 02:12:01', '2023-03-16 02:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `manual_payments`
--

CREATE TABLE `manual_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('bank_payment','cash_payment','check_payment','custom_payment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manual_payments`
--

INSERT INTO `manual_payments` (`id`, `type`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'cash_payment', 'Test', '<p>Test</p>', 1, '2023-06-12 04:28:25', '2023-06-12 04:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2020_11_12_184107_create_permission_tables', 1),
(4, '2020_12_23_122556_create_contacts_table', 1),
(5, '2021_02_18_112239_create_admins_table', 1),
(6, '2021_07_14_154223_create_users_table', 1),
(7, '2021_08_23_115402_create_settings_table', 1),
(8, '2021_08_25_061331_create_languages_table', 1),
(9, '2021_12_14_142236_create_emails_table', 1),
(10, '2021_12_17_110211_create_testimonials_table', 1),
(11, '2021_12_19_152529_create_faq_categories_table', 1),
(12, '2021_12_21_105713_create_faqs_table', 1),
(13, '2022_01_25_131111_add_fields_to_settings_table', 1),
(14, '2022_01_26_091457_add_social_login_fields_to_users_table', 1),
(15, '2022_01_27_044638_create_experiences_table', 1),
(16, '2022_01_27_044649_create_education_table', 1),
(17, '2022_01_27_055733_create_job_types_table', 1),
(18, '2022_01_27_060057_create_salary_types_table', 1),
(19, '2022_01_27_081546_create_organization_types_table', 1),
(20, '2022_01_27_095019_create_team_sizes_table', 1),
(21, '2022_01_27_101204_create_nationalities_table', 1),
(22, '2022_01_27_121442_create_countries_table', 1),
(23, '2022_01_27_121452_create_states_table', 1),
(24, '2022_01_27_121453_create_cities_table', 1),
(25, '2022_01_28_030131_create_industry_types_table', 1),
(26, '2022_01_28_030802_create_professions_table', 1),
(27, '2022_01_28_033627_create_job_roles_table', 1),
(28, '2022_01_29_110746_create_companies_table', 1),
(29, '2022_01_29_120010_create_job_categories_table', 1),
(30, '2022_01_29_120020_create_candidates_table', 1),
(31, '2022_01_29_133751_create_jobs_table', 1),
(32, '2022_01_30_051177_create_post_categories_table', 1),
(33, '2022_01_30_051199_create_posts_table', 1),
(34, '2022_02_09_154506_create_company_bookmark_categories_table', 1),
(35, '2022_02_10_154506_create_bookmark_company_table', 1),
(36, '2022_02_10_160813_create_bookmark_candidate_job_table', 1),
(37, '2022_02_10_160821_create_bookmark_candidate_company_table', 1),
(38, '2022_02_10_161917_create_social_links_table', 1),
(39, '2022_02_10_162218_create_contact_infos_table', 1),
(40, '2022_02_19_141812_create_plans_table', 1),
(41, '2022_02_22_114329_create_post_comments_table', 1),
(42, '2022_02_22_183128_create_application_groups_table', 1),
(43, '2022_02_22_183129_create_applied_jobs_table', 1),
(44, '2022_03_01_213343_create_website_settings_table', 1),
(45, '2022_03_05_125615_create_currencies_table', 1),
(46, '2022_03_05_145248_create_abouts_table', 1),
(47, '2022_03_05_181737_create_our_missions_table', 1),
(48, '2022_03_08_110106_create_notifications_table', 1),
(49, '2022_03_10_110704_create_cms_table', 1),
(50, '2022_03_13_143318_create_payment_settings_table', 1),
(51, '2022_03_13_162626_create_user_plans_table', 1),
(52, '2022_03_13_193937_create_orders_table', 1),
(53, '2022_03_13_204812_create_earnings_table', 1),
(54, '2022_03_15_100012_create_terms_categories_table', 1),
(55, '2022_03_24_045305_create_seos_table', 1),
(56, '2022_03_26_130136_create_queue_jobs_table', 1),
(57, '2022_03_28_093629_add_socialite_column_to_users_table', 1),
(58, '2022_03_28_123603_create_theme_settings_table', 1),
(59, '2022_03_29_100616_create_timezones_table', 1),
(60, '2022_03_29_121851_create_admin_searches_table', 1),
(61, '2022_03_30_082959_create_cookies_table', 1),
(62, '2022_04_25_132657_create_setup_guides_table', 1),
(63, '2022_04_27_090501_create_bookmark_company_category_table', 1),
(64, '2022_04_30_041155_create_company_applied_job_rejected_table', 1),
(65, '2022_04_30_043011_create_company_applied_job_shortlist_table', 1),
(66, '2022_06_18_031525_add_full_address_to_candidates_table', 1),
(67, '2022_06_18_031525_add_full_address_to_companies_table', 1),
(68, '2022_06_18_031525_add_full_address_to_jobs_table', 1),
(69, '2022_06_27_050337_add_map_to_settings_table', 1),
(70, '2022_07_19_062856_create_manual_payments_table', 1),
(71, '2022_07_20_033046_add_manual_payment_id_to_earnings_table', 1),
(72, '2022_07_23_044852_add_transaction_id_to_earnings_table', 1),
(73, '2022_08_02_103529_create_candidate_resumes_table', 1),
(74, '2022_08_03_061932_add_fields_to_applied_jobs_table', 1),
(75, '2022_08_29_035902_add_employer_activation_field_to_settings_table', 1),
(76, '2022_08_29_063449_remove_some_columns_from_cms_table', 1),
(77, '2022_08_29_090125_create_cms_contents_table', 1),
(78, '2022_08_30_115827_remove_add_settings_table', 1),
(79, '2022_09_06_052408_create_skills_table', 1),
(80, '2022_09_06_052409_create_candidate_languages_table', 1),
(81, '2022_09_06_053034_create_candidate_skill_table', 1),
(82, '2022_09_06_053045_create_candidate_language_table', 1),
(83, '2022_10_16_063305_add_language_field_to_faqs_tables', 1),
(84, '2022_10_16_063328_add_language_field_to_testimonials_tables', 1),
(85, '2022_10_16_071227_add_available_status_fields_to_candidates_table', 1),
(86, '2022_10_16_100636_add_payperjob_field_to_settings_table', 1),
(87, '2022_10_17_024137_add_plan_id_field_to_earnings_table', 1),
(88, '2022_11_07_091932_add_candidate_account_auto_activation_to_settings_table', 1),
(89, '2022_11_09_040558_create_seo_page_contents_table', 1),
(90, '2022_11_11_085423_add_leaflet_map_field_to_settings_table', 1),
(91, '2022_11_12_060938_create_candidate_experiences_table', 1),
(92, '2022_11_12_091250_create_candidate_education_table', 1),
(93, '2022_11_15_095541_add_profile_limitaion_field_to_plans_table', 1),
(94, '2022_11_15_102325_add_profile_limitaion_field_to_user_plans_table', 1),
(95, '2022_11_17_083919_add_job_auto_approve_columns_to_settings', 1),
(96, '2022_11_17_090506_add_job_edited_columns_to_jobs', 1),
(97, '2022_11_18_032938_create_benefits_table', 1),
(98, '2022_11_18_032939_create_tags_table', 1),
(99, '2022_11_18_032940_create_job_benefit_table', 1),
(100, '2022_11_18_032941_create_job_tag_table', 1),
(101, '2022_11_23_104905_add_delete_columns_to_seos_table', 1),
(102, '2022_12_20_094532_change_salary_column_to_jobs_table', 1),
(103, '2022_12_20_102724_add_currency_switcher_field_to_settings_table', 1),
(104, '2022_12_23_104503_create_candidate_language_permission_table', 1),
(105, '2022_12_25_062232_add_highlight_features_job_duration_to_settings_table', 1),
(106, '2022_12_25_062645_add_highlight_featured_job_duration_field_to_jobs_table', 1),
(107, '2022_12_25_110928_create_benefit_permission_seeder_table', 1),
(108, '2022_12_26_082221_create_candidate_cv_views_table', 1),
(109, '2023_02_03_103051_add_currently_working_field_to_candidate_experiences_table', 1),
(110, '2023_02_06_112504_create_industry_type_translations_table', 1),
(111, '2023_02_07_034518_create_benefit_translations_table', 1),
(112, '2023_02_07_034909_create_profession_translations_table', 1),
(113, '2023_02_07_035108_create_skill_translations_table', 1),
(114, '2023_02_07_040101_create_job_role_translations_table', 1),
(115, '2023_02_07_095642_create_job_category_translations_table', 1),
(116, '2023_02_10_043825_add_fields_to_jobs_table', 1),
(117, '2023_02_10_053823_add_refund_page_column_to_cms_table', 1),
(118, '2023_02_13_093723_create_email_templates_table', 1),
(119, '2023_02_15_052022_remove_nationality_field_from_companies_table', 1),
(120, '2023_02_15_052100_remove_nationality_field_from_candidates_table', 1),
(121, '2023_02_16_085939_add_deadline_expiration_limit_to_settings_table', 1),
(122, '2023_02_17_022353_create_tags_crud_permission_table', 1),
(123, '2023_02_20_045609_create_tag_translations_table', 1),
(124, '2023_02_20_082840_add_show_popular_list_column_into_tags_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Afghan', 'afghan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(2, 'Albanian', 'albanian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(3, 'Algerian', 'algerian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(4, 'American', 'american', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(5, 'Andorran', 'andorran', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(6, 'Angolan', 'angolan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(7, 'Antiguans', 'antiguans', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(8, 'Argentinean', 'argentinean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(9, 'Armenian', 'armenian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(10, 'Australian', 'australian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(11, 'Austrian', 'austrian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(12, 'Azerbaijani', 'azerbaijani', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(13, 'Bahamian', 'bahamian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(14, 'Bahraini', 'bahraini', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(15, 'Bangladeshi', 'bangladeshi', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(16, 'Barbadian', 'barbadian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(17, 'Barbudans', 'barbudans', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(18, 'Batswana', 'batswana', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(19, 'Belarusian', 'belarusian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(20, 'Belgian', 'belgian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(21, 'Belizean', 'belizean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(22, 'Beninese', 'beninese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(23, 'Bhutanese', 'bhutanese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(24, 'Bolivian', 'bolivian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(25, 'Bosnian', 'bosnian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(26, 'Brazilian', 'brazilian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(27, 'British', 'british', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(28, 'Bruneian', 'bruneian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(29, 'Bulgarian', 'bulgarian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(30, 'Burkinabe', 'burkinabe', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(31, 'Burmese', 'burmese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(32, 'Burundian', 'burundian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(33, 'Cambodian', 'cambodian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(34, 'Cameroonian', 'cameroonian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(35, 'Canadian', 'canadian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(36, 'Cape Verdean', 'cape-verdean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(37, 'Central African', 'central-african', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(38, 'Chadian', 'chadian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(39, 'Chilean', 'chilean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(40, 'Chinese', 'chinese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(41, 'Colombian', 'colombian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(42, 'Comoran', 'comoran', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(43, 'Congolese', 'congolese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(44, 'Costa Rican', 'costa-rican', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(45, 'Croatian', 'croatian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(46, 'Cuban', 'cuban', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(47, 'Cypriot', 'cypriot', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(48, 'Czech', 'czech', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(49, 'Danish', 'danish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(50, 'Djibouti', 'djibouti', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(51, 'Dominican', 'dominican', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(52, 'Dutch', 'dutch', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(53, 'East Timorese', 'east-timorese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(54, 'Ecuadorean', 'ecuadorean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(55, 'Egyptian', 'egyptian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(56, 'Emirian', 'emirian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(57, 'Equatorial Guinean', 'equatorial-guinean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(58, 'Eritrean', 'eritrean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(59, 'Estonian', 'estonian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(60, 'Ethiopian', 'ethiopian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(61, 'Fijian', 'fijian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(62, 'Filipino', 'filipino', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(63, 'Finnish', 'finnish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(64, 'French', 'french', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(65, 'Gabonese', 'gabonese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(66, 'Gambian', 'gambian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(67, 'Georgian', 'georgian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(68, 'German', 'german', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(69, 'Ghanaian', 'ghanaian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(70, 'Greek', 'greek', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(71, 'Grenadian', 'grenadian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(72, 'Guatemalan', 'guatemalan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(73, 'Guinea-Bissauan', 'guinea-bissauan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(74, 'Guinean', 'guinean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(75, 'Guyanese', 'guyanese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(76, 'Haitian', 'haitian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(77, 'Herzegovinian', 'herzegovinian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(78, 'Honduran', 'honduran', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(79, 'Hungarian', 'hungarian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(80, 'I-Kiribati', 'i-kiribati', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(81, 'Icelander', 'icelander', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(82, 'Indian', 'indian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(83, 'Indonesian', 'indonesian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(84, 'Iranian', 'iranian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(85, 'Iraqi', 'iraqi', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(86, 'Irish', 'irish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(87, 'Israeli', 'israeli', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(88, 'Italian', 'italian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(89, 'Ivorian', 'ivorian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(90, 'Jamaican', 'jamaican', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(91, 'Japanese', 'japanese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(92, 'Jordanian', 'jordanian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(93, 'Kazakhstani', 'kazakhstani', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(94, 'Kenyan', 'kenyan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(95, 'Kittian and Nevisian', 'kittian-and-nevisian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(96, 'Kuwaiti', 'kuwaiti', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(97, 'Kyrgyz', 'kyrgyz', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(98, 'Laotian', 'laotian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(99, 'Latvian', 'latvian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(100, 'Lebanese', 'lebanese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(101, 'Liberian', 'liberian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(102, 'Libyan', 'libyan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(103, 'Liechtensteiner', 'liechtensteiner', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(104, 'Lithuanian', 'lithuanian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(105, 'Luxembourger', 'luxembourger', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(106, 'Macedonian', 'macedonian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(107, 'Malagasy', 'malagasy', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(108, 'Malawian', 'malawian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(109, 'Malaysian', 'malaysian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(110, 'Maldivan', 'maldivan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(111, 'Malian', 'malian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(112, 'Maltese', 'maltese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(113, 'Marshallese', 'marshallese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(114, 'Mauritanian', 'mauritanian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(115, 'Mauritian', 'mauritian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(116, 'Mexican', 'mexican', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(117, 'Micronesian', 'micronesian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(118, 'Moldovan', 'moldovan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(119, 'Monacan', 'monacan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(120, 'Mongolian', 'mongolian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(121, 'Moroccan', 'moroccan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(122, 'Mosotho', 'mosotho', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(123, 'Motswana', 'motswana', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(124, 'Mozambican', 'mozambican', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(125, 'Namibian', 'namibian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(126, 'Nauruan', 'nauruan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(127, 'Nepalese', 'nepalese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(128, 'New Zealander', 'new-zealander', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(129, 'Nicaraguan', 'nicaraguan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(130, 'Nigerian', 'nigerian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(131, 'Nigerien', 'nigerien', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(132, 'North Korean', 'north-korean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(133, 'Northern Irish', 'northern-irish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(134, 'Norwegian', 'norwegian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(135, 'Omani', 'omani', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(136, 'Pakistani', 'pakistani', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(137, 'Palauan', 'palauan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(138, 'Panamanian', 'panamanian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(139, 'Papua New Guinean', 'papua-new-guinean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(140, 'Paraguayan', 'paraguayan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(141, 'Peruvian', 'peruvian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(142, 'Polish', 'polish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(143, 'Portuguese', 'portuguese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(144, 'Qatari', 'qatari', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(145, 'Romanian', 'romanian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(146, 'Russian', 'russian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(147, 'Rwandan', 'rwandan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(148, 'Saint Lucian', 'saint-lucian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(149, 'Salvadoran', 'salvadoran', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(150, 'Samoan', 'samoan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(151, 'San Marinese', 'san-marinese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(152, 'Sao Tomean', 'sao-tomean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(153, 'Saudi', 'saudi', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(154, 'Scottish', 'scottish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(155, 'Senegalese', 'senegalese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(156, 'Serbian', 'serbian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(157, 'Seychellois', 'seychellois', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(158, 'Sierra Leonean', 'sierra-leonean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(159, 'Singaporean', 'singaporean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(160, 'Slovakian', 'slovakian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(161, 'Slovenian', 'slovenian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(162, 'Solomon Islander', 'solomon-islander', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(163, 'Somali', 'somali', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(164, 'South African', 'south-african', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(165, 'South Korean', 'south-korean', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(166, 'Spanish', 'spanish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(167, 'Sri Lankan', 'sri-lankan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(168, 'Sudanese', 'sudanese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(169, 'Surinamer', 'surinamer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(170, 'Swazi', 'swazi', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(171, 'Swedish', 'swedish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(172, 'Swiss', 'swiss', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(173, 'Syrian', 'syrian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(174, 'Taiwanese', 'taiwanese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(175, 'Tajik', 'tajik', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(176, 'Tanzanian', 'tanzanian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(177, 'Thai', 'thai', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(178, 'Togolese', 'togolese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(179, 'Tongan', 'tongan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(180, 'Trinidadian or Tobagonian', 'trinidadian-or-tobagonian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(181, 'Tunisian', 'tunisian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(182, 'Turkish', 'turkish', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(183, 'Tuvaluan', 'tuvaluan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(184, 'Ugandan', 'ugandan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(185, 'Ukrainian', 'ukrainian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(186, 'Uruguayan', 'uruguayan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(187, 'Uzbekistani', 'uzbekistani', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(188, 'Venezuelan', 'venezuelan', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(189, 'Vietnamese', 'vietnamese', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(190, 'Welsh', 'welsh', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(191, 'Yemenite', 'yemenite', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(192, 'Zambian', 'zambian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(193, 'Zimbabwean', 'zimbabwean', '2022-11-08 01:39:30', '2022-11-08 01:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('013babe1-e2c6-4a0f-bd86-61ac64866fc3', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 65, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', NULL, '2023-06-27 00:10:58', '2023-06-27 00:10:58'),
('05d070ef-f9a2-45e3-a9a1-274e2c598ee7', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/company\\/30\"}', NULL, '2023-06-27 00:35:00', '2023-06-27 00:35:00'),
('0702a44e-f32d-48c6-88c2-3144d81bd435', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 05:27:30', '2023-04-12 05:27:30'),
('07dc254c-9dd3-40ce-aa89-1b2f1039e4d6', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681545882-643a5a9a1ed16\"}', NULL, '2023-04-15 02:34:42', '2023-04-15 02:34:42'),
('095fa2eb-03b8-47cd-b0ef-33e6ea212b13', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 6, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-operative-up-to-ps14ph-1678526866-640c49924dc48\"}', NULL, '2023-03-11 03:58:20', '2023-03-11 03:58:20'),
('096127f3-a6ea-4af2-a059-9a169b471ff6', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 11, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/accountant-1684820484-646c52042436f\"}', NULL, '2023-05-23 00:11:50', '2023-05-23 00:11:50'),
('0a0790ea-276e-43cf-93cd-1b385c6b184a', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-04-11 05:23:23', '2023-04-11 05:23:23'),
('0b12383c-22ec-43b1-8d0f-3c2eb9ca4fa2', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-04-19 23:41:49', '2023-04-19 23:41:49'),
('0b7cb284-bf6d-4082-a463-26c9537d39a8', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\"}', NULL, '2023-05-08 00:41:56', '2023-05-08 00:41:56'),
('0b7ffd80-f3da-47ae-9e50-c9053c61e53e', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 43, '{\"title\":\"Ericsson has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/ericson\",\"title2\":\"You have bookmarked vigneshwari jeyaraj\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/vigneshwari%20jeyaraj\"}', NULL, '2023-06-01 01:08:21', '2023-06-01 01:08:21'),
('0c72fe96-b04d-47f2-8d3f-9e793e5441e8', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-14 01:43:03', '2023-04-14 01:43:03'),
('0d4caeff-11c0-4c19-be4b-c92c967d8b73', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 13, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/sales-man-1678529424-640c53908459d\"}', NULL, '2023-03-11 04:40:47', '2023-03-11 04:40:47'),
('0e6bf938-d465-4dfd-ac05-e4bb7192bb5f', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-13 00:27:05', '2023-04-13 00:27:05'),
('0f8515ff-2a7e-4e1d-a214-d1d68c6e00c4', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 4, '{\"title\":\"JosePhine has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-24 02:13:54', '2023-05-24 02:13:54'),
('0f8ac0d8-2e06-4bed-ad55-458857735bbe', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 23, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/accountant-1686823247-648ae14fbc3d3\"}', NULL, '2023-06-23 06:20:43', '2023-06-23 06:20:43'),
('0fdd8e9c-7a75-4bc9-bd50-063ec60c0cf9', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-04-19 06:08:58', '2023-04-19 06:08:58'),
('112e2fa6-0dd9-4bd5-9d16-327ea087556d', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 3, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 02:31:24', '2023-04-24 02:31:24'),
('1199d44b-4aec-4106-a1a3-c77c7294ced1', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:04:28', '2023-04-07 06:04:28'),
('1640ac3b-7348-47de-ba1a-1b1601781061', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 43, '{\"title\":\"Ericsson has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/ericson\",\"title2\":\"You have bookmarked vigneshwari jeyaraj\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/vigneshwari%20jeyaraj\"}', NULL, '2023-06-01 01:09:57', '2023-06-01 01:09:57'),
('171249c1-a921-4893-b390-f36f1cc18348', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-10 02:05:59', '2023-04-10 02:05:59'),
('17f5eccb-a653-466c-96e7-3d990dd27ae3', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 88, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687761990-64993446ba2f0\"}', '2023-06-27 00:14:58', '2023-06-27 00:11:09', '2023-06-27 00:14:58'),
('198139b5-cd0b-4ab9-9912-c8df580eb7e0', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 57, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:11:01', '2023-06-27 00:11:01'),
('1b207ac1-0ede-4119-b9a7-7d938b5aaa9e', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/company\\/6\"}', '2023-04-04 01:14:16', '2023-03-31 05:57:49', '2023-04-04 01:14:16'),
('1c1ccf5c-d55e-4e9c-9024-f6f2c0dd5b57', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/company\\/34\"}', NULL, '2023-06-28 01:13:38', '2023-06-28 01:13:38'),
('1c27dd75-e51a-407f-b43a-853cb5fec95f', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 3, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 01:53:42', '2023-04-24 01:53:42'),
('1cedfb96-38f3-45c5-87ea-33666f18b388', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 42, '{\"title\":\"Avinash ak has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-05-01 23:40:06', '2023-05-01 23:40:06'),
('1d2253d8-45e1-416f-bbc0-e1673d3b5f80', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 40, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-04-19 06:08:58', '2023-04-19 06:08:58'),
('1d78ce65-052b-4185-9453-77945f4f8d60', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 6, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-03-10 05:12:12', '2023-03-10 05:12:12'),
('1db2845a-11bf-4029-99c7-0b088c09934d', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 58, '{\"title\":\"Muthukumarabs has bookmarked your job\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/accountant-1686819111-648ad127ba269\",\"title2\":\"You have bookmarked a job\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/accountant-1686819111-648ad127ba269\"}', NULL, '2023-06-21 05:54:45', '2023-06-21 05:54:45'),
('1dc4b32c-7f51-47b0-9f80-ee2047015cbd', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681470400-643933c009caa\"}', NULL, '2023-04-14 05:36:40', '2023-04-14 05:36:40'),
('1ddb9320-1f57-42f8-888f-46d7d6550fb6', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-13 00:27:47', '2023-04-13 00:27:47'),
('1de441fd-746f-4d4f-85fb-488ee9ff123e', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\"}', NULL, '2023-05-02 06:15:47', '2023-05-02 06:15:47'),
('1df9bd38-797f-4eb0-8f9f-5c925b4f14a1', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 66, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/node-js-1687521643-6495896bc9505\"}', NULL, '2023-06-23 06:30:50', '2023-06-23 06:30:50'),
('1e70860b-10a8-4007-8ded-f29a8ea7beb3', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 00:57:33', '2023-04-12 00:57:33'),
('1ecda29d-af5a-4356-a481-f476e73511e9', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Jason Roy has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-20 02:50:11', '2023-05-20 02:50:11'),
('1ee89b68-b144-4716-b8bc-925b058cb769', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 2, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', NULL, '2023-04-05 01:10:00', '2023-04-05 01:10:00'),
('20a32779-cb70-46f4-aa55-6059b7bfa817', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/company\\/7\"}', '2023-04-11 06:49:33', '2023-04-11 01:26:51', '2023-04-11 06:49:33'),
('2103beef-3450-4675-90f9-8a9c5b29c706', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 2, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681474737-643944b1b4ef9\"}', NULL, '2023-04-14 06:49:11', '2023-04-14 06:49:11'),
('21d85d99-3e0a-4a80-b7a4-5694bc687547', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 66, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', NULL, '2023-06-27 00:10:36', '2023-06-27 00:10:36'),
('222469a0-4993-4f49-858a-a2c93cae8471', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 48, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:34', '2023-05-19 04:47:34'),
('2278e553-0889-4c04-836c-1c61c91ce66a', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', NULL, '2023-04-05 01:10:00', '2023-04-05 01:10:00'),
('23a1214a-87db-4a35-8f4f-4a5c1afe019c', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 2, '{\"title\":\"Avinash ak has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/uiux-designer-1681802497-643e450137240\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/uiux-designer-1681802497-643e450137240\"}', NULL, '2023-05-01 23:36:59', '2023-05-01 23:36:59'),
('246c4cfc-8d67-4dbc-89e5-f2542fef86a6', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 88, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', '2023-06-27 00:14:58', '2023-06-27 00:11:01', '2023-06-27 00:14:58'),
('247049e2-4867-489b-8cd1-3fe3b4469227', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 23:47:47', '2023-04-11 23:47:47'),
('255cdfac-5d15-4a3b-8105-5cda968848c3', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-05 01:10:05', '2023-04-05 01:10:05'),
('257101a7-75d4-4271-97d4-0e32e5afe370', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-10 02:05:59', '2023-04-10 02:05:59'),
('26062c25-a137-4a5d-88e4-8b1119deeace', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 88, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', '2023-06-27 00:14:59', '2023-06-27 00:10:50', '2023-06-27 00:14:59'),
('26a41dd3-fd07-45c6-bcb2-be40c5e745ff', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/company\\/31\"}', NULL, '2023-06-27 00:39:44', '2023-06-27 00:39:44'),
('29c02b87-4722-490f-b828-e362910dc5f4', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/11\"}', '2023-04-04 01:14:16', '2023-03-30 01:13:00', '2023-04-04 01:14:16'),
('29d82bd2-4fc0-4ada-a114-8f5d739b2d28', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 58, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/laravel-developer-1685608104-647856a87d743\"}', NULL, '2023-06-01 02:58:26', '2023-06-01 02:58:26'),
('2c8ad909-eedf-4471-8e64-434dcfeb0592', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 3, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-operative-up-to-ps14ph-1678526866-640c49924dc48\"}', NULL, '2023-03-11 03:58:20', '2023-03-11 03:58:20'),
('2db3123c-0716-41ff-8ec6-26d2961714ac', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 7, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\"}', NULL, '2023-04-19 12:13:04', '2023-04-19 12:13:04'),
('2e8c3d1f-7ae5-44f6-a88e-97dc79adf0ef', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\"}', NULL, '2023-05-02 06:15:38', '2023-05-02 06:15:38'),
('302966c6-79c0-4754-87e7-5129d0cbc7e2', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 3, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/content-writer-1678190642-640728320e4e5\"}', NULL, '2023-03-07 06:42:21', '2023-03-07 06:42:21'),
('30b7e641-80b2-4bb6-b166-6efc605b6d72', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-04-11 05:23:23', '2023-04-11 05:23:23'),
('312c2d59-f616-463b-b99c-362e91bf2a9f', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 65, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', NULL, '2023-06-27 00:10:47', '2023-06-27 00:10:47'),
('313c34f6-b96f-472b-859f-68371aa0916b', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 25, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:10:50', '2023-06-27 00:10:50'),
('33e62c4d-4571-4d23-8f21-91920f817daa', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 47, '{\"title\":\"Jason Roy has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-20 02:50:11', '2023-05-20 02:50:11'),
('34b65caf-e51b-4bad-89fd-b321e882d3e2', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 2, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/uiux-designer-1681802497-643e450137240\"}', NULL, '2023-04-18 01:54:53', '2023-04-18 01:54:53'),
('35d133a7-6e65-4551-a6ca-7cc6af0c0db3', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 7, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\"}', NULL, '2023-05-18 12:18:07', '2023-05-18 12:18:07'),
('374f3919-e883-4754-90bb-f4ea5933efb6', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/36\"}', '2023-05-31 07:02:14', '2023-05-31 05:06:28', '2023-05-31 07:02:14'),
('37b09d22-b289-4e35-8a5e-0b10ff668722', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 13, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/sales-person-1678531448-640c5b787056a\"}', NULL, '2023-03-11 05:14:08', '2023-03-11 05:14:08'),
('37ef962b-6a23-4be6-bed0-64e33f722585', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/company\\/11\"}', '2023-06-05 04:07:38', '2023-06-01 02:30:50', '2023-06-05 04:07:38'),
('38013a80-9313-49ca-bd71-4379911c23e4', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 42, '{\"title\":\"Avinash ak has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-18 00:04:38', '2023-05-18 00:04:38'),
('382316ef-d2b5-4cc2-b4c9-a5679eadd57c', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 38, '{\"title\":\"Suha rana has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681535030-643a30361b0df\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681535030-643a30361b0df\"}', NULL, '2023-04-15 08:46:32', '2023-04-15 08:46:32'),
('38916810-209b-468b-a875-6f06ec066649', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 10, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-03-10 05:12:12', '2023-03-10 05:12:12'),
('39d6d071-7752-43ee-9004-8b73372eada8', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 88, '{\"title\":\"Josephvijay s has bookmarked you\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/employers\\/Josephvijay%20s\",\"title2\":\"You have bookmarked Saravanakumar\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/candidates\\/saravanakumar\"}', NULL, '2023-06-27 00:16:13', '2023-06-27 00:16:13'),
('3aadbbcb-d2b7-420a-8331-d097f155e819', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 6, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/full-stack-developer-1678952814-6412c96e79c8c\"}', NULL, '2023-03-16 02:17:24', '2023-03-16 02:17:24'),
('3af4a4bf-3ece-4a9c-a2a7-3ff6d1f9e1c7', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/40\"}', '2023-06-05 04:07:38', '2023-06-01 02:29:43', '2023-06-05 04:07:38'),
('3bde9ab1-9ed2-4b90-8212-34244e08b3c9', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\"}', NULL, '2023-05-08 00:41:56', '2023-05-08 00:41:56'),
('3c6a7582-a0b4-4f77-872a-e1ff2a0960cc', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 3, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/accountant-1684820484-646c52042436f\"}', '2023-06-07 06:20:09', '2023-05-23 00:11:50', '2023-06-07 06:20:09'),
('3ce22848-a3ec-41f8-a0dd-3479f07d4f28', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-operative-1678527083-640c4a6b6dceb\"}', NULL, '2023-03-11 04:01:23', '2023-03-11 04:01:23'),
('3d8a6272-4420-4898-b661-d1b7aa83ec5b', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 3, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 02:32:38', '2023-04-24 02:32:38'),
('3e964283-6031-45f2-aec0-eb5375d6a243', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 89, '{\"title\":\"Josephvijay s has bookmarked you\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/employers\\/Josephvijay%20s\",\"title2\":\"You have bookmarked Thanasekaran\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/candidates\\/kthanasekaran122\"}', NULL, '2023-06-27 00:16:22', '2023-06-27 00:16:22'),
('3f4ecca3-163b-45e0-b47c-df625808d884', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 3, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 02:33:28', '2023-04-24 02:33:28'),
('3fce8f3e-2323-43ba-9862-cd388eb98824', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 05:41:39', '2023-04-07 05:41:39'),
('416b185a-09b1-4d5b-b829-8738779fe86d', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 45, '{\"title\":\"John luna has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-04 00:29:27', '2023-05-04 00:29:27'),
('42627dbb-3a1d-4200-ac71-3ace13e0f69e', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 59, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:10:50', '2023-06-27 00:10:50'),
('429c8bd0-de90-4fa2-b2df-78ed804f0340', 'App\\Notifications\\Admin\\NewJobAvailableNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A new job is available for approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/job?title=BDE\"}', '2023-05-31 07:02:14', '2023-05-31 05:33:00', '2023-05-31 07:02:14'),
('434a9082-9f24-43ae-89af-ee69e2f22be1', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 47, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-18 12:19:12', '2023-05-18 12:19:12'),
('4373f672-eda9-44a6-8d1e-6e189b439cd8', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 23:48:09', '2023-04-11 23:48:09'),
('43c1fd75-0014-48c5-ac4e-94db8b1f5de8', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 3, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked Martin luna\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/testcandidate\"}', NULL, '2023-04-26 04:25:02', '2023-04-26 04:25:02'),
('445427cd-bb44-4acb-8133-f7d7ed3f6135', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 65, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687761990-64993446ba2f0\"}', NULL, '2023-06-27 00:11:09', '2023-06-27 00:11:09'),
('446cd44a-0207-4570-9507-5bfd429e82d3', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Avinash ak has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-18 00:04:38', '2023-05-18 00:04:38'),
('4565fbfe-b630-477b-a2de-c39a48651c18', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/company\\/8\"}', '2023-05-31 07:02:14', '2023-05-31 05:16:45', '2023-05-31 07:02:14'),
('4581b9af-22ad-48c6-a823-3dd359e511c1', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 90, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:10:50', '2023-06-27 00:10:50'),
('46819bce-b608-464a-ac2f-7a1fa5de08fb', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 66, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', NULL, '2023-06-27 00:10:58', '2023-06-27 00:10:58'),
('4a0e7979-79a1-4d31-9962-f3bcebe0526b', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Test Candidate Support has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Test Support Company\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-03-07 07:04:58', '2023-03-07 07:04:58'),
('4b31da83-3cfa-4821-80c6-7dd96a0fe94d', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 6, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/forklift-driver-1678529598-640c543e09c2c\"}', NULL, '2023-03-11 04:44:25', '2023-03-11 04:44:25'),
('4b5d6f07-c1b7-4087-a0e6-fad51cb6a11e', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 16, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 02:31:24', '2023-04-24 02:31:24'),
('4c8bd19f-fb8c-44aa-9511-9b6e2409edc3', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 57, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:10:50', '2023-06-27 00:10:50'),
('4e03bb14-c377-4100-b2ca-8c66715dff27', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-13 00:27:05', '2023-04-13 00:27:05'),
('507a07f1-3f4c-46ed-9a8b-fac322385fc1', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:18', '2023-05-19 04:47:18'),
('50b8884d-de95-4148-b3cd-818a6084d696', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 10, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/full-stack-developer-1678952814-6412c96e79c8c\"}', NULL, '2023-03-16 02:17:25', '2023-03-16 02:17:25'),
('50dfeff8-f44d-4eb6-9819-34cd3826f08c', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\"}', NULL, '2023-05-02 06:15:47', '2023-05-02 06:15:47'),
('51594bbd-cd8f-4938-867d-327d1deafdf8', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-03-29 07:49:36', '2023-03-29 07:49:36'),
('52093332-bacd-4a0b-819e-589f4cedf976', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\"}', NULL, '2023-05-02 06:15:07', '2023-05-02 06:15:07'),
('5421c99f-2bb6-48d6-8c3c-c40a436215de', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/22\"}', '2023-04-18 02:07:07', '2023-04-15 00:56:49', '2023-04-18 02:07:07'),
('56b4fc6b-86e4-411c-b6ad-c335b83331a3', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/company\\/9\"}', '2023-06-05 04:07:38', '2023-06-01 01:58:30', '2023-06-05 04:07:38'),
('574c9d89-3ada-4290-b950-fac651a3f0b1', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 59, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:11:01', '2023-06-27 00:11:01'),
('59475808-482e-4c02-b186-d20a108593ae', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 00:55:50', '2023-04-12 00:55:50'),
('59ae8feb-1931-4a17-9cbb-aea63b9a1e5d', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 7, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/full-stack-developer-1678952814-6412c96e79c8c\"}', NULL, '2023-03-16 02:17:24', '2023-03-16 02:17:24'),
('5c74f847-6795-42d1-908c-a4a41317531f', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 4, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:10:50', '2023-06-27 00:10:50'),
('5d798304-51de-46a3-b557-b74bccd4d673', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 42, '{\"title\":\"Avinash ak has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\"}', NULL, '2023-05-04 23:52:17', '2023-05-04 23:52:17'),
('5df10bd5-207e-44c0-ba3b-a8ddcf104e1f', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 88, '{\"title\":\"Josephvijay s has bookmarked you\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/employers\\/Josephvijay%20s\",\"title2\":\"You have bookmarked Thanasekaran\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/candidates\\/kthanasekaran122\"}', NULL, '2023-06-27 00:16:22', '2023-06-27 00:16:22'),
('5f1ddc20-c7fa-4af8-b40f-e12b2adb7341', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/2\"}', '2023-03-07 06:34:39', '2023-03-07 06:14:14', '2023-03-07 06:34:39'),
('5f40ea16-9bd0-4d72-8fb2-e08710c7256c', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/10\"}', '2023-03-20 13:12:00', '2023-03-18 00:32:26', '2023-03-20 13:12:00'),
('5f94ac3a-e13b-4065-9b15-24e7adb7e42a', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 58, '{\"title\":\"Muthukumarabs has applied your job\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Amazon\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/company\\/my-jobs\"}', NULL, '2023-06-21 06:35:01', '2023-06-21 06:35:01'),
('5fe3c90d-4780-44a6-aabf-6206d4e8db11', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 16, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 01:53:42', '2023-04-24 01:53:42'),
('62a9233b-8c56-4e9a-81c4-0e663694590d', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Vishnu has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-04-20 02:45:26', '2023-04-20 02:45:26'),
('63f64bca-af79-42e2-8731-337cedd80939', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 1, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/manual-testing-1678188523-64071febc6caf\"}', NULL, '2023-03-07 05:59:34', '2023-03-07 05:59:34'),
('64098d9b-5eaf-4358-a07f-c792e6a2d855', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 4, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:11:01', '2023-06-27 00:11:01'),
('64aefa18-0242-4720-8223-f91c403800b0', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 43, '{\"title\":\"Ericsson has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/ericson\",\"title2\":\"You have bookmarked vigneshwari jeyaraj\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/vigneshwari%20jeyaraj\"}', NULL, '2023-06-01 01:10:56', '2023-06-01 01:10:56'),
('6537eaec-df80-4b1a-842a-f20612ccd428', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\"}', NULL, '2023-05-02 06:15:38', '2023-05-02 06:15:38'),
('65ad7a59-e94e-420b-8e6a-1da3a0a6b83b', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 13, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/sales-man-1678529424-640c53908459d\"}', NULL, '2023-03-11 04:40:24', '2023-03-11 04:40:24'),
('65be08f9-343d-4d7a-9367-1fba8e56e6ce', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', NULL, '2023-04-14 00:49:55', '2023-04-14 00:49:55'),
('66e09af1-cdbd-41f2-bdff-fb4112989263', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 2, '{\"title\":\"Avinash ak has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Ericsson\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-01 23:36:48', '2023-05-01 23:36:48'),
('6721ca8c-64d8-4bcc-b89b-fbcedb041cb5', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 06:32:08', '2023-04-12 06:32:08'),
('677ed793-73fc-4fbe-a6bb-4af39827c8bc', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 47, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\"}', NULL, '2023-05-18 12:18:24', '2023-05-18 12:18:24'),
('6803e01c-3aab-4476-8d94-a1e4bd46e152', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Vigneshwari jeyaraj has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-06 05:36:36', '2023-05-06 05:36:36'),
('684bde49-22a5-4845-94fe-43ca2c9a838b', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 16, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 02:33:28', '2023-04-24 02:33:28'),
('6ac51ef1-dc03-4771-a829-9bb074e7cc69', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 2, '{\"title\":\"Suha rana has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681535030-643a30361b0df\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681535030-643a30361b0df\"}', NULL, '2023-04-15 08:46:32', '2023-04-15 08:46:32');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('6e3d9b69-1c27-4252-b415-6896cd605bec', 'App\\Notifications\\Admin\\NewPlanPurchaseNotification', 'App\\Models\\Admin', 1, '{\"title\":\"Vigneshwari has purchased the Standard plan!\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/orders\\/10\"}', '2023-06-05 04:07:38', '2023-06-01 02:18:18', '2023-06-05 04:07:38'),
('6ee2310a-f2fd-4acd-bfe9-4e5f7634f664', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-04-19 23:42:02', '2023-04-19 23:42:02'),
('705b2714-293b-4bdb-8f4a-0461f4a2ef11', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 05:44:37', '2023-04-11 05:44:37'),
('72c0fdea-1dbd-42ce-a1fb-6bc9f02cfc95', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 8, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-operative-up-to-ps14ph-1678526866-640c49924dc48\"}', NULL, '2023-03-11 03:58:20', '2023-03-11 03:58:20'),
('734ab6fd-a348-4525-ae30-2dbe1d050f0f', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 2, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/uiux-designer-1681802497-643e450137240\"}', NULL, '2023-04-18 01:56:19', '2023-04-18 01:56:19'),
('735166e8-f73d-43c9-9ab2-a90cf6f5aac3', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 25, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:11:01', '2023-06-27 00:11:01'),
('7378473c-9722-4866-bee1-3760e643a0a5', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 2, '{\"title\":\"Ericsson has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/ericson\",\"title2\":\"You have bookmarked vigneshwari jeyaraj\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/vigneshwari%20jeyaraj\"}', NULL, '2023-06-01 01:10:56', '2023-06-01 01:10:56'),
('753aa059-7afc-4b4d-ba51-5c7209237ea2', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:19', '2023-05-19 04:47:19'),
('75cab5ca-2eca-4d68-8246-66e8cc663415', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 6, '{\"title\":\"Test Candidate Support has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Test Support Company\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-03-07 07:04:58', '2023-03-07 07:04:58'),
('77819aa0-f8fc-44d0-a16b-8692eeaec053', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 58, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/accountant-1686823247-648ae14fbc3d3\"}', NULL, '2023-06-15 04:30:48', '2023-06-15 04:30:48'),
('77ce9885-a2fd-4b51-972b-7c9f6580947f', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:35:56', '2023-04-07 06:35:56'),
('799105ae-afee-4bed-a8a2-ce35ed2eee56', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-04-20 04:52:15', '2023-04-20 04:52:15'),
('79ba755b-f507-47ed-b5cd-e08fbbe3f120', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 10, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-operative-up-to-ps14ph-1678526866-640c49924dc48\"}', NULL, '2023-03-11 03:58:20', '2023-03-11 03:58:20'),
('79c4d450-dd3e-4edd-a259-253d06194ff9', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 57, '{\"title\":\"Amazon has bookmarked you\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/employers\\/vigneshwari\",\"title2\":\"You have bookmarked mathavan\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/candidates\\/mathavan\"}', NULL, '2023-06-17 00:47:47', '2023-06-17 00:47:47'),
('79e749d5-545c-4103-8082-625e265b59d2', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/35\"}', '2023-05-24 01:02:03', '2023-05-23 02:37:34', '2023-05-24 01:02:03'),
('7b9856b0-674c-4123-b7c4-e7fc84a52a27', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 00:55:50', '2023-04-12 00:55:50'),
('7cfab552-af7f-4637-9f0b-d85e4bcbff82', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 2, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', NULL, '2023-04-14 00:49:55', '2023-04-14 00:49:55'),
('7d335721-ea71-4d58-870b-02c31b6e45e2', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-18 12:19:12', '2023-05-18 12:19:12'),
('7d9cfb4d-6133-45e3-ac5e-fb38e157cf16', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-01 07:55:41', '2023-04-01 07:55:41'),
('7da1f483-07be-4a98-9d81-739ab8755747', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 48, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:18', '2023-05-19 04:47:18'),
('7e684886-1471-4ea3-8b01-1245467fe95e', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"John luna has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-04 00:29:27', '2023-05-04 00:29:27'),
('7e9ca02b-fcb5-43bf-a4b8-82eb79d7aac0', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 3, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681470400-643933c009caa\"}', NULL, '2023-04-14 06:16:10', '2023-04-14 06:16:10'),
('7f0efc2d-3890-4354-a434-e82ee84efe44', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 4, '{\"title\":\"Bala has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-02 12:18:35', '2023-05-02 12:18:35'),
('7fe0d045-ca9c-4549-a927-365561af3d30', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-order-picker-1678527348-640c4b74ee9a9\"}', NULL, '2023-03-11 04:05:48', '2023-03-11 04:05:48'),
('7ff018cd-3887-4718-9a50-131660960c6b', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/company\\/3\"}', '2023-03-07 06:34:39', '2023-03-07 05:50:27', '2023-03-07 06:34:39'),
('81eb003d-59c4-40e9-9698-9315e39185f9', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 13, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/forklift-driver-1678529598-640c543e09c2c\"}', NULL, '2023-03-11 04:43:18', '2023-03-11 04:43:18'),
('8317d84f-be8c-45ae-a0a6-ccc8373f3b7e', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 66, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/node-js-1687762223-6499352f822bd\"}', NULL, '2023-06-27 00:11:05', '2023-06-27 00:11:05'),
('838f2fab-73e2-449f-bdab-bcdaf36e8b9f', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 44, '{\"title\":\"Jason Vijay has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-05-02 12:23:35', '2023-05-02 12:23:35'),
('83a8d9fc-1c5d-4116-afd3-e14b21f8e436', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 10, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/forklift-driver-1678529598-640c543e09c2c\"}', NULL, '2023-03-11 04:44:25', '2023-03-11 04:44:25'),
('84036234-e786-4807-872b-19ea1a3bc9f0', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-03-18 01:02:05', '2023-03-18 01:02:05'),
('844af756-38f7-4516-946b-4fbb8dbd7dd5', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:53:51', '2023-04-07 06:53:51'),
('85f337d1-143f-45e1-8540-4f1c3309f45a', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 88, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/node-js-1687762223-6499352f822bd\"}', '2023-06-27 00:14:58', '2023-06-27 00:11:05', '2023-06-27 00:14:58'),
('86a1b603-ba39-447e-87f0-afb28df68942', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:21:48', '2023-04-07 06:21:48'),
('87e162d0-3437-4bf1-8722-ebab2cbe2cdf', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 42, '{\"title\":\"Avinash ak has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/uiux-designer-1681802497-643e450137240\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/uiux-designer-1681802497-643e450137240\"}', NULL, '2023-05-01 23:36:59', '2023-05-01 23:36:59'),
('88e99456-00d5-4645-b46e-d128a9708faf', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/37\"}', '2023-05-31 07:02:14', '2023-05-31 05:15:07', '2023-05-31 07:02:14'),
('8a0a31d0-f333-451e-b01d-5e16a0f1fd0e', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-01 07:43:51', '2023-04-01 07:43:51'),
('8a33acaf-1d86-4e3b-8884-2ffc68131b75', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 90, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:11:01', '2023-06-27 00:11:01'),
('8a6386c8-e459-4339-ba61-97f15d99eb78', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 11, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-03-10 05:12:12', '2023-03-10 05:12:12'),
('8bcc8fe2-b044-49f9-aca5-ae94205a34f6', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 23:48:09', '2023-04-11 23:48:09'),
('8c11400f-6394-4fcf-8771-c10c56b2403b', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 48, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:17', '2023-05-19 04:47:17'),
('8c158fb6-2aed-493b-8621-1435f8f80175', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 44, '{\"title\":\"Jason Vijay has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-05-02 12:22:22', '2023-05-02 12:22:22'),
('8ca7bd4d-1860-42c9-898e-1a1789c016cb', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 47, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\"}', NULL, '2023-05-18 12:18:07', '2023-05-18 12:18:07'),
('8dd62285-c200-4acd-a9ea-b100ced50a8d', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 58, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/accountant-1686639298-648812c267189\"}', NULL, '2023-06-13 01:24:59', '2023-06-13 01:24:59'),
('8eaa5a00-66e7-4663-9c38-34b9c89bf36f', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 12, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/full-stack-developer-1678952814-6412c96e79c8c\"}', NULL, '2023-03-16 02:17:25', '2023-03-16 02:17:25'),
('90576699-f325-490f-b5ab-5e1e0cb8a19e', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:13:24', '2023-04-07 06:13:24'),
('91371599-f371-47a3-8788-0887147be363', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-06 05:41:59', '2023-05-06 05:41:59'),
('92b08bf5-cc27-45f2-922d-1573fa14e17d', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:04:28', '2023-04-07 06:04:28'),
('934895cd-4468-4371-b609-7fcd2471c35e', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-03-29 07:48:08', '2023-03-29 07:48:08'),
('93e7a6c6-472e-4517-834e-311c932c972e', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-11 05:40:24', '2023-04-11 05:40:24'),
('958f9dd3-4ca2-47ef-9911-80e399480e71', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 06:32:08', '2023-04-12 06:32:08'),
('959e6a0a-16de-4517-8b2f-a547828b21f7', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 05:44:37', '2023-04-11 05:44:37'),
('967fc98d-4e01-46b1-8d1b-10bff3ce613e', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 07:34:16', '2023-04-07 07:34:16'),
('971b4461-2e58-4727-bdff-0aa28a42c302', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/38\"}', '2023-05-31 07:02:14', '2023-05-31 06:29:14', '2023-05-31 07:02:14'),
('999e9496-0aea-4cd9-88a3-f4b48ed7ec9b', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-24 01:41:06', '2023-04-24 01:41:06'),
('9b10ed3f-6d1f-4020-8bd9-b03b2aa19afd', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 89, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:11:01', '2023-06-27 00:11:01'),
('9bdb3c09-36b3-4fbd-a5f0-1471c6af9519', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:13:24', '2023-04-07 06:13:24'),
('9d58dabf-3c53-4134-bf67-803a74cd185b', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/3\"}', '2023-03-07 07:29:29', '2023-03-07 06:48:07', '2023-03-07 07:29:29'),
('9f4b58a2-c57d-473f-8ff3-96ccba5e0106', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-14 01:43:03', '2023-04-14 01:43:03'),
('a02e5bea-8af1-4fe9-9853-c9f817dbfe41', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/14\"}', '2023-04-04 01:14:16', '2023-03-31 05:55:01', '2023-04-04 01:14:16'),
('a374aa8e-d463-4c8b-b48b-cdc28267736c', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 2, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', NULL, '2023-03-16 04:06:41', '2023-03-16 04:06:41'),
('a47bcc24-316b-4c29-960b-a823b07b7fe2', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 1, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-03-16 02:46:14', '2023-03-16 02:46:14'),
('a4e4677b-40e7-4e6e-b54f-0ae6356ee01e', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 66, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687761990-64993446ba2f0\"}', NULL, '2023-06-27 00:11:09', '2023-06-27 00:11:09'),
('a6d6d88f-1d32-4658-ac1f-83a8f3c3009d', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 58, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/accountant-1686823247-648ae14fbc3d3\"}', NULL, '2023-06-23 06:20:42', '2023-06-23 06:20:42'),
('a6ed78e5-74f1-4506-9ec3-bd9a2c9ac875', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 00:57:33', '2023-04-12 00:57:33'),
('a88e1ae3-5494-4dc3-88fa-130e00960ec7', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/company\\/29\"}', NULL, '2023-06-27 00:31:38', '2023-06-27 00:31:38'),
('a915e9ed-301a-4250-9ddc-82a485472697', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', NULL, '2023-04-11 05:47:26', '2023-04-11 05:47:26'),
('a9822569-9400-40aa-916d-9119d2f2ed78', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 8, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/forklift-driver-1678529598-640c543e09c2c\"}', NULL, '2023-03-11 04:44:25', '2023-03-11 04:44:25'),
('aa356360-b513-4726-9b3f-76b13a145eee', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-04-19 11:37:08', '2023-04-19 11:37:08'),
('aaede441-c4e8-49e6-a1e0-49084404618e', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/8\"}', '2023-03-11 03:53:57', '2023-03-11 03:27:41', '2023-03-11 03:53:57'),
('acf1406a-341f-45e5-8b55-dec32cfde4fc', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-03-18 01:02:05', '2023-03-18 01:02:05'),
('ada3958c-41b4-4fa4-8631-644711ffbd56', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:34', '2023-05-19 04:47:34'),
('ae00d9eb-c8f6-403f-96a1-271a6f95bf32', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 13, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/sales-person-1678531448-640c5b787056a\"}', NULL, '2023-03-16 01:51:23', '2023-03-16 01:51:23'),
('aea421cc-bbcf-49ff-8d28-97e4d99d285b', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 47, '{\"title\":\"Jason Roy has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-18 12:19:25', '2023-05-18 12:19:25'),
('af9449a0-f233-4784-96b5-f11272d44667', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Ericsson\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-06-01 00:45:45', '2023-06-01 00:45:45'),
('b07a91b7-919d-476e-a4de-43fc013d5134', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 05:41:39', '2023-04-07 05:41:39'),
('b139a0e5-ee34-4ba8-862b-1710c7f4c307', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/candidate\\/46\"}', NULL, '2023-06-26 23:27:47', '2023-06-26 23:27:47'),
('b16ed10b-be96-4e89-915b-4de808c99e82', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-01 07:43:51', '2023-04-01 07:43:51'),
('b2343f12-3fd0-4bc4-a7a1-c1a56c4ecc30', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:35:56', '2023-04-07 06:35:56'),
('b28b943b-9f86-4c12-8e77-e0f38c7f3561', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 53, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:11:01', '2023-06-27 00:11:01'),
('b328051c-351d-4681-b87b-24c7c04c2b37', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 16, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked ash\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/ash\"}', NULL, '2023-04-24 02:32:38', '2023-04-24 02:32:38'),
('b34649cc-3cd3-456d-8695-c1ac730bdf6a', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 12, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/forklift-driver-1678529598-640c543e09c2c\"}', NULL, '2023-03-11 04:44:25', '2023-03-11 04:44:25'),
('b60f2b37-e385-408f-96ef-cadae8308345', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 42, '{\"title\":\"Avinash ak has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Ericsson\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-01 23:36:48', '2023-05-01 23:36:48'),
('b6243a32-a7d9-4ee0-96af-fb6f732815b4', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 88, '{\"title\":\"Josephvijay s has bookmarked you\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/employers\\/Josephvijay%20s\",\"title2\":\"You have bookmarked Muthu\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/candidates\\/muthu\"}', NULL, '2023-06-27 00:16:29', '2023-06-27 00:16:29'),
('b704d5a2-439e-4ddf-8ba6-11000a7b844a', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 2, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', NULL, '2023-04-11 05:47:26', '2023-04-11 05:47:26'),
('b7d8412c-ae0e-431d-a6a1-07c686160890', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 39, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/accountant-1686823247-648ae14fbc3d3\"}', NULL, '2023-06-23 06:20:43', '2023-06-23 06:20:43'),
('b7e30cf7-960e-40f5-849d-d31d3bfa3285', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 58, '{\"title\":\"Amazon has bookmarked you\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/employers\\/vigneshwari\",\"title2\":\"You have bookmarked mathavan\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/candidates\\/mathavan\"}', NULL, '2023-06-17 00:47:47', '2023-06-17 00:47:47'),
('b9635b2a-7901-421a-8cef-b92be7920093', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 2, '{\"title\":\"Ericsson has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/ericson\",\"title2\":\"You have bookmarked vigneshwari jeyaraj\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/vigneshwari%20jeyaraj\"}', NULL, '2023-06-01 01:08:21', '2023-06-01 01:08:21'),
('b99cabd1-4652-49fc-873b-65fb9086a0c1', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 8, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/full-stack-developer-1678952814-6412c96e79c8c\"}', NULL, '2023-03-16 02:17:24', '2023-03-16 02:17:24'),
('b9adc6e1-67e4-4a2f-8234-313a8ce98fdb', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:46:09', '2023-04-07 06:46:09'),
('ba3dc0c8-35fe-4567-bcb9-090e9b7b9d92', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 1, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/manual-testing-1678188523-64071febc6caf\"}', NULL, '2023-03-07 06:00:05', '2023-03-07 06:00:05'),
('bca1cdb0-8f20-4ffe-a583-16aa3b66d2f1', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:21:48', '2023-04-07 06:21:48'),
('bd3bd08a-1c95-4365-80fa-c8875f57e48c', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 13, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/forklift-driver-1678529598-640c543e09c2c\"}', NULL, '2023-03-11 04:44:25', '2023-03-11 04:44:25'),
('c0d7be45-f02c-4061-9869-f444422faa3a', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-18 12:11:53', '2023-05-18 12:11:53'),
('c1d223d0-a12e-4ffe-96a8-24256453319b', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 65, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/node-js-1687521643-6495896bc9505\"}', NULL, '2023-06-23 06:30:50', '2023-06-23 06:30:50'),
('c23cdf7b-f65c-4ea5-aa15-030f39c93364', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-06 05:41:59', '2023-05-06 05:41:59'),
('c5c34da9-d197-4fbe-943b-1a40a76378bb', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 88, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', '2023-06-27 00:14:59', '2023-06-27 00:10:47', '2023-06-27 00:14:59'),
('c7de2ab4-c2ce-4c9c-a725-171d1435f212', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 26, '{\"title\":\"JosePhine has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', '2023-05-24 02:17:44', '2023-05-24 02:13:54', '2023-05-24 02:17:44'),
('c8b52d42-fdbb-4840-8883-1600d4997a6b', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 23:43:10', '2023-04-11 23:43:10'),
('cb9caae8-b255-406b-bf09-dcafb50054ce', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Avinash ak has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\"}', NULL, '2023-05-04 23:52:17', '2023-05-04 23:52:17'),
('cbcd2b65-6f80-4c8f-b895-4d9728ce58e3', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681535044-643a304415788\"}', NULL, '2023-05-02 06:15:07', '2023-05-02 06:15:07'),
('cc489eda-7c78-4774-bfda-d1fbf08262e4', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 7, '{\"title\":\"Happy me has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/front-developer-1681805690-643e517aa28c4\"}', NULL, '2023-04-19 12:13:34', '2023-04-19 12:13:34'),
('ce52cddf-ed06-48de-a8dd-7bde0f63625c', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-11 05:40:24', '2023-04-11 05:40:24'),
('cea1734b-0217-45ca-81e7-cde4aa1bb824', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/7\"}', '2023-03-11 03:53:57', '2023-03-10 05:02:15', '2023-03-11 03:53:57'),
('ced414f1-0668-4db5-a4e6-9ce87e33ff25', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:53:51', '2023-04-07 06:53:51'),
('cef4391a-9145-4d28-ac00-280c4ff28a47', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/13\"}', '2023-04-04 01:14:16', '2023-03-31 05:53:11', '2023-04-04 01:14:16'),
('d0ab8566-d549-4204-b7f8-4d56a3646c0d', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 47, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-18 12:11:53', '2023-05-18 12:11:53'),
('d15a89bd-fcad-4f02-a6b0-456d694ef14f', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-24 01:41:06', '2023-04-24 01:41:06'),
('d182022e-0f32-4165-80a4-af833cdd7bc2', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 58, '{\"title\":\"Muthukumarabs has applied your job\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Amazon\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/company\\/my-jobs\"}', NULL, '2023-06-21 05:59:23', '2023-06-21 05:59:23'),
('d1c9ebe0-a703-4032-b533-a07ca4daf9c7', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-03-29 07:49:36', '2023-03-29 07:49:36'),
('d1dc7d69-6e39-45b9-a7be-48a7a671dc58', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/company\\/10\"}', '2023-06-05 04:07:38', '2023-06-01 02:10:49', '2023-06-05 04:07:38'),
('d23726cb-4c36-4505-a83b-da771297b1cb', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Jason Vijay has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-05-02 12:23:35', '2023-05-02 12:23:35'),
('d2476e33-a83c-464a-830e-ec2910034f5b', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 06:46:09', '2023-04-07 06:46:09'),
('d31bdfce-1e23-41cc-9aeb-1d3db0cdc1a9', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681370483-6437ad7317395\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681370483-6437ad7317395\"}', NULL, '2023-04-14 00:54:32', '2023-04-14 00:54:32'),
('d33a3e37-5fa5-4870-9c31-dba259e311aa', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681370483-6437ad7317395\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681370483-6437ad7317395\"}', NULL, '2023-04-14 00:54:32', '2023-04-14 00:54:32'),
('d3ce1bc7-c158-4060-9f6a-ee02d1c06fc1', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:17', '2023-05-19 04:47:17'),
('d3fbf0d0-0230-4b5b-8d9b-8cf2bd90423c', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-operative-up-to-ps14ph-1678526866-640c49924dc48\"}', NULL, '2023-03-11 03:57:46', '2023-03-11 03:57:46'),
('d457ae2e-6482-447a-9ce0-60b296a46ae1', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 3, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-03-10 05:12:12', '2023-03-10 05:12:12'),
('d525ed1b-4b97-4176-a7b0-845ba47f0856', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 88, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', '2023-06-27 00:14:59', '2023-06-27 00:10:36', '2023-06-27 00:14:59'),
('d5b45e52-f6ff-4aeb-b185-71cc47562f73', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 3, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/flt-driver-1678526594-640c4882adb05\"}', NULL, '2023-03-11 03:54:19', '2023-03-11 03:54:19'),
('d6d14e76-42b1-40b7-9b07-20ed9eab30c4', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Jason Roy has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-18 12:19:25', '2023-05-18 12:19:25'),
('d79b6844-9921-477d-88a6-5a7a1ef19a2b', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-05 01:10:05', '2023-04-05 01:10:05');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('d80cb6d2-f282-4b86-9df6-70810817cdab', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 05:27:20', '2023-04-12 05:27:20'),
('d84022c6-9090-4080-815a-be30b4ff835f', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 2, '{\"title\":\"Vigneshwari jeyaraj has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of Ericsson\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-06-01 00:45:45', '2023-06-01 00:45:45'),
('d92dc23b-e1ae-451d-9917-e4310b9665db', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-07 07:34:16', '2023-04-07 07:34:16'),
('d96f85c3-c4e1-45e0-904d-70fe4cb77281', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 48, '{\"title\":\"Bala kumar has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-19 04:47:19', '2023-05-19 04:47:19'),
('d9c06d61-77a3-4389-b1ad-6379c7c30815', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 65, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/node-js-1687762223-6499352f822bd\"}', NULL, '2023-06-27 00:11:05', '2023-06-27 00:11:05'),
('dbcc5552-7013-474d-ae99-6a7e0e5c9c5c', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 13, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/sales-person-1678531448-640c5b787056a\"}', NULL, '2023-03-16 01:50:54', '2023-03-16 01:50:54'),
('dc4e6d3b-c4be-4e2d-bd81-d8fd29025376', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 4, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/delivery-boy-1678958783-6412e0bfb4caf\"}', '2023-05-23 00:47:03', '2023-03-16 04:06:41', '2023-05-23 00:47:03'),
('dda960cb-5c92-4e56-82b0-b65d4147448a', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-31 01:53:48', '2023-05-31 01:53:48'),
('de30e04f-71eb-41fe-a443-125484eb6e87', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/candidate\\/42\"}', NULL, '2023-06-12 05:32:18', '2023-06-12 05:32:18'),
('df6e8656-6ef3-4b5a-b9c0-9b51f7b18ecd', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 8, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1678444915-640b097356624\"}', NULL, '2023-03-10 05:12:12', '2023-03-10 05:12:12'),
('e0d6e06f-491d-43cc-9a5e-6d561ee08538', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 52, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/bde-1685530980-64772964e028f\"}', NULL, '2023-05-31 05:33:00', '2023-05-31 05:33:00'),
('e19ceb74-3dcb-49bd-b14f-81e20e0b26a6', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 88, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', '2023-06-27 00:14:59', '2023-06-27 00:10:58', '2023-06-27 00:14:59'),
('e270a3bc-328e-4404-a3b4-bdede1944232', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 43, '{\"title\":\"Vigneshwari jeyaraj has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of INFO TECH\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-05-06 05:36:36', '2023-05-06 05:36:36'),
('e5384fd9-e7b2-4f91-b390-1ba78c2f7739', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/company\\/32\"}', NULL, '2023-06-27 00:45:49', '2023-06-27 00:45:49'),
('e54e55fb-253c-4cb1-bf2c-37a390a7a2f9', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 3, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1681470400-643933c009caa\"}', NULL, '2023-04-14 06:16:40', '2023-04-14 06:16:40'),
('e5f21fd9-5020-4943-9908-dc8ef48576d5', 'App\\Notifications\\JobApprovalNotification', 'App\\Models\\User', 58, '{\"title\":\"Admin has approved your job. Your job is live now.\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/node-js-1687521643-6495896bc9505\"}', NULL, '2023-06-23 06:30:50', '2023-06-23 06:30:50'),
('e69e2b51-1a6f-4730-a54e-6d09fa96abd6', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Jason Roy has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/wordpress-developer-1683110509-64523a6dc74d5\"}', NULL, '2023-05-18 12:18:24', '2023-05-18 12:18:24'),
('e7132e69-e4e7-4fbb-9521-729b9731c526', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 65, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', NULL, '2023-06-27 00:10:36', '2023-06-27 00:10:36'),
('e756822b-1ff7-460a-bb61-289abaebc8c5', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 05:27:30', '2023-04-12 05:27:30'),
('e7915ddb-c504-4bc0-a5e6-a62572fbfd33', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-12 05:27:20', '2023-04-12 05:27:20'),
('e7cbbd89-6145-4308-8751-51c4a615b066', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 66, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', NULL, '2023-06-27 00:10:47', '2023-06-27 00:10:47'),
('e8045486-cc35-4da3-8978-79b5c4ede797', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Vigneshwari has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-03-29 07:48:08', '2023-03-29 07:48:08'),
('e87fb73b-1bc6-44cc-9a9e-9d46225a3dfc', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Company registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/company\\/33\"}', NULL, '2023-06-27 23:47:31', '2023-06-27 23:47:31'),
('e8fedaa8-12ae-4aa0-b382-6f8e72c79d73', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 23:43:10', '2023-04-11 23:43:10'),
('ea08c562-f9f7-4836-8503-08363a4bc06c', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 88, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-1687844166-649a7546a7f8a\"}', '2023-06-27 00:07:45', '2023-06-27 00:06:07', '2023-06-27 00:07:45'),
('ea749763-c886-4f23-b0ab-6203b0e3171b', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 89, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:10:50', '2023-06-27 00:10:50'),
('eb84ec1c-47c7-4b0b-971f-6dd6c8944980', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 90, '{\"title\":\"Josephvijay s has bookmarked you\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/employers\\/Josephvijay%20s\",\"title2\":\"You have bookmarked Saravanakumar\",\"url2\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/candidates\\/saravanakumar\"}', NULL, '2023-06-27 00:16:13', '2023-06-27 00:16:13'),
('eb987faf-600b-4ecf-b16a-acfe7c5e4354', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Jason Vijay has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-05-02 12:22:22', '2023-05-02 12:22:22'),
('ed1419bc-5709-4559-b157-8e884c5c8321', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/accountant-1682573048-644a06f82324e\"}', NULL, '2023-04-26 23:54:08', '2023-04-26 23:54:08'),
('ee02fba8-0fa7-4475-8313-20ec8189ac50', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 1, '{\"title\":\"Avinash ak has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/php-developer-1681802581-643e4555dd676\"}', NULL, '2023-05-01 23:40:06', '2023-05-01 23:40:06'),
('ef5dc57a-3ae0-40bd-b31d-6c5ea93f1fc1', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 2, '{\"title\":\"Ericsson has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/ericson\",\"title2\":\"You have bookmarked vigneshwari jeyaraj\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/vigneshwari%20jeyaraj\"}', NULL, '2023-06-01 01:09:57', '2023-06-01 01:09:57'),
('ef678f57-16c3-46bf-b830-9f7a231544e2', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Vigneshwari jeyaraj has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-31 01:53:48', '2023-05-31 01:53:48'),
('efb7de64-51c5-4f81-be07-31bcb8174a31', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 26, '{\"title\":\"Bala has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/quality-analyst-1681804638-643e4d5e7b2c4\"}', NULL, '2023-05-02 12:18:35', '2023-05-02 12:18:35'),
('f4b49401-60ab-4f7d-8ca1-56e94a280e2f', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 16, '{\"title\":\"Ash has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/backend-developer-1681210776-64353d98f1c32\"}', NULL, '2023-04-11 23:47:47', '2023-04-11 23:47:47'),
('f4fbc66f-3ecd-454c-b2a6-c9ecd74b34e1', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/flt-driver-1678526594-640c4882adb05\"}', NULL, '2023-03-11 03:53:14', '2023-03-11 03:53:14'),
('f5492b29-c24f-4ae1-9af3-fea7896e9a52', 'App\\Notifications\\Admin\\NewJobAvailableNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A new job is available for approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/job?title=Laravel%20Developer\"}', '2023-06-05 04:07:38', '2023-06-01 02:58:26', '2023-06-05 04:07:38'),
('f60de98c-ff6e-45eb-9bac-202e49de7a3a', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/junior-front-end-developer-1682075311-64426eaf42edd\"}', NULL, '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
('f6877c07-cb1b-4aed-8691-84888cb0a426', 'App\\Notifications\\Website\\Candidate\\ApplyJobNotification', 'App\\Models\\User', 3, '{\"title\":\"Ash has applied your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\",\"title2\":\"You have applied the job of ORACLE\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/company\\/my-jobs\"}', NULL, '2023-04-13 00:27:47', '2023-04-13 00:27:47'),
('fa7c4e43-8080-4a64-9ef0-9b12261c6cda', 'App\\Notifications\\Website\\Company\\JobCreatedNotification', 'App\\Models\\User', 3, '{\"title\":\"Job has been created and waiting for admin approval\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/content-writer-1678190642-640728320e4e5\"}', NULL, '2023-03-07 06:34:02', '2023-03-07 06:34:02'),
('fafa84f3-2861-4f6b-87e8-92df09314960', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/admin\\/candidate\\/39\"}', '2023-06-05 04:07:38', '2023-06-01 02:01:47', '2023-06-05 04:07:38'),
('fb8b4619-4332-4842-84b5-3ae5ebb5c308', 'App\\Notifications\\Website\\Company\\CandidateBookmarkNotification', 'App\\Models\\User', 11, '{\"title\":\"ORACLE has bookmarked you\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/employers\\/test-support-company\",\"title2\":\"You have bookmarked Martin luna\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/candidates\\/testcandidate\"}', NULL, '2023-04-26 04:25:02', '2023-04-26 04:25:02'),
('fcc020c5-c659-44b0-85ec-034c4b6a4689', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 53, '{\"title\":\"New job posted suiting your profile\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/jobs\\/laravel-developer-1687779026-649976d2caac1\"}', NULL, '2023-06-27 00:10:50', '2023-06-27 00:10:50'),
('fce83027-50a8-4b3a-ac1c-1299945091f0', 'App\\Notifications\\Website\\Candidate\\RelatedJobNotification', 'App\\Models\\User', 12, '{\"title\":\"New job posted suiting your profile\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/warehouse-operative-up-to-ps14ph-1678526866-640c49924dc48\"}', NULL, '2023-03-11 03:58:20', '2023-03-11 03:58:20'),
('fced3504-5681-4c25-a035-edc9f9a8b573', 'App\\Notifications\\Admin\\NewUserRegisteredNotification', 'App\\Models\\Admin', 1, '{\"title\":\"A Candidate registered recently\",\"url\":\"http:\\/\\/localhost\\/Saravanan\\/jobstar\\/public\\/admin\\/candidate\\/43\"}', NULL, '2023-06-21 05:07:19', '2023-06-21 05:07:19'),
('ffa36ff3-0740-4a4d-8065-a3b46c601a65', 'App\\Notifications\\Website\\Candidate\\BookmarkJobNotification', 'App\\Models\\User', 15, '{\"title\":\"Vigneshwari has bookmarked your job\",\"url\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\",\"title2\":\"You have bookmarked a job\",\"url2\":\"https:\\/\\/jobstar.abservetechdemo.com\\/jobs\\/web-designer-1678954473-6412cfe97ad84\"}', NULL, '2023-04-01 07:55:41', '2023-04-01 07:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00775d6bfc4b70ea2abb908c7447c384d54e97639b3c66990b7479a4fdbfd63d8deeb57bd5ffab9c', 16, 1, 'authToken', '[]', 0, '2023-04-11 05:21:48', '2023-04-11 05:21:48', '2024-04-11 10:51:48'),
('07d2f9f77bccbc00a6cea1e0cfb2d4ab454abc627eb6b7eace3f8dcf051c9646cd981fb2fec7b16f', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:41:54', '2023-06-17 05:41:54', '2024-06-17 11:11:54'),
('084af1f633dac56abf6fc24a0cba53aa414991bd4314a89cf5ed2489f69c349182ff51d3ac99adff', 40, 1, 'authToken', '[]', 0, '2023-04-16 23:58:22', '2023-04-16 23:58:22', '2024-04-17 05:28:22'),
('09e19cb0c6653cb5f79e50d642f451009c03a29a8a154d3a2c32ba323edec5e9a1040636f1f36932', 38, 1, 'authToken', '[]', 0, '2023-04-13 02:40:25', '2023-04-13 02:40:25', '2024-04-13 08:10:25'),
('0a5609c3ff42977db6e85c05def3392bb89975ef8f10e6eb8c9228c423d3fbbc0947b59ead4ec15a', 4, 1, 'authToken', '[]', 0, '2023-05-02 08:35:03', '2023-05-02 08:35:03', '2024-05-02 14:05:03'),
('0a75edd5f1d3395d27d794a2f7ec871f89629cd36b3685038906e23835bf76b0b7c3b13af9679cc8', 38, 1, 'authToken', '[]', 0, '2023-04-14 02:16:26', '2023-04-14 02:16:26', '2024-04-14 07:46:26'),
('0e4dbb49f8d612e7e10f43240315ff009d60770a2bfa90e0f7445d196d6d4e23fe831e354fdb749b', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:29:48', '2023-04-07 00:29:48', '2024-04-07 05:59:48'),
('0f76b83419c6b6e7379d77d9cd69a796925b111dccfd6961b33e5c5efac4878f1949d1907998f140', 16, 1, 'authToken', '[]', 0, '2023-04-07 07:37:09', '2023-04-07 07:37:09', '2024-04-07 13:07:09'),
('1167a5f0768f90dabc06958ec350870cf925a76ebf0a7d8f119a88764efb45923c37e0866e55d9c4', 4, 1, 'authToken', '[]', 0, '2023-05-04 05:14:16', '2023-05-04 05:14:16', '2024-05-04 10:44:16'),
('123e4cf3f5670e18ec33eaf10b2fcfc714a860815a74a17e3bc8fa3cc7f30f464b628f3ee3bf1130', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:04:31', '2023-04-07 05:04:31', '2024-04-07 10:34:31'),
('12c7cb53d8c36e8523151ca3622d98d7f1c1aeec4729404c1070f9ea930f04070cd506ac77e276e6', 66, 1, 'authToken', '[]', 0, '2023-06-21 05:07:36', '2023-06-21 05:07:36', '2024-06-21 10:37:36'),
('14147aba080fee8e4e98b8b8e05600c491636f6ff59d2b099f2d015aebf02e023ddd939658bbefcb', 16, 1, 'authToken', '[]', 0, '2023-04-05 07:33:15', '2023-04-05 07:33:15', '2024-04-05 13:03:15'),
('142009d5c776a4bd204c74b4332feb2618e694b8241b5d6049df884e1061f1ebdc1371f1d461cc85', 38, 1, 'authToken', '[]', 0, '2023-04-17 06:13:26', '2023-04-17 06:13:26', '2024-04-17 11:43:26'),
('143f2ac545f61f731d1187d44171623fe25bb7bda1c85a61ec9a9c19a960a37c98e43a15ca62a261', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:21:02', '2023-04-07 00:21:02', '2024-04-07 05:51:02'),
('14986dbff039b0132e0a47973c64dfeb5adbd32c70181ffd8e2c23ca2f21fb7e7c520c930d73a098', 4, 1, 'authToken', '[]', 0, '2023-04-15 05:31:13', '2023-04-15 05:31:13', '2024-04-15 11:01:13'),
('16f912a685630be30402c5207312f241e369d7db98bc6a46858406ce05257a2e4f290cd8b0369ee9', 26, 1, 'authToken', '[]', 0, '2023-04-18 00:43:52', '2023-04-18 00:43:52', '2024-04-18 06:13:52'),
('18fed285013fff797168d09c473f3c363a0629d5782768d1bfdd3d65ee615123097f62509c9ac9cf', 65, 1, 'authToken', '[]', 0, '2023-06-22 05:43:51', '2023-06-22 05:43:51', '2024-06-22 11:13:51'),
('19d5cde9f4820bcab11d2af1b166fca4a12c806c138f7058dcdf5a9f041b0b89f5529a278ee70834', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:29:09', '2023-04-07 05:29:09', '2024-04-07 10:59:09'),
('1a9c2f7e8735f99eab394d3fe11a968ce4ff13bf2790a611e08aaef8da3f386561ab84bae112cabe', 58, 1, 'authToken', '[]', 0, '2023-06-16 23:01:22', '2023-06-16 23:01:22', '2024-06-17 04:31:22'),
('1c5221fb1e33de06f0609c588a8b753b87a3a82ee82ff63949bd7e32136b185a3ccb160ee076374a', 43, 1, 'authToken', '[]', 0, '2023-05-07 23:50:58', '2023-05-07 23:50:58', '2024-05-08 05:20:58'),
('1ced6ab57ad4a51814297526ad8062533d1a2ccb209af577ed68654f7013aa2124b862e00c5d722e', 64, 1, 'authToken', '[]', 0, '2023-06-22 01:55:04', '2023-06-22 01:55:04', '2024-06-22 07:25:04'),
('1d2d1598faf8d62694e87b374caeb50fbb1c3b75e6194c8fd237a93c8ba4e2fc5e9fa0297ba6a83a', 16, 1, 'authToken', '[]', 0, '2023-04-06 04:51:20', '2023-04-06 04:51:20', '2024-04-06 10:21:20'),
('1deb8192633015b97180579c198c9d855c36e9f12d8d43426b9f4bec113040b5813cbe9ac8ac44eb', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:53:19', '2023-04-07 06:53:19', '2024-04-07 12:23:19'),
('1ee134d4612e2bcadd8a198b66301111df2a1ddbc62444011385ad7202ca4f5ea32cb32382af59b2', 16, 1, 'authToken', '[]', 0, '2023-04-05 01:40:57', '2023-04-05 01:40:57', '2024-04-05 07:10:57'),
('1f1e8d85856527a0df9ebf4e2537dd4bf05c60c9c9570c9a2096a9cea0da4673a6b25fe71e67c683', 16, 1, 'authToken', '[]', 0, '2023-04-06 08:02:37', '2023-04-06 08:02:37', '2024-04-06 13:32:37'),
('1f718559b0b381ebbe67afd0a6ef6e79b637478cd67a3c327e409b2d5184e364b3f9f3a0376989b9', 40, 1, 'authToken', '[]', 0, '2023-04-19 23:31:45', '2023-04-19 23:31:45', '2024-04-20 05:01:45'),
('1f747f945e5df50594b0dcf7fddb63f9f08a9a5db6491d672c0cba40f4446411f6ba511f59202d8f', 16, 1, 'authToken', '[]', 0, '2023-04-05 07:21:57', '2023-04-05 07:21:57', '2024-04-05 12:51:57'),
('1ffe310b48636b70d847989d34f9f5af65d4b22b2095e51248a49e1053d944429104b4b0b935ca9d', 64, 1, 'authToken', '[]', 0, '2023-06-22 03:52:36', '2023-06-22 03:52:36', '2024-06-22 09:22:36'),
('210e3b988102e85cb1d183c717a0ba062da2e37057617c4f7f2e321893696ff59db6d06b8e965817', 58, 1, 'authToken', '[]', 0, '2023-06-15 01:37:35', '2023-06-15 01:37:35', '2024-06-15 07:07:35'),
('21906942bb96d243b0562176f254829befea0989bd55e5f4b4d8503ef0a6d4979ea77470a70fe85a', 23, 1, 'authToken', '[]', 0, '2023-04-10 00:28:01', '2023-04-10 00:28:01', '2024-04-10 05:58:01'),
('2205aa693de505419bdb0873e9054bb08294f31426268aac27e312ee5ad3af8a00ec146a1a26280d', 16, 1, 'authToken', '[]', 0, '2023-04-07 07:33:05', '2023-04-07 07:33:05', '2024-04-07 13:03:05'),
('2247a504f47eef108922c5f4c84c25ce318d7397c8c0cc589f95cf0a3a482f1e1b3b81d4632f9608', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:56:37', '2023-06-17 05:56:37', '2024-06-17 11:26:37'),
('233c4c915899593403eb4309028a84c19b7ce2de0c7f1dc8dd020fb4d50273e06229f2dcddd6e422', 48, 1, 'authToken', '[]', 0, '2023-05-19 04:46:02', '2023-05-19 04:46:02', '2024-05-19 10:16:02'),
('23fc5c11cd9da39a3bda35a97a1e61a80574f1ffc1e2b08a14ef536c46dab112d2ed618f45e20de8', 16, 1, 'authToken', '[]', 0, '2023-04-13 05:22:58', '2023-04-13 05:22:58', '2024-04-13 10:52:58'),
('2535a9d24e9306947cadccfebf65be5f04678e07963a802e8d85b65a9fba7027024f46f11ae813f4', 4, 1, 'authToken', '[]', 0, '2023-05-07 23:46:41', '2023-05-07 23:46:41', '2024-05-08 05:16:41'),
('264484e9ea7cb9642a3fc829a69c0218538694ceb15118251bc63312b0cbbc033cb88bf48f8473dd', 11, 1, 'authToken', '[]', 0, '2023-03-21 01:17:45', '2023-03-21 01:17:45', '2024-03-21 12:17:45'),
('2718c621ba10f6c9c33cdeed9307c51f0c7fddeef35384a1d07013b7d55bc5502d2060266cc5431e', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:38:27', '2023-04-07 05:38:27', '2024-04-07 11:08:27'),
('2b54e6ef9a0e8b241c10b135afb05998723674de6a1c094ca7231c90b95adf157efc56540497993f', 16, 1, 'authToken', '[]', 0, '2023-04-05 07:29:47', '2023-04-05 07:29:47', '2024-04-05 12:59:47'),
('2b7eb411184f3f06d40b0001eb4961ec997bc6d5512ab460a9707b3074e585008f129ef1bbc71db2', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:45:22', '2023-06-17 05:45:22', '2024-06-17 11:15:22'),
('2cbd7cde1bef7786040056eabd256ec9e685da1777f87ce76a7e3e81d4341d955116269ee8ae8639', 16, 1, 'authToken', '[]', 0, '2023-04-06 02:19:44', '2023-04-06 02:19:44', '2024-04-06 07:49:44'),
('2d93f10e514d5873988c9e50c1fe59b974156fb261fbe3d99b1fcdae75aeeeaaae6c8ad27149b790', 16, 1, 'authToken', '[]', 0, '2023-04-11 23:47:25', '2023-04-11 23:47:25', '2024-04-12 05:17:25'),
('2e10516f5a9da737f6e0dd8336df127c0a226483a08d8941f6f5a66da13411b329d91de842793bf3', 4, 1, 'authToken', '[]', 0, '2023-05-31 02:15:54', '2023-05-31 02:15:54', '2024-05-31 07:45:54'),
('2e4a56a7c75daeba5ba0272009a2d506a87f63e67f702ab26ab8763a8b88f243bf20fbf1a1ccbb9b', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:03:11', '2023-04-07 06:03:11', '2024-04-07 11:33:11'),
('2e5d82ec754525bfe8b17f4680e2b8f0b16ae447e337495cec62112b73bcc65c70b1bd9923242819', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:29:28', '2023-04-07 06:29:28', '2024-04-07 11:59:28'),
('2f114328e4f6bd8d934f3b608e650cd208a2e0f24a034115f4200e04e168fc3c53e30871c5baeaec', 43, 1, 'authToken', '[]', 0, '2023-05-11 00:44:22', '2023-05-11 00:44:22', '2024-05-11 06:14:22'),
('2fb6a51718589982bb260ea8484c04793d5d0a450578524961f0dcea37a4829b63b2061eece99131', 16, 1, 'authToken', '[]', 0, '2023-04-06 07:58:17', '2023-04-06 07:58:17', '2024-04-06 13:28:17'),
('3051825831458accaa4498be51ad7eccaa84869aae80711eca9e2073dd92f1df27f8777279c1b2de', 42, 1, 'authToken', '[]', 0, '2023-05-03 04:02:19', '2023-05-03 04:02:19', '2024-05-03 09:32:19'),
('30b1e8d6b094a46a72350a174bf7de472e0458aa6fc1ce51893a2c61d48bcc222f9c763073a01dd1', 16, 1, 'authToken', '[]', 0, '2023-04-11 00:41:26', '2023-04-11 00:41:26', '2024-04-11 06:11:26'),
('30b250cb04f4705e1a9901e96ad00a26f4925fa95a2c003ec7caf6f01fe6a7f74c500f46d2a3e8bc', 16, 1, 'authToken', '[]', 0, '2023-04-05 01:58:41', '2023-04-05 01:58:41', '2024-04-05 07:28:41'),
('31bbd4e813ef3cc04aa58edaebb667c139181deaada3cab193e07c367b5505396532800b6f4e2249', 16, 1, 'authToken', '[]', 0, '2023-04-12 00:40:44', '2023-04-12 00:40:44', '2024-04-12 06:10:44'),
('33dd17af5200e23629c86b5c4a3d91f6d886619b773815ca5104bcd7f08f785a3397ccdf7c1fd7d0', 39, 1, 'authToken', '[]', 0, '2023-04-20 00:19:42', '2023-04-20 00:19:42', '2024-04-20 05:49:42'),
('340ead76cd54be9e2b53c15dc0c4393c62d186e6e3a8bc009b9f15dea1bc6531afc286e521c3d52e', 64, 1, 'authToken', '[]', 0, '2023-06-21 02:40:17', '2023-06-21 02:40:17', '2024-06-21 08:10:17'),
('34236955989019ecf2b5382659597cc6d28b33fb54231d83065f28a6d0ba677763b9ad0eabf2ae93', 58, 1, 'authToken', '[]', 0, '2023-06-17 04:25:37', '2023-06-17 04:25:37', '2024-06-17 09:55:37'),
('34ee5f1561aa64fd8a2647662a9c4ebf875711acbdb945d2e0b13e660086053e3cb45bf2ee912608', 16, 1, 'authToken', '[]', 0, '2023-04-10 01:35:38', '2023-04-10 01:35:38', '2024-04-10 07:05:38'),
('3579c5b135aa302b58041f1c87e5be664b66c13c88e9a944fa56ee88a073c5e543fe8f783deb4c96', 16, 1, 'authToken', '[]', 0, '2023-04-11 00:34:44', '2023-04-11 00:34:44', '2024-04-11 06:04:44'),
('35efdd16a1fd8c310facbf7274680166be2781fc1a8a371c5424e8e8b1be8daaef74599db2717db6', 64, 1, 'authToken', '[]', 0, '2023-06-20 23:37:50', '2023-06-20 23:37:50', '2024-06-21 05:07:50'),
('363c07f81d2e58681be934443caa3a31f35d89b9c58ac54febbcab8e7da433820e916e4577b6c3b3', 85, 1, 'authToken', '[]', 0, '2023-06-22 03:22:31', '2023-06-22 03:22:31', '2024-06-22 08:52:31'),
('36af4f6d5aa1c039e4fdf5402d446e1fedb5b3c42d40ae37085962b00a77a392a33bbf8e9d2273aa', 11, 1, 'authToken', '[]', 0, '2023-03-21 23:12:20', '2023-03-21 23:12:20', '2024-03-22 10:12:20'),
('37ff7adcf9e106ffdcd18c51de4e5741455844636f26af3a0df860b2ebd671927c8f7e4d7b71f40b', 58, 1, 'authToken', '[]', 0, '2023-06-14 01:43:33', '2023-06-14 01:43:33', '2024-06-14 07:13:33'),
('3896dc28f6d42700611482ce909a69dda1340013c24a432d5cf92b50dcf74dc37050f637a896eda7', 60, 1, 'authToken', '[]', 0, '2023-06-13 01:38:45', '2023-06-13 01:38:45', '2024-06-13 07:08:45'),
('3b1241c5af0d7061fcd3032ec81a53b1b0876e7400145b113ed088a908832c822441a241b90b3e45', 24, 1, 'authToken', '[]', 0, '2023-04-10 04:34:20', '2023-04-10 04:34:20', '2024-04-10 10:04:20'),
('3b9681ce4ba4302b2117b4e19063219bcec911842d7eb3af55ee73fb5118adb53feb2c3058de8183', 16, 1, 'authToken', '[]', 0, '2023-04-07 02:10:01', '2023-04-07 02:10:01', '2024-04-07 07:40:01'),
('3c36ea40971535e6d22524ca74ead50e180a6e68a59b7f1f483f581b0631d20ea248985071961b1c', 16, 1, 'authToken', '[]', 0, '2023-04-12 00:38:44', '2023-04-12 00:38:44', '2024-04-12 06:08:44'),
('3ce89cb18f4c2895c38b4e458ed7d3d08690bcb1817d9d62b72a3d8fd663e7d947c7fd09edc5f100', 16, 1, 'authToken', '[]', 0, '2023-04-10 00:56:59', '2023-04-10 00:56:59', '2024-04-10 06:26:59'),
('3dafd1c7087ce11dc7c0603b4ab66d85b92d387bf87d153a00634535885f7c5caba35d0008fe5005', 11, 1, 'authToken', '[]', 0, '2023-03-21 23:21:07', '2023-03-21 23:21:07', '2024-03-22 10:21:07'),
('3f090e74b12ca19a32b925caab7327e7cc795c89ae70bad0684da23a1281ab4eddb35b02c1acc421', 46, 1, 'authToken', '[]', 0, '2023-05-08 02:21:48', '2023-05-08 02:21:48', '2024-05-08 07:51:48'),
('3f7f2b56954a87c1f9e13ed5dd9e554fe65313daa3e355ab90745755e495175d66bc5c1b1fb4e82b', 16, 1, 'authToken', '[]', 0, '2023-04-12 06:47:14', '2023-04-12 06:47:14', '2024-04-12 12:17:14'),
('400ddd1518ab2f74a4617ea6533d158ad64aa93ef5d9c8f66cf45c021a8fab7b3f44a1b970180a30', 64, 1, 'authToken', '[]', 0, '2023-06-20 23:42:20', '2023-06-20 23:42:20', '2024-06-21 05:12:20'),
('408f77134b48c17bab0850daeec1bf575e410ae86f30958630e48feca92b13beee79e06e6305ca47', 58, 1, 'authToken', '[]', 0, '2023-06-15 01:23:35', '2023-06-15 01:23:35', '2024-06-15 06:53:35'),
('40cba3789008ffaa7b089f7660d88393567e7bd21fe0120bac3fa0a62532bcfd2d37e4dbe9209bca', 16, 1, 'authToken', '[]', 0, '2023-04-11 05:20:50', '2023-04-11 05:20:50', '2024-04-11 10:50:50'),
('419665b972fd77ab1d4937e4513e5b2b75f134438dce55ec49c0c329c188eae907bc58a2093990fc', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:56:43', '2023-06-17 05:56:43', '2024-06-17 11:26:43'),
('427b33e3ceac60ca0f1be364593a9de2e31d3f021fe4ede832ad56ee6829ff0bd6d42aa07fe43c3d', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:10', '2023-05-02 23:32:10', '2024-05-03 05:02:10'),
('431fc36ece1920f7258af24eff816800f96dda04c14862113b24c3aba0cb7218ebcda875a5cc98c2', 16, 1, 'authToken', '[]', 0, '2023-04-12 05:28:41', '2023-04-12 05:28:41', '2024-04-12 10:58:41'),
('462e7f2fedcc25123e5a9e314f10677cdfa8f47565a73c1df95331fd7bbcd875d4e2aa6635d37950', 16, 1, 'authToken', '[]', 0, '2023-04-12 06:43:06', '2023-04-12 06:43:06', '2024-04-12 12:13:06'),
('468db01789627edc9fc8e5374dfe18bc396f3319ea6d8709a792f92f3e9b64262e7d6d9738725a8d', 40, 1, 'authToken', '[]', 0, '2023-04-19 11:35:56', '2023-04-19 11:35:56', '2024-04-19 17:05:56'),
('488a2ab02c779a08f35ee14dd4ac4dc2046ec02df9712cd6a9f5ec4285432304cb901501fc8f8aca', 16, 1, 'authToken', '[]', 0, '2023-04-06 23:47:15', '2023-04-06 23:47:15', '2024-04-07 05:17:15'),
('48f5499cc8f18b150bfc0e8bb09229b5fb456e5d134fb92a9b523d30b216a95efd22b72223fcea23', 16, 1, 'authToken', '[]', 0, '2023-04-06 23:07:13', '2023-04-06 23:07:13', '2024-04-07 04:37:13'),
('491357ca9cd7c91d91717be470e63120b194c6d43f871993b31aa39f234594266d97e831cce31ad2', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:47:18', '2023-04-13 00:47:18', '2024-04-13 06:17:18'),
('491733cf0022c5b1ffed4c5b7fbcec2e3d449793becc79c3594ea82cc670da063315c8f4363f7456', 16, 1, 'authToken', '[]', 0, '2023-04-06 04:56:11', '2023-04-06 04:56:11', '2024-04-06 10:26:11'),
('494a8239e4896ef1ab7e12ee32b609664654a1031a38efa33174c3a69f88ff7d7898935c69da682a', 16, 1, 'authToken', '[]', 0, '2023-04-07 01:41:11', '2023-04-07 01:41:11', '2024-04-07 07:11:11'),
('49e26b0fe14f3d4b03225d4095c5ab096a77f4561d14f4ca80864d7f1d3167676062604e390b9201', 16, 1, 'authToken', '[]', 0, '2023-04-12 06:44:11', '2023-04-12 06:44:11', '2024-04-12 12:14:11'),
('4a587a14ffd25ccc0873a6c51ab34360c334d032f8058d64e48975ac11a67681bc7a05ddfaea6fea', 37, 1, 'authToken', '[]', 0, '2023-04-17 01:29:37', '2023-04-17 01:29:37', '2024-04-17 06:59:37'),
('4afe605f4dbb2014441efe362bb72a204b7bb5c0f7c944a50f11e4315b8906785f1cd4b805cb9e8f', 16, 1, 'authToken', '[]', 0, '2023-04-15 02:19:18', '2023-04-15 02:19:18', '2024-04-15 07:49:18'),
('4c789037becea1a764fb546d69a79a127e7cf1802b833b0831b967b6535bb8e07bc9840ee8ca2a36', 11, 1, 'authToken', '[]', 0, '2023-03-21 01:26:32', '2023-03-21 01:26:32', '2024-03-21 12:26:32'),
('4e359056eef39ae4e3239e3008020e84c44c9791a47856bb962cf8376ac7f6b07a2bd4d0ea747e80', 40, 1, 'authToken', '[]', 0, '2023-04-19 23:37:32', '2023-04-19 23:37:32', '2024-04-20 05:07:32'),
('4fc584d60a9d4af464e4fc3e8a93e4c1296e851434038e1539670d303543d74314cf8a3ed0483385', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:11', '2023-05-02 23:32:11', '2024-05-03 05:02:11'),
('51347cc7b19f04f12c73e49134d392ac8a62451e325a00fb14a71746a9c0640b3d107da75e3afa91', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:10', '2023-05-02 23:32:10', '2024-05-03 05:02:10'),
('517414058c490b334364035c8e0ec747e032dd08e35bfc56df7f3250618246494fa388d79694a0f9', 64, 1, 'authToken', '[]', 0, '2023-06-20 23:17:50', '2023-06-20 23:17:50', '2024-06-21 04:47:50'),
('51f30a1f9640301fc238bfc8dc6116eddbb8c93d1c48ec7a39bc0651c6f3a98d661a5d309bdf3798', 64, 1, 'authToken', '[]', 0, '2023-06-21 23:36:25', '2023-06-21 23:36:25', '2024-06-22 05:06:25'),
('522e755252b324939a08be4d9ab0836ce5805a88b8cba33d5e496eaa4af00b9df0b1902eb86499ec', 64, 1, 'authToken', '[]', 0, '2023-06-17 07:46:20', '2023-06-17 07:46:20', '2024-06-17 13:16:20'),
('52aec5542cf078edc79b2cc01e4a06253ecac3fe55df2ee7f697abaaebdbd5a53d4f47ffa9776eda', 16, 1, 'authToken', '[]', 0, '2023-04-12 06:30:53', '2023-04-12 06:30:53', '2024-04-12 12:00:53'),
('5315bc6b538180f702d94238bd3b55304890288cfbc74182fe5c2af88e983b4ebfbae7e182ab475d', 16, 1, 'authToken', '[]', 0, '2023-04-12 00:19:18', '2023-04-12 00:19:18', '2024-04-12 05:49:18'),
('54612d59785625c63f7f2fdca5e1e93b61bd8f6591e15e0a81104747aa635813b4ae5f43ac45bf4e', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:46:56', '2023-04-07 05:46:56', '2024-04-07 11:16:56'),
('5520b73994bf734dfaab08df277eaf11aee546e2e6d84e769c040574a1f32dfce031ffa4c498828a', 64, 1, 'authToken', '[]', 0, '2023-06-22 06:45:07', '2023-06-22 06:45:07', '2024-06-22 12:15:07'),
('5563fdc991859b5563a7006080e754ae27a5da2de68cc1d35ee0943a5ab2984a136b6fa94b753176', 16, 1, 'authToken', '[]', 0, '2023-04-06 07:59:59', '2023-04-06 07:59:59', '2024-04-06 13:29:59'),
('556b93a1eaab0836222177dd7bb33bd0fb62fa62c73da6c824ad8e16c8851a834b2aed3c602cba07', 1, 1, 'authToken', '[]', 0, '2023-06-13 00:14:36', '2023-06-13 00:14:36', '2024-06-13 05:44:36'),
('55759e7ddc27efa81c51025c73bab7924b478955272b20380ee25a9d4d918c8c11c17c84e407fae6', 16, 1, 'authToken', '[]', 0, '2023-04-11 23:45:55', '2023-04-11 23:45:55', '2024-04-12 05:15:55'),
('558dffde37575f2497f0496db92c8be1577ad8da18c5dc61c6c754a5bba4f3569b1ef0d3aa664536', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:05:54', '2023-04-07 06:05:54', '2024-04-07 11:35:54'),
('579a307e67ea2c8f75b99e85b4481be4e56e992a8a54414755397b52213d9848e5e6ce815e64232d', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:09', '2023-05-02 23:32:09', '2024-05-03 05:02:09'),
('58679ec8ca8e14df66c66bbb4805cb5d0acad8bafcdb9f08db81fead8fbd5df9bd3d4d67b879a116', 25, 1, 'authToken', '[]', 0, '2023-04-10 04:05:05', '2023-04-10 04:05:05', '2024-04-10 09:35:05'),
('589ad54ba641e82bc055e21d5668f0b67d60796abee0375cb493642f7edc996500b73c7bc8b449b9', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:10', '2023-05-02 23:32:10', '2024-05-03 05:02:10'),
('59a7e33f31086b8df4328c308a91a3c4394066aaeea710bc7d3c08983994e0781574dd48756dfbeb', 16, 1, 'authToken', '[]', 0, '2023-04-05 01:44:26', '2023-04-05 01:44:26', '2024-04-05 07:14:26'),
('5a6f6362f6a0e6d7986e9c9414100bdabc8312c75c5c92261c65e9214d5f08b6ebf2f42d105e878a', 44, 1, 'authToken', '[]', 0, '2023-05-02 12:21:35', '2023-05-02 12:21:35', '2024-05-02 17:51:35'),
('5b8d1efaa6a5484892738afa5f175ea1b556f2288bd640c9dba0fea71ab809fb3d15861d49449a88', 65, 1, 'authToken', '[]', 0, '2023-06-28 01:27:41', '2023-06-28 01:27:41', '2024-06-28 06:57:41'),
('5dfd26e16b2adca5af425d57a73e3d738c1550cc3ed84197b22f3506d9fdcc02ff6e33f33dca80c1', 16, 1, 'authToken', '[]', 0, '2023-04-11 05:37:20', '2023-04-11 05:37:20', '2024-04-11 11:07:20'),
('5e1abd14d73660a089cb8d9609f9c443a11d98e5ff610e9d8262d92952f64b5a3e076382a90ff996', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:23:09', '2023-04-13 00:23:09', '2024-04-13 05:53:09'),
('5e9c0de5e24e0c86411a4ccc2654c7a3ca588819df041d934c0ba90b0df89f3cd683e6b4f183d649', 16, 1, 'authToken', '[]', 0, '2023-04-05 07:35:33', '2023-04-05 07:35:33', '2024-04-05 13:05:33'),
('5eb1f81dc69f45ce7d510a4b963b0d771b898b514de0228968414aac1e1c68361a8f4da48904a811', 42, 1, 'authToken', '[]', 0, '2023-05-04 05:20:08', '2023-05-04 05:20:08', '2024-05-04 10:50:08'),
('600f5ed2f74fc15e51aeb5f4e4ca7ba1a10c2edaa98b61f808ece547493f3b16c7f1916493150d7b', 39, 1, 'authToken', '[]', 0, '2023-04-18 07:46:16', '2023-04-18 07:46:16', '2024-04-18 13:16:16'),
('6056b4c1ce0c309f6dd24cbe941afe1d008e97890a471839f0d3105afc991ebe671fd4f75e4ceba6', 43, 1, 'authToken', '[]', 0, '2023-05-04 05:43:35', '2023-05-04 05:43:35', '2024-05-04 11:13:35'),
('6265409f73e7d981b973a047be9c49654df3b188a3599c3e34a6017166cc9dfe3b472fae92215ab9', 11, 1, 'authToken', '[]', 0, '2023-03-21 23:09:27', '2023-03-21 23:09:27', '2024-03-22 10:09:27'),
('63638622ac997c8509865b8cedf1dcd4173a447552aed9ac5a063365e60e054b95d76f54b8baa59b', 16, 1, 'authToken', '[]', 0, '2023-04-06 08:07:09', '2023-04-06 08:07:09', '2024-04-06 13:37:09'),
('63bade482392b91632b5ab22ec3ada0c664ebb75bce82187c67a475e36473b15b183c2b0dce8ac79', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:01:59', '2023-04-07 06:01:59', '2024-04-07 11:31:59'),
('64522aeebe81cb74e8d9c8e5174e0d839363a05a09df7a925d07446e413d6da3f4014224070c36b3', 42, 1, 'authToken', '[]', 0, '2023-05-01 22:59:25', '2023-05-01 22:59:25', '2024-05-02 04:29:25'),
('64d2ba2d0955b5237e8eb3e0ff918aada4fa1af999d9fbf3fa4da472cb3d71e3a4b5e6b121d39566', 43, 1, 'authToken', '[]', 0, '2023-05-04 02:06:44', '2023-05-04 02:06:44', '2024-05-04 07:36:44'),
('6522ea4d62929f3bbd651b85607bf75bdc15812c97b6399266f18182d3798b00ac8c820b051870e5', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:16:22', '2023-04-07 00:16:22', '2024-04-07 05:46:22'),
('65a8700ee0d7f12f1a2be9725c476322e85869caa13e76e9bfd612168f3f43528ef729643edc7a47', 16, 1, 'authToken', '[]', 0, '2023-04-06 04:46:16', '2023-04-06 04:46:16', '2024-04-06 10:16:16'),
('66d69f22706851a97417384e82e69cbc6cd012e12d1582ead9b530863ca62593d79f8c2d493cade5', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:09:29', '2023-04-13 00:09:29', '2024-04-13 05:39:29'),
('66e410966d2b1f1d886e6af1c233aeb57941ecbe593a693972b06d279e3d8dce0ddae7a2eee6d612', 16, 1, 'authToken', '[]', 0, '2023-04-07 02:05:00', '2023-04-07 02:05:00', '2024-04-07 07:35:00'),
('66eceff7640894fee3f778ed66ca8b9a2a068687fbf31d957993d3b7b7738069cd7113da3bdb7875', 16, 1, 'authToken', '[]', 0, '2023-04-12 06:14:06', '2023-04-12 06:14:06', '2024-04-12 11:44:06'),
('6706f86cc4f605d5eee01472fc5e5217c2af0baa1e196ee9d788d01bb14614ee48ab93636a9086a4', 11, 1, 'authToken', '[]', 0, '2023-03-21 23:28:28', '2023-03-21 23:28:28', '2024-03-22 10:28:28'),
('672ac3a215c71ac4263927a4e15cb63fcd444f9e9983ce99bedecf56c730473b174c00fcf5466fff', 42, 1, 'authToken', '[]', 0, '2023-05-18 11:32:19', '2023-05-18 11:32:19', '2024-05-18 17:02:19'),
('67b2868d8ff6d8dd5882c0207bf7a1ca2a1e75a9e9343045cf545d1824cd0b495254ce5fca2a8af5', 40, 1, 'authToken', '[]', 0, '2023-04-20 00:04:58', '2023-04-20 00:04:58', '2024-04-20 05:34:58'),
('682c73ed3ca42722b1c9b3b88ff2feb883929e4ba5f7b1f6293cf8a1de5cc0d09a5ad0136c1af542', 64, 1, 'authToken', '[]', 0, '2023-06-20 23:42:43', '2023-06-20 23:42:43', '2024-06-21 05:12:43'),
('6858302f3233770f1c5a0362f028a32803d4d88b630e38deadb723fd39a5d08788fd9e7041c59934', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:31:54', '2023-05-02 23:31:54', '2024-05-03 05:01:54'),
('6a6108354401676854e83b7ea5283c537bdd6f41a0e36f43fc60618495c3e7015bbcf55c746eafae', 43, 1, 'authToken', '[]', 0, '2023-05-03 04:45:36', '2023-05-03 04:45:36', '2024-05-03 10:15:36'),
('6a62698fe0508706c8033ef0d2e6577c7a4512c77267604cb909adb8a8fae3049fd79c0b7b373263', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:29:53', '2023-06-17 05:29:53', '2024-06-17 10:59:53'),
('6afc895d3b2ab9bdf7cfa4def53f137605dce058746478a804a195ba576a66d57a4d8dd68b7100ab', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:37:59', '2023-04-07 06:37:59', '2024-04-07 12:07:59'),
('6b99e97951a975d91b7d79204a0f50a9d25f9749cbab967057ae8c0dc4a97aa5bdce06391d4f1e25', 16, 1, 'authToken', '[]', 0, '2023-04-07 07:10:14', '2023-04-07 07:10:14', '2024-04-07 12:40:14'),
('6bd49fcca1e79cea7887ad60fba818135c715dfd41ec98e7f6da4b88acc7ec444aa27a51a36123df', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:43:14', '2023-06-17 05:43:14', '2024-06-17 11:13:14'),
('6bf70200bf30af52f6b7a1cd5f2bffd3470f8b5da6b1d88028f0c174fd1f3bc977e81a044e6ef80f', 88, 1, 'authToken', '[]', 0, '2023-06-23 00:27:50', '2023-06-23 00:27:50', '2024-06-23 05:57:50'),
('6c6157bb44215b00723fbeedf551b91801d1bacfa0a0f6f0914bdaea50f66db54fe300d57beca327', 4, 1, 'authToken', '[]', 0, '2023-05-07 23:48:04', '2023-05-07 23:48:04', '2024-05-08 05:18:04'),
('6dd19bd454b9d0fe985fd49b886d35fa7afa9e279b85aa138c98bdc084f939a80b2bc2f51edec86c', 40, 1, 'authToken', '[]', 0, '2023-04-19 11:36:01', '2023-04-19 11:36:01', '2024-04-19 17:06:01'),
('6de66995a3f179a54fbf14df62bbab05480a236baae214569cb2550d8e86d807c9c086b4a1f2a065', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:50:34', '2023-04-07 05:50:34', '2024-04-07 11:20:34'),
('6e7d444f7a356354738d8edb64f01180b7b430a84930c0f3c68f206d6e729e91f381e8194c28e5f9', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:54', '2023-05-02 23:32:54', '2024-05-03 05:02:54'),
('702d8fab96c919272b92da89a5f105238e576a4a7c91600288512d955a684b3cbbe27a27a8f8f471', 16, 1, 'authToken', '[]', 0, '2023-04-11 23:30:03', '2023-04-11 23:30:03', '2024-04-12 05:00:03'),
('72031094799cd623b7f9257a9fc7b46d53b137b9be9b1234695144b793effe8c30d4314716aa798a', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:18:07', '2023-04-07 06:18:07', '2024-04-07 11:48:07'),
('7246f90c97348ec290f6d8f5e86873894f8dad66324bb7ff436f6f6df80f43d4fbf641cf8eacf42b', 4, 1, 'authToken', '[]', 0, '2023-05-08 00:03:43', '2023-05-08 00:03:43', '2024-05-08 05:33:43'),
('72fc6d0b9a1cc046668ecc888ec99b4fffd473462d363a7f0a55fdc26c930ce78853ca268912fbea', 39, 1, 'authToken', '[]', 0, '2023-04-18 07:20:32', '2023-04-18 07:20:32', '2024-04-18 12:50:32'),
('73fea605806e0ae48ac1df652e06979e931b0b1e0b24f556b02a60ff03d2049bdf34a02d6f90ad37', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:19:43', '2023-04-07 06:19:43', '2024-04-07 11:49:43'),
('754aa2dad2f706f614c8f6a6eb7159b059d6c0315e0d0db674011d255a82dde3f00546288fc911c8', 1, 1, 'authToken', '[]', 0, '2023-06-13 00:39:41', '2023-06-13 00:39:41', '2024-06-13 06:09:41'),
('784a416f83959462000c07ada3a4a540519611df260b93bacd04d0ae8d53e7fce85fa6ee4967dd18', 66, 1, 'authToken', '[]', 0, '2023-06-21 05:27:25', '2023-06-21 05:27:25', '2024-06-21 10:57:25'),
('78bc93d1c338a8e2ce92b0ad107a62d1b74b9875ddadaeeb113ae0070eb24dd2d11be5ee30531da5', 42, 1, 'authToken', '[]', 0, '2023-05-09 02:32:21', '2023-05-09 02:32:21', '2024-05-09 08:02:21'),
('78ecdc0c6c47da8631d17b60f084bc95e9e7e0bd61a833bfc82fc1b6717001504f7239ffd3cac262', 16, 1, 'authToken', '[]', 0, '2023-04-05 01:55:47', '2023-04-05 01:55:47', '2024-04-05 07:25:47'),
('7906a0a3f4e6c9679f7111b0caedc21c7bfa20e16f130fe209a99ab729dc3614b5c60648b7c52be3', 16, 1, 'authToken', '[]', 0, '2023-04-07 08:07:36', '2023-04-07 08:07:36', '2024-04-07 13:37:36'),
('7dea372ef03bd4273b04f36d12bbe54a5057c200d4f0f0e7c5736e7abb1b33d005f520db717b61d8', 64, 1, 'authToken', '[]', 0, '2023-06-21 04:50:01', '2023-06-21 04:50:01', '2024-06-21 10:20:01'),
('7ee94b3d0a22dd320a265afe37c4ee41f8646a597616fa4a6bba19d8c63f24835c0e73c1f6bfb218', 64, 1, 'authToken', '[]', 0, '2023-06-23 00:41:03', '2023-06-23 00:41:03', '2024-06-23 06:11:03'),
('8027c27412a90dd340af849e95368dbf61782270f712b03f51a801dd88d144ef299aa5cc3ea22bde', 16, 1, 'authToken', '[]', 0, '2023-04-11 00:39:07', '2023-04-11 00:39:07', '2024-04-11 06:09:07'),
('809a096fa4d943c1459a6a7df48a794217f6edd7378dbac43b470e5b39c03c3cc4c01a66f5307061', 38, 1, 'authToken', '[]', 0, '2023-04-15 02:32:57', '2023-04-15 02:32:57', '2024-04-15 08:02:57'),
('8113a4563d5c730b288a68b2b116a4effa4570694a85d87da3abdee15df1b709f2e7d1d0445784d8', 16, 1, 'authToken', '[]', 0, '2023-04-07 01:21:46', '2023-04-07 01:21:46', '2024-04-07 06:51:46'),
('815724a346519c095a587e05b6a1fd384371665f62c00d2d778efe14bc23dfb3b7c99e9f3b93c85e', 64, 1, 'authToken', '[]', 0, '2023-06-17 07:49:21', '2023-06-17 07:49:21', '2024-06-17 13:19:21'),
('82c06d90971c7bd985ccbb5b458cae6ca3719c09634072e948d293913148dea8dce8677cdc3054d2', 64, 1, 'authToken', '[]', 0, '2023-06-22 00:26:13', '2023-06-22 00:26:13', '2024-06-22 05:56:13'),
('83922b2da56ba94aea96887a868fd8974a3054f0bc29535541c6b3e63505bc05b97368474fc7b8f7', 42, 1, 'authToken', '[]', 0, '2023-05-09 02:33:00', '2023-05-09 02:33:00', '2024-05-09 08:03:00'),
('83b647c43fb18bf30e7e207cfe8ce3657c44935a2037a46d0883902cd5bb1bf1550f56f69d2b8fd4', 40, 1, 'authToken', '[]', 0, '2023-04-19 08:30:26', '2023-04-19 08:30:26', '2024-04-19 14:00:26'),
('852b1364c4eeb44ad628d79f89509a8921f1c2fab90a6af1da8f9b873b48d2ed6a2bcae3e56fc8ac', 4, 1, 'authToken', '[]', 0, '2023-05-07 23:44:56', '2023-05-07 23:44:56', '2024-05-08 05:14:56'),
('8533ee22a34ca050ea75cd39a91bb6629d71d4fe167114a38eb4b40440e5e331b5ba49b547e02f34', 42, 1, 'authToken', '[]', 0, '2023-05-09 02:32:35', '2023-05-09 02:32:35', '2024-05-09 08:02:35'),
('85762597789dfae6bdc13689abf48638fb643a6de5cfb185a7c3f207ae1fea40ce06cda8c6d0a47e', 23, 1, 'authToken', '[]', 0, '2023-04-10 02:10:04', '2023-04-10 02:10:04', '2024-04-10 07:40:04'),
('862af994f5579bbac675b77bedc80fb928cedc17b25eb02b160cb43d89a7566199c9fbd654a4d653', 80, 1, 'authToken', '[]', 0, '2023-06-22 02:32:08', '2023-06-22 02:32:08', '2024-06-22 08:02:08'),
('86733b9a04c14072fb77c975fc921528c460dadf5a8bff4e2d929bb23f5887e4fe46358c54b4e64b', 58, 1, 'authToken', '[]', 0, '2023-06-17 05:03:28', '2023-06-17 05:03:28', '2024-06-17 10:33:28'),
('86801b5935bc1e7e0f3d7fa292e0a495083f78f7c12a2cdccc4d6f8ff405cc4f7a267c2f20fd777e', 42, 1, 'authToken', '[]', 0, '2023-05-10 23:26:12', '2023-05-10 23:26:12', '2024-05-11 04:56:12'),
('869982e3d0e99e7613ad0a5c9f041018285f2bf51e8b5738b4dd56ed923a24e725b9211c87a0e6d9', 38, 1, 'authToken', '[]', 0, '2023-04-13 05:26:29', '2023-04-13 05:26:29', '2024-04-13 10:56:29'),
('86b04735d112ae42e69cce30358fa870426355d63a5d5d1416bcb7e8e69e11448020bd48584c231e', 16, 1, 'authToken', '[]', 0, '2023-04-05 07:21:02', '2023-04-05 07:21:02', '2024-04-05 12:51:02'),
('86e65faa7127493329aafade9b1b32fcce07a59c4de6110be554a61bcba91a65394921f12824b0b0', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:22:43', '2023-04-13 00:22:43', '2024-04-13 05:52:43'),
('8ad180d3786c8a16c46e2824b5ffea149954608a0fe0984ede9450c57b8637352fc65fa2cd46592e', 3, 1, 'authToken', '[]', 0, '2023-04-12 02:41:06', '2023-04-12 02:41:06', '2024-04-12 08:11:06'),
('8c19cb9718d9c2f84c994520fd02f1ad87ff5a9c68944ded77e5bee2ffcabb1d1c93a56cf726cc82', 16, 1, 'authToken', '[]', 0, '2023-04-06 00:46:54', '2023-04-06 00:46:54', '2024-04-06 06:16:54'),
('8c5360671abede1b87c6ffa4b95c306d466ebd11911d6f5deab420c4089402defab0138f6733c1fc', 42, 1, 'authToken', '[]', 0, '2023-05-09 02:37:36', '2023-05-09 02:37:36', '2024-05-09 08:07:36'),
('8cd8a5b52c5db64c96818204198eb30ebcfa10931b560bf1ac389a007c310bb9e7a9a0a21f749ede', 38, 1, 'authToken', '[]', 0, '2023-04-15 08:38:40', '2023-04-15 08:38:40', '2024-04-15 14:08:40'),
('8d302ca9ec606efd5bc982a37b524a4f8cc44480147bb8a3b924bee612800b0a42e06125a9ab8e9a', 42, 1, 'authToken', '[]', 0, '2023-05-18 06:01:49', '2023-05-18 06:01:49', '2024-05-18 11:31:49'),
('8d9e40025204fd3397aaaf2c9ccbaecb16bff55856838e8c144a7b7305c2ee5944011097fd6ede88', 40, 1, 'authToken', '[]', 0, '2023-04-19 23:32:15', '2023-04-19 23:32:15', '2024-04-20 05:02:15'),
('8eebf3785f635f9ef6d54742e2626e45bd8ff24d947dc2c3beebb8dca4c213022efe23260ae11fa4', 11, 1, 'authToken', '[]', 0, '2023-03-21 01:34:35', '2023-03-21 01:34:35', '2024-03-21 12:34:35'),
('8f19acc4ba7fb736f9c9a43fb46ddb8fc05e1cfef3136e543769d3739f45ccc0d49a7617be8bc7bd', 40, 1, 'authToken', '[]', 0, '2023-04-19 23:52:21', '2023-04-19 23:52:21', '2024-04-20 05:22:21'),
('8f2d30f0fb6493f6884665b8c77ba5274584197eb03ebc00ab72dd149836e5d6556890a38f0e84b0', 16, 1, 'authToken', '[]', 0, '2023-04-10 02:13:31', '2023-04-10 02:13:31', '2024-04-10 07:43:31'),
('8fa9c6ff7b4f44f1e696c911469b028bcc1702a31aeb9f2b35ab6aecf57a488adb04257e7e409b31', 58, 1, 'authToken', '[]', 0, '2023-06-13 01:40:03', '2023-06-13 01:40:03', '2024-06-13 07:10:03'),
('8fd35585db6bcb258b8a1e9d201d4aac32c8d26a343ff51ad47bed9f0c5116d831fbf3ecada23eff', 40, 1, 'authToken', '[]', 0, '2023-04-19 11:35:37', '2023-04-19 11:35:37', '2024-04-19 17:05:37'),
('90eeda9f02c175223b514c3f40d35f799c3e07b05409b66e7b6e3e11ee28c2b9da72170c381602e3', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:53:31', '2023-04-07 00:53:31', '2024-04-07 06:23:31'),
('91154bab4093b113527f632b31a438c532d350db22b5e98e1daa0d332ba6f1db4364acafc86776ff', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:23:09', '2023-04-13 00:23:09', '2024-04-13 05:53:09'),
('913ed89d1e352beff0eb21af23effc2dae066b57fc2083a09c20450b2de39c2ff8a6b9a3d526ad1c', 16, 1, 'authToken', '[]', 0, '2023-04-12 00:35:53', '2023-04-12 00:35:53', '2024-04-12 06:05:53'),
('91475ffae1f862de933545b08bdf3fcf005f2c301eb2e86018b8d636c38c29521f6caa93a063b72f', 11, 1, 'authToken', '[]', 0, '2023-03-23 22:06:50', '2023-03-23 22:06:50', '2024-03-24 09:06:50'),
('926b7770168d7d83ea9977b2e716f952a26f75f80319ade8b47e432ed1da2e3f62821d4f06c0558e', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:13:13', '2023-04-07 00:13:13', '2024-04-07 05:43:13'),
('93e48f48b6a43a45a875b8298c60863083a0f1aa1fc693fdd83cdec74e17de90eed452db5ea86411', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:24:09', '2023-04-07 00:24:09', '2024-04-07 05:54:09'),
('9435aa7e9585c638ec4341da0eddf84edb162495df14ed7cb201c6563a69de8d779b0d2213131dab', 16, 1, 'authToken', '[]', 0, '2023-04-13 02:36:42', '2023-04-13 02:36:42', '2024-04-13 08:06:42'),
('947d4f4fce3b1e8096321a32d367f3699ad42ddb7d67d3de4cc2bc880ef3af204b2adea6bb89435f', 16, 1, 'authToken', '[]', 0, '2023-04-07 07:04:36', '2023-04-07 07:04:36', '2024-04-07 12:34:36'),
('968948d79b57038127402c67ce652941d718fbfd2c807dffb55d50b5f54ea8e263788e2a50deb777', 39, 1, 'authToken', '[]', 0, '2023-04-18 23:38:00', '2023-04-18 23:38:00', '2024-04-19 05:08:00'),
('96eae5e6dbf09192a5434f1627a9e7987b5a6fbd789e00fb6a3c4d1e011a622aa7c67e3f31a90b18', 16, 1, 'authToken', '[]', 0, '2023-04-06 23:42:00', '2023-04-06 23:42:00', '2024-04-07 05:12:00'),
('9701dfc255a139bf8db5d7c5419189dbc33097cf386e3db280533110d047a52b081007a3318ed047', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:16:00', '2023-04-07 06:16:00', '2024-04-07 11:46:00'),
('99223218d9532599fa991af53be8f750d6520a5c1768c87d2cd3f80746edcad1f832c7f2dc644365', 47, 1, 'authToken', '[]', 0, '2023-06-07 01:13:57', '2023-06-07 01:13:57', '2024-06-07 06:43:57'),
('9a56cda57a2b79ca04d95b77a1a8e6a868d56ef0dfdfd9896ac9155651411e33c512a8802590cffb', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:28:15', '2023-04-07 00:28:15', '2024-04-07 05:58:15'),
('9be0584a4aaa31373060c8772701787047a85246057fe48a3a210a5d7392d79e5ebeea5410bf5d56', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:45:53', '2023-04-07 06:45:53', '2024-04-07 12:15:53'),
('9ccfd90c44758d0121e350112f078f1cd6d8cdabaf76f7a23696327cb93af09736d608eb1eb67039', 16, 1, 'authToken', '[]', 0, '2023-04-05 01:33:33', '2023-04-05 01:33:33', '2024-04-05 07:03:33'),
('9df7bd30cecf014aeb90cd6f7ba44f64464f148f25ddd46091b4822d603956a101d43c89214bf48d', 16, 1, 'authToken', '[]', 0, '2023-04-06 23:27:13', '2023-04-06 23:27:13', '2024-04-07 04:57:13'),
('9f1dd719a19e01ecd54bd40badd359b6a5486e1f28f852cfab7205bf7abb8d3d119a10b3b06217e6', 16, 1, 'authToken', '[]', 0, '2023-04-12 06:18:07', '2023-04-12 06:18:07', '2024-04-12 11:48:07'),
('a00107d05798a18987cb7e3e57e859805f9883f6bbe97fb77b225ba3cc3db92f631f798274ac155b', 43, 1, 'authToken', '[]', 0, '2023-05-06 05:05:58', '2023-05-06 05:05:58', '2024-05-06 10:35:58'),
('a0186689cfe3778d165021f759e8629f0cf3b57897557078bdfc789a1e84b997d9ea0b3bf9f7c16e', 94, 1, 'authToken', '[]', 0, '2023-06-28 01:28:51', '2023-06-28 01:28:51', '2024-06-28 06:58:51'),
('a130bc9ae73535ec62a1f209c2ec4350c3a1cd29c84411e9545ff1e5963cd3f1d85996be92d93d88', 58, 1, 'authToken', '[]', 0, '2023-06-13 04:52:08', '2023-06-13 04:52:08', '2024-06-13 10:22:08'),
('a2465da08fc43080df982422ad11b13c8f33605b7a727a22162576e5812a7163d83289e09c301b82', 16, 1, 'authToken', '[]', 0, '2023-04-06 23:43:14', '2023-04-06 23:43:14', '2024-04-07 05:13:14'),
('a3510449a40fa832aef51a6b6a2bd87dce3b0ab50b1944e720dd6c9a729c05e300d137261b2e4a60', 45, 1, 'authToken', '[]', 0, '2023-05-03 02:41:01', '2023-05-03 02:41:01', '2024-05-03 08:11:01'),
('a3e0d998545f1752660e3a2dbe5e46cf6872518b8754bc1fab0fce3fce5be9341ad53dd587b6a85a', 23, 1, 'authToken', '[]', 0, '2023-04-14 04:32:48', '2023-04-14 04:32:48', '2024-04-14 10:02:48'),
('a459612199fc156006d370676cf3c8f537419280b706d52cece6690d944099e88f10055953bf67de', 46, 1, 'authToken', '[]', 0, '2023-05-08 01:58:43', '2023-05-08 01:58:43', '2024-05-08 07:28:43'),
('a4c012a2a3ba317d5fd53633043c337c9cd43273027b4d4e2ea0d8ef5dd6817f1155ca3226ff7a60', 43, 1, 'authToken', '[]', 0, '2023-05-18 07:59:08', '2023-05-18 07:59:08', '2024-05-18 13:29:08'),
('a51b3bd3e573aecd7d3f92d1a39497a9c1e63449ad76cfa918ef3602243b16c100313451b0c34471', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:25:08', '2023-04-13 00:25:08', '2024-04-13 05:55:08'),
('a5a8a02d3b686591c64cc28634f9a6d32e1111f28b41452e37b9524fd3915c8a86924a81d587c247', 16, 1, 'authToken', '[]', 0, '2023-04-13 23:31:26', '2023-04-13 23:31:26', '2024-04-14 05:01:26'),
('a997616c5ea1325b60d693449340e1c5e3f8c418881d5ad46ac8b99700ace174b90b8bd0e2669627', 16, 1, 'authToken', '[]', 0, '2023-04-13 05:54:25', '2023-04-13 05:54:25', '2024-04-13 11:24:25'),
('aa3ae6c63244e8e9e018bf2bc5618a60005a612ad127d5872fa94fccaea14f338749500b43c820e0', 16, 1, 'authToken', '[]', 0, '2023-04-11 05:17:15', '2023-04-11 05:17:15', '2024-04-11 10:47:15'),
('aaf81aa4f3812ffb051f4df73f729cea17a4a8d105edbf4e2e2a6d200f6aca1813cf8fb1b9f0a065', 16, 1, 'authToken', '[]', 0, '2023-04-11 04:43:22', '2023-04-11 04:43:22', '2024-04-11 10:13:22'),
('ab2fe1b5e2ca49276555ba6b1782baa05de7f582784709ce17368dae0ecc8f0db3abe5b2ca899a1b', 16, 1, 'authToken', '[]', 0, '2023-04-11 05:20:07', '2023-04-11 05:20:07', '2024-04-11 10:50:07'),
('ab3242d4f0a20384a93b526f27e1888b1b49c5c54c70a192832563b5905cc903d7cfb76cb5eff852', 42, 1, 'authToken', '[]', 0, '2023-05-02 00:32:53', '2023-05-02 00:32:53', '2024-05-02 06:02:53'),
('abdc2991c3b94b5967e8d98b93c94d6cdbe8416b6a72d2a0816c51bb500f51c8ef66d8b916f747fd', 16, 1, 'authToken', '[]', 0, '2023-04-12 06:45:46', '2023-04-12 06:45:46', '2024-04-12 12:15:46'),
('ac8f1c45aba3c3bdd40c162002c02e5e3ba58b95dd0624c2ab6bf8165597e2779d0826691068da1a', 16, 1, 'authToken', '[]', 0, '2023-04-11 04:44:28', '2023-04-11 04:44:28', '2024-04-11 10:14:28'),
('aeea64bc3bf41c65e70ca1d2afe1a806cf2ebb77591006f0f481ce296b5bbdfbfb25e10de5a7584e', 16, 1, 'authToken', '[]', 0, '2023-04-07 02:20:21', '2023-04-07 02:20:21', '2024-04-07 07:50:21'),
('b02579e9999e18382f65bd8900034248e46ac30f92b3bb99030954f07165e137704c6583131a4c4e', 16, 1, 'authToken', '[]', 0, '2023-04-12 01:20:21', '2023-04-12 01:20:21', '2024-04-12 06:50:21'),
('b0492e25430b3ca8115bc24ce841c14ed6d511260be1a1c08139f89cb527942009a8e508c74f83b5', 16, 1, 'authToken', '[]', 0, '2023-04-13 02:22:04', '2023-04-13 02:22:04', '2024-04-13 07:52:04'),
('b04fd02339817f851c0a41737bf430a5b165113fb1080387ab838e8afbf4e1a615325d7fcf0efc25', 16, 1, 'authToken', '[]', 0, '2023-04-15 02:19:36', '2023-04-15 02:19:36', '2024-04-15 07:49:36'),
('b140f22cd44ad7423af0c6d3688e79ea9650529bf223bfdc4b2b008ab2338d00fa4e3a9877423ee1', 64, 1, 'authToken', '[]', 0, '2023-06-21 00:13:51', '2023-06-21 00:13:51', '2024-06-21 05:43:51'),
('b142ab0f4aafe79a71b416f6ff7ebf0a17ad22c4b4c1248ce6e343e22939360c155997b2620c53c4', 16, 1, 'authToken', '[]', 0, '2023-04-12 00:20:39', '2023-04-12 00:20:39', '2024-04-12 05:50:39'),
('b2a2685a038a01c68c2db466f83416ae2fe824e9eb651dd08cf8b00fd2b6223f65317dbe410cc2a6', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:26:19', '2023-04-13 00:26:19', '2024-04-13 05:56:19'),
('b3db78b89948c336a2266cc9fe0c009f46f0fd01493e5ab4f87140463cb1a5942da649bc9a885378', 42, 1, 'authToken', '[]', 0, '2023-05-18 08:39:10', '2023-05-18 08:39:10', '2024-05-18 14:09:10'),
('b44c09301a784fb0c653c05df298e79381064a5277633efd4de8bda46f0e76f05de1bbda07a67a23', 24, 1, 'authToken', '[]', 0, '2023-04-10 02:29:37', '2023-04-10 02:29:37', '2024-04-10 07:59:37'),
('b6bbb20678af49ba57dfc7c01e3f5b94fb038876aa9d470f17d5776f38fc4598afef37104593e007', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:26:18', '2023-04-07 05:26:18', '2024-04-07 10:56:18'),
('b8e1991d9adb3e6c4e6d2c57c6b704edd5bedb788d5b1fdf8ceccfda47b72d3710fe6904af265642', 43, 1, 'authToken', '[]', 0, '2023-05-02 05:58:11', '2023-05-02 05:58:11', '2024-05-02 11:28:11'),
('b974fd272b6e579e54460283329f79551c631e24d4bad1928c8276ba4a99f13ceb4ab95bc5c55946', 40, 1, 'authToken', '[]', 0, '2023-04-19 11:36:13', '2023-04-19 11:36:13', '2024-04-19 17:06:13'),
('bb9d93e6d107ec60fe5a5376a32892c023ca17097f45d78aa2b95ddb86e08e186e97ad02a88845ef', 16, 1, 'authToken', '[]', 0, '2023-04-07 02:08:51', '2023-04-07 02:08:51', '2024-04-07 07:38:51'),
('bd1d8c5f7f72069a9aeb1612a9bdc8387c1cf3e77dbb6c20ee57e8bf8397168cd22aafa1bc266838', 37, 1, 'authToken', '[]', 0, '2023-04-13 01:13:31', '2023-04-13 01:13:31', '2024-04-13 06:43:31'),
('be33d97818eb5bf61c673def2a74f3a641927de450f74a3f74ef8c15eab2609908c06d6da13d6ecd', 62, 1, 'authToken', '[]', 0, '2023-06-21 04:56:38', '2023-06-21 04:56:38', '2024-06-21 10:26:38'),
('bf6197d60f24e038721b428414b1a5489721d84d4f0a0de4ecb423a4f5440fa2acfcdabe6d7c33ac', 16, 1, 'authToken', '[]', 0, '2023-04-13 05:54:03', '2023-04-13 05:54:03', '2024-04-13 11:24:03'),
('c10fa72b7088f028a7b8d296b4936c0595d3419bb09bbd8c5b3ded238628544517628c9577f77c10', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:13:44', '2023-04-13 00:13:44', '2024-04-13 05:43:44'),
('c1afc5bfc6cff04e68ba0d8a65b9ca1701bd4494559a8a0564d46117ee9fbd7ba57531528718d5f1', 16, 1, 'authToken', '[]', 0, '2023-04-11 05:15:16', '2023-04-11 05:15:16', '2024-04-11 10:45:16'),
('c23437c5684c51db38a94a30fafa77036dda0d08f279d1847bba5f3366c6a0a438b88f113b4e2325', 37, 1, 'authToken', '[]', 0, '2023-04-17 07:49:55', '2023-04-17 07:49:55', '2024-04-17 13:19:55'),
('c235212806edaff2ed65b047b1e6a494ea574475c2fc3bb6a1bf4b9d72d66bbd310fb7e7e9e7aea3', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:17:11', '2023-04-07 00:17:11', '2024-04-07 05:47:11'),
('c4b2fa28dfabe8da774e10150026f5268ba00d8bd85d9c1e7c94d3e0f9f54b80829a6757bc1c3517', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:37:39', '2023-04-07 06:37:39', '2024-04-07 12:07:39'),
('c6d88c0d243ebaf1ae4aed20ab501580485100d16c2a3775b060ba30902476f359f61f53d893d482', 16, 1, 'authToken', '[]', 0, '2023-04-11 04:46:51', '2023-04-11 04:46:51', '2024-04-11 10:16:51'),
('c705416dd7e56b891a6c24f3736fff1faf8a60a01da3023693f2bac9067528168c44e877aec33193', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:29:22', '2023-06-17 05:29:22', '2024-06-17 10:59:22'),
('c79207cb26cb544886112151f4887c1e00fdbc7c9dbd5112d0122e4b69a59940b7b8419b6e580ffd', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:10', '2023-05-02 23:32:10', '2024-05-03 05:02:10'),
('c7c4264053ae47b55049a8afd2cca35eff8478690cb4f1909c6075fc86e0977668cc2cf8d8be5998', 11, 1, 'authToken', '[]', 0, '2023-03-21 23:10:46', '2023-03-21 23:10:46', '2024-03-22 10:10:46'),
('c914e4d8d7a60a83bb71aa6626169753f92f2b353f143658b90b037474dee4ce5a527fb12d108790', 16, 1, 'authToken', '[]', 0, '2023-04-10 04:28:54', '2023-04-10 04:28:54', '2024-04-10 09:58:54'),
('c959a60d5234f413a0935559b4f66bfca2dd180782831f5ae715fc080fa37d5158e5d791ef2a46b5', 16, 1, 'authToken', '[]', 0, '2023-04-07 01:53:13', '2023-04-07 01:53:13', '2024-04-07 07:23:13'),
('c98efcd7c132c340f1678c200b6cd43452ea1a73e36ac52ac4ce9f1d2c8eefeb8ec9d9fab7158502', 66, 1, 'authToken', '[]', 0, '2023-06-22 00:24:31', '2023-06-22 00:24:31', '2024-06-22 05:54:31'),
('c9dafd378d8e191b7538070b3c4aa4d1bbba4fa5abe96ffae4155008c2930634a14f3427db3341be', 64, 1, 'authToken', '[]', 0, '2023-06-17 04:39:23', '2023-06-17 04:39:23', '2024-06-17 10:09:23'),
('ca1147963633c18c1aa69e0bcb19a4853ff93b49f77eb95b1db3e3cd856291a74934b1fadfe0a92f', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:50:13', '2023-04-13 00:50:13', '2024-04-13 06:20:13'),
('cb169dccb82d90e0e671f70dec8db0904831f543dd0b420e2a807cb44f9a1c0772dc4077230ee764', 43, 1, 'authToken', '[]', 0, '2023-05-09 02:35:52', '2023-05-09 02:35:52', '2024-05-09 08:05:52'),
('cc5997e3902253c8178d50123610009c751b58e8287690d7bf782efb6a39e61f4565f99148890923', 62, 1, 'authToken', '[]', 0, '2023-06-21 04:55:22', '2023-06-21 04:55:22', '2024-06-21 10:25:22'),
('cfa58ed666a26f8539e9b2b5f7f48e29f34d0bafa215d4deb87ce2eb9a749337d51752b564d0feba', 38, 1, 'authToken', '[]', 0, '2023-04-17 06:07:59', '2023-04-17 06:07:59', '2024-04-17 11:37:59'),
('d01a78117e6e0dc76655482f018ef8acbd6126208dcf5ac25115d8d6812c7fcd521e68dfc1db1897', 58, 1, 'authToken', '[]', 0, '2023-06-13 03:50:35', '2023-06-13 03:50:35', '2024-06-13 09:20:35'),
('d09be9a6000f73a71b6c906cb997c076867fd4c22e294abeab1660ff294acfb13ae2b02b058acfba', 16, 1, 'authToken', '[]', 0, '2023-04-11 04:41:46', '2023-04-11 04:41:46', '2024-04-11 10:11:46'),
('d0ff71608b744dc6eccaab99a25bbaab0fc795860f1d7b943846a165985f60c513e10f45c8f53da9', 4, 1, 'authToken', '[]', 0, '2023-05-07 23:48:28', '2023-05-07 23:48:28', '2024-05-08 05:18:28'),
('d2ee70bb7ab01c4848f748336abca3ff46bb2761134cd8b9daa967f84b863e0f3e60ed5a79c75cc4', 64, 1, 'authToken', '[]', 0, '2023-06-17 07:46:34', '2023-06-17 07:46:34', '2024-06-17 13:16:34'),
('d463f840babe7e4e72c4159ac7508cb89df4aeb204fa02f6dcd620491adbe3095d02fcbf44174bf5', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:56:41', '2023-04-07 05:56:41', '2024-04-07 11:26:41'),
('d482cfde3bb9ecd4fb0accbd6a08951a62cf7fe765b446f7587046c5b72ac2782e6240dbc80b69bf', 16, 1, 'authToken', '[]', 0, '2023-04-11 05:05:24', '2023-04-11 05:05:24', '2024-04-11 10:35:24'),
('d6ad04151f4e6ac3fe3a48967cfa1087bb7ee9382f97a4c92c62c9f9ae62ec4c3cdf2dde35476957', 64, 1, 'authToken', '[]', 0, '2023-06-20 23:41:01', '2023-06-20 23:41:01', '2024-06-21 05:11:01'),
('d6ee96ede1eb79d331945d1617aa5fc7ac54ac55cef990de40ab4a3a7b11c0184396d1375c2325a2', 16, 1, 'authToken', '[]', 0, '2023-04-06 08:09:30', '2023-04-06 08:09:30', '2024-04-06 13:39:30'),
('d7df03263edcc5750b7bae9969a12f5a812e9fa763c7e22fb96d50debbb03e503c1d2d0cd612e62a', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:32:11', '2023-05-02 23:32:11', '2024-05-03 05:02:11'),
('d8747e7a5cb7d34fd77155e6ebee0e2e9c6ef4223b866f227f47ce2debff8f0b4a353b83593a63c0', 37, 1, 'authToken', '[]', 0, '2023-04-17 07:46:26', '2023-04-17 07:46:26', '2024-04-17 13:16:26'),
('d9d1c2270404e72ed9518ed34340050d8f742501ad4e8325ae0884566da419bdf4d6c8e81f8753f6', 16, 1, 'authToken', '[]', 0, '2023-04-14 01:48:33', '2023-04-14 01:48:33', '2024-04-14 07:18:33'),
('da46c55a2a8eda85967b4671941690b2601c013ca8acf144c2161cab123af8c8351581c9fc6ee38e', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:11:41', '2023-04-07 06:11:41', '2024-04-07 11:41:41'),
('daf94f0159c235400a93f80e78da2081f4326203974cc2204121bed7e373b9376afa177fd666811b', 39, 1, 'authToken', '[]', 0, '2023-04-21 00:57:10', '2023-04-21 00:57:10', '2024-04-21 06:27:10'),
('db591f55d485e022bfa65e1ae48a0757928ec8d31cf2a844b533e170a8365b8e27d61dab0e111ade', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:55:50', '2023-06-17 05:55:50', '2024-06-17 11:25:50'),
('dba68182c2d452d97a887e30580d5b6baa4f7a248dd114dcec09cad75c1b48a49de72fc9a5a392b2', 16, 1, 'authToken', '[]', 0, '2023-04-06 08:15:23', '2023-04-06 08:15:23', '2024-04-06 13:45:23'),
('dbfef99b27418529697bb7faa9ca1ebbae32017d64fb97d5ee637f047d1d0cb95a273ba5517017fa', 64, 1, 'authToken', '[]', 0, '2023-06-21 00:04:57', '2023-06-21 00:04:57', '2024-06-21 05:34:57'),
('dd6949f3e1196bb0a858ac92d21c0cc3f7707ce67854cbf4442ab8ee563ee2d0da242e6142de7fb7', 4, 1, 'authToken', '[]', 0, '2023-05-07 23:54:44', '2023-05-07 23:54:44', '2024-05-08 05:24:44'),
('de41b847293cb7ac2ea7c27033586371bd8c14f9c7530b34f3b7ac0d2667441cbb75570959b9e01f', 38, 1, 'authToken', '[]', 0, '2023-04-18 01:18:36', '2023-04-18 01:18:36', '2024-04-18 06:48:36'),
('deba811563ed073d383b7a6a935638325e9958dda0677fdb7da72df574faeb9e16487905b0aadce9', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:48:41', '2023-06-17 05:48:41', '2024-06-17 11:18:41'),
('df6773184d0b825e81333e8d6b911d39ea9b33e327f85a28aaae46b22ba461b03683a44dee9d66bd', 38, 1, 'authToken', '[]', 0, '2023-04-17 07:43:31', '2023-04-17 07:43:31', '2024-04-17 13:13:31'),
('dfe527c4f257d0a41821c9eff5813863ff0c4448a9d102a6aa5adfaa341f74c6e5d6523e23eb1cd5', 16, 1, 'authToken', '[]', 0, '2023-04-07 01:11:53', '2023-04-07 01:11:53', '2024-04-07 06:41:53'),
('e045c29c4b9cd3bdb69027963ceaebfc93f35612bb757750ae7205f1152324b5e4484431159ea445', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:57:11', '2023-06-17 05:57:11', '2024-06-17 11:27:11'),
('e075027a58e034851377c7ff6efa4c95dd14f1c7370a79bb3e71b0c09f65a07011246e9dce1ea7d7', 64, 1, 'authToken', '[]', 0, '2023-06-20 23:18:57', '2023-06-20 23:18:57', '2024-06-21 04:48:57'),
('e18e80de6d46b8b35df185850aae67ef82a0592b1afcb7ea2e3b7565c754b676daf331ccaea7cb88', 38, 1, 'authToken', '[]', 0, '2023-04-14 23:38:29', '2023-04-14 23:38:29', '2024-04-15 05:08:29'),
('e393435447a5c18688cfd3726ff2cda3708f5937570ab36bdec70b564c69fd1a00a30e4a29ec5fa6', 16, 1, 'authToken', '[]', 0, '2023-04-13 00:30:48', '2023-04-13 00:30:48', '2024-04-13 06:00:48'),
('e4621c8a6f1d7f24d443f218d2dd8bdac8c1b0c181ef7ce8eb60c10f1191fbe108e6b579ed777c83', 4, 1, 'authToken', '[]', 0, '2023-05-07 23:49:00', '2023-05-07 23:49:00', '2024-05-08 05:19:00'),
('e46e3c78c190c603b26ce9d3a790ae2dbe34db15716a3b42650bbd1caa5f3f3cdafae60bbc10d264', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:34:35', '2023-04-07 00:34:35', '2024-04-07 06:04:35'),
('e5127ddd2d99b57f7a4a0920f36c2346bb9435160b585dfbdbec4598562c39b9a663f1e4bcf41e01', 16, 1, 'authToken', '[]', 0, '2023-04-05 01:44:07', '2023-04-05 01:44:07', '2024-04-05 07:14:07'),
('e5d27811fe6c8365b11451596d26667aeefabd438c2d2e3ef8f714338672f531fe9d51f1d4b01990', 16, 1, 'authToken', '[]', 0, '2023-04-12 05:28:20', '2023-04-12 05:28:20', '2024-04-12 10:58:20'),
('e5eeb23f314ac0ab71f70f4bae2f8d5716acc04045371013ef1b53c1d30429998ce10aedc540d62c', 42, 1, 'authToken', '[]', 0, '2023-05-05 00:02:14', '2023-05-05 00:02:14', '2024-05-05 05:32:14'),
('e67adbdc849776ca9de4620a791077ec0745fc1f180aca5b68da6b647041dd9eae470b12c59751bf', 79, 1, 'authToken', '[]', 0, '2023-06-22 02:01:10', '2023-06-22 02:01:10', '2024-06-22 07:31:10'),
('e9f8ff44e6f00a4ef143433d4c6ec0e31bde5c226cb1cc673171349b31bc3f16c03c6984a640d6a9', 16, 1, 'authToken', '[]', 0, '2023-04-07 08:00:21', '2023-04-07 08:00:21', '2024-04-07 13:30:21'),
('e9f9e4571b4d413673d7d3e4f1e7dded929d0a22957a8b40edf5d237371124cd0f34337ae6a356a2', 38, 1, 'authToken', '[]', 0, '2023-04-14 08:39:25', '2023-04-14 08:39:25', '2024-04-14 14:09:25');
INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('ea7808febc61d01f9ba0caa674ec79832cefeb043bb7d09550d45aca9c3fc05f330b28e0bc35b094', 16, 1, 'authToken', '[]', 0, '2023-04-07 06:24:09', '2023-04-07 06:24:09', '2024-04-07 11:54:09'),
('ea8333af51779813a96e9b77cb8c39a9ba989266847f2e8fb2d765af49ce7693bfc6e63a21b24f69', 58, 1, 'authToken', '[]', 0, '2023-06-16 23:00:39', '2023-06-16 23:00:39', '2024-06-17 04:30:39'),
('eaa465dc217d230e51faacf3af61a7707c13af55c22179a6fc4603ad51facc70b0047bce2db360df', 58, 1, 'authToken', '[]', 0, '2023-06-13 01:13:15', '2023-06-13 01:13:15', '2024-06-13 06:43:15'),
('eb0f63e169873b0ae457f729d621f1fc84cccf19e5da33d948d386752e0702260e199422c0d6de94', 16, 1, 'authToken', '[]', 0, '2023-04-07 00:38:30', '2023-04-07 00:38:30', '2024-04-07 06:08:30'),
('eb3c70ff80903512e4259f449f082def3beafa9536e25bf984900ffe93b32d8c8a237367d21f905b', 16, 1, 'authToken', '[]', 0, '2023-04-06 23:39:33', '2023-04-06 23:39:33', '2024-04-07 05:09:33'),
('ec629e0c6dcf9d030a32cf8bc611fbb2c31a3804501ab2cb6bc65ea556dd0b3d72005f5a56144000', 58, 1, 'authToken', '[]', 0, '2023-06-17 01:35:15', '2023-06-17 01:35:15', '2024-06-17 07:05:15'),
('f0ba2debb1e0869721be1545e23ecd792f6bdee15234fdce210f13c4fc07b7218928ec32ba8b3d51', 4, 1, 'authToken', '[]', 0, '2023-05-04 05:26:19', '2023-05-04 05:26:19', '2024-05-04 10:56:19'),
('f0bc2b0f9cff4ca8ceddb47cc44e419bb1644da7ee63da4ba9556622718d889afe4115be09559d23', 16, 1, 'authToken', '[]', 0, '2023-04-07 05:58:54', '2023-04-07 05:58:54', '2024-04-07 11:28:54'),
('f1b03992f71fb0010f92747357ae8c6f4e7d2a529d5222f882bace791b566f212b5897a53bcbc0ac', 16, 1, 'authToken', '[]', 0, '2023-04-07 01:13:04', '2023-04-07 01:13:04', '2024-04-07 06:43:04'),
('f279d149494f045c03fc5ff3435cceae0e83753efe233b029339abfb745dcc0e323fbd26f476d071', 16, 1, 'authToken', '[]', 0, '2023-04-10 04:44:50', '2023-04-10 04:44:50', '2024-04-10 10:14:50'),
('f28a88e949a150c320d6e8cdb433ebcde291b9454a8abbfe0050db766d793668539de1fb962633fb', 24, 1, 'authToken', '[]', 0, '2023-04-10 01:42:18', '2023-04-10 01:42:18', '2024-04-10 07:12:18'),
('f2a34b09e826a142fce2081bc6cbaaa82d17e5949bec892e3079968bb141b8a7f57f3b37007c35ed', 64, 1, 'authToken', '[]', 0, '2023-06-17 07:49:54', '2023-06-17 07:49:54', '2024-06-17 13:19:54'),
('f3d551d69ad861925b9496e9bb2bbe5564b08bad9fc9dc172aa8f90af05dce942e6bdee74422bcea', 42, 1, 'authToken', '[]', 0, '2023-05-05 01:23:56', '2023-05-05 01:23:56', '2024-05-05 06:53:56'),
('f52def493cf6a4c4a6889f6f8e5a66609870d597cf4ac50ad29741d10eb098b2cbba324951d437e5', 40, 1, 'authToken', '[]', 0, '2023-04-20 00:05:25', '2023-04-20 00:05:25', '2024-04-20 05:35:25'),
('f8549fa5fa8305c5c4c1e0f8642775673b229ae158727b1d040d16af2eb1b38677cd2896d446abe6', 16, 1, 'authToken', '[]', 0, '2023-04-05 01:39:32', '2023-04-05 01:39:32', '2024-04-05 07:09:32'),
('f8fbd50cb6e46fc4dae0c37ad7682338dbfce92624c341c02bbd19c26639635a96875e6fc7a5c1c0', 43, 1, 'authToken', '[]', 0, '2023-05-02 23:33:42', '2023-05-02 23:33:42', '2024-05-03 05:03:42'),
('f96d18f404199162ea45e6d5b1cd04b5783664a37b1779ef1a530e41e9c00a9b209410fcc845b2b3', 47, 1, 'authToken', '[]', 0, '2023-05-18 12:11:30', '2023-05-18 12:11:30', '2024-05-18 17:41:30'),
('f9d304837a905686ff77b338ebfdf54b955e529ab836e727f093a3d648522d0f2d8ba9cf1c10c892', 39, 1, 'authToken', '[]', 0, '2023-04-21 00:55:47', '2023-04-21 00:55:47', '2024-04-21 06:25:47'),
('fa22b7c7f5a4a7c5c45e2cabf8f7bfc12e847dc55f5f322e3731a2474136bb3259874bbc737d4d89', 42, 1, 'authToken', '[]', 0, '2023-05-02 05:11:05', '2023-05-02 05:11:05', '2024-05-02 10:41:05'),
('fa756ffcfb1e39503364bd96690bbf61a6b8802920309c84a6d5d2ce0bd654046def5ea3935f5706', 42, 1, 'authToken', '[]', 0, '2023-05-02 00:52:29', '2023-05-02 00:52:29', '2024-05-02 06:22:29'),
('fad168ef678dcbb6568bdb695a956df2d4309f20de8d9ac9f31d34935f6739c125c4d2a5578dcef9', 42, 1, 'authToken', '[]', 0, '2023-05-02 05:32:05', '2023-05-02 05:32:05', '2024-05-02 11:02:05'),
('fb1630c7190c342b21a90e399e80f0173fcb9c91cd8b4dac60f8bbce386117e3acc90a6025beffee', 16, 1, 'authToken', '[]', 0, '2023-04-12 00:34:23', '2023-04-12 00:34:23', '2024-04-12 06:04:23'),
('fbdfdfb032be7705652a8a31a84ad18175d3a90696a63fe7dbd0ca6ce4a470653ab370a86b3e8f50', 38, 1, 'authToken', '[]', 0, '2023-04-17 01:31:53', '2023-04-17 01:31:53', '2024-04-17 07:01:53'),
('fd45e14e1d7c2628c624584b7a75f1b16d73a06febed153c1b148e6e1b959c73fd58236469df23b2', 64, 1, 'authToken', '[]', 0, '2023-06-17 05:19:02', '2023-06-17 05:19:02', '2024-06-17 10:49:02'),
('fff56bd337f6bc48c0d8cc4a4a56de0bd48c12dab577aeadec4570387183f3d14c1332bc8543ddbe', 64, 1, 'authToken', '[]', 0, '2023-06-21 00:13:39', '2023-06-21 00:13:39', '2024-06-21 05:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Jobstar Personal Access Client', '0RBtABUMBp92x6STa2KpWKFbLTX6F36wrDuqV3DD', NULL, 'http://localhost', 1, 0, 0, '2023-03-21 01:16:58', '2023-03-21 01:16:58'),
(2, NULL, 'Jobstar Password Grant Client', 'SBd6zRuhVMKY93rT5vas6sENwy8Q75w3BHKPjCAR', 'users', 'http://localhost', 0, 1, 0, '2023-03-21 01:16:59', '2023-03-21 01:16:59'),
(3, NULL, 'Jobstar Personal Access Client', '9fbSif7tP587qmhFEaBMrwvGM8tbMPHqL3gg1BNC', NULL, 'http://localhost', 1, 0, 0, '2023-06-17 07:48:04', '2023-06-17 07:48:04'),
(4, NULL, 'Jobstar Personal Access Client', 'RlnPFmHm6sJS51GSMEp0RCAy6px88DsJSv5sNZXN', NULL, 'http://localhost', 1, 0, 0, '2023-06-17 07:49:01', '2023-06-17 07:49:01'),
(5, NULL, 'jobstar', 'Rexw8Yw7UuIOa65WlpSsReV9P1HC4fqWOlfe4MUI', NULL, 'http://localhost', 1, 0, 0, '2023-06-20 23:39:37', '2023-06-20 23:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-03-21 01:16:58', '2023-03-21 01:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_id` int(11) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_types`
--

CREATE TABLE `organization_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_types`
--

INSERT INTO `organization_types` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Government', 'government', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'Semi Government', 'semi-government', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, 'Public', 'public', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'Private', 'private', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, 'NGO', 'ngo', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(6, 'International Agencies', 'international-agencies', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `our_missions`
--

CREATE TABLE `our_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mission_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'frontend/assets/images/banner/about-banner-5.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@abservetech.com', '$2y$10$zjT5661nDVvyuM/zunhRvei8jp9p3PhsZ1AownpAqprl68gLke2Za', '2023-05-31 01:52:02'),
('abservetechphp.com@gmail.com', '$2y$10$YOpMl/2UUSc1Qs3AwdLm5uP5y0aw/t8SxmoCJrXaw8q0jkVhi.4W6', '2023-05-31 23:45:05'),
('abservetechphp@gmail.com', '$2y$10$GbJB92RCkheW0vILixTFqOVP/qB1gDHOkZxQQieXpd/6VDWOZ2jhG', '2023-05-31 23:57:27'),
('dharmadurai.p@technotackle.com', '$2y$10$v6ScXmjS0qpFPK5KzUAveuFZK./eFXTP3CKXyC1WRUBuWEzYcupyG', '2023-06-01 00:13:27'),
('absvigneshwarij@gmail.com', '$2y$10$/FVn/m1Nnk46f30/DrJKK.qwjC7bzxaofWwA6rY9PAOtV0/Xc1Wsi', '2023-06-01 00:31:04'),
('Muthupandi@gmail.com', '$2y$10$rTr4SDbEGID3GKB4YAqa1.21TBhlcZqVBh/4VjokZ40Fx2eKAbgiW', '2023-06-21 01:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paypal` tinyint(1) NOT NULL DEFAULT '1',
  `paypal_live_mode` tinyint(1) NOT NULL DEFAULT '0',
  `stripe` tinyint(1) NOT NULL DEFAULT '1',
  `razorpay` tinyint(1) NOT NULL DEFAULT '1',
  `paystack` tinyint(1) NOT NULL DEFAULT '1',
  `ssl_commerz` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `paypal`, `paypal_live_mode`, `stripe`, `razorpay`, `paystack`, `ssl_commerz`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, 1, 1, 1, '2023-02-24 04:43:19', '2023-02-24 04:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'admin.create', 'admin', 'admin', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(2, 'admin.view', 'admin', 'admin', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(3, 'admin.edit', 'admin', 'admin', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(4, 'admin.delete', 'admin', 'admin', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(5, 'order.view', 'admin', 'order', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(6, 'order.download', 'admin', 'order', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(7, 'company.create', 'admin', 'company', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(8, 'company.view', 'admin', 'company', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(9, 'company.update', 'admin', 'company', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(10, 'company.delete', 'admin', 'company', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(11, 'map.create', 'admin', 'map', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(12, 'map.view', 'admin', 'map', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(13, 'map.update', 'admin', 'map', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(14, 'map.delete', 'admin', 'map', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(15, 'candidate.create', 'admin', 'candidate', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(16, 'candidate.view', 'admin', 'candidate', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(17, 'candidate.update', 'admin', 'candidate', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(18, 'candidate.delete', 'admin', 'candidate', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(19, 'job.create', 'admin', 'job', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(20, 'job.view', 'admin', 'job', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(21, 'job.update', 'admin', 'job', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(22, 'job.delete', 'admin', 'job', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(23, 'job_category.create', 'admin', 'job_category', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(24, 'job_category.view', 'admin', 'job_category', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(25, 'job_category.update', 'admin', 'job_category', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(26, 'job_category.delete', 'admin', 'job_category', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(27, 'job_role.view', 'admin', 'job_role', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(28, 'job_role.create', 'admin', 'job_role', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(29, 'job_role.update', 'admin', 'job_role', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(30, 'job_role.delete', 'admin', 'job_role', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(31, 'plan.create', 'admin', 'price_plan', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(32, 'plan.view', 'admin', 'price_plan', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(33, 'plan.update', 'admin', 'price_plan', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(34, 'plan.delete', 'admin', 'price_plan', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(35, 'industry_types.create', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(36, 'industry_types.view', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(37, 'industry_types.update', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(38, 'industry_types.delete', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(39, 'professions.create', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(40, 'professions.view', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(41, 'professions.update', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(42, 'professions.delete', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(43, 'skills.create', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(44, 'skills.view', 'admin', 'attributes', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(45, 'skills.update', 'admin', 'attributes', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(46, 'skills.delete', 'admin', 'attributes', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(47, 'post.create', 'admin', 'blog', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(48, 'post.view', 'admin', 'blog', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(49, 'post.update', 'admin', 'blog', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(50, 'post.delete', 'admin', 'blog', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(51, 'country.create', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(52, 'country.view', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(53, 'country.update', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(54, 'country.delete', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(55, 'state.create', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(56, 'state.view', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(57, 'state.update', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(58, 'state.delete', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(59, 'city.create', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(60, 'city.view', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(61, 'city.update', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(62, 'city.delete', 'admin', 'location', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(63, 'newsletter.view', 'admin', 'newsletter', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(64, 'newsletter.sendmail', 'admin', 'newsletter', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(65, 'newsletter.delete', 'admin', 'newsletter', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(66, 'contact.view', 'admin', 'contact', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(67, 'contact.delete', 'admin', 'contact', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(68, 'testimonial.create', 'admin', 'testimonial', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(69, 'testimonial.view', 'admin', 'testimonial', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(70, 'testimonial.update', 'admin', 'testimonial', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(71, 'testimonial.delete', 'admin', 'testimonial', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(72, 'faq.create', 'admin', 'faq', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(73, 'faq.view', 'admin', 'faq', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(74, 'faq.update', 'admin', 'faq', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(75, 'faq.delete', 'admin', 'faq', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(76, 'role.create', 'admin', 'role', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(77, 'role.view', 'admin', 'role', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(78, 'role.edit', 'admin', 'role', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(79, 'role.delete', 'admin', 'role', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(80, 'setting.view', 'admin', 'settings', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(81, 'setting.update', 'admin', 'settings', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(82, 'candidate-language.create', 'admin', 'candidate-language', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(83, 'candidate-language.view', 'admin', 'candidate-language', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(84, 'candidate-language.update', 'admin', 'candidate-language', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(85, 'candidate-language.delete', 'admin', 'candidate-language', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(86, 'benefits.create', 'admin', 'attributes', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(87, 'benefits.view', 'admin', 'attributes', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(88, 'benefits.update', 'admin', 'attributes', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(89, 'benefits.delete', 'admin', 'attributes', '2023-02-24 04:43:17', '2023-02-24 04:43:17'),
(90, 'tags.create', 'admin', 'attributes', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(91, 'tags.view', 'admin', 'attributes', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(92, 'tags.update', 'admin', 'attributes', '2023-02-24 04:43:18', '2023-02-24 04:43:18'),
(93, 'tags.delete', 'admin', 'attributes', '2023-02-24 04:43:19', '2023-02-24 04:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `job_limit` int(11) NOT NULL,
  `featured_job_limit` int(11) NOT NULL,
  `highlight_job_limit` int(11) NOT NULL,
  `candidate_cv_view_limit` int(11) NOT NULL DEFAULT '0',
  `recommended` tinyint(1) NOT NULL DEFAULT '0',
  `frontend_show` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `candidate_cv_view_limitation` enum('unlimited','limited') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'limited'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `label`, `description`, `price`, `job_limit`, `featured_job_limit`, `highlight_job_limit`, `candidate_cv_view_limit`, `recommended`, `frontend_show`, `created_at`, `updated_at`, `candidate_cv_view_limitation`) VALUES
(1, 'Trial', 'This is the trial plan', 0.00, 5, 2, 3, 8, 0, 1, '2023-02-24 04:43:20', '2023-03-13 01:53:22', 'limited'),
(2, 'Standard', 'Standard Package', 100.00, 50, 10, 15, 50, 0, 1, '2023-03-07 06:29:21', '2023-03-07 06:30:58', 'limited'),
(3, 'Premium', 'Test Plan', 1000.00, 1000, 500, 300, 300, 1, 1, '2023-03-08 01:13:56', '2023-03-08 01:14:50', 'limited'),
(4, 'test', 'test', 5.00, 5, 5, 5, 5, 0, 0, '2023-03-13 01:55:38', '2023-03-13 01:57:12', 'limited');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `author_id`, `title`, `slug`, `image`, `short_description`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Hire in Madurai & Chennai', 'hire-in-madurai-chennai', 'uploads/post/1678250432_640811c05306f.png', 'You need Indeed’s all-in-one employer hiring platform.​. You need Indeed—one tool to attract, interview, and hire. Post Jobs. Post a Job in Minutes.', '<p><a href=\"https://indeed.com/hire?sid=us_googconthajpmax_sitelinks_hire\">Post a Job</a></p><p>Find out why you should post your jobs on Indeed. It\'s quick &amp; easy!</p><p><a href=\"https://resumes.indeed.com/?kw=%7Bkeyword%7D&amp;sid=%7B_network%7D%7Bifmobile:mob%7D%7B_campaign%7D%7B_adgroup%7D&amp;matchtype=%7Bmatchtype%7D&amp;network=%7Bnetwork%7D&amp;device=%7Bdevice%7D&amp;devicemodel=%7Bdevicemodel%7D&amp;creative=%7Bcreative%7D&amp;keyword=%7Bkeyword%7D&amp;placement=%7Bplacement%7D&amp;param1=%7Bparam1%7D&amp;param2=%7Bparam2%7D&amp;random=%7Brandom%7D&amp;aceid=%7Baceid%7D&amp;adposition=%7Badposition%7D\">Find Resumes</a></p><p>Explore our fast, simple resume search.</p>', 'published', '2023-03-07 23:10:32', '2023-03-07 23:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`id`, `name`, `image`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Zomato', 'uploads/postcategory/1678191915_64072d2b7e276.jpg', NULL, '2023-03-07 06:55:15', '2023-03-07 06:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professions`
--

CREATE TABLE `professions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `professions`
--

INSERT INTO `professions` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Physician', 'physician', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(2, 'Engineer', 'engineer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(3, 'Chef', 'chef', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(4, 'Lawyer', 'lawyer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(5, 'Designer', 'designer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(6, 'Labourer', 'labourer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(7, 'Dentist', 'dentist', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(8, 'Accountant', 'accountant', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(9, 'Dental Hygienist', 'dental-hygienist', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(10, 'Actor', 'actor', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(11, 'Electrician', 'electrician', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(12, 'Software Developer', 'software-developer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(13, 'Pharmacist', 'pharmacist', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(14, 'Technician', 'technician', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(15, 'Artist', 'artist', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(16, 'Teacher', 'teacher', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(17, 'Journalist', 'journalist', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(18, 'Cashier', 'cashier', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(19, 'Secretary', 'secretary', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(20, 'Scientist', 'scientist', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(21, 'Soldier', 'soldier', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(22, 'Gardener', 'gardener', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(23, 'Farmer', 'farmer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(24, 'Librarian', 'librarian', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(25, 'Driver', 'driver', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(26, 'Fishermen', 'fishermen', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(27, 'Police Officer ', 'police-officer', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(28, 'Tailor', 'tailor', '2022-11-08 01:39:30', '2022-11-08 01:39:30'),
(29, 'Photographer', 'photographer', '2023-05-02 05:18:13', '2023-05-02 05:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `profession_translations`
--

CREATE TABLE `profession_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profession_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profession_translations`
--

INSERT INTO `profession_translations` (`id`, `profession_id`, `name`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Physician', 'en', '2023-04-19 20:25:36', '2023-04-19 20:25:36'),
(2, 2, 'Engineer', 'en', '2023-04-19 20:25:36', '2023-04-19 20:25:36'),
(3, 3, 'Chef', 'en', '2023-04-19 20:25:37', '2023-04-19 20:25:37'),
(4, 4, 'Lawyer', 'en', '2023-04-19 20:25:37', '2023-04-19 20:25:37'),
(5, 5, 'Designer', 'en', '2023-04-19 20:25:37', '2023-04-19 20:25:37'),
(6, 6, 'Labourer', 'en', '2023-04-19 20:25:37', '2023-04-19 20:25:37'),
(7, 7, 'Dentist', 'en', '2023-04-19 20:25:37', '2023-04-19 20:25:37'),
(8, 8, 'Accountant', 'en', '2023-04-19 20:25:38', '2023-04-19 20:25:38'),
(9, 9, 'Dental Hygienist', 'en', '2023-04-19 20:25:38', '2023-04-19 20:25:38'),
(10, 10, 'Actor', 'en', '2023-04-19 20:25:38', '2023-04-19 20:25:38'),
(11, 11, 'Electrician', 'en', '2023-04-19 20:25:38', '2023-04-19 20:25:38'),
(12, 12, 'Software Developer', 'en', '2023-04-19 20:25:38', '2023-04-19 20:25:38'),
(13, 13, 'Pharmacist', 'en', '2023-04-19 20:25:38', '2023-04-19 20:25:38'),
(14, 14, 'Technician', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(15, 15, 'Artist', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(16, 16, 'Teacher', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(17, 17, 'Journalist', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(18, 18, 'Cashier', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(19, 19, 'Secretary', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(20, 20, 'Scientist', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(21, 21, 'Soldier', 'en', '2023-04-19 20:25:39', '2023-04-19 20:25:39'),
(22, 22, 'Gardener', 'en', '2023-04-19 20:25:40', '2023-04-19 20:25:40'),
(23, 23, 'Farmer', 'en', '2023-04-19 20:25:40', '2023-04-19 20:25:40'),
(24, 24, 'Librarian', 'en', '2023-04-19 20:25:40', '2023-04-19 20:25:40'),
(25, 25, 'Driver', 'en', '2023-04-19 20:25:40', '2023-04-19 20:25:40'),
(26, 26, 'Fishermen', 'en', '2023-04-19 20:25:40', '2023-04-19 20:25:40'),
(27, 27, 'Police Officer ', 'en', '2023-04-19 20:25:40', '2023-04-19 20:25:40'),
(28, 28, 'Tailor', 'en', '2023-04-19 20:25:40', '2023-04-19 20:25:40'),
(29, 1, 'Physician', 'fr', '2023-05-02 05:17:10', '2023-05-02 05:17:10'),
(30, 29, 'Photographer', 'fr', '2023-05-02 05:18:13', '2023-05-02 05:18:13'),
(31, 29, 'Photographer', 'en', '2023-05-02 05:18:13', '2023-05-02 05:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `queue_jobs`
--

CREATE TABLE `queue_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'admin', '2023-02-24 04:43:16', '2023-02-24 04:43:16'),
(2, 'testadmin', 'admin', '2022-11-08 01:39:30', '2022-11-08 01:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1);

-- --------------------------------------------------------

--
-- Table structure for table `salary_types`
--

CREATE TABLE `salary_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_types`
--

INSERT INTO `salary_types` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Monthly', 'monthly', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'Project Basis', 'project-basis', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, 'Hourly', 'hourly', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'Yearly', 'yearly', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `seos`
--

CREATE TABLE `seos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seos`
--

INSERT INTO `seos` (`id`, `page_slug`, `created_at`, `updated_at`) VALUES
(1, 'home', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, 'jobs', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, 'job-details', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'candidates', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, 'candidate-details', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(6, 'company', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, 'company-details', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(8, 'blog', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(9, 'post-details', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(10, 'pricing', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(11, 'login', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(12, 'register', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(13, 'about', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(14, 'contact', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(15, 'faq', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(16, 'terms-condition', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `seo_page_contents`
--

CREATE TABLE `seo_page_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `language_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo_page_contents`
--

INSERT INTO `seo_page_contents` (`id`, `page_id`, `language_code`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'en', 'Welcome To Job Portal', 'Job Portal is laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1678973635_64131ac361fc8.png', '2023-02-24 04:43:20', '2023-03-16 08:03:55'),
(2, 2, 'en', 'Jobs', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679029911_6413f69768fcf.png', '2023-02-24 04:43:20', '2023-03-17 00:03:39'),
(3, 3, 'en', 'Job Details', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679029937_6413f6b1c23a0.png', '2023-02-24 04:43:20', '2023-03-17 00:04:04'),
(4, 4, 'en', 'Candidates', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030279_6413f80720c7d.png', '2023-02-24 04:43:20', '2023-03-17 00:04:18'),
(5, 5, 'en', 'Candidate Details', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030336_6413f84019ce7.png', '2023-02-24 04:43:20', '2023-03-17 00:04:32'),
(6, 6, 'en', 'Company', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030572_6413f92c2e836.png', '2023-02-24 04:43:20', '2023-03-17 00:04:50'),
(7, 7, 'en', 'Company Details', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030708_6413f9b4bfe0c.png', '2023-02-24 04:43:20', '2023-03-17 00:13:05'),
(8, 8, 'en', 'Blog', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030752_6413f9e02b3ec.png', '2023-02-24 04:43:20', '2023-03-17 00:05:05'),
(9, 9, 'en', 'Post Details', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030793_6413fa09a9567.png', '2023-02-24 04:43:20', '2023-03-17 00:05:21'),
(10, 10, 'en', 'Pricing', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679031114_6413fb4a368a5.png', '2023-02-24 04:43:20', '2023-03-17 00:05:37'),
(11, 11, 'en', 'Login', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679031155_6413fb735b37c.png', '2023-02-24 04:43:20', '2023-03-17 00:05:57'),
(12, 12, 'en', 'Register', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679031076_6413fb24d77b7.png', '2023-02-24 04:43:20', '2023-03-17 00:13:54'),
(13, 13, 'en', 'About', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679031044_6413fb0444ecf.png', '2023-02-24 04:43:20', '2023-03-17 00:06:12'),
(14, 14, 'en', 'Contact', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679031005_6413fadd7de7c.png', '2023-02-24 04:43:20', '2023-03-17 00:06:25'),
(15, 15, 'en', 'FAQ', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030970_6413faba64a2b.png', '2023-02-24 04:43:20', '2023-03-17 00:06:42'),
(16, 16, 'en', 'Terms Condition', 'job portal laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'uploads/images/seo/1679030924_6413fa8c52e14.png', '2023-02-24 04:43:20', '2023-03-17 00:06:56'),
(17, 1, 'fr', 'Welcome To Jobstar', 'Jobstar is laravel script designed to create, manage and publish jobs posts. Companies can create their profile and publish jobs posts. Candidate can apply job posts.', 'frontend/assets/images/jobpilot.png', '2023-03-16 07:17:26', '2023-03-16 07:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dark_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `light_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_css` text COLLATE utf8mb4_unicode_ci,
  `header_script` text COLLATE utf8mb4_unicode_ci,
  `body_script` text COLLATE utf8mb4_unicode_ci,
  `sidebar_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nav_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar_txt_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nav_txt_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accent_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frontend_primary_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frontend_secondary_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_process_step1_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_process_step1_description` text COLLATE utf8mb4_unicode_ci,
  `working_process_step2_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_process_step2_description` text COLLATE utf8mb4_unicode_ci,
  `working_process_step3_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_process_step3_description` text COLLATE utf8mb4_unicode_ci,
  `working_process_step4_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_process_step4_description` text COLLATE utf8mb4_unicode_ci,
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `google_analytics` tinyint(1) NOT NULL DEFAULT '0',
  `search_engine_indexing` tinyint(1) NOT NULL DEFAULT '1',
  `default_layout` tinyint(1) NOT NULL DEFAULT '1',
  `default_plan` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `job_limit` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `featured_job_limit` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `highlight_job_limit` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `language_changing` tinyint(1) NOT NULL DEFAULT '1',
  `email_verification` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `default_map` enum('google-map','map-box','leaflet') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'leaflet',
  `google_map_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_box_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_long` double DEFAULT NULL,
  `default_lat` double DEFAULT NULL,
  `app_country_type` enum('single_base','multiple_base') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'multiple_base',
  `app_country` bigint(20) UNSIGNED DEFAULT NULL,
  `employer_auto_activation` tinyint(1) NOT NULL DEFAULT '1',
  `per_job_active` tinyint(1) NOT NULL DEFAULT '1',
  `per_job_price` double(8,2) DEFAULT '100.00',
  `highlight_job_price` double(8,2) DEFAULT '50.00',
  `featured_job_price` double(8,2) DEFAULT '50.00',
  `candidate_account_auto_activation` tinyint(1) NOT NULL DEFAULT '1',
  `job_auto_approved` tinyint(1) NOT NULL DEFAULT '0',
  `edited_job_auto_approved` tinyint(1) NOT NULL DEFAULT '1',
  `currency_switcher` tinyint(1) NOT NULL DEFAULT '1',
  `highlight_job_days` int(11) DEFAULT '0',
  `featured_job_days` int(11) DEFAULT '0',
  `job_deadline_expiration_limit` int(11) NOT NULL DEFAULT '30'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `email`, `dark_logo`, `light_logo`, `favicon_image`, `header_css`, `header_script`, `body_script`, `sidebar_color`, `nav_color`, `sidebar_txt_color`, `nav_txt_color`, `main_color`, `accent_color`, `frontend_primary_color`, `frontend_secondary_color`, `working_process_step1_title`, `working_process_step1_description`, `working_process_step2_title`, `working_process_step2_description`, `working_process_step3_title`, `working_process_step3_description`, `working_process_step4_title`, `working_process_step4_description`, `dark_mode`, `google_analytics`, `search_engine_indexing`, `default_layout`, `default_plan`, `job_limit`, `featured_job_limit`, `highlight_job_limit`, `timezone`, `language_changing`, `email_verification`, `created_at`, `updated_at`, `default_map`, `google_map_key`, `map_box_key`, `default_long`, `default_lat`, `app_country_type`, `app_country`, `employer_auto_activation`, `per_job_active`, `per_job_price`, `highlight_job_price`, `featured_job_price`, `candidate_account_auto_activation`, `job_auto_approved`, `edited_job_auto_approved`, `currency_switcher`, `highlight_job_days`, `featured_job_days`, `job_deadline_expiration_limit`) VALUES
(1, 'admin@abserve.tech', 'uploads/app/logo/sWaMOI0gYrn53k1XwGSHV5vXTPAQguOwEA7J8KAx.png', 'uploads/app/logo/GFOUUDrLnmQ0qOQY93wpkuxhQ41OIyOi6QBAJ7Cb.png', 'uploads/app/logo/9xbDMvycMLFybwLZqTqHoq1s82kgQxeyy54Y7CG9.png', NULL, NULL, NULL, '#FFFFFF', '#FFFFFF', '#7E7E7E', '#7E7E7E', '#742892', '#272727', '#742892', '#EAB3FF', 'Create Account', 'Aliquam facilisis egestas sapien, nec tempor leo tristique at.', 'Upload Cv Resume', 'Curabitur sit amet maximus ligula. Nam a nulla ante. Nam sodales', 'Find Suitable Job', 'Curabitur sit amet maximus ligula. Nam a nulla ante. Nam sodales', 'Apply Job', 'Curabitur sit amet maximus ligula. Nam a nulla ante. Nam sodales', 0, 0, 1, 1, 1, 1, 1, 1, 'UTC', 1, 0, '2023-02-24 04:43:19', '2023-06-14 05:49:52', 'google-map', 'AIzaSyBZvKhc06Ms4EXO2ApwcB99LUEwQrrL8f0', NULL, -72.41666666, 19, 'single_base', 99, 1, 1, 100.00, 50.00, 50.00, 1, 0, 1, 1, 0, 0, 30);

-- --------------------------------------------------------

--
-- Table structure for table `setup_guides`
--

CREATE TABLE `setup_guides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_guides`
--

INSERT INTO `setup_guides` (`id`, `task_name`, `title`, `description`, `action_route`, `action_label`, `status`, `created_at`, `updated_at`) VALUES
(1, 'app_setting', 'App Information ', 'Add your app logo, name, description, owner and other information.', 'settings.general', 'Add App Information', 1, '2023-02-24 04:43:20', '2023-03-16 07:22:02'),
(2, 'smtp_setting', 'SMTP Configuration', 'Add your app logo, name, description, owner and other information.', 'settings.email', 'Add Mail Configuration', 1, '2023-02-24 04:43:20', '2023-06-01 01:55:25'),
(3, 'payment_setting', 'Enable Payment Method', 'Enable to payment methods to receive payments from your customer.', 'settings.payment', 'Add Payment', 1, '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, 'theme_setting', 'Customize Theme', 'Customize your theme to make your app look more attractive.', 'settings.theme', 'Customize Your App Now', 1, '2023-02-24 04:43:20', '2023-03-08 02:29:11');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(2, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(3, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(4, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(5, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(6, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(7, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(8, NULL, NULL, '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(9, NULL, NULL, '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(10, NULL, NULL, '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(11, NULL, NULL, '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(12, NULL, NULL, '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(13, NULL, NULL, '2023-04-19 00:10:20', '2023-04-19 00:10:20'),
(15, NULL, NULL, '2023-05-02 05:25:11', '2023-05-02 05:25:11'),
(16, NULL, NULL, '2023-05-02 05:34:22', '2023-05-02 05:34:22'),
(17, NULL, NULL, '2023-05-03 00:38:23', '2023-05-03 00:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `skill_translations`
--

CREATE TABLE `skill_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skill_translations`
--

INSERT INTO `skill_translations` (`id`, `skill_id`, `name`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'html', 'en', '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(2, 2, 'css', 'en', '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(3, 3, 'js', 'en', '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(4, 4, 'php', 'en', '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(5, 5, 'laravel', 'en', '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(6, 6, 'mysql', 'en', '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(7, 7, 'vuejs', 'en', '2023-04-19 00:07:30', '2023-04-19 00:07:30'),
(8, 8, 'reactjs', 'en', '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(9, 9, 'nodejs', 'en', '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(10, 10, 'expressjs', 'en', '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(11, 11, 'python', 'en', '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(12, 12, 'django', 'en', '2023-04-19 00:07:31', '2023-04-19 00:07:31'),
(13, 13, 'java', 'en', '2023-04-19 00:10:20', '2023-04-19 00:10:20'),
(14, 1, 'html', 'fr', '2023-05-02 05:12:20', '2023-05-02 05:12:20'),
(17, 15, 'Leadership', 'en', '2023-05-02 05:25:11', '2023-05-02 05:25:11'),
(18, 15, 'Leadership', 'fr', '2023-05-02 05:25:11', '2023-05-02 05:25:11'),
(19, 16, 'Project management', 'en', '2023-05-02 05:34:22', '2023-05-02 05:34:22'),
(20, 16, 'Project management', 'fr', '2023-05-02 05:34:22', '2023-05-02 05:34:22'),
(21, 17, 'Problem solving', 'en', '2023-05-03 00:38:23', '2023-05-03 00:38:23'),
(22, 17, 'Résolution de problème', 'fr', '2023-05-03 00:38:23', '2023-05-03 00:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `social_media` enum('facebook','twitter','instagram','youtube','linkedin','pinterest','reddit','github','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `user_id`, `social_media`, `url`, `created_at`, `updated_at`) VALUES
(9, 60, 'facebook', 'https://www.facebook.com/abservetech/', '2023-04-18 02:45:51', '2023-04-18 02:45:51'),
(10, 40, 'other', 'https://stackoverflow.com/questions/62254797/android-app-crash-retrofit2-httpexception-http-401', '2023-04-19 08:24:35', '2023-04-19 08:24:35'),
(11, 52, 'instagram', 'http://instagram.com', '2023-05-31 06:59:47', '2023-05-31 06:59:47'),
(12, 65, 'facebook', 'http://www.facebook.com/mersalsaravanan', '2023-06-22 05:50:11', '2023-06-22 05:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_popular_list` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `created_at`, `updated_at`, `show_popular_list`) VALUES
(1, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(2, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(3, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(4, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(5, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(6, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(7, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(8, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(9, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(10, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(11, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(12, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(13, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(14, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(15, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(16, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(17, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(18, '2023-02-24 04:43:21', '2023-02-24 04:43:21', 0),
(19, '2023-03-07 06:34:02', '2023-03-07 06:34:02', 0),
(20, '2023-03-07 06:34:02', '2023-03-07 06:34:02', 0),
(21, '2023-03-11 03:53:14', '2023-03-11 03:53:14', 0),
(22, '2023-03-11 03:53:14', '2023-03-11 03:53:14', 0),
(23, '2023-03-11 04:01:23', '2023-03-11 04:01:23', 0),
(24, '2023-03-11 04:05:48', '2023-03-11 04:05:48', 0),
(25, '2023-03-11 04:40:24', '2023-03-11 04:40:24', 0),
(26, '2023-03-11 04:43:18', '2023-03-11 04:43:18', 0),
(27, '2023-03-11 05:14:08', '2023-03-11 05:14:08', 0),
(28, '2023-04-21 05:38:31', '2023-04-21 05:38:31', 0),
(29, '2023-04-21 05:38:31', '2023-04-21 05:38:31', 0),
(30, '2023-04-21 05:38:31', '2023-04-21 05:38:31', 0),
(31, '2023-04-21 05:38:31', '2023-04-21 05:38:31', 0),
(32, '2023-05-03 00:34:18', '2023-05-03 00:34:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tag_translations`
--

CREATE TABLE `tag_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tag_translations`
--

INSERT INTO `tag_translations` (`id`, `tag_id`, `name`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'php', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(2, 2, 'laravel', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(3, 3, 'mysql', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(4, 4, 'job', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(5, 5, 'frontend', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(6, 6, 'backend', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(7, 7, 'bootstrap', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(8, 8, 'team', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(9, 9, 'testing', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(10, 10, 'database', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(11, 11, 'jobs', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(12, 12, 'remote', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(13, 13, 'others', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(14, 14, 'seeker', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(15, 15, 'candidate', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(16, 16, 'company', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(17, 17, 'technology', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(18, 18, 'work', 'en', '2023-02-24 04:43:21', '2023-02-24 04:43:21'),
(19, 19, 'SEO', 'en', '2023-03-07 06:34:02', '2023-03-07 06:34:02'),
(20, 20, 'Marketing', 'en', '2023-03-07 06:34:02', '2023-03-07 06:34:02'),
(21, 21, 'Forklift', 'en', '2023-03-11 03:53:14', '2023-03-11 03:53:14'),
(22, 22, 'Driver', 'en', '2023-03-11 03:53:14', '2023-03-11 03:53:14'),
(23, 23, 'Warehouse Operative', 'en', '2023-03-11 04:01:23', '2023-03-11 04:01:23'),
(24, 24, 'Warehouse Order Picker', 'en', '2023-03-11 04:05:48', '2023-03-11 04:05:48'),
(25, 25, 'Salesman', 'en', '2023-03-11 04:40:24', '2023-03-11 04:40:24'),
(26, 26, 'Forklift Driver', 'en', '2023-03-11 04:43:18', '2023-03-11 04:43:18'),
(27, 27, 'sales', 'en', '2023-03-11 05:14:08', '2023-03-11 05:14:08'),
(28, 28, 'html5', 'en', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(29, 28, 'html5', 'fr', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(30, 29, 'css3', 'en', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(31, 29, 'css3', 'fr', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(32, 30, 'jQuery', 'en', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(33, 30, 'jQuery', 'fr', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(34, 31, 'Javascript', 'en', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(35, 31, 'Javascript', 'fr', '2023-04-21 05:38:31', '2023-04-21 05:38:31'),
(36, 32, 'Wordpress', 'fr', '2023-05-03 00:34:18', '2023-05-03 00:34:18'),
(37, 32, 'Wordpress', 'en', '2023-05-03 00:34:18', '2023-05-03 00:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `team_sizes`
--

CREATE TABLE `team_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_sizes`
--

INSERT INTO `team_sizes` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Only Me', 'only-me', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(2, '10 Members', '10-members', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(3, '10-20 Members', '10-20-members', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(4, '20-50 Members', '20-50-members', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(5, '50-100 Members', '50-100-members', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(6, '100-200 Members', '100-200-members', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(7, '200-500 Members', '200-500-members', '2023-02-24 04:43:20', '2023-02-24 04:43:20'),
(8, '500+ Members', '500-members', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `terms_categories`
--

CREATE TABLE `terms_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stars` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `value`) VALUES
(1, 'Africa/Abidjan'),
(2, 'Africa/Accra'),
(3, 'Africa/Addis_Ababa'),
(4, 'Africa/Algiers'),
(5, 'Africa/Asmara'),
(6, 'Africa/Bamako'),
(7, 'Africa/Bangui'),
(8, 'Africa/Banjul'),
(9, 'Africa/Bissau'),
(10, 'Africa/Blantyre'),
(11, 'Africa/Brazzaville'),
(12, 'Africa/Bujumbura'),
(13, 'Africa/Cairo'),
(14, 'Africa/Casablanca'),
(15, 'Africa/Ceuta'),
(16, 'Africa/Conakry'),
(17, 'Africa/Dakar'),
(18, 'Africa/Dar_es_Salaam'),
(19, 'Africa/Djibouti'),
(20, 'Africa/Douala'),
(21, 'Africa/El_Aaiun'),
(22, 'Africa/Freetown'),
(23, 'Africa/Gaborone'),
(24, 'Africa/Harare'),
(25, 'Africa/Johannesburg'),
(26, 'Africa/Juba'),
(27, 'Africa/Kampala'),
(28, 'Africa/Khartoum'),
(29, 'Africa/Kigali'),
(30, 'Africa/Kinshasa'),
(31, 'Africa/Lagos'),
(32, 'Africa/Libreville'),
(33, 'Africa/Lome'),
(34, 'Africa/Luanda'),
(35, 'Africa/Lubumbashi'),
(36, 'Africa/Lusaka'),
(37, 'Africa/Malabo'),
(38, 'Africa/Maputo'),
(39, 'Africa/Maseru'),
(40, 'Africa/Mbabane'),
(41, 'Africa/Mogadishu'),
(42, 'Africa/Monrovia'),
(43, 'Africa/Nairobi'),
(44, 'Africa/Ndjamena'),
(45, 'Africa/Niamey'),
(46, 'Africa/Nouakchott'),
(47, 'Africa/Ouagadougou'),
(48, 'Africa/Porto-Novo'),
(49, 'Africa/Sao_Tome'),
(50, 'Africa/Tripoli'),
(51, 'Africa/Tunis'),
(52, 'Africa/Windhoek'),
(53, 'America/Adak'),
(54, 'America/Anchorage'),
(55, 'America/Anguilla'),
(56, 'America/Antigua'),
(57, 'America/Araguaina'),
(58, 'America/Argentina/Buenos_Aires'),
(59, 'America/Argentina/Catamarca'),
(60, 'America/Argentina/Cordoba'),
(61, 'America/Argentina/Jujuy'),
(62, 'America/Argentina/La_Rioja'),
(63, 'America/Argentina/Mendoza'),
(64, 'America/Argentina/Rio_Gallegos'),
(65, 'America/Argentina/Salta'),
(66, 'America/Argentina/San_Juan'),
(67, 'America/Argentina/San_Luis'),
(68, 'America/Argentina/Tucuman'),
(69, 'America/Argentina/Ushuaia'),
(70, 'America/Aruba'),
(71, 'America/Asuncion'),
(72, 'America/Atikokan'),
(73, 'America/Bahia'),
(74, 'America/Bahia_Banderas'),
(75, 'America/Barbados'),
(76, 'America/Belem'),
(77, 'America/Belize'),
(78, 'America/Blanc-Sablon'),
(79, 'America/Boa_Vista'),
(80, 'America/Bogota'),
(81, 'America/Boise'),
(82, 'America/Cambridge_Bay'),
(83, 'America/Campo_Grande'),
(84, 'America/Cancun'),
(85, 'America/Caracas'),
(86, 'America/Cayenne'),
(87, 'America/Cayman'),
(88, 'America/Chicago'),
(89, 'America/Chihuahua'),
(90, 'America/Ciudad_Juarez'),
(91, 'America/Costa_Rica'),
(92, 'America/Creston'),
(93, 'America/Cuiaba'),
(94, 'America/Curacao'),
(95, 'America/Danmarkshavn'),
(96, 'America/Dawson'),
(97, 'America/Dawson_Creek'),
(98, 'America/Denver'),
(99, 'America/Detroit'),
(100, 'America/Dominica'),
(101, 'America/Edmonton'),
(102, 'America/Eirunepe'),
(103, 'America/El_Salvador'),
(104, 'America/Fort_Nelson'),
(105, 'America/Fortaleza'),
(106, 'America/Glace_Bay'),
(107, 'America/Goose_Bay'),
(108, 'America/Grand_Turk'),
(109, 'America/Grenada'),
(110, 'America/Guadeloupe'),
(111, 'America/Guatemala'),
(112, 'America/Guayaquil'),
(113, 'America/Guyana'),
(114, 'America/Halifax'),
(115, 'America/Havana'),
(116, 'America/Hermosillo'),
(117, 'America/Indiana/Indianapolis'),
(118, 'America/Indiana/Knox'),
(119, 'America/Indiana/Marengo'),
(120, 'America/Indiana/Petersburg'),
(121, 'America/Indiana/Tell_City'),
(122, 'America/Indiana/Vevay'),
(123, 'America/Indiana/Vincennes'),
(124, 'America/Indiana/Winamac'),
(125, 'America/Inuvik'),
(126, 'America/Iqaluit'),
(127, 'America/Jamaica'),
(128, 'America/Juneau'),
(129, 'America/Kentucky/Louisville'),
(130, 'America/Kentucky/Monticello'),
(131, 'America/Kralendijk'),
(132, 'America/La_Paz'),
(133, 'America/Lima'),
(134, 'America/Los_Angeles'),
(135, 'America/Lower_Princes'),
(136, 'America/Maceio'),
(137, 'America/Managua'),
(138, 'America/Manaus'),
(139, 'America/Marigot'),
(140, 'America/Martinique'),
(141, 'America/Matamoros'),
(142, 'America/Mazatlan'),
(143, 'America/Menominee'),
(144, 'America/Merida'),
(145, 'America/Metlakatla'),
(146, 'America/Mexico_City'),
(147, 'America/Miquelon'),
(148, 'America/Moncton'),
(149, 'America/Monterrey'),
(150, 'America/Montevideo'),
(151, 'America/Montserrat'),
(152, 'America/Nassau'),
(153, 'America/New_York'),
(154, 'America/Nome'),
(155, 'America/Noronha'),
(156, 'America/North_Dakota/Beulah'),
(157, 'America/North_Dakota/Center'),
(158, 'America/North_Dakota/New_Salem'),
(159, 'America/Nuuk'),
(160, 'America/Ojinaga'),
(161, 'America/Panama'),
(162, 'America/Paramaribo'),
(163, 'America/Phoenix'),
(164, 'America/Port-au-Prince'),
(165, 'America/Port_of_Spain'),
(166, 'America/Porto_Velho'),
(167, 'America/Puerto_Rico'),
(168, 'America/Punta_Arenas'),
(169, 'America/Rankin_Inlet'),
(170, 'America/Recife'),
(171, 'America/Regina'),
(172, 'America/Resolute'),
(173, 'America/Rio_Branco'),
(174, 'America/Santarem'),
(175, 'America/Santiago'),
(176, 'America/Santo_Domingo'),
(177, 'America/Sao_Paulo'),
(178, 'America/Scoresbysund'),
(179, 'America/Sitka'),
(180, 'America/St_Barthelemy'),
(181, 'America/St_Johns'),
(182, 'America/St_Kitts'),
(183, 'America/St_Lucia'),
(184, 'America/St_Thomas'),
(185, 'America/St_Vincent'),
(186, 'America/Swift_Current'),
(187, 'America/Tegucigalpa'),
(188, 'America/Thule'),
(189, 'America/Tijuana'),
(190, 'America/Toronto'),
(191, 'America/Tortola'),
(192, 'America/Vancouver'),
(193, 'America/Whitehorse'),
(194, 'America/Winnipeg'),
(195, 'America/Yakutat'),
(196, 'America/Yellowknife'),
(197, 'Antarctica/Casey'),
(198, 'Antarctica/Davis'),
(199, 'Antarctica/DumontDUrville'),
(200, 'Antarctica/Macquarie'),
(201, 'Antarctica/Mawson'),
(202, 'Antarctica/McMurdo'),
(203, 'Antarctica/Palmer'),
(204, 'Antarctica/Rothera'),
(205, 'Antarctica/Syowa'),
(206, 'Antarctica/Troll'),
(207, 'Antarctica/Vostok'),
(208, 'Arctic/Longyearbyen'),
(209, 'Asia/Aden'),
(210, 'Asia/Almaty'),
(211, 'Asia/Amman'),
(212, 'Asia/Anadyr'),
(213, 'Asia/Aqtau'),
(214, 'Asia/Aqtobe'),
(215, 'Asia/Ashgabat'),
(216, 'Asia/Atyrau'),
(217, 'Asia/Baghdad'),
(218, 'Asia/Bahrain'),
(219, 'Asia/Baku'),
(220, 'Asia/Bangkok'),
(221, 'Asia/Barnaul'),
(222, 'Asia/Beirut'),
(223, 'Asia/Bishkek'),
(224, 'Asia/Brunei'),
(225, 'Asia/Chita'),
(226, 'Asia/Choibalsan'),
(227, 'Asia/Colombo'),
(228, 'Asia/Damascus'),
(229, 'Asia/Dhaka'),
(230, 'Asia/Dili'),
(231, 'Asia/Dubai'),
(232, 'Asia/Dushanbe'),
(233, 'Asia/Famagusta'),
(234, 'Asia/Gaza'),
(235, 'Asia/Hebron'),
(236, 'Asia/Ho_Chi_Minh'),
(237, 'Asia/Hong_Kong'),
(238, 'Asia/Hovd'),
(239, 'Asia/Irkutsk'),
(240, 'Asia/Jakarta'),
(241, 'Asia/Jayapura'),
(242, 'Asia/Jerusalem'),
(243, 'Asia/Kabul'),
(244, 'Asia/Kamchatka'),
(245, 'Asia/Karachi'),
(246, 'Asia/Kathmandu'),
(247, 'Asia/Khandyga'),
(248, 'Asia/Kolkata'),
(249, 'Asia/Krasnoyarsk'),
(250, 'Asia/Kuala_Lumpur'),
(251, 'Asia/Kuching'),
(252, 'Asia/Kuwait'),
(253, 'Asia/Macau'),
(254, 'Asia/Magadan'),
(255, 'Asia/Makassar'),
(256, 'Asia/Manila'),
(257, 'Asia/Muscat'),
(258, 'Asia/Nicosia'),
(259, 'Asia/Novokuznetsk'),
(260, 'Asia/Novosibirsk'),
(261, 'Asia/Omsk'),
(262, 'Asia/Oral'),
(263, 'Asia/Phnom_Penh'),
(264, 'Asia/Pontianak'),
(265, 'Asia/Pyongyang'),
(266, 'Asia/Qatar'),
(267, 'Asia/Qostanay'),
(268, 'Asia/Qyzylorda'),
(269, 'Asia/Riyadh'),
(270, 'Asia/Sakhalin'),
(271, 'Asia/Samarkand'),
(272, 'Asia/Seoul'),
(273, 'Asia/Shanghai'),
(274, 'Asia/Singapore'),
(275, 'Asia/Srednekolymsk'),
(276, 'Asia/Taipei'),
(277, 'Asia/Tashkent'),
(278, 'Asia/Tbilisi'),
(279, 'Asia/Tehran'),
(280, 'Asia/Thimphu'),
(281, 'Asia/Tokyo'),
(282, 'Asia/Tomsk'),
(283, 'Asia/Ulaanbaatar'),
(284, 'Asia/Urumqi'),
(285, 'Asia/Ust-Nera'),
(286, 'Asia/Vientiane'),
(287, 'Asia/Vladivostok'),
(288, 'Asia/Yakutsk'),
(289, 'Asia/Yangon'),
(290, 'Asia/Yekaterinburg'),
(291, 'Asia/Yerevan'),
(292, 'Atlantic/Azores'),
(293, 'Atlantic/Bermuda'),
(294, 'Atlantic/Canary'),
(295, 'Atlantic/Cape_Verde'),
(296, 'Atlantic/Faroe'),
(297, 'Atlantic/Madeira'),
(298, 'Atlantic/Reykjavik'),
(299, 'Atlantic/South_Georgia'),
(300, 'Atlantic/St_Helena'),
(301, 'Atlantic/Stanley'),
(302, 'Australia/Adelaide'),
(303, 'Australia/Brisbane'),
(304, 'Australia/Broken_Hill'),
(305, 'Australia/Darwin'),
(306, 'Australia/Eucla'),
(307, 'Australia/Hobart'),
(308, 'Australia/Lindeman'),
(309, 'Australia/Lord_Howe'),
(310, 'Australia/Melbourne'),
(311, 'Australia/Perth'),
(312, 'Australia/Sydney'),
(313, 'Europe/Amsterdam'),
(314, 'Europe/Andorra'),
(315, 'Europe/Astrakhan'),
(316, 'Europe/Athens'),
(317, 'Europe/Belgrade'),
(318, 'Europe/Berlin'),
(319, 'Europe/Bratislava'),
(320, 'Europe/Brussels'),
(321, 'Europe/Bucharest'),
(322, 'Europe/Budapest'),
(323, 'Europe/Busingen'),
(324, 'Europe/Chisinau'),
(325, 'Europe/Copenhagen'),
(326, 'Europe/Dublin'),
(327, 'Europe/Gibraltar'),
(328, 'Europe/Guernsey'),
(329, 'Europe/Helsinki'),
(330, 'Europe/Isle_of_Man'),
(331, 'Europe/Istanbul'),
(332, 'Europe/Jersey'),
(333, 'Europe/Kaliningrad'),
(334, 'Europe/Kirov'),
(335, 'Europe/Kyiv'),
(336, 'Europe/Lisbon'),
(337, 'Europe/Ljubljana'),
(338, 'Europe/London'),
(339, 'Europe/Luxembourg'),
(340, 'Europe/Madrid'),
(341, 'Europe/Malta'),
(342, 'Europe/Mariehamn'),
(343, 'Europe/Minsk'),
(344, 'Europe/Monaco'),
(345, 'Europe/Moscow'),
(346, 'Europe/Oslo'),
(347, 'Europe/Paris'),
(348, 'Europe/Podgorica'),
(349, 'Europe/Prague'),
(350, 'Europe/Riga'),
(351, 'Europe/Rome'),
(352, 'Europe/Samara'),
(353, 'Europe/San_Marino'),
(354, 'Europe/Sarajevo'),
(355, 'Europe/Saratov'),
(356, 'Europe/Simferopol'),
(357, 'Europe/Skopje'),
(358, 'Europe/Sofia'),
(359, 'Europe/Stockholm'),
(360, 'Europe/Tallinn'),
(361, 'Europe/Tirane'),
(362, 'Europe/Ulyanovsk'),
(363, 'Europe/Vaduz'),
(364, 'Europe/Vatican'),
(365, 'Europe/Vienna'),
(366, 'Europe/Vilnius'),
(367, 'Europe/Volgograd'),
(368, 'Europe/Warsaw'),
(369, 'Europe/Zagreb'),
(370, 'Europe/Zurich'),
(371, 'Indian/Antananarivo'),
(372, 'Indian/Chagos'),
(373, 'Indian/Christmas'),
(374, 'Indian/Cocos'),
(375, 'Indian/Comoro'),
(376, 'Indian/Kerguelen'),
(377, 'Indian/Mahe'),
(378, 'Indian/Maldives'),
(379, 'Indian/Mauritius'),
(380, 'Indian/Mayotte'),
(381, 'Indian/Reunion'),
(382, 'Pacific/Apia'),
(383, 'Pacific/Auckland'),
(384, 'Pacific/Bougainville'),
(385, 'Pacific/Chatham'),
(386, 'Pacific/Chuuk'),
(387, 'Pacific/Easter'),
(388, 'Pacific/Efate'),
(389, 'Pacific/Fakaofo'),
(390, 'Pacific/Fiji'),
(391, 'Pacific/Funafuti'),
(392, 'Pacific/Galapagos'),
(393, 'Pacific/Gambier'),
(394, 'Pacific/Guadalcanal'),
(395, 'Pacific/Guam'),
(396, 'Pacific/Honolulu'),
(397, 'Pacific/Kanton'),
(398, 'Pacific/Kiritimati'),
(399, 'Pacific/Kosrae'),
(400, 'Pacific/Kwajalein'),
(401, 'Pacific/Majuro'),
(402, 'Pacific/Marquesas'),
(403, 'Pacific/Midway'),
(404, 'Pacific/Nauru'),
(405, 'Pacific/Niue'),
(406, 'Pacific/Norfolk'),
(407, 'Pacific/Noumea'),
(408, 'Pacific/Pago_Pago'),
(409, 'Pacific/Palau'),
(410, 'Pacific/Pitcairn'),
(411, 'Pacific/Pohnpei'),
(412, 'Pacific/Port_Moresby'),
(413, 'Pacific/Rarotonga'),
(414, 'Pacific/Saipan'),
(415, 'Pacific/Tahiti'),
(416, 'Pacific/Tarawa'),
(417, 'Pacific/Tongatapu'),
(418, 'Pacific/Wake'),
(419, 'Pacific/Wallis'),
(420, 'UTC');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` text COLLATE utf8mb4_unicode_ci,
  `last_name` text COLLATE utf8mb4_unicode_ci,
  `mobile_num` bigint(20) DEFAULT NULL,
  `mobile_otp` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend/image/default.png',
  `role` enum('company','candidate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'candidate',
  `city` text COLLATE utf8mb4_unicode_ci,
  `country` text COLLATE utf8mb4_unicode_ci,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recent_activities_alert` tinyint(1) NOT NULL DEFAULT '1',
  `job_expired_alert` tinyint(1) NOT NULL DEFAULT '1',
  `new_job_alert` tinyint(1) NOT NULL DEFAULT '1',
  `shortlisted_alert` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `api_token` text COLLATE utf8mb4_unicode_ci,
  `is_demo_field` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder` int(11) DEFAULT NULL,
  `auth_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'email',
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `mobile_num`, `mobile_otp`, `username`, `email`, `password`, `confirm_password`, `email_verified_at`, `image`, `role`, `city`, `country`, `gender`, `recent_activities_alert`, `job_expired_alert`, `new_job_alert`, `shortlisted_alert`, `status`, `api_token`, `is_demo_field`, `remember_token`, `created_at`, `updated_at`, `reminder`, `auth_type`, `google_id`, `facebook_id`, `provider`, `provider_id`) VALUES
(1, 'Adobe', NULL, NULL, NULL, NULL, 'Tester', 'abstesting12@gmail.com', '$2y$10$ZH4U5LcIRqmzGf5Mg4cBDu4Ui0QpZju87QR9bspy3FNLktQYLOKRm', NULL, '2023-03-11 04:16:31', 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNzU0YWEyZGFkMmY3MDZmNjE0YzhmNmE2ZWI3MTU5YjA1OWQ2YzAzMTVlMGQwZGI2NzQwMTFkMjU1YTgyZGRlM2YwMDU0NjI4OGZjOTExYzgiLCJpYXQiOjE2ODY2MzY1ODEuMzU1ODAyLCJuYmYiOjE2ODY2MzY1ODEuMzU1ODA0LCJleHAiOjE3MTgyNTg5ODEuMzExMjczLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.cJrXV-wA2pa46TlS5-xk47u5vFJsvsXoSoQFmcoJbg5v3kfVzHF7OPlrmNeSW6PHGvzsnxJ_fFC4ai_eOwdS-csPJ_hwYq73VAZbGNv3rD9eavRMDVwJPrqYMxZ6U_cmC6x8J_0BAO9L7qyrjO1lSTsSKZ0ywFGNh_Dee1vaiYBXtDLscHYTB2BAdVeApbD3D_cPQPvAYFPE4alo5BGkBWbMJWrAhXnW4_1_4zfFdhqFdO1cJ7EYwqAyywTHwYOUK_wICthw9leNgdzaJwsGlP5cCM3eIULqF9FTGLindz0MFwYKUBqGo9USvTS3XjIpmzkg3o8gdDxSUX7fbrnKf1ObQ1JCA6Nd6bpjniqLRktrRTny-ko-20Ca_mBXBuI2yjCWswasQpsB7f3vVcR-F2a7sp1VxCetGG5AlSn3Ootp7KnHV7f-pZ4vg8eW-fVMYAuaIYy844jEhMQ7O8kTDtiffCjkDmfPLmNOczn2qD_pywUvIYAA1aEFvZ5bbhZT30NVvgSEnZKQXIDHVSwaz_n4D2-UBCOmzBbSlYpBHBI_u5ICTfn_0GM0SdxviXn4AQKxuZL4s6B6S719amh_cgFCt0pAKzjH0NSSvPWTzC2HiwAmSGvL6eYWOTIgckksvKH75gjO8TVLnZhaYTjRNTiC3NqXNq7fxGs8UdacRU0', 0, NULL, '2023-03-07 05:33:57', '2023-06-13 00:39:41', NULL, 'email', NULL, NULL, NULL, NULL),
(2, 'Ericsson', NULL, NULL, NULL, NULL, 'ericson', 'ericson23@gmail.com', '$2y$10$kwN0Y6MivJyL8NlYL/gE/uh1BsEoJ/12XmQKeEj946ZihnhtD4Tbq', NULL, '2023-03-11 04:16:29', 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-03-07 05:41:21', '2023-04-19 06:47:58', NULL, 'email', NULL, NULL, NULL, NULL),
(3, 'ORACLE', NULL, NULL, NULL, NULL, 'test-support-company', 'oracle@gmail.com', '$2y$10$cjArT5JdVH4Pe6VhQ/AUa.2eq3ka7pI6YMby1bvC1R5Tudv6WoErC', NULL, '2023-03-07 06:42:11', 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOGFkMTgwZDM3ODZjOGExNmM0NmUyODI0YjVmZmVhMTQ5OTU0NjA4YTBmZTA5ODRlZGU5NDUwYzU3Yjg2MzczNTJmYzY1ZmEyY2Q0NjU5MmUiLCJpYXQiOjE2ODEyODcwNjYuNzQxMTc1ODg5OTY4ODcyMDcwMzEyNSwibmJmIjoxNjgxMjg3MDY2Ljc0MTE3OTk0MzA4NDcxNjc5Njg3NSwiZXhwIjoxNzEyOTA5NDY2LjczODEzMTk5OTk2OTQ4MjQyMTg3NSwic3ViIjoiMyIsInNjb3BlcyI6W119.xnsPE6h_ZoDWDJ5wwaB1OE1dGQPtCAT7CCa8G2RIhY5w3L5FdVZ7wXDLLwB4PDsmZUU7YvVgWvNLvWAaH20eNJeTql5GKCk8LnHiz2GskOE3r_GfIOLgyFrUqw4r195wQONsBzWUm8p90LUyKB1Wg1cgKt_Lr2VeKSrggovKcVJqbJtGXPGfX0PBTdJxtbDXOVF_VwN-x_4AS6ODrk3JVdwK_G1vsPcYEcaWJbN-zUhqfT0-ccP__8TYmd26_qwaxjulyBhs1DKsUbf4EIOYuMX2--WtJUA1ss_F8U1bJ9t1lmvXwTpOmu9hmuLTWVFNuGTCXyvrd8WvkauiLpyCBNG6q2yq3VLbhVAlCF-jTblkuA7CK-y75E4rxW9HA9pTBITg0s9Su4MFJCzSRKKKMFSABI4tLyF3gSbbQ8MFpvxg49egfJLcL7ZnbAMktKCWFWoGdELJiY8GTRC2GZNBOXVHtvsFO5N7X6g1ITU7ckOURgKWJEqt3-bfgipP01qKJVK3CEhTw6yGhfXiyoNiaLLDOLjl__Scn4TDnMAsd6Wxl-1hOOH9oTgGrsMVyQeM2-FdEbvL781Rq_duVvrBI-sbBw3O7L21seratIALW3rtv4FMmoo1LD_1-A98DV4qqAj1VPlozKH4BiBSOYgtcRRTAA5I9BTNJf23zuEA5ac', 0, '6oLI8mUViVDhna3WNVQi3qHMhz9qLNmGaI1gk8Jp5yEu3Ylt0TIY8wbgTxKA', '2023-03-07 05:50:27', '2023-04-18 00:55:29', NULL, 'email', NULL, NULL, NULL, NULL),
(4, 'JosePhine', NULL, NULL, NULL, NULL, 'kvaneeswari122', 'jose@gmail.com', '$2y$10$fSjVW4HXBjOU75waciwRduwuHS4dnDbJUMlBEfAVqQuUgI47FH0fS', '$2y$10$pc12C9eGu37IYRYgHq3Rxeg9aLC0wvhBX/zpsiGJ9uKzc7FJH9tRK', '2023-03-07 06:10:30', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMmUxMDUxNmY1YTlkYTczN2Y2ZTBkZDgzMzZkZjEyN2MwYTIyNjQ4M2EwOGQ4OTQxZjZmNWE2NmRhMTM0MTFiMzI5ZDkxZGU4NDI3OTNiZjMiLCJpYXQiOjE2ODU1MTkxNTQuNjE3NDA1ODkxNDE4NDU3MDMxMjUsIm5iZiI6MTY4NTUxOTE1NC42MTc0MDgwMzcxODU2Njg5NDUzMTI1LCJleHAiOjE3MTcxNDE1NTQuNjA4NjA2MTAwMDgyMzk3NDYwOTM3NSwic3ViIjoiNCIsInNjb3BlcyI6W119.wPqqy63KRfdlaLaOFQx0JT8zTi10OGFLex8vNqia3v5XHQb8AcKoy39bUZpipHq6Jx4nSelw_ln1yI1qjuZtVOUcgoZZGXzo6sdEJ0QNJVk5l5hB-gSoa8kQ31-pWmv3UT8yedwDIedfscxENwSNyGeW-RhLDBxxr4Qa4MpF_tM8xDtFfjiJwWugUENeMT8-MqHDPZSS1YNEGoYav1Kz9yoTbCpDVEHXOlSjgd1LRkEK9MD9ar_41Dt_CjHLEuRk6Jq_02oXEMRxWXNSbEtQDE6RxMd0wi2xR8leNls0TRT7hZCm8mPMBYI7YdzkUtWmWH50eFCuZxeHgu1SDTncha63cMk1gLtoPKDYOEacLW__lFZ26lvJzialk6ALFi9iypdQBSeOwd-Bv6Qi4ia1c_GeM8GH4fLSnormhsQ_c-5YysZd7iJvWJvpVktUMllFIMbMktiQ1WQlQzGh2zl89n3BHZALmu5SXDfu_gkjzCe7YAHshVzlxVGKsb2_IB1bjVi-VaG4V-ZJmC9J2yAuy8VA_qW53GZJZgGnydx_kWVmgb8yhecI30-IuYf4N2co4W-TvhD4KrNwS-0jj9K9ieMvGw7EPpb-ZErqIHdUN1Cm9iJY6Cq7E5-KD4qtrE1QlXF8AFyqXutktIPK93BkbWj9K5EbhALhSeH7tKx-bkM', 0, 'GabRtEGPZ6pQswCdBdi6j5cvBqAqFhrDumjnWmsShAL2uOeSsOtkcpOAO3B3', '2023-03-07 06:10:30', '2023-05-31 02:15:54', NULL, 'email', NULL, NULL, NULL, NULL),
(6, 'Linnea', NULL, NULL, NULL, NULL, 'test-candidate-support', 'linnea14@gmail.com', '$2y$10$Y6yuocs19Kb1I.WTfjPs1eVtSEygIi0WqKWW0kXzHraMoga9lDNAa', NULL, '2023-03-08 01:13:49', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-03-07 06:48:06', '2023-03-08 01:13:49', NULL, 'email', NULL, NULL, NULL, NULL),
(7, 'ZOHO', NULL, NULL, NULL, NULL, 'Tech_support', 'zoho@mail.com', '$2y$10$dBhgqcZLsW.n4QGH51TZ.OrVyJILAFodBc3EgR13QXIeR1GwyhCcW', NULL, '2023-03-07 07:52:58', 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-03-07 07:42:34', '2023-04-18 00:16:49', NULL, 'email', NULL, NULL, NULL, NULL),
(8, 'Jason', NULL, NULL, NULL, NULL, 'kjason122', 'jason2@gmail.com', '$2y$10$jT7CSGwx3iIf2hQziDPX9u7ZZgoa0Ee9y8NngaT2.anQ3dSXFXiTO', NULL, '2023-03-08 00:56:16', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, 'IGtfNH54fG', '2023-03-08 00:56:16', '2023-03-08 00:56:16', NULL, 'email', NULL, NULL, NULL, NULL),
(9, 'Thomas Shelby', NULL, NULL, NULL, NULL, 'kthomas-shelby122', 'thomasshelby@gmail.com', '$2y$10$Q0rA.Pdv1sOIJFImcs2Ou.Pv41Z1Knt/YHiqDjeI3Wl2i007jYdJ6', NULL, '2023-03-08 01:06:10', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, 'MHD0nxkdOo', '2023-03-08 01:06:10', '2023-03-08 01:06:10', NULL, 'email', NULL, NULL, NULL, NULL),
(10, 'Arthur', NULL, NULL, NULL, NULL, 'karthur122', 'arthur@gmail.com', '$2y$10$Ra8BuQuHVGwiY0lsdv8qlOq3TX1CslU1GC8LM01A8kh.t1FIX8AbO', NULL, '2023-03-08 01:08:26', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, 'czM0ubUaOZ', '2023-03-08 01:08:26', '2023-03-08 01:08:26', NULL, 'email', NULL, NULL, NULL, NULL),
(11, 'Martin luna', NULL, NULL, NULL, NULL, 'testcandidate', 'candidate@mail.com', '$2y$10$TIfwco8CHktO3fD36QOiZOW8OsMWuYfiMC2xKwtkYKfrVfppY./bS', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, 'X3YI5hD8iEy7MXHxHm0kGI7tOVU0mUg2Fwn47Kk8fC7MhKniKqoKbbEPGgZp', '2023-03-10 05:02:15', '2023-03-10 07:45:36', NULL, 'email', NULL, NULL, NULL, NULL),
(12, 'Jishovon', NULL, NULL, NULL, NULL, 'ji', 'jishovon.bn@gmail.com', '$2y$10$8f1Jo43qCWr6Z38e/VER4eOh2SmrmpNgXv19o6xMK8L3YU1NmAmFa', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-03-11 03:27:41', '2023-03-13 01:46:50', NULL, 'email', NULL, NULL, NULL, NULL),
(15, 'Seeker', NULL, NULL, NULL, NULL, 'seeker', 'seeker@abservetech.com', '$2y$10$kwN0Y6MivJyL8NlYL/gE/uh1BsEoJ/12XmQKeEj946ZihnhtD4Tbq', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTE0NzVmZmFlMWY4NjJkZTkzMzU0NWIwOGJkZjNmY2YwMDVmMmMzMDFlYjJlODYwMThiOGQ2MzZjMzhjMjk1MjFmNmNhYTkzYTA2M2I3MmYiLCJpYXQiOjE2Nzk2NDg4MTEuMTgzMjc3LCJuYmYiOjE2Nzk2NDg4MTEuMTgzMjgzLCJleHAiOjE3MTEyNzEyMTAuMTk3ODUxLCJzdWIiOiIxMSIsInNjb3BlcyI6W119.YkDmqPpMGsvVA15qNJb_GIbNxfgsDroNWACYytl-YifSvXHTqc73BNU3rOMCd2bJihywHf8h-XIJOa9C-FGWpj5sa7eI9BAici9mx-cJapnrnWS4s9vJ_4lixZowtDaMLZA6Gckr1DQEPXzDjbZfpA8ieFRWX-XyNzUqwlJIiqZTQpGFnTA8BsvzLfX_ACZhs7WryYlhDUCwFQj5VTsz9AJ0lcKblNtAG1TpRQGDtGC1zC1ac-IabiaX76iwAE7NPSkqKpuyHpo2JtmnXrg7B4Uqf13pyGqOzlX-cXR2scSQHN8q6q4Z94oVVxaEsWO4NEuHK9LUaj6ubIUQJFSK02tD4nqZ3RC7dod_wwVSB3h8pN2vxbrcYrCAvUW7ZRpEkLsJpwsTpX09L0Dx2Lfg2s0X9_Bh-kvzpfeeCAeiARX1KJPfcyD4_m7SCID0N8q_YOvXfeKSBSX2lP6RhBOtDviQ2b7IwfaLC2L2t5w97ha_VRSdxdezk_hSr5w8FEEFVWOGp1etq2PXhTgWiHlHsgo8zxEdwVwoHiOTgdfi5auw6T7Y-PiNPm4oY3yfMzY0kpIjsZuz2XtgSsBK0s6G4RnGtpU9u_FViHJcWV-YAB_VmHXQ1Bh-6h9lYiawrPfArRrlx_C-fpdU-Jwu1TSJPGBrwpO6KchSQdItZPC91OA', 0, NULL, '2023-03-18 00:32:26', '2023-04-29 07:32:23', NULL, 'email', NULL, NULL, NULL, NULL),
(16, 'ash', NULL, NULL, NULL, NULL, 'ash', 'ash@gmail.com', '$2y$10$cjArT5JdVH4Pe6VhQ/AUa.2eq3ka7pI6YMby1bvC1R5Tudv6WoErC', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjA0ZmQwMjMzOTgxN2Y4NTFjMGE0MTczN2JmNDMwYTViMTY1MTEzZmIxMDgwMzg3YWI4MzhlOGFmYmY0ZTFhNjE1MzI1ZDdmY2YwZWZjMjUiLCJpYXQiOjE2ODE1NDQ5NzYuNTk3MTA5MDc5MzYwOTYxOTE0MDYyNSwibmJmIjoxNjgxNTQ0OTc2LjU5NzExNDA4NjE1MTEyMzA0Njg3NSwiZXhwIjoxNzEzMTY3Mzc2LjU5NDMxOTEwNTE0ODMxNTQyOTY4NzUsInN1YiI6IjE2Iiwic2NvcGVzIjpbXX0.OiFIQuVVNEvhy2RZLhB8fSfIUo8gIKG8aQJJzcrVMIjDKHbWyp_Ivvi12RCA8ANFBC8S9b-admWAR1BnDCQZgWUqlh1ftjjgd9zBTsMebX5Hyxum_xoNC6iP4DctgeHTM4jaqBjRQTW_LuAI0qrtyTZ5JlbZUz-6FJffW4wRWHY1WoI0C2AU9Jh6XGENwokxbihl9VTCGSfuA2yu_csdpINmSKTAOCeg7KfI_uurRkoHSfeCljwOF4_EjfT32FQ1VNnd_MJn3-8fDX4PbAO17l-DKIsE8fTKYibn78-okxXwDd0qJq8UI6JMefr6vr66dVdPNhUD-PId9cNeMUDBWYnuZz0M4B_vg3dFm4dpx13ENwaoicxlhMaKIm2UCZYInbwv4du52mHZcm6BkBZY-gjxKqqCJS1u6888-X-b04hIlB_Z-5CIJm9AcrVjKrDoGT11zwBDn2dGBHdIfotdBoJx3GtCp3T2UA8XZScpUny93GD6s4XkXwgbJJy9EHiRvzidxZ8GOpAKErJ3O3fluwLHsErYIpvgsNwiqy9_gMDCgYXsN1kb_EaBLA2EMpsWISminRwkM_GVS7rl2eSHOF2QP_Vw7ljPdQmhsmpEy-fxb_9U5mysfpMi8Yv1QwE8n8Xrg8nmYSRHA_3UU8pVE36ZumNEFNEsVNaKQlRet5A', 0, '0XhDRszHYGfILdWQyaIOV8xm2k8fyIgU6DBGlEsjMxB79j1ugpYhWh78WlYm', '2023-03-30 01:13:00', '2023-04-15 02:19:36', NULL, 'email', NULL, NULL, NULL, NULL),
(17, 'degoo d', 'degoo', 'd', 6985457856, NULL, NULL, 'tests@gmail.com', '$2y$10$C41Xm/NhjeRoHa7IJKYbLOePQhAQg.uZ7sRUyBoq8zzzOX7q/9iU2', '$2y$10$xGvoHHJLLSdQ0bjiT/st8ed286tNBs/HHGTO7ho1QY4Tes7iC/Oou', NULL, 'backend/image/default.png', 'candidate', 'madurai', 'madurai', 'male', 1, 1, 1, 1, 1, NULL, 0, NULL, NULL, '2023-03-30 06:04:28', NULL, 'email', NULL, NULL, NULL, NULL),
(21, 'candidate', NULL, NULL, NULL, NULL, 'kcandidate122', 'abservetech.com@gmail.com', '$2y$10$9IV2MO3HA/vkHZwDJTP3ueYtrPBynJKDvnuw.fpvkdmWo6ep1bBw6', NULL, '2023-04-05 01:43:08', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, '4pKykzQf7Y', '2023-04-05 01:43:08', '2023-04-05 01:43:08', NULL, 'email', NULL, NULL, NULL, NULL),
(22, 'testcandidate', NULL, NULL, NULL, NULL, 'ktestcandidate122', 'test_candidate@mail.com', '$2y$10$YN8Y.n3vjbqKcKydYg0Jpu6wUcwSgJVidW6Mqjo33BkbefKPj0hzy', NULL, '2023-04-05 02:22:56', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, 'WyxhLx5cBY', '2023-04-05 02:22:56', '2023-04-05 02:22:56', NULL, 'email', NULL, NULL, NULL, NULL),
(23, 'vishnu vishnu', 'vishnu', 'vishnu', 6379610241, NULL, NULL, 'kumaresh323@gmail.com', '$2y$10$aR9hMkJo6Ojt1GrxlXowsOmlVmzbg7IOLjvXAgMBYJMoiAqhbUpaO', '$2y$10$Cm2StTNrnR7K4mcWabWekugwKQgCgXIeECaWGRjniiD.GhkmhfbFC', NULL, 'backend/image/default.png', 'candidate', 'madurai', 'india', 'male', 1, 1, 1, 1, 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTNlMGQ5OTg1NDVmMTc1MjY2MGUzYTJkYmU1ZTQ2Y2Y2ODcyNTE4Yjg3NTRiYzFmYWIwZmNlM2ZjZTViZTkzNDFhZDUzZGQ1ODdiNmE4NWEiLCJpYXQiOjE2ODE0NjY1NjguMDQxOTMyMTA2MDE4MDY2NDA2MjUsIm5iZiI6MTY4MTQ2NjU2OC4wNDE5MzQ5NjcwNDEwMTU2MjUsImV4cCI6MTcxMzA4ODk2OC4wMzk5MjI5NTI2NTE5Nzc1MzkwNjI1LCJzdWIiOiIyMyIsInNjb3BlcyI6W119.UyN3QBQAfQ-mF8i6U7Sv1kQ5gJa7SBOVkedBnqAedaGif_a2vxwny2YmC-RylhKMiBaUcvmkmeiDa6hs8HcN2-MjgbcLqm8ZQYthlmm-MCOBKjsBNJvQyVveHgi-Iqr4iPqIS94Szh-uvbzfWZHowKC3D3gKP0M8szDi7GtBtISE9LKyrtefrzwfQBrc9FtU8CwERLTuvMvljNV5fXCUdVjw13TGDlfkEsYa545LQSOf43smTlRQw1a0u63CwkyBjcDJRd3fF9P7d-Tm_L3XcU11_B-NjeMmqZpz4u7KI8GD4a3FP_DxOLZQz7dkU_2DDMm3uQYZYeSal69YtKkE6xqAJlEyVJ77pQUxGlbfimxSQBy2xgfycEtjka5hNOA22zVEIPGFjGy3z_dG_D6huhylJnGYg7gJXqb83jJUBItij_AXukitOer7U6WX2qP4V3cDnffOKP83GZEMlqCwECi2RqLrufGuAkvmdijmVcnHsOtBlqnOqX-oE7vnEefhC-OYfhfMmIA3l6eGL9Bvcg3TBuax7WXUJDtW7CASCg_xCQLueS0v9B0XYt3BvqGDZhRIYjvR2D5XF9oyez5uu43w7YAt0Pg1cUgE5-RhJ8dm7mvamtp-u6Bx0qqio95KDS4YFgASSg-PLouFL_xS_IY_HreHrrNfohVFHfLyEB4', 0, NULL, NULL, '2023-05-24 02:39:27', NULL, 'email', NULL, NULL, NULL, NULL),
(24, 'vishnu kumaf', 'vishnu', 'kumaf', 8098822516, NULL, NULL, 'vishnumv@gmail.com', '$2y$10$r7Z6wZ7d71.XUjNrxVd6XeoG6oghu4PB81bhnPP7RMUGw4Qx97WHi', '$2y$10$q8KPQxZsTjgsKdyT/PrXiuC9dluvWCQYrssTBguz25bwxjl2SPsNe', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'MALE', 1, 1, 1, 1, 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2IxMjQxYzVhZjBkNzA2MWZjZDMwMzJlYzgxYTUzYjFiMDg3NmU3NDAwMTQ1YjExM2VkMDg4YTkwODgzMmM4MjI0NDFhMjQxYjkwYjNlNDUiLCJpYXQiOjE2ODExMjEwNjAuODg5ODc0OTM1MTUwMTQ2NDg0Mzc1LCJuYmYiOjE2ODExMjEwNjAuODg5ODc4MDM0NTkxNjc0ODA0Njg3NSwiZXhwIjoxNzEyNzQzNDYwLjg4ODI0NzAxMzA5MjA0MTAxNTYyNSwic3ViIjoiMjQiLCJzY29wZXMiOltdfQ.SiXRYzGYKRazMPKStXfInENCDFKr9KDA7KGRG5vLilce55joh_Yd1kyg_zfsXugtj2i-MlN4n0cas2YjUUAsc02lh0-d3AaskTq6nLttjtPVfdyYjQeiKrZqJ7iG44l4758-iNiSGUipRjNarkAr79UKppG-1Azxr11bb4luGbzNfMTvuZM3e6npIKqzm5hdPoqkyeydWYr5zqnp9FJml46s04x9lp8nJdPO9vTe9JnViTan3jGEFjDMHL72J--_IWmHbeXlyEpZgoP14IFuG0rpPdI1YE-NA2x6ARNhAfIwsj12PTDEvJMbO1Dw2txryRsrai5TxIjd7OjRx4ykFl2DAwTAD7LiihefUkKf2Vv2Y2UCxewTEJSNSLuLNf_it8JuhT0MPdM9_h7TIKPayIkhdxRRs_CDUduCEXn12hgYnha29Y0Q-Rj0kR1bRV943SFloDzGvgm3rfA1N7drqgR7c67NRAp5NSvMob9or5DZ7xvlTTcQuGavhovRGUlIqFb3W_T0KiOKmWYxwOWfziz7xxCSDCUHvEeCVN-0sjmz5E2noFUsP8lvhfVbXP2DSVI4tGoprdWX24G1rTeskkyQzDO9d3QqR6WBDu2t8S6WH6_NnphhrZbYXWqD6Uf011UaNnvphyF2pP6OlRUYcGhleUmcDuoaSB2FDuy2nbo', 0, NULL, NULL, '2023-05-24 02:39:29', NULL, 'email', NULL, NULL, NULL, NULL),
(25, 'test test', 'test', 'test', 1234567890, NULL, NULL, 'test@123.com', '$2y$10$/g7i05NROwhoUVitIJHR1uibyt5mKLAxnVAlmJ57fQgwImsE.QOpu', '$2y$10$k.5jrXhThkqHy13XpT.DjOPGnyowSJleFyoK4aXjK7OI6g.Tmmx3S', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'MALE', 1, 1, 1, 1, 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTg2NzllYzhjYThlMTRkZjY2YzY2YmJiNDgwNWNiNWQwYWNhZDhiYWZjZGI5ZjA4ZGI4MWZlYWQ4ZmJkNWRmOWJkM2Q0ZDY3Yjg3OWExMTYiLCJpYXQiOjE2ODExMTkzMDUuNzI3MDU0MTE5MTEwMTA3NDIxODc1LCJuYmYiOjE2ODExMTkzMDUuNzI3MDU2OTgwMTMzMDU2NjQwNjI1LCJleHAiOjE3MTI3NDE3MDUuNzI1MzI3OTY4NTk3NDEyMTA5Mzc1LCJzdWIiOiIyNSIsInNjb3BlcyI6W119.RTxfM_oG8taZpusdJwdEn7GHhgbIlOhHPL8bLhWlUzeHJDmFK9H1gvtw7GQNeNh2NnfAklZ0Z0bNiFK81ufR7-wc47_ehiuA_-cwtpedoF3djOaRHn3yvqVI5obzltHRqUku1yYYqUI0AoMfUPJYI5vufPevBhj79Dier60p3vCvvglnQqv_FbUzz9NBqmAGW1j89rnw_suLC8p-2C36wbfH7zJ0vyOuTUdZVaoeasU8xZTPi2VdYSX7Ciwt0T7qap-IMotMgeIDxW_lgrWR9hSpL6RUEf5_GuvAj13AeACRCB3lf11N991mbOy56o0MSU4vUPbZfczY-UFMbB0gz5YJgydcdhT6hMvef53IFqWHnh-Q-3uC_l0Rfo1UdBSzY8WU1YVuk8mXIrNZcN33SD58MMXWs6XfNMP0ftC4Ex2VOBgVYrWe41KVf8KdisIqiMSBiV7xHSt2T8thRC_BYlz9SkF0eN-fqjo7kJNqK-U-2HnYbsdvn8znPumiE57IaimwOgmSEtVbQTgrQjSe2zyWfu1QEuF1xb27-43-siJfg1fGRFO6izFOaLKDbuBo3cZOswz3MPq2ssg4prpyFDxOMSDpnShptiKIarzv2r7N5gBoU8Ge2Z9Nk3dZStrXLIHi_IZNhCA1HCYPB4rfh_ENzro-aJxklsgLXTaVNMU', 0, NULL, NULL, '2023-05-24 02:39:30', NULL, 'email', NULL, NULL, NULL, NULL),
(26, 'Employer', NULL, NULL, NULL, NULL, 'Employer', 'employer@abservetech.com', '$2y$10$kwN0Y6MivJyL8NlYL/gE/uh1BsEoJ/12XmQKeEj946ZihnhtD4Tbq', NULL, '2023-04-18 00:29:24', 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMTZmOTEyYTY4NTYzMGJlMzA0MDJjNTIwNzMxMmYyNDFlMzY5ZDdkYjk4YmM2YTQ2ODU4NDA2Y2UwNTI1N2EyZTRmMjkwY2Q4YjAzNjllZTkiLCJpYXQiOjE2ODE3OTg0MzIuMjI1NjU3OTM5OTEwODg4NjcxODc1LCJuYmYiOjE2ODE3OTg0MzIuMjI1NjYxOTkzMDI2NzMzMzk4NDM3NSwiZXhwIjoxNzEzNDIwODMyLjIyMTY0MDExMDAxNTg2OTE0MDYyNSwic3ViIjoiMjYiLCJzY29wZXMiOltdfQ.iJv-J5z0ZHMUyWMvFhiFdp5_xsaKIV7e9pdS3xSqDlmgBnSfMS62epwpJP9kEtn9WliPg7IT1gQ5Yfyl-qC0uK5SGfEI7YjG6yga_hP8Ui2J9OidZ_tEhOgVMzMR2J78mt3MFVRlLwlIQRL-_UnXABSOQC-3hp7aNWsT4xVVch2GXQkMQXIe0wWyQiDGxmE0k9ODo4paoJfidK6WVMUlpkxvFLG6j2_rOAPnWsslukotbWfck44dhNoR8wm8kkKmYG55qLU9ArsRVtG4s74KrLj6paVbNE8DyNnQVVZHwV2pKg6zey5lA8DqBMmjLVYAy93JRyOkg79nZj0l6HXl8bNyqqkk9fGiZ7UIAdx9LR4MY0Oiu50YNm7Rm2p4AYK_y5hWHsuVXy8AqalvYpBjBCn3mGp5n__stCi8e7CklgxWhCenNAxvSTBRAbt4ERdr5ek_GfSjUmISX8IYo5T4LadLlyXOQAo3SyD3-rlHzL7uURiu3u-yQjutoPaWOV1Bc6hBkSJQrFve4fS4avGYUuQsob60d8f5dc99Yuv7bVX0yL9IZI1ZS2EOCsbKv4nFaWjuwIktNpI_0HA7MSnbFiwyrq4ZmBM-fYUFNb3DJTKr5j5-zksfsoB9dPEf5INXXjXFOF2RaH9GC1yosYECqbBw5VeO2Q3EcXyWPxDxN5Y', 0, 'LrxA49V3guMLVNH0wl4H1z5vJ45Z4uwniEL6RXXM7AEyB6ir1XoF6SIWwK7z', '2023-04-11 01:26:51', '2023-04-18 00:43:52', NULL, 'email', NULL, NULL, NULL, NULL),
(39, 'Angelina', NULL, NULL, NULL, NULL, 'vishnu', 'Angelina@gmail.com', '$2y$10$K8hidG5DzIuTuFO3sfnNO.RuxyKylg1F3x4ESOggtLKC4fmNAKKCC', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 0, 0, 0, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZGFmOTRmMDE1OWMyMzU0MDBhOTNmODBlNzhkYTIwODFmNDMyNjIwMzk3NGNjMjIwNDEyMWJlZDdlMzczYjkzNzZhZmExNzdmZDY2NjgxMWIiLCJpYXQiOjE2ODIwNTg0MzAuNTQ0ODgxMTA1NDIyOTczNjMyODEyNSwibmJmIjoxNjgyMDU4NDMwLjU0NDg4Mzk2NjQ0NTkyMjg1MTU2MjUsImV4cCI6MTcxMzY4MDgzMC41NDI1NDUwODAxODQ5MzY1MjM0Mzc1LCJzdWIiOiIzOSIsInNjb3BlcyI6W119.ZNyicHWi0R8-fHizjD_HC4P0FY0LZv3HLR3tv7XUpoilBnEsO92IZ3rYPrMeFU0dhDIWSa0jIDjQOU4oxtc3trwD1mewd3NRNZMS00wU5y6YkpJWqD80tH03yTj0sncdQT5bvIQq41xnMweVV2zk_BiR_23aSKAbiNPkJ30HSLI87p-R6OAtpNLe7eynuFJ6s6hvgSBweXijCJYmaTZxDkk1jQ2ijiK3g8186Ja88UURuaka_8jhgy3ksy662QkjHT32kh7DVR1HIkHOkE0Qox6KBQchbR4-1Fba1ZjJlkiSmon4BoDe7YN5E0g8whqjCdvekInDzUxUrhCu50FebxT-56EtSMPcsCOkBs2w-q-Zl7VRyjl616eUOUmnRl7BiRI_UxPHmJlULSkWBPP-vHJLXCuO1kIxcCL_D19akt8Z6YqpCZZm2DppHYHmNVzxE_q9lumhvxYV8KLOxK0k-t4-e4V5nUr1mqnWU2_Btqg65JZrcJFBMBKUrddEfxsS4W1ag6TiSZQzAEZcS5Vqr1lvsFsrY8jCCsc7MXCYU32cMopSpFemNBqbBdzQjr-0UQZiHvh8k-rSaYSm9xMnLswdFpeZ_iga1PZNjd0A1YUuk2ivkNO_C4bCMz50sue1cJ3YA7v7rl0yWVEdYYMyeNAjjdhkkSXj5ndcn9Ozo1s', 0, '9A8aelgILjKWblMaGkOaHGDTyXnO3hlZLIvTtJ32AqiDcpN94QP1yXRW3KuW', '2023-04-15 00:56:49', '2023-04-29 07:45:16', 1111, 'email', NULL, NULL, NULL, NULL),
(40, 'Andrew', 'happy', 'me', 123556789, NULL, NULL, 'Andrew@gmail.com', '$2y$10$IyFDYjb0Sn9esOMsxpNxbupjCg3RlweYYi4SN6Bimv2lhjw8lZDt6', '$2y$10$VR5DmV9Ni8MhctDiT1Q5S..A4qRFU.XLc3TFEJV4OzRVBbvNMmche', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'Female', 0, 0, 0, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZjUyZGVmNDkzY2Y2YTRjNGE2ODg5ZjZmOGU1YTY2NjA5ODcwZDU5N2NmNGFjNTBhZDI5NzQxZDEwZWIwOThiMmNiYmEzMjQ5NTFkNDM3ZTUiLCJpYXQiOjE2ODE5Njg5MjUuMTMyMjYzODk4ODQ5NDg3MzA0Njg3NSwibmJmIjoxNjgxOTY4OTI1LjEzMjI2Njk5ODI5MTAxNTYyNSwiZXhwIjoxNzEzNTkxMzI1LjEzMDEwMDk2NTQ5OTg3NzkyOTY4NzUsInN1YiI6IjQwIiwic2NvcGVzIjpbXX0.H21xqa_P7-3kVd9fttwBI4H00c6u6hdLYYF2Dr9OmzhgUMaaJ_h42zB0dzYc3cCVZSoY3XwQPIjM3sWEcwKVTg7QJxsjoYHLEs2VfTGtPsMQ_22P54-GIF0gu0HHGtBuiBDrkrf56KAkWWJmV4wcsxsMTPDzRAtsHOVpwbPyMK3hVmg8Mu36wBS0YBUP22B21CSYwNsZ2hEyBm2afRuDZkH8Tbs_pf9uBLayoVfp8hGMGSPlLyJ8e1-O-b6YFlqNkYfJ89gtBP4BwEL-nmuN2-7PV6OZef10IEiQNQL06-h69vNjyDSax2Ystd5K7W6E5NSnGjEYlZ8eAR0H1O3L4Ytpqvo9lQSO9IxBdoyIhf_vXtf83jWsWX8SUcsbA-fg-B8e_p8tc6hXkHlT1vkIJeVFmj5w0IMpU-3qu_UnED_ifAQPrXB6cPA93kNDhl310xQSPVe6x-Q3U2c7CDYRKUuvYucsgucRzcHXT046DpmPzRyDiZEhh_xd1GD6NCuT6rTm0u4ePTi9lgpwymOhbIqAOp_gylrwvDcLqR36zUtQe4RhLRBU9XEPCS_5RnpzuNS68DOrrWriJlBrF6uzqVyecClCRdx5WVdnM8BBhzmSkDKQ3W0MZf4cLcSNMxr39Am8NeH56yE5AewHbMAvbglW4VAGd0IFcmmuD31tzRw', 0, NULL, '2023-04-16 23:57:53', '2023-04-29 07:50:35', 1111, 'email', NULL, NULL, NULL, NULL),
(42, 'avinash ak', 'avinash', 'ak', 9874563210, NULL, 'avinash ak', 'avi@gmail.com', '$2y$10$rIBFwyws5ckQniNkbVymje8up7VJ81YrTc3fUqLQm9su9VMuf4kim', '$2y$10$ghcWeO6cACkDZPO3cZtdJOGzteFn2yoHqI2wZxUlipF2OSLdRzJmu', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'MALE', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNjcyYWMzYTIxNWM3MWFjNDI2MzkyN2E0ZTE1Y2I2M2ZjZDQ0NGY5ZTk5ODNjZTk5YmVkZWNmNTZjNzMwNDczYjE3NGMwMGZjZjU0NjZmZmYiLCJpYXQiOjE2ODQ0MjkzMzkuODAwMjg2MDU0NjExMjA2MDU0Njg3NSwibmJmIjoxNjg0NDI5MzM5LjgwMDI4Nzk2MTk1OTgzODg2NzE4NzUsImV4cCI6MTcxNjA1MTczOS43OTcxNDIwMjg4MDg1OTM3NSwic3ViIjoiNDIiLCJzY29wZXMiOltdfQ.q2X29i2N1FrYo0REXSSc-SbD8EFYSpYTlwXDT-Co-7Nf2N4za3VuxapcDv5cvgxWhmJO7H8J9TtjUEEv8bVt621BGQuqJYtzdz_jEmpKhGPlCuatthFmAZLgnIBIyKYQd_9-3HHkZYv8VR6D-aN1-8O7s8Asth-geXercrAfwWdbFBSXrYPcyzSheOCPmdUahLUVueB6sLuO3dTV4JXtTx2cG_8rEz9ho0a6JKntymFuEqVp5CrT2DGnFIMEv-ruTTG7amvxmpP6qJ0IyzQVTTm-l2_9zlj4OZUbffs3qvhon4z0SPo4TTMQ2iUnGKAubLxicdhLz7wSJy7Drgau11rLbnKIamfsgU2YJ3U-yZiiZI3L0DyuybaatkJ9zq-NNg8cBc16kJjZsEP1yuoBm2FU6J3Rg5bIvfuMN1Ar1un8KUXhj1gUoFxPSYRNu8EHmtHfgXYqgTBlBsi3b642MmjIJYJqrqWh28Xyaf1Wre3LipWUfJTPesIxgLjOUa_cZ5SxI2uT2lQ2fR7Hl7dgk9At_ZCJfmWX2U2u2v8jIPnLz9SqM78tGO3H3xjFnOEtpJsJK1pCnDykqSCm4sQlQDpQH-m2Tyhl15SjnO5Nrk8C1ZxTxbmDxwXG2ExXb6QhskrzRvxIq6001d_Cb-I5lwrbZ3F4MCED48Nu1VHo4bM', 0, 'EKpFskz2boXV3PSLRKOzFZRJHMLtd9tZ327BCk6PiWyk8pQPI8S33DjSp2Xh', '2023-05-01 22:59:16', '2023-05-18 11:32:19', NULL, 'email', NULL, NULL, NULL, NULL),
(43, 'vigneshwari jeyaraj', 'vigneshwari', 'jeyaraj', 9942616658, NULL, 'vigneshwari jeyaraj', 'absvigneshwarij@gmail.com', '$2y$10$kwN0Y6MivJyL8NlYL/gE/uh1BsEoJ/12XmQKeEj946ZihnhtD4Tbq', '$2y$10$k/XhOLxolN9Rz7vFVShZUOj.mB2x.HjVLh4SgGyqgPrF9LI16MjRa', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'Female', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTRjMDEyYTJhM2JhMzE3ZDVmZDUzNjMzMDQzYzMzN2M5Y2Q0MzI3MzAyN2I0ZDRlMmVhMGQ4ZWY1ZGQ2ODE3ZjExNTVjYTMyMjZmZjdhNjAiLCJpYXQiOjE2ODQ0MTY1NDguOTc0NzQ2OTQyNTIwMTQxNjAxNTYyNSwibmJmIjoxNjg0NDE2NTQ4Ljk3NDc0OTA4ODI4NzM1MzUxNTYyNSwiZXhwIjoxNzE2MDM4OTQ4Ljk3MDM4NTA3NDYxNTQ3ODUxNTYyNSwic3ViIjoiNDMiLCJzY29wZXMiOltdfQ.LA1FR6rLvOt6ys4vws6lHzrJWjv0TFYInZgQpJ238JETHgZOHWjNuplhxw3UQNJKlw_kgWo1D_MTXQVrQcSQ4EctCq_OlZcA9HBS-LHGDCo0_Ulh1mJsmxwJXUYUzG4vMuEa4vUejJ_bxtxmVRiWaTD4WOB1EF9l0Gsg9t4plphLwCv4N3VN_B-vyv5UvZ74diGE70_WASr5TAFpinQgYusFuDbhdRq8044x7fziSyi0SQNlP_-gPppyCQSLnK0HjEq0wkcmmV2LZV047YmUbQr-VV_nCTHNiy7vbNLMf8xv_T6kQZSb9lSkPwA9B9RIk_f5teN5nAjiIfBbr9pC_augqmrKmgdE8LHIQ7sOHAiIjV64EPvxqPiyM2igOYeUwkuAgVzdy2jBAbFN801k1yq9Mswn2xbgY1fWB77Xoe54kB4BzhxuYG2Mr4rMNSqZiUk9U3uUR6Jg97yoVH_8SQOaA8mw3t2xcbukjTZfNJWka5SXBrdEGaK0MRJ1YQWyJswm6paNi-Ve3e064W8UBdFjh0P2xtLFJJO8YqAIhNl6AZHlFmG-NTrmTvhJjjskwc0I5wKyTUzZJ_EaJQWCkCMf5uWXzzHMTkn6wyRXlaQ23LD9-ednjCg37vsHHS3hJ6I_FDsb_EfUrIbbmw3dC3j3lNAt7YduZoscKq9JLFE', 0, NULL, '2023-05-02 05:42:50', '2023-06-05 00:23:07', NULL, 'email', NULL, NULL, NULL, NULL),
(44, 'Jason Vijay', 'Jason', 'Vijay', 12333333333, NULL, 'Jason Vijay', 'jason@gmail.com', '$2y$10$/KIEs/9Yq2KAix8mOo2L0.Jak4.xm2r9TmOlcytx0hrvM2xug46NS', '$2y$10$xRCazuPiHE8AdTLJukuw3OHvmxtg9Gwk073vh0vJZkiLONB5g3uBu', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'MALE', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNWE2ZjYzNjJmNmEwZTZkNzk4NmU5Yzk0MTQxMDBiZGFiYzgzMTJjNzVjNWM5MjI2MWM2NWU5MjE0ZDVmMDhiNmViZjJmNDJkMTA1ZTg3OGEiLCJpYXQiOjE2ODMwNDk4OTUuNjEwNzEyMDUxMzkxNjAxNTYyNSwibmJmIjoxNjgzMDQ5ODk1LjYxMDcxMzk1ODc0MDIzNDM3NSwiZXhwIjoxNzE0NjcyMjk1LjYwODM2NTA1ODg5ODkyNTc4MTI1LCJzdWIiOiI0NCIsInNjb3BlcyI6W119.ibj6_Ks7kBIo94i6BVveXrMYXrhsBQjDYHoJdUP-pCPrQaHQz9Gyk6NJBYsETGxwa8wNyDxaAeRqv9-eQvWmsp9JFSOR0nFrVlWqs9JZnpraL9ZPjjEzI3CRe5iJ_vKyGfKH3_jPEb2Hio8sli_orhvZKAt6TxFkzKgzM0oPn7zfTuZx6CWovdXfetiOIt88rovMgQ9rGf8B90DGeWI8YbyNqZ0jbFXJRb7p91yahL8DcO0ucPkUW_CMacSSek7t_0rVVRRORjaPpCmiCMZAqDKidkL8UYoUZ06EDpPM_wVvFTu4HOL8lRG1TCsI2pnw3byrQGS0DOUcSaKw5b5rhLq5Y2EqOneYBeaQlTW41emrZRV-u4K1bsP43IEwgk7iCr8jICS0lSD6gOs6g7q3w5ATYPHANqzbu9hOHfJuo-l71wOb3Z-a5l93UQ2VC3mlefgqE2Kk4XToVl2mMr6jbw66_UH1TMp7egdUheDkYq_lcD_WHOdkgQyi5lXRBtOEw6UxOwO_9kS0ayMdAUCw02fLX_YkAs1W2orn46tmMIqgeKRx0nstf4k1osatbbtYw1kYiSwT6o8zDmljigxnB2SH9Oqucwwo2OMfVusMMt38HB8cWp6tFo6egVys4fOBINJW2vCwZNVQ5Fp8yHlNLgs3t0qXjW8-cwSHLF6fk7A', 0, NULL, '2023-05-02 12:21:08', '2023-05-02 12:21:35', NULL, 'email', NULL, NULL, NULL, NULL),
(45, 'John luna', 'John', 'luna', 9876543210, NULL, 'John luna', 'john23@ymail.com', '$2y$10$2Si4IrYY/JtTPk2brjZaZuxqhByDupvn2v.wsPWq6xNNPFitNDHIq', '$2y$10$6EtdcjQ2UlgiZBhqODsZXuUdxb689ioZ29mqsspTKZmpTPnylzeCy', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'MALE', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTM1MTA0NDlhNDBmYTgzMmFlZjUxYTZiNmEyYmQ4N2RjZTNiMGFiNTBiMTk0NGU3MjBkZDZjOWE3MjljMDVlMzAwZDEzNzI2MWIyZTRhNjAiLCJpYXQiOjE2ODMxMDE0NjEuNjY3MTg0MTE0NDU2MTc2NzU3ODEyNSwibmJmIjoxNjgzMTAxNDYxLjY2NzE4NjAyMTgwNDgwOTU3MDMxMjUsImV4cCI6MTcxNDcyMzg2MS42NjQyNDEwNzU1MTU3NDcwNzAzMTI1LCJzdWIiOiI0NSIsInNjb3BlcyI6W119.pVZx5oz1XczZ9IFNoQnPeXgj3meNC0aVM7mMEbX51oQoylnjIRhmx08CYpSVG9Xvu_WUoEyYEOejkpgEP0bwrMGFqsAavidwQ_n4QUilAh8mXt6WVejUqf6JesgfQTzXfCG-byY62uSYOa33D8AtDEM8S3bW6fnUc0azhGcWxivXrJbJn3A-6oD7WsKxHBA473tD8nIUBFuWTtXjnDv_jbqT8npLz98y-OO3GQejHX2nAeP8QfdAKBCkPn1hrXhNpEY8sHc45OeEzwNutwQtWLhAi7ww4-NwbxryGBWq_apqD5SBZJHCihURDIMRPqayA6SNUXUBf1Kn7kYoxx_rUMBGABTH-NdNvH0evBRH-sQIAeqlUXWgjzA2rPKDHYw_lrgNNOw9rdivNb4rPJbk3um2IXBiQ1h0a5N_6Lt5PfVi77lInhTHj2IIsfgBo7l7O8y4vWnBtejGDvrYwswdaVS6OBtN5VMfgIelw2-e1Smepm-U1zZYrBdYJsNfloMxw5whICy2-sYFnJD56rbKg1kNFpTvQIPJKQ-wdX54lHVfwdjtq6hPiXke_YgdQaYnvDCTkKdh1zXiKXqw5SR2LcG_G7X6_9eD3LXLxM50ewJlh1oHjTqpdZubAmhzmYosaliUo6YF6Y_vPcRLY2a7zokWPw4pUwDPLILurGXNru0', 0, NULL, '2023-05-03 02:40:33', '2023-05-03 02:41:01', NULL, 'email', NULL, NULL, NULL, NULL),
(46, 'vani shankar', 'vani', 'shankar', 7374757677, NULL, 'vani shankar', 'vanishankarnov14@gmail.com', '$2y$10$qgl34dUxIqT/cSrBkbYdX.PRGDsAwieXNB6AV.Hbeg3XbiNCCAF8u', '$2y$10$B1zcFjmpOvu3HCtw/zK92.OcoMkvpAKDVKCMRQ1ojfQtfQszjRTLG', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'Female', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2YwOTBlNzRiMTJjYTE5YTMyYjkyNWNhYWI3MzI3ZTdjYzc5NWM4OWFlNzBiYWQwNjg0ZGEyM2ExMjgxYWI0ZWRkYjM1YjAyYzFhY2M0MjEiLCJpYXQiOjE2ODM1MzIzMDguOTYyNTY5OTUyMDExMTA4Mzk4NDM3NSwibmJmIjoxNjgzNTMyMzA4Ljk2MjU4NDAxODcwNzI3NTM5MDYyNSwiZXhwIjoxNzE1MTU0NzA4Ljk1OTY4NTA4NzIwMzk3OTQ5MjE4NzUsInN1YiI6IjQ2Iiwic2NvcGVzIjpbXX0.Lt4Y0WBL6sDKdwHUvgGgW75Yv9xwY7jgbvohPZE-pDCXXCVKBqoFSqcinJyfJw1l2eQ5RtzUORCRcJdYENn3mfD7PmmM1eYWFmHSOoa8m9rhJDdiwBEZGlrq7ff2HuQ8_W-2CBvx4ov_oqdrD5wep5DmRHC-mfExC_pljVNzJUgD0K-sQVlrSvlQyJaZeuPNs1UAecGwvew563w_rGC7UnVq6kFSNo6-Fr_Z_hoJ5CMeBiGk9Juti4X84_2rU2kSnxdSuxDxXBhfSEbKInX2gcGVIUg00ygxw3c11wkJrC9aPtfcGPjsTP4IwSPvaTJwbbmzTPQ_1q0cJBNpGdklmmawob9DBGhRP5jDy3ZEtif0M4CKRAM2_zyn3twOHQojPUdLF7sqfbPAAZDA2Zkj8ltz4sw2LGtRwpWheU-59o77btc6MGYVLtLf2psVW_t5s92XL_Fm90VerrRI_WafnOgJ8HdG4_w5GBAe2znLGI0L9TI9MsYEvKwLDsB-mi7YFizuGQZA38Jq3Z92u1MtXyVVgY3IKS_e7MM3IiftdObGq33tTw7trlOacFRrsRZDh4PSMBVp7NoZZqynoOAXNTrTBBztOibaqF-sfpyliuzkxxtTJswUCKxHEPh8-avFtWalr_Hm1mKYd_qu1njz2nmfEGdv2DVJ8Lo_NsFGB5E', 0, NULL, '2023-05-08 01:58:06', '2023-05-31 01:49:56', 1111, 'email', NULL, NULL, NULL, NULL),
(47, 'Jason Roy', 'Jason', 'Roy', 9842567828, NULL, 'Jason Roy', 'jasonuk@gmail.com', '$2y$10$A/ewl9kPoVxXcvvc797a2uFAEVM3X4LOObE8EGHHokglHbq7/Exmq', '$2y$10$0sLF1MIwmr4f1qmHaoYuJOYsMcNPPH6J1kKWtf96gw51wbcF4C0zG', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'MALE', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTkyMjMyMThkOTUzMjU5OWZhOTkxYWY1M2JlOGY3NTBkNjUyMGE1YzE3NjhjODdkMmNkM2Y4MDc0NmVkY2FkMWY4MzJjN2YyZGM2NDQzNjUiLCJpYXQiOjE2ODYxMjAyMzcuODI3Mjk2MDE4NjAwNDYzODY3MTg3NSwibmJmIjoxNjg2MTIwMjM3LjgyNzI5Njk3MjI3NDc4MDI3MzQzNzUsImV4cCI6MTcxNzc0MjYzNy44MTkzNzY5NDU0OTU2MDU0Njg3NSwic3ViIjoiNDciLCJzY29wZXMiOltdfQ.Fmh78pRRA6TwTTtN00c3yLs0j6cj-t1CfqqlA-RDhrA11hav_TZLQ4nasuSg-upePJVvnejFSgzafEKoEdyHXEAZNsA6OLZsCLh41ZYJw7XgIffEDMS63w-D5rrOc3F6oxhtd_sf9RXfiGAJhJh5JkeDJFyjDH1lEcjcsMAAJrItcCMJUoJL_4Hh5fkQ2I2N6AT9OnQ5RSX8penbRMh9bIp6rMpn8JkduGU2zbroFAroQS0dM1ATgIj2vRhs_Sb6jsUMrXJCvwqK_P_Avbo9bCvDGeGxYLWJnRL3PsPYHNJnNn7U_zEd2-cgNscdp-PPhOfQC3O0tSM52ljnVGXqdxUgmOCjQuqiHnrJ84xN3M6lyRLWJ6t7qApCmCHVXbF4FOhn2wUF1ihhJyZp6dCDpgKXdwK5mJVbwErpTFPLfw98-820anM0rUDwcazRshJs3zIuNFUBwpgkA9-ctezAlaPpsTDuJxHCnhAcFURUMouvXh4Bs5mUMK0JB5sXesEek8xvkK-BPmd4iWdnq3y4tFfuFTBTLdKEbhGW3hgvDXzWiFhbXoRG12jl9foLllQqTTEn7DyAvGctmeGLLcLrrXM746Vh85iOZxea4P7eFUcEd_zBaQdXjxLQ8hJ-fDaMmqBhvgR-DpPYrF8f1oQenLYq8cLfWhioCRi7D3kLREs', 0, NULL, '2023-05-18 12:11:22', '2023-06-07 01:13:57', NULL, 'email', NULL, NULL, NULL, NULL),
(48, 'bala kumar', 'bala', 'kumar', 9715442525, NULL, 'bala kumar', 'balakumar@gmail.com', '$2y$10$Dll4k51lObm.Xd56NIaqpuwHhOBNzLhjWQYgIrq5G4UGh09ky8lL6', '$2y$10$nCW4.GXpGzW8J6f7iKGBRueTTt6P0GPSJY8.2ct0K1tR8aPIe9BLi', NULL, 'backend/image/default.png', 'candidate', 'Madurai', 'India', 'MALE', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjMzYzRjOTE1ODk5NTkzNDAzZWI0MzA5MDI4YTg0YzE5YjdjZTJkZTBjN2YxZGM4ZGQwMjBmYjRkNTAyNzNlMDYyMjlmMmRjZGRkNmU0MjIiLCJpYXQiOjE2ODQ0OTEzNjIuMjM0ODQ2MTE1MTEyMzA0Njg3NSwibmJmIjoxNjg0NDkxMzYyLjIzNDg0ODk3NjEzNTI1MzkwNjI1LCJleHAiOjE3MTYxMTM3NjIuMjI4ODUyMDMzNjE1MTEyMzA0Njg3NSwic3ViIjoiNDgiLCJzY29wZXMiOltdfQ.LWol1KZ6qEtIdQ3iX07j-GCuInmreo0paSmESWg0BqE_sS3b3M0TtSbHW3RtnsqYck-aBbo4eh2RbDro6T2YdFlB1xSvVVGxl3aY8f-K6fdCvqxk4a2mKP0bzYf2bPqY1JtCVlqsVddD0bVLmA1ASKbC5L-fejGci4gzMxtbmxZAn4tJTyx640H6Tbt90kI70X2B3MyumVNzmfLifAtUpImtTukapTn0nKrLiPGjO5v8G-MBJ1yf_JxtAJbFAqieOvvwpIJX9uIHRyBb-_FOvlNeeSP083C6zKUF3qvNYAOszWzlJZPutO7Lu2x_plz4GJerRKaUplIhLG0xxFOldfFEPx3Wv-xHv4h1cmf1OsqSgPNgzLkX3Tk8NCWU-urWypG0Jg5KMmAOP-NHxCbfPCQvEmSbGRVrjrKEleGrnrVkIy0YzqmMtt6jaSL819pBO_0gDTHAa4s40L8fhV7WdR3xp_e2Hk9OrMHFVnOP0Qtll7vvrZjyDNpbqT3ReE_7gqZGwog6dGYSh5ap5rTw6mY-q3NO6c4KMTTv47_UaaiKLYgWGmTsPcfUa_uHRJIevSqYWX3llksl2n9xdyctr0Ob4tieO6_c68cklAWHbPj50nbSWm0OzKiLRfEYlGeUfK8qQAhkMp02VItqu1AL7SJ5Al5f_ULgRgJoB7Wo5lI', 0, NULL, '2023-05-19 04:45:37', '2023-05-19 04:46:02', NULL, 'email', NULL, NULL, NULL, NULL),
(52, 'MM Company', NULL, NULL, NULL, NULL, 'mm-company', 'abservetechphp@gmail.com', '$2y$10$qPs9KX9gw2TJ4PsO1oGf9.3C2SyG4xeSyFmD50tDDCUjghaRfZCWi', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-05-31 05:16:45', '2023-05-31 05:16:45', NULL, 'email', NULL, NULL, NULL, NULL),
(53, 'Mahes', NULL, NULL, NULL, NULL, 'mahes', 'dharmadurai.p@technotackle.com', '$2y$10$TGqzwAwjMAadDmthU89PCOQPGCU/9uEjcTtWda7y.6QMGYlHKpAKi', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-05-31 06:29:14', '2023-05-31 06:29:14', NULL, 'email', NULL, NULL, NULL, NULL),
(54, 'Madhavan', NULL, NULL, NULL, NULL, 'madhavan', 'madhavan.g@abserve.tech', '$2y$10$vZghTKTqFLuX9fbVE2oFFeKYxiDfOGO7n3W4RCMVtHJF8f/eIW6Ki', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, 0, NULL, '2023-06-01 01:58:30', '2023-06-01 02:25:15', NULL, 'email', NULL, NULL, NULL, NULL),
(57, 'mathavan', NULL, NULL, NULL, NULL, 'mathavan', 'mathavan.g@abserve.tech', '$2y$10$BIGcMC8KGG3eymoecm/YH.ch2k2luaTOg9.rSD/iyZ0dqXWqZzZVC', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, 0, NULL, '2023-06-01 02:29:43', '2023-06-01 02:29:43', NULL, 'email', NULL, NULL, NULL, NULL),
(58, 'Amazon', NULL, NULL, 9677570694, 66363, 'vigneshwari', 'vigneshwari.j@abserve.tech', '$2y$10$cjvCWahr8.IreMwPzZW.letFI6i/uCOXHRL9qttnWwiY9VAG3Y8Hy', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODY3MzNiOWEwNGMxNDA3MmZiNzdjOTc1ZmM5MjE1MjhjNDYwZGFkZjVhOGJmZjRlMmQ5MjliYjIzZjU4ODdlNGZlNDYzNThjNTRiNGU2NGIiLCJpYXQiOjE2ODY5OTgwMDguMzM3NTA5LCJuYmYiOjE2ODY5OTgwMDguMzM3NTExLCJleHAiOjE3MTg2MjA0MDguMjk1MzkxLCJzdWIiOiI1OCIsInNjb3BlcyI6W119.yLYaJkJ0JKHEdxfhpQj9UVMBfvR3lJis9RKjZTXzmGA-Ua7C10l2UDcuDX9x4N-AwmZ0Po5gJMdigjagghSkaMFkkNwKA8UhLPhFnnlLpXQY7FL4RiOlWG-6MiJ0EcolpxQDp7n_SSI0V9TnGLQLcc6J611B32eGVDiJocgUquUsRczB7bXkscxH28Wd5WBHdJPi9qi7l-cCLGrAyMWb5T1k3edLAGZdvjM9xGZ7AF26xDmqMk43lPG9tBQeDZPxifacPwS6kGzw_NSrpP8wjVywwjaKan6CElkakiF8c0IWCV70IRGu900F7QI8-TLMXPqMUhmlbnLW6bSF8lIWAAdQ2jmSGRIjRNyYmSP7ynZamR0ZKoXUjeN7axi5al4HCUMFTUjYhBirGniLs_eeHp0w2AUBaPKB7vihv1X-3Aa0Pr-K6UoSwc52jW1TpNw3rLxID5hlBuJwkl1RfK6XpXcq7-qkPnQfPPXFym88Y1zbG_ByaWC8b4ub-3MEoyOlqT2nlIdO2JmFbA91LNuuSdZtT-A4hzO6vhJL_tAiVVxpwCjnGF4noYu7OuMjVluYEf6cZzHX4MPI7I0xyobMjgSfQ_Lp1H_kp06obt-n3S-RUEBtePyFTNnUsurEH1lAxZEw0gB0jXDi4AmFfHOarxu8CJVmMAROr6xPV_m115s', 0, NULL, '2023-06-01 02:30:50', '2023-06-17 05:03:28', 1111, 'email', NULL, NULL, NULL, NULL),
(59, 'Mithu', NULL, NULL, NULL, NULL, 'kmithu122', 'mithu04@gmail.com', '$2y$10$Z0Coq/kvIGTVymIgL8mT.ubo0TOAUAvFekRzfaOqzBvliJKXvsdwq', NULL, '2023-06-07 06:14:28', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, 'RqTL78Jjae', '2023-06-07 06:14:28', '2023-06-07 06:14:28', NULL, 'email', NULL, NULL, NULL, NULL),
(60, 'Muthu', NULL, NULL, NULL, NULL, 'muthu', 'muthukumar@gmail.com', '$2y$10$PbJ2o/eQHh0MREaRyq5qjelu3OFCL1NpDGlZdHzfHs8GKRGcT9cVW', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 0, 0, 0, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMzg5NmRjMjhmNmQ0MjcwMDYxMTQ4MmNlOTA5YTY5ZGRhMTM0MDAxM2MyNGE0MzJkNWNmOTJiNTBkY2Y3NGRjMzcwNTBmNjM3YTg5NmVkYTciLCJpYXQiOjE2ODY2NDAxMjUuNTY3ODE3LCJuYmYiOjE2ODY2NDAxMjUuNTY3ODIxLCJleHAiOjE3MTgyNjI1MjUuNTIzNjczLCJzdWIiOiI2MCIsInNjb3BlcyI6W119.CTdPW0ExeI01QPrv9JJvDkZsDOoKzGth_zuNY2Kfwa-ifzhZl9_faU_dzFnMIcwkqtagOuYkdqFcPHnV5WXYxSsldFGJOs4iyKvLkOrhVsY-N1L4sQDBcknrOx6_Uy9RyrEXPhIanyz_DjPxWQnozwla7yStk9MhDjkAUVSODuPzIIGs0w5D37FGUf7otRt_87_EsFI--haR12xH5EmKLtMmBxPcexSJdaE7UGPB15yr4NJO05j2lnKMl1AbbtsAtSkVkcnwuk9GOgFaW4Py1unsS-mY1d6QtXqmpzvYxn0o16B_gZvUvM8XckoniwCuXPj1Knjey8A2-SQrG5xwJiZOrmXdaHqz-V0RVn0Cjg3Pokp9l8a6OKi6cpKotN4XPknYl7mgMhn35wr2-IwSrZkNmDFSOLxyC9l8xirJk3sagYCKuMbvYakKq7Q2CWtiHWV3UkXWYIr2Y63MduTz2hOn3ZKoXl_SwLNN1-w7Gv4HisAgbNuy7epXhX7FX7aLiokSVkNp6OlstY4nTrMqS2djOgHt4AKo3OyBeUdLGcmYP6tdiniNO-QDSR58bnidU8e8U8EqkZG5FwU77B00hVtVyqCG8b_HYegK51AQ3rU3IGM-aX0EiovOuPIJl3IWjW-7dTIV98jIogGnUDZdc1jhrbeym2oPNxKm-_lEbfY', 0, NULL, '2023-06-12 05:32:18', '2023-06-17 02:03:16', NULL, 'email', NULL, NULL, NULL, NULL),
(62, 'Kumaresh', NULL, NULL, NULL, NULL, 'Kumaresh', 'Kumaresh123@gmail.com', '$2y$10$ndyuAjz0Cz2OtshNf1G.AOFCHxGBxKJOVkzhxFhq4jGMSknhwWaVO', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYmUzM2Q5NzgxOGViNWJmNjFjNjczZGVmMmE3NGYzYTY0MTkyN2RlNDUwZjc0YTNmNzRlZjhjMTVlYWIyNjA5OTA4YzA2ZDZkYTEzZDZlY2QiLCJpYXQiOjE2ODczNDMxOTguNTA0MjcyLCJuYmYiOjE2ODczNDMxOTguNTA0Mjc0LCJleHAiOjE3MTg5NjU1OTguNDYwMzc4LCJzdWIiOiI2MiIsInNjb3BlcyI6W119.IH9xB8lP3UDwFJMeQcWBMSaf8dt2Yv-2Qg-9VGUVoymsj915yLFmjryWpJHTqm5tKZOCtYGFEWwpIZl7nVcS6WsXsaMRPlzUDWFqTPQW4l6AcmqHEN3y0SroyjrsmyeLV9kFhCleI48XX3wjRncVUxvdgzcMWZyX05axS_XFyRjQMBqwz-86lmO8Zn4Y6FwBDxv0p8puRZGdtMuTEFrp-0oW4nW1IFqR12Hbwc9U2EITim6SGI8VcYycrhPErW261iWAysnJBMgSIQra3n_oZSLq4YRAEoof1VHJyIgy_n9ocLnwfBDZczL3tT-v2QV1yqZIbU2uEuSyf-o7VQfaZu4Sg67jdJsx7AuTjz7ZCYii8PkBav6TEAD1Ap11xz1KehUYnqFWEjHw__wsVXzW2s4Cb_oi9ePrDizPdUIjBDSrTZk03awCTRRuku1Q9GAtLErVGANvSPb0fUxmuRbQzaafHRs94alQJTnv0cgZ0mqM96PYTid-ezbpt2f_ft3lCHAV3Aczpr2AEpOO2DMBgxQtoqeC1Azwm6Xu_4xN-HdjruPWEt-lvUFzDxX1oqBiX9Nt-jpJl9hg-_gCjYqHmuzznbc0KbNyDi-qTH8QzWNM0ymGDKvqWX7PvD9cKDids-I792vtMiMtgXIglA6fi4bP7KqR1lUjg_Hl2YGSz2o', 0, NULL, '2023-06-13 23:59:34', '2023-06-21 04:56:38', NULL, 'email', NULL, NULL, NULL, NULL),
(63, 'Vishnu', NULL, NULL, NULL, NULL, 'vishnu1231', 'vishnu123@gmail.com', '$2y$10$XoE79ppwnfT.GN3oKNJ4nu75lmJHv7zfTnyr/xac3GP2c9eZYdKC2', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-06-14 00:33:30', '2023-06-14 00:33:30', NULL, 'email', NULL, NULL, NULL, NULL),
(64, 'Abservetech', 'Muthupandi', 'A', 7200930694, 1234, 'Muthupandi A', 'muthukumarsaravanan.m@abserve.tech', '$2y$10$k86fvrf4NRitAR1pjkxkgemjSniSiA0lbUnBVKDG1t3U6kBRD.AWi', '$2y$10$Yl/V9nn/3R18YvTetUtN7O4q87wlik8QHmNBUEKp8NyOhdHeFwtE2', NULL, 'backend/image/default.png', 'company', 'Madurai', 'india', 'male', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiN2VlOTRiM2QwYTIyZGQzMjBhMjY1YWZlMzdjNGVlNDFmODY0NmE1OTc2MTZmYTRhNmJiYTE5ZDhjNjNmMjQ4MzVjMGU3M2MxZjZiZmIyMTgiLCJpYXQiOjE2ODc1MDA2NjMuNzYwOTk0LCJuYmYiOjE2ODc1MDA2NjMuNzYwOTk3LCJleHAiOjE3MTkxMjMwNjMuNjcxNTQ4LCJzdWIiOiI2NCIsInNjb3BlcyI6W119.eVSF6OavxT-kG7rXv1W7qbjCZhO7BmOydKqLXPMcYxU2HimhBL9c78Nf8XluGcUhIlujD4tn9HtFPgewiQUxpofGmXwjeEyB7gSExj3UoLCplbO61Y62tkiZ0JyRNF1GP7adMS0KM3u9Y5aiIeWaFJqCj4lwyoIoypUri9c34PdFKv_zaDHbDEEJQ-vYif07cNaJh6mjwkhjmzohMWnZda6beXdKIdij1wvRcR-qje41Z7USu9ZLsL23tC0MpTj_phT53K-jPpQ0Ap3KHohPS5F7M0T0iHJ7A-uymfBbSWOQ5pOJFyyVgA-Po0KBQyT_cpjwLeT6TBfMYCfJsjUU3w', 0, NULL, '2023-06-17 04:38:22', '2023-06-23 00:41:03', NULL, 'email', NULL, NULL, NULL, NULL),
(65, 'Muthukumar', NULL, NULL, NULL, NULL, 'muthukumar', 'absmuthukumarasaravanan@gmail.com', '$2y$10$mv7zVCNrnhF.46whJlUTZuL.S.Bmiz6aK7SV/cCzyH6BkLATkqgHO', '$2y$10$pdxr4tNnGmNIXTX81lNlLe0RGgOpizEXhTG/8iZVx2NKZ.rwMSOyC', NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 0, 0, 0, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNWI4ZDFlZmFhNmE1NDg0ODkyNzM4YWZhNWYxNzVlYTFiNTU2ZjIyODhiZDY0MGM5ZGJhMGZlYTcxYWI4MDlmYjNkMTU4NjFkNDk0NDlhODgiLCJpYXQiOjE2ODc5MzU0NjEuNDMwNzM0LCJuYmYiOjE2ODc5MzU0NjEuNDMwNzM2LCJleHAiOjE3MTk1NTc4NjEuMzMxODA5LCJzdWIiOiI2NSIsInNjb3BlcyI6W119.Af0Y3z3smqn_hbMmd0r2v9jzDlqWYVbqdN4Zx-W9gZNn4TUQ-hndbStc3thgBV9CnBGXGVOQsbNX8uosPtc9-OSnDr77r8koYBz3gDWEBXfQvHUKJHLC_hyhLHkgGKSuktQoDTmcKxKwAfECY5kBRIGc_V9hy0Bjsjxt1o4lxUaIc7_P1X8hscfyGRWiF-EWeIxpi2qBJgzRYEBE8RI2j6Gp7dIG20yHI_Yx9qQm1IWjPO0RVm_QDblGjB-wUnukf80EVHpey2lVKljXUZbkZlA0E7RvN3_H9v-mcpWyh_lDRnUhhjkP92TXRouqwKriQKq7ZSFqP9CVIZUVzWYMIg', 0, NULL, '2023-06-21 04:13:29', '2023-06-28 01:27:41', NULL, 'email', NULL, NULL, NULL, NULL),
(66, 'Muthukumarabs', NULL, NULL, NULL, NULL, 'muthukumarabs', 'absmuthukumarasaravanan123@gmail.com', '$2y$10$MkCcue31NllMPlRwbTBJ/e0EEbg52p9lPau1FMX.JO37jL4ATTL/y', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 0, 0, 0, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzk4ZWZjZDdjMTMyYzM0MGYxNjc4YzIwMGI2Y2Q0MzQ1MmVhMWE3M2UzNmFjNTJhYzRjZTlmMWQyYzhlZWZlYjhlYzlkOWZhYjcxNTg1MDIiLCJpYXQiOjE2ODc0MTMyNzEuNzk1MjM1LCJuYmYiOjE2ODc0MTMyNzEuNzk1MjM4LCJleHAiOjE3MTkwMzU2NzEuNzU0MDUsInN1YiI6IjY2Iiwic2NvcGVzIjpbXX0.V8uITb72Y1Gk432MsI6rVkWH8Xhr0PZag3m5cTQ1tJ62E13JGwOZ0qeK-EcK2I0NPrJ-YpZZatCF4QCRMTNFbMjBub-_HkQ_il4snEA3S4fSV29SkLNiPPFhdJPH_jUlvfYIfWaTJw7uKDVuyJKN6Z-mev-RzfIy2_faD_4hTFNUkW3xrqA5vjpS1c1TzlfrcMBmLG9Vx14oJzn7lU9yuabNv8MWp8l6v9BMKE8q6ppFKpIs1YH8G-tqkiML9ZePZWgvMJfh3Wvpd60JWJOpVyc3Yv1tHHcjfexifndyH-xIY-tLSwjN4OrDsnTB4m8MXkwFwvFw30I6gxkoXZ1HyA', 0, NULL, '2023-06-21 05:07:18', '2023-06-22 00:24:31', NULL, 'email', NULL, NULL, NULL, NULL),
(86, 'Vijay', NULL, NULL, NULL, NULL, 'Vijay', 'Vijay.m@abserve.tech', '$2y$10$BG6kmqCSDzz1btBY4MgFcuyLysOcvcPBy2bexjsBxM9HuxZuSW112', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-06-22 23:55:40', '2023-06-22 23:55:40', NULL, 'email', NULL, NULL, NULL, NULL),
(88, 'Josephvijay s', 'Josephvijay', 's', 6380094922, NULL, 'Josephvijay s', 'Josephvijay.s@abserve.tech', '$2y$10$W91kOa0x1uAL134qRIO7e.LCc1fgVZoC4bchKnKVVvlStxYExkvAu', '$2y$10$O1Rhdvkwlcwj4RvzAVZUme.ZhwkkvYIna5ozryL8DrTkQgeuSq8Ie', NULL, 'backend/image/default.png', 'company', 'madurai', 'india', 'male', 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmJmNzAyMDBiZjMwYWY1MmY2YjdhMWNkNWYyYmZmZDM0NzBmOGI1ZGE2YjFkODgwMjhmMGMxNzRmZDFmM2JjOTc3ZTgxYTA0NGU2ZWY4MGYiLCJpYXQiOjE2ODc0OTk4NzEuMDY4MDUxLCJuYmYiOjE2ODc0OTk4NzEuMDY4MDUzLCJleHAiOjE3MTkxMjIyNzAuOTg4ODMzLCJzdWIiOiI4OCIsInNjb3BlcyI6W119.fYua6EYdf1O1AZte1e1uGqApiz0w14jE6xixTnVY44xDrTc54ClW3YXG8W9Cx1R9qpolaXEky7e9QdmkNBzzgDK1pkRyQ63pqHHKlxdOHR4hzaCrqORV3mF3p8KjcsZ22DGlPtDyttn_yCItTKNB8JENbv5VRyeG63meIzL9Y9LojISzJ-Fy5B5Y-v3zYqxTQZHrDMGBSGuoUSEsOgDzIML8hz4Hs5BDRt6gUxLvTnbHbCbS5ALXdUMSiR6rfMUnrsCloASaO6BcxoOE-CzoYvlGfm4cjGbhxx3HdE0jRVGeicTLyVn344ghgI-qPlxAXL5hGlz6hgWpbOiUrJNzGg', 0, NULL, '2023-06-23 00:27:50', '2023-06-23 00:27:51', NULL, 'email', NULL, NULL, NULL, NULL),
(89, 'Thanasekaran', NULL, NULL, NULL, NULL, 'kthanasekaran122', 'thanasekaran@gmail.com', '$2y$10$barAaj0wQMQoJalVailiGORcTgj3WyVR/1PPKSSBnQ7k2HZLusXqm', NULL, '2023-06-26 00:09:33', 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, 'MdM6iVBthm', '2023-06-26 00:09:33', '2023-06-26 00:09:33', NULL, 'email', NULL, NULL, NULL, NULL),
(90, 'Saravanakumar', NULL, NULL, NULL, NULL, 'saravanakumar', 'saravanit2322@gmail.com', '$2y$10$63sPOhibOjA5WJVx/4umberlE1/p.4ygZ8F0/oK4UfVU04b//t1NK', NULL, NULL, 'backend/image/default.png', 'candidate', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-06-26 23:27:47', '2023-06-26 23:27:47', NULL, 'email', NULL, NULL, NULL, NULL),
(91, 'basheer', NULL, NULL, NULL, NULL, 'basheer', 'basheer@abserve.tech', '$2y$10$sx4zMx1q7wxlzlk1CJ175e4vk7e.ht0ix56hqX3Ijwvl4f5hq.AQe', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-06-27 00:31:37', '2023-06-27 00:31:37', NULL, 'email', NULL, NULL, NULL, NULL),
(94, 'Dharamadurai', NULL, NULL, NULL, NULL, 'dharamadurai', 'dharamadurai.p@abserve.tech', '$2y$10$0Peke2AUqwltW/zxq135auyE56UJV8ERVTKZ7mECFsGjNTDUzuRii', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTAxODY2ODljZmUzNzc4ZDE2NTAyMWY3NTllODYyOWYwY2YzYjU3ODk3NTU3MDc4YmRmYzc4OWExZTg0Yjk5N2Q5ZWEwYjNiZjlmN2MxNmUiLCJpYXQiOjE2ODc5MzU1MzEuMjMwNDU2LCJuYmYiOjE2ODc5MzU1MzEuMjMwNDU4LCJleHAiOjE3MTk1NTc5MzEuMTMwOTUyLCJzdWIiOiI5NCIsInNjb3BlcyI6W119.OU5wgUImpcJB0MobBkyGzm66WEAjUre2WmW1Z3NRh7QpQvso65nCCWVv8UdnkkXMLiBRjcWZiAEa1G5gIr8IvRT4XTdII2f763X784Z3wdZx7PI42ciJSonNi_dQA2R-sDgSsodyH-2CVYnLPt_1AQ1WInlCNO4Ztz7uqdAJGkl3NEklfGydEtbn5gBbudG-jM4OCmQzUACPUIDutafhHxyWM311j4QkURjE3lP8ACtpcUVUrJo1-KHo9flKw_2w_iTJj_sSaqYTfidLlAF29LEz0hdi0a7nRLnYO1Ti02MucZzC8_ykHLjml2wa4I7DuQdz5BaNEZU84jozmXGv9Q', 0, NULL, '2023-06-27 00:45:49', '2023-06-28 01:28:51', NULL, 'email', NULL, NULL, NULL, NULL),
(95, 'Muthukumar', NULL, NULL, NULL, NULL, 'muthukumar_cYSYC', 'MuthukumarABS01259@gmail.com', '$2y$10$.iHlbIRjq4L8iH5Xwj/pbeEEEx2.EHUVqjzzuNV5vrjA1PsQF3ONS', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-06-27 23:47:30', '2023-06-27 23:47:30', NULL, 'email', NULL, NULL, NULL, NULL),
(96, 'ABs', NULL, NULL, NULL, NULL, 'abs', 'fgfd2@gmail.com', '$2y$10$j0Rby3GC3t1rEX1iDX92ZOpIiIgFYAlo0j2rHUwp6RH0J0HLqGcKa', NULL, NULL, 'backend/image/default.png', 'company', NULL, NULL, NULL, 1, 1, 1, 1, 1, NULL, 0, NULL, '2023-06-28 01:13:38', '2023-06-28 01:13:38', NULL, 'email', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `job_limit` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `featured_job_limit` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `highlight_job_limit` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `candidate_cv_view_limit` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `candidate_cv_view_limitation` enum('unlimited','limited') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'limited'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plans`
--

INSERT INTO `user_plans` (`id`, `company_id`, `plan_id`, `job_limit`, `featured_job_limit`, `highlight_job_limit`, `candidate_cv_view_limit`, `created_at`, `updated_at`, `candidate_cv_view_limitation`) VALUES
(1, 3, 2, 50, 9, 1, 63, '2023-03-07 06:31:37', '2023-04-28 02:19:49', 'limited'),
(4, 7, 1, 5, 2, 1, 4, '2023-04-11 02:24:32', '2023-05-25 04:08:48', 'limited'),
(5, 8, 1, 4, 2, 1, 7, '2023-05-31 05:23:17', '2023-05-31 05:35:44', 'limited'),
(6, 2, 1, 4, 2, 1, 3, '2023-06-01 01:01:35', '2023-06-01 01:12:47', 'limited'),
(8, 11, 1, 2, 1, 0, 58, '2023-06-01 02:55:33', '2023-06-17 00:47:47', 'limited'),
(9, 14, 1, 5, 2, 3, 8, '2023-06-22 00:39:47', '2023-06-22 00:39:47', 'limited'),
(10, 28, 1, 4, 1, 3, 0, '2023-06-26 23:38:27', '2023-06-27 00:16:29', 'limited'),
(11, 29, 1, 5, 2, 3, 8, '2023-06-27 00:32:36', '2023-06-27 00:32:36', 'limited'),
(12, 32, 1, 5, 2, 3, 8, '2023-06-28 07:21:55', '2023-06-28 07:21:55', 'limited');

-- --------------------------------------------------------

--
-- Table structure for table `website_settings`
--

CREATE TABLE `website_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `live_job` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `companies` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `candidates` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `website_settings`
--

INSERT INTO `website_settings` (`id`, `phone`, `address`, `map_address`, `facebook`, `instagram`, `twitter`, `youtube`, `title`, `sub_title`, `description`, `live_job`, `companies`, `candidates`, `created_at`, `updated_at`) VALUES
(1, '(319) 555-0115', '6391 Elgin St. Celina, Delaware 10299, New York, United States of America', 'Zakir Soft Map', 'https://www.facebook.com/zakirsoft', 'https://www.instagram.com/zakirsoft', 'https://www.twitter.com/zakirsoft', 'https://www.youtube.com/zakirsoft', 'Who we are', 'We’re highly skilled and professionals team.', 'Praesent non sem facilisis, hendrerit nisi vitae, volutpat quam. Aliquam metus mauris, semper eu eros vitae, blandit tristique metus. Vestibulum maximus nec justo sed maximus.', '175,324', '97,354', '3,847,154', '2023-02-24 04:43:20', '2023-02-24 04:43:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_searches`
--
ALTER TABLE `admin_searches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_groups`
--
ALTER TABLE `application_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_groups_company_id_foreign` (`company_id`);

--
-- Indexes for table `applied_jobs`
--
ALTER TABLE `applied_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applied_jobs_candidate_id_foreign` (`candidate_id`),
  ADD KEY `applied_jobs_job_id_foreign` (`job_id`),
  ADD KEY `applied_jobs_candidate_resume_id_foreign` (`candidate_resume_id`),
  ADD KEY `applied_jobs_application_group_id_foreign` (`application_group_id`);

--
-- Indexes for table `benefits`
--
ALTER TABLE `benefits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `benefit_translations`
--
ALTER TABLE `benefit_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benefit_translations_benefit_id_foreign` (`benefit_id`);

--
-- Indexes for table `bookmark_candidate_company`
--
ALTER TABLE `bookmark_candidate_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookmark_candidate_company_candidate_id_foreign` (`candidate_id`),
  ADD KEY `bookmark_candidate_company_company_id_foreign` (`company_id`);

--
-- Indexes for table `bookmark_candidate_job`
--
ALTER TABLE `bookmark_candidate_job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookmark_candidate_job_candidate_id_foreign` (`candidate_id`),
  ADD KEY `bookmark_candidate_job_job_id_foreign` (`job_id`);

--
-- Indexes for table `bookmark_company`
--
ALTER TABLE `bookmark_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookmark_company_company_id_foreign` (`company_id`),
  ADD KEY `bookmark_company_candidate_id_foreign` (`candidate_id`),
  ADD KEY `bookmark_company_category_id_foreign` (`category_id`);

--
-- Indexes for table `bookmark_company_category`
--
ALTER TABLE `bookmark_company_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookmark_company_category_bookmark_id_foreign` (`bookmark_id`),
  ADD KEY `bookmark_company_category_category_id_foreign` (`category_id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidates_user_id_foreign` (`user_id`),
  ADD KEY `candidates_role_id_foreign` (`role_id`),
  ADD KEY `candidates_profession_id_foreign` (`profession_id`),
  ADD KEY `candidates_experience_id_foreign` (`experience_id`),
  ADD KEY `candidates_education_id_foreign` (`education_id`);

--
-- Indexes for table `candidate_cv_views`
--
ALTER TABLE `candidate_cv_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_cv_views_company_id_foreign` (`company_id`),
  ADD KEY `candidate_cv_views_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `candidate_education`
--
ALTER TABLE `candidate_education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_education_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `candidate_experiences`
--
ALTER TABLE `candidate_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_experiences_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `candidate_language`
--
ALTER TABLE `candidate_language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_language_candidate_id_foreign` (`candidate_id`),
  ADD KEY `candidate_language_candidate_language_id_foreign` (`candidate_language_id`);

--
-- Indexes for table `candidate_languages`
--
ALTER TABLE `candidate_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_resumes`
--
ALTER TABLE `candidate_resumes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_resumes_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `candidate_skill`
--
ALTER TABLE `candidate_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_skill_candidate_id_foreign` (`candidate_id`),
  ADD KEY `candidate_skill_skill_id_foreign` (`skill_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_contents`
--
ALTER TABLE `cms_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_foreign` (`user_id`),
  ADD KEY `companies_industry_type_id_foreign` (`industry_type_id`),
  ADD KEY `companies_organization_type_id_foreign` (`organization_type_id`),
  ADD KEY `companies_team_size_id_foreign` (`team_size_id`);

--
-- Indexes for table `company_applied_job_rejected`
--
ALTER TABLE `company_applied_job_rejected`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_applied_job_rejected_company_id_foreign` (`company_id`),
  ADD KEY `company_applied_job_rejected_applied_job_id_foreign` (`applied_job_id`);

--
-- Indexes for table `company_applied_job_shortlist`
--
ALTER TABLE `company_applied_job_shortlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_applied_job_shortlist_company_id_foreign` (`company_id`),
  ADD KEY `company_applied_job_shortlist_applied_job_id_foreign` (`applied_job_id`);

--
-- Indexes for table `company_bookmark_categories`
--
ALTER TABLE `company_bookmark_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_bookmark_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `company_messages`
--
ALTER TABLE `company_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_infos`
--
ALTER TABLE `contact_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_infos_user_id_foreign` (`user_id`);

--
-- Indexes for table `cookies`
--
ALTER TABLE `cookies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `earnings_company_id_foreign` (`company_id`),
  ADD KEY `earnings_manual_payment_id_foreign` (`manual_payment_id`),
  ADD KEY `earnings_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emails_email_unique` (`email`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_faq_category_id_foreign` (`faq_category_id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faq_categories_name_unique` (`name`),
  ADD UNIQUE KEY `faq_categories_slug_unique` (`slug`);

--
-- Indexes for table `industry_types`
--
ALTER TABLE `industry_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industry_type_translations`
--
ALTER TABLE `industry_type_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `industry_type_translations_industry_type_id_foreign` (`industry_type_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_company_id_foreign` (`company_id`),
  ADD KEY `jobs_category_id_foreign` (`category_id`),
  ADD KEY `jobs_role_id_foreign` (`role_id`),
  ADD KEY `jobs_experience_id_foreign` (`experience_id`),
  ADD KEY `jobs_education_id_foreign` (`education_id`),
  ADD KEY `jobs_job_type_id_foreign` (`job_type_id`),
  ADD KEY `jobs_salary_type_id_foreign` (`salary_type_id`);

--
-- Indexes for table `job_benefit`
--
ALTER TABLE `job_benefit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_benefit_job_id_foreign` (`job_id`),
  ADD KEY `job_benefit_benefit_id_foreign` (`benefit_id`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_category_translations`
--
ALTER TABLE `job_category_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_category_translations_job_category_id_foreign` (`job_category_id`);

--
-- Indexes for table `job_roles`
--
ALTER TABLE `job_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_role_translations`
--
ALTER TABLE `job_role_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_role_translations_job_role_id_foreign` (`job_role_id`);

--
-- Indexes for table `job_tag`
--
ALTER TABLE `job_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_tag_job_id_foreign` (`job_id`),
  ADD KEY `job_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `job_types`
--
ALTER TABLE `job_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`),
  ADD UNIQUE KEY `languages_icon_unique` (`icon`);

--
-- Indexes for table `manual_payments`
--
ALTER TABLE `manual_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_types`
--
ALTER TABLE `organization_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_missions`
--
ALTER TABLE `our_missions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plans_label_unique` (`label`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_category_id_foreign` (`category_id`),
  ADD KEY `posts_author_id_foreign` (`author_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_author_id_foreign` (`author_id`),
  ADD KEY `post_comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `professions`
--
ALTER TABLE `professions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profession_translations`
--
ALTER TABLE `profession_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profession_translations_profession_id_foreign` (`profession_id`);

--
-- Indexes for table `queue_jobs`
--
ALTER TABLE `queue_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue_jobs_queue_index` (`queue`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary_types`
--
ALTER TABLE `salary_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seos`
--
ALTER TABLE `seos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo_page_contents`
--
ALTER TABLE `seo_page_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_page_contents_page_id_foreign` (`page_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_app_country_foreign` (`app_country`);

--
-- Indexes for table `setup_guides`
--
ALTER TABLE `setup_guides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill_translations`
--
ALTER TABLE `skill_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skill_translations_skill_id_foreign` (`skill_id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_links_user_id_foreign` (`user_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_translations`
--
ALTER TABLE `tag_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_translations_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `team_sizes`
--
ALTER TABLE `team_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_categories`
--
ALTER TABLE `terms_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_plans_company_id_foreign` (`company_id`),
  ADD KEY `user_plans_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_searches`
--
ALTER TABLE `admin_searches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_groups`
--
ALTER TABLE `application_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `applied_jobs`
--
ALTER TABLE `applied_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `benefits`
--
ALTER TABLE `benefits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `benefit_translations`
--
ALTER TABLE `benefit_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `bookmark_candidate_company`
--
ALTER TABLE `bookmark_candidate_company`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookmark_candidate_job`
--
ALTER TABLE `bookmark_candidate_job`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `bookmark_company`
--
ALTER TABLE `bookmark_company`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `bookmark_company_category`
--
ALTER TABLE `bookmark_company_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `candidate_cv_views`
--
ALTER TABLE `candidate_cv_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `candidate_education`
--
ALTER TABLE `candidate_education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `candidate_experiences`
--
ALTER TABLE `candidate_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `candidate_language`
--
ALTER TABLE `candidate_language`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `candidate_languages`
--
ALTER TABLE `candidate_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `candidate_resumes`
--
ALTER TABLE `candidate_resumes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `candidate_skill`
--
ALTER TABLE `candidate_skill`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_contents`
--
ALTER TABLE `cms_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `company_applied_job_rejected`
--
ALTER TABLE `company_applied_job_rejected`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_applied_job_shortlist`
--
ALTER TABLE `company_applied_job_shortlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_bookmark_categories`
--
ALTER TABLE `company_bookmark_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company_messages`
--
ALTER TABLE `company_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_infos`
--
ALTER TABLE `contact_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `cookies`
--
ALTER TABLE `cookies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `industry_types`
--
ALTER TABLE `industry_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `industry_type_translations`
--
ALTER TABLE `industry_type_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `job_benefit`
--
ALTER TABLE `job_benefit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `job_category_translations`
--
ALTER TABLE `job_category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `job_roles`
--
ALTER TABLE `job_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_role_translations`
--
ALTER TABLE `job_role_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `job_tag`
--
ALTER TABLE `job_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manual_payments`
--
ALTER TABLE `manual_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization_types`
--
ALTER TABLE `organization_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `our_missions`
--
ALTER TABLE `our_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professions`
--
ALTER TABLE `professions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `profession_translations`
--
ALTER TABLE `profession_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `queue_jobs`
--
ALTER TABLE `queue_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salary_types`
--
ALTER TABLE `salary_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seos`
--
ALTER TABLE `seos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `seo_page_contents`
--
ALTER TABLE `seo_page_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setup_guides`
--
ALTER TABLE `setup_guides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `skill_translations`
--
ALTER TABLE `skill_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tag_translations`
--
ALTER TABLE `tag_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `team_sizes`
--
ALTER TABLE `team_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `terms_categories`
--
ALTER TABLE `terms_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `website_settings`
--
ALTER TABLE `website_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_groups`
--
ALTER TABLE `application_groups`
  ADD CONSTRAINT `application_groups_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applied_jobs`
--
ALTER TABLE `applied_jobs`
  ADD CONSTRAINT `applied_jobs_application_group_id_foreign` FOREIGN KEY (`application_group_id`) REFERENCES `application_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applied_jobs_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applied_jobs_candidate_resume_id_foreign` FOREIGN KEY (`candidate_resume_id`) REFERENCES `candidate_resumes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applied_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `benefit_translations`
--
ALTER TABLE `benefit_translations`
  ADD CONSTRAINT `benefit_translations_benefit_id_foreign` FOREIGN KEY (`benefit_id`) REFERENCES `benefits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmark_candidate_company`
--
ALTER TABLE `bookmark_candidate_company`
  ADD CONSTRAINT `bookmark_candidate_company_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmark_candidate_company_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmark_candidate_job`
--
ALTER TABLE `bookmark_candidate_job`
  ADD CONSTRAINT `bookmark_candidate_job_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmark_candidate_job_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmark_company`
--
ALTER TABLE `bookmark_company`
  ADD CONSTRAINT `bookmark_company_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmark_company_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `company_bookmark_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmark_company_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmark_company_category`
--
ALTER TABLE `bookmark_company_category`
  ADD CONSTRAINT `bookmark_company_category_bookmark_id_foreign` FOREIGN KEY (`bookmark_id`) REFERENCES `bookmark_company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmark_company_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `company_bookmark_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_education_id_foreign` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidates_experience_id_foreign` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidates_profession_id_foreign` FOREIGN KEY (`profession_id`) REFERENCES `professions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidates_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `job_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_cv_views`
--
ALTER TABLE `candidate_cv_views`
  ADD CONSTRAINT `candidate_cv_views_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`),
  ADD CONSTRAINT `candidate_cv_views_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `candidate_education`
--
ALTER TABLE `candidate_education`
  ADD CONSTRAINT `candidate_education_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_experiences`
--
ALTER TABLE `candidate_experiences`
  ADD CONSTRAINT `candidate_experiences_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_language`
--
ALTER TABLE `candidate_language`
  ADD CONSTRAINT `candidate_language_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidate_language_candidate_language_id_foreign` FOREIGN KEY (`candidate_language_id`) REFERENCES `candidate_languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_resumes`
--
ALTER TABLE `candidate_resumes`
  ADD CONSTRAINT `candidate_resumes_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_skill`
--
ALTER TABLE `candidate_skill`
  ADD CONSTRAINT `candidate_skill_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidate_skill_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_industry_type_id_foreign` FOREIGN KEY (`industry_type_id`) REFERENCES `industry_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_organization_type_id_foreign` FOREIGN KEY (`organization_type_id`) REFERENCES `organization_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_team_size_id_foreign` FOREIGN KEY (`team_size_id`) REFERENCES `team_sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_applied_job_rejected`
--
ALTER TABLE `company_applied_job_rejected`
  ADD CONSTRAINT `company_applied_job_rejected_applied_job_id_foreign` FOREIGN KEY (`applied_job_id`) REFERENCES `applied_jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_applied_job_rejected_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_applied_job_shortlist`
--
ALTER TABLE `company_applied_job_shortlist`
  ADD CONSTRAINT `company_applied_job_shortlist_applied_job_id_foreign` FOREIGN KEY (`applied_job_id`) REFERENCES `applied_jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_applied_job_shortlist_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_bookmark_categories`
--
ALTER TABLE `company_bookmark_categories`
  ADD CONSTRAINT `company_bookmark_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_infos`
--
ALTER TABLE `contact_infos`
  ADD CONSTRAINT `contact_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `earnings`
--
ALTER TABLE `earnings`
  ADD CONSTRAINT `earnings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `earnings_manual_payment_id_foreign` FOREIGN KEY (`manual_payment_id`) REFERENCES `manual_payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `earnings_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_faq_category_id_foreign` FOREIGN KEY (`faq_category_id`) REFERENCES `faq_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `industry_type_translations`
--
ALTER TABLE `industry_type_translations`
  ADD CONSTRAINT `industry_type_translations_industry_type_id_foreign` FOREIGN KEY (`industry_type_id`) REFERENCES `industry_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_education_id_foreign` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_experience_id_foreign` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_job_type_id_foreign` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `job_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_salary_type_id_foreign` FOREIGN KEY (`salary_type_id`) REFERENCES `salary_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_benefit`
--
ALTER TABLE `job_benefit`
  ADD CONSTRAINT `job_benefit_benefit_id_foreign` FOREIGN KEY (`benefit_id`) REFERENCES `benefits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_benefit_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_category_translations`
--
ALTER TABLE `job_category_translations`
  ADD CONSTRAINT `job_category_translations_job_category_id_foreign` FOREIGN KEY (`job_category_id`) REFERENCES `job_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_role_translations`
--
ALTER TABLE `job_role_translations`
  ADD CONSTRAINT `job_role_translations_job_role_id_foreign` FOREIGN KEY (`job_role_id`) REFERENCES `job_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_tag`
--
ALTER TABLE `job_tag`
  ADD CONSTRAINT `job_tag_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `post_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profession_translations`
--
ALTER TABLE `profession_translations`
  ADD CONSTRAINT `profession_translations_profession_id_foreign` FOREIGN KEY (`profession_id`) REFERENCES `professions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seo_page_contents`
--
ALTER TABLE `seo_page_contents`
  ADD CONSTRAINT `seo_page_contents_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `seos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_app_country_foreign` FOREIGN KEY (`app_country`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skill_translations`
--
ALTER TABLE `skill_translations`
  ADD CONSTRAINT `skill_translations_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_links`
--
ALTER TABLE `social_links`
  ADD CONSTRAINT `social_links_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_translations`
--
ALTER TABLE `tag_translations`
  ADD CONSTRAINT `tag_translations_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD CONSTRAINT `user_plans_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_plans_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
