<?php
session_start();
require_once 'connect.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $email = filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['Password'];

    if (empty($email) || empty($password)) {
        header("Location: logine.php?error=Email and password are required");
        exit();
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT id, FullName, Email, Password FROM users WHERE Email = ?");
    if (!$stmt) {
        header("Location: logine.php?error=Database error");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password (check both hashed and plaintext for migration)
        if (password_verify($password, $user['Password']) || $password === $user['Password']) {
            // Regenerate session ID for security
            session_regenerate_id(true);
            
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['FullName'];
            $_SESSION['email'] = $user['Email'];
            
            // Redirect to feed page
            header("Location: feed.php");
            exit();
        } else {
            // Invalid password
            header("Location: logine.php?error=Invalid email or password");
            exit();
        }
    } else {
        // User not found
        header("Location: logine.php?error=Invalid email or password");
        exit();
    }
    
    $stmt->close();
    $conn->close();
} else {
    // Not a POST request
    header("Location: logine.php");
    exit();
}
?>