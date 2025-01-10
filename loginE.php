<?php
// include our connect script 
require_once("society_dbE.php");
$error_msg = "";
session_start();

if (isset($_POST['logg'])) {	//setting credential 
	$role = mysqli_real_escape_string($conn, $_POST['roles']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$passwd = mysqli_real_escape_string($conn, $_POST['password']);
	$passwd = md5($passwd);
	//checking 
	if ($role == 'admin') {
		$query = mysqli_query($conn, "SELECT * FROM `admin_table` WHERE `a_email`='{$email}' AND `ad_password` = '{$passwd}'");
		if (mysqli_num_rows($query) == 1) {
			while ($row = mysqli_fetch_array($query)) {
				$_SESSION["a_name"] = $row["a_name"];
				$_SESSION["a_society"] = $row["society_reg"];
				$_SESSION["a_email"] = $row["a_email"];
				$_SESSION['a_logged_in'] = true;
				$_SESSION['a_role'] = $role;

				// Redirect to the home page
				header('location: a_dashboardE.php');

			}
		} else {
			$error_msg = 'Invalid email or password';
		}

	} elseif ($role == 'member') {
		$query = mysqli_query($conn, "SELECT * FROM `member_table` WHERE `m_email`='{$email}' AND `m_password`='{$passwd}'");
		if (mysqli_num_rows($query) == 1) {
			while ($row = mysqli_fetch_array($query)) {
				$_SESSION["m_id"] = $row["member_id"];
				$_SESSION["m_name"] = $row["m_name"];
				$_SESSION["m_email"] = $row["m_email"];
				$_SESSION["m_flat"] = $row["flat_no"];
				$_SESSION["m_society"] = $row["society_reg"];
				$_SESSION['m_logged_in'] = true;
				$_SESSION['m_role'] = $role;

				// Redirect to the home page
				header('location: m_dashboardE.php');



			}
		} else {
			$error_msg = 'Invalid email or password';
		}

	} elseif ($role == 'watchman') {
		$query = mysqli_query($conn, "SELECT * FROM `watchman_table` WHERE `w_email`='{$email}' AND `w_password`='{$passwd}'");
		if (mysqli_num_rows($query) == 1) {
			while ($row = mysqli_fetch_array($query)) {
				$_SESSION["w_id"] = $row["watchman_id"];
				$_SESSION["w_name"] = $row["w_name"];
				$_SESSION["w_email"] = $row["w_email"];
				$_SESSION['w_society'] = $row["society_reg"];
				$_SESSION['w_logged_in'] = true;
				$_SESSION['w_role'] = $role;


				// Redirect to the home page
				header('location: w_dashboardE.php');



			}
		} else {
			$error_msg = 'Invalid email or password';
		}


	} else {
		$error_msg = "Please select user roles";
	}
}

?>

<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<title>Login</title>
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
		<h1>Login</h1>
		<form method="post">



			<label for="email" class="lab">
				<i class="fas fa-envelope"></i>
			</label>
			<input type="text" name="email" pattern=".+@gmail\.com" placeholder="example@gmail.com" id="email" required>

			<script>$(document).ready(function () {
					$("#email").on("blur", function () {
						if (!$(this).val().match(/.+@gmail\.com/)) {
							alert("Please enter a valid email address ");
						}
					});
				});
			</script>


			<label for="password" class="lab">
				<i class="fas fa-lock"></i>
			</label>
			<input type="password" name="password" placeholder="Password" minlength="8" id="password"
				title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" required
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
			<div>
				<lable><a href="emailE.php" style=" margin-right: 235px ;"> Forgot Password? </a></lable>
			</div>

			<div class="radio">
				<input label="Admin" type="radio" id="ad" name="roles" value="admin" checked>
				<input label="Member" type="radio" id="mem" name="roles" value="member">
				<input label="Watchman" type="radio" id="watc" name="roles" value="watchman">
			</div>

			<?php
			echo "<p>" . $error_msg . "</p>";
			?>
			<input type="submit" name="logg" value="Login">
		</form>
	</div>
</body>

</html>