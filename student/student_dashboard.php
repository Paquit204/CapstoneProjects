<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Dashboard - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/student_dashboard.css">
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
        <a href="archived.php" class="nav-link">
          <i class="fas fa-archive"></i> Archived Theses
        </a>
        <a href="notifications.php" class="nav-link">
          <i class="fas fa-bell"></i> Notifications
          <span class="badge">4</span>
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
        <a href="#" class="logout-btn">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <h1>Student Dashboard</h1>
        <div class="user-info">
          <span class="user-name">Mark Kiven Gie</span>
          <div class="avatar">MK</div>
        </div>
      </header>

      <div class="welcome-section">
        <h2>Welcome back, Mark!</h2>
        <p>Here’s a quick overview of your thesis progress and updates.</p>
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