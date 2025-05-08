<?php
$pageTitle = 'Login';
if (isset($_SESSION['user']['email'])) {
    header('location: dashboard');
    exit;
}
require_once ROOT . '/partials/auth/header.php';
$email = $_SESSION['user']['tempEmail'] ?? null;
$message = $_SESSION['loginMessage'] ?? null;
?>

<main class=" items-align-center mt-5 mx-auto">
    <?php
    if ($message) {
        echo "<div class='text-center alert alert-{$message['type']}'>{$message['text']}</div>";
        unset($_SESSION['loginMessage']);
    }
    ?>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Login</h3>
                        <form action="login-validation" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;
                                unset($_SESSION['user']['tempEmail']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <span class="text-muted fs-6">
                                Not registed yet? <a href="sign-up" class="text-decoration-none"> registed</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once ROOT . '/partials/auth/footer.php'; ?>