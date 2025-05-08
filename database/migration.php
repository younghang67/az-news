<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "news";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($database);

$sql = "CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100)  NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Category table created successfully<br>";
} else {
    die("Error creating categories table: " . $conn->error);
}

$sql = "INSERT IGNORE INTO categories (id, name, slug, description) VALUES (1, 'Uncategorized', 'uncategorized', 'This is default Category' )";
if ($conn->query($sql) === TRUE) {
    echo "Category added successfully<br>";
} else {
    die("Error creating Category : " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully<br>";
} else {
    die("Error creating users table: " . $conn->error);
}


$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    status ENUM('published','draft','archived') DEFAULT 'published',
    category_id INT UNSIGNED DEFAULT '1',
    user_id INT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Post table created successfully<br>";
} else {
    die("Error creating post table: " . $conn->error);
}

$conn->close();
?>

<a href='home'>GO Home</a>