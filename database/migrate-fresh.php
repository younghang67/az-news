<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "news";

$conn = new mysqli($servername, $username, $password, );

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (session_destroy()) {
    echo 'session ended <br>';
}

$sql = "DROP DATABASE IF EXISTS news";
if ($conn->query($sql) === TRUE) {
    echo "database dropped successfully" . "<br>";
    require_once __DIR__ . '/migration.php';
} else {
    echo "Error dropping tables: " . $conn->error;
    $conn->close();
    exit;
}