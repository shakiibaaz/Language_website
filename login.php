<?php
require_once 'config.php';
$message='';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
// Get form data
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];

// Validation
    if (empty($email) || empty($password)) {
        header('location:login.php?op=empty');
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

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            header('location:login.php?op=error');
            exit();
        }

        // Verify password
        if (!verify_password($password, $user['password'])) {
            header('location:login.php?op=error');
            exit();
        }
        $_SESSION['role'] = $user['role'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['userid'] = $user['id'];
        if($user['role']) {
            header('location:admin.php?');
            exit();
        }
        else{
            header('location:index.php?');
            exit();
        }

    } catch (PDOException $e) {
        echo ('Database error: ' . $e->getMessage());
    }
}
//show message
if(isset($_GET['op'])){
    switch ($_GET['op']){
        case 'ok':
            $message = '<div class="success">Registration was successful, you can now log in.</div>';
            break;
        case 'empty':
            $message = '<div class="error">Email and password are required</div>';
            break;
        case 'email':
            $message = '<div class="error">Invalid email format</div>';
            break;
        case 'least':
            $message = '<div class="error">Password must be at least 6 characters long</div>';
            break;
        case 'error':
            $message = '<div class="error">Invalid email or password</div>';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Language Learning Hub</title>
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
                    <li><a href="login.php" class="active">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="auth-section">
            <div class="container">
                <div class="auth-container">
                    <div class="auth-card">
                        <h2>Login to Your Account</h2>
                        <?=@$message?>
                        <form id="loginForm" action="" method="POST">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="remember"> Remember me
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-full">Login</button>
                        </form>
                        <div class="auth-links">
                            <p>Don't have an account? <a href="register.php">Register here</a></p>
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