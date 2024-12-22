<?php
include('society_dbE.php');
session_start();
$success = "";
$errmsg = "";
if (isset($_SESSION['random_number']) && isset($_SESSION['attempt'])) {
	if (isset($_POST['submit'])) {
		$otp = $_POST['otp'];
		//var_dump($otp);
		//var_dump($_SESSION['random_number']);
		if ($otp == $_SESSION['random_number']) {
			if (isset($_SESSION['aid']) && isset($_SESSION['apasswd']) && isset($_SESSION['asociety']) && isset($_SESSION['aemail']) && isset($_SESSION['aname'])) {
				$id = $_SESSION['aid'];
				$passwd = $_SESSION['apasswd'];
				$society = $_SESSION['asociety'];
				$email = $_SESSION['aemail'];
				$name = $_SESSION['aname'];


				mysqli_query($conn, "INSERT INTO `admin_table` VALUES (
					'{$id}', '{$passwd}', '{$society}', '{$email}', '{$name}'
				)");


				// verify the user's account was created
				$query = mysqli_query($conn, "SELECT * FROM `admin_table` WHERE `admin_id`='{$id}' AND `society_reg`='{$society}' ");
				if (mysqli_num_rows($query) == 1) {

					unset($_SESSION['aid']);
					unset($_SESSION['apasswd']);
					unset($_SESSION['asociety']);
					unset($_SESSION['aemail']);
					unset($_SESSION['aname']);
					$success = true;

				}
			}



		} else {

			$errmsg = "<script> alert('Wrong OTP') </script>";
		}
	}
} else {
	$errmsg = "Error connecting";
}
if (time() > $_SESSION['expire']) {
	unset($_SESSION['random_number']);
	unset($_SESSION['expire']);

}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title> Verification </title>
	<link rel="shortcut icon" href="img/2.png" type="image/png">
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
				id="otp" required>


			<b>Didn't received OTP </b>&nbsp;<a href="newotpE.php">SEND
				Again</a>&nbsp;<br>
			<?php
			// check to see if the user successfully created an account
			if (isset($success) && $success == true) {
				echo '<script>
						  alert(" Verification successfull ");
						  // Load a new URL in the current window
						  window.location.assign("loginE.php");
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