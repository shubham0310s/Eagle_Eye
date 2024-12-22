<?php
// include our connect script 
include_once("society_dbE.php");
$sucess = "";
$error_msg = "";
session_start();

if (isset($_POST['logg'])) {	//setting credential 
    if (isset($_SESSION['f_mail']) && isset($_SESSION['user'])) {
        $email = $_SESSION['f_mail'];
        $role = $_SESSION['user'];
    } else {
        $role = "undefined";
        $email = " ";
    }
    //var_dump($email);
    //var_dump($role);

    $new_passwd = mysqli_real_escape_string($conn, $_POST['new_password']);
    $con_passwd = mysqli_real_escape_string($conn, $_POST['confi_password']);

    //var_dump($new_passwd);
    //var_dump($con_passwd);

    if ($role == 'admin') {

        if ($new_passwd === $con_passwd) {
            $new_passwd = md5($new_passwd);
            $q = "UPDATE `admin_table` SET `ad_password`='{$new_passwd}'WHERE `a_email`='{$email}'";

            if ($update = mysqli_query($conn, $q)) {

                unset($_SESSION['f_mail']);
                unset($_SESSION['user']);
                $success = true;
            } else
                $error_msg = "Error updating password ";
        } else
            $error_msg = 'Password and confirm Password must be same ';


    } elseif ($role == 'member') {

        if ($new_passwd === $con_passwd) {
            $new_passwd = md5($new_passwd);

            $q = "UPDATE `member_table` SET `m_password`='{$new_passwd}'WHERE `m_email`='{$email}'";
            if ($update = mysqli_query($conn, $q)) {

                unset($_SESSION['f_mail']);
                unset($_SESSION['user']);
                $success = true;

            } else
                $error_msg = "Error updation database ";

        } else
            $error_msg = 'Password and confirm Password must be same ';

    } elseif ($role == 'watchman') {

        if ($new_passwd === $con_passwd) {
            $new_passwd = md5($new_passwd);

            $q = "UPDATE `watchman_tabe` SET `w_password`='{$new_passwd}'WHERE `w_email`='{$email}'";
            if ($update = mysqli_query($conn, $q)) {

                unset($_SESSION['f_mail']);
                unset($_SESSION['user']);
                $success = true;
            } else
                $error_msg = "Error updation database ";

        } else
            $error_msg = 'Password and confirm Password must be same ';

    } else
        $error_msg = " There is an error when choosing the user account ";
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
            // check to see if the user successfully created an account
            if (isset($success) && $success == true) {
                echo '<script>
						  alert("Password Updated Successfully");
						  // Load a new URL in the current window
						  window.location.assign("loginE.php");
					  </script>';
            }
            if (isset($error_msg)) {
                echo "<p>" . $error_msg . "</p>";
            }
            ?>

            <input type="submit" name="logg" value="Change ">
        </form>
    </div>
</body>

</html>