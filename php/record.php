<?php
$pdo = new PDO('mysql:host=localhost;dbname=republika', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = $_POST['username'];

	$query = $pdo->prepare("SELECT * FROM booking_record WHERE username = :username");
	$query->execute([':username' => $username]);

	$bResults = $query->fetchAll(PDO::FETCH_ASSOC);

	$query = $pdo->prepare("SELECT * FROM reservation_record WHERE username = :username");
	$query->execute([':username' => $username]);

	$rResults = $query->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode(['bResults' => $bResults, 'rResults' => $rResults]);
}
?>