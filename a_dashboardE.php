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

<html lang="en" dir="ltr">


<head>
  <meta charset="UTF-8">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <title> Admin Dashboard </title>
  <link rel="shortcut icon" href="img/2.png" type="image/png">
  <link rel="stylesheet" href="css/dashE.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="./img/logo.png" alt="Eagle Eye Logo" style="width: 50px; height: auto;" />
      &emsp;&emsp;&emsp; <span class="logo_name">Eagle Eye</span>
    </div>

    <ul class="nav-links">
      <li>
        <a href="a_dashboardE.php" class="active">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">HOME</span>
        </a>
      </li>
      <li>
        <a href="a_bill.php">
          <i class='bx bx-receipt'></i>
          <span class="links_name">Bill</span>
        </a>
      </li>
      <li>
        <a href="a_historyE.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">HISTORY</span>
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
        function mcheckdelete() {
          return confirm('Are you sure you want to delete this record ');
        }
        function wcheckdelete() {
          return confirm('Are you sure you want to delete this record ');
        }

      </script>

      <!-- This end of account info function -->

    </nav>


    <div class="home-content">
      <div class="overview-boxes">
        <div class="box static-box">
          <a href="m_registerE.php">
            <!-- <div class="right-side"> -->
            <div class="box-topic"></div>
            <div class="number"> Add Member
            </div>
            <!-- <div class="indicator">
              - <i class='bx bx-up-arrow-alt'></i> -->
            <!-- <span class="text"></span> -->
            <!-- </div> -->
            <!-- </div> -->
            <!-- <i class='bx bx-cart-alt cart'></i> -->

          </a>
        </div>
        <div class="overview-boxes"></div>
        <div class="box">
          <a href="w_registerE.php">
            <div class="right-side">
              <div class="box-topic"></div>
              <div class="number">Add Watchman</div>
              <div class="indicator">
                <!-- <i class='bx bx-up-arrow-alt'></i> -->
                <span class="text"></span>
              </div>
            </div>
            <!-- <i class='bx bx-cart-alt cart'></i> -->
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
              <span class="text">In Your Society</span>
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
              <span class="text">In Your Society</span>
            </div>
          </div>
          <i class='bx bx-user-circle bx-lg user'></i>
        </div>
      </div>
    </div>

    <!-- Event Calendar Section -->
    <div style="margin-top: 30px; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
      <h2 style="text-align: center; font-size: 24px; margin-bottom: 20px;">Event Calendar</h2>
      <div id="calendar"
        style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; font-family: Arial, sans-serif;">
        <!-- Calendar days will be dynamically added here -->
      </div>
    </div>
    <!DOCTYPE html>




    <script>
      function generateCalendar() {
        const daysInMonth = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate();
        const firstDayIndex = new Date(new Date().getFullYear(), new Date().getMonth(), 1).getDay();
        const calendar = document.getElementById('calendar');
        const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Add week day headers
        weekDays.forEach(day => {
          const dayElement = document.createElement('div');
          dayElement.textContent = day;
          dayElement.style.fontWeight = 'bold';
          dayElement.style.textAlign = 'center';
          dayElement.style.borderBottom = '1px solid #ccc';
          calendar.appendChild(dayElement);
        });

        // Add blank spaces for days before the first day
        for (let i = 0; i < firstDayIndex; i++) {
          const blankSpace = document.createElement('div');
          calendar.appendChild(blankSpace);
        }

        // Add days of the current month
        for (let i = 1; i <= daysInMonth; i++) {
          const dayCell = document.createElement('div');
          dayCell.textContent = i;
          dayCell.style.padding = '10px';
          dayCell.style.textAlign = 'center';
          dayCell.style.border = '1px solid #ccc';
          dayCell.style.cursor = 'pointer';
          dayCell.onclick = () => alert(`Clicked on day ${i}`);
          calendar.appendChild(dayCell);
        }
      }

      // Generate the calendar on page load
      generateCalendar();
    </script>


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