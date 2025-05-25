<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $category = $_POST['category']; // 'Obese', 'Normal', 'Slender'

    // Validate required fields (can add more validation if needed)
    if (empty($name) || empty($email) || empty($password) || empty($category)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, category) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $category);

            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_category'] = $category;

                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

include('includes/header.php');
?>

<div class="container mt-5">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="register.php" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" id="name" required class="form-control" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" required class="form-control" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" required class="form-control" />
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Body Mass Category:</label>
            <select name="category" id="category" required class="form-select">
                <option value="">Select category</option>
                <option value="Obese" <?= (isset($category) && $category === 'Obese') ? 'selected' : '' ?>>Obese (Reduce size)</option>
                <option value="Normal" <?= (isset($category) && $category === 'Normal') ? 'selected' : '' ?>>Normal (Maintain health)</option>
                <option value="Slender" <?= (isset($category) && $category === 'Slender') ? 'selected' : '' ?>>Slender (Add size)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
