<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_category'] !== 'Admin') {
    header("Location: ../login.php");
    exit();
}

include('../includes/header.php');

$categories = ['Obese', 'Normal', 'Slender'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $breakfast = $_POST['breakfast'];
    $lunch = $_POST['lunch'];
    $dinner = $_POST['dinner'];
    $snacks = $_POST['snacks'];

    // Check if diet plan exists
    $stmt = $conn->prepare("SELECT plan_id FROM diet_plans WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update
        $stmt->close();
        $stmt = $conn->prepare("UPDATE diet_plans SET breakfast = ?, lunch = ?, dinner = ?, snacks = ? WHERE category = ?");
        $stmt->bind_param("sssss", $breakfast, $lunch, $dinner, $snacks, $category);
        if ($stmt->execute()) {
            $success = "Diet plan for {$category} updated successfully!";
        } else {
            $error = "Failed to update diet plan.";
        }
    } else {
        // Insert
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO diet_plans (category, breakfast, lunch, dinner, snacks) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $category, $breakfast, $lunch, $dinner, $snacks);
        if ($stmt->execute()) {
            $success = "Diet plan for {$category} created successfully!";
        } else {
            $error = "Failed to create diet plan.";
        }
    }
}

// Load diet plan for selected category (default Obese)
$selected_category = $_POST['category'] ?? 'Obese';

$stmt = $conn->prepare("SELECT breakfast, lunch, dinner, snacks FROM diet_plans WHERE category = ?");
$stmt->bind_param("s", $selected_category);
$stmt->execute();
$result = $stmt->get_result();
$diet_plan = $result->fetch_assoc();

?>

<div class="container mt-5">
    <h2 class="text-center">Manage Diet Plans</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="manage_diet.php">
        <div class="mb-3">
            <label>Category:</label>
            <select name="category" class="form-select" onchange="this.form.submit()">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat ?>" <?= $selected_category === $cat ? 'selected' : '' ?>>
                        <?= $cat ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Breakfast:</label>
            <textarea name="breakfast" class="form-control" rows="3"><?= htmlspecialchars($diet_plan['breakfast'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label>Lunch:</label>
            <textarea name="lunch" class="form-control" rows="3"><?= htmlspecialchars($diet_plan['lunch'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label>Dinner:</label>
            <textarea name="dinner" class="form-control" rows="3"><?= htmlspecialchars($diet_plan['dinner'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label>Snacks:</label>
            <textarea name="snacks" class="form-control" rows="3"><?= htmlspecialchars($diet_plan['snacks'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save Diet Plan</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
