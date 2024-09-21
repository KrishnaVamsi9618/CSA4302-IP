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

    // Fetch teacher's classes
    $stmt_classes = $conn->query("SELECT * FROM classes WHERE teacher_id = " . $_SESSION['teacher_id']);
    $classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $quiz_title = $_POST['quiz_title'];
        $class_id = $_POST['class_id'];
        $quiz_date = $_POST['quiz_date'];

        $stmt = $conn->prepare("INSERT INTO quizzes (quiz_title, class_id, quiz_date) VALUES (:quiz_title, :class_id, :quiz_date)");
        $stmt->bindParam(':quiz_title', $quiz_title);
        $stmt->bindParam(':class_id', $class_id);
        $stmt->bindParam(':quiz_date', $quiz_date);

        if ($stmt->execute()) {
            echo "Quiz created successfully!";
        } else {
            echo "Failed to create quiz!";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>