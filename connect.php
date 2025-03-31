<?php
// Database connection function
function getDBConnection() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "skillbridge";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Create a global connection variable
$conn = getDBConnection();

// For registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['FullName'])) {
    $FullName = $_POST['FullName'];
    $Email = $_POST['Email'];
    $PhoneNo = $_POST['PhoneNo'];
    $YourSkill = $_POST['YourSkill'];
    $Learn = $_POST['Learn'];
    $Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(FullName, Email, PhoneNo, YourSkill, Learn, Password) 
       VALUES(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $FullName, $Email, $PhoneNo, $YourSkill, $Learn, $Password);
    
    if ($stmt->execute()) {
        // After registration, redirect to login
        header("Location: logine.php?registered=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>