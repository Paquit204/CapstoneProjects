<?php
// reviewThesis.php
$pageTitle = "Review Theses";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/reviewThesis.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <!-- Sidebar - fully included -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Theses Archive</h2>
      <p>Faculty Portal</p>
    </div>

    <nav class="sidebar-nav">
      <a href="facultyDashboard.php" class="nav-link">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="reviewThesis.php" class="nav-link active">
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

    <div class="search-filter-bar">
      <div class="search-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search by title, student, or ID...">
      </div>
      <select class="filter-select">
        <option>Filter by Status</option>
        <option>Pending</option>
        <option>In Progress</option>
        <option>Completed</option>
      </select>
    </div>

    <div class="thesis-list">
      <div class="thesis-card">
        <div class="thesis-header">
          <h3 class="thesis-title">Smart Waste Bin Monitoring with IoT & Mobile App</h3>
          <span class="status pending">Pending Review</span>
        </div>
        <div class="thesis-student">Mark Kiven Gie • 2021-001234</div>
        <div class="thesis-date">Submitted: Feb 5, 2026</div>
        <div class="thesis-actions">
          <a href="#" class="btn primary">View Manuscript</a>
          <a href="#" class="btn secondary">Add Feedback</a>
        </div>
      </div>

      <!-- Add more thesis cards here dynamically with PHP -->
    </div>
  </main>
</div>

<script>
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