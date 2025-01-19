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
        <a href="w_chat.php" ]>
          <i class='bx bx-chat'></i>
          <span class="links_name">CHAT</span>
        </a>
      </li>
      <li>
        <a href="" class="active">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">MEMBER REPORT</span>
        </a>
      </li>
      <li>
        <a href="w_historyE.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">HISTORY</span>
        </a>
      </li>

      <li>
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

    <div class="search-box" style="max-width: 600px; margin: 0 auto; text-align: center;">
      <br />
      <br />
      <br />
      <br />
      <br />
      <div class="form-group" style="margin-bottom: 20px;">
        <div class="input-group" style="display: flex; justify-content: center;">
          <div class="search-box" style="width: 100%; max-width: 400px;">
            <input type="text" id="search_text" placeholder="Search..."
              style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); color: black;">
          </div>
        </div>
      </div>
      <br />
      <div id="result" style="text-align: left; font-size: 14px; color: #333;"></div>
    </div>
    <div style="clear: both;"></div>
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
      load_data(); // Load all members initially

      function load_data(query = '') {
        console.log("Search query: " + query); // Debugging: log the query being sent
        $.ajax({
          url: "w_fetch.php",
          method: "POST", // Ensure this is POST
          data: { query: query }, // Send the query
          success: function (data) {
            $('#result').html(data); // Display the result in the HTML element
          }
        });
      }

      $('#search_text').keyup(function () {
        const search = $(this).val(); // Get the input value
        console.log("Search input: " + search); // Debugging: log the input value
        load_data(search); // Pass the search value
      });
    });

  </script>

</body>

</html>