<?php
$pageTitle = 'Dashboard';
require_once ROOT . ('/partials/auth/header.php');
require_once ROOT . ('/link/connect.php');

$sql = "SELECT status, COUNT(*) AS count FROM posts GROUP BY status";
$result = $conn->query($sql);

$statusCounts = [
    'published' => 0,
    'draft' => 0,
    'archived' => 0
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusCounts[$row['status']] = (int) $row['count'];
    }
}

$recentPostSql = "
    SELECT p.title, c.name AS category, u.name AS author, p.created_at AS date
    FROM posts p
    JOIN categories c ON p.category_id = c.id
    JOIN users u ON p.user_id = u.id
    WHERE p.status = 'published'
";

$recentPostResutl = $conn->query($recentPostSql);
?>

<div class="dashboard-container">
    <?php require_once ROOT . '/partials/auth/sidebar.php' ?>

    <div class="main-content" id="main-content">
        <?php require_once ROOT . ('/partials/auth/dashboard-header.php'); ?>

        <div class="tab-content active">
            <div class="row g-4 mb-4">

                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-icon green">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <div class="stats-value"><?= $statusCounts['published'] ?></div>
                        <div class="stats-label">Published Articles</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-icon green">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <div class="stats-value"><?= $statusCounts['draft'] ?></div>
                        <div class="stats-label">Draft Articles</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-icon green">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <div class="stats-value"><?= $statusCounts['archived'] ?></div>
                        <div class="stats-label">Archived Articles</div>
                    </div>
                </div>

            </div>

            <!-- Recent Articles -->
            <div class="content-card">
                <div class="content-header">
                    <h5 class="content-title">Recent Articles</h5>
                    <a href="show-news" class="btn btn-sm btn-outline-dark" data-tab="news-tab">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($recentPostResutl->num_rows > 0) { ?>
                                <?php while ($row = $recentPostResutl->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['title']; ?></td>
                                        <td><?= $row['category']; ?></td>
                                        <td><?= $row['author']; ?></td>
                                        <td><?= date('M d Y', strtotime($row["date"])) ?></td>
                                    </tr>
                                <?php endwhile;
                            } else { ?>
                                <tr>
                                    <td colspan="4">
                                        <p>No Posts to retrieve</p>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?php require_once ROOT . '/partials/auth/footer.php' ?>