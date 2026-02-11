<?php
require_once "config.php";
if (isset($_POST['add'])) {
  $name = trim($_POST['curriculum_name']);
  if ($name !== '') {
    $stmt = $conn->prepare("INSERT INTO curriculum (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    header("Location: curriculum.php");
    exit;
  }
}
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $stmt = $conn->prepare("DELETE FROM curriculum WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: curriculum.php");
  exit;
}

$result = $conn->query("SELECT * FROM curriculum ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Curriculum</title>
  <link rel="stylesheet" href="/thesis_archiving/css/curriculum.css?v=1">
</head>
<body>
<div class="container">
  <h2 class="page-title">Curriculum</h2>
  <form method="post" class="form-row">
    <input
      type="text"
      name="curriculum_name"
      class="input"
      placeholder="Curriculum name"
      required
    >
    <button type="submit" name="add" class="btn btn-primary">Add</button>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th class="col-num">#</th>
        <th>Curriculum Name</th>
        <th class="col-action">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php $i=1; while($row=$result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>
              <a
                href="curriculum.php?delete=<?= $row['id'] ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Delete this curriculum?')"
              >
                Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="3" class="empty">No curriculum found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <a href="admindashboard.php" class="btn btn-gray back-btn">
    Back to Dashboard
  </a>

</div>

</body>
</html>