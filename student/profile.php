<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Profile - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/profile.css">
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
        <a href="profile.php" class="nav-link active">
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
        <h1>My Profile</h1>
        <div class="user-info">
          <span class="user-name">Mark Kiven Gie</span>
          <div class="avatar">MK</div>
        </div>
      </header>

      <div class="profile-container">
        <div class="profile-card main">
          <div class="profile-top">
            <div class="big-avatar">MK</div>
            <div class="profile-info">
              <h2>Mark Kiven Gie</h2>
              <p class="student-id">2021-001234</p>
              <p>BS Computer Science • 4th Year</p>
            </div>
          </div>

          <div class="profile-details">
            <p><strong>Email:</strong> mark.gie@university.edu.ph</p>
            <p><strong>Contact:</strong> +63 917 123 4567</p>
            <p><strong>Adviser:</strong> Dr. Anna Reyes</p>
            <p><strong>Joined:</strong> August 2021</p>
          </div>

          <button class="edit-btn">Edit Profile</button>
        </div>

        <div class="profile-card stats">
          <h3>Thesis Progress</h3>
          <div class="progress-item">
            <span>Overall Progress</span>
            <div class="progress-bar"><div class="fill" style="width:82%"></div></div>
          </div>
          <div class="progress-item">
            <span>Proposal</span>
            <div class="progress-bar"><div class="fill" style="width:100%"></div></div>
          </div>
          <div class="progress-item">
            <span>Final Manuscript</span>
            <div class="progress-bar"><div class="fill" style="width:65%"></div></div>
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