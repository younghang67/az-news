<?php
require_once ROOT . '/link/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $categoryId = $_POST['category'];
    $status = $_POST['status'];

    // Get user ID based on session email
    $email = $_SESSION['user']['email'] ?? null;
    if (!$email) {
        die("User not logged in");
    }

    $userQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $userQuery->bind_param("s", $email);
    $userQuery->execute();
    $userResult = $userQuery->get_result();

    if ($userResult->num_rows === 0) {
        die("Invalid user");
    }

    $user = $userResult->fetch_assoc();
    $userId = $user['id'];
    $userQuery->close();

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO posts (title, content, category_id, user_id, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $title, $content, $categoryId, $userId, $status);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Post created successfully!'];
        header("Location: show-news");
        exit;
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Error creating post.'];
    }

    $stmt->close();
}
