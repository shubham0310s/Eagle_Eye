<?php
require("society_dbE.php");
session_start();
if (!isset($_SESSION['w_logged_in'])) {
  header("Location: index.html");
  exit;
}
if (isset($_SESSION['w_name']) && isset($_SESSION['w_email']) && isset($_SESSION['w_society'])) {
  $wname = $_SESSION['w_name'];
  $wemail = $_SESSION['w_email'];
  $wsociety = $_SESSION['w_society'];
} else {
  $wname = "name";
  $wemail = "Email@gmail.com";
  $wsociety = "0000";
}
$society = "";
date_default_timezone_set("Asia/Kolkata");

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
  if (isset($_POST['captured_image']) && !empty($_POST['captured_image'])) {
    $capturedImage = $_POST['captured_image'];
    $imageData = explode(',', $capturedImage);

    if (count($imageData) == 2) {
      $imageBase64 = $imageData[1];
      $imageName = uniqid("visitor_", true) . ".png";
      $imagePath = "visitor_image/" . $imageName;

      // Save image to server
      if (file_put_contents($imagePath, base64_decode($imageBase64))) {
        // Database insertion logic
      } else {
        $error_msg = "Error saving image.";
      }
    } else {
      $error_msg = "Invalid image data.";
    }
  } else {
    $error_msg = "Captured image is missing.";
  }


  if ($name != "" && $phone != "" && $flat != "" && $meet != "" && $capturedImage != "") {
    // if (($file_type = "image/jpeg" || $file_type = "image/png") && $file_size <= 41943040) {
    //"images" is just a folder name here we will load the file.
    $date = date('Y-m-d H:i:s.u');

    mysqli_query($conn, "INSERT INTO `visitor_table`(`visitor_id`, `v_name`, `v_image`, `society_reg`, `phone_no`, `visiting_date`, `visiting_purpose`, `flat_no`, `status`) VALUES ('{}','{$name}','{$imageName}','{$society}','{$phone}','{$date}','{$meet}','{$flat}','pending')");
    // move_uploaded_file($file_path, 'visitor_image/' . $imageName);
    // verify the user's account was created

    $query = mysqli_query($conn, "SELECT * FROM `visitor_table` WHERE `v_name`='{$name}' AND `phone_no`='{$phone}'");

    if (mysqli_num_rows($query) == 1) {

      $success = true;

      $sql = "SELECT * FROM `visitor_table` WHERE `flat_no`='{$flat}' AND `status`='pending'";
      $result = mysqli_query($conn, $sql);
      if (isset($result)) {
        $_SESSION[$flat] = mysqli_num_rows($result);
      }

      $flat_no = $society . "_" . $flat;
      $Q = mysqli_query($conn, "SELECT `m_email` FROM `member_table` WHERE `flat_no`='{$flat_no}'");
      $rmail = mysqli_fetch_array($Q);
      $message = "<h2>
                    <pre>YOU GOT A VISITOR!
                       <b>Name :</b>" . $name . "
                       <b>Phone :</b>" . $phone . "
                       <b>Reason :</b>" . $meet . "
                    </pre>
                  </h2>";


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
      $mail->Username = 'eagleeye@gmail.com';                 // SMTP username
      $mail->Password = 'rkzygqmlaqwfdqat';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('eagleeye@gmail.com', 'Mailer');
      $mail->addAddress($rmail["m_email"], 'Recipient');     // Add a recipient
      $mail->addReplyTo('eagleeye@gmail.com', 'Information');

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Eagle Eye';
      $mail->Body = $message;
      $mail->AltBody = 'YOU GOT A VISITOR';

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
  // $error_msg = 'Please fill out all required fields.';
}

// check to see if the user successfully created an account
if (isset($success) && $success == true) {
  echo '<script>alert("sent Successful")</script>';
}
if (isset($error_msg)) {
  echo "<p>" . $error_msg . "</p>";
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
          <span class="links_name">HOME</span>
        </a>
      </li>
      <li>
        <a href="#" class="active">
          <i class='bx bx-box'></i>
          <span class="links_name">VISITOR ENTRY</span>
        </a>
      </li>
      <li>
        <a href="w_chat.php">
          <i class='bx bx-chat'></i>
          <span class="links_name">CHAT</span>
        </a>
      </li>
      <li>
        <a href="w_report.php">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">MEMBER REPORT</span>
        </a>
      </li>
      <li>
        <a href="w_historyE.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">HISTORY</span>
        </a>
      </li>


      <li class="log_out">
        <a href="session_unsetE.php">
          <i class='bx bx-log-out'></i>
          <span class="links_name">LOG OUT</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- This end of account info function -->
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Visitor Entry</span>
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
              <?php
              echo "<div id = 'eagleN'><b>" . $wname . "</b></div>";
              echo "<div id = 'eagleR'> Watchman </div>";
              echo "<div id = 'eagleG'>" . $wemail . "</div>";
              echo "<div id = 'eagleG'>" . $wsociety . "</div>";
              ?>
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

          <label for="fname">Photo</label>
          <br>

          <!-- Video preview (for capturing images) -->
          <video id="video" autoplay style="width: 300px; height: 200px; border: 1px solid #ccc;"></video>

          <!-- Canvas to store the captured image -->
          <canvas id="canvas" style="display: none;"></canvas>

          <br>
          <!-- Buttons for camera capture -->
          <button type="button" id="capture-btn">Capture Image</button>

          <br><br>
          <input type="submit" name="sent" value="Submit">


          <script>
            const video = document.getElementById("video");
            const canvas = document.getElementById("canvas");
            const captureBtn = document.getElementById("capture-btn");
            const uploadBtn = document.getElementById("upload-btn");
            const capturedImageInput = document.getElementById("captured_image");

            // Access the user's webcam
            navigator.mediaDevices.getUserMedia({ video: true })
              .then(stream => {
                video.srcObject = stream;
              })
              .catch(error => {
                console.error("Error accessing webcam:", error);
              });

            // Capture image from video
            captureBtn.addEventListener("click", (e) => {
              e.preventDefault(); // Prevent form submission
              const context = canvas.getContext("2d");
              canvas.width = video.videoWidth;
              canvas.height = video.videoHeight;
              context.drawImage(video, 0, 0, canvas.width, canvas.height);
              const imageDataURL = canvas.toDataURL("image/png"); // Convert canvas to Base64
              capturedImageInput.value = imageDataURL; // Store Base64 string in hidden input
              uploadBtn.style.display = "block"; // Show the upload button
            });
          </script>

        </form>
      </div>
    </div>
    </div>
    </div>
  </section>


  <script>
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

</body>

</html>