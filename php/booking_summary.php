<?php
session_start();

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Booking Summary</title>
		<link rel="stylesheet" href="../css/booking_summary.css" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

	</head>

	<body>
		
		<header>
			<nav>
				<div class="navbar-head">
					<h1 class="logo-head">re<font color="white">pub</font>lika</h1>
					<div class="menu" onclick="toggleMenu()">
				        <div></div>
				        <div></div>
				        <div></div>
	      			</div>
					<ul class="nav-head">
						<a class="close-btn" onclick="toggleMenu()">x</a>
						<li><a href="contact-us.php">Contact us</a></li>
						<hr class="hr2">
						<li><a href="about-us.php">About us</a></li>
						<?php 
						if (!$isNotEmpty) {
							echo '<hr class="hr3">';
						}
						?>
						<?php if (isset($isNotEmpty)): ?>
							<?php
				            $avatarPath = "../uploads/" . basename($_SESSION['r_avatar']);
				            $avatarSrc = file_exists($avatarPath) ? $avatarPath : "../img/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg";
				            ?>
				            <div class="profile">
				            	<img src="<?php echo $avatarSrc; ?>" alt="Avatar" class="avatar">
				            	<span><?php echo htmlspecialchars($isNotEmpty); ?></span>
				            	<div class="dropdown-content">
				            		<a href="manage_account.php">Account</a>
				                    <a href="bookings_reservations.php" style="border-top: 0.5px solid #FF8400; border-bottom: 0.5px solid #FF8400;">Bokings & Reservations</a>
				                    <a href="logout.php">Log out</a>
				            	</div>
				            </div>
			            <?php else: ?>
						<li><a onclick="window.location.href='../html/authentication.html?action=login'">Log in</a></li>
						<hr class="hr4">
						<li><button onclick="window.location.href='../html/authentication.html?action=register'">Register</button></li>
						<?php endif; ?>
					</ul>
				</div>
			</nav>
		</header>
		<main>
			<div class="rtn-home">
				<a href="../index.php">
					<button>
						<i class="fa-solid fa-arrow-left"></i>
					</button>
				</a>
			</div>
			<div class="sumContainer" id="saveSection">
				<i class="fa-solid fa-check"></i>
				<p class="p1">
					<font size="5"><b>Booking Confirmed!</b></font>
					<br>
					Thank you for scheduling with us. Below are the details of your appointment.
				</p>
				<div class="dtlsBox">
					<div class="dtlsContainer">
						<span class="label">ACCOMMODATION:</span>
						<span class="labelData" id="accData">Accomodation data</span>
						<span class="label">FULL NAME:</span>
						<span class="labelData" id="flnameData">Full name data</span>
						<span class="label">EMAIL:</span>
						<span class="labelData" id="emailData">Email data</span>
						<span class="label">GUESTS:</span>
						<span class="labelData" id="gstsData">Guests data</span>
					</div>
					<div class="dtlsContainer">
						<span class="label">CHECK-IN:</span>
						<span class="labelData" id="chckInData">Check-in data</span>
						<span class="label">TIME-IN:</span>
						<span class="labelData" id="timeInData">Time-in data</span>
						<span class="label">CHECK-OUT:</span>
						<span class="labelData" id="chckOutData">Check-out data</span>
						<span class="label">TIME-OUT:</span>
						<span class="labelData" id="timeOutData">Time-out data</span>
						<span class="label">PRICE:</span>
						<span class="labelData" id="priceData">Price data</span>
					</div>
				</div>
				<button class="saveBtn" onclick="savePage()">SAVE</button>
			</div>
		</main>
		<footer>
			<nav>
				<div class="navbar-foot">
					<div class="logo-foot">republika</div>
					<hr class="hr5">
					<div class="nav-foot">
						<a href="https://www.facebook.com/republikasiquijor?mibextid=ZbWKwL" target="_blank">Facebook</a>
						<a href="https://www.instagram.com/republika_beach_bar?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">Instagram</a>
						<a href="terms-conditions.php">Terms and Conditions</a>
						<a href="privacy-policy.php">Privacy Policy</a>
					</div>
					<p>&#x00A9; Copyright 2025 Republika | All Rights Reserved.</p>
				</div>
			</nav>
		</footer>

		<script src="../js/booking_summary.js"></script>

	</body>

</html>