<?php
require_once "config.php";

if (isset($_GET['verify'])) {
  $id = (int)$_GET['verify'];
  $stmt = $conn->prepare("UPDATE students SET is_verified = 1 WHERE id = ? AND status = 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: students.php");
  exit;
}

if (isset($_GET['unverify'])) {
  $id = (int)$_GET['unverify'];
  $stmt = $conn->prepare("UPDATE students SET is_verified = 0 WHERE id = ? AND status = 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: students.php");
  exit;
}

$filter = $_GET['filter'] ?? 'all';
$where = "WHERE status = 1";

if ($filter === "verified") {
  $where .= " AND is_verified = 1";
} elseif ($filter === "not_verified") {
  $where .= " AND is_verified = 0";
}
$result = $conn->query("SELECT * FROM students $where ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student List</title>
  <link rel="stylesheet" href="/thesis_archiving/css/students.css?v=1">
</head>
<body>
<div class="container">

  <div class="header">
    <h3>Student List</h3>

    <div class="tabs">
      <a href="students.php?filter=all" class="tab tab-all <?= $filter==='all'?'active':'' ?>">All</a>
      <a href="students.php?filter=verified" class="tab tab-verified <?= $filter==='verified'?'active':'' ?>">Verified</a>
      <a href="students.php?filter=not_verified" class="tab tab-not <?= $filter==='not_verified'?'active':'' ?>">Not Verified</a>
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th class="col-num">#</th>
        <th>Full Name</th>
        <th class="col-status">Status</th>
        <th class="col-action">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php $i=1; while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td>
              <?php if ((int)$row['is_verified'] === 1): ?>
                <span class="badge ok">Verified</span>
              <?php else: ?>
                <span class="badge warn">Not Verified</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ((int)$row['is_verified'] === 1): ?>
                <a class="btn gray btn-sm"
                   href="students.php?unverify=<?= $row['id'] ?>"
                   onclick="return confirm('Unverify this student?')">Unverify</a>
              <?php else: ?>
                <a class="btn green btn-sm"
                   href="students.php?verify=<?= $row['id'] ?>"
                   onclick="return confirm('Verify this student?')">Verify</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="empty">No students found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  <a href="admindashboard.php" class="btn gray back-btn">Back to Dashboard</a>
    </div>
  </body>
</html>