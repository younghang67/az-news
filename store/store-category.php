<?php
require_once ROOT . '/link/connect.php';

if (isLoggedIn()) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = trim($_POST['name']);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $name = strtolower($name);
        $nameSlug = explode(" ", $name);
        $nameSlug = implode("-", $nameSlug);
        $description = trim($_POST['description']);
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

        if (!empty($name)) {
            $check = $conn->prepare("SELECT id FROM categories WHERE name = ?");
            $check->bind_param("s", $name);
            $check->execute();
            $check->store_result();

            if ($check->num_rows == 0) {
                $stmt = $conn->prepare("INSERT INTO categories (name , slug, description) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $nameSlug, $description);
                if ($stmt->execute()) {
                    $_SESSION['message'] = ['type' => 'success', 'text' => 'Category added.'];
                    $stmt->close();
                    $conn->close();
                    header("Location: show-category");
                    exit();
                } else {
                    echo "Error inserting category.";
                }
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Category already exists.'];
                header("Location: show-category");
                exit();
            }

            $check->close();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Category name is required.'];
            header("Location: show-category");
            exit();
        }
    }

} else {
    header('location: home');
    exit;
}

