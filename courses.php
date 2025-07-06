<?php
require_once 'config.php';
//get data from courses
$course = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Learning Hub</title>
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
                    <li><a href="courses.php" class="active">Courses</a></li>
                    <?php if(isset($_SESSION['userid'])){ ?>
                        <li>Welcome <?=$_SESSION['fullname']?></li>
                        <li><a href="logout.php">logout</a></li>
                    <?php }else{ ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php } ?>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <main>

        <section class="popular-courses">
            <div class="container">
                <h2>Popular Courses</h2>
                <?php while($rows = $course->fetch()){ ?>
                <div class="courses-grid" id="popular-courses">
                    <div class="course-image">
                        <img src="upload/<?=$rows['image']?>">
                    </div>
                    <div class="course-content">
                        <h3><?=$rows['title']?></h3>
                        <div class="course-meta">
                            <span>Level: <?=$rows['level']?></span>
                            <span>Duration: <?=$rows['duration']?> h</span>
                        </div>
                        <p><?=nl2br($rows['description'])?></p>
                        <a href="#course_detail.php?id=<?=$rows['cid']?>" class="btn btn-primary">View Course</a>
                    </div>

                </div>
                <?php } ?>
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
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="courses.html">Courses</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="register.html">Register</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Email: info@languagehub.com</p>
                    <p>Phone: +1 (555) 123-4567</p>
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