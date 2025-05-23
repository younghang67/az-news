<?php
require_once ROOT . ('/link/connect.php');
$pageTitle = "AZ News";
require_once ROOT . ('/partials/header.php');

$categoryId = null;
$currentPostStatus = 'published';
$posts = [];

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

if (!isset($_GET['category_id'])) {
    $allPostsQuery = "SELECT posts.*, categories.name AS category_name
    FROM posts
    JOIN categories ON posts.category_id = categories.id WHERE posts.status = '$currentPostStatus'";
    $allPostsResult = $conn->query($allPostsQuery);
    
    if ($allPostsResult && $allPostsResult->num_rows > 0) {
        while ($postRow = $allPostsResult->fetch_assoc()) {
            $posts[] = $postRow;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include ROOT . '/validation/news-filter-public.php';
        if ($allPostsResult && $allPostsResult->num_rows > 0) {
            $posts = $allPostsResult->fetch_all(MYSQLI_ASSOC);
        }
    }
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
<?php if (empty($categoryId)): ?>
    <section class="filter-section">
        <div class="container">
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
                        <select class="form-select" name="sort_by">
                            <option value="" selected>Sort By</option>
                            <option value="DESC">Newest First</option>
                            <option value="ASC">Oldest First</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search articles...">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn bg-dark text-white btn-outline-dark w-100">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
<?php endif; ?>

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