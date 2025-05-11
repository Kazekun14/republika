<?php
session_start();

$isNotEmpty = isset($_SESSION['r_username']) ? $_SESSION['r_username'] : null;
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Republika Beach Bar</title>
		<link rel="stylesheet" href="css/index.css" type="text/css">
		<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Carrois+Gothic+SC&family=Cinzel:wght@400..900&family=Julius+Sans+One&family=Permanent+Marker&family=Sriracha&family=Vollkorn+SC:wght@400;600;700;900&display=swap" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

	</head>

	<body>
		
		<header>
			<nav>
				<div class="navigation-bar">
					<h1 class="logo">re<font color="white">pub</font>lika</h1>
					<div class="hamburger" onclick="toggleMenu()">
				        <div></div>
				        <div></div>
				        <div></div>
	      			</div>
					<ul class="navigation">
						<a class="close-btn" onclick="toggleMenu()">x</a>
						<li><a href="php/contact-us.php">Contact us</a></li>
						<hr class="hr2">
						<li><a href="php/about-us.php">About us</a></li>
						<?php
						if (!$isNotEmpty) {
							echo '<hr class="hr3">';
						}
						?>
						<?php if (isset($isNotEmpty)): ?>
							<?php
				            $avatarPath = "uploads/" . basename($_SESSION['r_avatar']);
				            $avatarSrc = file_exists($avatarPath) ? $avatarPath : "img/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg";
				            ?>
				            <div class="profile">
				                <img src="<?php echo $avatarSrc; ?>" alt="Avatar" class="avatar">
				                <span><?php echo htmlspecialchars($isNotEmpty); ?></span>
				                <div class="dropdown-content">
				                    <a href="php/manage_account.php">Account</a>
				                    <a href="php/bookings_reservations.php" style="border-top: 0.5px solid #FF8400; border-bottom: 0.5px solid #FF8400;">Bookings & Reservations</a>
				                    <a href="php/logout.php">Log out</a>
				                </div>
				            </div>
				        <?php else: ?>
						<li><a onclick="window.location.href='html/authentication.html?action=login'">Log in</a></li>
						<hr class="hr4">
						<li><button onclick="window.location.href='html/authentication.html?action=register'">Register</button></li>
						<?php endif; ?>
					</ul>
				</div>
			</nav>
			<section>
				<div class="banner-container">
					<img src="img/o2qggfqoidd8rnrulhj5.jfif" width="100%" height="100%">
					<div class="overlay"></div>
					<div class="tagline-container">
						<span class="tagline">
							<i>
								"Republika Beach Bar" 
								<br>
								BOOK NOW!
								<br>
								Make your paradise escape 
								<br>
								UNFORGETTABLE!
							</i>
						</span>
					</div>
				</div>
			</section>
			<section>
				<div class="search-bar">
					<form action="php/accommodation-service.php" method="get" id="searchForm">
						<div class="search-container">
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
						<div class="search-container">
							<label id="labelCheckinDate" for="checkinDate">CHECK-IN</label>
							<input type="date" id="checkinDate" name="checkinDate">
						</div>
						<div class="search-container">
							<label id="labelCheckoutTime" for="checkoutTime">CHECK-OUT</label>
							<input type="date" id="checkoutTime" name="checkoutTime">
						</div>
						<div class="search-container">
							<label for="guest_selector">GUESTS</label>
							<div class="guest_selector">
								<button id="guest-dropdown-button" class="guest-selector-input"><span id="guest-count">1</span><img src="img/chevron.png" width="14px" height="14px"></button>
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
						<div class="search-button">
						<button type="submit">SEARCH</button>
						</div>
					</form>
				</div>				
			</section>
		</header>
		<div class="occupy-empty-space"></div>
		<main>
			<div class="clabel-container">
				<label class="c-label" for="carousel-container">
					<font style="font-size: 25px; font-weight: bold;">Unmatched Stays and Services Await You</font>
					<br><br>
					Indulge in luxurious accommodations, exceptional dining, and personalized services crafted to make every moment unforgettable.
				</label>
			</div>
			<div class="carousel-container">
				<div class="carousel" id="carousel">
					<div class="carousel-item">
						<a href="javascript:void(0);" onclick="room();"><img src="img/IMG_6153-600x400.jpg" alt="Image 1"></a>
						<div class="caption">Room</div>
					</div>
					<div class="carousel-item">
                		<a href="javascript:void(0);" onclick="dorm();"><img src="img/341017622_722601886269925_1417288136208582119_n.jpg" alt="Image 2"></a>
                		<div class="caption">Dorm</div>
            		</div>
            		<div class="carousel-item">
		                <a href="javascript:void(0);" onclick="foodBeverage();"><img src="img/452651944_894549026029805_7783535078166201283_n.jpg" alt="Image 4"></a>
		                <div class="caption">Food and Beverage</div>
            		</div>
            		<div class="carousel-item">
		                <a href="javascript:void(0);" onclick="eventCatering();"><img src="img/istockphoto-650655146-612x612.jpg" alt="Image 5"></a>
		                <div class="caption">Event Catering</div>
            		</div>
            		<div class="carousel-item">
		                <a href="javascript:void(0);" onclick="entertainmentEvent();"><img src="img/454528919_1498646194101183_3709761952342077757_n.jpg" alt="Image 6"></a>
		                <div class="caption">Entertainment and Event</div>
            		</div>
				</div>
				<button class="arrow arrow-left hidden" id="prevButton"><i class="fa-solid fa-arrow-left"></i></button>
				<button class="arrow arrow-right" id="nextButton"><i class="fa-solid fa-arrow-right"></i></button>
			</div>
			<div class="siteAd-container">
  				<img src="img/Diver-swims-with-hawksbill-turtle-at-West-Caicos.jpg" width="200px" height="185px">
  				<div class="slabel-container">
    				<font class="main-subtitle">
      				Part of Republika’s Unforgettable Experience
    				</font>
    				<font class="bottom-subtitle">
      				Discover the beauty of the ocean with DivePoint, proudly brought to you by Republika Beach Bar—your ultimate destination for adventure and relaxation.
    				</font>
    				<a href="https://www.divepoint.asia/" target="_blank" class="styled-button">Visit</a>
  				</div>
			</div>
		</main>
		<footer>
			<nav>
				<div class="navigation-bar1">
					<div class="logo-foot">republika</div>
					<hr style="width: 60%; border: 1px solid #FF8400;">
					<div class="nav-foot">
						<a href="https://www.facebook.com/republikasiquijor?mibextid=ZbWKwL" target="_blank">Facebook</a>
						<a href="https://www.instagram.com/republika_beach_bar?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">Instagram</a>
						<a href="php/terms-conditions.php">Terms and Conditions</a>
						<a href="php/privacy-policy.php">Privacy Policy</a>
					</div>
					<p>&#x00A9; Copyright 2025 Republika | All Rights Reserved.</p>
				</div>
			</nav>
		</footer>

		<script src="js/index.js"></script>

	</body>

</html>