<?php
$catId = $_GET['category_id'];

$pageTitle = "edit-category";
require_once ROOT . '/partials/auth/header.php';
require_once ROOT . '/link/connect.php';

$sql = "SELECT * FROM categories WHERE id = $catId";
$result = $conn->query($sql);
if ($catId == 1) {
    $_SESSION['message'] = [
        'type' => 'warning',
        'text' => 'Uncategorized cannot be edited'
    ];
    header('location: show-category');
    exit;
}
if ($result->num_rows == 0) {
    $_SESSION['message'] = [
        'type' => 'warning',
        'text' => 'Category Not found'
    ];
    header('location: show-category');
    exit;
}
$result = $result->fetch_assoc();
?>
<div class="dashboard-container">
    <?php require_once ROOT . '/partials/auth/sidebar.php' ?>
    <div class="main-content" id="main-content">
        <div class="tab-content active" id="category-tab">
            <div class="content-card">
                <div class="content-header">
                    <h5 class="content-title">Categories</h5>
                    <a href="show-category" class="btn btn-sm btn-dark"> All Category</a>
                </div>
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message']['type'] ?>">
                        <?= htmlspecialchars($_SESSION['message']['text']) ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif ?>
                <div class="row">
                    <form id="categoryForm" action="update-category" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= htmlspecialchars($result["name"]); ?>" placeholder="Enter category name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="Enter category descriptions" rows="3"> <?php if (!empty($result["description"])) {
                                    echo trim(htmlspecialchars($result["description"]));
                                } ?></textarea>
                        </div>
                        <input type="hidden" value="<?= $result['id'] ?>" name="cat_id">
                        <button type="submit" form="categoryForm" class="btn btn-dark">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT . '/partials/auth/category-modal.php' ?>

<?php require_once ROOT . '/partials/auth/footer.php'; ?>