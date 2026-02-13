<?php
session_start();

$message = "";
$full_name = $email = $username = $department = "";

function split_name($fullName) {
    $fullName = trim(preg_replace('/\s+/', ' ', $fullName));
    if ($fullName === '') return ['', ''];

    $parts = explode(' ', $fullName);
    if (count($parts) === 1) return [$parts[0], ''];

    $last = array_pop($parts);
    $first = implode(' ', $parts);
    return [$first, $last];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name        = trim($_POST['fullname'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $username         = trim($_POST['username'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role             = $_POST['role'] ?? '';
    $department       = trim($_POST['department'] ?? '');

    // Optional fields (if you want to add later)
    $birth_date  = trim($_POST['birth_date'] ?? '');   // optional
    $address     = trim($_POST['address'] ?? '');      // optional
    $contact_num = trim($_POST['contact_num'] ?? '');  // optional

    // Role -> role_id mapping (adjust if you have your own role table)
    $role_map = [
        'admin'   => 1,
        'faculty' => 2,
        'student' => 3,
    ];
    $role_id = $role_map[$role] ?? 0;

    // Basic validations
    if (!$full_name || !$email || !$username || !$password || !$role_id || !$department) {
        $message = "All required fields must be filled.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $message = "Password and Confirm Password do not match.";
    } else {

        // Split full name into first_name and last_name
        [$first_name, $last_name] = split_name($full_name);

        // Connect to DB (match your DB name)
        $conn = new mysqli("localhost", "root", "", "thesiss_archiving");
        if ($conn->connect_error) {
            $message = "Connection failed: " . $conn->connect_error;
        } else {
            $conn->set_charset("utf8mb4");

            // Check if email exists
            $stmt = $conn->prepare("SELECT user_id FROM user WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $message = "Email already exists.";
                $stmt->close();
            } else {
                $stmt->close();

                // Check if username exists
                $stmt = $conn->prepare("SELECT user_id FROM user WHERE username = ? LIMIT 1");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $message = "Username already exists.";
                    $stmt->close();
                } else {
                    $stmt->close();

                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $status = "Pending";
                    $profile_picture = ""; 
                    $insert = $conn->prepare("
                        INSERT INTO user
                        (role_id, first_name, last_name, email, username, password, department, birth_date, address, contact_num, status, profile_picture, date_created, updated_at)
                        VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                    ");

                    // contact_num is int in your DB (int(11)), convert safely
                    $contact_int = ($contact_num !== '' && ctype_digit($contact_num)) ? (int)$contact_num : 0;

                    $insert->bind_param(
                        "issssssssiss",
                        $role_id,
                        $first_name,
                        $last_name,
                        $email,
                        $username,
                        $hashed,
                        $department,
                        $birth_date,
                        $address,
                        $contact_int,
                        $status,
                        $profile_picture
                    );

                    if ($insert->execute()) {
                        $message = "Registration successful! Wait for admin approval.";
                        echo "<script>setTimeout(() => { window.location.href='login.php'; }, 2000);</script>";
                    } else {
                        $message = "⚠️ Registration failed: " . $insert->error;
                    }

                    $insert->close();
                }
            }

            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Thesis Archiving System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

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
                        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($full_name); ?>" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined input-icon">mail</span>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username *</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined input-icon">account_circle</span>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Choose a username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Role *</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined input-icon">group</span>
                        <select id="role" name="role" required>
                            <option value="">Select role</option>
                            <option value="student">Student</option>
                            <option value="faculty">Faculty</option>
                            <option value="admin">Admin</option>
                            <option value="admin">Dean</option>
                            
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
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

                <div class="form-group">
                    <label for="contact_num">Contact Number *</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined input-icon">call</span>
                        <input type="text" id="contact_num" name="contact_num" placeholder="09xxxxxxxxx" required>
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
                     <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
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

<script>
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