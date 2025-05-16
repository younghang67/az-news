<?php
require_once ROOT . '/partials/auth/header.php';
require_once ROOT . '/link/connect.php';
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

?>
<div class="dashboard-container">
    <?php require_once ROOT . '/partials/auth/sidebar.php' ?>
    <div class="main-content" id="main-content">
        <?php require_once ROOT . ('/partials/auth/dashboard-header.php'); ?>
        <div class="tab-content active" id="category-tab">
            <div class="content-card">
                <div class="content-header">
                    <h5 class="content-title">All Categories</h5>
                    <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="bi bi-plus-lg me-1"></i> Add Category
                    </button>
                </div>
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message']['type'] ?>">
                        <?= htmlspecialchars($_SESSION['message']['text']) ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif ?>
                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-md-6">
                                <div class="category-card">
                                    <div class="w-100">
                                        <div class="w-100 d-flex mb-3">
                                            <h6 class="category-name flex-grow-1"><?= htmlspecialchars($row["name"]) ?></h6>
                                            <?php if ($row["id"] != 1): ?>
                                                <div>
                                                    <form action="edit-category" method="GET" class="d-inline-block">
                                                        <input type="hidden" value="<?= htmlspecialchars($row["id"]) ?>"
                                                            name="category_id">
                                                        <button data-bs-toggle="modal" data-bs-target="#addCategoryModal"
                                                            class="me-1 no-style" type="submit"><i
                                                                class="bi bi-pencil-square action-icon edit"></i></button>
                                                    </form>

                                                    <form action="delete-category" method="POST" class="d-inline-block">
                                                        <input type="hidden" value="<?= htmlspecialchars($row["id"]) ?>"
                                                            name="category_id">
                                                        <button type="submit" class="me-1 no-style"><i
                                                                class="bi bi-trash action-icon delete"></i></button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <p><?= limit_words($row['description'], 15) ?></p>
                                    </div>

                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-md-12">
                            <div class="category-card">
                                <div>
                                    <h6 class="category-name"> Categoires Empty </h6>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT . '/partials/auth/category-modal.php' ?>

<?php require_once ROOT . '/partials/auth/footer.php'; ?>