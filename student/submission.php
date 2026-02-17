<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];

$stmt = $conn->prepare("SELECT first_name, last_name FROM user_table WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header("Location: ../authentication/login.php");
    exit;
}

$first = trim($user["first_name"] ?? "");
$last  = trim($user["last_name"] ?? "");

$displayName = trim($first . " " . $last);
$initials = $first && $last ? strtoupper(substr($first, 0, 1) . substr($last, 0, 1)) : "U";

// Handle form submission (demo/validation only)
$successMessage = "";
$formErrors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title    = trim($_POST["title"] ?? "");
    $abstract = trim($_POST["abstract"] ?? "");
    $adviser  = trim($_POST["adviser"] ?? "");

    if (empty($title))    $formErrors[] = "Thesis title is required.";
    if (empty($abstract)) $formErrors[] = "Abstract is required.";
    if (empty($adviser))  $formErrors[] = "Adviser name is required.";

    if (empty($_FILES["manuscript"]["name"])) {
        $formErrors[] = "Please upload the manuscript (PDF).";
    } else {
        $ext = strtolower(pathinfo($_FILES["manuscript"]["name"], PATHINFO_EXTENSION));
        if ($ext !== "pdf") {
            $formErrors[] = "Only PDF files are allowed.";
        }
    }

    if (empty($formErrors)) {
        $successMessage = "Thesis submitted successfully! It is now pending review.";
        // → In real app: save to DB + move file + redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Thesis - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/projects.css">     <!-- buttons, cards -->
  <link rel="stylesheet" href="css/submission.css?v=<?= time() ?>">  <!-- new external file -->
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
      <a href="submission.php" class="nav-link active">
        <i class="fas fa-upload"></i> Submit Thesis
      </a>
      <a href="archived.php" class="nav-link">
        <i class="fas fa-archive"></i> Archived Theses
      </a>
      <a href="notifications.php" class="nav-link">
        <i class="fas fa-bell"></i> Notifications
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
      <a href="../authentication/logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </aside>

  <main class="main-content">
    <header class="topbar">
      <h1>Thesis Submission</h1>
      <div class="user-info">
        <span class="user-name"><?= htmlspecialchars($displayName) ?></span>
        <div class="avatar"><?= htmlspecialchars($initials) ?></div>
      </div>
    </header>

    <div class="submission-container">

      <?php if ($successMessage): ?>
        <div class="success-message">
          <?= htmlspecialchars($successMessage) ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($formErrors)): ?>
        <ul class="error-list">
          <?php foreach ($formErrors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <div class="submission-card">
        <h2>New Thesis Submission</h2>

        <form method="POST" enctype="multipart/form-data">

          <div class="form-group">
            <label for="title">Thesis Title <span class="required">*</span></label>
            <input type="text" id="title" name="title" required
                   value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                   placeholder="e.g. Mobile-Based Student Attendance Monitoring with Face Recognition">
          </div>

          <div class="form-group">
            <label for="abstract">Abstract <span class="required">*</span></label>
            <textarea id="abstract" name="abstract" required
                      placeholder="Provide a brief summary of your research (200–400 words recommended)"><?= htmlspecialchars($_POST['abstract'] ?? '') ?></textarea>
          </div>

          <div class="form-group">
            <label for="adviser">Thesis Adviser <span class="required">*</span></label>
            <input type="text" id="adviser" name="adviser" required
                   value="<?= htmlspecialchars($_POST['adviser'] ?? '') ?>"
                   placeholder="e.g. Dr. Anna Reyes">
          </div>

          <div class="form-group">
            <label for="manuscript">Upload Manuscript (PDF only) <span class="required">*</span></label>
            <input type="file" id="manuscript" name="manuscript" accept=".pdf" required>
            <small class="help-text">Max file size: 20 MB recommended</small>
          </div>

          <div style="margin-top: 2.2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn primary">
              <i class="fas fa-paper-plane"></i> Submit for Review
            </button>
            <button type="reset" class="btn secondary">
              Clear Form
            </button>
          </div>

        </form>
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