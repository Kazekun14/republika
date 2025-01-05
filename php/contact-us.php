<?php
session_start();
require 'database.php';

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['description'])) {
            throw new Exception("All fields are required");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $subject = $conn->real_escape_string($_POST['subject']);
        $description = $conn->real_escape_string($_POST['description']);

        if (isset($_SESSION['r_username'])) {
            $stmt = $conn->prepare("INSERT INTO contact_us (username, name, email, subject, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $_SESSION['r_username'], $name, $email, $subject, $description);
        } else {
            $stmt = $conn->prepare("INSERT INTO contact_us (name, email, subject, description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $subject, $description);
        }

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $stmt->close();
        echo json_encode(['status' => 'success']);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?> 

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Contact Us</title>
		<link rel="stylesheet" href="../css/contact-us.css" type="text/css">
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
			<h1 class="contact-caption">Contact Us</h1>
			<div class="contact-container">
				 <div class="info-container">
				 	<p>
				 		<strong>Republika Beach Bar, Accommodation and Services</strong>
				 		<br><br>
				 		<strong>Location:</strong> Republika Beach Bar is nestled on the scenic outskirts of Maite village, in the municipality of San Juan, on the enchanting island of Siquijor, Philippines. Conveniently located just 250 meters south of Bah Ba’r, a renowned dining spot celebrated for its exceptional cuisine, the bar lies along the route heading toward popular destinations such as Royal Cliff and Coco Grove Resort. It is approximately 1.5 kilometers south of San Juan town center, offering a perfect blend of accessibility and tranquility for visitors seeking a serene beachside escape in the heart of the Philippines.
				 	</p>
				 	<div class="map-container">
				 		<a href="https://www.google.com/maps/place/Republika+Beach+Bar/@9.1490958,123.4996261,17z/data=!3m1!4b1!4m9!3m8!1s0x33ab3ef45c94e643:0xd2d84885dcaaa519!5m2!4m1!1i2!8m2!3d9.1490905!4d123.502201!16s%2Fg%2F11fyls8d_d?entry=ttu&g_ep=EgoyMDI0MTIwMi4wIKXMDSoASAFQAw%3D%3D" target="_blank">
            				<img src="../img/462729950_980658040550711_8521635846861411191_n.jpg" alt="Republika Beach Bar Map" width="100%" height="100%">
        				</a>
				 	</div>
				 	<p>
				 		<strong>Phone:</strong> 
				 		<br><br>
				 		0998 548 8783
				 		<br>
				 		<strong>Gen</strong> 09171546628
				 		<br>
						<strong>Genam</strong> 0910083 7714
						<br><br>
						<strong>Email:</strong> 
						<br><br>
						Steveswatton@mac.com
						<br>
						info@baha-bar.com
				 	</p>
				 </div>
				 <div class="form-container">
				 	<form method="POST" id="contactForm">
				        <label for="name">Your name:</label><br>
				        <input type="text" id="name" name="name" required><br><br>

				        <label for="email">Your email address:</label><br>
				        <input type="email" id="email" name="email" required><br><br>

				        <label for="subject">Subject:</label><br>
				        <input type="text" id="subject" name="subject"><br><br>

				        <label for="description">Description:</label><br>
				        <textarea id="description" name="description" placeholder="Please enter the details of your request. A member of our support staff will respond as soon as possible. Please ensure that you do not enter credit card details/username/passwords in this form."></textarea><br><br>

				        <button type="submit">Submit</button>
				    </form>
				 </div>
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

		<script src="../js/contact-us.js"></script>
		<script>
		    document.getElementById('contactForm').addEventListener('submit', function(event) {
	            event.preventDefault();

	            fetch(window.location.href, {
	                method: 'POST',
	                body: new FormData(this)
	            })
	            .then(response => response.json())
	            .then(data => {
	                if (data.status === 'success') {
	                    alert('Form submitted successfully!');
	                    this.reset();
	                } else {
	                    throw new Error(data.message);
	                }
	            })
	            .catch(error => {
	                alert('Error: ' + error.message);
	            });
	        });
		</script>
		
	</body>

</html>