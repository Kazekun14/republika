<?php
require '../php/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mUsername']) && isset($_POST['mPassword']) && isset($_POST['mRepassword'])) {
    $Managerusername = $_POST['mUsername'];
    $password = $_POST['mPassword'];
    $repassword = $_POST['mRepassword'];

    if ($password !== $repassword) {
        echo "<script>alert('Password and confirm password do not match.');</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $Managerusername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Account already exists. Please use a different username.');</script>";
        exit;
    }

    $user_type="manager";

    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
    $stmt = $conn->prepare("INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $Managerusername, $hashedPassword, $user_type);
    $result = $stmt->execute();

    if ($result) {
        echo "<script>alert('Registration successful! " . $Managerusername . " can now manage records and facilitate bookings.');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}
?>