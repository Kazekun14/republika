<?php
session_start();
require 'database.php';

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
$jsonusrdta1 = null;
$userdta2 = ['date' => $_GET['checkinDate'], 'time' => $_GET['checkoutTime'], 'adults' => $_GET['adults'], 'children' => 
			$_GET['children'], 'totalGuests' => $_GET['totalGuests']];
$id = $_GET['id'];

if (isset($_SESSION['r_username'])) {
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['r_username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userinfo = $result->fetch_assoc();
        $userdta1 = ['fullname' => $userinfo['fullname'], 'email' => $userinfo['email'], 'address' => $userinfo['address']];

        $jsonusrdta1 = json_encode($userdta1);
    }
}

$jsonusrdta2 = json_encode($userdta2);

$stmt = $conn->prepare("SELECT * FROM accommodations WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

$srvc = $result->fetch_assoc();
$service = ['type' => $srvc['type'], 'name' => $srvc['name'], 'price' => $srvc['price']];

$jsonsrvc = json_encode($service);
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Reserve</title>
		<link rel="stylesheet" href="../css/reserve.css" type="text/css">
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
			<div class="frmBox">
				<div class="frmHead">Reservation Form</div>
				<form class="frmReserve" id="frmReserve">
					<div class="inptContainer">
						<label for="fname">Full name</label>
						<input type="text" id="fname" name="fname" required>
					</div>
					<div class="inptContainer">
						<label for="eml">Email</label>
						<input type="email" id="eml" name="eml" required>
					</div>
					<div class="inptContainer">
						<label for="dte">Date</label>
						<input type="date" id="dte" name="dte" required>
					</div>
					<div class="inptContainer">
						<label for="tim">Time</label>
						<input type="time" id="tim" name="tim" required>
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
					<div class="inptContainer" id="inptContaineradrs">
						<label for="adrs">Address</label>
						<input type="text" id="adrs" name="adrs" required>						
					</div>
					<div class="btnContainer">
						<button type="button" onclick="openModal()">RESERVE NOW</button>
					</div>
				</form>
			</div>
			<div id="modal" class="modal">
		    	<div class="mdl-content">
		    		<p>Do you want to confirm your reservation?</p>
	    			<button class="confirm" onclick="confirmReserve()">Confirm</button>
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
			const username = "<?php echo $isNotEmpty; ?>";
			const userdta1 = <?php echo isset($jsonusrdta1) ? $jsonusrdta1 : 'null'; ?>;
			const userdta2 = <?php echo $jsonusrdta2; ?>;
			const service = <?php echo $jsonsrvc; ?>;
		</script>
		<script src="../js/reserve.js"></script>

	</body>

</html>