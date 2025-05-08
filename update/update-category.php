<?php
require_once ROOT . '/link/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catId = $_POST['cat_id'] ?? null;
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $nameSlug = explode(" ", $name);
    $nameSlug = implode("-", $nameSlug);
    if (!$catId) {
        die("Missing post ID");
    }

    $email = $_SESSION['user']['email'] ?? null;
    if (!$email) {
        die("User not logged in");
    }


    $stmt = $conn->prepare("UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $nameSlug, $desc, $catId);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'category updated successfully!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Error updating post.'];
    }

    $stmt->close();
    header("Location: show-category");
    exit;
}
