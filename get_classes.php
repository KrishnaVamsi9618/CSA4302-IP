<?php
// get_classes.php
$result = $conn->query("SELECT * FROM classes1");
$classes = [];

while ($row = $result->fetch_assoc()) {
    $classes[] = $row;
}

echo json_encode($classes);
?>
