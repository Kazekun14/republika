<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usrname = $_POST['username'] ?? '';
    $fname = $_POST['fullname'] ?? '';
    $eml = $_POST['email'] ?? '';
    $adrs = $_POST['address'] ?? '';
    $dte = $_POST['date'] ?? '';
    $tim = $_POST['time'] ?? '';
    $gsts = (int)$_POST['guests'] ?? '';
    $srvcname = $_POST['servicename'] ?? '';
    $srvcprice = $_POST['serviceprice'] ?? '';

    if (empty($fname) || empty($eml) || empty($dte) || empty($gsts)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input. Please fill in all fields.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO reservation_record (username, full_name, email, address, date, time, guests, service_name, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssisd", $usrname, $fname, $eml, $adrs, $dte, $tim, $gsts, $srvcname, $srvcprice);
    $stmt->execute();

    $rsrvdata = ['fullname' => $fname, 'email' => $eml, 'address' => $adrs, 'date' => $dte, 'time' => $tim, 'guests' => $gsts, 'servicename' => $srvcname, 'serviceprice' => $srvcprice];

    echo json_encode(['success' => true, 'message' => 'Reservation saved successfully', 'rsrvdata' => $rsrvdata]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
