<?php
include("visitor_db.php");
session_start();
if (!isset($_SESSION['a_logged_in'])) {
  header("Location: index.html");
  exit;
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
  <title>Admin Dashboard</title>
  <link rel="shortcut icon" href="img/2.png" type="image/png">
  <link rel="stylesheet" href="css/dashE.css">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="./img/logo.png" alt="Eagle Eye Logo" style="width: 50px; height: auto;" />
      &emsp;&emsp;&emsp; <span class="logo_name">Eagle Eye</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="a_dashboardE.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">HOME</span>
        </a>
      </li>
      <li>
        <a href="a_event.php">
          <i class='bx bx-calendar'></i>
          <span class="links_name"> Event</span>
        </a>
      </li>

      <li>
        <a href="a_reportm.php">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">Member Report</span>
        </a>
      </li>
      <li>
        <a href="#" class="active">
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
        <span class="dashboard"> REPORT</span>
      </div>

      <div class="search-box">
        <br />
        <br />
        <br />
        <div class="form-group">
          <div class="input-group">
            <div class="search-box">
              <input type="text" id="search_text" placeholder="Search...">
            </div>
          </div>
        </div>
        <br />

        <div id="result"></div>
      </div>
      <div style="clear:both"></div>
      <br />
      <br />
      <br />
      <br />

      <script>
        function menuToggle() {
          const toggleMenu = document.querySelector('.menu');
          toggleMenu.classList.toggle('active');
        }
      </script>
    </nav>
  </section>

  <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function () {
      sidebar.classList.toggle("active");
      if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else {
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      }
    }
  </script>
  <script>
    $(document).ready(function () {
      load_data(); // Load all watchmen initially

      function load_data(query = '') {
        $.ajax({
          url: "a_fetch.php",
          method: "post",
          data: { query: query },
          success: function (data) {
            $('#result').html(data);
          }
        });
      }

      $('#search_text').keyup(function () {
        const search = $(this).val();
        load_data(search); // Pass the search value
      });
    });
  </script>

</body>

</html>