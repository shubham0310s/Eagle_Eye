<?php
// include our connect script 
require_once("society_dbE.php");
$error_msg = "";
session_start();
if (!isset($_SESSION['w_logged_in']) && !isset($_SESSION['m_logged_in']) && !isset($_SESSION['a_logged_in'])) {
	header("Location: index.html");
	exit;
}

if (isset($_SESSION['a_role'])) {
	$role = $_SESSION['a_role'];
} elseif (isset($_SESSION['m_role'])) {
	$role = $_SESSION['m_role'];
} elseif (isset($_SESSION['w_role'])) {
	$role = $_SESSION['w_role'];
} else
	$role = 'notdefined';


if (isset($_POST['logg'])) {	//setting credential 
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$passwd = mysqli_real_escape_string($conn, $_POST['old_password']);
	$new_passwd = mysqli_real_escape_string($conn, $_POST['new_password']);
	$con_passwd = mysqli_real_escape_string($conn, $_POST['confi_password']);
	$passwd = md5($passwd);
	//checking 


	if ($role == 'admin') {

		$query = mysqli_query($conn, "SELECT * FROM `admin_table` WHERE `a_email`='{$email}' AND `ad_password` = '{$passwd}'");
		if (mysqli_num_rows($query) == 1) {
			if ($new_passwd === $con_passwd) {
				$new_passwd = md5($new_passwd);
				if ($passwd != $new_passwd) {

					$q = "UPDATE `admin_table` SET `ad_password`='{$new_passwd}'WHERE `a_email`='{$email}'";
					if ($update = mysqli_query($conn, $q)) {
						echo '<script>
									  alert("Sucessfull Updated password");
									  // Load a new URL in the current window
									  window.location.assign("a_dashboardE.php");
								  </script>';

					} else
						$error_msg = "Error updation database ";

				} else
					$error_msg = "New and old password cannot be same ";

			} else
				$error_msg = 'Password and confirm Password must be same ';
		} else
			$error_msg = 'Invalid email or password';


	} elseif ($role == 'member') {

		$query = mysqli_query($conn, "SELECT * FROM `member_table` WHERE `m_email`=''{$email} AND `m_password`='{$passwd}'");
		if (mysqli_num_rows($query) == 1) {
			if ($new_passwd === $con_passwd) {
				$new_passwd = md5($new_passwd);
				if ($passwd != $new_passwd) {

					$q = "UPDATE `member_table` SET `m_password`='{$new_passwd}'WHERE `m_email`='{$email}'";
					if ($update = mysqli_query($conn, $q)) {
						echo '<script>
									  alert("Sucessfull Updated password");
									  // Load a new URL in the current window
									  window.location.assign("m_dashboardE.php");
								  </script>';

					} else
						$error_msg = "Error updation database ";

				} else
					$error_msg = "New and old password cannot be same ";

			} else
				$error_msg = 'Password and confirm Password must be same ';

		} else {
			$error_msg = 'Invalid email or password';
		}

	} elseif ($role == 'watchman') {

		$query = mysqli_query($conn, "SELECT * FROM `watchman_tabe` WHERE `w_email`='{$email}' AND `w_password`='{$passwd}'");
		if (mysqli_num_rows($query) == 1) {
			if ($new_passwd === $con_passwd) {
				$new_passwd = md5($new_passwd);
				if ($passwd != $new_passwd) {

					$q = "UPDATE `watchman_tabe` SET `w_password`='{$new_passwd}'WHERE `w_email`='{$email}'";
					if ($update = mysqli_query($conn, $q)) {
						echo '<script>
									  alert("Sucessfull Updated password");
									  // Load a new URL in the current window
									  window.location.assign("w_dashboardE.php");
								  </script>';

					} else
						$error_msg = "Error updation database ";

				} else
					$error_msg = "New and old password cannot be same ";

			} else
				$error_msg = 'Password and confirm Password must be same ';

		} else
			$error_msg = "Invalid email or password";

	} else
		$error_msg = " Please login to update password ";
}


?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Change Password</title>
	<link rel="shortcut icon" href="img/2.png" type="image/png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="css/loginsE.css" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</head>

<body>
	<div class="login">
		<h1> Change Password </h1>
		<form method="post">



			<label for="email" class="lab">
				<i class="fas fa-envelope"></i>
			</label>
			<input type="text" name="email" pattern=".+@gmail\.com" placeholder="example@gmail.com" id="email" required>

			<script>$(document).ready(function () {
					$("#email").on("blur", function () {
						if (!$(this).val().match(/^.+@gmail\.com$/)) {
							alert("Please enter a valid gmail address");
						}
					});
				});
			</script>


			<label for="old_password" class="lab">
				<i class="fas fa-lock"></i>
			</label>
			<input type="password" name="old_password" placeholder="Current Password" minlength="8" id="old_password"
				required>

			<label for="new_password" class="lab">
				<i class="fas fa-lock"></i>
			</label>
			<input title="Password must contain at least 8 characters, including UPPER/lowercase and numbers"
				type="password" name="new_password" placeholder="New Password" minlength="8" id="new_password" required
				required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="
  this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
  if(this.checkValidity()) form.confi_password.pattern = RegExp.escape(this.value);
  ">

			<label for="confi_password" class="lab">
				<i class="fas fa-lock"></i>
			</label>
			<input title="Please enter the same Password as above" type="password"
				title="Please enter the same Password as above" type="password" name="confi_password"
				placeholder="Confirm Password" minlength="8" id="confi_password" required
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="
  this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
  ">

			<?php
			if (isset($error_msg)) {
				echo "<p>" . $error_msg . "</p>";
			}
			?>

			<input type="submit" name="logg" value="Change ">
		</form>
	</div>
</body>

</html>