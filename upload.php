<?php
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        $conn = new mysqli("localhost", "root", "", "file_search");
        $stmt = $conn->prepare("INSERT INTO files (filename, filepath) VALUES (?, ?)");
        $stmt->bind_param("ss", $fileName, $targetFilePath);
        $stmt->execute();
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
}
?>
