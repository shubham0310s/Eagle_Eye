<?php
include("society_dbE.php");
session_start();
$success = "";
$error_msg = "";
if (isset($_POST["check"])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['roles']);
    $_SESSION['user'] = $role;
    $_SESSION['f_mail'] = $email;
    //var_dump( $_SESSION['user']);
    //var_dump( $_SESSION['f_mail']);

    if ($role == 'admin') {
        $query = mysqli_query($conn, "SELECT * FROM `admin_table` WHERE `a_email`='{$email}'");
        if (mysqli_num_rows($query) == 1) {

            $seed = time();
            mt_srand($seed);
            $_SESSION['email_number'] = mt_rand(100000, 999999);
            $_SESSION['limit'] = time() + 600; // expire in 10 minutes
            $otp = ($_SESSION['email_number']);
            $message = "<h1>" . $otp . "</h1><br>
                        Is your one time password for Email verification ";
        } else {
            $error_msg = 'Invalid email address ';
        }

    } elseif ($role == 'member') {
        $query = mysqli_query($conn, "SELECT * FROM `member_table` WHERE `m_email`='{$email}'");
        if (mysqli_num_rows($query) == 1) {

            $seed = time();
            mt_srand($seed);
            $_SESSION['email_number'] = mt_rand(100000, 999999);
            $_SESSION['limit'] = time() + 600; // expire in 10 minutes
            $otp = ($_SESSION['email_number']);
            $message = "<h1>" . $otp . "</h1><br>
                        Is your one time password for Email verification ";
        } else {
            $error_msg = 'Invalid email address';
        }

    } elseif ($role == 'watchman') {
        $query = mysqli_query($conn, "SELECT * FROM `watchman_tabe` WHERE `w_email`='{$email}'");
        if (mysqli_num_rows($query) == 1) {

            $seed = time();
            mt_srand($seed);
            $_SESSION['email_number'] = mt_rand(100000, 999999);
            $_SESSION['limit'] = time() + 600; // expire in 10 minutes
            $otp = ($_SESSION['email_number']);
            $message = "<h1>" . $otp . "</h1><br>
                        Is your one time password for Email verification ";

        } else {
            $error_msg = 'Invalid email address ';
        }
    }
    if (isset($otp) && isset($message) && isset($email)) {


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
        $mail->Password = 'qvxwtozigesmgmww';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                      // TCP port to connect to
        $mail->clearCustomHeaders();

        //Recipients
        $mail->setFrom('demonslayer1me2u@gmail.com', 'Mailer');
        $mail->addAddress($email, 'Recipient');     // Add a recipient
        $mail->addReplyTo('demonslayer1me2u@gmail.com', 'Information');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Eagle Eye';
        $mail->Body = $message;
        $mail->AltBody = 'You GOT A Visitor';

        //send the message and check for errors
        if (!$mail->send()) {
            echo " Email failed to sent ";
        }
        //Mailer function ends here */

        if (time() > $_SESSION['limit']) {
            unset($_SESSION['email_number']);
            unset($_SESSION['limit']);

        }

        $success = true;
    }

}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title>Email</title>
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
        <h1>Change password </h1>
        <form method="post" autocomplete="off">



            <label for="email" class="lab">
                <i class="fas fa-envelope"></i>
            </label>
            <input type="text" name="email" pattern=".+@gmail\.com" placeholder="example@gmail.com" id="email" required>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>$(document).ready(function () {
                    $("#email").on("blur", function () {
                        if (!$(this).val().match(/^.+@gmail\.com$/)) {
                            alert("Please enter a valid email address");
                        }
                    });
                });
            </script>


            <div class="radio">
                <input label="Admin" type="radio" id="ad" name="roles" value="admin" checked>
                <input label="Member" type="radio" id="mem" name="roles" value="member">
                <input label="Watchman" type="radio" id="watc" name="roles" value="watchman">
            </div>


            <?php
            // check to see if the user successfully created an account
            if (isset($success) && $success == true) {
                echo '<script>
						  alert("A 6 Digit OTP number has sent to your Email");
						  // Load a new URL in the current window
						  window.location.assign("fotpE.php");
					  </script>';
            }
            if (isset($error_msg)) {
                echo "<p>" . $error_msg . "</p>";
            }
            ?>

            <input type="submit" name="check" value="sent">
        </form>
    </div>
</body>

</html>