<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Archived Theses - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/archived.css">
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
        <a href="profile.php" class="nav-link">
          <i class="fas fa-user"></i> Profile
        </a>
        <a href="projects.php" class="nav-link">
          <i class="fas fa-folder-open"></i> My Projects
        </a>
        <a href="archived.php" class="nav-link active">
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
        <h1>Archived Theses</h1>
        <div class="user-info">
          <span class="user-name">Mark Kiven Gie</span>
          <div class="avatar">MK</div>
        </div>
      </header>

      <div class="archived-container">

        <div class="archive-card">
          <h2>Mobile-Based Student Attendance with Face Recognition</h2>
          <div class="archive-meta">
            <span class="grade">Grade: 1.50</span>
            <span class="date">March 31, 2025</span>
            <span class="pages">68 pages</span>
          </div>
          <div class="archive-actions">
            <a href="#" class="btn primary">View PDF</a>
            <a href="#" class="btn">Download Certificate</a>
            <a href="#" class="btn secondary">View Abstract</a>
          </div>
        </div>

        <div class="archive-card">
          <h2>Web Portal for Barangay Health Record Management</h2>
          <div class="archive-meta">
            <span class="grade">Grade: 1.75</span>
            <span class="date">October 15, 2024</span>
            <span class="pages">54 pages</span>
          </div>
          <div class="archive-actions">
            <a href="#" class="btn primary">View PDF</a>
            <a href="#" class="btn secondary">View Abstract</a>
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