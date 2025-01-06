<?php
// include our connect script 
require_once("society_dbE.php");

// check to see if there is a user already logged in, if so redirect them 
session_start();
$success = "";
$error_msg = "";
if (isset($_SESSION['name']) && isset($_SESSION['admin_id']))
	header("Location: ./dashboardE.php");  // redirect the user to the home page

if (isset($_POST['registerBtn'])) {
	// get all of the form data 
	// $id = mysqli_real_escape_string($conn, $_POST['admin_id']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$society = mysqli_real_escape_string($conn, $_POST['society_reg']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$passwd = mysqli_real_escape_string($conn, $_POST['password']);
	$passwd_again = mysqli_real_escape_string($conn, $_POST['conpassword']);

	if ($name != "" && $passwd != "" && $passwd_again != "" && $society != "" && $email != "") {
		// make sure the two passwords match
		if ($passwd === $passwd_again) {
			// make sure the password meets the min strength requirements
			if (strlen($passwd) >= 5 != false) {
				// query the database to see if the username is taken
				$query = mysqli_query($conn, "SELECT * FROM `admin_table` WHERE  `society_reg`='{$society}' OR  `a_email`='{$email}' ");
				if (mysqli_num_rows($query) == 0) {
					// create and format some variables for the database
					$passwd = md5($passwd);
					// $_SESSION['aid'] = $id;
					$_SESSION['apasswd'] = $passwd;
					$_SESSION['asociety'] = $society;
					$_SESSION['aemail'] = $email;
					$_SESSION['aname'] = $name;


					$seed = time();
					mt_srand($seed);
					$_SESSION['random_number'] = mt_rand(100000, 999999);
					$_SESSION['expire'] = time() + 600; // expire in 10 minutes
					$_SESSION['attempt'] = 1;
					$_SESSION['mail'] = $email;
					$otp = ($_SESSION['random_number']);
					$message = "<h1>" . $otp . "</h1><br>
									  Is your one time password for Email verification ";
					//var_dump($otp);


					//mailer function start here do not touch without permission
					require 'C:\xampp\htdocs\testmail\mail\PHPMailer-master\src\PHPMailer.php';
					require 'C:\xampp\htdocs\testmail\mail\PHPMailer-master\src\SMTP.php';
					require 'C:\xampp\htdocs\testmail\mail\PHPMailer-master\src\Exception.php';

					$mail = new PHPMailer\PHPMailer\PHPMailer();
					$mail->IsSMTP(); // enable SMTP

					//Server settings
					$mail->SMTPDebug = 2;                                 // Enable verbose debug output                               
					$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'demonslayer1me2u@gmail.com';                 // SMTP username
					$mail->Password = 'demonkongslayer@#';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    // TCP port to connect to

					//Recipients
					$mail->setFrom('demonslaye1me2u@gmail.com', 'Mailer');
					$mail->addAddress($email, 'Recipient');     // Add a recipient
					$mail->addReplyTo('demonslayer1me2u@gmail.com', 'Information');

					//Content
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = 'Eagle Eye';
					$mail->Body = $message;
					$mail->AltBody = '';

					//send the message and check for errors
					if (!$mail->send()) {
						echo " Email failed to sent ";
					}
					//Mailer function ends here */

					if (time() > $_SESSION['expire']) {
						unset($_SESSION['random_number']);
						unset($_SESSION['expire']);
					}

					$success = true;


				} else
					$error_msg = 'The ID <b>' . $id . '</b> and SOCIETY NO <b>' . $society . '</b> is already logged in. Please use another.';
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
	<title>Register</title>
	<link rel="shortcut icon" href="img/2.png" type="image/png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="css/registerE.css" rel="stylesheet" type="text/css">
	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		/* Firefox */
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
		<h1>Welcome to Eagle Eye</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">


			<label for="name">
				<i class="fas fa-user"></i>
			</label>
			<input type="text" title="Enter your username" name="name" placeholder="Name" id="name" required>

			<script>
				$(document).ready(function () {
					$("#name").on("blur", function () {
						// Regular expression to validate the name (first and last name)
						if (!$(this).val().match(/^[a-zA-Z]+ [a-zA-Z]+$/)) {
							alert("Please enter a valid name. The name should contain only letters and a space between first and last names.");
						}
					});
				});
			</script>



			<label for="society no">
				<i class='fas fa-building'></i>
			</label>
			<input type="number" name="society_reg" placeholder="Society No." id="society_reg" min="1000" max="9999"
				required>

			<script>
				$(document).ready(function () {
					$("#society_reg").on("blur", function () {
						if (!$(this).val().match(/^[1-9][0-9]{4}$/)) {
							alert("Please enter a valid Society_reg (4 digits starting from 1000 to 9999).");
						}
					});
				});
			</script>

			<label for="password">
				<i class="fas fa-lock"></i>
			</label>
			<input type="password"
				title="Password must contain at least 8 characters, including UPPER/lowercase and numbers"
				name="password" placeholder="Password" minlength="8" id="password" required
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="
  this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
  if(this.checkValidity()) form.conpassword.pattern = RegExp.escape(this.value);
">



			<label for="password">
				<i class="fas fa-lock"></i>
			</label>
			<input type="password" title="Please enter the same Password as above" name="conpassword"
				placeholder="Confirm Password" minlength="8" id="conpassword" required
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="
  this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
">


			<label for="email">
				<i class="fas fa-envelope"></i>
			</label>
			<input type="email" name="email" pattern=".+@gmail\.com" placeholder="example@gmail.com" id="email"
				required>

			<script>$(document).ready(function () {
					$("#email").on("blur", function () {
						if (!$(this).val().match(/^.+@\gmail.com$/)) {
							alert("Please enter a valid gmail address");
						}
					});
				});
			</script>

			<?php
			// check to see if the user successfully created an account
			if (isset($success) && $success == true) {
				echo '<script>
						  alert("A 6 Digit OTP number has sent to your Email");
						  // Load a new URL in the current window
						  window.location.assign("otpE.php");
					  </script>';
			}
			if (isset($error_msg)) {
				echo "<p>" . $error_msg . "</p>";
			}
			?>
			<b>Already Registered! </b>&nbsp;<a href="loginE.php">LOGIN NOW </a>
			<input type="submit" name="registerBtn" value="Register">
		</form>
	</div>
</body>

</html>