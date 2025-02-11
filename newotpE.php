<?php
session_start();
if (isset($_SESSION['random_number']) && isset($_SESSION['attempt']) && isset($_SESSION['mail'])) {
    if ($_SESSION['attempt'] < 4) {

        echo "<script> alert('A new OTP will be sent to your Email ') </script>";
        $seed = time();
        mt_srand($seed);
        $_SESSION['random_number'] = mt_rand(100000, 999999);
        $_SESSION['expire'] = time() + 600; // expire in 10 minutes
        $email = $_SESSION['mail'];
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
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output                               
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'eayleeye@gmail.com';                 // SMTP username
        $mail->Password = 'rkzygqmlaqwfdqat';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('eayleeye@gmail.com', 'Mailer');
        $mail->addAddress($email, 'Recipient');     // Add a recipient
        $mail->addReplyTo('eayleeye@gmail.com', 'Information');


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
        $_SESSION['attempt'] = $_SESSION['attempt'] + 1;
        // var_dump($_SESSION['attempt']);

        if (time() > $_SESSION['expire']) {
            unset($_SESSION['random_number']);
            unset($_SESSION['expire']);
            unset($_SESSION['mail']);

        }

    } elseif ($_SESSION['attempt'] == 5) {


        $_SESSION['expire'] = time() + 600;
        if (time() > $_SESSION['expire']) {
            unset($SESSION_['attempt']);
            unset($_SESSION['random_number']);
            unset($_SESSION['expire']);
            unset($_SESSION['mail']);

        }
        $_SESSION['attempt'] = $_SESSION['attempt'] + 1;
        echo "<script> alert('Maximum attempt for OTP has reached try again after some time') </>";

    } else {
        echo "<script> alert('Maximum attempt for OTP has reached try again after some time') </script>";
    }
}
?>
<META HTTP-EQUIV="refresh" CONTENT="0; url = otpE.php">