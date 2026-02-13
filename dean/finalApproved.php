<?php
// finalApproved.php
$pageTitle = "Final Approval";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/finalApproved.css">
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
      <a href="deanDashboard.php" class="nav-link">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="finalApproved.php" class="nav-link active">
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
    </nav>
  </aside>

  <main class="main-content">
    <header class="topbar">
      <h1>Final Approval Queue</h1>
      <div class="user-info">
        <span class="user-name">Dean Maria Santos</span>
        <div class="avatar">MS</div>
      </div>
    </header>

    <div class="approval-list">
      <div class="approval-card">
        <div class="approval-header">
          <h3 class="thesis-title">Smart Waste Bin Monitoring with IoT & Mobile App</h3>
          <span class="status-badge">Awaiting Signature</span>
        </div>
        
        <div class="thesis-info">
          <div class="info-item">
            <label>Researcher</label>
            <span>Mark Kiven Gie</span>
          </div>
          <div class="info-item">
            <label>Adviser</label>
            <span>Dr. Anna Reyes</span>
          </div>
          <div class="info-item">
            <label>Date Submitted</label>
            <span>Feb 8, 2026</span>
          </div>
        </div>

        <div class="approval-actions">
          <button class="btn primary">Approve & Sign</button>
          <button class="btn secondary">Return to Adviser</button>
          <button class="btn outline">Read Manuscript</button>
        </div>
      </div>
      
      <div class="approval-card">
        <div class="approval-header">
          <h3 class="thesis-title">Blockchain-based Secure Grading System</h3>
          <span class="status-badge">Awaiting Signature</span>
        </div>
        
        <div class="thesis-info">
          <div class="info-item">
            <label>Researcher</label>
            <span>John Doe</span>
          </div>
          <div class="info-item">
            <label>Adviser</label>
            <span>Prof. Leo Vega</span>
          </div>
          <div class="info-item">
            <label>Date Submitted</label>
            <span>Feb 9, 2026</span>
          </div>
        </div>

        <div class="approval-actions">
          <button class="btn primary">Approve & Sign</button>
          <button class="btn secondary">Return to Adviser</button>
          <button class="btn outline">Read Manuscript</button>
        </div>
      </div>
    </div>
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