<?php
session_start();
require '../php/database.php';

    if (!isset($_SESSION['radmin_username']) || $_SESSION['r_user_type'] !== 'admin') {
        header('Location: login.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT COUNT(*) AS totalAccounts FROM users");
    $stmt->execute();
    $stmt->bind_result($totalAccounts);
    $stmt->fetch();

    $stmt->close();

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

    $user_type = "customer";

    $stmt = $conn->prepare("SELECT COUNT(*) AS totalCustomer FROM users WHERE user_type = ?");
    $stmt->bind_param("s", $user_type);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $totalCustomer = $row['totalCustomer'];

    $stmt->close();

    $user_type = "manager";

    $stmt = $conn->prepare("SELECT COUNT(*) AS totalManager FROM users WHERE user_type = ?");
    $stmt->bind_param("s", $user_type);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $totalManager = $row['totalManager'];

    $stmt->close();

    $sql = "SELECT users.id, users.username, users.password, users.avatar, users.user_type, userinfo.fullname, userinfo.email, userinfo.number, userinfo.address, userinfo.datebirth, userinfo.gender FROM users LEFT JOIN userinfo ON users.username = userinfo.username WHERE users.user_type = 'customer'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $CustomerAccountResult = $stmt->get_result();

    $stmt->close();

    $sql = "SELECT users.username, users.password, users.avatar, users.user_type, userinfo.fullname, userinfo.email, userinfo.number, userinfo.address, userinfo.datebirth, userinfo.gender FROM users LEFT JOIN userinfo ON users.username = userinfo.username WHERE users.user_type = 'manager'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $ManagerAccountResult = $stmt->get_result();

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customerDelete'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $_POST['customerDelete']);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM userinfo WHERE username = ?");
        $stmt->bind_param("s", $_POST['customerDelete']);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['managerDelete'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $_POST['managerDelete']);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM userinfo WHERE username = ?");
        $stmt->bind_param("s", $_POST['managerDelete']);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
    }

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
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/admin.css" type="text/css">
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
                    <a href="#" class="nav-link" id="navAccounts" onclick="showContent('accounts')">
                        <i class="fa-regular fa-user"></i> Accounts
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
                <h2 class="fw-bold m-4">Admin</h2>
                <button class="exit fs-2 m-4" onclick="window.location.href='exit.php';"><i class="fa-solid fa-arrow-right-to-bracket"></i></button>
            </div>
            <!--Dashboard-->
            <div class="container-fluid py-4" id="dashboard">
                <h2 class="mb-5 mt-4 ms-4">Dashboard</h2>
                <div class="row">
                    <div class="col-md-6 mb-4 ">
                        <div class="card bg-primary text-white rHeight " onclick="showContent('accounts')">
                            <div class="card-body">
                                <h5 class="card-title">Accounts</h5>
                                <h2 class="position-absolute start-50 top-50 translate-middle fs-1"><?php echo $totalAccounts ?? 0?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card bg-success text-white rHeight" onclick="showContent('bookings')">
                            <div class="card-body">
                                <h5 class="card-title">Total Bookings</h5>
                                <h2 class="position-absolute start-50 top-50 translate-middle fs-1"><?php echo $totalBookings ?? 0?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card bg-warning text-white rHeight" onclick="showContent('reservations')">
                            <div class="card-body">
                                <h5 class="card-title">Total Reservations</h5>
                                <h2 class="position-absolute start-50 top-50 translate-middle fs-1"><?php echo $totalReservations ?? 0?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card bg-info text-white rHeight" onclick="showContent('inbox')">
                            <div class="card-body">
                                <h5 class="card-title">Inbox</h5>
                                <h2 class="position-absolute start-50 top-50 translate-middle fs-1"><?php echo $totalInbox ?? 0?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div>&#x00A9; Copyright 2025 Republika  | All Rights Reserved.</div>
            </div>
            <!--Accounts-->
            <div class="container-fluid py-4 d-none" id="accounts">
                <h2 class="mb-5 mt-4 ms-4">Account Management</h2>
                <div class="container-fluid d-flex mb-5 mt-3 justify-content-between">
                    <div class="d-flex">
                        <button class="rounded-pill mx-1 customerBtn" type="button" onclick="showAccountType('customer')">Customers</button>
                        <button class="rounded-pill mx-1 managerBtn" type="button" onclick="showAccountType('manager')">Managers</button>
                    </div>
                    <button class="addcustomerBtn" onclick="window.location.href='registerManager.php';">+ Add Manager</button>
                </div>
                <h5 class="fw-bold mb-3" id="totalCustomer">Total Customers: <?php echo $totalCustomer ?? 0; ?></h5>
                <h5 class="fw-bold mb-3 d-none" id="totalManager">Total Managers: <?php echo $totalManager ?? 0; ?></h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark align-middle">
                            <tr>
                                <th class="text-center">User</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Phone Number</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Date of Birth</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customerAccounts">
                            <?php
                            if ($CustomerAccountResult->num_rows > 0) {
                                while ($row = $CustomerAccountResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='d-flex justify-content-center align-items-center'>";
                                    echo "<img src='../uploads/" . $row['avatar'] . "' alt='Avatar' width='50' height='50' class='avatar'/>";
                                    echo "<p>" . $row['fullname'] . "</p>";
                                    echo "</td>";
                                    echo "<td class='text-center'>" . $row['username'] . "</td>";
                                    echo "<td class='text-center'>" . $row['email'] . "</td>";
                                    echo "<td class='text-center'>" . $row['number'] . "</td>";
                                    echo "<td class='text-center'>" . $row['address'] . "</td>";
                                    echo "<td class='text-center'>" . date('F j, Y', strtotime($row['datebirth'])) . "</td>";
                                    echo "<td class='text-center'>" . $row['gender'] . "</td>";
                                    echo "<td class='d-flex'>";
                                    echo "<form method='POST'><button class='btn btn-danger btn-sm ms-1' name='customerDelete' value='" . $row['username'] . "'>Delete</button></form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                        <tbody class="d-none" id="managerAccounts">
                            <?php
                            if ($ManagerAccountResult->num_rows > 0) {
                                while ($row = $ManagerAccountResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='d-flex justify-content-center align-items-center'>";
                                    echo "<img src='../uploads/" . $row['avatar'] . "' alt='Avatar' width='50' height='50' class='avatar'/>";
                                    echo "<p>" . $row['fullname'] . "</p>";
                                    echo "</td>";
                                    echo "<td class='text-center'>" . $row['username'] . "</td>";
                                    echo "<td class='text-center'>" . $row['email'] . "</td>";
                                    echo "<td class='text-center'>" . $row['number'] . "</td>";
                                    echo "<td class='text-center'>" . $row['address'] . "</td>";
                                    echo "<td class='text-center'>" . date('F j, Y', strtotime($row['datebirth'])) . "</td>";
                                    echo "<td class='text-center'>" . $row['gender'] . "</td>";
                                    echo "<td class='d-flex'>";
                                    echo "<form method='POST'><button class='btn btn-danger btn-sm ms-1' name='managerDelete' value='" . $row['username'] . "'>Delete</button></form>";
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
    <script src="../js/admin.js"></script>
</body>

</html>