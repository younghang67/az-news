<?php
require_once ROOT . '/link/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];

    if (is_numeric($categoryId)) {

        if ($categoryId == 1) {
            $_SESSION['message'] = [
                'type' => 'warning',
                'text' => 'The "Uncategorized" category cannot be deleted.'
            ];
            header('Location: show-category');
            exit;
        } else {
            $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->bind_param("i", $categoryId);

            if ($stmt->execute()) {
                $checkStmt = $conn->query("SELECT COUNT(*) as count FROM categories");
                $row = $checkStmt->fetch_assoc();
                if ($row['count'] == 0) {

                    $insertStmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
                    $uncategorized = 'Uncategorized';
                    $insertStmt->bind_param("s", $uncategorized);
                    $insertStmt->execute();
                    $insertStmt->close();
                }
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Category deleted successfully'
                ];
            } else {
                $_SESSION['message'] = [
                    'type' => 'danger',
                    'text' => 'Failed to delete category'
                ];
            }

            $stmt->close();
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'warning',
            'text' => 'Invalid category ID'
        ];
    }

    header('Location: show-category');
    exit;
}
