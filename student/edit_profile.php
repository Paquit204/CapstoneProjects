<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

$user_id = (int)$_SESSION['user_id'];
$error = "";
$success = "";

/* SAVE UPDATE */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $full_name = trim($_POST['full_name'] ?? "");
  $email     = trim($_POST['email'] ?? "");
  $contact   = trim($_POST['contact'] ?? "");

  if ($full_name === "" || $email === "" || $contact === "") {
    $error = "Please fill out all fields.";
  } else {
    $stmt = $conn->prepare("UPDATE user SET full_name=?, email=?, contact=? WHERE user_id=?");
    if (!$stmt) {
      $error = "Prepare error: " . $conn->error;
    } else {
      $stmt->bind_param("sssi", $full_name, $email, $contact, $user_id);
      if ($stmt->execute()) {
        // redirect back to profile after update
        header("Location: profile.php?updated=1");
        exit;
      } else {
        $error = "Update failed: " . $stmt->error;
      }
    }
  }
}

/* FETCH CURRENT USER */
$stmt = $conn->prepare("SELECT full_name, email, contact FROM user WHERE user_id=? LIMIT 1");
if (!$stmt) die("Prepare error: " . $conn->error);

$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) die("User not found.");

$initials = "U";
if (!empty($user['full_name'])) {
  $parts = preg_split('/\s+/', trim($user['full_name']));
  $initials = strtoupper(substr($parts[0],0,1) . (isset($parts[1]) ? substr($parts[1],0,1) : ""));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Profile - Theses Archiving System</title>

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
        <a href="logout.php" class="logout-btn">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <h1>Edit Profile</h1>
        <div class="user-info">
          <span class="user-name"><?= htmlspecialchars($user['full_name']) ?></span>
          <div class="avatar"><?= htmlspecialchars($initials) ?></div>
        </div>
      </header>

      <div class="notifications-container">

        <?php if($error): ?>
          <div class="notification-item unread" style="border-left:5px solid #e74c3c;">
            <div class="notif-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="notif-content">
              <p><strong>Error:</strong> <?= htmlspecialchars($error) ?></p>
              <span class="notif-time">Please try again</span>
            </div>
          </div>
        <?php endif; ?>

        <div class="notification-item unread">
          <div class="notif-icon"><i class="fas fa-user-edit"></i></div>
          <div class="notif-content">
            <p><strong>Update your account details</strong></p>
            <span class="notif-time">Make sure your info is correct.</span>

            <!-- FORM -->
            <form method="POST" style="margin-top:14px; display:grid; gap:12px;">

              <div style="display:grid; gap:6px;">
                <label style="font-weight:600;">Full Name</label>
                <input
                  type="text"
                  name="full_name"
                  value="<?= htmlspecialchars($user['full_name']) ?>"
                  required
                  style="padding:10px;border:1px solid #ddd;border-radius:10px;width:100%;"
                />
              </div>

              <div style="display:grid; gap:6px;">
                <label style="font-weight:600;">Email</label>
                <input
                  type="email"
                  name="email"
                  value="<?= htmlspecialchars($user['email']) ?>"
                  required
                  style="padding:10px;border:1px solid #ddd;border-radius:10px;width:100%;"
                />
              </div>

              <div style="display:grid; gap:6px;">
                <label style="font-weight:600;">Contact</label>
                <input
                  type="text"
                  name="contact"
                  value="<?= htmlspecialchars($user['contact']) ?>"
                  required
                  style="padding:10px;border:1px solid #ddd;border-radius:10px;width:100%;"
                />
              </div>

              <div style="display:flex; gap:10px; margin-top:6px;">
                <button type="submit"
                  style="padding:10px 14px;border:none;border-radius:10px;background:#2d6cdf;color:#fff;cursor:pointer;">
                  <i class="fas fa-save"></i> Save Changes
                </button>

                <a href="profile.php"
                  style="padding:10px 14px;border-radius:10px;border:1px solid #ddd;text-decoration:none;color:#222;">
                  Cancel
                </a>
              </div>

            </form>
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