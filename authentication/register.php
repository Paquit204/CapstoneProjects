<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

$message = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $role_id     = (int)($_POST["role_id"] ?? 2);

    $first_name  = trim($_POST["first_name"] ?? "");
    $last_name   = trim($_POST["last_name"] ?? "");
    $email       = trim($_POST["email"] ?? "");
    $username    = trim($_POST["username"] ?? "");
    $password    = $_POST["password"] ?? "";
    $cpassword   = $_POST["cpassword"] ?? "";
    $department  = trim($_POST["department"] ?? "");
    $birth_date  = trim($_POST["birth_date"] ?? "");
    $address     = trim($_POST["address"] ?? "");

    $contact_number = trim($_POST["contact_number"] ?? "");

    $status      = "1";

    if ($first_name === "" || $last_name === "" || $email === "" || $username === "" || $password === "" || $cpassword === "" || $contact_number === "") {
        $message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif ($password !== $cpassword) {
        $message = "Password and Confirm Password do not match.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } elseif (!ctype_digit($contact_number) || strlen($contact_number) < 10) {
        $message = "Contact number must be numeric and valid.";
    } elseif (!in_array($role_id, [1,2,3,4], true)) {
        $message = "Invalid role selected.";
    } else {

        $check = $conn->prepare("SELECT user_id FROM user_table WHERE username = ? OR email = ? LIMIT 1");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $exists = $check->get_result();

        if ($exists && $exists->num_rows > 0) {
            $message = "Username or Email already exists.";
        } else {

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $profile_picture = "default.png";

            $stmt = $conn->prepare("
                INSERT INTO user_table
                (role_id, first_name, last_name, email, username, password, department, birth_date, address, contact_number, status, profile_picture)
                VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "isssssssssss",
                $role_id,
                $first_name,
                $last_name,
                $email,
                $username,
                $hashed,
                $department,
                $birth_date,
                $address,
                $contact_number,
                $status,
                $profile_picture
            );

            if ($stmt->execute()) {
                $success = "Registered successfully! You can now login.";
            } else {
                $message = "Register failed: " . $conn->error;
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Thesis Archiving</title>

  <link rel="stylesheet" href="css/register.css?v=1">
</head>
<body>

<div class="auth-wrap">
  <div class="card">
    <div class="top-icon" aria-hidden="true">
      <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
        <path d="M15 19a6 6 0 0 0-12 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2"/>
        <path d="M19 8v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M22 11h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </div>

    <h1>Create Account</h1>
    <p class="sub"></p>

    <?php if ($message): ?>
      <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" class="form" autocomplete="off">

      <label class="lbl">Role *</label>

      <div class="select-wrap">
        <select class="select" name="role_id" required>
          <option value="" disabled selected>Select role</option>
          <option value="1">Admin</option>
          <option value="2">Student</option>
          <option value="3">Faculty</option>
          <option value="4">Dean</option>
        </select>
      </div>

      <div class="grid">
        <div>
          <label class="lbl">First Name *</label>
          <input class="input" type="text" name="first_name" placeholder="Enter first name" required>
        </div>
        <div>
          <label class="lbl">Last Name *</label>
          <input class="input" type="text" name="last_name" placeholder="Enter last name" required>
        </div>
      </div>

      <label class="lbl">Email *</label>
      <input class="input" type="email" name="email" placeholder="Enter email" required>

      <label class="lbl">Username *</label>
      <input class="input" type="text" name="username" placeholder="Enter username" required>

      <div class="grid">
        <div>
          <label class="lbl">Password *</label>
          <input class="input" type="password" name="password" placeholder="Enter password" required>
        </div>
        <div>
          <label class="lbl">Confirm Password *</label>
          <input class="input" type="password" name="cpassword" placeholder="Confirm password" required>
        </div>
      </div>

      <label class="lbl">Department</label>
      <input class="input" type="text" name="department" placeholder="">

      <div class="grid">
        <div>
          <label class="lbl">Birth Date</label>
          <input class="input" type="date" name="birth_date">
        </div>
        <div>
          <label class="lbl">Contact Number *</label>
          <input class="input" type="text" name="contact_number" placeholder="09xxxxxxxxx" required>
        </div>
      </div>

      <label class="lbl">Address</label>
      <textarea class="textarea" name="address" placeholder="Enter address"></textarea>

      <button class="btn" type="submit">Register</button>

      <div class="or">OR</div>
      <div class="foot">
        Already have an account? <a class="link" href="login.php">Login</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>