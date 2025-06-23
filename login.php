<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT user_id, name, password, category FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Login success - set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_category'] = $user['category'];

            // Redirect based on category
            if ($user['category'] === 'Admin') {
                header('Location: admin/admin_dashboard.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not found.";
    }
}

include('includes/header.php');
?>

<div class="container mt-5">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email address:</label>
            <input type="email" name="email" id="email" required class="form-control" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" required class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
