<?php
$pageTitle = "Dean Dashboard";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/deanDashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Theses Archive</h2>
      <p>Dean Portal</p>
    </div>
    <nav class="sidebar-nav">
      <a href="deanDashboard.php" class="nav-link active">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="finalApproved.php" class="nav-link">
        <i class="fas fa-check-double"></i> Final Approval
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-chart-bar"></i> Reports
      </a>
      <div class="sidebar-divider">Settings</div>
      <div class="dark-mode-toggle">
        <span>Dark Mode</span>
        <input type="checkbox" id="darkmode" hidden />
        <label for="darkmode" class="toggle-label">
          <i class="fas fa-sun"></i>
          <i class="fas fa-moon"></i>
          <div class="slider"></div>
        </label>
      </div>
      <a href="logout.php" class="nav-link logout">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="topbar">
      <h1>Dashboard Overview</h1>
      <div class="user-info">
        <div class="user-details">
          <span class="user-name">Dean Maria Santos</span>
          <span class="user-role">Administrator</span>
        </div>
        <div class="avatar">MS</div>
      </div>
    </header>

    <div class="welcome-card">
      <h2>Welcome Back, Dean Santos!</h2>
      <p>Your portal is ready. You have 3 pending theses awaiting your final signature.</p>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <i class="fas fa-clock stat-icon"></i>
        <div class="stat-value">3</div>
        <div class="stat-label">Pending Final Approval</div>
      </div>
      <div class="stat-card">
        <i class="fas fa-file-signature stat-icon"></i>
        <div class="stat-value">42</div>
        <div class="stat-label">Approved This Year</div>
      </div>
      <div class="stat-card">
        <i class="fas fa-archive stat-icon"></i>
        <div class="stat-value">1,856</div>
        <div class="stat-label">Total Archived</div>
      </div>
    </div>

    <section class="recent-pending-section">
      <h3>Priority Action Items</h3>
      <div class="pending-card">
        <div class="pending-header">
          <h4 class="pending-title">Smart Waste Bin Monitoring System</h4>
        </div>
        <div class="pending-details">
          <p><strong>Student:</strong> Mark Kiven Gie</p>
          <p><strong>Status:</strong> Ready for Final Sign-off</p>
        </div>
        <a href="finalApproved.php" class="btn primary" style="display:inline-block; margin-top:1rem; text-decoration:none;">Review & Approve</a>
      </div>
    </section>
  </main>
</div>

<script>
  const toggle = document.getElementById('darkmode');
  if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
    toggle.checked = true;
  }
  toggle.addEventListener('change', () => {
    if (toggle.checked) {
      document.body.classList.add('dark-mode');
      localStorage.setItem('darkMode', 'enabled');
    } else {
      document.body.classList.remove('dark-mode');
      localStorage.setItem('darkMode', 'disabled');
    }
  });
</script>
</body>
</html>