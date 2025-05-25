<?php
// Start session and include database connection
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
require_once 'includes/db.php'; // Update with your database connection file path
include('includes/header.php');


// Fetch meals from the database
$query = "SELECT * FROM meal_calendar WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$meals = [];

while ($row = $result->fetch_assoc()) {
    $meals[$row['day']] = [
        'Breakfast' => $row['breakfast'],
        'Lunch' => $row['lunch'],
        'Dinner' => $row['dinner']
    ];
}

// Handle Refresh Button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refresh_meal'])) {
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $updated_meals = [
        'Breakfast' => ['Oatmeal', 'Eggs', 'Smoothie', 'Pancakes', 'Toast', 'Fruit Salad', 'Waffles'],
        'Lunch' => ['Chicken Salad', 'Turkey Sandwich', 'Pasta', 'Rice and Beans', 'Grilled Fish', 'Wrap', 'Roast Beef'],
        'Dinner' => ['Grilled Salmon', 'Tofu Stir-fry', 'Chicken Roast', 'Vegetable Soup', 'Steak', 'Shrimp', 'Baked Chicken']
    ];

    foreach ($days as $day) {
        $breakfast = $updated_meals['Breakfast'][array_rand($updated_meals['Breakfast'])];
        $lunch = $updated_meals['Lunch'][array_rand($updated_meals['Lunch'])];
        $dinner = $updated_meals['Dinner'][array_rand($updated_meals['Dinner'])];

        $stmt = $conn->prepare("REPLACE INTO meal_calendar (user_id, day, breakfast, lunch, dinner, date_updated) VALUES (?, ?, ?, ?, ?, CURDATE())");
        $stmt->bind_param("issss", $_SESSION['user_id'], $day, $breakfast, $lunch, $dinner);
        $stmt->execute();
    }

    // Reload page to reflect changes
    header("Location: meal_calendar.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Calendar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Meal Calendar</h2>
        <form method="POST" class="mb-4">
            <button type="submit" name="refresh_meal" class="btn btn-primary">Refresh Weekly Meal Plan</button>
        </form>
        <div class="row">
            <?php if (!empty($meals)) : ?>
                <?php foreach ($meals as $day => $meal_plan) : ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center fw-bold"><?= htmlspecialchars($day) ?></div>
                            <div class="card-body">
                                <p><strong>Breakfast:</strong> <?= htmlspecialchars($meal_plan['Breakfast']) ?></p>
                                <p><strong>Lunch:</strong> <?= htmlspecialchars($meal_plan['Lunch']) ?></p>
                                <p><strong>Dinner:</strong> <?= htmlspecialchars($meal_plan['Dinner']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No meal plan available. Please click the refresh button to generate one.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php include('includes/footer.php'); ?>