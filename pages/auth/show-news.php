<?php
$pageTitle = "Add News";
require_once ROOT . '/partials/auth/header.php';
require_once ROOT . '/link/connect.php';

$categoryOptions = [];
$resultCategories = $conn->query("SELECT id, name FROM categories");
if ($resultCategories && $resultCategories->num_rows > 0) {
    while ($row = $resultCategories->fetch_assoc()) {
        $categoryOptions[] = $row;
    }
}

$sqlStatus = "SHOW COLUMNS FROM posts LIKE 'status'";
$resultStatus = $conn->query($sqlStatus);
$statusOptions = [];
if ($resultStatus) {
    $row = $resultStatus->fetch_assoc();
    preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches);
    if (isset($matches[1])) {
        $statusOptions = explode("','", $matches[1]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include ROOT . '/validation/news-filter.php';
} else {
    $sql = "SELECT posts.*, categories.name AS category_name 
            FROM posts 
            JOIN categories ON posts.category_id = categories.id 
            ORDER BY posts.created_at DESC";
    $result = $conn->query($sql);
}
?>

<div class="dashboard-container">
    <?php require_once ROOT . '/partials/auth/sidebar.php' ?>
    <div class="main-content" id="main-content">
        <?php require_once ROOT . ('/partials/auth/dashboard-header.php'); ?>
        <div class="content-card">
            <div class="news-tab-content active">
                <div class="content-header">
                    <h5 class="content-title">All Articles</h5>
                    <a href="add-news" class="btn btn-sm btn-dark">
                        <i class="bi bi-plus-lg me-1"></i> Create Article
                    </a>
                </div>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message']['type']; ?>">
                        <?= htmlspecialchars($_SESSION['message']['text']) ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif ?>

                <div class="all-news">
                    <div class="mb-4">
                        <form method="POST">
                            <div class="row g-2">
                                <div class="col-md-2">
                                    <select class="form-select" name="category">
                                        <option value="" selected>All Categories</option>
                                        <?php foreach ($categoryOptions as $category): ?>
                                            <option value="<?= htmlspecialchars($category['id']) ?>">
                                                <?= htmlspecialchars($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="status">
                                        <option value="" selected>All Status</option>
                                        <?php foreach ($statusOptions as $status): ?>
                                            <option value="<?= htmlspecialchars($status) ?>">
                                                <?= htmlspecialchars($status) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="sort_by">
                                        <option value="" selected>Sort By</option>
                                        <option value="DESC">Newest First</option>
                                        <option value="ASC">Oldest First</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search articles...">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-outline-dark w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <p href="#" class="article-title"><?= htmlspecialchars($row["title"]) ?></p>
                                            </td>
                                            <td><?= htmlspecialchars($row["category_name"]) ?></td>
                                            <td><?= date('Y-m-d', strtotime($row["created_at"])) ?></td>
                                            <td><span class="status-badge status-<?= htmlspecialchars($row["status"]) ?>">
                                                    <?= htmlspecialchars($row["status"]) ?></span></td>
                                            <td>
                                                <form class="d-inline-block" action="edit-news" method="GET">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row["id"]) ?>">
                                                    <button class="no-style" type="submit"><i
                                                            class="bi bi-pencil-square action-icon edit"></i></button>
                                                </form>

                                                <form class="d-inline-block" action="delete-news" method="POST">
                                                    <input type="hidden" name="news_id"
                                                        value="<?= htmlspecialchars($row["id"]) ?>">
                                                    <button class="no-style" type="submit"> <i
                                                            class="bi bi-trash action-icon delete"></i></button>
                                                </form>

                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No articles found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT . '/partials/auth/footer.php'; ?>