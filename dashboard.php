<?php
session_start();
include('includes/db.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

// Update login count only once per day
$stmt = $conn->prepare("SELECT email, created_at, login_count, last_login_date FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['registration_date'] = $user['created_at'];
    $_SESSION['user_name'] = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User';

    $login_count = (int)$user['login_count'];
    $last_login_date = $user['last_login_date'];

    if ($last_login_date !== $today) {
        // Update login count and last login date
        $login_count++;
        $update_stmt = $conn->prepare("UPDATE users SET login_count = ?, last_login_date = ? WHERE user_id = ?");
        $update_stmt->bind_param("isi", $login_count, $today, $user_id);
        $update_stmt->execute();
    }

    $_SESSION['login_count'] = $login_count;
} else {
    $_SESSION['user_email'] = 'Not Available';
    $_SESSION['registration_date'] = 'Unknown';
    $_SESSION['login_count'] = 0;
}

// Prepare user data
$user_email = $_SESSION['user_email'];
$registration_date = $_SESSION['registration_date'];
$user_name = $_SESSION['user_name'];
$login_count = $_SESSION['login_count'];

// Fetch the user’s diet progress
$query = "SELECT COUNT(*) AS progress FROM daily_diets WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$progress = 0;
if ($row = $result->fetch_assoc()) {
    $progress = $row['progress'];
}

// Progress Bar Calculation
$total_days = 100; // Arbitrary total progress target
$progress_percentage = min(($progress / $total_days) * 100, 100);

include('includes/header.php');
?>

<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($user_name) ?>!</h2>
    <p>Today's date is <?= date('l, F j, Y') ?>.</p>

    <div class="card mt-4">
        <div class="card-header">
            <h4>User Information</h4>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> <?= htmlspecialchars($user_email) ?></p>
            <p><strong>Registration Date:</strong> <?= htmlspecialchars($registration_date) ?></p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4>Diet Progress</h4>
        </div>
        <div class="card-body">
            <p><strong>Login Streak:</strong> <?= $login_count ?> / <?= $total_days ?></p>
            <div class="progress">
                <div 
                    class="progress-bar" 
                    role="progressbar" 
                    style="width: <?= round($progress_percentage) ?>%;" 
                    aria-valuenow="<?= round($progress_percentage) ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    <?= round($progress_percentage) ?>%
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
