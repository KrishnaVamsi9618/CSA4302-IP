<?php
session_start();
$host = 'localhost';
$dbname = 'tuition_db';
$username = 'root';
$password = '';

// Check if teacher is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch classes and students
    $stmt_classes = $conn->query("SELECT * FROM classes WHERE teacher_id = " . $_SESSION['teacher_id']);
    $classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $class_id = $_POST['class_id'];
        $student_id = $_POST['student_id'];
        $subject = $_POST['subject'];
        $marks = $_POST['marks'];

        $stmt = $conn->prepare("INSERT INTO marks (student_id, subject, marks) VALUES (:student_id, :subject, :marks)");
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':marks', $marks);

        if ($stmt->execute()) {
            echo "Marks added successfully!";
        } else {
            echo "Failed to add marks!";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>