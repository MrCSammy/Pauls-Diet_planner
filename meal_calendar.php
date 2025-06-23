<?php
session_start();
include('includes/db.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/header.php');

// Sample meals for demonstration (you can make this dynamic in the future)
$meals = [
    'Monday' => ['Breakfast' => 'Oatmeal', 'Lunch' => 'Chicken Salad', 'Dinner' => 'Grilled Salmon'],
    'Tuesday' => ['Breakfast' => 'Eggs and Toast', 'Lunch' => 'Turkey Sandwich', 'Dinner' => 'Tofu Stir-fry'],
    'Wednesday' => ['Breakfast' => 'Smoothie', 'Lunch' => 'Pasta', 'Dinner' => 'Chicken Roast'],
    'Thursday' => ['Breakfast' => 'Pancakes', 'Lunch' => 'Rice and Beans', 'Dinner' => 'Vegetable Soup'],
    'Friday' => ['Breakfast' => 'Oatmeal', 'Lunch' => 'Grilled Fish', 'Dinner' => 'Steak and Vegetables'],
    'Saturday' => ['Breakfast' => 'Fruit Salad', 'Lunch' => 'Wrap Sandwich', 'Dinner' => 'Grilled Shrimp'],
    'Sunday' => ['Breakfast' => 'Waffles', 'Lunch' => 'Roast Beef', 'Dinner' => 'Baked Chicken'],
];

// Foods to avoid (sample data)
$foods_to_avoid = [
    'Obese' => 'Sugary snacks, fried foods, and soda.',
    'Normal' => 'Excessive processed foods.',
    'Slender' => 'Skipping meals or low-calorie diets.',
];

$body_mass_category = $_SESSION['user_category'];
?>

<div class="container mt-5">
    <h2 class="text-center">Meal Calendar</h2>
    <p class="text-center">Plan your meals for the week and avoid unhealthy options.</p>

    <div class="row">
        <?php foreach ($meals as $day => $meal_plan) : ?>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white"><?= htmlspecialchars($day); ?></div>
                    <div class="card-body">
                        <?php foreach ($meal_plan as $meal => $menu) : ?>
                            <p><strong><?= htmlspecialchars($meal); ?>:</strong> <?= htmlspecialchars($menu); ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <h3>Foods to Avoid</h3>
        <p><strong><?= htmlspecialchars($body_mass_category); ?>:</strong> <?= htmlspecialchars($foods_to_avoid[$body_mass_category]); ?></p>
    </div>
</div>

<?php include('includes/footer.php'); ?>
