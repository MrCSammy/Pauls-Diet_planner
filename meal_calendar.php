<?php
session_start();
include('includes/db.php');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user category
$stmt = $conn->prepare("SELECT category FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$category = $user['category'] ?? 'Normal';

// Days of the week
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// Check if meal calendar already exists for the user
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM meal_calendar WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if ($res['count'] < 7) {
    // Fetch diet plan based on category
    $diet_stmt = $conn->prepare("SELECT breakfast, lunch, dinner FROM diet_plans WHERE category = ?");
    $diet_stmt->bind_param("s", $category);
    $diet_stmt->execute();
    $diet = $diet_stmt->get_result()->fetch_assoc();

    // Clear any existing calendar to prevent duplication
    $conn->query("DELETE FROM meal_calendar WHERE user_id = $user_id");

    // Insert meals for the 7 days
    foreach ($days as $day) {
        $insert = $conn->prepare("INSERT INTO meal_calendar (user_id, day, breakfast, lunch, dinner, date_updated) VALUES (?, ?, ?, ?, ?, CURDATE())");
        $insert->bind_param("issss", $user_id, $day, $diet['breakfast'], $diet['lunch'], $diet['dinner']);
        $insert->execute();
    }
}

// Retrieve updated weekly meals
$meal_query = "
    SELECT day, breakfast, lunch, dinner
    FROM meal_calendar
    WHERE user_id = ?
    GROUP BY day
    ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
";
$stmt = $conn->prepare($meal_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$meals = [];
while ($row = $result->fetch_assoc()) {
    $meals[$row['day']] = $row;
}

include('includes/header.php');
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Your Weekly Meal Calendar</h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach ($days as $day): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0"><?= $day ?></h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($meals[$day])): ?>
                            <p><strong>Breakfast:</strong> <?= htmlspecialchars($meals[$day]['breakfast']) ?></p>
                            <p><strong>Lunch:</strong> <?= htmlspecialchars($meals[$day]['lunch']) ?></p>
                            <p><strong>Dinner:</strong> <?= htmlspecialchars($meals[$day]['dinner']) ?></p>
                        <?php else: ?>
                            <p class="text-muted">No meals planned.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
        <form method="post">
            <button type="submit" name="refresh" class="btn btn-success">🔄 Refresh Meals</button>
        </form>
    </div>
</div>

<?php
// Refresh logic – pick 7 random meals (from meal_calendar or diet_plans)
if (isset($_POST['refresh'])) {
    // Re-fetch plan for category
    $diet_stmt = $conn->prepare("SELECT breakfast, lunch, dinner FROM diet_plans WHERE category = ?");
    $diet_stmt->bind_param("s", $category);
    $diet_stmt->execute();
    $diet = $diet_stmt->get_result()->fetch_assoc();

    // Update each day
    foreach ($days as $day) {
        $update = $conn->prepare("
            UPDATE meal_calendar 
            SET breakfast = ?, lunch = ?, dinner = ?, date_updated = CURDATE() 
            WHERE user_id = ? AND day = ?
        ");
        $update->bind_param("sssis", $diet['breakfast'], $diet['lunch'], $diet['dinner'], $user_id, $day);
        $update->execute();
    }

    echo "<script>location.href='meal_calendar.php';</script>";
}

include('includes/footer.php');
?>
