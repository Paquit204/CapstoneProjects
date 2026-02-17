<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifications - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/notifications.css">
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
        <a href="archived.php" class="nav-link">
          <i class="fas fa-archive"></i> Archived Theses
        </a>
        <a href="notifications.php" class="nav-link active">
          <i class="fas fa-bell"></i> Notifications
          <span class="badge" id="notification-badge">4</span>
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
        <h1>Notifications</h1>
        <div class="user-info">
          <span class="user-name">Mark Kiven Gie</span>
          <div class="avatar">MK</div>
        </div>
      </header>

      <div class="notifications-container">

        <div class="notification-item unread">
          <div class="notif-icon"><i class="fas fa-file-signature"></i></div>
          <div class="notif-content">
            <p><strong>Dr. Anna Reyes</strong> uploaded revision comments on Chapter 4 & 5</p>
            <span class="notif-time">Today • 7:42 AM</span>
          </div>
        </div>

        <div class="notification-item unread">
          <div class="notif-icon"><i class="fas fa-calendar-check"></i></div>
          <div class="notif-content">
            <p>Final defense schedule confirmed: <strong>March 15, 2026 – 10:00 AM</strong></p>
            <span class="notif-time">February 08, 2026</span>
          </div>
        </div>

        <div class="notification-item unread">
          <div class="notif-icon"><i class="fas fa-exclamation-triangle"></i></div>
          <div class="notif-content">
            <p>Reminder: Submit final manuscript before <strong>February 20, 2026</strong></p>
            <span class="notif-time">February 05, 2026</span>
          </div>
        </div>

        <div class="notification-item unread">
          <div class="notif-icon"><i class="fas fa-check-circle"></i></div>
          <div class="notif-content">
            <p>Proposal defense (October 2025) marked as <strong>Passed</strong></p>
            <span class="notif-time">November 12, 2025</span>
          </div>
        </div>

      </div>
    </main>
  </div>

  <script>
    // Dark mode toggle (unchanged)
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

    // =============================================
    // Mark notification as read + update badge count
    // =============================================
    document.addEventListener('DOMContentLoaded', () => {
      const badgeElement = document.getElementById('notification-badge');
      let unreadCount = badgeElement ? parseInt(badgeElement.textContent.trim(), 10) : 0;

      document.querySelectorAll('.notification-item').forEach(notification => {
        notification.addEventListener('click', function(e) {
          // Skip if clicked on something interactive inside (future-proof)
          if (e.target.closest('a, button, input, select')) {
            return;
          }

          // Only act if this notification is still unread
          if (this.classList.contains('unread')) {
            // Remove unread styling
            this.classList.remove('unread');

            // Decrease counter
            if (unreadCount > 0) {
              unreadCount--;
              if (unreadCount > 0) {
                badgeElement.textContent = unreadCount;
              } else {
                // Remove badge completely when no unread left
                badgeElement.remove();
              }
            }

            // Optional: small visual feedback
            this.style.backgroundColor = 'rgba(100, 116, 139, 0.08)';
            setTimeout(() => {
              this.style.backgroundColor = '';
            }, 400);
          }
        });
      });
    });
  </script>
</body>
</html>