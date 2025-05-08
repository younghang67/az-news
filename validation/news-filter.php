<?php
require_once ROOT . '/link/connect.php';

$category = $_POST['category'] ?? '';
$status = $_POST['status'] ?? '';
if ($_POST['sort_by'] === "ASC") {
    $sort = $_POST['sort_by'];
} else {
    $sort = 'DESC';
}
$search = trim($_POST['search'] ?? '');

$sql = "
    SELECT posts.*, categories.name AS category_name 
    FROM posts 
    JOIN categories ON posts.category_id = categories.id 
    WHERE 1=1
";

$params = [];
$types = '';

if ($category !== '') {
    $sql .= " AND posts.category_id = ?";
    $types .= 'i';
    $params[] = $category;
}

if ($status !== '') {
    $sql .= " AND posts.status = ?";
    $types .= 's';
    $params[] = $status;
}

if ($search !== '') {
    $sql .= " AND (posts.title LIKE ? OR posts.content LIKE ?)";
    $types .= 'ss';
    $like = '%' . $search . '%';
    $params[] = $like;
    $params[] = $like;
}

$sql .= " ORDER BY posts.created_at $sort";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
// header('location: show-news');
$stmt->close();

