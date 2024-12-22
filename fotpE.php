<?php
session_start();
$success = "";
$errmsg = "";
if (isset($_SESSION['email_number']) && isset($_SESSION['limit'])) {
	if (isset($_POST['submit'])) {
		$otp = $_POST['otp'];
		//var_dump($otp);
		//var_dump($_SESSION['random_number']);
		if ($otp == $_SESSION['email_number']) {
			$success = true;
		} else {

			$errmsg = "<script> alert('Wrong OTP') </script>";
		}
	}
} else {
	$errmsg = "Error connecting";
}
if (isset($_SESSION['limit'])) {
	if (time() > $_SESSION['limit']) {
		unset($_SESSION['email_number']);
		unset($_SESSION['limit']);
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title> Verification </title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="css/registerE.css" rel="stylesheet" type="text/css">
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</head>

<body>
	<div class="register">
		<h1>Enter OTP</h1>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off">
			<label for="OTP Code">
				<i class="fas fa-user"></i>
			</label>
			<input type="number" style='letter-spacing: 16px; font-size: 20px; ' name="otp" placeholder="0-0-0-0-0-0"
				id="otp" required autofocus>

			<?php
			// check to see if the user successfully created an account
			if (isset($success) && $success == true) {
				echo '<script>
						  alert(" Verification successfull ");
						  // Load a new URL in the current window
						  window.location.assign("forgot_pawdE.php");
					  </script>';
			}
			if (isset($errmsg)) {

				echo "<p>" . $errmsg . "</p><br>";
			}
			?>
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
</body>

</html>