<?php
session_start();
require 'database.php';

$userInfo = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileUpload'])) {
    $avatar = $_FILES['fileUpload']['name'];
    $target = "../uploads/" . basename($avatar);

    if (move_uploaded_file($_FILES['fileUpload']['tmp_name'], $target)) {
        $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE username = ?");
        $stmt->bind_param("ss", $avatar, $_SESSION['r_username']);
        if ($stmt->execute()) {
            $_SESSION['r_avatar'] = $avatar;
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update avatar.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload the file.']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $username = $_SESSION['r_username'];

    $stmt1 = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt1->bind_param("s", $username);

    $stmt2 = $conn->prepare("DELETE FROM userinfo WHERE username = ?");
    $stmt2->bind_param("s", $username);

    $stmt1Executed = $stmt1->execute();
    $stmt2Executed = $stmt2->execute();

    if ($stmt1Executed || $stmt2Executed) {
        session_unset();
        session_destroy();

        echo json_encode(['status' => 'success', 'message' => 'Your account has been deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete your account. Please try again.']);
    }

    $stmt1->close();
    $stmt2->close();

    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = ['fname', 'email', 'number', 'address', 'datebirth', 'gender'];
    $missingFields = array_diff_key(array_flip($requiredFields), $_POST);

    if (empty($missingFields)) {
        $username = $_SESSION['r_username'];
        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $address = $_POST['address'];
        $datebirth = $_POST['datebirth'];
        $gender = $_POST['gender'];

        $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO userinfo (username, fullname, email, number, address, datebirth, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $username, $fname, $email, $number, $address, $datebirth, $gender);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("UPDATE userinfo SET fullname = ?, email = ?, number = ?, address = ?, datebirth = ?, gender = ? WHERE username = ?");
            $stmt->bind_param("sssssss", $fname, $email, $number, $address, $datebirth, $gender, $username);
            $stmt->execute();
        }
    }
}

if (isset($_SESSION['r_username'])) {
    $username = $_SESSION['r_username'];
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userinfo = $result->fetch_assoc();
        $userData = json_encode($userinfo);

        $userInfo = true;

        echo "<script>var userData = $userData;</script>";
    } else {
        echo "<script>var userData = null;</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="../css/manage_account.css" type="text/css">
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
                            <a href="manage_account.php" style="pointer-events: none; color: gray;">Account</a>
                            <a href="bookings_reservations.php" style="border-top: 0.5px solid #FF8400; border-bottom: 0.5px solid #FF8400;">Bookings & Reservations</a>
                            <a href="logout.php">Log out</a>
                        </div>
                    </div>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="bnr-container">
            <img src="../img/84393581_520040995295046_9031856357044649984_n.jpg" width="100%" height="100%" alt="Banner">
        </div>
        <div class="rtn-home">
            <a href="../index.php">
                <button>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </a>
        </div>
        <div class="pfe-container">
            <div class="user-profile">
                <div class="avatar-wrapper">
                    <img id="avatar" src="<?php echo $avatarSrc;?>" alt="Avatar" class="avatar">
                    <form id="avatarUpload" method="POST" enctype="multipart/form-data">
                        <label class="upload-label" for="fileUpload">Upload</label>
                        <input type="file" id="fileUpload" name="fileUpload" accept="image/*" onchange="uploadAvatar(event)">
                    </form>
                </div>
                <span>Hi, <?php echo htmlspecialchars($_SESSION['r_username']);?></span>
                <button onclick="openModal()"><i class="fa-regular fa-trash-can"></i></button>
            </div>
        </div>
        <div id="cfrmModal" class="modal">
        	<div class="mdl-content">
        		<p>Are you sure you want to delete your account?</p>
        		<form class="btn-group" id="deleteAccountForm">
        			<button class="confirm" onclick="deleteAccount()">Yes</button>
        			<button class="cancel" onclick="closeModal()">No</button>
        		</form>
        	</div>
        </div>
        <p class="infotxt-container">
            <?php if (!$userInfo): ?>
                Please enter your details to automatically save your information for future bookings and reservations.
            <?php else: ?>
                Your information has been saved! Enjoy seamless future bookings by entering just a few details.
            <?php endif; ?>
        </p>
        <div class="info-wrapper">
            <form method="POST" id="userInfoForm" class="userInfo">
                <div class="info-container">
                    <label for="fname">FULL NAME</label>
                    <input class="input" type="text" id="fname" name="fname" placeholder="Enter your full name" required>
                </div>
                <div class="info-container">
                    <label for="email">EMAIL</label>
                    <input class="input" type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="info-container">
                    <label for="number">PHONE NUMBER</label>
                    <input class="input" type="tel" id="number" name="number" placeholder="Enter your phone number" required>
                </div>
                <div class="info-container">
                    <label for="address">ADDRESS</label>
                    <input class="input" type="text" id="address" name="address" placeholder="Enter your address" required>
                </div>
                <div class="info-container">
                    <label for="datebirth">DATE OF BIRTH</label>
                    <input type="date" id="datebirth" name="datebirth" required>
                </div>
                <div class="info-container">
                    <label for="gender">GENDER</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="btn-info">
                <button class="btnSave" type="submit" id="btnSave">Save</button>
                <button class="btnChange" type="button" id="btnChange">Change</button>
                </div>
            </form>
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

    <script src="../js/manage_account.js"></script>
    <script>
		function uploadAvatar(event) {
		    event.preventDefault();
		    var formData = new FormData(document.getElementById('avatarUpload'));

		    fetch('', {
		        method: 'POST',
		        body: formData
		    })
		        .then(response => response.json())
		        .then(data => {
		            if (data.status === 'success') {
		                alert('Your image has been uploaded successfully!');
		                var avatarImage = document.getElementById('avatar');
		                avatarImage.src = "../uploads/" + formData.get('fileUpload').name;
		            } else {
		                alert(data.message || 'An error occurred.');
		            }
		        })
		        .catch(error => alert('Error: ' + error));
		}

		function openModal() {
		    document.getElementById('cfrmModal').style.display = 'flex';
		}

		function closeModal() {
		    document.getElementById('cfrmModal').style.display = 'none';
		}

		function deleteAccount() {
		    fetch('', {
		        method: 'POST',
		        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		        body: 'action=delete'
		    })
		        .then(response => response.json())
		        .then(data => {
		            alert(data.message);
		            if (data.status === 'success') {
		                window.location.href = 'logout.php';
		            }
		        })
		        .catch(error => console.error('Error:', error));
		}
    </script>

</body>

</html>
