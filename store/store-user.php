<?php
require_once ROOT . '/link/connect.php';

if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirmPassword'])
) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    if ($password !== $confirmPassword) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Passwords do not match.'];
        header("Location: sign-up");
        $conn->close();
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Invalid email format.'];
        header("Location: sign-up");
        $conn->close();
        exit();
    }
    if (strlen($password) < 8) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Password must be at least 8 characters long.'];
        header("Location: sign-up");
        $conn->close();
        exit();
    }


    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Email already exists.'];
        $stmt->close();
        header("Location: sign-up");
        $conn->close();
        exit();
    }
    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['user'] = [
            'tempEmail' => $email
        ];
        $stmt->close();
        header("Location: admin");
        $conn->close();
        exit();
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Registration failed.'];
        $stmt->close();
        header("Location: sign-up");
        $conn->close();
        exit();
    }
} else {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Please fill in all fields.'];
    header("Location: sign-up");
    $conn->close();
    exit();
}

