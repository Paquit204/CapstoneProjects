<?php
session_start();

$message = "";
$full_name = $student_id = $email = $username = $user_role = $department = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name  = trim($_POST['fullname'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $username   = trim($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? '';
    $user_role  = $_POST['role'] ?? '';
    $department = trim($_POST['department'] ?? '');
    $student_id = trim($_POST['student_id'] ?? ''); // Optional
    $account_status = "Pending";

    if ($full_name && $email && $username && $password && $user_role && $department) {
        $conn = new mysqli("localhost", "root", "", "wbtas");
        if ($conn->connect_error) {
            $message = "Connection failed.";
        } else {
            // Check for existing email
            $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $message = "Email already exists.";
            } else {
                // Check for existing username
                $stmt->close();
                $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $message = "Username already exists.";
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->close();
                    $insert = $conn->prepare(
                        "INSERT INTO users (full_name, student_id, email, username, password, user_role, department, account_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                    );
                    $insert->bind_param("ssssssss", $full_name, $student_id, $email, $username, $hashed, $user_role, $department, $account_status);
                    if ($insert->execute()) {
                        $message = "Registration successful! Wait for admin approval.";
                        echo "<script>setTimeout(() => { window.location.href='login.php'; }, 2500);</script>";
                    } else {
                        $message = "⚠️ Registration failed.";
                    }
                    $insert->close();
                }
            }
            $conn->close();
        }
    } else {
        $message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Thesis Archiving System</title>
    <!-- Google Fonts + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
      
    <!-- Navigation -->
    

    <div class="container">
        <div class="register-container">
            <div class="register-header">
                <span class="material-symbols-outlined register-icon">person_add</span>
                <h2>Create Your Account</h2>
                <p>Join our academic community</p>
            </div>

            <?php if (!empty($message)) : ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form class="register-form" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullname">Full Name *</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">person</span>
                            <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">mail</span>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">account_circle</span>
                            <input type="text" id="username" name="username" placeholder="Choose a username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">badge</span>
                            <input type="text" id="student_id" name="student_id" placeholder="Enter student ID (optional)">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="role">Role *</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">group</span>
                            <select id="role" name="role" required>
                                <option value="">Select role</option>
                                <option value="student">Student</option>
                                <option value="faculty">Faculty</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="department">Department *</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">school</span>
                            <select id="department" name="department" required>
                                <option value="">Select department</option>
                                <option value="BSIT">BSIT</option>
                                <option value="EDUC">EDUC</option>
                                <option value="CRIME">CRIME</option>
                                <option value="BSN">BSN</option>
                                <option value="BSBA">BSBA</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">lock</span>
                            <input type="password" id="password" name="password" placeholder="Create a password" required>
                            <span class="material-symbols-outlined password-toggle" id="reg-toggle">visibility_off</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password *</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined input-icon">lock</span>
                            <input type="password" id="confirm_password" placeholder="Confirm password" required>
                            <span class="material-symbols-outlined password-toggle" id="confirm-toggle">visibility_off</span>
                        </div>
                    </div>
                </div>

                <div class="terms-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the <a href="#" class="link">Terms and Conditions</a> and <a href="#" class="link">Privacy Policy</a></span>
                    </label>
                </div>

                <button type="submit" class="btn-register">Create Account</button>

                <div class="login-link">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
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
        // Show/Hide Password - Password
        const regToggle = document.getElementById('reg-toggle');
        const regPass = document.getElementById('password');

        if (regToggle && regPass) {
            regToggle.addEventListener('click', () => {
                if (regPass.type === 'password') {
                    regPass.type = 'text';
                    regToggle.textContent = 'visibility';
                } else {
                    regPass.type = 'password';
                    regToggle.textContent = 'visibility_off';
                }
            });
        }

        // Show/Hide Password - Confirm
        const confirmToggle = document.getElementById('confirm-toggle');
        const confirmPass = document.getElementById('confirm_password');

        if (confirmToggle && confirmPass) {
            confirmToggle.addEventListener('click', () => {
                if (confirmPass.type === 'password') {
                    confirmPass.type = 'text';
                    confirmToggle.textContent = 'visibility';
                } else {
                    confirmPass.type = 'password';
                    confirmToggle.textContent = 'visibility_off';
                }
            });
        }
    </script>
</body>
</html>
