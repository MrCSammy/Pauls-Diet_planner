<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_category = $_SESSION['user_category']; // 'Obese', 'Normal', 'Slender'
$current_date = date('Y-m-d');

// Define diet plans for each category
$diets = [
    'Obese' => [
        "Low-carb Breakfast, Grilled Chicken Salad Lunch, Steamed Vegetables Dinner",
        "Fruit Smoothie Breakfast, Lean Protein Bowl Lunch, Grilled Fish Dinner",
        "Oatmeal with Almonds Breakfast, Vegetable Stir-fry Lunch, Baked Salmon Dinner",
        "Green Tea Breakfast, Quinoa Salad Lunch, Roasted Cauliflower Dinner",
        "Cucumber and Hummus Breakfast, Lentil Soup Lunch, Tofu Stir-fry Dinner",
        "Avocado and Egg Toast Breakfast, Grilled Shrimp Salad Lunch, Broccoli and Chicken Dinner",
        "Smoothie Bowl Breakfast, Wild Rice and Vegetables Lunch, Zucchini Noodles Dinner",
        "Greek Yogurt and Nuts Breakfast, Spinach and Feta Wrap Lunch, Grilled Tuna Dinner",
        "Boiled Eggs and Veggies Breakfast, Grilled Turkey Lunch, Steamed Fish Dinner",
        "Chia Pudding Breakfast, Couscous and Veggies Lunch, Roasted Asparagus Dinner",
        "Hard-boiled Eggs Breakfast, Lean Beef Lunch, Sauteed Spinach Dinner",
        "Herbal Tea Breakfast, Barley Salad Lunch, Stuffed Peppers Dinner",
    ],
    'Normal' => [
        "Eggs and Toast Breakfast, Chicken Sandwich Lunch, Roast Beef Dinner",
        "Pancakes Breakfast, Pasta and Salad Lunch, Grilled Steak Dinner",
        "Cereal Breakfast, Sushi Lunch, Roast Chicken Dinner",
        "Bagel Breakfast, Baked Potato and Beans Lunch, Roast Pork Dinner",
        "French Toast Breakfast, Turkey Wrap Lunch, Meatloaf Dinner",
        "Omelette Breakfast, Risotto Lunch, Grilled Halibut Dinner",
        "Fruit Salad Breakfast, Caprese Sandwich Lunch, Chicken Marsala Dinner",
        "Blueberry Muffin Breakfast, Bolognese Lunch, Salmon Tacos Dinner",
        "Veggie Frittata Breakfast, Fajitas Lunch, BBQ Chicken Dinner",
        "Waffles Breakfast, Club Sandwich Lunch, Shrimp Stir-fry Dinner",
        "Peanut Butter Toast Breakfast, Burrito Bowl Lunch, Herb Chicken Dinner",
        "Granola and Milk Breakfast, Caesar Salad Lunch, Lamb Chops Dinner",
    ],
    'Slender' => [
        "Full English Breakfast, Cheeseburger Lunch, High-Calorie Dinner with Dessert",
        "Bagel with Cream Cheese Breakfast, Pizza Lunch, BBQ Ribs Dinner",
        "Avocado Toast Breakfast, Pasta Alfredo Lunch, Fried Rice and Chicken Dinner",
        "Pancakes with Maple Syrup Breakfast, Mac and Cheese Lunch, Baked Ziti Dinner",
        "Hash Browns and Sausage Breakfast, Philly Cheesesteak Lunch, Loaded Nachos Dinner",
        "Breakfast Burrito, Grilled Cheese Sandwich Lunch, Fried Pork Chops Dinner",
        "Croissant Sandwich Breakfast, Meatball Sub Lunch, Chicken Parmesan Dinner",
        "Chocolate Chip Muffin Breakfast, Chili Con Carne Lunch, Pork Ribs Dinner",
        "Toasted Bagel Breakfast, Lasagna Lunch, Cheesecake Dinner",
        "Eggs Benedict Breakfast, Beef Stroganoff Lunch, Fried Chicken Dinner",
        "French Croissant Breakfast, BBQ Pork Lunch, Stuffed Meatloaf Dinner",
        "Buttered Pancakes Breakfast, Loaded Fries Lunch, Creamy Chicken Curry Dinner",
    ]
];

// Handle diet refresh
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refresh_diet'])) {
    // Assign a new diet for today based on the category
    $new_diet = $diets[$user_category][array_rand($diets[$user_category])];

    // Update or insert today's diet
    $stmt = $conn->prepare("REPLACE INTO daily_diets (user_id, date, diet) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $current_date, $new_diet);
    $stmt->execute();

    // Reload the page to reflect changes
    header('Location: dashboard.php');
    exit;
}

// Fetch today's diet
$query = "SELECT diet FROM daily_diets WHERE user_id = ? AND date = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $current_date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $today_diet = $result->fetch_assoc()['diet'];
} else {
    // Assign a new diet if none exists
    $today_diet = $diets[$user_category][array_rand($diets[$user_category])];
    $stmt = $conn->prepare("INSERT INTO daily_diets (user_id, date, diet) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $current_date, $today_diet);
    $stmt->execute();
}

// Fetch yesterday's diet
$yesterday_date = date('Y-m-d', strtotime('-1 day'));
$yesterday_query = "SELECT diet FROM daily_diets WHERE user_id = ? AND date = ?";
$yesterday_stmt = $conn->prepare($yesterday_query);
$yesterday_stmt->bind_param("is", $user_id, $yesterday_date);
$yesterday_stmt->execute();
$yesterday_result = $yesterday_stmt->get_result();

$yesterday_diet = $yesterday_result->num_rows > 0 ? $yesterday_result->fetch_assoc()['diet'] : "No diet assigned";

include('includes/header.php');
?>

<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($user_name) ?>!</h2>
    <p>Today's date is <?= date('l, F j, Y') ?>.</p>

    <?php if ($yesterday_diet !== "No diet assigned"): ?>
        <p>Yesterday, you had the following diet: <strong><?= htmlspecialchars($yesterday_diet) ?></strong>.</p>
    <?php endif; ?>

    <p>Today, you will be having the following diet: <strong><?= htmlspecialchars($today_diet) ?></strong>.</p>

    <form method="POST" action="dashboard.php">
        <button type="submit" name="refresh_diet" class="btn btn-primary mt-3">Refresh Today's Diet</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
