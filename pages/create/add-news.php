<?php
$pageTitle = "Create Articles";
require_once ROOT . '/partials/auth/header.php';
require_once ROOT . '/link/connect.php';

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

$sqlStatus = "SHOW COLUMNS FROM posts LIKE 'status'";
$resultStatus = $conn->query($sqlStatus);

$options = [];

if ($resultStatus) {
    $row = $resultStatus->fetch_assoc();
    $enumString = $row['Type'];

    preg_match("/^enum\('(.*)'\)$/", $enumString, $matches);
    if (isset($matches[1])) {
        $options = explode("','", $matches[1]);
    }
}
?>

<div class="dashboard-container">
    <?php require_once ROOT . '/partials/auth/sidebar.php' ?>

    <div class="main-content" id="main-content">
        <div class="dashboard-header">
            <button class="toggle-sidebar" id="toggle-sidebar">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="dashboard-title">News</h4>
        </div>
        <div class="content-header">
            <h5 class="content-title">Create Articles</h5>
            <a href="show-news" class="btn btn-sm btn-dark">
                Show All Article
            </a>
        </div>

        <?php if (isset($_SESSION['message']) && $_SESSION['message']['type'] === 'error'): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['message']['text']) ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif ?>

        <div class="content-card">
            <div class="news-tab-content active">
                <form action="news-validation" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700  fw-bold mb-2">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-gray-700  fw-bold mb-2">Category</label>
                        <select id="category" name="category" class="form-control" required>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row["id"]) ?>" <?php if ($row["id"] == 1):
                                          echo 'selected';
                                      endif; ?>> <?= htmlspecialchars($row["name"]) ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="" disabled>No categories available</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700  fw-bold mb-2">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <?php foreach ($options as $option): ?>
                                <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-gray-700  fw-bold mb-2">Content:</label>
                        <textarea id="content" name="content" rows="4" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-dark px-5">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT . '/partials/auth/footer.php' ?>