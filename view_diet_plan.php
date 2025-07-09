<?php
session_start();
include('includes/db.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/header.php');

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';

// Get current day and time
date_default_timezone_set('Africa/Lagos'); // Adjust to your timezone
$current_day = date('l'); // e.g., Monday
$current_hour = date('H');

// Determine the current meal period
if ($current_hour < 11) {
    $meal_time = 'Breakfast';
} elseif ($current_hour < 16) {
    $meal_time = 'Lunch';
} else {
    $meal_time = 'Dinner';
}

// Fetch today’s meal from meal_calendar
$stmt = $conn->prepare("SELECT breakfast, lunch, dinner FROM meal_calendar WHERE user_id = ? AND day = ?");
$stmt->bind_param("is", $user_id, $current_day);
$stmt->execute();
$result = $stmt->get_result();
$meal_row = $result->fetch_assoc();
?>

<div class="container mt-5">
    <h2 class="text-center">Hi <?= htmlspecialchars($user_name); ?>, Here's Your Meal for Today</h2>
    <p class="text-center">Today is <strong><?= $current_day; ?></strong> and it's <strong><?= $meal_time; ?></strong> time.</p>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header bg-success text-white">
                    <?= $meal_time; ?>
                </div>
                <div class="card-body">
                    <p>
                        <?= isset($meal_row[$meal_time = strtolower($meal_time)]) && $meal_row[$meal_time] 
                            ? htmlspecialchars($meal_row[$meal_time])
                            : "<em>No meal planned yet for this time.</em>"; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
