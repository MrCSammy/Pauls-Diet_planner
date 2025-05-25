<?php
session_start();
include('includes/db.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user details from the database if not already set in session
if (!isset($_SESSION['user_email']) || !isset($_SESSION['created_at'])) {
    $stmt = $conn->prepare("SELECT email, created_at FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['created_at'] = $user['created_at'];
    } else {
        $_SESSION['user_email'] = 'Not Available';
        $_SESSION['created_at'] = 'Unknown';
    }
}


// Initialize session variables with defaults if not set
$login_count = isset($_SESSION['login_count']) ? $_SESSION['login_count'] : 0;
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Not Available';
$created_at = isset($_SESSION['created_at']) ? $_SESSION['created_at'] : 'Unknown';
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User';

// Fetch the user’s diet progress
$current_date = date('Y-m-d');
$query = "SELECT COUNT(*) AS progress FROM daily_diets WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$progress = $result->num_rows > 0 ? $result->fetch_assoc()['progress'] : 0;

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
            <p><strong>Registration Date:</strong> <?= htmlspecialchars($created_at) ?></p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4>Diet Progress</h4>
        </div>
        <div class="card-body">
            <p><strong>Login Streak:</strong> <?= htmlspecialchars($login_count) ?> / <?= $total_days ?></p>
            <div class="progress">
                <div 
                    class="progress-bar" 
                    role="progressbar" 
                    style="width: <?= htmlspecialchars($progress_percentage) ?>%;" 
                    aria-valuenow="<?= htmlspecialchars($progress_percentage) ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                    <?= round($progress_percentage) ?>%
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
