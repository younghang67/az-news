<?php
global $pageTitle;
$pageTitle = "Add Category";
require_once ROOT . '/partials/auth/header.php';
?>

<main class="container mx-auto mt-5">
    <h2>Add Category</h2>
    <p class="text-muted">Add a new category.</p>
    <?php if (isset($_SESSION['message']) && $_SESSION['message']['type'] === 'error'): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['message']['text']) ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif ?>
    <form action="store/store-category.php" method="POST">
        <div>
            <label for="name" class="form-label">Category Name</label>
            <input type="text" id="category_name" class="form-control" name="name" required>
        </div>
        <button type="submit" class="mt-4 btn btn-primary">Upload</button>
    </form>
</main>

<?php
require_once ROOT . '/partials/auth/footer.php';
?>