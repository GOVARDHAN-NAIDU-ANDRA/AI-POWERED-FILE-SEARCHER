<?php
header("Content-Type: application/json");
$query = isset($_GET["q"]) ? $_GET["q"] : "";

if ($query) {
    $command = escapeshellcmd("python3 search.py " . escapeshellarg($query));
    $output = shell_exec($command);
    echo $output;
} else {
    echo json_encode([]);
}
?>