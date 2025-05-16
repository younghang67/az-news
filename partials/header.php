<?php
$url = explode("/", $_SERVER['SCRIPT_NAME']);
$active = end($url);
function active($pageName)
{
    global $active;
    if ($active == $pageName) {
        return 'active';
    } else {
        return '';
    }
}

require_once ROOT . ('/link/connect.php');

$sql = " SELECT * FROM categories WHERE id != 1 LIMIT 6";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    $categories = $result->fetch_all(MYSQLI_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?php echo './public/favicon-3.ico' ?>">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Default Title'; ?></title>
    <link rel="stylesheet" href="<?= baseURL() ?>/public/css/index.css">
    <link rel="stylesheet" href="<?= baseURL() . '/public/css/listing.css' ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand" href="home">AZ NEWS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= baseURL() ?>/home">Home</a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= baseURL() ?>/news/category?category_id=<?= $category['id']; ?>"><?= $category['name'] ?></a>
                        </li>
                    <?php endforeach; ?>
                    <?php
                    if (isLoggedIn()) { ?>
                        <li><a href="dashboard" class="btn btn-primary">admin</a></li>
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
    </nav>