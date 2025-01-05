<?php
session_start();

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accommodations and Services</title>
		<link rel="stylesheet" href="../css/accommodation-service.css" type="text/css">
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
			<div class="searchBar">
				<form method="get" id="searchForm">
					<div class="srch-container">
						<label for="accommodation_service">ACCOMMODATION / SERVICE</label>
						<select id="accommodation_service" name="accommodation_service" required>
							<option value="" disabled selected>Select an option</option>
							<optgroup label="Accommodations">
	         					<option value="room">Room</option>
	          					<option value="dorm">Dorm</option>
	        				</optgroup>
	        				<optgroup label="Services">
	          					<option value="food_and_beverage">Food and Beverage</option>
	          					<option value="event_catering">Event Catering</option>
	          					<option value="entertainment_and_event">Entertainment and Event</option>
	        				</optgroup>
						</select>
					</div>
					<div class="srch-container">
						<label id="labelCheckinDate" for="checkinDate">CHECK-IN</label>
						<input type="date" id="checkinDate" name="checkinDate">
					</div>
					<div class="srch-container">
						<label id="labelCheckoutTime" for="checkoutTime">CHECK-OUT</label>
						<input type="date" id="checkoutTime" name="checkoutTime">
					</div>
					<div class="srch-container">
						<label for="guest_selector">GUESTS</label>
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
					<div class="srch-container srch-container-override">
						<button class="srch-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
					</div>
					<input type="hidden" id="hidden-adults" name="adults">
				    <input type="hidden" id="hidden-children" name="children">
				    <input type="hidden" id="hidden-total-guests" name="totalGuests">
				</form>
				<div class="dta-container" id="dtaContainer">
					<div class="dta-content">
						<span id="acc-ser" class="acc-ser">Accommodation/Service</span>
						<span id="cinDate" class="cin-date">Check-in date</span>
						<span id="coutTime" class="cout-date">Check-out date</span>
						<span id="guests" class="guests">Guests</span>
					</div>
					<i class="fa-regular fa-pen-to-square" id="editSearch"></i>
				</div>
			</div>
			<div class="accser-container" id="accser-container"></div>
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

		<script src="../js/accommodation-service.js"></script>
		<script>
        	const formData = new FormData();
	        formData.append('accommodation_service', accserURL);
	        formData.append('checkinDate', checkinDateURL);
	        formData.append('checkoutTime', checkoutTimeURL);
	        formData.append('adults', adultsURL);
	        formData.append('children', childrenURL);
	        formData.append('totalGuests', totalGuestsURL);

	        fetch('search.php', {
	            method: 'POST',
	            body: formData
        	})
        	.then(response => response.json())
	        .then(data => {
	            let output = '';
	            if (data.results.length > 0) {
	                data.results.forEach(result => {
	                    output += `
	                        <div class="accommodation-card">
	                        	<div class="img-container">
	                        		<img src="${result.image}" width="100%" height="100%" alt="Accomodation/Service picture">
	                        	</div>
	                        	<div class="acc-content">
		                            <h3>${result.name}</h3>
		                            <p class="p1 ${result.capacity === 0 ? 'hidden' : ''}">Capacity: ${result.capacity} guests</p>
		                            <p class="p1">Price: PHP ${result.price}</p>
		                            <p class="p2">${result.description}</p>
	                            </div>
	                            <div class="vbtn-container">
	                            	<a href="${['room', 'dorm'].includes(result.type) ? 'book.php' : 'reserve.php'}?id=${result.id}&checkinDate=${data.dateTime.checkinDate}&checkoutTime=${data.dateTime.checkoutTime}&adults=${data.guests.adults}&children=${data.guests.children}&totalGuests=${data.guests.totalGuests}">${textReserveBook}</a>
	                            </div>
	                        </div>
	                    `;
	                });
	            } else {
	                output = `<p class="p3">No accommodations or services available for your criteria.</p>`;
	            }
	            document.getElementById('accser-container').innerHTML = output;
	        })
	        .catch(error => console.error('Error:', error));
		</script>

	</body>

</html>