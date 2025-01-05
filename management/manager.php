<?php
session_start();
require '../php/database.php';

    if (!isset($_SESSION['rmanager_username']) || $_SESSION['r_user_type'] !== 'manager') {
        header('Location: login.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT COUNT(*) AS totalBookings FROM booking_record");
    $stmt->execute();
    $stmt->bind_result($totalBookings);
    $stmt->fetch();

    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) AS totalReservations FROM reservation_record");
    $stmt->execute();
    $stmt->bind_result($totalReservations);
    $stmt->fetch();

    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) AS totalInbox FROM contact_us");
    $stmt->execute();
    $stmt->bind_result($totalInbox);
    $stmt->fetch();

    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM booking_record");
    $stmt->execute();
    $bookingResult = $stmt->get_result();

    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM reservation_record");
    $stmt->execute();
    $reservationResult = $stmt->get_result();

    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM contact_us");
    $stmt->execute();
    $contactResult = $stmt->get_result();

    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['rmanager_username']);
    $stmt->execute();
    $result = $stmt->get_result();

    $myAccountResult1 = $result->fetch_assoc();

    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['rmanager_username']);
    $stmt->execute();
    $result = $stmt->get_result();

    $myAccountResult2 = $result->fetch_assoc();

    $stmt->close();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookingDelete'])) {
        $stmt = $conn->prepare("DELETE FROM booking_record WHERE id = ?");
        $stmt->bind_param("s", $_POST['bookingDelete']);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservationDelete'])) {
        $stmt = $conn->prepare("DELETE FROM reservation_record WHERE id = ?");
        $stmt->bind_param("s", $_POST['reservationDelete']);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inboxDelete'])) {
        $stmt = $conn->prepare("DELETE FROM contact_us WHERE id = ?");
        $stmt->bind_param("s", $_POST['inboxDelete']);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/manager.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

    <div class="wrapper">
        <!--Side bar-->
        <nav id="sidebar" class="sidebar">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-black fs-2 mb-0 logo">re<font color="white">pub</font>lika</h1>
                <button class="p-0 sidebarClose" id="sidebarClose">
                    <h3>x</h3>
                </button>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link active" id="navDashboard" onclick="showContent('dashboard')">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="navMyAccount" onclick="showContent('myAccount')">
                        <i class="fa-solid fa-user-tie"></i> My Account
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="navBookings" onclick="showContent('bookings')">
                        <i class="fa-regular fa-calendar-check"></i> Bookings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="navReservations" onclick="showContent('reservations')">
                        <i class="fa-regular fa-calendar-check"></i> Reservations
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="navInbox" onclick="showContent('inbox')">
                        <i class="fa-solid fa-inbox"></i> Inbox
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid d-flex justify-content-between align-items-center headBar">
                <button class="btn btn-dark m-4 menu-toggle" id="sidebarOpen">
                    <img src="../img/hamburger_black.svg" alt="menu">
                </button>
                <h2 class="fw-bold m-4">Manager</h2>
                <button class="exit fs-2 m-4" onclick="window.location.href='exit.php';"><i class="fa-solid fa-arrow-right-to-bracket"></i></button>
            </div>
            <!--Dashboard-->
            <div class="container-fluid py-4" id="dashboard">
                <h2 class="mb-5 mt-4 ms-4">Dashboard</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card bg-success text-white rHeight" onclick="showContent('bookings')">
                            <div class="card-body">
                                <h5 class="card-title">Total Bookings</h5>
                                <h2 class="position-absolute start-50 top-50 translate-middle fs-1"><?php echo $totalBookings ?? 0?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card bg-warning text-white rHeight" onclick="showContent('reservations')">
                            <div class="card-body">
                                <h5 class="card-title">Total Reservations</h5>
                                <h2 class="position-absolute start-50 top-50 translate-middle fs-1"><?php echo $totalReservations ?? 0?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card bg-info text-white rHeight" onclick="showContent('inbox')">
                            <div class="card-body">
                                <h5 class="card-title">Inbox</h5>
                                <h2 class="position-absolute start-50 top-50 translate-middle fs-1"><?php echo $totalInbox ?? 0?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div>&#x00A9; Copyright 2025 Republika | All Rights Reserved.</div>
            </div>
            <!--My account-->
            <div class="container-fluid py-4 d-none" id="myAccount">
                <form method="POST" id="myAccountFRM" enctype="multipart/form-data">
                    <div class="container-fluid d-flex align-items-center ms-4">
                        <img src="../uploads/<?php echo $myAccountResult1['avatar'] ?? '../img/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg'; ?>" class="avatar">
                        <div class="ms-4">
                            <label for="avatar" class="d-block fs-4">Avatar</label>
                            <input type="file" class="cursor-pointer" name="avatar" id="avatar" accept="image/*">
                        </div>
                    </div>
                    <div class="container-fluid mt-4 ms-4">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="myAccountUsername" class="d-block fs-6">Username</label>
                                <input type="text" name="myAccountUsername" value="<?php echo $myAccountResult1['username'] ?? '';?>" id="myAccountUsername" class="w-100 mAccountinpt" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="myAccountFullname" class="d-block fs-6">Full name</label>
                                <input type="text" name="myAccountFullname" id="myAccountFullname" class="w-100 mAccountinpt" value="<?php echo $myAccountResult2['fullname'] ?? '';?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="myAccountEmail" class="d-block fs-6">Email</label>
                                <input type="email" name="myAccountEmail" id="myAccountEmail" class="w-100 mAccountinpt" value="<?php echo $myAccountResult2['email'] ?? '';?>" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="myAccountNumber" class="d-block fs-6">Number</label>
                                <input type="tel" name="myAccountNumber" id="myAccountNumber" class="w-100 mAccountinpt" value="<?php echo $myAccountResult2['number'] ?? '';?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="myAccountAddress" class="d-block fs-6">Address</label>
                                <input type="text" name="myAccountAddress" id="myAccountAddress" class="w-100 mAccountinpt" value="<?php echo $myAccountResult2['address'] ?? '';?>" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="myAccountDatebirth" class="d-block fs-6">Datebirth</label>
                                <input type="date" name="myAccountDatebirth" id="myAccountDatebirth" class="w-100 mAccountinpt cursor-pointer" value="<?php echo isset($myAccountResult2['datebirth']) ? htmlspecialchars($myAccountResult2['datebirth']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="myAccountGender" class="d-block fs-6">Gender</label>
                                <select name="myAccountGender" id="myAccountGender" class="w-100 mAccountinpt cursor-pointer" required>
                                    <option value="" disabled>Select an option</option>
                                    <option value="Male" <?php echo (isset($myAccountResult2['gender']) && $myAccountResult2['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (isset($myAccountResult2['gender']) && $myAccountResult2['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="ms-5 myAccountBtn">SAVE CHANGES</button>
                </form>
                <div class="ms-5 my-4">&#x00A9; Copyright 2025 Republika | All Rights Reserved.</div>
            </div>
            <!--Bookings-->
            <div class="container-fluid py-4 d-none" id="bookings">
                <h2 class="mb-5 mt-4 ms-4">Bookings</h2>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark align-middle">
                            <tr>
                                <th class="text-center">Username</th>
                                <th class="text-center">Full Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Check-in Date</th>
                                <th class="text-center">Check-in Time</th>
                                <th class="text-center">Check-out Date</th>
                                <th class="text-center">Check-out Time</th>
                                <th class="text-center">Guest Count</th>
                                <th class="text-center">Accommodation Name</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($bookingResult->num_rows > 0) {
                                while ($row = $bookingResult->fetch_assoc()) {
                                    $check_in_date = date('F j, Y', strtotime($row['check_in_date']));
                                    $check_out_date = date('F j, Y', strtotime($row['check_out_date']));
                                    echo "<tr>";
                                    echo "<td class='text-center'>{$row['username']}</td>";
                                    echo "<td class='text-center'>{$row['full_name']}</td>";
                                    echo "<td class='text-center'>{$row['email']}</td>";
                                    echo "<td class='text-center'>{$check_in_date}</td>";
                                    echo "<td class='text-center'>{$row['check_in_time']}</td>";
                                    echo "<td class='text-center'>{$check_out_date}</td>";
                                    echo "<td class='text-center'>{$row['check_out_time']}</td>";
                                    echo "<td class='text-center'>{$row['guest_count']}</td>";
                                    echo "<td class='text-center'>{$row['accommodation_name']}</td>";
                                    echo "<td class='text-center'>{$row['total_price']}</td>";
                                    echo "<td class='d-flex'>";
                                    echo "<form method='POST'><button class='btn btn-danger btn-sm' name='bookingDelete' value='" . $row['id'] . "'><i class='bi bi-trash'></i> Delete</button></form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>&#x00A9; Copyright 2025 Republika | All Rights Reserved.</div>
            </div>
            <!--Reservations-->
            <div class="container-fluid py-4 d-none" id="reservations">
                <h2 class="mb-5 mt-4 ms-4">Reservations</h2>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark align-middle">
                            <tr>
                                <th class="text-center">Username</th>
                                <th class="text-center">Full Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Guests</th>
                                <th class="text-center">Service Name</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($reservationResult->num_rows > 0) {
                                while ($row = $reservationResult->fetch_assoc()) {
                                    $date = date('F j, Y', strtotime($row['date']));
                                    echo "<tr>";
                                    echo "<td class='text-center'>{$row['username']}</td>";
                                    echo "<td class='text-center'>{$row['full_name']}</td>";
                                    echo "<td class='text-center'>{$row['email']}</td>";
                                    echo "<td class='text-center'>{$row['address']}</td>";
                                    echo "<td class='text-center'>{$date}</td>";
                                    echo "<td class='text-center'>{$row['time']}</td>";
                                    echo "<td class='text-center'>{$row['guests']}</td>";
                                    echo "<td class='text-center'>{$row['service_name']}</td>";
                                    echo "<td class='text-center'>{$row['total_price']}</td>";
                                    echo "<td class='d-flex'>";
                                    echo "<form method='POST'><button class='btn btn-danger btn-sm' name='reservationDelete' value='" . $row['id'] . "'><i class='bi bi-trash'></i> Delete</button></form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>&#x00A9; Copyright 2025 Republika | All Rights Reserved.</div>
            </div>
            <!--inbox-->
            <div class="container-fluid py-4 d-none" id="inbox">
                <h2 class="mb-5 mt-4 ms-4">Inbox</h2>
                <div class="row">
                    <?php if ($contactResult->num_rows > 0) : ?>
                        <?php while ($contact = $contactResult->fetch_assoc()) : ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <?php echo htmlspecialchars($contact['subject']); ?>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($contact['name']); ?> <?php echo htmlspecialchars($contact['username']); ?></h5>
                                        <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
                                        <p class="card-text"><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($contact['description'])); ?></p>

                                        <form method="POST"><button class="btn btn-danger" name="inboxDelete" value="<?php echo $contact['id'];?>">Delete</button></form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>No contact messages found.</p>
                    <?php endif; ?>
                </div>
                <div>&#x00A9; Copyright 2025 Republika | All Rights Reserved.</div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../js/manager.js"></script>
    <script>
        $(document).ready(function () {
            $('.myAccountBtn').on('click', function () {
                var formData = new FormData($('#myAccountFRM')[0]);
                formData.append('crntUsername', '<?php echo $_SESSION['rmanager_username']; ?>');

                $.ajax({
                    url: 'managerServer.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var jsonResponse = JSON.parse(response);
                
                        alert(jsonResponse.message);

                        if (jsonResponse.success) {
                            window.location.href = 'exit.php';
                        }
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });    
    </script>

</body>

</html>