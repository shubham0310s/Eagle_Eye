<?php
// Set secure session parameters
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'localhost', // Replace with your actual domain
    'secure' => false,       // Set to true if using HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Start the session
session_start();

// Include database connection
include("society_dbE.php");

// Check if the user is logged in and a society is selected
if (!isset($_SESSION['a_society']) || empty($_SESSION['a_society'])) {
    echo "Please log in first.";
    exit;
}

// Fetch the society from the session
$society = $_SESSION['a_society'];

// Fetch member data securely
$query = "SELECT * FROM `member_table` WHERE `society_reg` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $society);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message']) && isset($_POST['receiver_id'])) {
    // Validate and sanitize inputs
    $message = trim($_POST['message']);
    $receiver_id = intval($_POST['receiver_id']);
    $receiver_role = $_POST['receiver_role'] ?? 'member'; // Receiver role from POST data
    $sender_id = $_SESSION['id'] ?? null; // Ensure `id` is stored in the session
    $sender_role = $_SESSION['role'] ?? 'member'; // Ensure `role` is stored in the session

    // Check if sender ID and role exist in the session
    if (!$sender_id || !$sender_role) {
        echo "Error: Invalid sender credentials.";
        exit;
    }

    // Ensure the message is not empty
    if (empty($message)) {
        echo "Message cannot be empty.";
        exit;
    }

    // Insert the message securely
    $query = "
        INSERT INTO messages (sender_id, receiver_id, message, sender_role, receiver_role) 
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisss", $sender_id, $receiver_id, $message, $sender_role, $receiver_role);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: Unable to send message.";
    }

    $stmt->close();
}
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
                <a href="a_dashboardE.php">
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
                <a href="a_chat.php" class="active">
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
                <span class="dashboard">CHAT</span>
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