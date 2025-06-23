<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_category'] !== 'Admin') {
    header("Location: ../login.php");
    exit();
}

include('../includes/header.php');

$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_categories = 3; // Obese, Normal, Slender

?>

<div class="container mt-5">
    <h2 class="text-center">Admin Dashboard</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?= htmlspecialchars($total_users); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text"><?= htmlspecialchars($total_categories); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="manage_diet.php" class="btn btn-primary">Manage Diet Plans</a>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
