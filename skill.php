<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillBridge | Professional Skill Network 
  
          </title>
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

    
        @keyframes stellarFloat {
           
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes quantumPulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 229, 204, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(0, 229, 204, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 229, 204, 0); }
        }

        @keyframes nebulaFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Navigation */
        .navbar {
            background: rgba(10, 15, 31, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--stellar-blue);
            animation: nebulaFadeIn 1s ease-out;
        }

        .nav-link {
            color: var(--starlight) !important;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

        
        .hero-section {
            background: linear-gradient(135deg, var(--deep-space) 0%, var(--stellar-blue) 100%);
            padding: 10rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(0, 229, 204, 0.1) 0%, transparent 60%);
            animation: quantumPulse 3s infinite;
        }

        .hero-icon {
            animation: stellarFloat 4s ease-in-out infinite;
            filter: drop-shadow(0 0 15px rgba(0, 229, 204, 0.4));
        }

        
        .feature-card {
            background: rgba(42, 47, 69, 0.6);
            border: 1px solid var(--stellar-blue);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-10px) rotateZ(2deg);
            box-shadow: 0 15px 30px rgba(0, 229, 204, 0.2);
        }

        /* Auth Forms */
        .auth-container {
            background: rgba(42, 47, 69, 0.8);
            border: 1px solid var(--quantum-teal);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            transform: perspective(1000px) rotateX(5deg);
            transition: transform 0.4s ease;
        }

        .auth-container:hover {
            transform: perspective(1000px) rotateX(0deg);
        }

        /* Profile Section */
        .profile-header {
            background: linear-gradient(135deg, var(--stellar-blue) 0%, var(--nebula-purple) 100%);
            position: relative;
            overflow: hidden;
        }

        .profile-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InJnYmEoMCwwLDAsMC4xKSIvPjxwYXRoIGQ9Ik0wIDQwSDEyMEwxNjAgMEwyMDAgNDBIMzIwTDM2MCAwTDM2MCA0MEgzNjBWMjBIMzYwVjBIMzYwVjBIMHY0MFoiIGZpbGw9InJnYmEoMCwyMjksMjA0LDAuMSkiLz48L3N2Zz4=');
        }

        
        .skill-tag {
            background: rgba(0, 229, 204, 0.15);
            color: var(--quantum-teal);
            border: 1px solid var(--quantum-teal);
            padding: 8px 16px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .skill-tag:hover {
            background: var(--quantum-teal);
            color: var(--deep-space);
            transform: scale(1.05);
        }

        /* Buttons */
        .btn-quantum {
            background: var(--quantum-teal);
            color: var(--deep-space);
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .btn-quantum::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.4s;
        }

        .btn-quantum:hover::before {
            left: 100%;
        }

        /* Form Elements */
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
        }

        /* Page Transitions */
        .page {
            animation: nebulaFadeIn 0.8s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <i class="fas fa-atom me-2"></i>SkillBridge
            </a>
            <div class="d-flex align-items-center">
                <a href="logine.php" class="nav-link mx-3">Login</a>
<!-- logine and join page wapas nahi ho raha hai  -->

                <a href="register.html" class="btn btn-quantum mx-2">Join Now</a>
            </div>
        </div>
    </nav>

    <!-- Home Page Content -->
    <div class="hero-section">
        <div class="container text-center">
            <i class="fas fa-brain hero-icon fa-4x text-quantum-teal mb-4"></i>
            <h1 class="display-4 mb-4">Transform Your Professional Journey</h1>
            <p class="lead mb-5">Connect with experts in a cosmic network of knowledge exchange</p>
            <a href="#register" class="btn btn-quantum btn-lg px-5">Launch Your Growth</a>
        </div>
       
    </div>

    <!-- Rest of your content remains the same with updated class names -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add intersection observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        document.querySelectorAll('.feature-card, .auth-container').forEach((el) => {
            el.style.opacity = 0;
            el.style.transform = 'translateY(30px)';
            observer.observe(el);
        });
    </script>
 
     <footer class="text-center py-3 bg-light">
        &copy; 2025 SkillBridge. All Rights Reserved.
    </footer>
   
</body>
</html>