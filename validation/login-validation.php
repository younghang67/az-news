<?php
require_once ROOT . '/link/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['loginMessage'] = ['type' => 'danger', 'text' => 'Invalid email format.'];
        header("Location: /login.php");
        exit();
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loginMessage'] = ['type' => 'success', 'text' => 'Login successful.'];
            $_SESSION['user'] = [
                'name' => $user['name'],
                'email' => $user['email']
            ];
            header("Location: dashboard");
            $stmt->close();
            $conn->close();
            exit();
        } else {
            $_SESSION['loginMessage'] = ['type' => 'danger', 'text' => 'Incorrect password.'];
            header("Location: login");
            $stmt->close();
            $conn->close();
            exit();
        }
    } else {
        $_SESSION['loginMessage'] = ['type' => 'danger', 'text' => 'Email not found.'];
        header("Location: login");
        $stmt->close();
        $conn->close();
        exit();
    }

} else {
    $_SESSION['loginMessage'] = ['type' => 'danger', 'text' => 'Please fill in all fields.'];
    header("Location: login");
    $stmt->close();
    $conn->close();
    exit();
}

?>