<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: logine.php");
    exit();
}

require_once 'connect.php';

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['FullName']); ?> | SkillBridge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --light-text: #ecf0f1;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
        }
        
        /* Professional Navbar */
        .navbar-professional {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.5rem 1rem;
        }
        
        .navbar-professional .navbar-brand {
            font-weight: 700;
            color: var(--secondary-color);
        }
        
        .profile-nav {
            display: flex;
            align-items: center;
        }
        
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid var(--primary-color);
        }
        
        /* Hero Section */
        .hero-profile {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        /* Skills Section */
        .skills-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .skill-badge {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            display: inline-block;
            font-size: 0.9rem;
        }
        
        .learning-badge {
            background-color: var(--accent-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            display: inline-block;
            font-size: 0.9rem;
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        /* Activity Feed */
        .activity-item {
            border-left: 3px solid var(--primary-color);
            padding-left: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .activity-time {
            font-size: 0.8rem;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <!-- Professional Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-professional sticky-top">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">
                <i class="fas fa-network-wired me-2"></i>SkillBridge
            </a>
            
            <div class="profile-nav ms-auto">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['FullName']); ?>&background=3498db&color=fff" 
                     alt="Profile" class="profile-pic">
                <span class="d-none d-md-inline"><?php echo htmlspecialchars($user['FullName']); ?></span>
            </div>
        </div>
    </nav>

    <!-- Profile Hero Section -->
    <section class="hero-profile">
        <div class="container text-center">
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['FullName']); ?>&background=fff&color=3498db&size=150" 
                 alt="Profile" class="profile-avatar mb-3">
            <h1><?php echo htmlspecialchars($user['FullName']); ?></h1>
            <p class="lead"><?php echo htmlspecialchars($user['YourSkill']); ?> Specialist</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="btn btn-light"><i class="fas fa-envelope me-2"></i>Contact</a>
                <a href="#" class="btn btn-outline-light"><i class="fas fa-share-alt me-2"></i>Share Profile</a>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column - Profile Info -->
            <div class="col-lg-4">
                <!-- About Card -->
                <div class="skills-container mb-4">
                    <h4><i class="fas fa-user me-2"></i>About</h4>
                    <p class="text-muted"><?php echo htmlspecialchars($user['FullName']); ?> is a passionate professional with expertise in multiple domains.</p>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-envelope me-2"></i>Email</h6>
                        <p><?php echo htmlspecialchars($user['Email']); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-phone me-2"></i>Phone</h6>
                        <p><?php echo htmlspecialchars($user['PhoneNo']); ?></p>
                    </div>
                </div>
                
                <!-- Stats Card -->
                <div class="skills-container">
                    <h4><i class="fas fa-chart-line me-2"></i>Stats</h4>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-number">24</div>
                                <div>Connections</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-number">5</div>
                                <div>Projects</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-number">12</div>
                                <div>Skills</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-number">3</div>
                                <div>Learning</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Main Content -->
            <div class="col-lg-8">
                <!-- Skills Section -->
                <div class="skills-container mb-4">
                    <h4><i class="fas fa-code me-2"></i>My Skills</h4>
                    <div class="mb-4">
                        <?php 
                        $skills = explode(',', $user['YourSkill']);
                        foreach($skills as $skill) {
                            echo '<span class="skill-badge">'.htmlspecialchars(trim($skill)).'</span>';
                        }
                        ?>
                    </div>
                    
                    <h4><i class="fas fa-graduation-cap me-2"></i>Currently Learning</h4>
                    <div>
                        <?php 
                        $learning = explode(',', $user['Learn']);
                        foreach($learning as $learn) {
                            echo '<span class="learning-badge">'.htmlspecialchars(trim($learn)).'</span>';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="skills-container mb-4">
                    <h4><i class="fas fa-bell me-2"></i>Recent Activity</h4>
                    
                    <div class="activity-item">
                        <h6>Completed PHP Mastery Course</h6>
                        <p class="mb-1">Earned certification in advanced PHP techniques</p>
                        <p class="activity-time">2 hours ago</p>
                    </div>
                    
                    <div class="activity-item">
                        <h6>Connected with Sarah Johnson</h6>
                        <p class="mb-1">You and Sarah Johnson are now connected</p>
                        <p class="activity-time">1 day ago</p>
                    </div>
                    
                    <div class="activity-item">
                        <h6>Shared a project</h6>
                        <p class="mb-1">Published "E-commerce Dashboard" to your portfolio</p>
                        <p class="activity-time">3 days ago</p>
                    </div>
                </div>
                
                <!-- Projects Section -->
                <div class="skills-container">
                    <h4><i class="fas fa-briefcase me-2"></i>Featured Projects</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/300x200?text=Project+1" class="card-img-top" alt="Project 1">
                                <div class="card-body">
                                    <h5 class="card-title">E-commerce Platform</h5>
                                    <p class="card-text">A complete online shopping solution with payment integration.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/300x200?text=Project+2" class="card-img-top" alt="Project 2">
                                <div class="card-body">
                                    <h5 class="card-title">Task Management App</h5>
                                    <p class="card-text">Productivity application for team collaboration.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>