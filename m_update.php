<?php
// include our connect script 
require_once("society_dbE.php");
session_start();
if (!isset($_SESSION['a_logged_in'])) {
  header("Location: index.html");
  exit;
}

$success = "";
$error_msg = "";
if (isset($_POST['mupdate'])) {
  $id = $_POST['mupdate'];
  $sql = mysqli_query($conn, "SELECT * FROM `member_table` WHERE `member_id`='{$id}'");
  if ($sql) {
    $member = mysqli_fetch_array($sql);
  }
  if (isset($_SESSION["a_society"])) {
    $society = $_SESSION["a_society"];
    $find = $society . "_";
    $flat = str_replace($find, "", $member["flat_no"]);
  }
}
if (isset($_POST['update'])) {

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $flatno = mysqli_real_escape_string($conn, $_POST['flat_no']);
  $mid = mysqli_real_escape_string($conn, $_POST['id']);
  $residence = mysqli_real_escape_string($conn, $_POST['Residence']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone_no']);
  $society = $_SESSION["a_society"];
  if ($name != "" && $email != "" && $flatno != "" && $mid != "" && $residence != "") {

    // create and format some variables for the database
    $flatno = $society . "_" . $flatno;
    //var_dump($flatno);
    $update = mysqli_query($conn, "UPDATE `member_table` SET `m_name`='{$name}',`flat_no`='{$flatno}',`m_email`='{$email}',`phone_no`='{$phone}',`residence`='{$residence}' WHERE `member_id`='{$mid}'");
    if ($update)
      $success = true;

  }

}



?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Update</title>
  <link rel="shortcut icon" href="img/2.png" type="image/png">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <link href="css/registerE.css" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</head>

<body>
  <div class="register">
    <h1>Member Detail</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">

      <label for="name">
        <i class="fas fa-user"></i>
      </label>
      <input type="text" name="name" placeholder="Name" value="<?php if (isset($member))
        echo "$member[m_name]"; ?>" id="name" required>

      <script>$(document).ready(function () {
          $("#name").on("blur", function () {
            if (!$(this).val().match(/^[a-zA-Z]+ [a-zA-Z]+$/)) {
              alert("Please enter a valid name");
            }
          });
        });
      </script>


      <label for="email">
        <i class="fas fa-envelope"></i>
      </label>
      <input type="email" name="email" placeholder="E-mail" value="<?php if (isset($member))
        echo "$member[m_email]"; ?>" id="email" required>
      <script>$(document).ready(function () {
          $("#email").on("blur", function () {
            if (!$(this).val().match(/^.+@gmail\.com$/)) {
              alert("Please enter a valid email address");
            }
          });
        });
      </script>

      <label for="residence">
        <i class='fas fa-building'></i>
      </label>
      <select name="Residence" required>
        <option value="" disabled selected>Residence</option>
        <option value='Owned'>Owned</option>
        <option value='On Rent'>Rent</option>
      </select><br>

      <label for="phone_no">
        <i class="fas fa-user"></i>
      </label>
      <input type="number" name="phone_no" value="<?php if (isset($member))
        echo "$member[phone_no]"; ?>" placeholder="phone_no" id="phone_no" required>

      <label for="flat_no">
        <i class="fa fa-home"></i>
      </label>
      <input type="text" name="flat_no" placeholder="Flat_no" value="<?php if (isset($member))
        echo "$flat"; ?>" id="flat_no" required>

      <script>$(document).ready(function () {
          $("#flat_no").on("blur", function () {
            if (!$(this).val().match(/^[a-zA-Z0-9]+$/)) {
              alert("Please enter a valid flat number");
            }
          });
        });

        var phone = document.getElementById("phone_no");

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
      </script>

      <?php
      // check to see if the user successfully created an account
      if (isset($success) && $success == true) {
        echo '<script>
                      alert("Update Successfull");
                      // Load a new URL in the current window
                      window.location.assign("a_dashboardE.php");
                  </script>';
      }

      if (isset($error_msg)) {
        echo "<p>" . $error_msg . "</p>";
      }
      ?>
      <input type="submit" name="update" value="update">
    </form>
  </div>
</body>

</html>