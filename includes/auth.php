<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function login($email, $password, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function signup($email, $password, $pdo) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    return $stmt->execute(['email' => $email, 'password' => $hashedPassword]);
}

function logout() {
    session_destroy();
    header("Location: /");
    exit();
}

function getUserById($id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
