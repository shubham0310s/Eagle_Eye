<?php
include("society_dbE.php");
// include("visitor_db.php");
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
$m = mysqli_query($conn, "SELECT * FROM `member_table`");
$member = mysqli_num_rows($m);
$a = mysqli_query($conn, "SELECT * FROM `admin_table`");
$admin = mysqli_num_rows($a);
$w = mysqli_query($conn, "SELECT * FROM `watchman_table`");
$watchman = mysqli_num_rows($w);
$v = mysqli_query($conn, "SELECT * FROM `visitor_table`");
$visitor = mysqli_num_rows($v);

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
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="./img/logo.png" alt="Eagle Eye Logo" style="width: 50px; height: auto;" />

      &emsp; &emsp; &emsp; <span class="logo_name">Eagle Eye </span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="#" class="active">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Home</span>
        </a>
      </li>
      <li>
        <a href="w_formE.php">
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
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Home</span>
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
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Users</div>
            <div class="number"><?php echo $member + $admin + $watchman; ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Till Now</span>
            </div>
          </div>
          <i class='bx bx-user-circle bx-lg user'></i>
        </div>


        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Society</div>
            <div class="number"><?php echo $admin; ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Till Now</span>
            </div>
          </div>
          <i class='bx bx-building bx-lg building'></i>
        </div>


        <div class="box">
          <div class="right-side">
            <div class="box-topic"> Visitor Visited </div>
            <div class="number"><?php echo $visitor; ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Till Now</span>
            </div>
          </div>
          <i class='bx bx-history bx-lg history'></i>
        </div>


        <div class="box">
          <div class="right-side">
            <div class="box-topic">New </div>
            <div class="number">Features</div>
            <div class="indicator">
              <i class='bx bx-down-arrow-alt down'></i>
              <span class="text">Coming Soon</span>
            </div>
          </div>

        </div>
      </div>

      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Work of the WatchMen</div>
          <div class="sales-details">


            <ul class="details">
              <li class="topic">Vistors Entry:-</li>
              <li><a href="#">A quick entry and authorisation process for new visitors along with the opition of adding
                  frequent visitors.</a></li>
              <li class="topic">Mobile Intercom:-</li>
              <li><a href="#">Providing multiple options to reach residents when they have to authorise the entry of a
                  visitor. No more depending on the traditional intercom or landline.</a></li>
              <li class="topic">Online Visitor Management:-</li>
              <li><a href="#">Rack all the visitors(staff/guests/vendors) visiting your socitey through Eagle Eye making
                  your society more secure.</a></li>
            </ul>

          </div>
        </div>
        <div class="top-sales box">
          <div class="title"></div>
          <img src="images/build1.jpg" class="build">
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

</html>