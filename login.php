<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname="tuition_db";

$conn = new mysqli($servername, $dbusername, $dbpassword,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role= $_POST["role"];

    $sql = "INSERT INTO login1 (username, password, role) VALUES ('$username','$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("location:source1.html");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
    $conn->close();
?>
