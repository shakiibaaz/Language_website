<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Language Learning Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <div class="logo">
                    <h2><a href="index.html">Language Hub</a></h2>
                </div>
                <ul class="nav-menu">
                    <li><a href="dashboard.html" class="active">Dashboard</a></li>
                    <li><a href="courses.html">Courses</a></li>
                    <li><a href="#" onclick="logout()">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="dashboard">
            <div class="container">
                <div class="dashboard-header">
                    <h1>Welcome back, <span id="user-name">User</span>!</h1>
                    <p>Continue your language learning journey</p>
                </div>

                <div class="dashboard-stats">
                    <div class="stat-card">
                        <h3>Enrolled Courses</h3>
                        <div class="stat-number">3</div>
                    </div>
                    <div class="stat-card">
                        <h3>Hours Studied</h3>
                        <div class="stat-number">24</div>
                    </div>
                    <div class="stat-card">
                        <h3>Certificates</h3>
                        <div class="stat-number">1</div>
                    </div>
                    <div class="stat-card">
                        <h3>Current Streak</h3>
                        <div class="stat-number">7 days</div>
                    </div>
                </div>

                <div class="dashboard-content">
                    <div class="dashboard-section">
                        <h2>My Courses</h2>
                        <div class="my-courses" id="my-courses">
                            <!-- User's enrolled courses will be loaded here -->
                        </div>
                    </div>

                    <div class="dashboard-section">
                        <h2>Recent Progress</h2>
                        <div class="progress-list">
                            <div class="progress-item">
                                <div class="progress-info">
                                    <h4>German Basics</h4>
                                    <p>Lesson 5: Basic Conversations</p>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 70%"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div class="progress-info">
                                    <h4>French Intermediate</h4>
                                    <p>Lesson 3: Past Tense</p>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-section">
                        <h2>Quick Actions</h2>
                        <div class="quick-actions">
                            <a href="courses.html" class="action-btn">Browse New Courses</a>
                            <a href="#" class="action-btn">Continue Learning</a>
                            <a href="#" class="action-btn">View Certificates</a>
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
    <script>
        // Check if user is logged in
        window.onload = function() {
            checkAuth();
            loadUserCourses();
        };
    </script>
</body>
</html>