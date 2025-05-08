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
                    <a href="#news" class="btn btn-sm btn-outline-dark" data-tab="news-tab">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="article.html" class="article-title">The Future of Artificial Intelligence
                                        in Everyday Life</a></td>
                                <td>Technology</td>
                                <td>Sarah Johnson</td>
                                <td>May 5, 2025</td>
                                <td><span class="status-badge status-published">Published</span></td>
                                <td>1,245</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="article-title">Global Markets Respond to New Economic
                                        Policies</a></td>
                                <td>Business</td>
                                <td>Robert Chen</td>
                                <td>May 5, 2025</td>
                                <td><span class="status-badge status-published">Published</span></td>
                                <td>982</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="article-title">Researchers Discover New Species in Amazon
                                        Rainforest</a></td>
                                <td>Science</td>
                                <td>Maria Garcia</td>
                                <td>May 4, 2025</td>
                                <td><span class="status-badge status-published">Published</span></td>
                                <td>756</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="article-title">The Impact of Climate Change on Global
                                        Agriculture</a></td>
                                <td>Environment</td>
                                <td>James Wilson</td>
                                <td>May 3, 2025</td>
                                <td><span class="status-badge status-draft">Draft</span></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="article-title">New Study Reveals Benefits of Intermittent
                                        Fasting</a></td>
                                <td>Health</td>
                                <td>Emily Parker</td>
                                <td>May 2, 2025</td>
                                <td><span class="status-badge status-review">Under Review</span></td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?php require_once ROOT . '/partials/auth/footer.php' ?>