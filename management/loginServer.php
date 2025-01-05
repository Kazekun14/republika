<?php
session_start();
require '../php/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adminUsername']) && isset($_POST['adminPassword'])) {
	$user_type = "admin";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND user_type = ?");
    $stmt->bind_param("ss", $_POST['adminUsername'], $user_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Admin account does not exist.";
        exit;
    }

    $admin = $result->fetch_assoc();

    if (!password_verify($_POST['adminPassword'], $admin['password'])) {
        echo "Incorrect password.";
        exit;
    }

    $_SESSION['radmin_username'] = $admin['username'];
    $_SESSION['r_user_type'] = $user_type;

    echo "Welcome! Admin access confirmed.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['managerUsername']) && isset($_POST['managerPassword'])) {
    $user_type = "manager";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND user_type = ?");
    $stmt->bind_param("ss", $_POST['managerUsername'], $user_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Manager account does not exist.";
        exit;
    }

    $manager = $result->fetch_assoc();

    if (!password_verify($_POST['managerPassword'], $manager['password'])) {
        echo "Incorrect password.";
        exit;
    }

    $_SESSION['rmanager_username'] = $manager['username'];
    $_SESSION['r_user_type'] = $user_type;

    echo "Welcome! Your manager access has been confirmed.";
}
?>