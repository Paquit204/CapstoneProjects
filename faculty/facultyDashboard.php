<?php
 
$pageTitle = "Faculty Dashboard";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/facultyDashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Theses Archive</h2>
      <p>Faculty Portal</p>
    </div>

    <nav class="sidebar-nav">
      <a href="facultyDashboard.php" class="nav-link active">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="reviewThesis.php" class="nav-link">
        <i class="fas fa-book-reader"></i> Review Theses
      </a>
      <a href="facultyFeedback.php" class="nav-link">
        <i class="fas fa-comment-dots"></i> My Feedback
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-calendar-check"></i> Schedule
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-chart-line"></i> Statistics
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
      <a href="../logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </aside>

  <!-- Main content -->
  <main class="main-content">
    <header class="topbar">
      <h1><?= htmlspecialchars($pageTitle) ?></h1>
      <div class="user-info">
        <span class="user-name">Dr. Anna Reyes</span>
        <div class="avatar">AR</div>
      </div>
    </header>

    <div class="welcome-banner">
      <h2>Welcome back, Dr. Reyes</h2>
      <p>Here's an overview of your advising and review activities.</p>
    </div>

    <div class="stats-overview">
      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
        <div class="stat-value">12</div>
        <div class="stat-label">Active Advisees</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-file-signature"></i></div>
        <div class="stat-value">7</div>
        <div class="stat-label">Theses for Review</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value">19</div>
        <div class="stat-label">Completed Reviews</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value">3</div>
        <div class="stat-label">Pending Feedback</div>
      </div>
    </div>

    <div class="recent-activity">
      <h3>Recent Activity</h3>
      <div class="activity-list">
        <div class="activity-item">
          <i class="fas fa-file-upload activity-icon"></i>
          <div class="activity-content">
            <p><strong>Mark Kiven Gie</strong> submitted Chapter 4 revision</p>
            <span class="activity-time">Today • 9:42 AM</span>
          </div>
        </div>
        <!-- more items -->
      </div>
    </div>
  </main>
</div>

<script>
// Dark mode toggle
const toggle = document.getElementById('darkmode');
if (toggle) {
  toggle.addEventListener('change', () => {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', toggle.checked);
  });
  if (localStorage.getItem('darkMode') === 'true') {
    toggle.checked = true;
    document.body.classList.add('dark-mode');
  }
}
</script>
</body>
</html>