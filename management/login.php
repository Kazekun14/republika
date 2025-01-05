<!DOCTYPE html>

<html>
	
	<head>
		
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Management Portal</title>
		<link rel="stylesheet" href="../css/login.css" type="text/css">
		<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	</head>

	<body>
		
		<div class="overlay">
			<h1 class="logo">re<font color="white">pub</font>lika</h1>
			<p class="subtitle">Management System</p>
			<div class="box">
				<div class="ambtnContainer">
					<div class="slider" id="slider"></div>
					<div class="amBtn" id="adminBtn" onclick="showForm('admin')">Admin</div>
					<div class="amBtn" id="managerBtn" onclick="showForm('manager')">Manager</div>
				</div>
				<form method="POST" class="Frm" id="Frm">
					<label for="username">Username</label>
					<input type="text" name="adminUsername" id="username" placeholder="Enter username" required>
					<label for="username">Password</label>
					<input type="password" name="adminPassword" id="password" placeholder="Enter password" required>
					<button type="submit">LOG IN</button>
				</form>
				<p>&#x00A9; Copyright 2025 Republika | All Rights Reserved.</p>
			</div>
		</div>

		<script src="../js/login.js"></script>
		<script>
			$(document).ready(function () {
	            $('#Frm').on('submit', function (e) {
	                e.preventDefault();

	                $.ajax({
	                    url: 'loginServer.php',
	                    type: 'POST',
	                    data: $(this).serialize(),
	                    success: function (response) {
	                        alert(response);
	                        if (response.includes('Welcome! Admin access confirmed.')) {
	                            window.location.href = 'admin.php';
	                        }
	                        if (response.includes('Welcome! Your manager access has been confirmed.')) {
	                            window.location.href = 'manager.php';
	                        }
	                    },
	                    error: function () {
	                        alert('An error occurred. Please try again.');
	                    }
	                });
	            });
	        });
		</script>

	</body>

</html>