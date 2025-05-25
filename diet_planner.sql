-- Create the database
CREATE DATABASE diet_planner;

-- Use the database
USE diet_planner;
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    category ENUM('Obese', 'Normal', 'Slender', 'Admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample users
INSERT INTO users (name, email, password, category) VALUES
('Admin User', 'admin@example.com', '$2y$10$R9qIxi.1nZigEO2YYP25zOJCl6TqOfMb5.Gx29oVhF.0/K1LCcKjS', 'Admin'),
('John Doe', 'john@example.com', '$2y$10$vKY1Kq8drN9Qcq3Gjq1Qde8BkefZzpo2kOFlLoaRZY/ROV3QfMWGS', 'Obese'),
('Jane Smith', 'jane@example.com', '$2y$10$kqZ1vYtMI6jxOtAVAwXTa.D9D7sxG2qaTPzix7g1H1tlPxKQ.kbJW', 'Normal'),
('Bob Brown', 'bob@example.com', '$2y$10$RH1QYiRXQQjl0UrQAYpTfOXHzpBveLys0WkXy9sYkd.J3YX1NqGmi', 'Slender');
-- Sample admin user
CREATE TABLE diet_plans (
    plan_id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('Obese', 'Normal', 'Slender') NOT NULL,
    breakfast VARCHAR(255) NOT NULL,
    lunch VARCHAR(255) NOT NULL,
    dinner VARCHAR(255) NOT NULL,
    snacks VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample diet plans
INSERT INTO diet_plans (category, breakfast, lunch, dinner, snacks) VALUES
('Obese', 'Oatmeal with fresh fruit', 'Grilled chicken salad', 'Steamed vegetables with baked salmon', 'Carrot sticks'),
('Normal', 'Eggs and whole-grain toast', 'Turkey sandwich', 'Stir-fried tofu', 'Mixed nuts'),
('Slender', 'Pancakes with peanut butter', 'Pasta with lean ground beef', 'Roast chicken', 'Smoothies');
CREATE TABLE meal_calendar (
    calendar_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    breakfast VARCHAR(255) NOT NULL,
    lunch VARCHAR(255) NOT NULL,
    dinner VARCHAR(255) NOT NULL,
    snacks VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample meal schedules for John Doe (user_id = 2)
INSERT INTO meal_calendar (user_id, day, breakfast, lunch, dinner, snacks) VALUES
(2, 'Monday', 'Oatmeal', 'Chicken Salad', 'Grilled Salmon', 'Carrot sticks'),
(2, 'Tuesday', 'Eggs and Toast', 'Turkey Sandwich', 'Tofu Stir-fry', 'Mixed nuts');
CREATE TABLE daily_diets (
    diet_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    diet TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
-- Sample daily diets for John Doe (user_id = 2)
INSERT INTO daily_diets (user_id, date, diet) VALUES
(2, '2023-10-01', 'Breakfast: Oatmeal with fruit, Lunch: Grilled chicken salad, Dinner: Steamed vegetables with salmon'),
(2, '2023-10-02', 'Breakfast: Eggs and toast, Lunch: Turkey sandwich, Dinner: Stir-fried tofu');