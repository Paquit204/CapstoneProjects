<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Projects - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/projects.css">
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
        <a href="student_dashboard.php" class="nav-link">
          <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="profile.php " class="nav-link">
          <i class="fas fa-user"></i> Profile
        </a>
        <a href="projects.php" class="nav-link active">
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
        <h1>My Current Projects</h1>
        <div class="user-info">
          <span class="user-name">Mark Kiven Gie</span>
          <div class="avatar">MK</div>
        </div>
      </header>

      <div class="projects-container">

        <div class="project-card">
          <div class="project-header">
            <h2>Smart Waste Bin Monitoring with IoT & Mobile App</h2>
            <span class="status status-active">Active – Revision Stage</span>
          </div>

          <div class="project-progress">
            <div class="progress-label">Overall Progress</div>
            <div class="progress-bar">
              <div class="progress-fill" style="width: 82%;"></div>
            </div>
            <div class="progress-percentage">82%</div>
          </div>

          <div class="project-meta">
            <div><strong>Adviser:</strong> Dr. Anna Reyes</div>
            <div><strong>Started:</strong> August 2025</div>
            <div><strong>Last update:</strong> February 07, 2026</div>
          </div>

          <div class="project-actions">
            <button class="btn primary">Open Manuscript</button>
            <button class="btn">View Comments (7)</button>
            <button class="btn secondary">Upload New Version</button>
          </div>
        </div>

        <div class="project-card">
          <div class="project-header">
            <h2>Blockchain-based Academic Credential Verification</h2>
            <span class="status status-pending">Pending – Proposal Review</span>
          </div>

          <div class="project-progress">
            <div class="progress-label">Overall Progress</div>
            <div class="progress-bar">
              <div class="progress-fill" style="width: 28%;"></div>
            </div>
            <div class="progress-percentage">28%</div>
          </div>

          <div class="project-meta">
            <div><strong>Adviser:</strong> Prof. James Lim</div>
            <div><strong>Started:</strong> January 10, 2026</div>
            <div><strong>Last update:</strong> February 01, 2026</div>
          </div>

          <div class="project-actions">
            <button class="btn primary">Continue Work</button>
            <button class="btn">Submit for Review</button>
          </div>
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