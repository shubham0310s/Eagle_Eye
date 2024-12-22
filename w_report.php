<?php
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
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
        <a href="" class="active">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">Member report</span>
        </a>
      </li>
      <li>
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
        <span class="dashboard">REPORT</span>
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
    <script>
      $(document).ready(function () {
        load_data();
        function load_data(query) {
          $.ajax({
            url: "w_fetch.php",
            method: "post",
            data: { query: query },
            success: function (data) {
              $('#result').html(data);
            }
          });
        }

        $('#search_text').keyup(function () {
          var search = $(this).val();
          if (search != '') {
            load_data(search);
          }
          else {
            load_data();
          }
        });
      });
    </script>

</body>

</html>