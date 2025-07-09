-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 09, 2025 at 05:28 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diet_planner`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_diets`
--

DROP TABLE IF EXISTS `daily_diets`;
CREATE TABLE IF NOT EXISTS `daily_diets` (
  `diet_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `diet` text NOT NULL,
  PRIMARY KEY (`diet_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daily_diets`
--

INSERT INTO `daily_diets` (`diet_id`, `user_id`, `date`, `diet`) VALUES
(1, 2, '2023-10-01', 'Breakfast: Oatmeal with fruit, Lunch: Grilled chicken salad, Dinner: Steamed vegetables with salmon'),
(2, 2, '2023-10-02', 'Breakfast: Eggs and toast, Lunch: Turkey sandwich, Dinner: Stir-fried tofu'),
(3, 2, '2023-10-01', 'Breakfast: Oatmeal with fruit, Lunch: Grilled chicken salad, Dinner: Steamed vegetables with salmon'),
(4, 2, '2023-10-02', 'Breakfast: Eggs and toast, Lunch: Turkey sandwich, Dinner: Stir-fried tofu'),
(5, 9, '2025-05-19', 'Scrambled Eggs Breakfast, Turkey Sandwich Lunch, Baked Salmon Dinner'),
(6, 9, '2025-05-19', 'Pancakes Breakfast, Pasta and Salad Lunch, Grilled Steak Dinner'),
(7, 9, '2025-05-19', 'Eggs and Toast Breakfast, Chicken Sandwich Lunch, Roast Beef Dinner'),
(8, 9, '2025-05-19', 'Cereal Breakfast, Sushi Lunch, Roast Chicken Dinner'),
(9, 9, '2025-05-19', 'Cereal Breakfast, Sushi Lunch, Roast Chicken Dinner'),
(10, 9, '2025-05-19', 'Pancakes Breakfast, Pasta and Salad Lunch, Grilled Steak Dinner'),
(11, 9, '2025-05-19', 'Pancakes Breakfast, Pasta and Salad Lunch, Grilled Steak Dinner'),
(12, 9, '2025-05-19', 'Eggs and Toast Breakfast, Chicken Sandwich Lunch, Roast Beef Dinner'),
(13, 9, '2025-05-19', 'Pancakes Breakfast, Pasta and Salad Lunch, Grilled Steak Dinner'),
(14, 9, '2025-05-19', 'Cereal Breakfast, Sushi Lunch, Roast Chicken Dinner'),
(15, 9, '2025-05-19', 'Cereal Breakfast, Sushi Lunch, Roast Chicken Dinner'),
(16, 9, '2025-05-19', 'Eggs and Toast Breakfast, Chicken Sandwich Lunch, Roast Beef Dinner'),
(17, 9, '2025-05-19', 'Fruit Salad Breakfast, Caprese Sandwich Lunch, Chicken Marsala Dinner'),
(18, 9, '2025-05-25', 'Granola and Milk Breakfast, Caesar Salad Lunch, Lamb Chops Dinner'),
(19, 9, '2025-05-25', 'Fruit Salad Breakfast, Caprese Sandwich Lunch, Chicken Marsala Dinner'),
(20, 9, '2025-05-25', 'Waffles Breakfast, Club Sandwich Lunch, Shrimp Stir-fry Dinner'),
(21, 9, '2025-05-25', 'Refreshed diet for Normal'),
(22, 9, '2025-05-25', 'Refreshed diet for Normal'),
(23, 10, '2025-06-23', 'Cereal Breakfast, Sushi Lunch, Roast Chicken Dinner'),
(24, 10, '2025-06-23', 'Eggs and Toast Breakfast, Chicken Sandwich Lunch, Roast Beef Dinner'),
(25, 10, '2025-06-23', 'Waffles Breakfast, Club Sandwich Lunch, Shrimp Stir-fry Dinner'),
(26, 10, '2025-06-23', 'Veggie Frittata Breakfast, Fajitas Lunch, BBQ Chicken Dinner'),
(27, 10, '2025-06-23', 'Veggie Frittata Breakfast, Fajitas Lunch, BBQ Chicken Dinner'),
(28, 10, '2025-06-23', 'Eggs and Toast Breakfast, Chicken Sandwich Lunch, Roast Beef Dinner'),
(29, 11, '2025-06-25', 'Buttered Pancakes Breakfast, Loaded Fries Lunch, Creamy Chicken Curry Dinner'),
(30, 11, '2025-06-25', 'Pancakes with Maple Syrup Breakfast, Mac and Cheese Lunch, Baked Ziti Dinner');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plans`
--

DROP TABLE IF EXISTS `diet_plans`;
CREATE TABLE IF NOT EXISTS `diet_plans` (
  `plan_id` int NOT NULL AUTO_INCREMENT,
  `category` enum('Obese','Normal','Slender') NOT NULL,
  `breakfast` varchar(255) NOT NULL,
  `lunch` varchar(255) NOT NULL,
  `dinner` varchar(255) NOT NULL,
  `snacks` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diet_plans`
--

INSERT INTO `diet_plans` (`plan_id`, `category`, `breakfast`, `lunch`, `dinner`, `snacks`, `created_at`, `updated_at`) VALUES
(1, 'Obese', 'Oatmeal with fresh fruit', 'Grilled chicken salad', 'Steamed vegetables with baked salmon', 'Carrot sticks', '2025-05-19 19:22:41', '2025-05-19 19:22:41'),
(2, 'Normal', 'Eggs and whole-grain toast', 'Turkey sandwich', 'Stir-fried tofu', 'Mixed nuts', '2025-05-19 19:22:41', '2025-05-19 19:22:41'),
(3, 'Slender', 'Pancakes with peanut butter', 'Pasta with lean ground beef', 'Roast chicken', 'Smoothies', '2025-05-19 19:22:41', '2025-05-19 19:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `meal_calendar`
--

DROP TABLE IF EXISTS `meal_calendar`;
CREATE TABLE IF NOT EXISTS `meal_calendar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `day` varchar(20) NOT NULL,
  `breakfast` varchar(255) NOT NULL,
  `lunch` varchar(255) NOT NULL,
  `dinner` varchar(255) NOT NULL,
  `date_updated` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `meal_calendar`
--

INSERT INTO `meal_calendar` (`id`, `user_id`, `day`, `breakfast`, `lunch`, `dinner`, `date_updated`) VALUES
(1, 9, 'Monday', 'Pancakes', 'Roast Beef', 'Chicken Roast', '2025-05-25'),
(2, 9, 'Tuesday', 'Toast', 'Roast Beef', 'Vegetable Soup', '2025-05-25'),
(3, 9, 'Wednesday', 'Smoothie', 'Wrap', 'Vegetable Soup', '2025-05-25'),
(4, 9, 'Thursday', 'Waffles', 'Grilled Fish', 'Tofu Stir-fry', '2025-05-25'),
(5, 9, 'Friday', 'Toast', 'Grilled Fish', 'Vegetable Soup', '2025-05-25'),
(6, 9, 'Saturday', 'Oatmeal', 'Pasta', 'Chicken Roast', '2025-05-25'),
(7, 9, 'Sunday', 'Smoothie', 'Chicken Salad', 'Baked Chicken', '2025-05-25'),
(8, 9, 'Monday', 'Pancakes', 'Roast Beef', 'Vegetable Soup', '2025-05-25'),
(9, 9, 'Tuesday', 'Fruit Salad', 'Pasta', 'Shrimp', '2025-05-25'),
(10, 9, 'Wednesday', 'Pancakes', 'Pasta', 'Steak', '2025-05-25'),
(11, 9, 'Thursday', 'Fruit Salad', 'Wrap', 'Vegetable Soup', '2025-05-25'),
(12, 9, 'Friday', 'Smoothie', 'Grilled Fish', 'Vegetable Soup', '2025-05-25'),
(13, 9, 'Saturday', 'Smoothie', 'Chicken Salad', 'Grilled Salmon', '2025-05-25'),
(14, 9, 'Sunday', 'Waffles', 'Grilled Fish', 'Chicken Roast', '2025-05-25'),
(15, 9, 'Monday', 'Smoothie', 'Chicken Salad', 'Chicken Roast', '2025-05-25'),
(16, 9, 'Tuesday', 'Eggs', 'Chicken Salad', 'Baked Chicken', '2025-05-25'),
(17, 9, 'Wednesday', 'Oatmeal', 'Grilled Fish', 'Vegetable Soup', '2025-05-25'),
(18, 9, 'Thursday', 'Toast', 'Wrap', 'Vegetable Soup', '2025-05-25'),
(19, 9, 'Friday', 'Oatmeal', 'Pasta', 'Shrimp', '2025-05-25'),
(20, 9, 'Saturday', 'Toast', 'Roast Beef', 'Vegetable Soup', '2025-05-25'),
(21, 9, 'Sunday', 'Fruit Salad', 'Pasta', 'Baked Chicken', '2025-05-25'),
(22, 9, 'Monday', 'Waffles', 'Roast Beef', 'Shrimp', '2025-05-25'),
(23, 9, 'Tuesday', 'Eggs', 'Pasta', 'Steak', '2025-05-25'),
(24, 9, 'Wednesday', 'Waffles', 'Roast Beef', 'Shrimp', '2025-05-25'),
(25, 9, 'Thursday', 'Pancakes', 'Wrap', 'Vegetable Soup', '2025-05-25'),
(26, 9, 'Friday', 'Oatmeal', 'Chicken Salad', 'Chicken Roast', '2025-05-25'),
(27, 9, 'Saturday', 'Smoothie', 'Turkey Sandwich', 'Steak', '2025-05-25'),
(28, 9, 'Sunday', 'Toast', 'Rice and Beans', 'Shrimp', '2025-05-25'),
(29, 9, 'Monday', 'Oatmeal', 'Wrap', 'Baked Chicken', '2025-05-25'),
(30, 9, 'Tuesday', 'Fruit Salad', 'Grilled Fish', 'Shrimp', '2025-05-25'),
(31, 9, 'Wednesday', 'Toast', 'Pasta', 'Tofu Stir-fry', '2025-05-25'),
(32, 9, 'Thursday', 'Fruit Salad', 'Pasta', 'Vegetable Soup', '2025-05-25'),
(33, 9, 'Friday', 'Smoothie', 'Rice and Beans', 'Vegetable Soup', '2025-05-25'),
(34, 9, 'Saturday', 'Pancakes', 'Grilled Fish', 'Grilled Salmon', '2025-05-25'),
(35, 9, 'Sunday', 'Oatmeal', 'Wrap', 'Shrimp', '2025-05-25'),
(36, 9, 'Monday', 'Pancakes', 'Pasta', 'Grilled Salmon', '2025-05-25'),
(37, 9, 'Tuesday', 'Waffles', 'Chicken Salad', 'Shrimp', '2025-05-25'),
(38, 9, 'Wednesday', 'Oatmeal', 'Grilled Fish', 'Baked Chicken', '2025-05-25'),
(39, 9, 'Thursday', 'Waffles', 'Grilled Fish', 'Steak', '2025-05-25'),
(40, 9, 'Friday', 'Pancakes', 'Wrap', 'Tofu Stir-fry', '2025-05-25'),
(41, 9, 'Saturday', 'Toast', 'Wrap', 'Grilled Salmon', '2025-05-25'),
(42, 9, 'Sunday', 'Oatmeal', 'Rice and Beans', 'Steak', '2025-05-25'),
(43, 9, 'Monday', 'Waffles', 'Turkey Sandwich', 'Baked Chicken', '2025-05-25'),
(44, 9, 'Tuesday', 'Smoothie', 'Chicken Salad', 'Tofu Stir-fry', '2025-05-25'),
(45, 9, 'Wednesday', 'Smoothie', 'Grilled Fish', 'Steak', '2025-05-25'),
(46, 9, 'Thursday', 'Toast', 'Chicken Salad', 'Steak', '2025-05-25'),
(47, 9, 'Friday', 'Smoothie', 'Rice and Beans', 'Shrimp', '2025-05-25'),
(48, 9, 'Saturday', 'Toast', 'Wrap', 'Shrimp', '2025-05-25'),
(49, 9, 'Sunday', 'Fruit Salad', 'Chicken Salad', 'Grilled Salmon', '2025-05-25'),
(50, 9, 'Monday', 'Pancakes', 'Roast Beef', 'Tofu Stir-fry', '2025-05-25'),
(51, 9, 'Tuesday', 'Oatmeal', 'Chicken Salad', 'Grilled Salmon', '2025-05-25'),
(52, 9, 'Wednesday', 'Waffles', 'Roast Beef', 'Tofu Stir-fry', '2025-05-25'),
(53, 9, 'Thursday', 'Toast', 'Chicken Salad', 'Steak', '2025-05-25'),
(54, 9, 'Friday', 'Pancakes', 'Roast Beef', 'Shrimp', '2025-05-25'),
(55, 9, 'Saturday', 'Oatmeal', 'Rice and Beans', 'Grilled Salmon', '2025-05-25'),
(56, 9, 'Sunday', 'Fruit Salad', 'Chicken Salad', 'Grilled Salmon', '2025-05-25'),
(57, 9, 'Monday', 'Eggs', 'Wrap', 'Steak', '2025-05-25'),
(58, 9, 'Tuesday', 'Eggs', 'Pasta', 'Steak', '2025-05-25'),
(59, 9, 'Wednesday', 'Fruit Salad', 'Grilled Fish', 'Tofu Stir-fry', '2025-05-25'),
(60, 9, 'Thursday', 'Oatmeal', 'Rice and Beans', 'Grilled Salmon', '2025-05-25'),
(61, 9, 'Friday', 'Eggs', 'Rice and Beans', 'Baked Chicken', '2025-05-25'),
(62, 9, 'Saturday', 'Smoothie', 'Pasta', 'Vegetable Soup', '2025-05-25'),
(63, 9, 'Sunday', 'Toast', 'Chicken Salad', 'Shrimp', '2025-05-25'),
(64, 9, 'Monday', 'Fruit Salad', 'Wrap', 'Baked Chicken', '2025-05-25'),
(65, 9, 'Tuesday', 'Fruit Salad', 'Pasta', 'Steak', '2025-05-25'),
(66, 9, 'Wednesday', 'Pancakes', 'Pasta', 'Vegetable Soup', '2025-05-25'),
(67, 9, 'Thursday', 'Fruit Salad', 'Grilled Fish', 'Tofu Stir-fry', '2025-05-25'),
(68, 9, 'Friday', 'Fruit Salad', 'Rice and Beans', 'Vegetable Soup', '2025-05-25'),
(69, 9, 'Saturday', 'Smoothie', 'Roast Beef', 'Grilled Salmon', '2025-05-25'),
(70, 9, 'Sunday', 'Pancakes', 'Rice and Beans', 'Grilled Salmon', '2025-05-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `category` enum('Obese','Normal','Slender','Admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `category`, `created_at`) VALUES
(7, 'Jane Smith', 'jane@example.com', '$2y$10$kqZ1vYtMI6jxOtAVAwXTa.D9D7sxG2qaTPzix7g1H1tlPxKQ.kbJW', 'Normal', '2025-05-19 20:23:04'),
(6, 'John Doe', 'john@example.com', '$2y$10$vKY1Kq8drN9Qcq3Gjq1Qde8BkefZzpo2kOFlLoaRZY/ROV3QfMWGS', 'Obese', '2025-05-19 20:23:04'),
(5, 'Admin User', 'admin@example.com', '$2y$10$R9qIxi.1nZigEO2YYP25zOJCl6TqOfMb5.Gx29oVhF.0/K1LCcKjS', 'Admin', '2025-05-19 20:23:04'),
(8, 'Bob Brown', 'bob@example.com', '$2y$10$RH1QYiRXQQjl0UrQAYpTfOXHzpBveLys0WkXy9sYkd.J3YX1NqGmi', 'Slender', '2025-05-19 20:23:04'),
(9, 'Samuel Smart', 'teacher@example.com', '$2y$10$t8Z9NS6rBawaHvwykOOmx.FHNtZ5vStth4PheigtR5JQZbj1gP9m.', 'Normal', '2025-05-19 21:36:10'),
(1, 'Administrator', 'admin@admin.com', '$2y$10$KbqiZR5z.E6mk3yzKFYvjOORpZgQUQl.LWODZ03uAYPswqHiSH/iO', 'Admin', '2025-05-25 19:09:08'),
(10, 'Smart Samuel', 'mail@mail.com', '$2y$10$b2u2e5HSu1Hj6XiPr8hvKePmdGEiyHsBCfRelcOeYo3GcsC3VnUt2', 'Normal', '2025-06-23 12:53:09'),
(11, 'Remi Alliu', 'remi@gmail.com', '$2y$10$TEmL7BG/SF2b6xbngZipW.9hx9T6ujujI1OIcvOQpuQf10DMAYUSW', 'Slender', '2025-06-25 16:45:49');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
