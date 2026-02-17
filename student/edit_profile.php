<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];
$error = "";

$stmt = $conn->prepare("SELECT first_name, last_name, email, contact_number, address, birth_date, profile_picture FROM user_table WHERE user_id=?");
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

$profilePicUrl = $user["profile_picture"] 
    ? "../uploads/profile_pictures/" . $user["profile_picture"] 
    : "";

/* ====================== POST HANDLING ====================== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name  = trim($_POST["first_name"] ?? "");
    $last_name   = trim($_POST["last_name"] ?? "");
    $email       = trim($_POST["email"] ?? "");
    $contact_num = trim($_POST["contact_number"] ?? "");
    $birth_date  = trim($_POST["birth_date"] ?? "");
    $address     = trim($_POST["address"] ?? "");

    if ($first_name === "" || $last_name === "" || $email === "") {
        $error = "First name, last name, and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $newFileName = null;

        if (!empty($_FILES["profile_picture"]["name"])) {
            $file = $_FILES["profile_picture"];
            $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            if (!in_array($ext, ["jpg", "jpeg", "png"])) {
                $error = "Only JPG, JPEG or PNG files allowed.";
            } else {
                $uploadDir = __DIR__ . "/../uploads/profile_pictures/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $newFileName = "user_" . $user_id . "_" . time() . "." . $ext;
                $dest = $uploadDir . $newFileName;

                if (!move_uploaded_file($file["tmp_name"], $dest)) {
                    $error = "Failed to upload picture.";
                    $newFileName = null;
                }
            }
        }

        if (!$error) {
            if ($newFileName) {
                $sql = "UPDATE user_table SET first_name=?, last_name=?, email=?, contact_number=?, address=?, birth_date=?, profile_picture=?, updated_at=NOW() WHERE user_id=?";
                $upd = $conn->prepare($sql);
                $upd->bind_param("sssssssi", $first_name, $last_name, $email, $contact_num, $address, $birth_date, $newFileName, $user_id);
            } else {
                $sql = "UPDATE user_table SET first_name=?, last_name=?, email=?, contact_number=?, address=?, birth_date=?, updated_at=NOW() WHERE user_id=?";
                $upd = $conn->prepare($sql);
                $upd->bind_param("ssssssi", $first_name, $last_name, $email, $contact_num, $address, $birth_date, $user_id);
            }

            if ($upd->execute()) {
                $upd->close();
                header("Location: profile.php");
                exit;
            } else {
                $error = "Update failed: " . $upd->error;
                $upd->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Theses Archive</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/profile.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/edit_profile.css?v=<?= time() ?>">
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
            <a href="../authentication/logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <main class="main-content">

        <header class="topbar">
            <h1>Edit Profile</h1>
            <button class="mobile-menu-btn" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                <i class="fas fa-bars"></i>
            </button>
        </header>

        <div class="profile-container">

            <div class="profile-card main">

                <?php if ($error): ?>
                    <div class="alert" style="padding:1rem; background:#fee2e2; color:#991b1b; border-radius:10px; margin-bottom:1.5rem;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="edit-form">

                    <div class="form-group picture-group">
                        <label>Profile Picture</label>

                        <?php if ($profilePicUrl && file_exists(__DIR__ . "/../uploads/profile_pictures/" . $user["profile_picture"])): ?>
                            <div class="current-picture">
                                <img src="<?= htmlspecialchars($profilePicUrl) ?>?v=<?= time() ?>" alt="Current profile picture">
                            </div>
                        <?php else: ?>
                            <div class="current-picture placeholder">
                                No picture set
                            </div>
                        <?php endif; ?>

                        <div class="file-upload-wrapper">
                            <input type="file" name="profile_picture" accept="image/jpeg,image/png" id="profile_picture">
                            <label for="profile_picture" class="file-upload-btn">Choose File</label>
                            <span class="file-name">No file chosen</span>
                        </div>

                        <small>PNG, JPG, JPEG only (max 2MB recommended)</small>
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($first) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($last) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" id="contact_number" name="contact_number" value="<?= htmlspecialchars($user["contact_number"] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="birth_date">Birth Date</label>
                        <input type="date" id="birth_date" name="birth_date" value="<?= htmlspecialchars($user["birth_date"] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="4"><?= htmlspecialchars($user["address"] ?? '') ?></textarea>
                    </div>

                    <div class="form-actions">
                        <a href="profile.php" class="btn secondary">Cancel</a>
                        <button type="submit" class="btn primary">Save Changes</button>
                    </div>

                </form>

            </div>

            <div class="profile-card stats">
                <h3>Profile Tips</h3>
                <ul class="tips-list">
                    <li>Use a clear, recent photo</li>
                    <li>Keep email active for notifications</li>
                    <li>Contact number helps quick communication</li>
                    <li>Birth date is optional but useful for records</li>
                </ul>
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

document.getElementById('profile_picture')?.addEventListener('change', function(e) {
    const fileName = e.target.files.length > 0 ? e.target.files[0].name : 'No file chosen';
    document.querySelector('.file-name').textContent = fileName;
});
</script>

</body>
</html>