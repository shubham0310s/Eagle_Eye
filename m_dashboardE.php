<?php
include("society_dbE.php");
// include("visitor_db.php");
session_start();
if (!isset($_SESSION['m_logged_in'])) {
  header("Location: index.html");
  exit;
}
if (isset($_SESSION['m_name']) && isset($_SESSION['m_email']) && isset($_SESSION['m_flat']) && isset($_SESSION['m_society'])) {
  $mname = $_SESSION['m_name'];
  $memail = $_SESSION['m_email'];
  $msociety = $_SESSION['m_society'];
  $mflat_no = $_SESSION['m_flat'];
  $find = $msociety . "_";
  $mflat = str_replace($find, "", $mflat_no);
} else {
  $mname = "name";
  $memail = "Email@gmail.com";
  $msociety = "0000";
  $mflat = "A000";

}

$m = mysqli_query($conn, "SELECT * FROM `member_table`");
$member = mysqli_num_rows($m);
$a = mysqli_query($conn, "SELECT * FROM `admin_table`");
$admin = mysqli_num_rows($a);
$w = mysqli_query($conn, "SELECT * FROM `watchman_table`");
$watchman = mysqli_num_rows($w);
$v = mysqli_query($conn, "SELECT * FROM `visitor_table`");
$visitor = mysqli_num_rows($v);

?><!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Member Dashboard </title>
  <link rel="shortcut icon" href="img/2.png" type="image/png">
  <link rel="stylesheet" href="css\dashE.css">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Event Box Container */
    .announcement-box {
      background-color: #f9f9f9;
      border-radius: 8px;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    /* Event Box Header */
    .announcement-box h3 {
      font-size: 24px;
      color: #333;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }

    /* Event List Styling */
    .announcement-box ul {
      list-style-type: none;
      padding: 0;
    }

    .announcement-box li {
      background-color: #ffffff;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: background-color 0.3s ease;
    }

    /* Hover Effect for List Items */
    .announcement-box li:hover {
      background-color: #f1f1f1;
    }

    /* Event Title */
    .announcement-box li .event-title {
      font-size: 18px;
      color: #333;
      font-weight: 500;
      margin-right: 20px;
      width: 70%;
    }

    /* Event Date */
    .announcement-box li .event-date {
      font-size: 14px;
      color: #888;
      text-align: right;
      width: 30%;
    }

    /* No Events Found Message */
    .announcement-box .no-events {
      text-align: center;
      font-size: 16px;
      color: #888;
      font-weight: 500;
    }
  </style>
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
        <a href="#" class="active">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">HOME</span>
        </a>
      </li>
      <li>
        <a href="m_bill.php">
          <i class='bx bx-receipt' class="active"></i>
          <span class="links_name">Bill</span>
        </a>
      </li>
      <li>
        <a href="m_event.php">
          <i class='bx bx-calendar'></i>
          <span class="links_name">Event</span>
        </a>
      </li>
      <li>
        <a href="m_requestE.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">APPROVE/DENIED</span>
          <?php
          if (isset($_SESSION[$mflat])) {
            $num = $_SESSION[$mflat];
            if ($num) {
              echo '<span class="material-icons">notifications</span>';
              echo '<span class="icon-button__badge">' . $num . '</span>';
            }
          }
          ?>
        </a>
      </li>
      <li>
        <a href="m_report.php">
          <i class='bx bx-box'></i>
          <span class="links_name">REPORT</span>
        </a>
      </li>
      <li>
        <a href="m_historyE.php">
          <i class='bx bx-box'></i>
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
            <img src="images/host2.png" alt="">
          </div>

          <div class="menu">
            <h3>
              <?php
              echo "<div id = 'eagleN'><b>" . $mname . "</b></div>";
              echo "<div id = 'eagleR'>Member</div>";
              echo "<div id = 'eagleN'>" . $memail . "</div>";
              echo "<div id = 'eagleG'>" . $msociety . "</div>";
              echo "<div id = 'eagleG'>" . $mflat . "</div>";
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
            <div class="box-topic">Visitor Visited</div>
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
            <div class="box-topic">Chat </div>
            <div class="number"> Interaction</div>
            <div class="indicator">
              <i class='bx bx-bell down'></i>
              <span class="text">Stay Updated Instantly</span>
            </div>
          </div>
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
          <div class="title">Work of the Members</div>
          <div class="sales-details">


            <ul class="details">
              <li class="topic">Invite Vistors with a Click:-</li>
              <li><a href="#">Use the app to invite visitors so they may enter the building immediately and avoid long
                  lines.</a></li>
              <li class="topic">Approve Guests with a Click:-</li>
              <li><a href="#">Have a visitor show up without warning? No problem , use the app to directly authorise or
                  deny the entry after receiving a alert from the gate security.</a></li>
              <li class="topic">Access All Visitor Records:-</li>
              <li><a href="#">Wondering when your delivery or visitor arrived? Check your visitor records to find out
                  their entry/exit time and date.</a></li>
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