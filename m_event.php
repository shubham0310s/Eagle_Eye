<?php
include("society_dbE.php");
include("visitor_db.php");
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
$v = mysqli_query($con, "SELECT * FROM `visitor_table`");
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
                <a href="m_dashboardE.php">
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
                <a href="m_event.php" class="active">
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
            <h2 style="text-align: center; color: #333; font-family: Arial, sans-serif;">Event Calendar</h2>
            <div class="calendar"
                style="max-width: 700px; margin: 20px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
                <div class="calendar-header"
                    style="background-color: #000000; color: #fff; text-align: center; padding: 15px; font-size: 1.5rem;">
                    <?php
                    $currentMonth = date('F');
                    $currentYear = date('Y');
                    echo "$currentMonth $currentYear";
                    ?>
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="background-color: #34a853; color: #fff; padding: 10px; text-align: center;">Sun
                            </th>
                            <th style="background-color: #34a853; color: #fff; padding: 10px; text-align: center;">Mon
                            </th>
                            <th style="background-color: #34a853; color: #fff; padding: 10px; text-align: center;">Tue
                            </th>
                            <th style="background-color: #34a853; color: #fff; padding: 10px; text-align: center;">Wed
                            </th>
                            <th style="background-color: #34a853; color: #fff; padding: 10px; text-align: center;">Thu
                            </th>
                            <th style="background-color: #34a853; color: #fff; padding: 10px; text-align: center;">Fri
                            </th>
                            <th style="background-color: #34a853; color: #fff; padding: 10px; text-align: center;">Sat
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                        $firstDayOfMonth = date('w', strtotime(date('Y-m-01')));
                        $day = 1;

                        for ($i = 0; $i < 6; $i++) {
                            echo "<tr>";
                            for ($j = 0; $j < 7; $j++) {
                                if ($i === 0 && $j < $firstDayOfMonth || $day > $daysInMonth) {
                                    echo "<td style='height: 80px; text-align: center; vertical-align: middle; border: 1px solid #ddd;'></td>";
                                } else {
                                    echo "<td class='date-cell' data-date='" . date('Y-m-') . $day . "' style='height: 80px; text-align: center; vertical-align: middle; border: 1px solid #ddd; cursor: pointer;'>
                                    <span class='event-day" . ($day === (int) date('j') ? " today" : "") . "' style='background-color: blue; color: white; border-radius: 50%; width: 40px; height: 40px; line-height: 40px; display: inline-block;'>$day</span>
                                  </td>";
                                    $day++;
                                }
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal-overlay"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); z-index: 1000;">
            </div>
            <div class="modal"
                style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; width: 400px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); z-index: 1001;">
                <h3 style="margin: 0 0 10px; font-size: 1.5rem; color: #333;">Event Details</h3>
                <p class="modal-content" style="font-size: 1rem; color: #555;">No events available.</p>
                <button class="close-btn"
                    style="display: block; text-align: center; margin-top: 20px; padding: 10px; background-color: #000000; color: white; border: none; border-radius: 5px; cursor: pointer;">Close</button>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const dateCells = document.querySelectorAll('.date-cell');
                    const modal = document.querySelector('.modal');
                    const overlay = document.querySelector('.modal-overlay');
                    const closeModal = document.querySelector('.close-btn');
                    const modalContent = document.querySelector('.modal-content');

                    dateCells.forEach(cell => {
                        cell.addEventListener('click', () => {
                            const selectedDate = cell.getAttribute('data-date');
                            fetch(`fetch_events.php?date=${selectedDate}`)
                                .then(response => response.json())
                                .then(data => {
                                    modalContent.innerHTML = data.length > 0
                                        ? data.map(event => `<p><strong>${event.title}</strong><br>${event.start}</p>`).join('')
                                        : '<p>No events available for this date.</p>';
                                    modal.style.display = 'block';
                                    overlay.style.display = 'block';
                                });
                        });
                    });

                    closeModal.addEventListener('click', () => {
                        modal.style.display = 'none';
                        overlay.style.display = 'none';
                    });
                });
            </script>
        </div>

        <div class="announcement-box"
            style="max-width: 500px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <h3 style="margin: 0 0 15px; font-size: 1.5rem; font-weight: 600; color: #333; text-align: center;">Upcoming
                Events</h3>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 1rem; color: #555;">
                <?php
                include("society_dbE.php"); // Include your database connection
                
                // Check if the society session is set
                if (isset($_SESSION["a_society"])) {
                    $society = $_SESSION["a_society"];
                } else {
                    $society = "0000"; // Default society if not set
                }

                // Fetch upcoming events from the events table for the specific society
                $query = "SELECT * FROM events WHERE society_reg = '{$society}' AND event_start >= NOW() ORDER BY event_start LIMIT 5";
                $result = mysqli_query($conn, $query);

                // Check if there are any events
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $eventTitle = htmlspecialchars($row['event_title']);
                        $eventDate = date('F j, Y, g:i A', strtotime($row['event_start'])); // Format the event date
                
                        // Display each event
                        echo "<li style='margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #fff;'>
                        <strong style='color: #007bff;'>{$eventTitle}</strong> <br> 
                        <span style='color: #777; font-size: 0.9rem;'>{$eventDate}</span>
                      </li>";
                    }
                } else {
                    echo "<li style='text-align: center; color: #999;'>No upcoming events.</li>";
                }
                ?>
            </ul>
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