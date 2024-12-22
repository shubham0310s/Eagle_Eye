<?php
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
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Member Dashboard </title>
  <link rel="shortcut icon" href="img/2.png" type="image/png">
  <link rel="stylesheet" href="css\dashE.css">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
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
        <a href="m_dashboardE.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">HOME</span>
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
        <a href="" class="active">
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
  <script>
    $(document).ready(function () {
      load_data();
      function load_data(query) {
        $.ajax({
          url: "m_fetch.php",
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