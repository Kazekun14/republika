<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['cfrmPassword'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['cfrmPassword'];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Password and confirm password do not match.');</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('User already exists.');</script>";
        exit;
    }

    $user_type = "customer";

    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
    $stmt = $conn->prepare("INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $user_type);
    $result = $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND user_type = ?");
    $stmt->bind_param("ss", $username, $user_type);
    $stmt->execute();
    $session = $stmt->get_result();

    $user = $session->fetch_assoc();

    $_SESSION['r_username'] = $user['username'];
    $_SESSION['r_avatar'] = '360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg';

    if ($result) {
        echo "<script>alert('Registration successful! Update your profile to save your information, access your records, and make future bookings and reservations more convenient.');</script>";
        echo "<script>window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password']) && !isset($_POST['cfrmPassword'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = "customer";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND user_type = ?");
    $stmt->bind_param("ss", $username, $user_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('User does not exist.');</script>";
        exit;
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        echo "<script>alert('Incorrect password.');</script>";
        exit;
    }

    $_SESSION['r_username'] = $user['username'];
    $_SESSION['r_avatar'] = $user['avatar'] ?? '../img/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg';

    echo "<script>alert('You are logged in!');</script>";
    echo "<script>window.location.href='../index.php';</script>";
}

$conn->close();
?>
