<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: logine.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_stmt->close();

$posts_stmt = $conn->prepare("SELECT posts.*, users.FullName 
                            FROM posts 
                            JOIN users ON posts.user_id = users.id 
                            ORDER BY posts.created_at DESC LIMIT 20");
$posts_stmt->execute();
$posts_result = $posts_stmt->get_result();
$posts = $posts_result->fetch_all(MYSQLI_ASSOC);
$posts_stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed | SkillBridge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --deep-space: #0A0F1F;
            --stellar-blue: #1A2A6B;
            --nebula-purple: #4B0082;
            --quantum-teal: #00E5CC;
            --cosmic-gray: #2A2F45;
            --starlight: #E6E6FA;
        }

        body {
            background: var(--deep-space);
            color: var(--starlight);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* Professional Navigation */
        .navbar-cosmic {
            background: rgba(10, 15, 31, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--stellar-blue);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-icon {
            font-size: 1.25rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-icon:hover {
            background: rgba(0, 229, 204, 0.1);
        }

        .nav-icon.active {
            color: var(--quantum-teal);
        }

        /* Profile Dropdown */
        .profile-dropdown {
            width: 280px;
            border: 1px solid var(--stellar-blue);
            background: rgba(42, 47, 69, 0.95);
            backdrop-filter: blur(10px);
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 250px 1fr 300px;
            gap: 1.5rem;
            padding-top: 1rem;
        }

        /* Sidebar Modules */
        .cosmic-module {
            background: rgba(42, 47, 69, 0.6);
            border: 1px solid var(--stellar-blue);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .module-title {
            color: var(--quantum-teal);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        /* Feed Posts */
        .cosmic-post {
            background: rgba(42, 47, 69, 0.6);
            border: 1px solid var(--stellar-blue);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .cosmic-post:hover {
            transform: translateY(-3px);
            border-color: var(--quantum-teal);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .post-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--quantum-teal);
            margin-right: 1rem;
        }

        .post-user {
            font-weight: 600;
        }

        .post-time {
            color: #7f8c8d;
            font-size: 0.85rem;
        }

        .post-content {
            margin: 1rem 0;
            line-height: 1.6;
        }

        .post-image {
            width: 100%;
            border-radius: 8px;
            margin: 1rem 0;
            max-height: 500px;
            object-fit: cover;
            border: 1px solid var(--stellar-blue);
        }

        .post-actions {
            display: flex;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--cosmic-gray);
        }

        .post-action {
            color: var(--starlight);
            transition: all 0.3s ease;
        }

        .post-action:hover {
            color: var(--quantum-teal);
            transform: scale(1.1);
        }

        /* Create Post */
        .create-post {
            background: rgba(42, 47, 69, 0.8);
            border: 1px solid var(--quantum-teal);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .create-post-input {
            background: rgba(42, 47, 69, 0.6);
            border: 1px solid var(--stellar-blue);
            color: var(--starlight);
            border-radius: 12px;
            padding: 1rem;
            width: 100%;
            resize: none;
        }

        .create-post-input:focus {
            outline: none;
            border-color: var(--quantum-teal);
        }

        /* Buttons */
        .btn-cosmic {
            background: var(--quantum-teal);
            color: var(--deep-space);
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cosmic:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 229, 204, 0.3);
        }

        /* Animations */
        @keyframes stellarFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes quantumPulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 229, 204, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(0, 229, 204, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 229, 204, 0); }
        }
    </style>
</head>
<body>
    <!-- Professional Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-cosmic sticky-top">
        <div class="container">
            <a class="navbar-brand" href="feed.php">
                <i class="fas fa-atom me-2"></i>SkillBridge
            </a>
            
            <div class="d-flex align-items-center">
                <a href="feed.php" class="nav-icon active" title="Home">
                    <i class="fas fa-home"></i>
                </a>
                <a href="#" class="nav-icon" title="Network">
                    <i class="fas fa-users"></i>
                </a>
                <a href="#" class="nav-icon" title="Notifications">
                    <i class="fas fa-bell"></i>
                </a>
                <a href="#" class="nav-icon" title="Messages">
                    <i class="fas fa-envelope"></i>
                </a>
                
                <!-- Profile Dropdown -->
                <div class="dropdown ms-3">
                    <button class="btn p-0" type="button" id="profileDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['FullName']) ?>&background=00E5CC&color=0A0F1F" 
                             alt="Profile" class="rounded-circle" width="40" height="40">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="profileDropdownBtn">
                        <li>
                            <div class="d-flex align-items-center px-3 py-2">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['FullName']) ?>&background=00E5CC&color=0A0F1F" 
                                     alt="Profile" class="rounded-circle me-3" width="48" height="48">
                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars($user['FullName']) ?></h6>
                                    <small class="text-muted">@<?= htmlspecialchars(explode('@', $user['Email'])[0]) ?></small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="homepage.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <div class="content-grid">
            <!-- Left Sidebar -->
            <div class="left-sidebar">
                <div class="cosmic-module">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['FullName']) ?>&background=00E5CC&color=0A0F1F" 
                             alt="Profile" class="rounded-circle me-3" width="64" height="64">
                        <div>
                            <h5 class="mb-0"><?= htmlspecialchars($user['FullName']) ?></h5>
                            <small class="text-muted"><?= htmlspecialchars($user['YourSkill']) ?></small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between text-center">
                        <div>
                            <div class="fw-bold">247</div>
                            <small>Connections</small>
                        </div>
                        <div>
                            <div class="fw-bold">56</div>
                            <small>Posts</small>
                        </div>
                        <div>
                            <div class="fw-bold">12</div>
                            <small>Skills</small>
                        </div>
                    </div>
                </div>

                <div class="cosmic-module">
                    <h6 class="module-title"><i class="fas fa-bolt me-2"></i>Recent Activity</h6>
                    <div class="activity-item">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-certificate text-quantum-teal me-2"></i>
                            <span>Completed React Course</span>
                        </div>
                        <small class="text-muted">2 hours ago</small>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user-plus text-quantum-teal me-2"></i>
                            <span>Connected with Sarah</span>
                        </div>
                        <small class="text-muted">1 day ago</small>
                    </div>
                </div>

                <div class="cosmic-module">
                    <h6 class="module-title"><i class="fas fa-fire me-2"></i>Trending Skills</h6>
                    <div class="skill-tag">React</div>
                    <div class="skill-tag">Node.js</div>
                    <div class="skill-tag">UI/UX</div>
                    <div class="skill-tag">Python</div>
                    <div class="skill-tag">AWS</div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="main-feed">
                <div class="create-post">
                    <form action="create_post.php" method="post" enctype="multipart/form-data">
                        <textarea class="create-post-input mb-3" name="content" placeholder="Share your knowledge..." rows="3"></textarea>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <input type="file" id="postImage" name="image" accept="image/*" class="d-none">
                                <label for="postImage" class="btn btn-sm btn-outline-quantum-teal me-2">
                                    <i class="fas fa-image"></i>
                                </label>
                                <button type="button" class="btn btn-sm btn-outline-quantum-teal">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-cosmic">Post</button>
                        </div>
                    </form>
                </div>

                <?php if(count($posts) > 0): ?>
                    <?php foreach($posts as $post): ?>
                    <div class="cosmic-post">
                        <div class="post-header">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($post['FullName']) ?>&background=00E5CC&color=0A0F1F" 
                                 alt="Profile" class="post-avatar">
                            <div>
                                <div class="post-user"><?= htmlspecialchars($post['FullName']) ?></div>
                                <div class="post-time"><?= date('M j, Y \a\t g:i a', strtotime($post['created_at'])) ?></div>
                            </div>
                        </div>
                        
                        <div class="post-content">
                            <?= htmlspecialchars($post['content']) ?>
                        </div>
                        
                        <?php if($post['image_url']): ?>
                        <img src="<?= htmlspecialchars($post['image_url']) ?>" class="post-image">
                        <?php endif; ?>
                        
                        <div class="post-actions">
                            <a href="#" class="post-action"><i class="far fa-heart"></i> Like</a>
                            <a href="#" class="post-action"><i class="far fa-comment"></i> Comment</a>
                            <a href="#" class="post-action"><i class="fas fa-share"></i> Share</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="cosmic-module text-center py-4">
                        <i class="fas fa-comment-slash text-quantum-teal mb-3" style="font-size: 2rem;"></i>
                        <h5>No posts yet</h5>
                        <p class="text-muted">Be the first to share your knowledge!</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar -->
            <div class="right-sidebar">
                <div class="cosmic-module">
                    <h6 class="module-title"><i class="fas fa-users me-2"></i>People You May Know</h6>
                    <div class="suggested-user">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="rounded-circle me-2" width="40">
                        <div>
                            <div>Sarah Johnson</div>
                            <small class="text-muted">UI/UX Designer</small>
                        </div>
                        <button class="btn btn-sm btn-cosmic ms-auto">Connect</button>
                    </div>
                    <!-- More suggested users... -->
                </div>

                <div class="cosmic-module">
                    <h6 class="module-title"><i class="fas fa-calendar me-2"></i>Upcoming Events</h6>
                    <div class="event-item">
                        <div class="event-date bg-quantum-teal text-dark">15 OCT</div>
                        <div>
                            <div>Web Development Workshop</div>
                            <small class="text-muted">Online • 2:00 PM</small>
                        </div>
                    </div>
                    <!-- More events... -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>
</html>