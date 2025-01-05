<?php
session_start();

$username = $_SESSION['r_username'];
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Bookings & Reservations</title>
		<link rel="stylesheet" href="../css/bookings_reservations.css" type="text/css">
		<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
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
	                    $avatarPath = "../uploads/" . basename($_SESSION['r_avatar']);
	                    $avatarSrc = file_exists($avatarPath) ? $avatarPath : "../img/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg";
	                    ?>
	                    <div class="profile">
	                        <img src="<?php echo $avatarSrc;?>" alt="Avatar" class="avatar">
	                        <span><?php echo htmlspecialchars($_SESSION['r_username']);?></span>
	                        <div class="dropdown-content">
	                            <a href="manage_account.php">Account</a>
	                            <a href="bookings_reservations.php" style="border-top: 0.5px solid #FF8400; border-bottom: 0.5px solid #FF8400; pointer-events: none; color: gray;">Bookings & Reservations</a>
	                            <a href="logout.php">Log out</a>
	                        </div>
	                    </div>
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
			<div class="rcdOptionContainer">
				<div onclick="showRecord('bRecord')">Bookings</div>
				<div onclick="showRecord('rRecord')">Reservations</div>
				<hr id="slider">
			</div>
			<div class="bContainer" id="bRecord">
				<div class="bField">
					<span>Accommodation Name</span>
					<span>Check-in</span>
					<span>Time-in</span>
					<span>Check-out</span>
					<span>Time-out</span>
					<span>Guests</span>
					<span>Total Price</span>
				</div>
				<div class="bLists" id="bLists"></div>
			</div>
			<div class="rContainer" id="rRecord">
				<div class="rField">
					<span>Service Name</span>
					<span>Date</span>
					<span>Time</span>
					<span>Guests</span>
					<span>Total Price</span>
				</div>
				<div class="rLists" id="rLists"></div>
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

		<script src="../js/bookings_reservations.js"></script>
		<script>
			const username = "<?php echo $username;?>";

			const frmData = new FormData();
			frmData.append('username', username);

			fetch('record.php', {
				method: 'POST',
	            body: frmData
			})
			.then(response => response.json())
			.then(data => {
				let bOutput = '';
				if (data.bResults.length > 0) {
					data.bResults.forEach(bResult => {
						bOutput += `
							<div class="bCard">
								<div class="baccCard">${bResult.accommodation_name}</div>
								<div class="bchckInCard">${bResult.check_in_date}</div>
								<div class="btimInCard">${bResult.check_in_time}</div>
								<div class="bchckOutCard">${bResult.check_out_date}</div>
								<div class="btimOutCard">${bResult.check_out_time}</div>
								<div class="bgstCard">${bResult.guest_count}</div>
								<div class="bttlprcCard">${bResult.total_price}</div>
							</div>
						`;
					});
				} else {
					bOutput = `<p class="bnoAcc">No accommodation records yet.</p>`;
				}
				document.getElementById('bLists').innerHTML = bOutput;

				let rOutput = '';
				if (data.rResults.length > 0) {
					data.rResults.forEach(rResult => {
						rOutput += `
							<div class="rCard">
								<div class="rsrvcCard">${rResult.service_name}</div>
								<div class="rdteCard">${rResult.date}</div>
								<div class="rtimCard">${rResult.time}</div>
								<div class="rgstCard">${rResult.guests}</div>
								<div class="rttlprcCard">${rResult.total_price}</div>
							</div>
						`;
					});
				} else {
					rOutput = `<p class="rnoSrvc">No service records yet.</p>`;
				}
				document.getElementById('rLists').innerHTML = rOutput;
			})
			.catch(error => console.error('Error:', error));
		</script>

	</body>

</html>