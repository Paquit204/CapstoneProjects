<DOCUMENT filename="homepage.php">
<?php
session_start();
$is_logged_in = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Web-Based Thesis Archiving System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="css/homepage.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="homepage.php" class="logo">
                <span class="material-symbols-outlined">book</span>
                Thesis Archiving
            </a>
            <ul class="nav-links">
                <li><a href="homepage.php" class="active">Home</a></li>
                <li><a href="browse.php">Browse</a></li>
                <li><a href="#">Upload</a></li>
                <?php if ($is_logged_in): ?>
                    <li><a href="student-dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <section class="hero">
        <div class="hero-content">
            <h1>Web-Based Thesis Archiving System</h1>
            <p>Discover, browse, and preserve academic research. Your gateway to scholarly knowledge.</p>
            <div class="hero-actions">
                <a href="browse.php" class="btn btn-primary">Browse Theses</a>
            </div>
        </div>
    </section>
</body>
</html>
</DOCUMENT>