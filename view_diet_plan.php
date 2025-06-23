<?php
session_start();
include('includes/db.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/header.php');

// Fetch user's body mass category from session
$body_mass_category = $_SESSION['user_category'];

// Define diet plans
$diet_plans = [
    'Obese' => [
        'Breakfast' => 'Oatmeal with fresh fruit',
        'Lunch' => 'Grilled chicken salad with olive oil dressing',
        'Dinner' => 'Steamed vegetables with baked salmon',
        'Snacks' => 'Carrot sticks or an apple',
    ],
    'Normal' => [
        'Breakfast' => 'Eggs with whole-grain toast and avocado',
        'Lunch' => 'Grilled turkey sandwich with a side of vegetables',
        'Dinner' => 'Stir-fried tofu with brown rice',
        'Snacks' => 'Mixed nuts or yogurt',
    ],
    'Slender' => [
        'Breakfast' => 'Pancakes with peanut butter and banana slices',
        'Lunch' => 'Pasta with lean ground beef and tomato sauce',
        'Dinner' => 'Roast chicken with mashed potatoes and green beans',
        'Snacks' => 'Smoothies or protein bars',
    ],
];

// Get the specific diet plan for the user
$diet_plan = $diet_plans[$body_mass_category];
?>

<div class="container mt-5">
    <h2 class="text-center">Your Personalized Diet Plan</h2>
    <p class="text-center">Tailored for your category: <strong><?= htmlspecialchars($body_mass_category); ?></strong></p>

    <div class="row mt-4">
        <?php foreach ($diet_plan as $meal => $menu) : ?>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white"><?= htmlspecialchars($meal); ?></div>
                    <div class="card-body">
                        <p><?= htmlspecialchars($menu); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
