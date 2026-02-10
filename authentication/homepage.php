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
    <title>ThesisVault - Academic Archive</title>
    <!-- Google Fonts + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="css/homepage.css">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="homepage.php" class="logo">
                <span class="material-symbols-outlined">book</span>
                ThesisArchive
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

    <!-- Hero (image kept, login/register buttons removed) -->
    <section class="hero">
        <div class="hero-content">
            <h1>Thesis Archive</h1>
            <p>Discover, browse, and preserve academic research. Your gateway to scholarly knowledge.</p>
            <div class="hero-actions">
                <a href="browse.php" class="btn btn-primary">Browse Theses</a>
            </div>
        </div>
    </section>

    <!-- Stats with hover boxes -->
    <div class="stats">
        <div class="stat-box">
            <span class="material-symbols-outlined stat-icon">library_books</span>
            <div class="stat-number">1,240+</div>
            <div class="stat-label">Total Theses</div>
        </div>
        <div class="stat-box">
            <span class="material-symbols-outlined stat-icon">school</span>
            <div class="stat-number">8</div>
            <div class="stat-label">Departments</div>
        </div>
        <div class="stat-box">
            <span class="material-symbols-outlined stat-icon">calendar_today</span>
            <div class="stat-number">186</div>
            <div class="stat-label">This Year</div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <section class="recent-section">
        <div class="section-header">
            <h2 class="section-title">Recent Submissions</h2>
            <a href="browse.php" class="view-all">View all →</a>
        </div>
        <div class="recent-grid">
            <div class="thesis-card">
                <span class="approved-badge">APPROVED</span>
                <div class="thesis-year">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span>2025</span>
                </div>
                <h3>Machine Learning Approaches for Predictive Analytics in Agricultural Yield Forecasting</h3>
                <div class="thesis-author">Maria Santos · Computer Science</div>
                <p>This study explores machine learning algorithms including Random Forest, SVM, and Neural Networks to predict crop yields...</p>
                <div class="tags">
                    <span class="tag">machine learning</span>
                    <span class="tag">agriculture</span>
                    <span class="tag">predictive analytics</span>
                </div>
                <span class="arrow material-symbols-outlined">arrow_forward</span>
            </div>

            <!-- You can add more cards here -->
        </div>
    </section>

    <footer>
        <p>© 2026 ThesisVault - Academic Thesis Archive. All rights reserved.</p>
    </footer>

</body>
</html>
</DOCUMENT>