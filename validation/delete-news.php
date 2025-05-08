<?php
require_once ROOT . '/link/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news_id'])) {
    $newsId = $_POST['news_id'];

    // Ensure it's numeric or properly validated
    if (is_numeric($newsId)) {
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $newsId);

        if ($stmt->execute()) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'news deleted successfully'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'danger',
                'text' => 'Failed to delete news'
            ];
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = [
            'type' => 'warning',
            'text' => 'Invalid news ID'
        ];
    }
    header('Location: show-news');
    exit;
}
