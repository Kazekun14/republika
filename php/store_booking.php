<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'] ?? '';
    $username = $_POST['username'] ?? '';
    $flname = $_POST['flname'] ?? '';
    $email = $_POST['email'] ?? '';
    $chckIn = $_POST['chckIn'] ?? '';
    $timeIn = $_POST['timeIn'] ?? '';
    $chckOut = $_POST['chckOut'] ?? '';
    $timeOut = $_POST['timeOut'] ?? '';
    $guestcount = (int)$_POST['guestcount'] ?? '';

    if (empty($flname) || empty($email) || empty($chckIn) || empty($guestcount)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input. Please fill in all fields.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM accommodations WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $acc = $result->fetch_assoc();
        $accname = $acc['name'];
        $accprice = $acc['price'];

        $stmt = $conn->prepare("INSERT INTO booking_record (username, full_name, email, check_in_date, check_in_time, check_out_date, check_out_time, guest_count, accommodation_name, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssd", $username, $flname, $email, $chckIn, $timeIn, $chckOut, $timeOut, $guestcount, $accname, $accprice);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT * FROM booking_record WHERE 
        full_name = ? AND 
        email = ? AND 
        check_in_date = ? AND 
        check_in_time = ? AND 
        check_out_date = ? AND 
        check_out_time = ? AND 
        guest_count = ? AND 
        accommodation_name = ? AND 
        total_price = ?");

        $stmt->bind_param("ssssssisd", $flname, $email, $chckIn, $timeIn, $chckOut, $timeOut, $guestcount, $accname, $accprice);
        $stmt->execute();
        $result = $stmt->get_result();

        $ubdata = $result->fetch_assoc();

        $daccname = $ubdata['accommodation_name'];
        $dflname = $ubdata['full_name'];
        $demail = $ubdata['email'];
        $dchckin = $ubdata['check_in_date'];
        $dtimein = $ubdata['check_in_time'];
        $dchckout = $ubdata['check_out_date'];
        $dtimeout = $ubdata['check_out_time'];
        $dguests = $ubdata['guest_count'];
        $dprice = $ubdata['total_price'];

        $bdata = ['accommodation' => $daccname, 'fullname' => $dflname, 'email' => $demail, 'checkin' => $dchckin, 'timein' => $dtimein, 'checkout' => $dchckout, 'timeout' => $dtimeout, 'guests' => $dguests, 'price' => $dprice]; 

        echo json_encode(['success' => true, 'message' => 'Booking saved successfully', 'bdata' => $bdata]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Accommodation not found']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
