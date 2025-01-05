<?php
$pdo = new PDO('mysql:host=localhost;dbname=republika', 'root', '');

$accser = $_POST['accommodation_service'];
$checkinDate = $_POST['checkinDate'];
$checkoutTime = $_POST['checkoutTime'];
$adults = (int)$_POST['adults'];
$children = (int)$_POST['children'];
$totalGuests = (int)$_POST['totalGuests'];

$query = $pdo->prepare("
    SELECT * FROM accommodations 
    WHERE type = :accser
    ORDER BY 
        CASE 
            WHEN capacity = :totalGuests THEN 0
            WHEN capacity > :totalGuests THEN 1
            ELSE 2
        END ASC, 
        capacity ASC
");
$query->execute([
    ':accser' => $accser,
    ':totalGuests' => $totalGuests
]);

$results = $query->fetchAll(PDO::FETCH_ASSOC);

$dateTime = ['checkinDate' => $checkinDate, 'checkoutTime' => $checkoutTime];
$guests = ['totalGuests' => $totalGuests, 'adults' => $adults, 'children' => $children];

echo json_encode(['results' => $results, 'dateTime' => $dateTime, 'guests' => $guests]);
?>