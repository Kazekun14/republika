<?php
session_start();

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
?> 

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Privacy Policy</title>
		<link rel="stylesheet" href="../css/privacy-policy.css" type="text/css">
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
			<div class="rtn-home">
				<a href="../index.php">
					<button>
						<i class="fa-solid fa-arrow-left"></i>
					</button>
				</a>
			</div>
			<div class="txt-container">
				<div>Privacy Policy</div>
				<p>
					Effective Date: January 6, 2025
					<br><br>
					Welcome to <strong>Republika Beach Bar</strong>! This Privacy Policy outlines the types of personal information that is received and collected by Republika Beach Bar and how it is used.
					<br><br>
					By accessing this website, you agree to the collection and use of information in accordance with this policy. If you do not agree with any part of this policy, please discontinue use of our website.
					<br><br>
					<strong>1. Information We Collect</strong>
					<br>
					We may collect the following types of information when you visit our website:
				</p>
				<ul>
				  <li>Personal identification information (name, email address, etc.)</li>
				  <li>Non-personal identification information (browser type, device information, etc.)</li>
				  <li>Log data (IP address, pages visited, time spent on pages, etc.)</li>
				</ul>
				<p>
					<strong>2. How We Use Your Information</strong>
					<br>
					We use the collected information for the following purposes:
				</p>
				<ul>
				  <li>To personalize your experience on our website.</li>
				  <li>To improve our website and services.</li>
				  <li>To respond to customer service requests.</li>
				  <li>To analyze website usage and performance.</li>
				</ul>
				<p>
					<strong>3. Cookies</strong>
					<br>
					Our website does not currently use cookies or similar tracking technologies. If we implement cookies in the future, we will update this policy accordingly.
					<br><br>
					<strong>4. Data Security</strong>
					<br>
					We take reasonable precautions to protect your personal information. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee its absolute security.
					<br><br>
					<strong>5. Third-Party Links</strong>
					<br>
					Our website may contain links to external websites. We are not responsible for the privacy practices or content of these third-party sites.
					<br><br>
					<strong>6. Children's Privacy</strong>
					<br>
					This website is not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If we become aware that a child under 13 has provided us with personal information, we will take steps to remove such information.
					<br><br>
					<strong>7. Changes to Privacy Policy</strong>
					<br>
					Republika Beach Bar reserves the right to update or revise this Privacy Policy at any time. Any changes will be posted on this page, and the "Effective Date" will be updated accordingly.
					<br><br>
					<strong>8. Contact Us</strong>
					<br>
					If you have any questions or concerns regarding this Privacy Policy, please contact us at:
					<br>
					<strong>Email:</strong> steveswatton@mac.com
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

		<script src="../js/privacy-policy.js"></script>

	</body>

</html>