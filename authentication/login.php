<?php
session_start();

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$username || !$password) {
        $message = "Username and password are required.";
        $message_type = "error";
    } else {
        // TODO: Replace with actual database authentication
        $valid_user = "admin";
        $valid_pass = "1234";

        if ($username === $valid_user && $password === $valid_pass) {
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
            $message = "✓ Login successful! Redirecting...";
            $message_type = "success";
            echo "<script>
                setTimeout(function(){
                    window.location.href='student-dashboard.php';
                }, 1500);
            </script>";
        } else {
            $message = "Invalid username or password.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Thesis Archiving System</title>
    <!-- Google Fonts + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="homepage.php" class="logo">
                <span class="material-symbols-outlined">book</span>
                ThesisVault
            </a>
            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="browse.php">Browse Thesis</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="login.php" class="active">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <span class="material-symbols-outlined login-icon">lock</span>
                <h2>Login to Your Account</h2>
                <p>Enter your credentials to access the system</p>
            </div>

            <?php if (!empty($message)) : ?>
                <div class="message <?php echo $message_type; ?>">
                    <span class="message-icon">
                        <?php echo ($message_type === 'success') ? '✓' : '✕'; ?>
                    </span>
                    <span class="message-text"><?php echo htmlspecialchars($message); ?></span>
                </div>
            <?php endif; ?>

            <form class="login-form" id="loginForm" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined input-icon">person</span>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined input-icon">lock</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span class="material-symbols-outlined password-toggle" id="login-toggle">visibility_off</span>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-login">Login</button>

                <div class="divider">
                    <span>OR</span>
                </div>

                <div class="role-selection">
                    <p class="role-title">Quick Login As:</p>
                    <div class="role-buttons">
                        <button type="button" class="role-btn" onclick="quickLogin('student')">
                            <span class="material-symbols-outlined role-icon">school</span>
                            <span>Student</span>
                        </button>
                        <button type="button" class="role-btn" onclick="quickLogin('faculty')">
                            <span class="material-symbols-outlined role-icon">person</span>
                            <span>Faculty</span>
                        </button>
                        <button type="button" class="role-btn" onclick="quickLogin('dean')">
                            <span class="material-symbols-outlined role-icon">account_balance</span>
                            <span>Dean</span>
                        </button>
                        <button type="button" class="role-btn" onclick="quickLogin('admin')">
                            <span class="material-symbols-outlined role-icon">settings</span>
                            <span>Admin</span>
                        </button>
                    </div>
                </div>

                <div class="register-link">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Thesis Archiving System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Quick login function (redirections fixed to .php)
        function quickLogin(role) {
            switch(role) {
                case 'student':
                    window.location.href = 'student-dashboard.php';
                    break;
                case 'faculty':
                    window.location.href = 'faculty-dashboard.php';
                    break;
                case 'dean':
                    window.location.href = 'dean-dashboard.php';
                    break;
                case 'admin':
                    window.location.href = 'admin-dashboard.php';
                    break;
            }
        }

        // Show/Hide Password - Login
        const loginToggle = document.getElementById('login-toggle');
        const loginPass = document.getElementById('password');

        if (loginToggle && loginPass) {
            loginToggle.addEventListener('click', () => {
                if (loginPass.type === 'password') {
                    loginPass.type = 'text';
                    loginToggle.textContent = 'visibility';
                } else {
                    loginPass.type = 'password';
                    loginToggle.textContent = 'visibility_off';
                }
            });
        }
    </script>
</body>
</html>
