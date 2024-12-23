<?php
session_start();
if (!isset($_SESSION['a_logged_in'])) {
	header("Location: index.html");
	exit;
}
// include our connect script 
require_once("society_dbE.php");
$result = mysqli_query($conn, "SELECT * FROM `admin_table`");
$success = "";
$error_msg = "";
if (isset($_POST['registerBtn'])) {
	// get all of the form data 
	// $id = mysqli_real_escape_string($conn, $_POST['member_id']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$societyno = mysqli_real_escape_string($conn, $_POST['society_reg']);
	$flat = mysqli_real_escape_string($conn, $_POST['flat_no']);
	$residence = mysqli_real_escape_string($conn, $_POST['Residence']);
	$phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
	$passwd = mysqli_real_escape_string($conn, $_POST['password']);
	$passwd_again = mysqli_real_escape_string($conn, $_POST['conpassword']);

	if ($name != "" && $passwd != "" && $passwd_again != "" && $societyno != "" && $email != "" && $flat != "" && $residence != "") {
		// make sure the two passwords match
		if ($passwd === $passwd_again) {
			// make sure the password meets the min strength requirements
			if (strlen($passwd) >= 5) {
				// query the database to see if the username is taken
				$query = mysqli_query($conn, "SELECT * FROM `member_table` WHERE `flat_no`='{$flat}' OR `m_email`='{$email}'");
				$check = mysqli_fetch_array($query);

				// $mid = $check["member_id"] ?? "";
				$mflat = $check["flat_no"] ?? "";
				$memail = $check["m_email"] ?? "";

				// if ($id != $mid) {
				if ($flat != $mflat) {
					if ($email != $memail) {
						if (mysqli_num_rows($query) == 0) {
							// create and format some variables for the database
							$passwd = md5($passwd);
							$flatno = $societyno . '_' . $flat;
							mysqli_query($conn, "INSERT INTO `member_table`( `m_password`, `m_name`, `society_reg`, `residence`,phone_no, `flat_no`, `m_email`) VALUES ('{$id}','{$passwd}','{$name}','{$societyno}','{$residence}','{$phone_no}','{$flatno}','{$email}')");

							// verify the user's account was created
							$query = mysqli_query($conn, "SELECT * FROM `member_table` WHERE  `flat_no`='{$flatno}'");
							if (mysqli_num_rows($query) == 1) {
								$success = true;
							}
						}
					} else
						$error_msg = 'The Email<b>' . $email . '</b> is already taken. Please use another.';
				} else
					$error_msg = 'The Flat <b>' . $flat . '</b> is already taken. Please use another.';
				// } else
				// $error_msg = 'The ID <b>' . $id . '</b> is already taken. Please use another.';
			} else
				$error_msg = 'Your password is not strong enough. Please use another.';
		} else
			$error_msg = 'Your passwords did not match.';
	} else
		$error_msg = 'Please fill out all required fields.';
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Member</title>
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
		<h1>Member Detail</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off" id="formId">
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

			<label for="flat_no">
				<i class="fa fa-home"></i>
			</label>
			<input type="text" name="flat_no" placeholder="Flat no eg. A111" id="flat_no" required>

			<label for="residence">
				<i class="fas fa-building"></i>
			</label>
			<select name="Residence" id="Residence" required>
				<option value="" disabled selected>Residence</option>
				<option value='Owned'>Owned</option>
				<option value='On Rent'>Rent</option>
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
		</form>

		<!-- jQuery Validation -->
		<script>
			$(document).ready(function () {
				$('#registrationForm').submit(function (e) {
					// Prevent form submission
					e.preventDefault();

					// Validation for Name
					const name = $('#name').val();
					if (!/^[A-Za-z\s]+$/.test(name)) {
						alert("Name can only contain letters and spaces.");
						return false;
					}

					// Validation for Email
					const email = $('#email').val();
					if (!/.+@gmail\.com$/.test(email)) {
						alert("Email must be a valid Gmail address.");
						return false;
					}

					// Validation for Flat Number
					const flatNo = $('#flat_no').val();
					if (!/^[A-Za-z0-9\s\-]+$/.test(flatNo)) {
						alert("Flat number can include alphabet and numbers like A121");
						return false;
					}

					// Validation for Phone Number
					const phoneNo = $('#phone_no').val();
					if (!/^[0-9]{10}$/.test(phoneNo)) {
						alert("Phone number must be exactly 10 digits.");
						return false;
					}

					// Validation for Password
					const password = $('#password').val();
					if (!/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%]).{8,}/.test(password)) {
						alert("Password must contain at least 8 characters, including uppercase, lowercase, numbers, and special characters.");
						return false;
					}

					// Validation for Confirm Password
					const confirmPassword = $('#conpassword').val();
					if (password !== confirmPassword) {
						alert("Passwords do not match.");
						return false;
					}

					// If all validations pass, submit the form
					this.submit();
				});
			});
		</script>

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
		<!-- <input type="submit" name="registerBtn" value="ADD"> -->
		</form>
	</div>
</body>

</html>