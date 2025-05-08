<?php
require_once ROOT . '/link/connect.php';
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

?>
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
                    <div>
                        <h6 class="category-name"><?= htmlspecialchars($row["name"]) ?></h6>
                        <p class="category-count">42 articles</p>
                    </div>
                    <div>
                        <form action="" method="POST" class="d-inline-block">
                            <input type="hidden" value="<?= htmlspecialchars($row["id"]) ?>" name="category_id">
                            <button style="all: unset;cursor: pointer;" class="me-1" type="submit"><i
                                    class="bi bi-pencil-square action-icon edit"></i></button>
                        </form>

                        <form action="delete-category" method="POST" class="d-inline-block">
                            <input type="hidden" value="<?= htmlspecialchars($row["id"]) ?>" name="category_id">
                            <button style="all: unset;cursor: pointer;" type="submit" class="me-1"><i
                                    class="bi bi-trash action-icon delete"></i></button>
                        </form>
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