<?php
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$base = '/az-news';
$path = str_replace($base, '', $request);

switch ($path) {
    case '/':
    //----------------------------------------------------------------------------------- front end
    case '/home':
        require ROOT . '/pages/home.php';
        break;

    case '/category':
        require ROOT . '/pages/show-category.php';
        break;

    case '/post':
        require ROOT . '/pages/single-post.php';
        break;

    case '/news/category':
        require ROOT . '/pages/archive.php';
        break;

    case '/news':
        require ROOT . '/pages/archive.php';
        break;

    //----------------------------------------------------------------------------------- validation && store
    case '/login-validation':
        require ROOT . '/validation/login-validation.php';
        break;

    case '/registration-validation':
        require ROOT . '/store/store-user.php';
        break;

    case '/cateogry-validation':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/store/store-category.php';
        break;

    case '/news-validation':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/store/store-news.php';
        break;


    //----------------------------------------------------------------------------------- delete && update
    case '/edit-category':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/pages/edit/category-edit.php';

        break;
    case '/update-category':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/update/update-category.php';
        break;

    case '/delete-category':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/validation/delete-category.php';
        break;

    case '/delete-news':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/validation/delete-news.php';
        break;

    case '/edit-news':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/pages/edit/news-edit.php';
        break;

    case '/update-news':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/update/update-news.php';
        break;


    //----------------------------------------------------------------------------------- authentication
    case '/sign-up':
        require ROOT . '/pages/auth/register.php';
        break;

    case '/admin':
        require ROOT . '/pages/auth/login.php';
        break;

    case '/logout':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/pages/auth/logout.php';
        break;

    case '/dashboard':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/pages/auth/dashboard.php';
        break;

    case '/add-news':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/pages/create/add-news.php';
        break;

    case '/show-news':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/pages/auth/show-news.php';
        break;

    case '/show-category':
        if (!isLoggedIn()) {
            header('Location: page-not-found');
            exit;
        }
        require ROOT . '/pages/auth/show-category.php';
        break;

    case '/page-not-found':
        require ROOT . '/404.php';
        break;


    //--------------------------------------------------------------------------------- database
    case '/migrate':
        require ROOT . '/database/migration.php';
        break;

    case '/migrate-fresh':
        require ROOT . '/database/migrate-fresh.php';
        break;

    case '/seeding':
        require ROOT . '/database/seeding.php';
        break;
    //----------------------------------------------------------------------------------- filter
    case '/news-filter':
        require ROOT . '/validation/news-filter.php';
        break;

    default:
        http_response_code(404);
        require ROOT . '/404.php';
        break;
}
