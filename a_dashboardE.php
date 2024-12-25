<?php
include("society_dbE.php");
session_start();
if (!isset($_SESSION['a_logged_in'])) {
  header("Location: index.html");
  exit;
}
if (isset($_SESSION["a_society"])) {
  $society = $_SESSION["a_society"];
  $mresult = mysqli_query($conn, "SELECT * FROM `member_table` WHERE `society_reg`='{$society}'");
  $wresult = mysqli_query($conn, "SELECT * FROM `watchman_table` WHERE `society_reg`='{$society}'");
  $find = $society . "_";

}
if (isset($_SESSION['a_name']) && isset($_SESSION['a_email'])) {
  $aname = $_SESSION['a_name'];
  $aemail = $_SESSION['a_email'];
} else {
  $aname = "name";
  $aemail = "Email@gmail.com";
}

?>

<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <title> Admin Dashboard </title>
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

      &emsp;&emsp;&emsp;
      <span class="logo_name">Eagle Eye</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="a_dashboardE.php" class="active">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">HOME</span>
        </a>
      </li>
      <li>
        <a href="a_event.php">
          <i class='bx bx-calendar'></i>
          <span class="links_name">Event</span>
        </a>
      </li>

      <li>
        <a href="a_reportm.php">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">Member Report</span>
        </a>
      </li>
      <li>
        <a href="a_reportw.php">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">Watchman Report</span>
        </a>
      </li>
      <li>
        <a href="a_historyE.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">HISTORY</span>
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

  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">HOME</span>
      </div>
      <!-- This start of account info function -->

      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link
          href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
          rel="stylesheet">
      </head>
      <div class="action">
        <div class="profile" onclick="menuToggle();">
          <img src="images/host.png" alt="">
        </div>

        <div class="menu">
          <h3>
            <?php
            echo "<div id = 'eagleN'><b>" . $aname . "</b></div>";
            echo "<div id = 'eagleR'> Admin </div>";
            echo "<div id = 'eagleG'>" . $aemail . "</div>";
            echo "<div id = 'eagleG'>" . $society . "</div>";
            ?>
          </h3>
          <ul>
            <li>
              <span class="material-icons icons-size">mode</span>
              <a href="change_passE.php">Change Password</a>
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
      <div class="overview-boxes">
        <div class="box">
          <a href="m_registerE.php">
            <div class="right-side">
              <div class="box-topic"></div>
              <div class="number">Member Registration</div>
              <div class="indicator">
                <span class="text"></span>
              </div>
            </div>
          </a>
        </div>
        <div class="box">
          <a href="w_registerE.php">
            <div class="right-side">
              <div class="box-topic"></div>
              <div class="number">Watchman Registration</div>
              <div class="indicator">
                <span class="text"></span>
              </div>
            </div>
          </a>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Member</div>


            <?php

            $m = mysqli_num_rows($mresult);
            echo "<div class='number'>" . $m . "</div>";
            ?>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">IN Society</span>
            </div>
          </div>
          <i class='bx bx-user-circle bx-lg user'></i>
        </div>

        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Watchman</div>
            <?php

            $w = mysqli_num_rows($wresult);
            echo "<div class='number'>" . $w . "</div>";
            ?>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">In Society</span>
            </div>
          </div>
          <i class='bx bx-user-circle bx-lg user'></i>
        </div>
      </div>
    </div>

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
</section>

</html>