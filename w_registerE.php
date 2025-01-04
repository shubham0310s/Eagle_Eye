<?php
session_start();
if (!isset($_SESSION['a_logged_in'])) {
	header("Location: index.html");
	exit;
}
// Include our connect script 
require_once("society_dbE.php");
$result = mysqli_query($conn, "SELECT * FROM `admin_table`");
$success = "";
$error_msg = "";

if (isset($_POST['registerBtn'])) {
	// Get all of the form data 
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$societyno = mysqli_real_escape_string($conn, $_POST['society_reg']);
	$passwd = mysqli_real_escape_string($conn, $_POST['password']);
	$passwd_again = mysqli_real_escape_string($conn, $_POST['conpassword']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone_no']);

	// Check if all fields are filled
	if ($name != "" && $passwd != "" && $passwd_again != "" && $societyno != "" && $email != "" && $phone != "") {
		// Ensure the two passwords match
		if ($passwd === $passwd_again) {
			// Validate password strength
			if (strlen($passwd) >= 8) {
				// Check for duplicates in the database
				$query = mysqli_query($conn, "SELECT * FROM `watchman_table` WHERE `w_email`='{$email}'");
				if ($query && mysqli_num_rows($query) > 0) {
					$check = mysqli_fetch_assoc($query);
					if ($check && $email == $check["w_email"]) {
						$error_msg = 'The E-mail <b>' . $email . '</b> is already taken. Please use another.';
					}
				} else {
					// Encrypt the password
					$passwd = md5($passwd);

					// Insert data into the database
					$insert_query = "INSERT INTO `watchman_table`(`w_password`, `society_reg`, `w_name`, `w_email`, `w_phno`) VALUES ('{$passwd}', '{$societyno}', '{$name}', '{$email}', '{$phone}')";

					if (mysqli_query($conn, $insert_query)) {
						$success = true;
					} else {
						$error_msg = 'Error inserting data: ' . mysqli_error($conn);
					}
				}
			} else {
				$error_msg = 'Your password is not strong enough. Please use another.';
			}
		} else {
			$error_msg = 'Your passwords did not match.';
		}
	} else {
		$error_msg = 'Please fill out all required fields.';
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Watchman</title>
	<link rel="shortcut icon" href="img/2.png" type="image/png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="css/registerE.css" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		input[type=number] {
			-moz-appearance: textfield;
		}
	</style>
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</head>

<body>
	<div class="register">

		<h1>Watchman Details</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
			<label for="name">
				<i class="fas fa-user"></i>
			</label>
			<input type="text" name="name" placeholder="Name" id="name" required>

			<label for="email">
				<i class="fas fa-envelope"></i>
			</label>
			<input type="email" name="email" placeholder="example@gmail.com" id="email" required>

			<label for="society_no">
				<i class="fas fa-building"></i>
			</label>
			<select name="society_reg" id="society_reg" required>
				<option value="" disabled selected>Society no</option>
				<?php
				if ($result) {
					while ($row = mysqli_fetch_array($result)) {
						$society = $row["society_reg"];
						echo "<option value='$society'>$society<br></option>";
					}
				}
				?>
			</select>


			<label for="phone_no">
				<i class="fas fa-user"></i>
			</label>
			<input type="number" name="phone_no" placeholder="Phone Number" id="phone_no" required>

			<label for="password">
				<i class="fas fa-lock"></i>
			</label>
			<input type="password" name="password" placeholder="Password" id="password" required>

			<label for="conpassword">
				<i class="fas fa-lock"></i>
			</label>
			<input type="password" name="conpassword" placeholder="Confirm Password" id="conpassword" required>

			<input type="submit" name="registerBtn" value="ADD">
			<?php
			if (isset($success) && $success == true) {
				echo '<script>
                          alert("Addition successful.");
                          window.location.assign("a_dashboardE.php");
                      </script>';
			}

			if (isset($error_msg)) {
				echo "<p>" . $error_msg . "</p>";
			}
			?>
		</form>
	</div>
</body>

</html>