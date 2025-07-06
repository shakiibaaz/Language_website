<?php
require_once 'config.php';
$message='';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
// Get form data
    $full_name = sanitize_input($_POST['full_name']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $now = time();

// Validation
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        header('location:register.php?op=empty');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location:register.php?op=email');
        exit();
    }

    if (strlen($password) < 6) {
        header('location:register.php?op=least');
        exit();
    }

    if ($password !== $confirm_password) {
        header('location:register.php?op=password');
        exit();
    }

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            header('location:register.php?op=duplicate');
            exit();
        }

        // Hash password
        $hashed_password = hash_password($password);

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password, role, created_at) VALUES (?, ?, ?, 0, ?)");
        $stmt->execute([$full_name, $email, $hashed_password, $now]);
        header('location:login.php?ok');
        exit();

    } catch (PDOException $e) {
        echo ('Database error: ' . $e->getMessage());
    }
}
if(isset($_GET['op'])){
    switch ($_GET['op']){
        case 'empty':
            $message = '<div class="error">All fields are required</div>';
            break;
        case 'email':
            $message = '<div class="error">Invalid email format</div>';
            break;
        case 'least':
            $message = '<div class="error">Password must be at least 6 characters long</div>';
            break;
        case 'password':
            $message = '<div class="error">Passwords do not match</div>';
            break;
        case 'duplicate':
            $message = '<div class="error">Email already exists</div>';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Language Learning Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <div class="logo">
                    <h2><a href="index.php">Language Hub</a></h2>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php" class="active">Register</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="auth-section">
            <div class="container">
                <div class="auth-container">
                    <div class="auth-card">
                        <h2>Create Your Account</h2>
                        <?=@$message?>
                        <form id="registerForm" action="" method="POST">
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" minlength="6" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="terms" required> I agree to the Terms and Conditions
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-full">Register</button>
                        </form>
                        <div class="auth-links">
                            <p>Already have an account? <a href="login.php">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Language Hub</h3>
                    <p>Your gateway to mastering new languages</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Language Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="main.js"></script>
</body>
</html>