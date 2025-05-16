<?php

require_once ROOT . ('/link/connect.php');

$postId = null;
$postDetail = null;

if (isset($_GET['post_id'])) {
    $postId = (int) $_GET['post_id'];

    $sql = "SELECT posts.title, posts.content, posts.status, posts.updated_at,
               categories.name AS category_name,
               users.name AS author_name
        FROM posts
        JOIN categories ON posts.category_id = categories.id
        JOIN users ON posts.user_id = users.id
        WHERE posts.id = $postId
        LIMIT 1";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $postDetail = $result->fetch_assoc();
    } else {
        echo "<p>Post not found.</p>";
    }
}
if (isset($_GET['post_id'])) {
    $pageTitle = $postDetail['title'];
} else {
    $pageTitle = "News";
}

require_once ROOT . ('/partials/header.php');

?>

<?php if ($postDetail): ?>
    <header class="article-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="article-meta">
                        <span class="article-category"><?= htmlspecialchars($postDetail['category_name']) ?></span>
                        <span><?= date('m-d-Y', strtotime($postDetail["updated_at"])) ?></span>

                    </div>
                    <h1 class="article-title"><?= htmlspecialchars($postDetail['title']) ?></h1>
                    <div class="article-author">
                        <img src="https://g-btuwypcnlte.vusercontent.net/placeholder.svg?height=50&width=50" alt="Author"
                            class="author-image">
                        <div>
                            <p class="author-name"></strong> <?= htmlspecialchars($postDetail['author_name']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <img src="https://g-btuwypcnlte.vusercontent.net/placeholder.svg?height=500&width=800"
                    alt="AI in everyday life" class="article-featured-image">
                <div class="article-content">
                    <p>
                        <?= nl2br(htmlspecialchars($postDetail['content'])) ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
<?php else: ?>
    <div class="container mx-auto mt-4">
        <h2>Please choose a News</h2>
    </div>
<?php endif; ?>