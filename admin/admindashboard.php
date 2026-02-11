<?php
require_once "config.php";
function get_count($conn, $sql) {
  $res = $conn->query($sql);
  if (!$res) return 0;
  $row = $res->fetch_assoc();
  return (int)($row['c'] ?? 0);
}
$departmentCount = get_count($conn, "SELECT COUNT(*) AS c FROM department");
$curriculumCount = get_count($conn, "SELECT COUNT(*) AS c FROM curriculum");
$verifiedStudents = get_count($conn, "SELECT COUNT(*) AS c FROM students WHERE status=1 AND is_verified=1");
$notVerifiedStudents = get_count($conn, "SELECT COUNT(*) AS c FROM students WHERE status=1 AND is_verified=0");
$verifiedArchives = get_count($conn, "SELECT COUNT(*) AS c FROM archives WHERE status=1 AND is_verified=1");
$notVerifiedArchives = get_count($conn, "SELECT COUNT(*) AS c FROM archives WHERE status=1 AND is_verified=0");

$displayName = "Admin";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/thesis_archiving/css/admin.css?v=1">
</head>
<body>

<header class="topbar">
  <button class="icon-btn" type="button" title="Menu">☰</button>
  <div class="topbar-title">Web-Based Thesis Archiving System</div>
  <div class="topbar-right">
    <div class="avatar">A</div>
    <div class="topbar-user"><?= htmlspecialchars($displayName) ?></div>
  </div>
</header>
<div class="layout">
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-logo">WB</div>
      <div class="brand-text">
        <div class="brand-name">Web-Based Thesis</div>
        <div class="brand-name">Archiving System</div>
      </div>
    </div>

    <nav class="nav">
      <a class="nav-link active" href="admindashboard.php">Dashboard</a>
      <a class="nav-link" href="archives.php">Archives</a>
      <a class="nav-link" href="students.php">Student</a>
      <div class="nav-section">MAINTENANCE</div>
      <a class="nav-link" href="departments.php">Department</a>
      <a class="nav-link" href="curriculum.php">Curriculum</a>
      <a class="nav-link" href="users.php">User</a>
      <a class="nav-link" href="settings.php">Settings</a>
    </nav>
  </aside>

  <main class="content">
    <h2 class="welcome">Welcome to Web-Based Thesis Archiving System</h2>
    <div class="divider"></div>

    <div class="cards">

      <div class="card">
        <div class="card-body">
          <div class="card-title">Department</div>
          <div class="card-value"><?= $departmentCount ?></div>
        </div>
      </div>

      <div class="card">

        <div class="card-body">
          <div class="card-title">Curriculum</div>
          <div class="card-value"><?= $curriculumCount ?></div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="card-title">Verified Students</div>
          <div class="card-value"><?= $verifiedStudents ?></div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="card-title">Not Verified Students</div>
          <div class="card-value"><?= $notVerifiedStudents ?></div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="card-title">Verified Archives</div>
          <div class="card-value"><?= $verifiedArchives ?></div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="card-title">Not Verified Archives</div>
          <div class="card-value"><?= $notVerifiedArchives ?></div>
        </div>
      </div>
    </div>
  </main>

</div>
</body>
</html>