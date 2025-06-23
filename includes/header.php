<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Planner</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/diet_planner/assets/css/styles.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/diet_planner/index.php">Diet Planner</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="nav-item"><a class="nav-link" href="/diet_planner/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/diet_planner/logout.php">Logout</a></li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="/diet_planner/register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="/diet_planner/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

