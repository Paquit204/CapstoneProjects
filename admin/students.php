<?php
require_once "config.php";
$course = trim($_GET['course'] ?? '');
$year_level = trim($_GET['year_level'] ?? '');

$where = "WHERE 1";
$params = [];
$types = "";

/* Optional filters */
if ($course !== "") {
  $where .= " AND course = ?";
  $params[] = $course;
  $types .= "s";
}

if ($year_level !== "") {
  $where .= " AND year_level = ?";
  $params[] = $year_level;
  $types .= "s";
}

/* Prepare query */
$sql = "SELECT student_id, student_number, course, year_level FROM student_table $where ORDER BY student_id DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
  $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

/* For dropdown values */
$courses_res = $conn->query("SELECT DISTINCT course FROM student_table WHERE course <> '' ORDER BY course ASC");
$years_res   = $conn->query("SELECT DISTINCT year_level FROM student_table WHERE year_level <> '' ORDER BY year_level ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student List</title>
  <link rel="stylesheet" href="css/students.css">
</head>
<body>

<div class="container">
  <div class="header">
    <h3>Student List</h3>
  </div>

  <!-- FILTER FORM (optional pero helpful) -->
  <form method="get" class="filters" style="margin-bottom: 15px;">
    <select name="course">
      <option value="">All Courses</option>
      <?php if ($courses_res): ?>
        <?php while ($c = $courses_res->fetch_assoc()): ?>
          <option value="<?= htmlspecialchars($c['course']) ?>"
            <?= ($course === $c['course']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['course']) ?>
          </option>
        <?php endwhile; ?>
      <?php endif; ?>
    </select>

    <select name="year_level">
      <option value="">All Year Levels</option>
      <?php if ($years_res): ?>
        <?php while ($y = $years_res->fetch_assoc()): ?>
          <option value="<?= htmlspecialchars($y['year_level']) ?>"
            <?= ($year_level === $y['year_level']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($y['year_level']) ?>
          </option>
        <?php endwhile; ?>
      <?php endif; ?>
    </select>

    <button type="submit" class="btn green btn-sm">Filter</button>
    <a href="students.php" class="btn gray btn-sm">Reset</a>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th class="col-num">#</th>
        <th>Student Number</th>
        <th>Course</th>
        <th>Year Level</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php $i=1; while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['student_number']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td><?= htmlspecialchars($row['year_level']) ?></td>
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
<?php
$stmt->close();
?>