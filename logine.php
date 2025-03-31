<?php
session_start();
// Redirect to feed if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: feed.php");
    exit();
}

$error = isset($_GET['error']) ? $_GET['error'] : '';
$registered = isset($_GET['registered']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SkillBridge</title>
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
            display: flex;
            flex-direction: column;
        }

        .auth-container {
            background: rgba(42, 47, 69, 0.8);
            border: 1px solid var(--quantum-teal);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            padding: 2rem;
            max-width: 450px;
            width: 100%;
            margin: 2rem auto;
            animation: nebulaFadeIn 0.8s ease-out;
            transform: perspective(1000px) rotateX(5deg);
            transition: transform 0.4s ease;
        }

        .auth-container:hover {
            transform: perspective(1000px) rotateX(0deg);
        }

        @keyframes nebulaFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-control {
            background: rgba(42, 47, 69, 0.6);
            border: 1px solid var(--stellar-blue);
            color: var(--starlight);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--quantum-teal);
            box-shadow: 0 0 15px rgba(0, 229, 204, 0.3);
            background: rgba(42, 47, 69, 0.8);
            color: var(--starlight);
        }

        .btn-quantum {
            background: var(--quantum-teal);
            color: var(--deep-space);
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.4s ease;
        }

        .btn-quantum:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 229, 204, 0.4);
        }

        .login-title {
            color: var(--quantum-teal);
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .nav-link {
            color: var(--starlight) !important;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--quantum-teal);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="skill.php">
                <i class="fas fa-atom me-2"></i>SkillBridge
            </a>
            <div class="d-flex align-items-center">
                <a href="skill.php" class="nav-link mx-3">Home</a>
                <a href="register.html" class="btn btn-quantum mx-2">Join Now</a>
            </div>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="container my-auto">
        <div class="auth-container">
            <h2 class="login-title"><i class="fas fa-sign-in-alt me-2"></i>Login to SkillBridge</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($registered): ?>
                <div class="alert alert-success">Registration successful! Please login.</div>
            <?php endif; ?>
            
            <form action="logpro.php" method="post" autocomplete="off">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="Email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="Password" required>
                </div>
                <button type="submit" class="btn btn-quantum w-100 mt-3">Login</button>
            </form>
            
            <div class="text-center mt-4">
                <p class="mb-2">Don't have an account? <a href="register.html" class="text-quantum-teal">Register here</a></p>
                <a href="skill.php" class="text-muted"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>