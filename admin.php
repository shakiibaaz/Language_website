<?php
require_once 'config.php';
// Check if user is admin
if(!isset($_SESSION['role']) && $_SESSION['role']!=1){
    header('index.php?ok=restrict');
    exit();
}
$message='';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
// Get form data
    $title = sanitize_input($_POST['title']);
    $language = sanitize_input($_POST['language']);
    $level = sanitize_input($_POST['level']);
    $duration = sanitize_input($_POST['duration']);
    $description = sanitize_input($_POST['description']);
    $now = time();
    $pic = Upload($_FILES['image']['name'],$_FILES['image']['tmp_name'],'upload/',1000000000,'jpg,png,jpeg,gif,webp',2500,2500,'admin.php');

// Validation
    if (empty($title) || empty($language) || empty($level) || empty($duration) || empty($description) || empty($pic)) {
        header('location:login.php?op=empty');
        exit();
    }

    try {
        // Insert new course
        $stmt = $pdo->prepare("INSERT INTO courses (title, lang, level, duration, description, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $language, $level, $duration, $description, $pic, $now]);
        header('location:admin.php?op=ok');
        exit();

    } catch (PDOException $e) {
        echo ('Database error: ' . $e->getMessage());
    }
}
//delete courses
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM courses WHERE cid=?");
    $stmt->execute([$id]);
    header('location:admin.php?op=dok');
    exit();
}
//delete users
if(isset($_GET['delete'])){
    $id = intval($_GET['deluser']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$id]);
    header('location:admin.php?op=uok');
    exit();
}
//get data from courses tbl
$course = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC");
//get all user
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
//show message
if(isset($_GET['op'])){
    switch ($_GET['op']){
        case 'ok':
            $message = '<div class="success">The course was successfully registered.</div>';
            break;
        case 'empty':
            $message = '<div class="error">All fields are required</div>';
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
    <title>Admin Panel - Language Learning Hub</title>
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
                    <li><a href="admin.php" class="active">Admin Panel</a></li>
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="#" onclick="logout()">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="admin-panel">
            <div class="container">
                <div class="admin-header">
                    <h1>Admin Panel</h1>
                    <p>Manage courses and users</p>
                </div>

                <div class="admin-tabs">
                    <button class="tab-btn active" onclick="showTab('courses')">Manage Courses</button>
                    <button class="tab-btn" onclick="showTab('users')">Manage Users</button>
                    <button class="tab-btn" onclick="showTab('stats')">Statistics</button>
                </div>

                <div id="courses-tab" class="tab-content active">
                    <div class="admin-section">
                        <h2>Add New Course</h2>
                        <form id="add-course-form" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="course_title">Course Title</label>
                                    <input type="text" id="course_title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select id="language" name="language" required>
                                        <option value="">Select Language</option>
                                        <option value="English">English</option>
                                        <option value="German">German</option>
                                        <option value="French">French</option>
                                        <option value="Spanish">Spanish</option>
                                        <option value="Italian">Italian</option>
                                        <option value="Portuguese">Portuguese</option>
                                        <option value="Japanese">Japanese</option>
                                        <option value="Korean">Korean</option>
                                        <option value="Chinese">Chinese</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select id="level" name="level" required>
                                        <option value="">Select Level</option>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Duration (hours)</label>
                                    <input type="number" id="duration" name="duration" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Course Image</label>
                                <input type="file" id="image" name="image" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Course</button>
                        </form>
                    </div>

                    <div class="admin-section">
                        <h2>Existing Courses</h2>
                        <div class="courses-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Language</th>
                                        <th>Level</th>
                                        <th>Duration</th>
                                        <th>Students</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="courses-table-body">
                                <?php while ($rows = $course->fetch()){ ?>
                                    <tr>
                                        <td><?=$rows['title']?></td>
                                        <td><?=$rows['lang']?></td>
                                        <td><?=$rows['level']?></td>
                                        <td><?=$rows['duration']?></td>
                                        <td>-</td>
                                        <td><a href="?delete=<?=$rows['cid']?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="users-tab" class="tab-content">
                    <div class="admin-section">
                        <h2>Registered Users</h2>
                        <div class="users-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Join Date</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="users-table-body">
                                <?php while($rows = $users->fetch()) { ?>
                                    <tr>
                                        <td><?=$rows['fullname']?></td>
                                        <td><?=$rows['email']?></td>
                                        <td><?=date("Y/m/d",$rows['created_at'])?></td>
                                        <td><?=$rows['role']==0?'user':'admin'?></td>
                                        <td><a href="?deluser=<?=$rows['id']?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="stats-tab" class="tab-content">
                    <div class="admin-section">
                        <h2>Platform Statistics</h2>
                        <div class="stats-grid">
                            <div class="stat-card">
                                <h3>Total Users</h3>
                                <div class="stat-number">152</div>
                            </div>
                            <div class="stat-card">
                                <h3>Total Courses</h3>
                                <div class="stat-number">12</div>
                            </div>
                            <div class="stat-card">
                                <h3>Active Students</h3>
                                <div class="stat-number">89</div>
                            </div>
                            <div class="stat-card">
                                <h3>Certificates Issued</h3>
                                <div class="stat-number">45</div>
                            </div>
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