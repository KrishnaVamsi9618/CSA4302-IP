<?php
session_start();

// Check if the teacher is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}
?>
