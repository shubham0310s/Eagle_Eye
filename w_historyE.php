<?php
include("society_dbE.php");
session_start();
if (!isset($_SESSION['w_logged_in'])) {
  header("Location: index.html");
  exit;
}
if (isset($_SESSION["w_society"])) {
  $society = $_SESSION["w_society"];
  $vresult = mysqli_query($conn, "SELECT * FROM `visitor_table` WHERE `society_reg`='{$society}' AND `status`='Approved' OR `society_reg`='{$society}' AND `status`='Denied'");

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
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Watchman Dashboard </title>
  <link rel="shortcut icon" href="img/2.png" type="image/png">
  <link rel="stylesheet" href="css/dashE.css">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <a href="w_formE.php">
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
        <a href="#" class="active">
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
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">History</span>
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
        <!-- This end of account info function -->
    </nav>


    <div class="home-content">
      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="sales-details">
            <ul class="details">
              <li class="topic">Image</li>
              <?php
              if ($vresult) {
                while ($row = mysqli_fetch_array($vresult)) {

                  echo "<li><a href='visitor_image/" . $row['v_image'] . "'><img src='visitor_image/" . $row['v_image'] . "' height = '35px' width = '45px'></a></li>";
                }
                mysqli_data_seek($vresult, 0);
                ?>

              </ul>
              <ul class="details">
                <li class="topic">Name</li>
                <?php

                while ($row = mysqli_fetch_array($vresult)) {

                  echo "<li style='margin-top:30px; margin-bottom:30px'><a>" . $row['v_name'] . "</a></li>";
                }
                mysqli_data_seek($vresult, 0);

                ?>


              </ul>
              <ul class="details">
                <li class="topic">Phone_no</li>
                <?php

                while ($row = mysqli_fetch_array($vresult)) {

                  echo "<li style='margin-top:30px; margin-bottom:30px'><a>" . $row['phone_no'] . "</a></li>";
                }
                mysqli_data_seek($vresult, 0);

                ?>


              </ul>
              <ul class="details">
                <li class="topic">Flat_no</li>
                <?php

                while ($row = mysqli_fetch_array($vresult)) {

                  echo "<li style='margin-top:30px; margin-bottom:30px'><a>" . $row['flat_no'] . "</a></li>";
                }
                mysqli_data_seek($vresult, 0);

                ?>

              </ul>
              <ul class="details">
                <li class="topic">Date</li>
                <?php

                while ($row = mysqli_fetch_array($vresult)) {

                  echo "<li style='margin-top:30px; margin-bottom:30px'><a>" . $row['visiting_date'] . "</a></li>";
                }
                mysqli_data_seek($vresult, 0);

                ?>


              </ul>
              <ul class="details">
                <li class="topic">Reason</li>
                <?php

                while ($row = mysqli_fetch_array($vresult)) {

                  echo "<li style='margin-top:30px; margin-bottom:30px'><a>" . $row['visiting_purpose'] . "</a></li>";
                }
                mysqli_data_seek($vresult, 0);

                ?>


              </ul>
              <ul class="details">
                <li class="topic">Status</li>
                <?php

                while ($row = mysqli_fetch_array($vresult)) {

                  echo "<li style='margin-top:30px; margin-bottom:30px'><a>" . $row['status'] . "</a></li>";
                }
                mysqli_data_seek($vresult, 0);

                ?>

              </ul>
              <?php
              }
              ?>
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