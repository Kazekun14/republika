<?php
session_start();

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
?>

<!DOCTYPE html>

	<html>
		
		<head>
			
			<meta charset="UTF-8">
  			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>About Us</title>
			<link rel="stylesheet" href="../css/about-us.css" type="text/css">
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
					                    <a href="bookings_reservations.php" style="border-top: 0.5px solid #FF8400; border-bottom: 0.5px solid #FF8400;">Bookings & Reservations</a>
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
				<div class="banner-container">
					<img src="../img/340623100_759167118890442_3109008658859458_n.jpg" width="100%" height="100%">
					<div class="banner-overlay">
						<h1 class="title">About republika</h1>
					</div>
				</div>
				<div class="rtn-home">
					<a href="../index.php">
						<button>
							<i class="fa-solid fa-arrow-left"></i>
						</button>
					</a>
				</div>
				<div class="txt-container">
					<p>
						<font size="5"><strong>About Us – Republika Beach Bar</strong></font>
						<br><br>
						Welcome to <strong>Republika Beach Bar</strong>, your ultimate destination for relaxation, indulgence, and unforgettable beachside experiences. Nestled along pristine shores, Republika Beach Bar offers a seamless blend of tropical vibes, warm hospitality, and exceptional amenities designed to make every visit extraordinary.
						<br><br>
						At Republika, we take pride in creating a haven where guests can unwind and savor the beauty of the coast. Our offerings include:
					</p>
					<ul>
						<li>
							<strong>Comfortable Accommodations:</strong> A range of well-appointed rooms designed to provide a serene retreat after a day of fun in the sun.
						</li>
						<li>
							<strong>Delectable Food & Drinks:</strong> Indulge in a variety of local and international cuisines, paired with refreshing beverages from our signature bar.
						</li>
						<li>
							<strong>Exciting Amenities:</strong> From beach games and live music to private cabanas, there’s something for everyone to enjoy.
						</li>
					</ul>
					<p>
						Whether you're seeking a tranquil escape or a vibrant beach party, Republika Beach Bar is here to turn your seaside dreams into reality. Come and make memories that last a lifetime at Republika, where the sun, sand, and sea await.
					</p>
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

			<script src="../js/about-us.js"></script>
		
		</body>

	</html>