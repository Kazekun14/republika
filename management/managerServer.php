<?php
require '../php/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_POST['crntUsername'] !== $_POST['myAccountUsername']) {
		$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? ");
		$stmt->bind_param("s", $_POST['myAccountUsername']);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows <= 0) {
			$stmt = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
			$stmt->bind_param("ss", $_POST['myAccountUsername'], $_POST['crntUsername']);
			$stmt->execute();

			$stmt->close();

			if (isset($_FILES['avatar'])) {
			    $avatar = $_FILES['avatar']['name'];
			    $target = "../uploads/" . basename($avatar);

			    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
			        $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE username = ?");
			        $stmt->bind_param("ss", $avatar, $_POST['myAccountUsername']);
			        $stmt->execute();
			    }
			}

			$stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
			$stmt->bind_param("s", $_POST['crntUsername']);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$stmt = $conn->prepare("UPDATE userinfo SET username = ?, fullname = ?, email = ?, number = ?, address = ?, datebirth = ?, gender = ? WHERE username = ?");
				$stmt->bind_param("ssssssss", $_POST['myAccountUsername'], $_POST['myAccountFullname'], $_POST['myAccountEmail'], $_POST['myAccountNumber'], $_POST['myAccountAddress'], $_POST['myAccountDatebirth'], $_POST['myAccountGender'], $_POST['crntUsername']);

				$stmt->close();

				echo json_encode(['success' => true, 'message' => "Your manager account details have been successfully updated."]);
				exit;
			} else if ($result->num_rows <= 0) {
				$stmt = $conn->prepare("INSERT INTO userinfo (username, fullname, email, number, address, datebirth, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssss", $_POST['myAccountUsername'], $_POST['myAccountFullname'], $_POST['myAccountEmail'], $_POST['myAccountNumber'], $_POST['myAccountAddress'], $_POST['myAccountDatebirth'], $_POST['myAccountGender']);
				$stmt->execute();

				$stmt->close();

				echo json_encode(['success' => true, 'message' => "Your manager account details have been successfully updated."]);
				exit;
			}
		} else if ($result->num_rows > 0) {
			echo json_encode(['success' => false, 'message' => "An account with these manager details already exists."]);
			exit;
		}

		$stmt->close();
	}

	if (isset($_FILES['avatar'])) {
	    $avatar = $_FILES['avatar']['name'];
	    $target = "../uploads/" . basename($avatar);

	    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
	        $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE username = ?");
	        $stmt->bind_param("ss", $avatar, $_POST['myAccountUsername']);
	        $stmt->execute();
	    }
	}

	$stmt = $conn->prepare("SELECT * FROM userinfo WHERE username = ?");
	$stmt->bind_param("s", $_POST['myAccountUsername']);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$stmt = $conn->prepare("UPDATE userinfo SET fullname = ?, email = ?, number = ?, address = ?, datebirth = ?, gender = ? WHERE username = ?");
		$stmt->bind_param("sssssss", $_POST['myAccountFullname'], $_POST['myAccountEmail'], $_POST['myAccountNumber'], $_POST['myAccountAddress'], $_POST['myAccountDatebirth'], $_POST['myAccountGender'], $_POST['myAccountUsername']);
		$stmt->execute();

		echo json_encode(['success' => true, 'message' => "Your manager account details have been successfully updated."]);
		exit;
	} else if ($result->num_rows <= 0) {
		$stmt = $conn->prepare("INSERT INTO userinfo (username, fullname, email, number, address, datebirth, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $_POST['myAccountUsername'], $_POST['myAccountFullname'], $_POST['myAccountEmail'], $_POST['myAccountNumber'], $_POST['myAccountAddress'], $_POST['myAccountDatebirth'], $_POST['myAccountGender']);
			$stmt->execute();

		echo json_encode(['success' => true, 'message' => "Your manager account details have been successfully updated."]);
		exit;
	}
}
?>