<?php
session_start();

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Terms and Conditions</title>
		<link rel="stylesheet" href="../css/terms-conditions.css" type="text/css">
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
			<div class="txt-container">
				<div>Terms and Conditions</div>
				<p>
					Effective Date: January 6, 2025
					<br><br>
					Welcome to <strong>Republika Beach Bar</strong>! These Terms and Conditions outline the rules and regulations for using our website, located at 
					<a href="https://www.republikabeachbar.com" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;">https://www.republikabeachbar.com</a>.
					<br><br>
					<strong>Disclaimer:</strong> This website and its Terms and Conditions are part of an academic project for demonstration purposes only. Republika Beach Bar is not a licensed or operational business.
					<br><br>
					By accessing this website, you agree to comply with these Terms and Conditions. If you do not agree with any part of these terms, please discontinue use of our website.
					<br><br>
					<strong>1. Introduction</strong>
					<br>
					By using this website, you agree to accept these terms and conditions in full. Minors or people below 18 years old are not allowed to use this website without parental guidance.
					<br><br>
					<strong>2. Intellectual Property Rights</strong>
					<br>
					Unless otherwise stated, the content, design, and materials created for this website are original works by Republika Beach Bar and/or its creators for academic purposes. All rights to this original content are reserved. You may access this material for personal use, subject to the restrictions set in these terms.
					<br><br>
					You must not:
					<br><br>
					- Republish material from this website.
					<br>
					- Sell, rent, or sub-license material from this website.
					<br>
					- Reproduce, duplicate, or copy material from this website.
					<br>
					- Redistribute content from Republika Beach Bar.
					<br><br>
					<strong>3. User Content</strong>
					<br>
					By uploading, submitting, or otherwise sharing content on this website, you grant Republika Beach Bar a non-exclusive, worldwide, irrevocable license to use, reproduce, and modify such content.
					<br>
					You are responsible for ensuring your content does not infringe on any third-party rights.
					<br>
					Republika Beach Bar reserves the right to remove any content deemed inappropriate or in violation of these terms.
					<br><br>
					<strong>4. User Conduct</strong>
					<br>
					You agree not to use this website for:
					<br><br>
					- Engaging in unlawful, harmful, or fraudulent activities.
					<br>
					- Sending spam, unsolicited advertising, or promotional materials.
					<br>
					- Introducing viruses, trojans, or other malicious software.
					<br><br>
					<strong>5. Limitation of Liability</strong>
					<br>
					Republika Beach Bar is not responsible for any direct, indirect, or consequential damages arising from the use of this website or reliance on the information provided.
					<br><br>
					<strong>6. External Links</strong>
					<br>
					Our website may include links to external sites. We are not responsible for the content, privacy practices, or terms of use of these external websites.
					<br><br>
					<strong>7. Termination</strong>
					<br>
					We may terminate or suspend your access to the website without notice if you breach these terms.
					<br><br>
					<strong>8. Changes to Terms</strong>
					<br>
					Republika Beach Bar reserves the right to revise these Terms and Conditions at any time. Updated terms will be posted on this page, with the "Effective Date" updated accordingly.
					<br><br>
					<strong>9. Governing Law</strong>
					<br>
					These Terms and Conditions are governed by and construed in accordance with the laws of the Philippines, and you submit to the non-exclusive jurisdiction of the courts in that location.
					<br><br>
					<strong>10. Contact Us</strong>
					<br>
					For questions or concerns regarding these Terms and Conditions, please contact us at:
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

		<script src="../js/terms-conditions.js"></script>

	</body>

</html>