<?php
include("society_dbE.php");
session_start();
if (!isset($_SESSION['a_logged_in'])) {
    header("Location: index.html");
    exit;
}

$society = isset($_SESSION["a_society"]) ? $_SESSION["a_society"] : "0000";
$aname = $_SESSION['a_name'] ?? "name";
$aemail = $_SESSION['a_email'] ?? "Email@gmail.com";

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_event"])) {
    $eventTitle = mysqli_real_escape_string($conn, $_POST["event_title"]);
    $eventStart = mysqli_real_escape_string($conn, $_POST["event_start"]);
    $eventEnd = mysqli_real_escape_string($conn, $_POST["event_end"]);

    $query = "INSERT INTO events (event_title, event_start, event_end, society_reg) 
              VALUES ('$eventTitle', '$eventStart', '$eventEnd', '$society')";

    if (mysqli_query($conn, $query)) {
        $_SESSION["event_success"] = "Event added successfully!";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_SESSION["event_success"])) {
    $successMessage = $_SESSION["event_success"];
    unset($_SESSION["event_success"]);
}

$query = "SELECT * FROM events WHERE society_reg = '{$society}' AND event_start >= NOW() ORDER BY event_start LIMIT 5";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="img/2.png" type="image/png">
    <link rel="stylesheet" href="css/dashE.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/style.css">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

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
                <a href="a_dashboardE.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">HOME</span>
                </a>
            </li>
            <li>
                <a href="a_event.php" class="active">
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
            <div class="sidebar-button"><i class='bx bx-menu sidebarBtn'></i><span class="dashboard">Event</span></div>
            <div class="action">
                <div class="profile" onclick="menuToggle();"><img src="images/host.png" alt=""></div>
                <div class="menu">
                    <h3>
                        <div id="eagleN"><b><?= $aname ?></b></div>
                        <div id="eagleR">Admin</div>
                        <div id="eagleG"><?= $aemail ?></div>
                        <div id="eagleG"><?= $society ?></div>
                    </h3>
                    <ul>
                        <li><a href="change_passE.php">Change Password</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" style="padding: 35px;"></div>
        <div class="container" style=" ; background-color: #fff; padding: 20px; border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success"
                    style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px;">
                    <?= $successMessage ?>
                </div>
            <?php endif; ?>

            <!-- Add Event Form-->
            <div class="card" style="margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px">
                <div class="card-header"
                    style="background-color: #007bff; color: #fff; padding: 15px; font-size: 1.25rem; font-weight: bold;">
                    Add New Event
                </div>
                <div class="card-body" style="padding: 20px;">
                    <form method="POST">
                        <label for="event_title" style="font-weight: bold; margin-bottom: 10px; display: block;">Event
                            Title</label>
                        <input type="text" id="event_title" name="event_title" required
                            style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">

                        <label for="event_start" style="font-weight: bold; margin-bottom: 10px; display: block;">Event
                            Start Date and Time</label>
                        <input type="datetime-local" id="event_start" name="event_start" required
                            style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">

                        <label for="event_end" style="font-weight: bold; margin-bottom: 10px; display: block;">Event End
                            Date and Time</label>
                        <input type="datetime-local" id="event_end" name="event_end" required
                            style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">

                        <button type="submit" name="add_event"
                            style="display: inline-block; padding: 10px 15px; color: #fff; background-color: #28a745; border: none; border-radius: 4px; font-size: 1rem; font-weight: bold; cursor: pointer;">Add
                            Event</button>
                    </form>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="card" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <div class="card-header"
                    style="background-color: #007bff; color: #fff; padding: 15px; font-size: 1.25rem; font-weight: bold;">
                    Upcoming Events
                </div>
                <div class="card-body" style="padding: 20px;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <li
                                style="padding: 10px 15px; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 4px; background-color: #f9f9f9; display: flex; justify-content: space-between; align-items: center;">
                                <strong style="color: #333;"><?= $row['event_title'] ?></strong>
                                <span
                                    style="font-size: 0.9rem; color: #6c757d;"><?= date('F j, Y, g:i A', strtotime($row['event_start'])) ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
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