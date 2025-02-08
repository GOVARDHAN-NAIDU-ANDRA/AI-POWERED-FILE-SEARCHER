<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "file_search");

if ($conn->connect_error) {
    die(json_encode([]));
}

$query = "SELECT filename, filepath FROM files ORDER BY uploaded_at DESC";
$result = $conn->query($query);

$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}

echo json_encode($files);
?>
