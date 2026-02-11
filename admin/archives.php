<?php
require_once "config.php";

if (isset($_GET['verify'])) {
  $id = (int)$_GET['verify'];
  $stmt = $conn->prepare("UPDATE archives SET is_verified = 1 WHERE id = ? AND status = 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: archives.php");
  exit;
}

if (isset($_GET['unverify'])) {
  $id = (int)$_GET['unverify'];
  $stmt = $conn->prepare("UPDATE archives SET is_verified = 0 WHERE id = ? AND status = 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: archives.php");
  exit;
}

$filter = $_GET['filter'] ?? 'all';
$where = "WHERE status = 1";
if ($filter === "verified") $where .= " AND is_verified = 1";
elseif ($filter === "not_verified") $where .= " AND is_verified = 0";

$result = $conn->query("SELECT * FROM archives $where ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Archives </title>
  <link rel="stylesheet" href="/thesis_archiving/css/archives.css?v=1">
</head>

<body>
<div class="container">
  <div class="header">
    <h3>Archives List</h3>

    <div class="tabs">
      <a href="archives.php?filter=all" class="<?= $filter==='all'?'active':'' ?>">All</a>
      <a href="archives.php?filter=verified" class="<?= $filter==='verified'?'active':'' ?>">Verified</a>
      <a href="archives.php?filter=not_verified" class="<?= $filter==='not_verified'?'active':'' ?>">Not Verified</a>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Thesis Title</th>
        <th>Status</th>
        <th width="220">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php $i=1; while($r=$result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td>
              <?php if ((int)$r['is_verified'] === 1): ?>
                <span class="badge ok">Verified</span>
              <?php else: ?>
                <span class="badge warn">Not Verified</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ((int)$r['is_verified'] === 1): ?>
                <a class="btn gray" href="archives.php?unverify=<?= $r['id'] ?>"
                   onclick="return confirm('Unverify this archive?')">Unverify</a>
              <?php else: ?>
                <a class="btn green" href="archives.php?verify=<?= $r['id'] ?>"
                   onclick="return confirm('Verify this archive?')">Verify</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4" class="center">No archives found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <a href="admindashboard.php" class="btn gray back">Back to Dashboard</a>
</div>
</body>
</html>