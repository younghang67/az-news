<?php
require_once ROOT . '/link/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'] ?? null;
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $categoryId = $_POST['category'];
    $status = $_POST['status'];

    if (!$postId) {
        die("Missing post ID");
    }

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

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, category_id = ?, status = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssisii", $title, $content, $categoryId, $status, $postId, $userId);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Post updated successfully!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Error updating post.'];
    }

    $stmt->close();
    header("Location: show-news");
    exit;
}
