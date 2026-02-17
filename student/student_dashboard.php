<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];

$stmt = $conn->prepare("SELECT first_name, last_name FROM user_table WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header("Location: ../authentication/login.php");
    exit;
}

$first = trim($user["first_name"] ?? "");
$last  = trim($user["last_name"] ?? "");

$displayName = trim($first . " " . $last);
$initials = "";

if ($first && $last) {
    $initials = strtoupper($first[0] . $last[0]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard - Theses Archiving System</title>

  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/student_dashboard.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Theses Archive</h2>
      <p>Student Portal</p>
    </div>

    <nav class="sidebar-nav">
      <a href="student_dashboard.php" class="nav-link active">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="profile.php" class="nav-link">
        <i class="fas fa-user"></i> Profile
      </a>
      <a href="projects.php" class="nav-link">
        <i class="fas fa-folder-open"></i> My Projects
      </a>
      <a href="submission.php" class="nav-link">
        <i class="fas fa-upload"></i> Submit Thesis
      </a>
      <a href="archived.php" class="nav-link">
        <i class="fas fa-archive"></i> Archived Theses
      </a>
      <a href="notifications.php" class="nav-link">
        <i class="fas fa-bell"></i> Notifications
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="theme-toggle">
        <input type="checkbox" id="darkmode" />
        <label for="darkmode" class="toggle-label">
          <i class="fas fa-sun"></i>
          <i class="fas fa-moon"></i>
          <span class="slider"></span>
        </label>
      </div>
      <a href="../authentication/logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </aside>

  <main class="main-content">

    <header class="topbar">
      <h1>Student Dashboard</h1>

      <div class="user-info">
        <span class="user-name">
          <?= htmlspecialchars($displayName) ?>
        </span>

        <div class="avatar">
          <?= htmlspecialchars($initials) ?>
        </div>
      </div>
    </header>

    <div class="welcome-section">
      <h2>Welcome, <?= htmlspecialchars($first) ?>!</h2>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-value">1</div>
        <div class="stat-label">Active Thesis</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-archive"></i></div>
        <div class="stat-value">2</div>
        <div class="stat-label">Archived Theses</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-tasks"></i></div>
        <div class="stat-value">82%</div>
        <div class="stat-label">Overall Progress</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-bell"></i></div>
        <div class="stat-value">4</div>
        <div class="stat-label">New Notifications</div>
      </div>
    </div>

    <div class="quick-links">
      <h3>Quick Actions</h3>
      <div class="links-grid">
        <a href="projects.php" class="quick-btn">View My Projects</a>
        <a href="profile.php" class="quick-btn">Update Profile</a>
        <a href="notifications.php" class="quick-btn">Check Notifications</a>
        <a href="archived.php" class="quick-btn">View Archived Works</a>
      </div>
    </div>

  </main>
</div>

<script>
  // Dark mode toggle & persistence
  const toggle = document.getElementById('darkmode');
  if (toggle) {
    toggle.addEventListener('change', () => {
      document.body.classList.toggle('dark-mode');
      localStorage.setItem('darkMode', toggle.checked);
    });

    // Apply saved preference on load
    const savedMode = localStorage.getItem('darkMode');
    if (savedMode === 'true') {
      toggle.checked = true;
      document.body.classList.add('dark-mode');
    }
  }
</script>

</body>
</html>