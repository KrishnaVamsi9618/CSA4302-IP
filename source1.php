<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "tuition_db";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT role FROM login1 WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['role'];

        // Redirect based on role
        if ($role == 'student') {
            header("Location:source.html");
            exit();
        } elseif ($role == 'teacher') {
            header("Location:teacher_dashboard.html");
            exit();
        } else {
            echo "Unknown role.";
        }
    } else {
        echo "Invalid username or password.";
    }
}

$conn->close();
?>
