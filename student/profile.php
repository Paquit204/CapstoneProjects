<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];

$stmt = $conn->prepare("
    SELECT first_name, last_name, email, contact_number, address, birth_date, profile_picture
    FROM user_table
    WHERE user_id = ?
");
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
$full  = trim($first . " " . $last);

$initials = "";
if ($first && $last) $initials = strtoupper(substr($first,0,1) . substr($last,0,1));
elseif ($first) $initials = strtoupper(substr($first,0,1));
else $initials = "U";

$profilePicUrl = $user["profile_picture"]
    ? "../uploads/profile_pictures/" . $user["profile_picture"]
    : "";

$email   = trim($user["email"] ?? "");
$contact = trim($user["contact_number"] ?? "");
$address = trim($user["address"] ?? "");
$birth   = trim($user["birth_date"] ?? "");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Theses Archive</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/profile.css?v=<?= time() ?>">
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

        <!-- ✅ MOBILE MENU BUTTON (moved here, optional) -->
        <button class="mobile-menu-btn"
                onclick="document.querySelector('.sidebar').classList.toggle('active')">
            <i class="fas fa-bars"></i>
        </button>

        <div class="profile-container">

            <div class="profile-card main">

                <!-- ✅ TITLE NOW INSIDE THE CARD (ABOVE IMAGE) -->
                <div class="card-title">
                    <h1>My Profile</h1>
                </div>

                <div class="profile-top">
                    <?php if ($profilePicUrl && file_exists(__DIR__ . "/../uploads/profile_pictures/" . $user["profile_picture"])): ?>
                        <div class="big-avatar-wrapper">
                            <img class="big-avatar-img" src="<?= htmlspecialchars($profilePicUrl) ?>?v=<?= time() ?>" alt="Profile Picture">
                        </div>
                    <?php else: ?>
                        <div class="big-avatar"><?= htmlspecialchars($initials) ?></div>
                    <?php endif; ?>

                    <div class="profile-info">
                        <h1><?= htmlspecialchars($full ?: "User") ?></h1>
                        <p class="student-id">User ID: <?= $user_id ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-row">
                        <strong>Email</strong>
                        <span><?= htmlspecialchars($email ?: "—") ?></span>
                    </div>
                    <div class="detail-row">
                        <strong>Contact</strong>
                        <span><?= htmlspecialchars($contact ?: "—") ?></span>
                    </div>
                    <div class="detail-row">
                        <strong>Address</strong>
                        <span><?= htmlspecialchars($address ?: "—") ?></span>
                    </div>
                    <div class="detail-row">
                        <strong>Birth Date</strong>
                        <span><?= htmlspecialchars($birth ?: "—") ?></span>
                    </div>
                </div>

                <a href="edit_profile.php" class="edit-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>

            </div>

            <div class="profile-card stats">
                <h3>Thesis Progress</h3>

                <div class="progress-item">
                    <span>Overall Progress</span>
                    <div class="progress-bar"><div class="fill" style="width:0%"></div></div>
                </div>

                <div class="progress-item">
                    <span>Proposal</span>
                    <div class="progress-bar"><div class="fill" style="width:0%"></div></div>
                </div>

                <div class="progress-item">
                    <span>Final Manuscript</span>
                    <div class="progress-bar"><div class="fill" style="width:0%"></div></div>
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