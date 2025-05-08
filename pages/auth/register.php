<?php
$pageTitle = 'Register';
require_once ROOT . '/partials/auth/header.php';
?>

<main class="container mt-5">
    <?php
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        echo "<div class='alert alert-{$message['type']}'>{$message['text']}</div>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Register</h3>
                        <form action="registration-validation" method="post">
                            <div class="mb-4">
                                <label for="name" class="form-label">name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="password-container">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <a class="toggle-password" onclick="togglePassword('password', event)"><i
                                            class="bi bi-eye"></i> </a>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <div class="d-flex password-container">
                                    <input type="password" class="form-control " id="confirmPassword"
                                        name="confirmPassword" required>
                                    <a class="toggle-password" onclick="togglePassword('confirmPassword', event)">
                                        <i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-center">
                                <button type="submit" class=" btn btn-primary px-5 py-2">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php require_once ROOT . '/partials/auth/footer.php' ?>