<?php
session_start();
require 'database.php';

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
$id = $_GET['id'];
$chckIn = $_GET['checkinDate'];
$chckOut = $_GET['checkoutTime'];
$flname = null;
$email = null;

if (isset($_SESSION['r_username'])) {
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
    $stmt->bind_param("s", $isNotEmpty);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userinfo = $result->fetch_assoc();
        $flname = $userinfo['fullname'];
        $email = $userinfo['email'];

    }
}
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Book</title>
		<link rel="stylesheet" href="../css/book.css" type="text/css">
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
			<div class="formContainer">
				<div class="formHead">Booking Form</div>
				<form action="bkngsuccess.php" class="bkngForm" id="bkngForm">
					<div class="inptContainer">
						<label for="flname">Full name</label>
						<input type="text" id="flname" name="flname" value="<?php echo $flname; ?>" <?php echo $flname ? 'disabled' : ''; ?> required>
					</div>
					<div class="inptContainer">
						<label for="email">Email</label>
						<input type="email" id="email" name="email" value="<?php echo $email; ?>" <?php echo $email ? 'disabled' : ''; ?> required>
					</div>
					<div class="inptContainer">
						<label for="chckIn">Check-in</label>
						<input type="date" id="chckIn" name="chckIn" value="<?php echo $chckIn; ?>" required>
					</div>
					<div class="inptContainer">
						<label for="timeIn">Time-in</label>
						<input type="time" id="timeIn" name="timeIn" required>
					</div>
					<div class="inptContainer">
						<label for="chckOut">Check-out</label>
						<input type="date" id="chckOut" name="chckOut" value="<?php echo $chckOut; ?>" required>
					</div>
					<div class="inptContainer">
						<label for="timeOut">Time-out</label>
						<input type="time" id="timeOut" name="timeOut" required>
					</div>
					<div class="inptContainer">
						<label for="gsts">Guests</label>
						<div class="guest_selector">
							<button id="guest-dropdown-button" class="guest-selector-input">
								<span id="guest-count">1</span>
								<img src="../img/chevron.png" width="14px" height="14px">
							</button>
							<div id="guest-dropdown-menu" class="dropdown-menu">
								<div class="dropdown-item">
									<span>Adults</span>
									<div class="counter">
										<button class="counter-btn" id="adults-decrement" disabled>-</button>
										<span id="adults-count">1</span>
										<button class="counter-btn" id="adults-increment">+</button>	
									</div>
								</div>
								<div class="dropdown-item">
        							<span>Children</span>
        							<div class="counter">
          								<button class="counter-btn" id="children-decrement" disabled>-</button>
          								<span id="children-count">0</span>
          								<button class="counter-btn" id="children-increment">+</button>
        							</div>
      							</div>
							</div>
						</div>
					</div>
					<input type="hidden" id="hidden-adults" name="adults">
				    <input type="hidden" id="hidden-children" name="children">
				    <input type="hidden" id="hidden-total-guests" name="totalGuests">
					<div class="btnContainer">
						<button type="button" onclick="openModal()">BOOK NOW</button>
					</div>
				</form>
			</div>
			<div id="modal" class="modal">
		    	<div class="mdl-content">
		    		<p>Do you want to confirm your booking?</p>
	    			<button class="confirm" onclick="cnfrmBook()">Confirm</button>
	    			<button class="cancel" onclick="closeModal()">Cancel</button>
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

		<script>
			const id = "<?php echo $id;?>";
			const username = "<?php echo $isNotEmpty;?>";
		</script>
		<script src="../js/book.js"></script>

	</body>

</html>