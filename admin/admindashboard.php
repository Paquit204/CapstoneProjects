<?php
require_once "config.php";

function get_count(mysqli $conn, string $sql): int {
  $res = $conn->query($sql);
  if (!$res) return 0;
  $row = $res->fetch_assoc();
  return (int)($row['c'] ?? 0);
}

function column_exists(mysqli $conn, string $table, string $column): bool {
  $tableEsc = $conn->real_escape_string($table);
  $colEsc   = $conn->real_escape_string($column);
  $sql = "SELECT 1
          FROM INFORMATION_SCHEMA.COLUMNS
          WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = '{$tableEsc}'
            AND COLUMN_NAME = '{$colEsc}'
          LIMIT 1";
  $res = $conn->query($sql);
  return $res && $res->num_rows > 0;
}

function archives_where(mysqli $conn): string {
  $clauses = [];
  if (column_exists($conn, "archives", "status")) {
    $clauses[] = "status = 1";
  }


  return $clauses ? (" WHERE " . implode(" AND ", $clauses)) : "";
}

$departmentCount = get_count($conn, "SELECT COUNT(*) AS c FROM department");
$curriculumCount = get_count($conn, "SELECT COUNT(*) AS c FROM curriculum");

$totalStudents = get_count($conn, "SELECT COUNT(*) AS c FROM student_table");

$archivesBaseWhere = archives_where($conn);
$totalArchives = get_count($conn, "SELECT COUNT(*) AS c FROM archives{$archivesBaseWhere}");

$verifiedArchives = 0;
$notVerifiedArchives = 0;
if (column_exists($conn, "archives", "is_verified")) {
  $verifiedArchives = get_count(
    $conn,
    "SELECT COUNT(*) AS c FROM archives{$archivesBaseWhere}" . ($archivesBaseWhere ? " AND " : " WHERE ") . "is_verified = 1"
  );
  $notVerifiedArchives = get_count(
    $conn,
    "SELECT COUNT(*) AS c FROM archives{$archivesBaseWhere}" . ($archivesBaseWhere ? " AND " : " WHERE ") . "is_verified = 0"
  );
}

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
      <a class="nav-link" href="departments.php">Department</a>
      <a class="nav-link" href="curriculum.php">Curriculum</a>
      <a class="nav-link" href="users.php">User</a>
      <a class="nav-link" href="settings.php">Settings</a>
      <a class="nav-link" href="logout.php">Logout</a>
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
          <div class="card-title">Total Students</div>
          <div class="card-value"><?= $totalStudents ?></div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="card-title">Total Archives</div>
          <div class="card-value"><?= $totalArchives ?></div>
        </div>
      </div>

      <?php if (column_exists($conn, "archives", "is_verified")): ?>
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
      <?php endif; ?>

    </div>
  </main>
</div>
</body>
</html>