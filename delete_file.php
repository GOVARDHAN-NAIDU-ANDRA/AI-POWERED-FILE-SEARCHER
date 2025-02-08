<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    
    // Connect to MySQL
    $conn = new mysqli("localhost", "root", "", "file_search");

    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    // Get file path
    $query = "SELECT filepath FROM files WHERE filename=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $filename);
    $stmt->execute();
    $stmt->bind_result($filepath);
    $stmt->fetch();
    $stmt->close();

    if ($filepath && file_exists($filepath)) {
        unlink($filepath); // Delete the file from the folder
    }

    // Delete from database
    $query = "DELETE FROM files WHERE filename=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $filename);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "✅ File deleted successfully!";
} else {
    echo "❌ Error: Invalid request!";
}
?>
