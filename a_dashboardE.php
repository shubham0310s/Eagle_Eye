<?php
// Start the session
session_start();

// Include the database connection
include("society_dbE.php");

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  // Redirect to login page if not logged in
  header("Location: loginE.php");
  exit;
}

// Check if required cookies are set
if (isset($_COOKIE['a_email']) && isset($_COOKIE['user_role']) && isset($_COOKIE['logged_in']) && isset($_COOKIE['a_name'])) {
  // Assign session variables from cookies
  $_SESSION['a_email'] = $_COOKIE['a_email'];
  $_SESSION['a_name'] = $_COOKIE['a_name'];
  $_SESSION['user_role'] = $_COOKIE['user_role'];
  $_SESSION['logged_in'] = $_COOKIE['logged_in'];

  // Restrict access for non-admin users or unauthenticated users
  if ($_SESSION['user_role'] !== 'admin' || $_SESSION['logged_in'] !== '1') {
    // Redirect non-admins or unauthenticated users to the login page
    header("Location: loginE.php");
    exit();
  }
}

// Session timeout logic
$timeout = 1800; // 30 minutes timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
  // Destroy the session if timed out
  session_unset();
  session_destroy();
  header("Location: index.html");
  exit;
}

// Update the last activity timestamp
$_SESSION['last_activity'] = time();

// Assign session variables
$society = isset($_SESSION["a_society"]) ? $_SESSION["a_society"] : "";
$aname = isset($_SESSION['a_name']) ? $_SESSION['a_name'] : "Name";
$aemail = isset($_SESSION['a_email']) ? $_SESSION['a_email'] : "Email@gmail.com";

// Fetch data from the database
$mresult = $society ? mysqli_query($conn, "SELECT * FROM `member_table` WHERE `society_reg`='{$society}'") : false;
$wresult = $society ? mysqli_query($conn, "SELECT * FROM `watchman_table` WHERE `society_reg`='{$society}'") : false;
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
        <a href="a_chat.php">
          <i class='bx bx-chat'></i>
          <span class="links_name">Chat</span>
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
          <div class="right-side">
            <div class="box-topic">Member</div>
            <a href="m_registerE.php">
              <div class="right-side">
                <div class="box-topic"></div>
                <div class="number">Registration</div>

              </div>
            </a>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">IN Society</span>
            </div>
          </div>
          <div class="indicator"></div>
          <i class='bx bx-user-circle bx-lg user'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Watchman</div>
            <a href="w_registerE.php">
              <div class="right-side">
                <div class="box-topic"></div>
                <div class="number">Registration</div>
              </div>
            </a>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">IN Society</span>
            </div>
          </div>
          <i class='bx bx-user-circle bx-lg user'></i>
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