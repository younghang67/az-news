<?php
require_once ROOT . ('/link/connect.php');
$pageTitle = "AZ News";
require_once ROOT . ('/partials/header.php');

$currentCategoryId = null;
$currentPostStatus = 'published';
$posts = [];

$availableCategories = [];
$categoryQueryResult = $conn->query("SELECT id, name FROM categories");
if ($categoryQueryResult && $categoryQueryResult->num_rows > 0) {
    while ($categoryRow = $categoryQueryResult->fetch_assoc()) {
        $availableCategories[] = $categoryRow;
    }
}

$statusQuery = "SHOW COLUMNS FROM posts LIKE 'status'";
$statusQueryResult = $conn->query($statusQuery);
$availableStatuses = [];
if ($statusQueryResult) {
    $statusRow = $statusQueryResult->fetch_assoc();
    preg_match("/^enum\('(.*)'\)$/", $statusRow['Type'], $statusMatches);
    if (isset($statusMatches[1])) {
        $availableStatuses = explode("','", $statusMatches[1]);
    }
}

if (isset($_GET['category_id'])) {
    $currentCategoryId = (int) $_GET['category_id'];
    $postQuery = "SELECT posts.*, 
                categories.id AS category_id, 
                categories.name AS category_name, 
                categories.slug AS category_slug, 
                categories.description AS category_description
                FROM posts 
                JOIN categories ON posts.category_id = categories.id 
                WHERE posts.category_id = $currentCategoryId AND posts.status = '$currentPostStatus'";

    $postQueryResult = $conn->query($postQuery);

    if ($postQueryResult && $postQueryResult->num_rows > 0) {
        while ($postRow = $postQueryResult->fetch_assoc()) {
            $posts[] = $postRow;
        }
    }

    $categoryInfoQuery = "SELECT name, description, slug FROM categories WHERE id = $currentCategoryId";
    $categoryInfoResult = $conn->query($categoryInfoQuery);
    $currentCategoryInfo = $categoryInfoResult->fetch_assoc();

} else {
    echo "Please enter category";
}
?>



<header class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">
                    <?php
                    if (empty($categoryId)):
                        echo "All News";
                    else:
                        echo $categoryInfo['name'];
                    endif;
                    ?>
                </h1>
                <p class="mt-3">
                    <?php
                    if (empty($categoryId)):
                        echo "All news to keep you up to date";
                    else:
                        echo $categoryInfo['description'];
                    endif;
                    ?>
                </p>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-decoration-none text-dark">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php
                            if (empty($categoryId)):
                                echo "All New";
                            else:
                                echo htmlspecialchars($categoryInfo['name']);
                            endif;

                            ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</header>


<section class="mt-4 news-list-view list-view">
    <div class="container">
        <?php
        if ($result->num_rows > 0):
            foreach ($posts as $post):
                ?>
                <div class="news-item">
                    <img src="<?= defaultImg(); ?>/placeholder.svg?height=180&width=250" class="news-image" alt="News image">
                    <div class="news-content">
                        <div class="article-meta">
                            <span class="article-category"><?= $post['category_name']; ?></span>
                        </div>
                        <h3 class="news-title"><?= $post['title']; ?></h3>
                        <p class="news-excerpt"><?= limit_words($post['content'], 30); ?></p>
                        <a href="<?= baseURL() ?>/post?post_id=<?= $post['id']; ?>"
                            class="text-dark fw-bold text-decoration-none">Read more →</a>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        <?php else: ?>
            <div class="news-item p-5 text-mute">
                <h3>Sorry No news to show</h3>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once ROOT . ('/partials/footer.php'); ?>