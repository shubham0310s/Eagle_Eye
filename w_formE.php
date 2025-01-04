<?php
require("society_dbE.php");
session_start();
if (!isset($_SESSION['w_logged_in'])) {
  header("Location: index.html");
  exit;
}
$society = "";
date_default_timezone_set("Asia/Kolkata");
// Database connection information for society data 
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'society_data';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

$society = $_SESSION['w_society'];
$result = mysqli_query($conn, "SELECT `flat_no` FROM `member_table` WHERE `society_reg`='{$society}'");
$success = "";
$error_msg = "";

if (isset($_POST['sent'])) {

  $name = mysqli_real_escape_string($conn, $_POST['firstname']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $flat = mysqli_real_escape_string($conn, $_POST['flat']);
  $meet = mysqli_real_escape_string($conn, $_POST['meet']);

  //storing all necessary data into the respective variables.
  $file = $_FILES['file'];
  $file_name = $file['name'];
  $file_type = $file['type'];
  $file_size = $file['size'];
  $file_path = $file['tmp_name'];

  if ($name != "" && $phone != "" && $flat != "" && $meet != "" && $file_name != "") {
    if (($file_type = "image/jpeg" || $file_type = "image/png") && $file_size <= 41943040) {
      //"images" is just a folder name here we will load the file.
      $date = date('Y-m-d H:i:s.u');

      mysqli_query($con, "INSERT INTO `visitor_table`(`visitor_id`, `v_name`, `v_image`, `society_reg`, `phone_no`, `visiting_date`, `visiting_purpose`, `flat_no`, `status`) VALUES ('{}','{$name}','{$file_name}','{$society}','{$phone}','{$date}','{$meet}','{$flat}','pending')");
      move_uploaded_file($file_path, 'visitor_image/' . $file_name);
      // verify the user's account was created

      $query = mysqli_query($con, "SELECT * FROM `visitor_table` WHERE `v_name`='{$name}' AND `phone_no`='{$phone}'");

      if (mysqli_num_rows($query) == 1) {

        $success = true;

        $sql = "SELECT * FROM `visitor_table` WHERE `flat_no`='{$flat}' AND `status`='pending'";
        $result = mysqli_query($con, $sql);
        if (isset($result)) {
          $_SESSION[$flat] = mysqli_num_rows($result);
        }

        $flat_no = $society . "_" . $flat;
        $Q = mysqli_query($conn, "SELECT `m_email` FROM `member_table` WHERE `flat_no`='{$flat_no}'");
        $rmail = mysqli_fetch_array($Q);
        $message = "<h2><pre>YOU GOT A VISITOR!!

             <b>Name :</b>" . $name . "
             <b>Phone :</b>" . $phone . "
             <b>Reasone :</b>" . $meet . "
             
             </pre></h2>";


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
        $mail->Username = 'eagleeye.local@gmail.com';                 // SMTP username
        $mail->Password = 'qvxwtozigesmgmww';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('eagleeye.local@gmail.com', 'Mailer');
        $mail->addAddress($rmail["m_email"], 'Recipient');     // Add a recipient
        $mail->addReplyTo('eagleeye.local@gmail.com', 'Information');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Eagle Eye';
        $mail->Body = $message;
        $mail->AltBody = 'You GOT A Visitor';

        //send the message and check for errors
        if (!$mail->send()) {
          echo " Email failed to sent ";
        }
        //Mailer function ends here 

      }

    } else {
      $error_msg = 'Please choose valid file type';
    }

  } else {
    $error_msg = 'Please fill out all required fields.';
  }
}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Watchman Dashboard </title>
  <link rel="shortcut icon" href="img/2.png" type="image/png">
  <link rel="stylesheet" href="css/dashE.css">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

  </script>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="./img/logo.png" alt="Eagle Eye Logo" style="width: 50px; height: auto;" />

      &emsp; &emsp; &emsp; <span class="logo_name">Eagle Eye </span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="w_dashboardE.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Home</span>
        </a>
      </li>
      <li>
        <a href="#" class="active">
          <i class='bx bx-box'></i>
          <span class="links_name">Visitor Entry</span>
        </a>
      </li>
      <li>
        <a href="w_historyE.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">History</span>
        </a>
      </li>
      <li>
        <a href="w_report.php">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">Member report</span>
        </a>
      </li>

      <li class="log_out">
        <a href="session_unsetE.php">
          <i class='bx bx-log-out'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <!-- This start of account info function -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link
    href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
    rel="stylesheet">
  </head>

  <body>
    <div class="action">
      <div class="profile" onclick="menuToggle();">
        <img src="images/host3.png" alt="">
      </div>

      <div class="menu">
        <h3>
          <div id="eagleN"><b>
              User Name</b>
          </div>
          <div id="eagleR">
            MEMBER
          </div>
          <div id="eagleG">
            admin@gmail.com
          </div>
        </h3>
        <ul>
          <li>
            <span class="material-icons icons-size">mode</span>
            <a href="change_passE.php">Edit Password</a>
          </li>
        </ul>
      </div>
    </div>
    <script>
      function menuToggle() {
        const toggleMenu = document.querySelector('.menu');
        toggleMenu.classList.toggle('active')
      }
    </script>
    <!-- This end of account info function -->
    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class='bx bx-menu sidebarBtn'></i>
          <span class="dashboard">Visitor Entry</span>
        </div>
      </nav>

      <div class="home-content">

        <div class="container">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="formId" enctype="multipart/form-data">

            <label for="fname">Name</label>
            <input type="text" id="fname" name="firstname" placeholder="Your name.." required>

            <script>
              $(document).ready(function () {
                var alertShown = false; // Flag to track alert state

                $("#fname").on("blur", function () {
                  // Only trigger validation if the alert hasn't been shown already
                  if (!alertShown && !$(this).val().match(/^[a-zA-Z]+ [a-zA-Z]+$/)) {
                    alert("Please enter a valid name (first and last name only).");
                    alertShown = true; // Set the flag to true once the alert is shown
                  } else {
                    alertShown = false; // Reset flag once a valid name is entered
                  }
                });
              });
            </script>


            <label for="lname">Phone No.</label><br>
            <input type="text" id="phone" name="phone" placeholder="1234-567-890" maxlength="10" required>

            <script>
              $(document).ready(function () {
                var alertShown = false; // Flag to track if the alert has been shown

                $("#phone").on("blur", function () {
                  var phoneValue = $(this).val();

                  // Regular expression for phone number in the format 1234-567-890
                  var phonePattern = /^[0-9]{4}-[0-9]{3}-[0-9]{3}$/;

                  // Only trigger the alert if the pattern doesn't match and alert hasn't been shown already
                  if (!alertShown && !phoneValue.match(phonePattern)) {
                    alert("Please enter a valid phone number in the format 1234-567-890.");
                    alertShown = true; // Set the flag to true once the alert is shown
                  } else {
                    alertShown = false; // Reset the flag when a valid phone number is entered
                  }
                });
              });
            </script>

            <label for="country">Flat No.</label>
            <select id="country" name="flat">
              <option value="" disabled selected>Flat no </option>
              <?php
              $find = $society . "_";

              if ($result) {

                while ($row = mysqli_fetch_array($result)) {
                  $flat = str_replace($find, "", $row["flat_no"]);
                  echo "<option value='$flat'>$flat<br></option>";
                }
              }

              ?>
            </select><br>

            <label for="fname">Reason to meet</label>
            <input type="text" id="fname" name="meet" placeholder="Reason " required><br>

            <div class="file-upload-wrapper" data-text=" Image ">
              <input type="file" name="file" id="file" accept="image/png, image/jpeg" onchange="validateImage()" />
              <p id="error-message" style="color: red; display: none;">Please upload only PNG or JPEG images.</p>
            </div><br>

            <script>
              function validateImage() {
                var file = document.getElementById("file").files[0];
                var fileType = file ? file.type : "";

                // Check if the file is an image (PNG or JPEG)
                if (fileType !== "image/png" && fileType !== "image/jpeg") {
                  document.getElementById("error-message").style.display = "block"; // Show error message
                  document.getElementById("file").value = ""; // Clear the file input
                } else {
                  document.getElementById("error-message").style.display = "none"; // Hide error message
                }
              }
            </script>




            <input type="submit" name="sent" value="Submit">

          </form>
        </div>


      </div>
      </div>
      </div>
    </section>

    <script>
      // Get the phone input element
      var phone = document.getElementById("phone");
      var form = document.getElementById("formId");
      // Add an event listener for the "blur" event
      phone.addEventListener("blur", function () {
        // Get the phone number
        var phoneNumber = phone.value;

        // Regular expression to match 10 digits
        var regex = /^\d{10}$/;

        // Check if the phone number matches the regular expression
        if (!regex.test(phoneNumber)) {
          alert("Please enter a valid 10-digit phone number");
          phone.value = "";
        }
      });

      // Add an event listener for the "submit" event
      form.addEventListener("submit", function (e) {
        // Get the phone number
        var phoneNumber = phone.value;

        // Regular expression to match 10 digits
        var regex = /^\d{10}$/;

        // Check if the phone number matches the regular expression
        if (!regex.test(phoneNumber)) {
          alert("Please enter a valid 10-digit phone number");
          e.preventDefault();
        }
      });
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
          sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      }
    </script>
    <?php
    // check to see if the user successfully created an account
    if (isset($success) && $success == true) {
      echo '<script>alert("sent Successful")</script>';
    }
    if (isset($error_msg)) {
      echo "<p>" . $error_msg . "</p>";
    }
    ?>

  </body>

</html>